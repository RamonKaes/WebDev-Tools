#!/bin/bash
# Verify Tool Completeness - Check Sitemaps vs Actual Directories
# Usage: ./bin/verify-tools.sh

set -euo pipefail

BASE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$BASE_DIR"

echo "╔════════════════════════════════════════════════════════════╗"
echo "║      WebDev-Tools — Tool Completeness Verification        ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

TOTAL_MISSING=0

# Function to check if directory exists for URL
check_tool_exists() {
    local url="$1"
    local lang="$2"
    
    # Remove trailing slash
    url="${url%/}"
    
    # Skip non-tool URLs
    if [[ "$url" == *".php" ]] || [[ "$url" == "" ]]; then
        return 0
    fi
    
    # Construct expected directory path
    local expected_dir
    if [[ "$lang" == "en" ]]; then
        expected_dir="${BASE_DIR}/${url}"
    else
        expected_dir="${BASE_DIR}/${url}"
    fi
    
    # Check if directory exists and has index.php
    if [[ -d "$expected_dir" ]] && [[ -f "$expected_dir/index.php" ]]; then
        echo -e "  ${GREEN}✓${NC} $url"
        return 0
    else
        echo -e "  ${RED}✗${NC} $url ${YELLOW}(Missing: $expected_dir)${NC}"
        TOTAL_MISSING=$((TOTAL_MISSING + 1))
        return 1
    fi
}

# Check English Tools
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 English Tools (sitemap-en.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "sitemap-en.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "en"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' sitemap-en.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ sitemap-en.xml not found${NC}"
fi

# Check German Tools
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 German Tools (de/sitemap.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "de/sitemap.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "de"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' de/sitemap.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ de/sitemap.xml not found${NC}"
fi

# Check Spanish Tools
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 Spanish Tools (es/sitemap.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "es/sitemap.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "es"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' es/sitemap.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ es/sitemap.xml not found${NC}"
fi

# Check Portuguese Tools
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 Portuguese Tools (pt/sitemap.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "pt/sitemap.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "pt"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' pt/sitemap.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ pt/sitemap.xml not found${NC}"
fi

# Check French Tools
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 French Tools (fr/sitemap.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "fr/sitemap.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "fr"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' fr/sitemap.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ fr/sitemap.xml not found${NC}"
fi

# Check Italian Tools
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 Italian Tools (it/sitemap.xml)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ -f "it/sitemap.xml" ]]; then
    while IFS= read -r url; do
        check_tool_exists "$url" "it"
    done < <(grep -oP '<loc>https://webdev-tools\.info/\K[^<]*' it/sitemap.xml | grep -v '\.php$' | grep -v '^$')
else
    echo -e "${RED}✗ it/sitemap.xml not found${NC}"
fi

# Summary
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 Summary"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [[ $TOTAL_MISSING -eq 0 ]]; then
    echo -e "${GREEN}✓ All tools from sitemaps exist!${NC}"
    exit 0
else
    echo -e "${RED}✗ Total missing tools: $TOTAL_MISSING${NC}"
    echo ""
    echo "Action required:"
    echo "  1. Create missing directories and index.php files"
    echo "  2. Copy from existing language versions as templates"
    echo "  3. Update i18n translations"
    echo "  4. Re-run this script to verify"
    exit 1
fi
