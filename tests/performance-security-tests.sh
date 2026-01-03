#!/bin/bash
# Enhanced Performance & Security Test Suite

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  Performance & Security Deep-Dive Tests                   ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

VIOLATIONS=0
WARNINGS=0

# ============================================================
# PERFORMANCE TESTS
# ============================================================

echo "⚡ PERFORMANCE TESTS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Test 1: GZIP/Compression Check
echo "📦 [1/8] GZIP Compression Configuration..."
if [ -f ".htaccess" ]; then
  if grep -q "mod_deflate\|AddOutputFilterByType.*DEFLATE" .htaccess; then
    echo "  ✓ GZIP compression configured in .htaccess"
  else
    echo "  ⚠ GZIP compression not found in .htaccess"
    echo "    Recommendation: Add mod_deflate for JSON, JS, CSS, HTML"
    WARNINGS=$((WARNINGS + 1))
  fi
else
  echo "  ⚠ No .htaccess found (consider adding for Apache)"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# Test 2: Cache Headers Check
echo "💾 [2/8] Cache Headers Configuration..."
CACHE_HEADERS=$(grep -r "Cache-Control\|Expires\|max-age" config/security-headers.php 2>/dev/null | wc -l)
if [ $CACHE_HEADERS -gt 0 ]; then
  echo "  ✓ Cache headers configured"
else
  echo "  ⚠ No cache headers detected (check security-headers.php)"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# Test 3: Image Optimization Check
echo "🖼️  [3/8] Image Optimization Analysis..."
if [ -d "assets/img" ]; then
  LARGE_IMAGES=$(find assets/img -type f \( -name "*.png" -o -name "*.jpg" -o -name "*.jpeg" \) -size +500k | wc -l)
  if [ $LARGE_IMAGES -eq 0 ]; then
    echo "  ✓ No large images found (all < 500KB)"
  else
    echo "  ⚠ Found $LARGE_IMAGES images > 500KB"
    find assets/img -type f \( -name "*.png" -o -name "*.jpg" \) -size +500k -exec ls -lh {} \; | head -3
    WARNINGS=$((WARNINGS + 1))
  fi
  
  # Check for WebP alternatives
  PNG_COUNT=$(find assets/img -name "*.png" | wc -l)
  WEBP_COUNT=$(find assets/img -name "*.webp" | wc -l)
  if [ $PNG_COUNT -gt 0 ] && [ $WEBP_COUNT -eq 0 ]; then
    echo "  ⚠ Consider WebP format for better compression ($PNG_COUNT PNG files)"
    WARNINGS=$((WARNINGS + 1))
  fi
fi
echo ""

# Test 4: Minification Check
echo "🗜️  [4/8] Asset Minification Status..."
MINIFIED_JS=$(find assets/js -name "*.min.js" | wc -l)
TOTAL_JS=$(find assets/js -name "*.js" -not -name "*.min.js" | wc -l)
if [ $MINIFIED_JS -gt 0 ]; then
  echo "  ✓ Minified JavaScript files detected ($MINIFIED_JS files)"
else
  echo "  ⚠ No minified JS found (consider build process for production)"
  echo "    Total JS files: $TOTAL_JS (can be reduced ~30% with minification)"
  WARNINGS=$((WARNINGS + 1))
fi
echo ""

# ============================================================
# SECURITY TESTS
# ============================================================

