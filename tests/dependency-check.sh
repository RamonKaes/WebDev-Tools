#!/bin/bash
# Dependency Security Check Script
# Überprüft CDN-Dependencies auf bekannte Vulnerabilities
# 
# Location: tests/dependency-check.sh
# Usage: ./tests/dependency-check.sh (from project root)
# Frequency: Vierteljährlich (vor jedem Release)

# Determine script directory and project root
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"

echo "=== Dependency Security Check ==="
echo "Datum: $(date '+%d.%m.%Y %H:%M')"
echo ""

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Bootstrap-Version aus head.php extrahieren
BOOTSTRAP_VERSION=$(grep -oP 'bootstrap@\K[0-9.]+' "$PROJECT_ROOT/partials/head.php" | head -1)
ICONS_VERSION=$(grep -oP 'bootstrap-icons@\K[0-9.]+' "$PROJECT_ROOT/partials/head.php" | head -1)

echo "Aktuelle Versionen:"
echo "  - Bootstrap: ${BOOTSTRAP_VERSION}"
echo "  - Bootstrap Icons: ${ICONS_VERSION}"
echo ""

# Funktion: GitHub Releases prüfen
check_github_release() {
    local repo=$1
    local current_version=$2
    local name=$3
    
    echo "Prüfe ${name}..."
    
    # Latest Release von GitHub holen
    latest_version=$(curl -s "https://api.github.com/repos/${repo}/releases/latest" | grep '"tag_name":' | sed -E 's/.*"v?([^"]+)".*/\1/')
    
    if [ -z "$latest_version" ]; then
        echo -e "${YELLOW}  ⚠ Konnte neueste Version nicht abrufen${NC}"
        return
    fi
    
    if [ "$current_version" == "$latest_version" ]; then
        echo -e "${GREEN}  ✓ Aktuelle Version ($current_version)${NC}"
    else
        echo -e "${YELLOW}  ⚠ Update verfügbar: $current_version → $latest_version${NC}"
    fi
}

# Funktion: CVE-Datenbank prüfen (via OSV.dev)
check_vulnerabilities() {
    local package=$1
    local version=$2
    local name=$3
    
    echo "Prüfe CVEs für ${name}..."
    
    # OSV.dev API Query
    query="{\"package\":{\"name\":\"${package}\",\"ecosystem\":\"npm\"},\"version\":\"${version}\"}"
    
    response=$(curl -s -X POST "https://api.osv.dev/v1/query" \
        -H "Content-Type: application/json" \
        -d "$query")
    
    # Prüfe ob Vulnerabilities gefunden wurden
    if echo "$response" | grep -q '"vulns"'; then
        vuln_count=$(echo "$response" | grep -o '"id"' | wc -l)
        echo -e "${RED}  ✗ ${vuln_count} Vulnerability/ies gefunden!${NC}"
        echo "$response" | grep -oP '"id":\s*"\K[^"]+' | while read cve; do
            echo -e "${RED}    - ${cve}${NC}"
        done
    else
        echo -e "${GREEN}  ✓ Keine bekannten CVEs${NC}"
    fi
    echo ""
}

# GitHub-Releases prüfen
check_github_release "twbs/bootstrap" "$BOOTSTRAP_VERSION" "Bootstrap"
check_github_release "twbs/icons" "$ICONS_VERSION" "Bootstrap Icons"
echo ""

# CVE-Datenbank prüfen
check_vulnerabilities "bootstrap" "$BOOTSTRAP_VERSION" "Bootstrap"
check_vulnerabilities "bootstrap-icons" "$ICONS_VERSION" "Bootstrap Icons"

# PHP-Version prüfen
echo "Prüfe PHP-Version..."
PHP_VERSION=$(php -r 'echo PHP_VERSION;')
PHP_MAJOR_MINOR=$(echo $PHP_VERSION | grep -oP '^\d+\.\d+')

# EOL-Daten für PHP-Versionen
case $PHP_MAJOR_MINOR in
    "8.1") PHP_EOL_DATE="2025-11-25" ;;
    "8.2") PHP_EOL_DATE="2026-12-08" ;;
    "8.3") PHP_EOL_DATE="2027-11-23" ;;
    "8.4") PHP_EOL_DATE="2028-11-23" ;;
    *) PHP_EOL_DATE="Unbekannt" ;;
esac

echo "  - Aktuelle Version: ${PHP_VERSION}"
echo "  - EOL-Datum (PHP ${PHP_MAJOR_MINOR}): ${PHP_EOL_DATE}"

if [ "$PHP_EOL_DATE" != "Unbekannt" ]; then
    # Berechne Tage bis EOL
    if EOL_TIMESTAMP=$(date -d "$PHP_EOL_DATE" +%s 2>/dev/null); then
        CURRENT_TIMESTAMP=$(date +%s)
        DAYS_UNTIL_EOL=$(( ($EOL_TIMESTAMP - $CURRENT_TIMESTAMP) / 86400 ))

        if [ $DAYS_UNTIL_EOL -lt 0 ]; then
            echo -e "${RED}  ✗ PHP-Version ist End-of-Life!${NC}"
        elif [ $DAYS_UNTIL_EOL -lt 180 ]; then
            echo -e "${YELLOW}  ⚠ PHP-Version erreicht EOL in ${DAYS_UNTIL_EOL} Tagen${NC}"
        else
            echo -e "${GREEN}  ✓ PHP-Version wird noch ${DAYS_UNTIL_EOL} Tage unterstützt${NC}"
        fi
    else
        echo -e "${YELLOW}  ⚠ Datumsberechnung fehlgeschlagen${NC}"
    fi
else
    echo -e "${YELLOW}  ⚠ EOL-Datum für PHP ${PHP_MAJOR_MINOR} unbekannt${NC}"
fi

echo ""
echo "=== Check abgeschlossen ==="
echo ""
echo "Dokumentation: SECURITY.md"
echo "Nächster Check empfohlen: $(date -d '+3 months' '+%B %Y')"
