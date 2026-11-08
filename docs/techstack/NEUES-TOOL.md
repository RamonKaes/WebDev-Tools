# Neues Tool hinzufügen – WebDev-Tools

Schritt-für-Schritt-Anleitung mit den tatsächlich verwendeten Schnittstellen. Jeder Codeblock ist aus dem Code abgeleitet; bei Zweifel gilt die genannte Quelldatei.

Beispiel-Tool in dieser Anleitung: `myToolName` mit dem Slug `my-tool`.

---

## 1. Tool-Registry (`config/tools.php`)

Ein Eintrag pro Tool. Der Array-Key, `id` und das erste Argument von `window.Tools.register()` müssen identisch sein.

```php
'myToolName' => [
  'id' => 'myToolName',
  'slug' => 'my-tool',                       // englischer Slug = Ordnername
  'slugs' => [                               // ein Slug pro Sprache (Ordnername unter de/, es/, …)
    'en' => 'my-tool', 'de' => 'mein-tool', 'es' => 'my-tool',
    'pt' => 'my-tool', 'fr' => 'my-tool', 'it' => 'my-tool'
  ],
  'category' => 'converters',                // encoders|formatters|converters|generators|stringtools|references|utilities
  'icon' => 'bi-gear',                       // Bootstrap-Icon-Klasse, hier MIT bi-Präfix
  'jsModule' => 'tools/myToolNameTool.js',   // relativ zu assets/js/
  'features' => ['live-mode'],               // freie Tags, landen in manifest.json
  'seoTemplate' => 'default',
  'hasFeaturesSection' => true,              // zeigt die Features-Karte aus $features
  // nur bei CDN-Bibliotheken, immer mit SRI (partials/common-scripts.php rendert die Tags):
  // 'externalLibraries' => [['url' => 'https://cdn.jsdelivr.net/npm/…', 'integrity' => 'sha384-…', 'crossorigin' => 'anonymous']],
],
```

Die Kategorien sind in `getNavigationStructure()` (`config/helpers.php`) fest verdrahtet; eine unbekannte Kategorie erscheint nicht in der Sidebar.

Danach außerdem eintragen:

- `assets/js/tool-loader.js` → `TOOL_MODULES_FALLBACK` (greift, wenn `config/manifest.json` nicht geladen werden kann)
- `build.sh` → Schleife `for tool_dir in …` (nur gelistete Tool-Ordner landen in `dist/`)
- `eslint.config.js` → `globals`, falls eine CDN-Bibliothek ein neues Global einführt (wie `qrcode`, `Terser`)
- `build-tools/bootstrap-custom.scss`, falls das Tool eine noch nicht importierte Bootstrap-Komponente braucht (Liste im Kommentar in `build.sh`, Abschnitt 5)

---

## 2. PHP-Seiten (6 Sprachen)

`my-tool/index.php` (EN) sowie `de/mein-tool/index.php`, `es/my-tool/index.php`, `fr/…`, `it/…`, `pt/…`. Ordnername = `slugs[lang]`.

```php
<?php

declare(strict_types=1);

ob_start(); // Pflicht: tool-base.php schließt den Buffer mit minify_html_output()

$toolId = 'myToolName';
$lang = 'en';                                // 'de', 'es', … in den Sprachordnern
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$features = [                                // reiner Text, wird mit htmlspecialchars() ausgegeben
    'Runs entirely in the browser',
    'Bulk processing',
];

$usefulResources = [
    ['url' => 'https://…', 'title' => '…', 'description' => '…'],
];

// optional
$additionalSections = [
    ['title' => 'Common Use Cases', 'icon' => 'lightbulb', 'content' => <<<HTML
<ul><li>…</li></ul>
HTML],
];
$customNoticeType = 'info';                  // 'info' | 'warning' | 'success'
$customNoticeContent = '<p class="mb-0">…</p>';

include __DIR__ . '/../partials/tool-base.php';   // in Sprachordnern: '/../../partials/tool-base.php'
```

Regeln (siehe `partials/tool-base.php`):

- Alle Texte hier sind **hardcoded pro Sprache** – kein i18n-JSON. Jede Sprachversion wird manuell gepflegt und kulturell angepasst, nicht 1:1 übersetzt.
- `$features`, Titel und Resource-Felder werden escaped; `content` der `$additionalSections` und `$customNoticeContent` sind rohes HTML.
- Icons in `$additionalSections` **ohne** `bi-`-Präfix (`'lightbulb'`, `'shield-check'`); fehlt `icon`, wird eines aus dem Titel abgeleitet.
- Fehlt `$features`, fällt die Features-Karte auf `seo.<toolId>.featureList` aus dem i18n-JSON zurück.
- Standards-Badges (RFC, CSPRNG, …) stehen im Array `$toolStandards` in `tool-base.php` und sind optional.

