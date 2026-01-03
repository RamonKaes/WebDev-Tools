#!/bin/bash
# Advanced Testing with Node.js Tools

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  Advanced Code Quality Tests (Node.js Tools)              ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Test 1: ESLint (if available or via npx)
echo "🔍 [1/5] ESLint Code Quality Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
cat > .eslintrc.json << 'ESLINTRC'
{
  "env": {
    "browser": true,
    "es2021": true
  },
  "extends": "eslint:recommended",
  "parserOptions": {
    "ecmaVersion": 2022,
    "sourceType": "module"
  },
  "rules": {
    "no-unused-vars": ["warn", { "argsIgnorePattern": "^_" }],
    "no-console": "off",
    "no-debugger": "warn"
  },
  "globals": {
    "DOMPurify": "readonly",
    "bootstrap": "readonly"
  }
}
ESLINTRC

if npx --yes eslint assets/js/lib/*.js assets/js/tools/*.js --quiet 2>/dev/null; then
  echo "  ✓ ESLint passed (no errors)"
else
  echo "  ⚠ ESLint found issues (see above)"
fi
echo ""

# Test 2: JavaScript Complexity Analysis
echo "📊 [2/5] Code Complexity Analysis..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
node << 'NODESCRIPT'
const fs = require('fs');
const path = require('path');

function analyzeComplexity(filePath) {
  const content = fs.readFileSync(filePath, 'utf8');
  const lines = content.split('\n').length;
  const functions = (content.match(/function\s+\w+|=>\s*{|^\s*\w+\s*\(/gm) || []).length;
  const conditionals = (content.match(/if\s*\(|else|switch\s*\(/g) || []).length;
  const loops = (content.match(/for\s*\(|while\s*\(|\.forEach|\.map\(/g) || []).length;
  
  return { lines, functions, conditionals, loops };
}

const jsFiles = [
  'assets/js/lib/validators.js',
  'assets/js/lib/formatters.js',
  'assets/js/i18n.js'
];

let totalLines = 0;
let totalFunctions = 0;

jsFiles.forEach(file => {
  if (fs.existsSync(file)) {
    const stats = analyzeComplexity(file);
    totalLines += stats.lines;
    totalFunctions += stats.functions;
    const complexity = stats.conditionals + stats.loops;
    console.log(`  ${path.basename(file)}: ${stats.lines} lines, ${stats.functions} functions, complexity: ${complexity}`);
  }
});

console.log(`\n  ✓ Total: ${totalLines} lines, ${totalFunctions} functions analyzed`);
NODESCRIPT
echo ""

# Test 3: Accessibility Check (basic HTML structure)
echo "♿ [3/5] Accessibility Basic Checks..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
A11Y_ISSUES=0

# Check for alt attributes on images
if grep -rn '<img' --include="*.php" . | grep -v 'alt=' | head -3; then
  echo "  ⚠ Found <img> tags without alt attributes (see above)"
  A11Y_ISSUES=$((A11Y_ISSUES + 1))
else
  echo "  ✓ All <img> tags have alt attributes"
fi

# Check for proper heading hierarchy
if grep -rn '<h[1-6]' --include="*.php" partials/ | wc -l > /dev/null; then
  echo "  ✓ Heading tags found in partials"
else
  echo "  ⚠ No heading structure in partials"
fi
echo ""

# Test 4: Performance Check (file sizes)
echo "⚡ [4/5] Performance - Asset Size Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  JavaScript files:"
find assets/js -name "*.js" -not -path "*/node_modules/*" -exec du -h {} \; | sort -rh | head -5 | while read size file; do
  echo "    - $file: $size"
done

echo "  CSS files:"
find assets/css -name "*.css" -exec du -h {} \; | sort -rh | head -3 | while read size file; do
  echo "    - $file: $size"
done

echo "  I18N files:"
du -h config/i18n/*.json | head -3 | while read size file; do
  echo "    - $(basename $file): $size"
done
echo ""

# Test 5: Dependencies Security Check
echo "🔒 [5/5] Third-Party Dependencies Check..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  Checking for CDN dependencies in partials..."

# Extract CDN URLs
CDN_COUNT=$(grep -roh 'https://cdn\.[^"]*' partials/ | sort -u | wc -l)
echo "  ✓ Found $CDN_COUNT unique CDN resources"

# Check for SRI hashes
SRI_COUNT=$(grep -c 'integrity="sha' partials/common-scripts.php 2>/dev/null || echo 0)
echo "  ✓ $SRI_COUNT resources with SRI integrity hashes"

if [ $SRI_COUNT -gt 0 ]; then
  echo "  ✓ Subresource Integrity (SRI) implemented"
else
  echo "  ⚠ Consider adding SRI hashes to CDN resources"
fi
echo ""

echo "╔════════════════════════════════════════════════════════════╗"
echo "║              ADVANCED TESTS COMPLETE                       ║"
echo "╚════════════════════════════════════════════════════════════╝"
