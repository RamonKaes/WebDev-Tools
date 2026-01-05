#!/bin/bash

# WebDev-Tools Simple Build Script
# Copies files to dist/ and minifies CSS only
# No JavaScript bundling - individual files are used

set -e  # Exit on error

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_ROOT="$SCRIPT_DIR"
DIST_DIR="$PROJECT_ROOT/dist"
BUILD_HASH=$(date +%s | sha256sum | cut -c1-8)

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  🏗️  WebDev-Tools Simple Build (No Bundling)              ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
echo "📦 Build Hash: $BUILD_HASH"
echo "🎯 Target: $DIST_DIR"
echo ""

# ============================================
# 1. Clean & Setup
# ============================================
echo "🧹 Cleaning previous build..."
rm -rf "$DIST_DIR"
mkdir -p "$DIST_DIR"/{assets/{css,js,img,data,bootstrap},config/i18n,og,partials}

# ============================================
# 2. Copy PHP Files
# ============================================
echo "📋 Copying PHP files..."

# Root PHP files
cp *.php "$DIST_DIR/" 2>/dev/null || true
cp *.htm "$DIST_DIR/" 2>/dev/null || true
cp robots.txt "$DIST_DIR/" 2>/dev/null || true

# Copy production htaccess (not dev version!)
if [ -f ".htaccess.production" ]; then
  cp .htaccess.production "$DIST_DIR/.htaccess"
  echo "  ✓ Using .htaccess.production for build"
else
  cp .htaccess "$DIST_DIR/" 2>/dev/null || true
  echo "  ⚠ Using development .htaccess (production version not found)"
fi

# Generate fresh sitemaps
if [ -f "config/generate-sitemaps.php" ]; then
  echo "🗺️  Generating sitemaps..."
  php config/generate-sitemaps.php
fi

# Copy sitemaps
cp *.xml "$DIST_DIR/" 2>/dev/null || true

# Partials
cp -r partials "$DIST_DIR/"

# Config
cp -r config/*.php "$DIST_DIR/config/"
cp config/manifest.json "$DIST_DIR/config/"

# ============================================
# 3. Copy JavaScript (No bundling!)
# ============================================
echo "📦 Copying JavaScript files..."
cp -r assets/js "$DIST_DIR/assets/"

# ============================================
# 4. Copy & Minify CSS
# ============================================
echo "🎨 Processing CSS..."
mkdir -p "$DIST_DIR/assets/css"

if command -v csso &> /dev/null; then
  for css_file in assets/css/*.css; do
    filename=$(basename "$css_file")
    csso "$css_file" -o "$DIST_DIR/assets/css/$filename"
  done
  echo "  ✓ CSS minified with csso"
else
  cp -r assets/css/* "$DIST_DIR/assets/css/"
  echo "  ⚠ csso not installed, using original CSS"
fi

# ============================================
# 5. Copy Bootstrap
# ============================================
echo "📦 Copying Bootstrap..."
cp -r assets/bootstrap "$DIST_DIR/assets/"

# ============================================
# 6. Copy Static Assets
# ============================================
echo "🖼️  Copying static assets..."
cp -r assets/img "$DIST_DIR/assets/"
cp -r assets/data "$DIST_DIR/assets/"
cp -r assets/bootstrap-icons "$DIST_DIR/assets/" 2>/dev/null || true

# ============================================
# 7. Copy i18n
# ============================================
echo "🌍 Copying i18n files..."
cp -r config/i18n "$DIST_DIR/config/"

# ============================================
# 8. Copy Tool Directories
# ============================================
echo "🔧 Copying tool directories..."
for tool_dir in uuid-generator password-generator hash-generator base64-encoder-decoder \
                json-formatter-validator code-formatter data-converter url-encoder-decoder \
                html-entity-encoder-decoder jwt-decoder punycode-converter string-escaper \
                regex-tester px-to-rem-converter aspect-ratio-calculator lorem-ipsum \
                qr-code-generator character-reference emoji-reference; do
  [ -d "$tool_dir" ] && cp -r "$tool_dir" "$DIST_DIR/"
done

# Language directories
for lang_dir in de es fr it pt; do
  [ -d "$lang_dir" ] && cp -r "$lang_dir" "$DIST_DIR/"
done

# ============================================
# 9. Copy OG Images
# ============================================
echo "🖼️  Copying OG images..."
cp og/*.png "$DIST_DIR/og/" 2>/dev/null || echo "  ⚠ No OG images found"

# ============================================
# Done!
# ============================================
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ BUILD COMPLETE!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📝 Build Summary:"
echo "   No JavaScript bundling - all files loaded individually"
echo "   CSS minified (if csso available)"
echo "   All PHP, assets, and tools copied"
echo ""
echo "🚀 Deployment Ready:"
echo "   rsync -avz --delete dist/ user@webdev-tools.info:/var/www/html/"
echo ""