---

## 3. JavaScript (`assets/js/tools/myToolNameTool.js`)

Klassisches `<script>` (kein ES-Modul), das `tool-loader.js` zur Laufzeit per Script-Tag nachlädt und dann `window.Tools.open(toolId, container)` aufruft.

```js
(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[myToolName] Tools registry not available.');
    return;
  }

  window.Tools.register('myToolName', {
    init: function () {},

    open: function (container) {
      const t = (key, params) => (window.i18n && typeof window.i18n.t === 'function')
        ? window.i18n.t(key, params)
        : key.split('.').pop();

      container.innerHTML = `
        <label for="myInput" class="form-label">${t('tools.myToolName.input_label')}</label>
        <textarea id="myInput" class="form-control"></textarea>
        <button id="runBtn" class="btn btn-primary btn-sm">${t('tools.myToolName.run_btn')}</button>
        <button id="copyBtn" class="btn btn-outline-secondary btn-sm"><i class="bi bi-clipboard"></i></button>
        <pre id="output" class="mt-3"></pre>`;

      const input = container.querySelector('#myInput');
      const output = container.querySelector('#output');

      container.querySelector('#runBtn').addEventListener('click', () => {
        output.textContent = convert(input.value);          // textContent für alles aus User-Input
        window.A11yUtils.announce(t('tools.myToolName.done_msg'));
      });

      container.querySelector('#copyBtn').addEventListener('click', async (e) => {
        await window.ClipboardUtils.copyWithFeedback(e.currentTarget, output.textContent, t('common.copied'));
      });
    }
  });

  function convert(value) { return value.trim(); }
})();
```

Regeln: `'use strict'`, kein `var`, kein `eval`/`new Function`, kein `document.execCommand`, kein Inline-JS außerhalb der IIFE (CSP). Der Dateiname folgt in der Regel `<toolId>Tool.js`; bei IDs, die schon auf `Tool` enden (z. B. `htmlEntityTool`), heißt die Datei `htmlEntityTool.js`.

### Gemeinsame Bibliotheken (auf jeder Seite geladen, `partials/common-scripts.php`)

| Global | Funktion | Quelle |
|---|---|---|
| `ClipboardUtils` | `copyToClipboard(text, message?)` → `Promise<boolean>`; `copyWithFeedback(button, text, message)` → `Promise<boolean>` (tauscht das Icon kurz gegen ein Häkchen); `showToast(message, type = 'success', duration = 3000)`; `isClipboardSupported()` | `assets/js/lib/clipboard-utils.js` |
| `DownloadUtils` | `downloadText(content, filename, mimeType = 'text/plain')`, `downloadJSON(data, filename, pretty)`, `downloadBlob(blob, filename)`, `downloadCanvas(canvas, filename, quality)`, `downloadSVG(svg, filename)`, `downloadBase64(data, filename)`, `downloadCSV(rows, filename, delimiter, includeBOM)`, `sanitizeFilename(name)` | `assets/js/lib/download-utils.js` |
| `A11yUtils` | `announce(message, { assertive = false, delay = 400 })` für Screenreader-Live-Region, `clearAnnouncements()` | `assets/js/lib/a11y-utils.js` |
| `AppHelpers` | `escapeHtml(unsafe)` für Strings, die doch in `innerHTML` landen müssen | `assets/js/helpers.js` (in `head.php`) |

Große Daten (Wortliste, Monitoring) werden mit `import()` nachgeladen (`lib/wordlist.js`, `lib/performance-monitoring.js`); das sind die einzigen ES-Module.

---

## 4. i18n (`config/i18n/{en,de,es,pt,fr,it}.json`)

Alle sechs Dateien gleichzeitig pflegen; `npm run check:i18n` prüft, dass jede Datei exakt die Schlüssel von `en.json` hat und dieselben Platzhalter (`{{name}}` oder `{name}`, beides wird in `i18n.js` ersetzt).

```json
"tools": {
  "myToolName": {
    "toc_title": "My Tool",                   // Sidebar, <title>-Fallback, Inhaltsverzeichnis
    "h1_title": "My Tool – Convert …",        // H1 der Seite
    "tool_description": "…",                  // Absatz unter der H1 (Fallback: card_description)
    "card_description": "…",                  // Startseite
    "linkTitle": { "nav": "…" },              // title-Attribut des Sidebar-Links
    "input_label": "Input",                   // UI-Strings: snake_case
    "run_btn": "Convert",
    "done_msg": "Done"
  }
},
"seo": {
  "myToolName": {
    "meta_title": "…",                        // <title>
    "meta_description": "…",                  // <meta name="description">
    "keywords": "a, b, c",
    "featureList": ["…", "…"],                // JSON-LD und Fallback für die Features-Karte
    "applicationCategory": "UtilityApplication"
  }
}
```

