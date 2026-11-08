# Backend – WebDev-Tools

**PHP 8 with strict_types** – Tool registry, i18n, templating, security headers. The server renders pages; it never processes user data.

---

## PHP Standards

- `declare(strict_types=1);` is the first statement of **every** PHP file
- Every output of user-controlled or translated data goes through `htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`; there is no shorter helper
- CLI-only scripts (`config/generate-manifest.php`) check `php_sapi_name() === 'cli'`
- `config/security-headers.php` and `config/language-handler.php` refuse direct access (`BASE_URL_DEFINED` constant, `X-Requested-With` header)

---

## Configuration (`config/config.php`)

The file defines constants and variables, it does not return an array:

| Symbol | Meaning |
|--------|---------|
| `SUPPORTED_LANGS` | `['en', 'de', 'es', 'pt', 'fr', 'it']` |
| `BASE_PATH` | `/WebDev-Tools` when the host is `localhost`/`127.0.0.1`, otherwise `''` |
| `$baseUrl` | `http(s)://localhost[:port]` locally, `https://webdev-tools.info` in production |
| `$supportedLanguages` | name, native name and flag per language |
| `detectUserLanguage($supportedLanguages, $defaultLang)` | `?lang=` parameter → `webdev-tools-lang` cookie → `Accept-Language` → `en`; only runs when `$lang` is not already set by the page |

`config/language-handler.php` is the AJAX endpoint behind the language switcher: it validates the code against its own `$allowedLanguages` list and sets the `webdev-tools-lang` cookie (30 days, `SameSite=Strict`). The language list therefore lives in `config.php`, `language-handler.php` and `assets/js/i18n.js`; keep them in sync.

---

## Tool Registry (`config/tools.php`)

Returns an array keyed by tool id:

```php
'qrCodeGeneratorTool' => [
  'id' => 'qrCodeGeneratorTool',
  'slug' => 'qr-code-generator',
  'slugs' => ['en' => 'qr-code-generator', 'de' => 'qr-code-generator', 'es' => 'generador-qr',
              'pt' => 'gerador-qr', 'fr' => 'generateur-qr', 'it' => 'generatore-qr'],
  'category' => 'generators',
  'icon' => 'bi-qr-code',
  'jsModule' => 'tools/qrCodeGeneratorTool.js',
  'externalLibraries' => [[
    'url' => 'https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js',
    'integrity' => 'sha384-…',
    'crossorigin' => 'anonymous'
  ]],
  'features' => ['qr-generation', 'customizable', 'download-svg-png'],
  'seoTemplate' => 'default',
  'hasFeaturesSection' => true
],
```

| Key | Purpose |
|-----|---------|
| `id`, `slug`, `slugs` | Id matches the JS registration; `slugs[lang]` is the directory name under the language folder |
| `category` | `encoders`, `formatters`, `converters`, `generators`, `stringtools`, `references`, `utilities` – the sidebar groups in `getNavigationStructure()` |
| `icon` | Bootstrap Icons class including the `bi-` prefix |
| `jsModule` | Script path relative to `assets/js/`; `generate-manifest.php` turns it into `jsPath` |
| `externalLibraries` | Optional CDN scripts, rendered with SRI by `partials/common-scripts.php`; the QR code library is the only entry today |
| `features` | Free-form tags, copied into `manifest.json` |
| `hasFeaturesSection` | Shows the features card (`$features` from the page, else `seo.<id>.featureList`) |
| `hasAboutSection` | Present on one tool, set to `false`; not read by `tool-base.php` |

---

## Helpers (`config/helpers.php`)

| Function | Purpose |
|----------|---------|
| `getToolConfig($identifier)` | Registry entry by id, English slug or any localized slug; `null` if unknown |
| `getAllTools()` | The whole registry |
| `getToolScripts()` | `toolId => script file name` |
| `getNavigationStructure($lang)` | Tools grouped by category with localized URLs, cached per language |
| `getToolsByCategory($category)` | Tools of one category |
| `getToolUrl($idOrSlug, $lang)`, `getFullUrl($path, $lang)`, `getAllToolLanguageUrls($toolId)` | Absolute URLs, localized slugs, hreflang sets |
| `getLangPrefix($lang)` | `''` for `en`, `/de` etc. otherwise |
| `loadI18n($lang)` | Decoded `config/i18n/{lang}.json`, cached; `loadI18nData()` is the deprecated uncached variant |
| `t($i18nData, $key, $default)` | Dotted key lookup in the loaded array |
| `getManifest()` | Decoded `config/manifest.json` |
| `assetVersion($relPath)`, `assetSrc($relPath)` | Content hash (`xxh3`) of a file below `assets/` and the escaped `?v=` URL built from it |
| `getAssetUrl()`, `getVersionedAssetUrl()` | Older URL builders (`filemtime`-based version) |
| `getCspNonce()` | Per-request nonce generated in `security-headers.php` |
| `generateToolSchema()`, `generateBreadcrumbSchema()` | JSON-LD |
| `minify_html_output($html)` | Whitespace/comment stripping, only off localhost |
| `getJsonEncodeFlags()` | Pretty-print on localhost only |

---

## Tool Page (`tool-name/index.php`)

