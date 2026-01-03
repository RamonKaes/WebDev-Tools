#!/usr/bin/env bash
set -euo pipefail

# Start a PHP built-in server for local development (serves on http://127.0.0.1:8080)
# Uses dev/router.php so requests fall back to index.php when appropriate.

HOST=${HOST:-127.0.0.1}
PORT=${PORT:-8080}

echo "Starting PHP built-in server at http://${HOST}:${PORT} (docroot: project root)"

php -S ${HOST}:${PORT} -t . dev/router.php