`partials/tool-base.php` liest `tools.<toolId>` und `seo.<toolId>`; UI-Strings holt das Tool mit `window.i18n.t('tools.myToolName.input_label')`.

---

## 5. Generierte Dateien

```bash
php config/generate-manifest.php    # config/manifest.json – Tool-Registry für tool-loader.js (kein PWA-Manifest)
php config/generate-sitemaps.php    # sitemap.xml, sitemap-en.xml, {de,es,fr,it,pt}/sitemap.xml
```

CI schlägt fehl, wenn die Sitemaps nicht zum Stand von `tools.php` passen (`git diff --exit-code` im Job `php`).

---

## 6. Rewrite-Regeln (`.htaccess` **und** `.htaccess.production`)

Bei lokalisierten Slugs leitet der englische Slug im Sprachordner auf den lokalisierten um; bei Umbenennungen der alte auf den neuen. Immer beide Dateien ändern – `build.sh` kopiert `.htaccess.production` nach `dist/.htaccess`.

```apache
RewriteRule ^de/my-tool/?$ /de/mein-tool/ [R=301,L]
```

---

## 7. Tests

### Jest (`tests/unit/myToolNameTool.test.js`)

`tests/unit/setup.js` stellt nur `TextEncoder`/`TextDecoder`, `URL.createObjectURL` und `scrollIntoView` bereit. Registry, i18n und die Bibliotheken mockt jeder Test selbst (Muster: `tests/unit/uuidGeneratorTool.test.js`):

```js
'use strict';
const path = require('path');
let tool;

beforeAll(() => {
  global.window = global;
  global.Tools = { _tools: {}, register: (name, obj) => { global.Tools._tools[name] = obj; }, open: jest.fn() };
  global.i18n = { t: (key) => key };
  global.ClipboardUtils = { copyToClipboard: jest.fn().mockResolvedValue(true), copyWithFeedback: jest.fn().mockResolvedValue(true) };
  global.DownloadUtils = { downloadText: jest.fn() };
  global.A11yUtils = { announce: jest.fn() };
  require(path.join(__dirname, '../../assets/js/tools/myToolNameTool.js'));
  tool = global.Tools._tools.myToolName;
});

function openTool() {
  document.body.innerHTML = '<div id="tool-container"></div>';
  const container = document.getElementById('tool-container');
  tool.open(container);
  return container;
}

test('registers under its id', () => expect(tool).toBeDefined());

test('converts input', () => {
  const c = openTool();
  c.querySelector('#myInput').value = '  x ';
  c.querySelector('#runBtn').click();
  expect(c.querySelector('#output').textContent).toBe('x');
});
```

Pro Konverter/Feature mindestens ein Happy-Path und ein Fehlerfall. `npm test`, `npm run test:coverage` (Schwellen in `jest.config.js`), `npm run lint`.

### Browser (Playwright, `tests/browser/`)

- `tools.spec.js`: Normalfall je Tool über die echte Seite; Eingabe/Button/Ausgabe per Selektor, Erwartungswert von außerhalb des Tools. Textbasierte Tools kommen als Objekt in `TEXT_TOOLS`, andere bekommen einen eigenen `test()`.
- `pages.spec.js`: Testname und Kommentar bei „the sitemap covers all 20 tools“ auf die neue Tool-Zahl anpassen.
- `accessibility.spec.js`: läuft automatisch über alle Sitemap-Seiten (axe, WCAG 2.2 AA, hell und dunkel). Neue Felder brauchen `<label for>` oder `aria-label`.

```bash
bash build.sh && npm run test:browser   # braucht apache2 + libapache2-mod-php, siehe tests/browser/serve.sh
```

---

## 8. Checkliste

- [ ] `config/tools.php`, `tool-loader.js` (Fallback), `build.sh` (Tool-Ordner), ggf. `eslint.config.js` / `bootstrap-custom.scss`
- [ ] `my-tool/index.php` + 5 Sprachversionen unter `slugs[lang]`
- [ ] `assets/js/tools/myToolNameTool.js`
- [ ] `tools.myToolName.*` und `seo.myToolName.*` in allen 6 JSON-Dateien, `npm run check:i18n` grün
- [ ] `php config/generate-manifest.php && php config/generate-sitemaps.php`
- [ ] Rewrite-Regeln in `.htaccess` und `.htaccess.production`
- [ ] `tests/unit/myToolNameTool.test.js`, Eintrag in `tools.spec.js`, Tool-Zahl in `pages.spec.js`
- [ ] `npm run lint && npm test && bash build.sh && npm run test:browser`
- [ ] Eintrag in `CHANGELOG.md`
