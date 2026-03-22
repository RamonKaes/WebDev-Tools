#!/bin/bash
# Copilot Instructions v5.1 Compliance Check

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  Copilot Instructions v5.1 - Compliance Test               ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

VIOLATIONS=0
WARNINGS=0

# [PHP-ARCH] Tests
echo "🔷 [PHP-ARCH] Principal Backend Architect"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check PSR-12 (basic indicators)
echo "  Checking PSR-12 compliance..."
PSR_VIOLATIONS=0
# Check for mixed tabs/spaces
if find . -name "*.php" -not -path "*/vendor/*" -exec grep -l $'\t' {} \; | head -1 > /dev/null; then
  echo "  ⚠ Found tabs in PHP files (PSR-12 requires spaces)"
  PSR_VIOLATIONS=$((PSR_VIOLATIONS + 1))
fi
# Check for proper brace placement (rough check)
if grep -rn "^}" --include="*.php" config/ | head -3; then
  echo "  ✓ Closing braces on own lines (PSR-12)"
else
  echo "  ⚠ Check brace placement manually"
fi

echo ""

# [DESIGN] Tests
echo "🎨 [DESIGN] Principal UI/UX Engineer"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check for inline styles (CSP violation)
echo "  Checking for inline styles (style=\"...\")..."
INLINE_STYLES=$(grep -rn 'style="' --include="*.php" . | grep -v "<!-- " | wc -l)
if [ $INLINE_STYLES -gt 0 ]; then
  echo "  ✗ Found $INLINE_STYLES inline style attributes (CSP violation)"
  grep -rn 'style="' --include="*.php" . | grep -v "<!-- " | head -3
  VIOLATIONS=$((VIOLATIONS + 1))
else
  echo "  ✓ No inline styles found (CSP compliant)"
fi

# Check Bootstrap utility usage
echo "  Checking Bootstrap 5 utility classes..."
if grep -rq "class=\".*\(m-[0-5]\|p-[0-5]\|d-flex\|justify-\|col-\)" --include="*.php" partials/; then
  echo "  ✓ Bootstrap utilities detected (m-*, p-*, d-flex, etc.)"
else
  echo "  ⚠ Consider using more Bootstrap utilities"
  WARNINGS=$((WARNINGS + 1))
fi

# Check button states in CSS
echo "  Checking button states (hover, focus-visible, disabled)..."
if grep -q ":hover\|:focus-visible\|:disabled" assets/css/style.css; then
  echo "  ✓ Button states implemented in CSS"
else
  echo "  ✗ Missing button states in CSS"
  VIOLATIONS=$((VIOLATIONS + 1))
fi

echo ""

# [SEC-AUDIT] Tests
echo "🔐 [SEC-AUDIT] Lead Security Engineer"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check for htmlspecialchars usage
echo "  Checking XSS protection (htmlspecialchars)..."
UNESCAPED=$(grep -rn "echo.*\$" --include="*.php" . | grep -v htmlspecialchars | grep -v "// " | wc -l)
if [ $UNESCAPED -gt 5 ]; then
  echo "  ⚠ Found $UNESCAPED potential unescaped outputs"
  WARNINGS=$((WARNINGS + 1))
else
  echo "  ✓ Most outputs appear to be escaped"
fi

# Check CSP headers
echo "  Checking Content-Security-Policy..."
if grep -q "Content-Security-Policy" config/security-headers.php; then
  echo "  ✓ CSP headers configured"
else
  echo "  ✗ CSP headers missing"
  VIOLATIONS=$((VIOLATIONS + 1))
fi

# Check DOMPurify version
echo "  Checking DOMPurify (XSS client-side)..."
if grep -q "dompurify@3\.[0-9]" partials/common-scripts.php; then
  echo "  ✓ DOMPurify 3.x integrated"
else
  echo "  ⚠ DOMPurify version check required"
  WARNINGS=$((WARNINGS + 1))
fi

echo ""

# [SEO] Tests
echo "🔍 [SEO] Technical SEO Lead"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check semantic HTML hierarchy
echo "  Checking semantic HTML heading hierarchy..."
python3 << 'PYEOF'
import re
import sys

