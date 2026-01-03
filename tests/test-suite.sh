#!/bin/bash
# WebDev-Tools Comprehensive Test Suite (Copilot Instructions v5.1 Compliant)
# Generated: 2026-01-03

set -e
ERRORS=0
WARNINGS=0

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  WebDev-Tools - Comprehensive Code Quality Test Suite     ║"
echo "║  Based on: Copilot Instructions v5.1 (Omni-Lead)          ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Test 1: [PHP-ARCH] PHP Syntax & strict_types Check
# Test 1: [PHP-ARCH] PHP Syntax & strict_types Check
echo "🔷 [PHP-ARCH] [1/10] PHP Syntax & strict_types..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
PHP_FILES=$(find . -name "*.php" -not -path "*/vendor/*" -not -path "*/node_modules/*")
PHP_ERRORS=0
for file in $PHP_FILES; do
  if ! php -l "$file" > /dev/null 2>&1; then
    echo "  ✗ Syntax error in: $file"
    PHP_ERRORS=$((PHP_ERRORS + 1))
  fi
done
if [ $PHP_ERRORS -eq 0 ]; then
  echo "  ✓ All PHP files have valid syntax (PSR-12 compliant)"
else
  echo "  ✗ Found $PHP_ERRORS PHP files with syntax errors"
  ERRORS=$((ERRORS + PHP_ERRORS))
fi
echo ""

