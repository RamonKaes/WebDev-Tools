#!/usr/bin/env bash
# Upload dist/ to the web host via FTP(S) with lftp.
#
# Connection settings live in deploy.config (not in git, see deploy.config.example).
# The password is read from the system keyring, stored once with:
#   secret-tool store --label="WebDev-Tools FTP" service webdev-tools-ftp
#
# Usage: bash build-tools/deploy-ftp.sh [--dry-run] [--delete] [--allow-new]
#   --dry-run    only show what would be uploaded
#   --delete     also remove remote files that are not in dist/
#   --allow-new  upload files the server does not have yet (a new tool, say);
#                without it the deploy stops and lists them

set -euo pipefail
cd "$(dirname "$0")/.."

CONFIG_FILE="deploy.config"
KEYRING_SERVICE="webdev-tools-ftp"

DRY_RUN=""
DELETE=""
ALLOW_NEW=""
for arg in "$@"; do
  case "$arg" in
    --dry-run) DRY_RUN="--dry-run" ;;
    --delete)  DELETE="--delete" ;;
    --allow-new) ALLOW_NEW="yes" ;;
    *) echo "Unknown option: $arg" >&2; exit 1 ;;
  esac
done

bash build-tools/check-deploy.sh

if [ ! -f "$CONFIG_FILE" ]; then
  echo "❌ $CONFIG_FILE missing – copy deploy.config.example to $CONFIG_FILE and fill it in." >&2
  exit 1
fi
# shellcheck source=/dev/null
source "$CONFIG_FILE"
: "${FTP_HOST:?FTP_HOST not set in $CONFIG_FILE}"
: "${FTP_USER:?FTP_USER not set in $CONFIG_FILE}"
: "${FTP_REMOTE_DIR:?FTP_REMOTE_DIR not set in $CONFIG_FILE}"
FTP_TLS="${FTP_TLS:-yes}"

for cmd in lftp secret-tool; do
  command -v "$cmd" &> /dev/null || { echo "❌ $cmd is not installed." >&2; exit 1; }
done

# Passed via environment (lftp --env-password), never on the command line
if ! LFTP_PASSWORD=$(secret-tool lookup service "$KEYRING_SERVICE"); then
  echo "❌ No password in the keyring. Store it with:" >&2
  echo "   secret-tool store --label=\"WebDev-Tools FTP\" service $KEYRING_SERVICE" >&2
  exit 1
fi
export LFTP_PASSWORD

if [ "$FTP_TLS" = "yes" ]; then
  TLS_SETTINGS="set ftp:ssl-force true; set ftp:ssl-protect-data true; set ssl:verify-certificate yes;"
else
  echo "⚠ FTP_TLS=no: password and files are sent unencrypted."
  TLS_SETTINGS="set ftp:ssl-allow false;"
fi

mirror_dist() {
  lftp --env-password -u "$FTP_USER" "$FTP_HOST" -e "
    ${TLS_SETTINGS}
    set net:max-retries 2; set net:timeout 20; set net:reconnect-interval-base 5;
    mirror --reverse --verbose --parallel=4 $* dist/ '${FTP_REMOTE_DIR}';
    bye
  "
}

# The dry run prints lftp commands: "get -O" uploads a file the server does not
# have, "get -e -O" replaces one, "rm" removes one.
PREVIEW=$(mirror_dist --dry-run --delete)
NEW_FILES=$(sed -n 's#^get -O .* file:.*/dist/##p' <<< "$PREVIEW")
REMOTE_ONLY=$(sed -n 's#^rm ftp://[^/]*/##p' <<< "$PREVIEW")

if [ -n "$NEW_FILES" ]; then
  echo "New on the server:"
  sed 's/^/   + /' <<< "$NEW_FILES"
fi
if [ -n "$REMOTE_ONLY" ]; then
  if [ -n "$DELETE" ]; then echo "To be deleted from the server:"; else echo "Only on the server (kept, --delete removes them):"; fi
  sed 's/^/   - /' <<< "$REMOTE_ONLY"
fi

if [ -n "$DRY_RUN" ]; then
  echo "✅ Dry run done, nothing changed."
  exit 0
fi

if [ -n "$NEW_FILES" ] && [ -z "$ALLOW_NEW" ]; then
  echo "❌ Nothing uploaded. Check the new files above, then run again with --allow-new." >&2
  exit 1
fi

echo "🚀 Uploading dist/ to ${FTP_USER}@${FTP_HOST}:${FTP_REMOTE_DIR}"
# shellcheck disable=SC2086
mirror_dist $DELETE

echo "🔎 Checking production..."
if ! node build-tools/verify-prod.js; then
  echo "❌ The upload finished, but production has problems." >&2
  exit 1
fi
echo "✅ Done."
