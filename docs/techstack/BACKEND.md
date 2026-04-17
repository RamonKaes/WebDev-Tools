# Backend – WebDev-Tools

**PHP 8+ with strict_types** – Tool registry, i18n system, routing.

---

## PHP Standards

### Strict Types (Mandatory)

**Every PHP file** must start with `declare(strict_types=1);`:

```php
<?php
declare(strict_types=1);  // ← FIRST line after <?php

// Remaining code
```

**Why?**
- Prevents type coercion bugs
- Enforces strict parameter/return types
- Better IDE support

---

### XSS Protection

**ALWAYS** use `htmlspecialchars()` for user input output:

```php
// WRONG
echo $_GET['name'];

// CORRECT
echo htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');

// Helper function (config/helpers.php)
echo esc($_GET['name']);
```

---

## Tool Registry (`config/tools.php`)

Central configuration of all tools:

```php
return [
  'myToolName' => [
    'id' => 'myToolName',                    // camelCase, must match JS tool ID
    'slug' => 'my-tool-name',                // EN slug (default)
    'slugs' => [                             // Localized slugs
      'en' => 'my-tool-name',
      'de' => 'mein-tool-name',
      'es' => 'mi-herramienta',
      'pt' => 'minha-ferramenta',
      'fr' => 'mon-outil',
      'it' => 'mio-strumento'
    ],
    'category' => 'converters',              // encoders|formatters|generators|converters|references|stringtools|utilities
    'icon' => 'bi-gear',                     // Bootstrap Icon
    'jsModule' => 'tools/myToolNameTool.js', // JS file (relative to assets/js/)
    'jsLibraries' => [                       // Required utilities
      'clipboard-utils',
      'download-utils',
      'validators'
    ],
    'features' => [                          // Feature tags
      'drag-drop',
      'bulk-processing',
      'live-mode'
    ],
    'seoTemplate' => 'default',              // SEO template
    'hasFeaturesSection' => true             // Show features section?
  ]
];
```

### Categories

| Category | Examples |
|----------|----------|
| `encoders` | Base64, URL, HTML Entity, JWT, Punycode |
| `formatters` | JSON, Code Formatter |
| `generators` | UUID, Password, QR Code, Hash, Lorem Ipsum |
| `converters` | Data Converter, Px→Rem, Aspect Ratio |
| `references` | Character Reference, Emoji Reference |
| `stringtools` | String Escaper |
| `utilities` | Regex Tester, SRI Generator |

### Optional Keys

| Key | Description | Example |
|-----|-------------|---------|
| `externalLibraries` | External CDN libraries with SRI hash | `['url' => '...', 'integrity' => 'sha384-...', 'crossorigin' => 'anonymous']` |
| `hasAboutSection` | Show about section (default: `false`) | `true` (Character Reference) |

---

## Tool PHP Interface (`tool-name/index.php`)

Every tool page follows this pattern:

```php
<?php
declare(strict_types=1);
ob_start();  // ← Mandatory! Required by tool-base.php for HTML minification

// Tool configuration
$toolId = 'myToolName';                     // Must match tools.php key
$lang = 'en';                               // Language code
$featuresSectionTitle = 'Features';         // Features section heading
$resourcesSectionTitle = 'Useful Resources'; // Resources section heading

// Features list (simple array)
$features = [
    'Privacy-first: All operations run locally',
    'Drag & Drop file upload support',
    'Bulk processing for multiple files',
    'Live conversion mode'
];

// Resources (array of arrays)
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

// Load layout (renders the tool)
include __DIR__ . '/../partials/tool-base.php';
```

---

## i18n System

### Multi-language Strategy

**Important:** There is **NO** i18n library for PHP content!

**PHP content (hardcoded in each language version):**
- Features list (`$features`)
- Resources (`$usefulResources` - Title, Description)
- Additional Sections (`$additionalSections` - Title, Content)
- Page texts, headings (`$featuresSectionTitle`, etc.)

**JavaScript UI (JSON files `config/i18n/{lang}.json`):**
- Labels, Buttons, Placeholders (tool UI)
- Error messages in tool
- Tooltips, Hints
- Meta data (SEO: `meta_title`, `meta_description`)

**Why no PHP i18n?**
- ✅ Each language version is culturally adapted, not 1:1 translation
- ✅ Features & resources vary by target audience
- ✅ SEO-optimized texts per language (not machine translated)
- ✅ Simple workflow: Copy-paste → Translate
- ❌ i18n library would be overhead for static content

### Maintaining Language Versions

For each language exists a separate tool directory:

```
base64-encoder-decoder/index.php          # EN (default)
de/base64-kodierer-dekodierer/index.php   # DE
es/base64-encoder-decoder/index.php       # ES
pt/base64-encoder-decoder/index.php       # PT
fr/base64-encoder-decoder/index.php       # FR
it/base64-encoder-decoder/index.php       # IT
```

**Rule:** No automatic translation – each language version is manually maintained for cultural adaptations.

---

### PHP Translation Workflow

**Step-by-step:**

1. **EN version as base** (`tool-name/index.php`)
   ```php
   $features = [
       'Privacy-first: All operations run client-side',
       'No data transmission to servers'
   ];
   ```

2. **Copy & translate DE version** (`de/tool-name/index.php`)
   ```php
   $features = [
       'Datenschutz: Alle Operationen laufen client-seitig',
       'Keine Datenübertragung an Server'
   ];
   ```

3. **Other languages analogously**
   - ES: Spanish (European, not Latin American)
   - PT: Portuguese (European)
   - FR: French (European)
   - IT: Italian

**Checklist per language version:**
- [ ] `$featuresSectionTitle` translated
- [ ] All `$features` translated
- [ ] `$resourcesSectionTitle` translated
- [ ] All `$usefulResources` (Title + Description) translated
- [ ] `$additionalSections` (Title + Content) translated (if present)
- [ ] `$customNoticeContent` translated (if present)
- [ ] Relative path to `tool-base.php` correct (`../` for EN, `../../` for language folders)

**Tip:** Multi-cursor editing in VS Code for parallel translation of all languages.

---

## Language Handler (`config/language-handler.php`)

Automatic language detection:

```php
function detectLanguage(): string {
    // 1. Check URL path (/de/, /es/, etc.)
    // 2. Check Accept-Language header
    // 3. Fallback: 'en'
}

function getLanguageFromPath(): ?string {
    // Extracts language code from URL
}
```

---

## Routing (`.htaccess`)

### URL Rewrite Rules

When URLs change (new slug, renamed tool), update **both** files:

- `.htaccess` – Development
- `.htaccess.production` – Production

**Example (301 redirect):**

```apache
# Old slug → New slug
RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]

# Language version without trailing slash → with slash
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

**CSP:** No inline JavaScript outside IIFEs, no external scripts (except CDN fallbacks).

---

## Manifest & Sitemap Generation

### Execute after new tool:

```bash
php config/generate-manifest.php    # PWA Manifest
php config/generate-sitemaps.php    # XML sitemaps
```

### Manifest (`config/manifest.json`)

Generated from `tools.php` for all languages:

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

One sitemap per language + `sitemap.xml` (sitemap index).

---

## Configuration (`config/config.php`)

Global settings:

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

All with `declare(strict_types=1);` and consistent layout.

---

**More Information:**
- [FRONTEND.md](FRONTEND.md) – JavaScript integration
- [BUILD.md](BUILD.md) – Build process
- [INTEGRATION.md](INTEGRATION.md) – Adding a new tool
