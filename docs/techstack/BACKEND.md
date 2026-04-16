# Backend – WebDev-Tools

**PHP 8+ mit strict_types** – Tool-Registry, i18n-System, Routing.

---

## PHP-Standards

### Strict Types (Pflicht)

**Jede PHP-Datei** muss mit `declare(strict_types=1);` beginnen:

```php
<?php
declare(strict_types=1);  // ← ERSTE Zeile nach <?php

// Restlicher Code
```

**Warum?**
- Verhindert Type-Coercion-Bugs
- Erzwingt strikte Parameter-/Return-Types
- Bessere IDE-Unterstützung

---

### XSS-Schutz

**IMMER** `htmlspecialchars()` für User-Input-Output:

```php
// FALSCH
echo $_GET['name'];

// RICHTIG
echo htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');

// Helper-Funktion (config/helpers.php)
echo esc($_GET['name']);
```

---

## Tool-Registry (`config/tools.php`)

Zentrale Konfiguration aller Tools:

```php
return [
  'myToolName' => [
    'id' => 'myToolName',                    // camelCase, muss Tool-ID in JS matchen
    'slug' => 'my-tool-name',                // EN-Slug (default)
    'slugs' => [                             // Lokalisierte Slugs
      'en' => 'my-tool-name',
      'de' => 'mein-tool-name',
      'es' => 'mi-herramienta',
      'pt' => 'minha-ferramenta',
      'fr' => 'mon-outil',
      'it' => 'mio-strumento'
    ],
    'category' => 'converters',              // encoders|formatters|generators|converters|references|stringtools|utilities
    'icon' => 'bi-gear',                     // Bootstrap Icon
    'jsModule' => 'tools/myToolNameTool.js', // JS-File (relativ zu assets/js/)
    'jsLibraries' => [                       // Benötigte Utilities
      'clipboard-utils',
      'download-utils',
      'validators'
    ],
    'features' => [                          // Feature-Tags
      'drag-drop',
      'bulk-processing',
      'live-mode'
    ],
    'seoTemplate' => 'default',              // SEO-Template
    'hasFeaturesSection' => true             // Features-Sektion anzeigen?
  ]
];
```

### Kategorien

| Kategorie | Beispiele |
|-----------|-----------|
| `encoders` | Base64, URL, HTML Entity, JWT, Punycode |
| `formatters` | JSON, Code Formatter |
| `generators` | UUID, Password, QR Code, Hash, Lorem Ipsum |
| `converters` | Data Converter, Px→Rem, Aspect Ratio |
| `references` | Character Reference, Emoji Reference |
| `stringtools` | String Escaper |
| `utilities` | Regex Tester |

### Optionale Keys

| Key | Beschreibung | Beispiel |
|-----|-------------|----------|
| `externalLibraries` | Externe CDN-Libraries mit SRI-Hash | `['url' => '...', 'integrity' => 'sha384-...', 'crossorigin' => 'anonymous']` |
| `hasAboutSection` | About-Sektion anzeigen (default: `false`) | `true` (Character Reference) |

---

## Tool-PHP-Interface (`tool-name/index.php`)

Jede Tool-Seite folgt diesem Pattern:

```php
<?php
declare(strict_types=1);
ob_start();  // ← Pflicht! Wird von tool-base.php für HTML-Minification benötigt

// Tool-Konfiguration
$toolId = 'myToolName';                     // Muss tools.php-Key matchen
$lang = 'en';                               // Sprachcode
$featuresSectionTitle = 'Features';         // Überschrift Features-Sektion
$resourcesSectionTitle = 'Useful Resources'; // Überschrift Ressourcen-Sektion

// Features-Liste (einfaches Array)
$features = [
    'Privacy-first: All operations run locally',
    'Drag & Drop file upload support',
    'Bulk processing for multiple files',
    'Live conversion mode'
];

// Ressourcen (Array of Arrays)
$usefulResources = [
    [
        'url' => 'https://example.com/docs',
        'title' => 'Official Documentation',
        'description' => 'Complete API reference and examples'
    ],
    [
        'url' => 'https://example.com/spec',
        'title' => 'Specification',
        'description' => 'RFC or standard specification'
    ]
];

// Optional: Additional Sections
$additionalSections = [
    [
        'title' => 'How It Works',
        'icon' => 'bi-info-circle',
        'content' => <<<HTML
<p>This tool performs the following steps:</p>
<ol>
    <li>Parse input data</li>
    <li>Apply transformation</li>
    <li>Return formatted result</li>
</ol>
HTML
    ]
];

// Optional: Custom Notice
// $customNoticeContent = 'Important: This tool requires JavaScript';
// $customNoticeType = 'warning'; // 'info' | 'warning' | 'success'

// Layout laden (rendert das Tool)
include __DIR__ . '/../partials/tool-base.php';
```

---

## i18n-System

### Mehrsprachigkeit-Strategie

**Wichtig:** Es gibt **KEINE** i18n-Library für PHP-Content!

**PHP-Content (hardcoded in jeder Sprachversion):**
- Features-Liste (`$features`)
- Ressourcen (`$usefulResources` - Title, Description)
- Additional Sections (`$additionalSections` - Title, Content)
- Seitentexte, Überschriften (`$featuresSectionTitle`, etc.)

**JavaScript-UI (JSON-Dateien `config/i18n/{lang}.json`):**
- Labels, Buttons, Placeholders (Tool-UI)
- Fehlermeldungen im Tool
- Tooltips, Hints
- Meta-Daten (SEO: `meta_title`, `meta_description`)

