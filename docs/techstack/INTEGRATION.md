# Integration Guide – Adding a New Tool

**Checklist for integrating a new tool** – Step-by-step guide.

---

## Overview

A new tool requires:

1. ✅ PHP files (EN + 5 language versions)
2. ✅ JavaScript module (IIFE pattern)
3. ✅ Entry in `config/tools.php`
4. ✅ i18n keys in all 6 JSON files
5. ✅ Jest tests
6. ✅ (Optional) Standards badges in `partials/tool-base.php`
7. ✅ (Optional) .htaccess rewrites
8. ✅ Generate manifest & sitemaps
9. ✅ Production build

**Estimated time:** 2-4 hours (depending on tool complexity)

---

## Schritt 1: PHP-Tool-Seite erstellen

### 1.1 Englische Version (default)

**Datei:** `tool-name/index.php`

```php
<?php
declare(strict_types=1);
ob_start();  // Pflicht! Für HTML-Minification in tool-base.php

$toolId = 'myToolName';  // camelCase, eindeutig
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$features = [
    'Privacy-first: All operations run client-side',
    'No data transmission to servers',
    'Fast and responsive interface',
    'Works offline after first load'
];

$usefulResources = [
    [
        'url' => 'https://example.com/docs',
        'title' => 'Official Documentation',
        'description' => 'Comprehensive guide and API reference'
    ]
];

// Optional: Additional Sections
// $additionalSections = [ ... ];

include __DIR__ . '/../partials/tool-base.php';
```

---

### 1.2 Deutsche Version

**Datei:** `de/tool-name/index.php`

```php
<?php
declare(strict_types=1);
ob_start();  // Pflicht! Für HTML-Minification in tool-base.php

$toolId = 'myToolName';  // Selbe ID wie EN
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Datenschutz: Alle Operationen laufen client-seitig',
    'Keine Datenübertragung an Server',
    'Schnelle und responsive Oberfläche',
    'Funktioniert offline nach erstem Laden'
];

$usefulResources = [
    [
        'url' => 'https://example.com/docs',
        'title' => 'Offizielle Dokumentation',
        'description' => 'Umfassender Leitfaden und API-Referenz'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
```

---

### 1.3 Weitere Sprachversionen

Analog für:
- `es/tool-name/index.php` (Spanisch)
- `pt/tool-name/index.php` (Portugiesisch)
- `fr/tool-name/index.php` (Französisch)
- `it/tool-name/index.php` (Italienisch)

**Wichtig:** 
- `$toolId` ist in allen Sprachen identisch
- `$lang` entspricht dem Sprachcode
- Relative Pfade zu `tool-base.php` anpassen

---

## Schritt 2: JavaScript-Tool-Modul

**Datei:** `assets/js/tools/myToolNameTool.js`

```javascript
(function() {
  'use strict';

  // Guard: Tools-Registry vorhanden?
  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'myToolName'})
      : '[myToolName] Tools registry not available.';
    console.warn(msg);
    return;
  }

  // i18n-Helper (Modul-Ebene)
  const t = (key, params) => {
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(key, params);
    }
    return key.split('.').pop();
  };

  // Tool-Initialisierung
  function init(container) {
    
    container.innerHTML = `
      <div class="tool-section">
        <label for="input" class="form-label">${t('tools.myToolName.inputLabel')}</label>
        <textarea id="input" class="form-control" rows="8" 
          placeholder="${t('tools.myToolName.inputPlaceholder')}"></textarea>
      </div>

      <div class="tool-section">
        <label for="output" class="form-label">${t('tools.myToolName.outputLabel')}</label>
        <textarea id="output" class="form-control" rows="8" readonly></textarea>
        
        <div class="button-group mt-2">
          <button id="copy-btn" class="btn btn-outline-primary">
            <i class="bi bi-clipboard"></i> ${t('common.copy')}
          </button>
          <button id="download-btn" class="btn btn-outline-secondary">
            <i class="bi bi-download"></i> ${t('common.download')}
          </button>
        </div>
      </div>
    `;

    // Event-Listener
    document.getElementById('input').addEventListener('input', processInput);
    document.getElementById('copy-btn').addEventListener('click', copyOutput);
    document.getElementById('download-btn').addEventListener('click', downloadOutput);
  }

  // Core-Funktionalität
  function processInput() {
    const input = document.getElementById('input').value;
    const output = document.getElementById('output');

    if (!input.trim()) {
      output.value = '';
      return;
    }

    try {
      // Hier die Tool-Logik implementieren
      const result = transformInput(input);
      output.value = result;
    } catch (error) {
      output.value = t('tools.myToolName.errors.processingFailed');
      console.error('Processing error:', error);
    }
  }

  function transformInput(input) {
    // TODO: Tool-spezifische Transformation
    return input.toUpperCase();
  }

  function copyOutput() {
    const output = document.getElementById('output').value;
    window.ClipboardUtils.copyToClipboard(
      output,
      () => console.log('Copied!'),
      (err) => console.error('Copy failed:', err)
    );
  }

  function downloadOutput() {
    const output = document.getElementById('output').value;
    window.DownloadUtils.downloadText(
      output,
      'output.txt',
      'text/plain'
    );
  }

  // Tool registrieren
  window.Tools.register('myToolName', {
    init: function() {},   // Wird automatisch bei register() aufgerufen
    open: init             // Wird bei Tool-Aufruf mit container aufgerufen
  });
})();
```