```php
<?php

declare(strict_types=1);

ob_start();                                   // tool-base.php ends with echo minify_html_output(ob_get_clean())

$toolId = 'myToolName';                       // key in tools.php
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';
$features = ['Plain text, escaped on output', '…'];
$usefulResources = [['url' => '…', 'title' => '…', 'description' => '…']];

// optional
$additionalSections = [['title' => 'Common Use Cases', 'icon' => 'lightbulb', 'content' => '<ul>…</ul>']];
$customNoticeType = 'info';                   // info | warning | success
$customNoticeContent = '<p class="mb-0">…</p>';

include __DIR__ . '/../partials/tool-base.php';
```

`tool-base.php` loads `config.php`, `security-headers.php` and `helpers.php`, resolves the registry entry (404 via `partials/error-template.php` if missing), reads `tools.<toolId>` and `seo.<toolId>` from the i18n file, and renders head, sidebar, H1 (`h1_title` → `toc_title`), standards badges (`$toolStandards` array inside the partial), the empty `#tool-container`, related tools, features, notice, additional sections, resources and footer.

Section icons in `$additionalSections` are names **without** the `bi-` prefix; the partial prepends it. Without an `icon`, one is picked from keywords in the title.

### Language versions

```
base64-encoder-decoder/index.php          # EN
de/base64-kodierer-dekodierer/index.php   # DE – directory = slugs['de']
es/base64-encoder-decoder/index.php       # ES
…
```

All page texts (`$features`, `$usefulResources`, `$additionalSections`, section titles, notices) are **hardcoded per language**; nothing comes from the JSON files. Each version is adapted to its audience rather than translated word for word. The language folders include `'/../../partials/tool-base.php'`.

---

## i18n Files (`config/i18n/{lang}.json`)

Top-level sections: `navigation`, `common`, `theme`, `errors`, `tools`, `seo`, `validation`, `time`, `date`.

- `tools.<toolId>.*` – UI strings for the JS tool (snake_case: `input_label`, `encode_btn`, …) plus the page fields `toc_title`, `h1_title`, `tool_description`, `card_description`, `linkTitle.nav`
- `seo.<toolId>.*` – `meta_title` (`<title>`), `meta_description`, `keywords`, `featureList`, `applicationCategory`; read in `tool-base.php` and used for JSON-LD

`head.php` inlines the current language's JSON as `window.__I18N__` with a nonce'd script; `assets/js/i18n.js` provides `window.i18n.t(key, params)` with `{{name}}`/`{name}` interpolation. `npm run check:i18n` enforces key parity across the six files.

---

## Generated Files

```bash
php config/generate-manifest.php    # config/manifest.json
php config/generate-sitemaps.php    # sitemap.xml (index), sitemap-en.xml, {de,es,fr,it,pt}/sitemap.xml
```

`config/manifest.json` is **not** the PWA manifest (that is `site.webmanifest` in the root and in each language folder). It is a dump of `tools.php` with `version`, `generatedAt` and per tool `url`, `jsPath`, `externalLibraries`, `features`. `tool-loader.js` fetches it, caches it in `localStorage` and loads `jsPath` via a `<script>` tag; `common-scripts.php` exposes its `version` as `window.MANIFEST_VERSION` so a new build invalidates the cache. The CI job `php` fails when the committed sitemaps differ from a fresh generation.

---

## Routing (`.htaccess`, `.htaccess.production`)

Both files hold the 301 rules from English slugs inside a language folder to the localized slug (`^de/url-encoder-decoder/?$ → /de/url-kodierer-dekodierer/`). `build.sh` copies `.htaccess.production` to `dist/.htaccess`; it additionally forces HTTPS, hides `X-Powered-By`/`Server`, and sets long immutable caching for `?v=` asset URLs. Every slug change goes into **both** files.

Error pages: `403.php`, `404.php`, `500.php` in the root, all rendered through `partials/error-template.php`.

---

## Security Headers (`config/security-headers.php`)

Included by `tool-base.php` after `config.php`. CSP (nonce per request from `random_bytes(16)`):

```
default-src 'self'; script-src 'self' 'nonce-…' https://cdn.jsdelivr.net; style-src 'self';
font-src 'self'; img-src 'self' data: blob: https:; connect-src 'self' https:; object-src 'none';
media-src 'none'; worker-src 'self'; manifest-src 'self'; [upgrade-insecure-requests;]
frame-ancestors 'none'; base-uri 'self'; form-action 'self'
```

`cdn.jsdelivr.net` is allowed for the two SRI-pinned scripts (qrcode-generator, terser); `connect-src https:` exists for the SRI generator, which fetches arbitrary URLs. Further headers: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection: 1; mode=block`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy` disabling geolocation, microphone, camera, payment, usb, magnetometer, gyroscope and accelerometer, HSTS (1 year, `includeSubDomains; preload`) when served over HTTPS, and `Cache-Control: no-cache` for HTML.

Inline scripts in the partials carry `nonce="<?= getCspNonce() ?>"`; self-hosted scripts match `'self'`.

---

**See also:** [NEUES-TOOL.md](NEUES-TOOL.md) (adding a tool), [SECURITY.md](SECURITY.md), [OVERVIEW.md](OVERVIEW.md) (build and deploy)
