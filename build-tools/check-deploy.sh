#!/usr/bin/env bash
# Refuses a deploy unless dist/ is a fresh build of what is on origin/main and
# holds nothing that should stay local. Run by deploy-ftp.sh, needs no credentials.

set -euo pipefail
cd "${1:-$(dirname "$0")/..}"

problems=()

branch=$(git rev-parse --abbrev-ref HEAD)
[ "$branch" = "main" ] || problems+=("On branch '$branch', deploys come from main.")

[ -z "$(git status --porcelain)" ] || problems+=("The working tree has uncommitted changes.")

head=$(git rev-parse HEAD)
if ! git fetch --quiet origin main; then
  problems+=("Could not fetch origin/main.")
elif [ "$head" != "$(git rev-parse origin/main)" ]; then
  problems+=("HEAD is not origin/main, run git pull or push first.")
fi

if [ ! -f dist/index.php ]; then
  problems+=("dist/ is missing or incomplete, run bash build.sh.")
else
  # build.sh records the commit it built, so an old dist/ cannot go out
  built=$(cat .build-commit 2> /dev/null || echo none)
  [ "$built" = "$head" ] || problems+=("dist/ was built from '$built', not from HEAD ($head), run bash build.sh.")

  while IFS= read -r file; do
    problems+=("Backup or temporary file in the build: $file")
  done < <(find dist -type f \( -name '*.backup' -o -name '*.bak' -o -name '*.orig' -o -name '*.old' \
    -o -name '*.swp' -o -name '*~' -o -name '*.log' -o -name '*.sql' -o -name '.env*' -o -name '.DS_Store' \))

  # A file copied from the checkout that git does not know is a local leftover.
  # Generated files have no counterpart outside dist/ or are tracked.
  while IFS= read -r file; do
    source_file="${file#dist/}"
    if [ -e "$source_file" ] && ! git ls-files --error-unmatch -- "$source_file" > /dev/null 2>&1; then
      problems+=("Not in git, but in the build: $source_file")
    fi
  done < <(find dist -type f)
fi

if [ ${#problems[@]} -gt 0 ]; then
  echo "❌ Deploy refused:" >&2
  printf '   - %s\n' "${problems[@]}" >&2
  exit 1
fi

echo "✓ dist/ is a clean build of origin/main (${head:0:7})"