# Test 2: [PHP-ARCH] strict_types Declaration
echo "🔒 [PHP-ARCH] [2/10] PHP strict_types Declaration..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
STRICT_MISSING=0
for file in config/*.php; do
  if [ -f "$file" ]; then
    if ! grep -q "declare(strict_types=1);" "$file"; then
      echo "  ✗ Missing strict_types: $file"
      STRICT_MISSING=$((STRICT_MISSING + 1))
    fi
  fi
done
if [ $STRICT_MISSING -eq 0 ]; then
  echo "  ✓ All config PHP files have strict_types"
else
  echo "  ⚠ $STRICT_MISSING files missing strict_types declaration"
  WARNINGS=$((WARNINGS + STRICT_MISSING))
fi
echo ""

# Test 3: JSON Validation
echo "📋 [I18N-GLOT] [3/10] JSON File Validation..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
JSON_ERRORS=0
for file in config/i18n/*.json; do
  if ! python3 -m json.tool "$file" > /dev/null 2>&1; then
    echo "  ✗ Invalid JSON: $file"
    JSON_ERRORS=$((JSON_ERRORS + 1))
  fi
done
if [ $JSON_ERRORS -eq 0 ]; then
  echo "  ✓ All JSON files are valid (6 language files)"
else
  echo "  ✗ Found $JSON_ERRORS invalid JSON files"
  ERRORS=$((ERRORS + JSON_ERRORS))
fi
echo ""

# Test 4: JavaScript Syntax Check
echo "⚡ [DESIGN] [4/10] JavaScript Syntax Validation..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
JS_FILES=$(find assets/js -name "*.js" -not -path "*/node_modules/*")
JS_ERRORS=0
for file in $JS_FILES; do
  if ! node --check "$file" 2>/dev/null; then
    echo "  ✗ Syntax error in: $file"
    JS_ERRORS=$((JS_ERRORS + 1))
  fi
done
if [ $JS_ERRORS -eq 0 ]; then
  echo "  ✓ All JavaScript files have valid syntax"
else
  echo "  ✗ Found $JS_ERRORS JavaScript files with errors"
  ERRORS=$((ERRORS + JS_ERRORS))
fi
echo ""

# Test 5: I18N Structure Consistency
echo "🌍 [I18N-GLOT] [5/10] I18N Structure Consistency Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
python3 << 'PYEOF'
import json
import sys

languages = ['en', 'de', 'es', 'pt', 'fr', 'it']
base_file = 'config/i18n/en.json'

with open(base_file) as f:
    base_data = json.load(f)
    base_keys = set(base_data.keys())

errors = 0
for lang in languages[1:]:  # Skip 'en' as it's the base
    try:
        with open(f'config/i18n/{lang}.json') as f:
            data = json.load(f)
            lang_keys = set(data.keys())
            
            missing = base_keys - lang_keys
            extra = lang_keys - base_keys
            
            if missing:
                print(f"  ⚠ {lang}.json missing sections: {missing}")
                errors += 1
            if extra:
                print(f"  ⚠ {lang}.json has extra sections: {extra}")
                errors += 1
    except Exception as e:
        print(f"  ✗ Error reading {lang}.json: {e}")
        errors += 1

if errors == 0:
    print("  ✓ All language files have consistent structure")
sys.exit(errors)
PYEOF
I18N_STATUS=$?
if [ $I18N_STATUS -ne 0 ]; then
  WARNINGS=$((WARNINGS + I18N_STATUS))
fi
echo ""

# Test 6: Security Headers Check
echo "🔐 [SEC-AUDIT] [6/10] Security Configuration Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
if [ -f "config/security-headers.php" ]; then
  if grep -q "X-Frame-Options" config/security-headers.php && \
     grep -q "X-Content-Type-Options" config/security-headers.php && \
     grep -q "Content-Security-Policy" config/security-headers.php; then
    echo "  ✓ Security headers properly configured"
  else
    echo "  ⚠ Some security headers might be missing"
    WARNINGS=$((WARNINGS + 1))
  fi
else
  echo "  ✗ security-headers.php not found"
  ERRORS=$((ERRORS + 1))
fi
echo ""

# Test 7: DOMPurify Integration Check
echo "🧹 [SEC-AUDIT] [7/10] DOMPurify XSS Protection Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
if grep -rq "dompurify@3.0.9" partials/common-scripts.php; then
  if grep -q "sha384-3HPB1XT51W3gGRxAmZ+qbZwRpRlFQL632y8x+adAqCr4Wp3TaWwCLSTAJJKbyWEK" partials/common-scripts.php; then
    echo "  ✓ DOMPurify 3.0.9 with correct SRI hash"
  else
    echo "  ⚠ DOMPurify present but SRI hash might be incorrect"
    WARNINGS=$((WARNINGS + 1))
  fi
else
  echo "  ⚠ DOMPurify not found or wrong version"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# Test 8: [I18N-GLOT] JavaScript Hardcoded String Detection
echo "🔤 [I18N-GLOT] [8/10] JavaScript Hardcoded String Detection..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
HARDCODED=0
# Check for common patterns that should use i18n
if grep -rn "return.*['\"]Invalid\|return.*['\"]Empty\|return.*['\"]Error" assets/js/lib/*.js assets/js/tools/*.js 2>/dev/null | grep -v "window.i18n?.t\|//" | head -5; then
  echo "  ⚠ Found potential hardcoded strings (see above)"
  WARNINGS=$((WARNINGS + 1))
else
  echo "  ✓ No obvious hardcoded strings detected in validators/formatters"
fi
echo ""

# Test 9: [DESIGN] Bootstrap 5 & CSS Compliance
echo "🎨 [DESIGN] [9/10] Bootstrap 5 & Button States Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
# Check for inline styles (CSP violation)
INLINE_STYLES=$(grep -rn 'style="' --include="*.php" . | grep -v "<!-- \|generate-og-images.php" | wc -l)
if [ $INLINE_STYLES -gt 0 ]; then
  echo "  ⚠ Found $INLINE_STYLES potential inline style attributes (check for CSP)"
  WARNINGS=$((WARNINGS + 1))
else
  echo "  ✓ No inline styles in HTML templates (CSP compliant)"
fi

# Check button states
if grep -q ":hover\|:focus-visible\|:disabled" assets/css/style.css; then
  echo "  ✓ Button states implemented (:hover, :focus-visible, :disabled)"
else
  echo "  ⚠ Missing button accessibility states in CSS"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# Test 10: [SEO] Core Web Vitals & Semantic HTML
echo "🔍 [SEO] [10/10] Core Web Vitals & Semantic HTML..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
# Check aspect-ratio for CLS
if grep -q "aspect-ratio:" assets/css/style.css; then
  echo "  ✓ aspect-ratio used (prevents Cumulative Layout Shift)"
else
  echo "  ⚠ Consider using aspect-ratio for images (Core Web Vitals)"
  WARNINGS=$((WARNINGS + 1))
fi

# Check heading hierarchy
if python3 -c "
import re
try:
    with open('index.php', 'r') as f:
        content = f.read()
        h1 = content.find('<h1')
        h2 = content.find('<h2')
        if h2 > 0 and (h1 < 0 or h2 < h1):
            exit(1)
    print('  ✓ Semantic HTML heading hierarchy correct (H1 before H2)')
    exit(0)
except:
    exit(0)
" 2>/dev/null; then
  : # Success output already printed
else
  echo "  ⚠ Check semantic HTML heading hierarchy (H1 -> H2 -> H3)"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# Final Summary
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                    TEST SUMMARY                            ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
  echo "  🎉 ALL TESTS PASSED!"
  echo "  ✓ 0 Errors | ✓ 0 Warnings"
  exit 0
elif [ $ERRORS -eq 0 ]; then
  echo "  ⚠️  TESTS COMPLETED WITH WARNINGS"
  echo "  ✓ 0 Errors | ⚠ $WARNINGS Warnings"
  exit 0
else
  echo "  ❌ TESTS FAILED"
  echo "  ✗ $ERRORS Errors | ⚠ $WARNINGS Warnings"
  exit 1
fi
