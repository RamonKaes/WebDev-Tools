# Build-Prozess – WebDev-Tools

**Production-Build mit Minification & Optimierung** – Bash-Script, Terser, csso/cssnano.

---

## Build-Befehle

```bash
# Production-Build (kompletter Build-Prozess)
bash build.sh

# Nur CSS minifizieren (manuell)
npm run build:css

# Deploy auf Server (rsync)
npm run deploy
```

---

## Build-Script (`build.sh`)

Automatisierter Build-Prozess:

```bash
#!/bin/bash
set -e  # Exit bei Fehler

echo "🔨 Starting production build..."

# 1. Cleanup
rm -rf dist/
mkdir -p dist/

# 2. Copy PHP-Files & Assets
rsync -av --exclude='node_modules' --exclude='tests' --exclude='dist' \
  --exclude='.git' --exclude='build-tools' \
  ./ dist/

# 3. Minify JavaScript
echo "📦 Minifying JavaScript..."
find dist/assets/js -name "*.js" ! -name "*.min.js" -type f | while read file; do
  terser "$file" -c -m -o "${file%.js}.min.js"
  rm "$file"  # Original entfernen
  mv "${file%.js}.min.js" "$file"  # Minified umbenennen
done

# 4. Minify CSS
echo "🎨 Minifying CSS..."
csso dist/assets/css/style.css -o dist/assets/css/style.min.css
rm dist/assets/css/style.css
mv dist/assets/css/style.min.css dist/assets/css/style.css

# 5. Optimize Images (optional)
# echo "🖼️  Optimizing images..."
# find dist/assets/img -type f -name "*.png" -exec optipng -o7 {} \;

# 6. Copy Production .htaccess
cp .htaccess.production dist/.htaccess

# 7. Generate Manifest & Sitemaps
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

**Optionen:**
- `-c` (compress): Dead-code elimination, constant folding
- `-m` (mangle): Verkürzt Variablennamen (außer globals)
- `--keep-fnames`: Function-Namen beibehalten (für Debugging)

**Excluded Files:**
- `*.min.js` – Bereits minifiziert
- `node_modules/**` – Dependencies

---

### CSS (csso / cssnano)

```bash
# Via csso (aktuell)
csso assets/css/style.css -o dist/assets/css/style.min.css

# Alternative: cssnano (npm script)
npm run build:css
```

**Optimierungen:**
- Entfernt Whitespace & Kommentare
- Kombiniert identische Regeln
- Verkürzt Farb-Codes (`#ffffff` → `#fff`)
- Optimiert `calc()` Expressions

---

### Sass Compilation

**Entwicklung:**

```bash
sass build-tools/bootstrap-custom.scss assets/css/bootstrap-custom.css
```

**Produktion (mit Kompression):**

```bash
sass --style=compressed build-tools/bootstrap-custom.scss dist/assets/css/bootstrap-custom.css
```

---

## Deployment

### Rsync-Deploy (`npm run deploy`)

```bash
rsync -avz --delete \
  dist/ \
  user@webdev-tools.info:/var/www/html/
```

**Flags:**
- `-a`: Archive-Modus (preserves permissions, timestamps)
- `-v`: Verbose
- `-z`: Kompression während Transfer
- `--delete`: Entfernt Dateien auf Server, die lokal nicht existieren

**Sicherheit:**
- SSH-Key-basierte Authentifizierung
- `--dry-run` zum Testen vor echtem Deploy

---

## .htaccess-Management

### Entwicklung vs. Produktion

**2 separate Dateien:**

| Datei | Verwendung |
|-------|------------|
| `.htaccess` | Lokale Entwicklung (XAMPP, Docker) |
| `.htaccess.production` | Production-Server (wird bei Build kopiert) |

**Wichtig:** Bei URL-Änderungen **beide** Dateien aktualisieren!

### Typische Rewrite-Rules

```apache
RewriteEngine On

# Trailing Slash erzwingen
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(.*)/$
RewriteRule ^(.*)$ /$1/ [R=301,L]

# 301-Redirect bei Slug-Änderung
RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]

# PHP-Extension verstecken
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php [L]

# Sprachversion-Routing
RewriteRule ^de/(.*)$ de/$1 [L]
RewriteRule ^es/(.*)$ es/$1 [L]
```

---

## Asset-Pipeline

### JavaScript-Loading

**Entwicklung:**
```html
<script src="/assets/js/tools/myTool.js"></script>
```

**Produktion (minified):**
```html
<script src="/assets/js/tools/myTool.js"></script>
<!-- Datei ist minifiziert, aber behält denselben Namen -->
```

**Lazy Loading:**
- Tools werden erst bei Aufruf geladen (via `tool-loader.js`)
- Kein Bundle – jedes Tool ist ein separates Modul

---

### CSS-Loading

**Critical CSS:** Inline im `<head>` (Layout, Above-the-Fold)

**Non-Critical CSS:** Asynchron geladen:

```html
<link rel="preload" href="/assets/css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
```

---

## Cache-Busting

### Via Query-Parameter

```php
<?php
$version = '2.0.0'; // Aus package.json oder config.php
?>
<link rel="stylesheet" href="/assets/css/style.css?v=<?= $version ?>">
<script src="/assets/js/app.js?v=<?= $version ?>"></script>
```

### Via .htaccess (Cache-Headers)

```apache
<IfModule mod_expires.c>
  ExpiresActive On
  
  # CSS & JS: 1 Jahr
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  
  # Images: 1 Monat
  ExpiresByType image/jpeg "access plus 1 month"
  ExpiresByType image/png "access plus 1 month"
  ExpiresByType image/webp "access plus 1 month"
  
  # HTML: Kein Cache
  ExpiresByType text/html "access plus 0 seconds"
</IfModule>
```

---

## Performance-Optimierung

### Compression (gzip/brotli)

```apache
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript
  AddOutputFilterByType DEFLATE application/json application/xml
</IfModule>
```

### Preloading

```html
<!-- DNS-Prefetch für externe Ressourcen -->
<link rel="dns-prefetch" href="//cdn.example.com">

<!-- Preconnect für kritische Verbindungen -->
<link rel="preconnect" href="https://fonts.googleapis.com">

<!-- Preload für kritische Ressourcen -->
<link rel="preload" href="/assets/js/tool-loader.js" as="script">
```

---

## Build-Validierung

### Nach Build prüfen:

```bash
# Dateigröße vergleichen
du -sh assets/js/tools/ dist/assets/js/tools/

# Syntax-Check minified JS
node -c dist/assets/js/tools/myTool.js

# CSS-Validierung
npx stylelint dist/assets/css/*.css

# .htaccess-Syntax (Apache)
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