# Simple check for H1 before H2
php_files = ['index.php', 'about.php']
for file in php_files:
    try:
        with open(file, 'r') as f:
            content = f.read()
            h1_pos = content.find('<h1')
            h2_pos = content.find('<h2')
            if h2_pos > 0 and (h1_pos < 0 or h2_pos < h1_pos):
                print(f"  ⚠ {file}: H2 before H1 (semantic issue)")
                sys.exit(1)
    except FileNotFoundError:
        pass

print("  ✓ Heading hierarchy appears correct")
sys.exit(0)
PYEOF

if [ $? -ne 0 ]; then
  WARNINGS=$((WARNINGS + 1))
fi

# Check aspect-ratio for CLS
echo "  Checking aspect-ratio for Core Web Vitals (CLS)..."
if grep -q "aspect-ratio:" assets/css/style.css; then
  echo "  ✓ aspect-ratio used (prevents layout shift)"
else
  echo "  ⚠ Consider using aspect-ratio for images/icons"
  WARNINGS=$((WARNINGS + 1))
fi

echo ""

# [I18N-GLOT] Tests (CRITICAL)
echo "🌍 [I18N-GLOT] Principal Localization Architect"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check JavaScript hardcoded strings
echo "  Checking JavaScript for hardcoded strings..."
JS_HARDCODED=$(grep -rn "return.*['\"]" assets/js/lib/*.js assets/js/tools/*.js 2>/dev/null | \
  grep -v "window.i18n?.t\|//\|console\|data-\|getElementById\|querySelector" | \
  grep -E "(Invalid|Empty|Error|Required|Please|Must)" | wc -l)

if [ $JS_HARDCODED -gt 0 ]; then
  echo "  ✗ Found $JS_HARDCODED potential hardcoded strings in JavaScript"
  grep -rn "return.*['\"]" assets/js/lib/*.js 2>/dev/null | \
    grep -v "window.i18n?.t\|//\|console" | \
    grep -E "(Invalid|Empty|Error)" | head -3
  VIOLATIONS=$((VIOLATIONS + 1))
else
  echo "  ✓ No obvious hardcoded strings in JavaScript"
fi

# Check Intl API locale usage
echo "  Checking Intl API locale (must be dynamic)..."
if grep -rq "toLocaleString()" assets/js/**/*.js; then
  HARDCODED_LOCALE=$(grep -rn "toLocaleString('en-US')" assets/js/**/*.js | wc -l)
  if [ $HARDCODED_LOCALE -gt 0 ]; then
    echo "  ✗ Found hardcoded 'en-US' locale in toLocaleString()"
    VIOLATIONS=$((VIOLATIONS + 1))
  else
    echo "  ✓ Intl APIs use dynamic locale"
  fi
fi

# Check meta tags use i18n
echo "  Checking meta tags (must use i18n)..."
META_I18N=$(grep -rn "<meta.*content=" --include="*.php" partials/ | grep -v "<?php" | wc -l)
if [ $META_I18N -gt 0 ]; then
  echo "  ⚠ Found $META_I18N static meta tags (should use i18n)"
  WARNINGS=$((WARNINGS + 1))
else
  echo "  ✓ Meta tags appear to use i18n"
fi

echo ""

# [CONTENT-EDU] Tests
echo "📚 [CONTENT-EDU] Senior Technical Writer"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check for passive voice (rough heuristic)
echo "  Checking writing style (active voice preferred)..."
PASSIVE=$(grep -roh "\(wird\|werden\|wurde\|wurden\) [a-zäöüß]*" --include="*.php" . | wc -l)
if [ $PASSIVE -gt 20 ]; then
  echo "  ⚠ Found $PASSIVE potential passive constructions (prefer active)"
  WARNINGS=$((WARNINGS + 1))
else
  echo "  ✓ Writing appears mostly active voice"
fi

echo ""

# Final Summary
echo "╔════════════════════════════════════════════════════════════╗"
echo "║         COPILOT INSTRUCTIONS v5.1 COMPLIANCE               ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

if [ $VIOLATIONS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
  echo "  🎉 100% COMPLIANT"
  echo "  ✓ 0 Violations | ✓ 0 Warnings"
  exit 0
elif [ $VIOLATIONS -eq 0 ]; then
  echo "  ⚠️  MOSTLY COMPLIANT"
  echo "  ✓ 0 Violations | ⚠ $WARNINGS Warnings"
  exit 0
else
  echo "  ❌ NON-COMPLIANT"
  echo "  ✗ $VIOLATIONS Violations | ⚠ $WARNINGS Warnings"
  exit 1
fi
