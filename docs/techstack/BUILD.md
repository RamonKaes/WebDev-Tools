# Build Process – WebDev-Tools

**Production build with minification & optimization** – Bash script, Terser, csso/cssnano.

---

## Build Commands

```bash
# Production build (complete build process)
bash build.sh

# Only minify CSS (manual)
npm run build:css

# Deploy to server (rsync)
npm run deploy
```

---

## Build Script (`build.sh`)

Automated build process:

```bash
#!/bin/bash
set -e  # Exit on error

echo "🔨 Starting production build..."

# 1. Cleanup
rm -rf dist/
mkdir -p dist/

# 2. Copy PHP files & assets
rsync -av --exclude='node_modules' --exclude='tests' --exclude='dist' \
  --exclude='.git' --exclude='build-tools' \
  ./ dist/

# 3. Minify JavaScript
echo "📦 Minifying JavaScript..."
find dist/assets/js -name "*.js" ! -name "*.min.js" -type f | while read file; do
  terser "$file" -c -m -o "${file%.js}.min.js"
  rm "$file"  # Remove original
  mv "${file%.js}.min.js" "$file"  # Rename minified
done

# 4. Minify CSS
echo "🎨 Minifying CSS..."
csso dist/assets/css/style.css -o dist/assets/css/style.min.css
rm dist/assets/css/style.css
mv dist/assets/css/style.min.css dist/assets/css/style.css

# 5. Optimize images (optional)
# echo "🖼️  Optimizing images..."
# find dist/assets/img -type f -name "*.png" -exec optipng -o7 {} \;

# 6. Copy production .htaccess
cp .htaccess.production dist/.htaccess

# 7. Generate manifest & sitemaps
echo "📄 Generating manifest & sitemaps..."
php config/generate-manifest.php
php config/generate-sitemaps.php

echo "✅ Build complete! Output: dist/"
```

---

## Minification

### JavaScript (Terser)

**Config:** `package.json` → `terser` options

```bash
terser input.js \
  -c \                    # Compress
  -m \                    # Mangle (variable names)
  -o output.min.js
```

**Options:**
- `-c` (compress): Dead-code elimination, constant folding
- `-m` (mangle): Shortens variable names (except globals)
- `--keep-fnames`: Keep function names (for debugging)

**Excluded files:**
- `*.min.js` – Already minified
- `node_modules/**` – Dependencies

---

### CSS (csso / cssnano)

```bash
# Via csso (current)
csso assets/css/style.css -o dist/assets/css/style.min.css

# Alternative: cssnano (npm script)
npm run build:css
```

**Optimizations:**
- Removes whitespace & comments
- Combines identical rules
- Shortens color codes (`#ffffff` → `#fff`)
- Optimizes `calc()` expressions

---

### Sass Compilation

**Development:**

```bash
sass build-tools/bootstrap-custom.scss assets/css/bootstrap-custom.css
```

**Production (with compression):**

```bash
sass --style=compressed build-tools/bootstrap-custom.scss dist/assets/css/bootstrap-custom.css
```

---

## Deployment

### Rsync Deploy (`npm run deploy`)

```bash
rsync -avz --delete \
  dist/ \
  user@webdev-tools.info:/var/www/html/
```

**Flags:**
- `-a`: Archive mode (preserves permissions, timestamps)
- `-v`: Verbose
- `-z`: Compression during transfer
- `--delete`: Removes files on server that don't exist locally

**Security:**
- SSH key-based authentication
- `--dry-run` to test before actual deploy

---

## .htaccess Management

### Development vs. Production

**2 separate files:**

| File | Usage |
|------|-------|
| `.htaccess` | Local development (XAMPP, Docker) |
| `.htaccess.production` | Production server (copied during build) |

**Important:** When URLs change, update **both** files!

### Typical Rewrite Rules

```apache
RewriteEngine On

# Enforce trailing slash
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(.*)/$
RewriteRule ^(.*)$ /$1/ [R=301,L]

# 301 redirect on slug change
RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]

# Hide PHP extension
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php [L]

# Language version routing
RewriteRule ^de/(.*)$ de/$1 [L]
RewriteRule ^es/(.*)$ es/$1 [L]
```

---

## Asset Pipeline

### JavaScript Loading

**Development:**
```html
<script src="/assets/js/tools/myTool.js"></script>
```

**Production (minified):**
```html
<script src="/assets/js/tools/myTool.js"></script>
<!-- File is minified but keeps the same name -->
```

**Lazy Loading:**
- Tools are loaded only on invocation (via `tool-loader.js`)
- No bundling – each tool is a separate module

---

### CSS Loading

**Critical CSS:** Inline in `<head>` (layout, above-the-fold)

**Non-Critical CSS:** Asynchronously loaded:

```html
<link rel="preload" href="/assets/css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
```

---

## Cache Busting

### Via Query Parameter

```php
<?php
$version = '2.1.2'; // From package.json or config.php
?>
<link rel="stylesheet" href="/assets/css/style.css?v=<?= $version ?>">
<script src="/assets/js/app.js?v=<?= $version ?>"></script>
```

### Via .htaccess (Cache Headers)

```apache
<IfModule mod_expires.c>
  ExpiresActive On
  
  # CSS & JS: 1 year
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  
  # Images: 1 month
  ExpiresByType image/jpeg "access plus 1 month"
  ExpiresByType image/png "access plus 1 month"
  ExpiresByType image/webp "access plus 1 month"
  
  # HTML: No cache
  ExpiresByType text/html "access plus 0 seconds"
</IfModule>
```

---

## Performance Optimization

### Compression (gzip/brotli)

```apache
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript
  AddOutputFilterByType DEFLATE application/json application/xml
</IfModule>
```

### Preloading

```html
<!-- DNS prefetch for external resources -->
<link rel="dns-prefetch" href="//cdn.example.com">

<!-- Preconnect for critical connections -->
<link rel="preconnect" href="https://fonts.googleapis.com">

<!-- Preload for critical resources -->
<link rel="preload" href="/assets/js/tool-loader.js" as="script">
```

---

## Build Validation

### After build, check:

```bash
# Compare file sizes
du -sh assets/js/tools/ dist/assets/js/tools/

# Syntax check minified JS
node -c dist/assets/js/tools/myTool.js

# CSS validation
npx stylelint dist/assets/css/*.css

# .htaccess syntax (Apache)
apachectl configtest
```

---

## CI/CD (optional)

### GitHub Actions Workflow (Beispiel)

```yaml
name: Build & Deploy

on:
  push:
    branches: [main]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: actions/setup-node@v3
        with:
          node-version: '18'
      - run: npm ci
      - run: npm test
      - run: bash build.sh
      - name: Deploy
        run: |
          rsync -avz --delete dist/ ${{ secrets.DEPLOY_USER }}@${{ secrets.DEPLOY_HOST }}:/var/www/html/
```

---

## Troubleshooting

### Build schlägt fehl

```bash
# Terser-Fehler (Syntax-Error in JS)
# → Prüfe JS-Datei auf Syntax-Fehler:
node -c assets/js/tools/problematicTool.js

# csso-Fehler (Invalid CSS)
# → Validiere CSS:
npx stylelint assets/css/style.css

# Rsync-Fehler (Permission denied)
# → Prüfe SSH-Keys & Permissions:
ssh user@server 'ls -la /var/www/html/'
```

---

**Weitere Infos:**
- [TESTING.md](TESTING.md) – Tests vor Build ausführen
- [INTEGRATION.md](INTEGRATION.md) – Neues Tool → Build-Prozess