---

## Schritt 3: Tool-Registry aktualisieren

**Datei:** `config/tools.php`

```php
return [
  // ... existierende Tools

  'myToolName' => [
    'id' => 'myToolName',
    'slug' => 'my-tool-name',
    'slugs' => [
      'en' => 'my-tool-name',
      'de' => 'mein-werkzeug',
      'es' => 'mi-herramienta',
      'pt' => 'minha-ferramenta',
      'fr' => 'mon-outil',
      'it' => 'mio-strumento'
    ],
    'category' => 'converters',  // encoders|formatters|generators|converters|references|stringtools|utilities
    'icon' => 'bi-gear',
    'jsModule' => 'tools/myToolNameTool.js',
    'jsLibraries' => [
      'clipboard-utils',
      'download-utils',
      'validators'
    ],
    'features' => [
      'privacy-first',
      'live-mode'
    ],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ]
];
```

---

## Schritt 4: i18n-Strings hinzufügen

Alle 6 JSON-Dateien aktualisieren:

### `config/i18n/en.json`

```json
{
  "tools": {
    "myToolName": {
      "meta_title": "My Tool - WebDev-Tools",
      "meta_description": "Description for search engines",
      "inputLabel": "Input",
      "inputPlaceholder": "Enter text here...",
      "outputLabel": "Output",
      "errors": {
        "processingFailed": "Processing failed. Please check your input."
      }
    }
  }
}
```

### Analog für:
- `config/i18n/de.json`
- `config/i18n/es.json`
- `config/i18n/pt.json`
- `config/i18n/fr.json`
- `config/i18n/it.json`

---

## Schritt 5: Jest-Tests schreiben

**Datei:** `tests/unit/myToolNameTool.test.js`

```javascript
describe('MyToolName', () => {
  let tool;

  beforeAll(() => {
    // Mocks (falls nicht in setup.js)
    window.Tools = { register: jest.fn() };
    window.i18n = { t: jest.fn(key => key) };
    window.ClipboardUtils = { copyToClipboard: jest.fn() };
    window.DownloadUtils = { downloadText: jest.fn() };

    // Tool laden
    require('../../assets/js/tools/myToolNameTool.js');
    tool = window.Tools.register.mock.calls[0][1];
  });

  beforeEach(() => {
    document.body.innerHTML = '<div id="tool-container"></div>';
  });

  describe('Initialization', () => {
    it('should register with correct tool ID', () => {
      expect(window.Tools.register).toHaveBeenCalledWith(
        'myToolName',
        expect.objectContaining({ open: expect.any(Function) })
      );
    });

    it('should render UI on open()', () => {
      tool.open();
      expect(document.getElementById('input')).toBeTruthy();
      expect(document.getElementById('output')).toBeTruthy();
    });
  });

  describe('Core Functionality', () => {
    it('should process valid input', () => {
      tool.open();
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = 'test';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('TEST');  // Beispiel: toUpperCase
    });

    it('should handle empty input', () => {
      tool.open();
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = '';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('');
    });
  });

  describe('Copy Functionality', () => {
    it('should copy output to clipboard', () => {
      tool.open();
      document.getElementById('output').value = 'test output';
      document.getElementById('copy-btn').click();

      expect(window.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(
        'test output',
        expect.any(Function),
        expect.any(Function)
      );
    });
  });

  describe('Download Functionality', () => {
    it('should download output as file', () => {
      tool.open();
      document.getElementById('output').value = 'test output';
      document.getElementById('download-btn').click();

      expect(window.DownloadUtils.downloadText).toHaveBeenCalledWith(
        'test output',
        expect.stringContaining('.txt'),
        'text/plain'
      );
    });
  });
});
```

**Tests ausführen:**

```bash
npm test -- myToolNameTool.test.js
```

---

## Schritt 6: Standards-Badges (optional)

In `partials/tool-base.php` existiert ein hardcoded Array `$toolStandards`, das technische Badges (z.B. RFC-Standards, W3C-Specs) für jedes Tool definiert. Falls dein Tool auf einem bekannten Standard basiert, füge dort einen Eintrag hinzu:

```php
// In partials/tool-base.php → $toolStandards Array:
'myToolName' => [
    ['label' => 'RFC 4648', 'url' => 'https://tools.ietf.org/html/rfc4648'],
    ['label' => 'W3C Standard', 'url' => 'https://www.w3.org/TR/...']
]
```

**Hinweis:** Ohne Eintrag werden einfach keine Badges angezeigt – das Tool funktioniert trotzdem.

---

## Schritt 7: .htaccess-Rewrites (optional)

**Nur nötig bei:**
- Lokalisierten Slugs (z.B. `de/mein-werkzeug` statt `de/my-tool-name`)
- Umbenennungen von bestehenden Tools (301-Redirects)

### `.htaccess` UND `.htaccess.production` aktualisieren:

```apache
# Trailing Slash erzwingen
RewriteRule ^my-tool-name$ /my-tool-name/ [R=301,L]
RewriteRule ^de/mein-werkzeug$ /de/mein-werkzeug/ [R=301,L]

# Bei Tool-Umbenennung: Alt → Neu
# RewriteRule ^old-tool-name/?$ /my-tool-name/ [R=301,L]
```

---

## Schritt 8: Manifest & Sitemaps generieren

```bash
php config/generate-manifest.php
php config/generate-sitemaps.php
```

**Prüfen:**
- `config/manifest.json` – Neues Tool in `shortcuts` vorhanden?
- `sitemap-en.xml`, `sitemap-de.xml`, etc. – Tool-URLs enthalten?

---

## Schritt 9: Build & Deployment

### Production-Build

```bash
bash build.sh
```

**Prüft:**
- JS-Minification erfolgreich
- CSS-Optimierung
- Alle Dateien nach `dist/` kopiert

### Tests vor Deploy

```bash
npm test
npm run test:coverage
```

### Deploy (wenn Tests grün)

```bash
npm run deploy
```

---

## Checkliste (Zusammenfassung)

- [ ] **PHP-Dateien:** 6 Sprachversionen erstellt (`tool-name/index.php`, `de/`, `es/`, etc.)
- [ ] **JavaScript:** `assets/js/tools/myToolNameTool.js` implementiert (IIFE-Pattern)
- [ ] **Tools-Registry:** Eintrag in `config/tools.php` hinzugefügt
- [ ] **i18n-Strings:** Alle 6 JSON-Dateien aktualisiert (`config/i18n/`)
- [ ] **Tests:** `tests/unit/myToolNameTool.test.js` geschrieben & grün
- [ ] **Standards-Badges:** Eintrag in `$toolStandards` in `partials/tool-base.php` hinzugefügt (optional)
- [ ] **Manifest:** `php config/generate-manifest.php` ausgeführt
- [ ] **Sitemaps:** `php config/generate-sitemaps.php` ausgeführt
- [ ] **.htaccess:** Rewrites hinzugefügt (falls lokalisierte Slugs)
- [ ] **Build:** `bash build.sh` erfolgreich
- [ ] **Manual Testing:** Tool in Browser getestet (EN + mind. 1 andere Sprache)
- [ ] **Deploy:** `npm run deploy` (oder manueller rsync)

---

## Troubleshooting

### Tool wird nicht geladen

**Symptom:** "Tool not found" oder leerer Container

**Lösungen:**
1. `config/tools.php` – `id` und `jsModule` prüfen
2. `assets/js/tools/myToolNameTool.js` – `window.Tools.register('myToolName', ...)` korrekt?
3. Browser-Console: JavaScript-Fehler?
4. Cache leeren & Hard Reload (Ctrl+Shift+R)

---

### i18n-Strings fehlen

**Symptom:** Keys statt Texte angezeigt (z.B. `tools.myToolName.inputLabel`)

**Lösungen:**
1. `config/i18n/{lang}.json` – Keys existieren?
2. JSON-Syntax korrekt? (letztes Komma entfernen!)
3. Server neu starten (falls PHP-Caching aktiv)

---

### Tests schlagen fehl

**Symptom:** `npm test` zeigt Fehler

**Lösungen:**
1. `tests/setup.js` – Alle Mocks vorhanden?
2. `tool.open()` vor DOM-Manipulation aufrufen
3. `document.body.innerHTML` in `beforeEach()` zurücksetzen
4. `jest.clearAllMocks()` in `afterEach()` (falls Mocks verwirrt sind)

---

### Build-Fehler (Terser)

**Symptom:** `bash build.sh` schlägt bei Minification fehl

**Lösungen:**
1. JS-Datei auf Syntax-Fehler prüfen: `node -c assets/js/tools/myToolNameTool.js`
2. Trailing Commas in Objekten/Arrays entfernen (alte Terser-Versionen)
3. ES6-Features prüfen (ggf. Terser-Config anpassen)

---

## Best Practices

### ✅ DO:
- **Konsistente Namensgebung:** `myToolName` (camelCase in Code), `my-tool-name` (kebab-case in URLs)
- **Alle 6 Sprachen pflegen** – keine Sprachversion vergessen
- **Tests schreiben BEVOR Tool fertig** (TDD)
- **Performance-Guards nutzen** bei großen Inputs
- **XSS-Schutz:** `textContent` statt `innerHTML` für User-Input

### ❌ DON'T:
- **Keine gemischten Sprachen** (z.B. englische UI mit deutschem PHP-Content)
- **Kein Code-Duplication** – gemeinsame Utilities nutzen
- **Keine direkten DOM-Manipulationen** vor `init()`
- **Keine Hard-coded Strings** im JS-Code (immer i18n nutzen)

---

**Weitere Infos:**
- [FRONTEND.md](FRONTEND.md) – JS-Utilities & Pattern
- [BACKEND.md](BACKEND.md) – PHP-Standards & Registry
- [TESTING.md](TESTING.md) – Test-Patterns & Coverage