**Warum kein PHP-i18n?**
- ✅ Jede Sprachversion ist kulturell angepasst, keine 1:1-Übersetzung
- ✅ Features & Ressourcen variieren je nach Zielgruppe
- ✅ SEO-optimierte Texte pro Sprache (nicht maschinell übersetzt)
- ✅ Einfacher Workflow: Copy-Paste → Übersetzen
- ❌ i18n-Library wäre Overhead für statische Inhalte

### Sprachversionen pflegen

Für jede Sprache existiert ein separates Tool-Directory:

```
base64-encoder-decoder/index.php          # EN (default)
de/base64-kodierer-dekodierer/index.php   # DE
es/base64-encoder-decoder/index.php       # ES
pt/base64-encoder-decoder/index.php       # PT
fr/base64-encoder-decoder/index.php       # FR
it/base64-encoder-decoder/index.php       # IT
```

**Regel:** Keine automatische Übersetzung – jede Sprachversion wird manuell gepflegt für kulturelle Anpassungen.

---

### PHP-Übersetzungs-Workflow

**Schritt-für-Schritt:**

1. **EN-Version als Basis** (`tool-name/index.php`)
   ```php
   $features = [
       'Privacy-first: All operations run client-side',
       'No data transmission to servers'
   ];
   ```

2. **DE-Version kopieren & übersetzen** (`de/tool-name/index.php`)
   ```php
   $features = [
       'Datenschutz: Alle Operationen laufen client-seitig',
       'Keine Datenübertragung an Server'
   ];
   ```

3. **Weitere Sprachen analog**
   - ES: Spanisch (europäisch, nicht lateinamerikanisch)
   - PT: Portugiesisch (brasilianisch bevorzugt)
   - FR: Französisch (europäisch)
   - IT: Italienisch

**Checkliste pro Sprachversion:**
- [ ] `$featuresSectionTitle` übersetzt
- [ ] Alle `$features` übersetzt
- [ ] `$resourcesSectionTitle` übersetzt
- [ ] Alle `$usefulResources` (Title + Description) übersetzt
- [ ] `$additionalSections` (Title + Content) übersetzt (falls vorhanden)
- [ ] `$customNoticeContent` übersetzt (falls vorhanden)
- [ ] Relative Pfad zu `tool-base.php` korrekt (`../` für EN, `../../` für Sprach-Ordner)

**Tipp:** Multi-Cursor-Editing in VS Code für paralleles Übersetzen aller Sprachen.

---

## Language Handler (`config/language-handler.php`)

Automatische Spracherkennung:

```php
function detectLanguage(): string {
    // 1. Check URL path (/de/, /es/, etc.)
    // 2. Check Accept-Language header
    // 3. Fallback: 'en'
}

function getLanguageFromPath(): ?string {
    // Extrahiert Sprachcode aus URL
}
```

---

## Routing (`.htaccess`)

### URL-Rewrite-Rules

Bei URL-Änderungen (neuer Slug, umbenanntes Tool) **beide** Dateien aktualisieren:

- `.htaccess` – Entwicklung
- `.htaccess.production` – Produktion

**Beispiel (301-Redirect):**

```apache
# Alter Slug → Neuer Slug
RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]

# Sprachversion ohne Trailing Slash → mit Slash
RewriteRule ^de/tool-name$ /de/tool-name/ [R=301,L]
```

---

## Security Headers (`config/security-headers.php`)

```php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: strict-origin-when-cross-origin");
```

**CSP:** Kein Inline-JavaScript außerhalb IIFEs, keine externen Scripts (außer CDN-Fallbacks).

---

## Manifest & Sitemap Generation

### Nach neuem Tool ausführen:

```bash
php config/generate-manifest.php    # PWA Manifest
php config/generate-sitemaps.php    # XML-Sitemaps
```

### Manifest (`config/manifest.json`)

Generiert aus `tools.php` für alle Sprachen:

```json
{
  "name": "WebDev-Tools",
  "short_name": "DevTools",
  "icons": [...],
  "shortcuts": [
    {
      "name": "UUID Generator",
      "url": "/uuid-generator/",
      "icons": [...]
    }
  ]
}
```

### Sitemaps (`sitemap-{lang}.xml`)

Eine Sitemap pro Sprache + `sitemap.xml` (Sitemap-Index).

---

## Konfiguration (`config/config.php`)

Globale Settings:

```php
return [
    'site_name' => 'WebDev-Tools',
    'base_url' => 'https://webdev-tools.info',
    'default_lang' => 'en',
    'supported_langs' => ['en', 'de', 'es', 'pt', 'fr', 'it'],
    'tools_path' => __DIR__ . '/../config/tools.php'
];
```

---

## Helper Functions (`config/helpers.php`)

```php
function esc(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function loadTools(): array {
    return require __DIR__ . '/tools.php';
}

function getToolById(string $id): ?array {
    $tools = loadTools();
    return $tools[$id] ?? null;
}
```

---

## Error Pages

- `404.php` – Not Found
- `403.php` – Forbidden
- `500.php` – Internal Server Error

Alle mit `declare(strict_types=1);` und konsistentem Layout.

---

**Weitere Infos:**
- [FRONTEND.md](FRONTEND.md) – JavaScript-Integration
- [BUILD.md](BUILD.md) – Build-Prozess
- [INTEGRATION.md](INTEGRATION.md) – Neues Tool hinzufügen
