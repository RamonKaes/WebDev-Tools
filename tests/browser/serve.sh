#!/usr/bin/env bash
# Serves dist/ through a private, unprivileged Apache, so the browser tests see
# the real .htaccess.production and the real mod_php instead of a dev server.
# Started by playwright.config.js. TLS is required: the production rules
# redirect everything else to HTTPS.

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${1:?usage: serve.sh <port>}"
RUN="$ROOT/test-results/apache"
MODULES=/usr/lib/apache2/modules

if [ ! -f "$ROOT/dist/index.php" ]; then
  echo "dist/ is missing - run bash build.sh first." >&2
  exit 1
fi

PHP_MODULE=$(find "$MODULES" -name 'libphp*.so' | head -n 1)
if [ -z "$PHP_MODULE" ]; then
  echo "mod_php is not installed (libapache2-mod-php)." >&2
  exit 1
fi

rm -rf "$RUN"
mkdir -p "$RUN"

openssl req -x509 -newkey rsa:2048 -nodes -days 2 -subj "/CN=webdev-tools.info" \
  -keyout "$RUN/key.pem" -out "$RUN/cert.pem" 2> /dev/null

{
  for module in authz_core authz_host dir mime rewrite headers setenvif expires filter deflate socache_shmcb ssl; do
    echo "LoadModule ${module}_module $MODULES/mod_${module}.so"
  done
  echo "LoadModule mpm_prefork_module $MODULES/mod_mpm_prefork.so"
  echo "LoadModule php_module $PHP_MODULE"
  cat <<EOF
ServerRoot "$RUN"
ServerName webdev-tools.info
Listen 127.0.0.1:$PORT https
PidFile "$RUN/httpd.pid"
DefaultRuntimeDir "$RUN"
ErrorLog "$RUN/error.log"
LogLevel warn
TypesConfig /etc/mime.types

SSLEngine on
SSLCertificateFile "$RUN/cert.pem"
SSLCertificateKeyFile "$RUN/key.pem"
SSLSessionCache "shmcb:$RUN/ssl-cache(512000)"

# The test fixture refuses every response without this header, so a test can
# never pass against the real site.
Header always set X-Browser-Test local

php_admin_flag display_errors on
php_admin_flag html_errors off
php_admin_value error_reporting 32767
php_admin_flag opcache.enable off

DocumentRoot "$ROOT/dist"
<Directory />
  AllowOverride None
  Require all denied
</Directory>
<Directory "$ROOT/dist">
  AllowOverride All
  Require all granted
  DirectoryIndex index.php index.html
</Directory>
<FilesMatch "\.php$">
  SetHandler application/x-httpd-php
</FilesMatch>
EOF
} > "$RUN/httpd.conf"

exec /usr/sbin/apache2 -f "$RUN/httpd.conf" -DFOREGROUND