echo "🔐 SECURITY TESTS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Test 5: Cookie Security
echo "🍪 [5/8] Cookie Security Flags..."
if grep -rq "setcookie\|Set-Cookie" config/*.php 2>/dev/null; then
  # Check for HttpOnly flag
  if grep -rq "httponly.*true\|HttpOnly" config/*.php; then
    echo "  ✓ HttpOnly flag detected"
  else
    echo "  ⚠ HttpOnly flag not found in cookies"
    WARNINGS=$((WARNINGS + 1))
  fi
  
  # Check for Secure flag
  if grep -rq "secure.*true\|Secure" config/*.php; then
    echo "  ✓ Secure flag detected"
  else
    echo "  ⚠ Secure flag not found (required for HTTPS)"
    WARNINGS=$((WARNINGS + 1))
  fi
  
  # Check for SameSite
  if grep -rq "samesite\|SameSite" config/*.php; then
    echo "  ✓ SameSite attribute detected"
  else
    echo "  ⚠ SameSite attribute not found (CSRF protection)"
    WARNINGS=$((WARNINGS + 1))
  fi
else
  echo "  ℹ No cookies detected (stateless application)"
fi
echo ""

# Test 6: Input Validation Patterns
echo "🛡️  [6/8] Input Validation & Sanitization..."
# Check for common validation functions
VALIDATION_COUNT=$(grep -rn "filter_var\|preg_match\|validate" config/*.php | wc -l)
if [ $VALIDATION_COUNT -gt 0 ]; then
  echo "  ✓ Input validation functions detected ($VALIDATION_COUNT instances)"
else
  echo "  ⚠ No obvious input validation detected"
  WARNINGS=$((WARNINGS + 1))
fi

# Check JavaScript validators
JS_VALIDATORS=$(find assets/js/lib -name "validators.js" -o -name "validation.js" | wc -l)
if [ $JS_VALIDATORS -gt 0 ]; then
  echo "  ✓ Client-side validators present"
else
  echo "  ⚠ No client-side validation library found"
fi
echo ""

# Test 7: Sensitive Data Exposure
echo "🔍 [7/8] Sensitive Data Exposure Check..."
SENSITIVE_FOUND=0

# Check for hardcoded passwords/keys
if grep -rn "password.*=.*['\"][^'\"]*['\"]" --include="*.php" config/ | grep -v "// \|validation\|validator" | head -3; then
  echo "  ⚠ Potential hardcoded credentials found"
  WARNINGS=$((WARNINGS + 1))
  SENSITIVE_FOUND=1
fi

# Check for API keys in config
if grep -rn "api[_-]?key\|secret" --include="*.php" config/ | grep -v "// \|@param" | head -3; then
  echo "  ⚠ Potential API keys in code"
  WARNINGS=$((WARNINGS + 1))
  SENSITIVE_FOUND=1
fi

if [ $SENSITIVE_FOUND -eq 0 ]; then
  echo "  ✓ No obvious sensitive data exposure"
fi
echo ""

# Test 8: Security Headers Deep Check
echo "🔒 [8/8] Advanced Security Headers..."
if [ -f "config/security-headers.php" ]; then
  # Check for Referrer-Policy
  if grep -q "Referrer-Policy" config/security-headers.php; then
    echo "  ✓ Referrer-Policy configured"
  else
    echo "  ⚠ Referrer-Policy missing (privacy protection)"
    WARNINGS=$((WARNINGS + 1))
  fi
  
  # Check for Permissions-Policy
  if grep -q "Permissions-Policy\|Feature-Policy" config/security-headers.php; then
    echo "  ✓ Permissions-Policy configured"
  else
    echo "  ⚠ Permissions-Policy missing (feature access control)"
    WARNINGS=$((WARNINGS + 1))
  fi
  
  # Check CSP directives
  if grep -q "script-src.*nonce\|script-src.*'strict-dynamic'" config/security-headers.php; then
    echo "  ✓ CSP with nonce/strict-dynamic (best practice)"
  else
    echo "  ⚠ CSP might not use nonce-based approach"
    WARNINGS=$((WARNINGS + 1))
  fi
fi
echo ""

# Final Summary
echo "╔════════════════════════════════════════════════════════════╗"
echo "║         PERFORMANCE & SECURITY TEST SUMMARY               ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

if [ $VIOLATIONS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
  echo "  🎉 ALL TESTS PASSED!"
  echo "  ✓ 0 Violations | ✓ 0 Warnings"
  exit 0
elif [ $VIOLATIONS -eq 0 ]; then
  echo "  ⚠️  TESTS COMPLETED WITH WARNINGS"
  echo "  ✓ 0 Violations | ⚠ $WARNINGS Warnings"
  echo ""
  echo "  💡 Recommendations for production:"
  echo "    • Enable GZIP compression (80% size reduction)"
  echo "    • Implement cache headers (immutable for versioned assets)"
  echo "    • Minify JS/CSS (30% size reduction)"
  echo "    • Convert PNG → WebP (25-35% size reduction)"
  exit 0
else
  echo "  ❌ TESTS FAILED"
  echo "  ✗ $VIOLATIONS Violations | ⚠ $WARNINGS Warnings"
  exit 1
fi
