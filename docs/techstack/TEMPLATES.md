# Code-Templates – WebDev-Tools

**Ready-to-use Templates** für neue Tools – Copy & Paste, dann anpassen.

---

## PHP-Tool-Template

### Englische Version (Default)

**Datei:** `tool-name/index.php`

```php
<?php
declare(strict_types=1);
ob_start();  // Pflicht! Wird von tool-base.php für HTML-Minification benötigt

// ============================================================================
// Tool Configuration
// ============================================================================
$toolId = 'myToolName';  // camelCase, muss mit tools.php und JS matchen
$lang = 'en';

// ============================================================================
// Features Section
// ============================================================================
$featuresSectionTitle = 'Features';
$features = [
    'Privacy-first: All operations run client-side in your browser',
    'No data transmission to any server',
    'Fast and responsive interface',
    'Works offline after initial load',
    'Copy results to clipboard with one click',
    'Download results as file'
];

// ============================================================================
// Resources Section
// ============================================================================
$resourcesSectionTitle = 'Useful Resources';
$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API',
        'title' => 'MDN Web API Documentation',
        'description' => 'Comprehensive reference for web APIs and standards'
    ],
    [
        'url' => 'https://example.com/spec',
        'title' => 'Specification',
        'description' => 'Official specification or RFC document'
    ]
];

// ============================================================================
// Additional Sections (Optional)
// ============================================================================
// Uncomment and customize if needed:

/*
$additionalSections = [
    [
        'title' => 'How It Works',
        'icon' => 'bi-info-circle',
        'content' => <<<HTML
<p>This tool performs the following operations:</p>
<ol>
    <li><strong>Step 1:</strong> Parse and validate your input</li>
    <li><strong>Step 2:</strong> Apply transformation or conversion</li>
    <li><strong>Step 3:</strong> Display formatted results</li>
</ol>
<p>All processing happens entirely in your browser - no data leaves your device.</p>
HTML
    ],
    [
        'title' => 'Use Cases',
        'icon' => 'bi-lightbulb',
        'content' => <<<HTML
<ul>
    <li>Web development and debugging</li>
    <li>API testing and integration</li>
    <li>Data format conversion</li>
    <li>Quick reference and validation</li>
</ul>
HTML
    ]
];
*/

// ============================================================================
// Custom Notice (Optional)
// ============================================================================
// Uncomment if you need a custom notice box:

// $customNoticeContent = 'Important: This tool requires JavaScript to function.';
// $customNoticeType = 'info';  // Options: 'info', 'warning', 'success'

// ============================================================================
// Load Base Layout
// ============================================================================
include __DIR__ . '/../partials/tool-base.php';
```

---

### Deutsche Version

**Datei:** `de/tool-name/index.php`

```php
<?php
declare(strict_types=1);
ob_start();  // Pflicht! Wird von tool-base.php für HTML-Minification benötigt

// ============================================================================
// Tool-Konfiguration
// ============================================================================
$toolId = 'myToolName';  // IDENTISCH wie EN-Version
$lang = 'de';

// ============================================================================
// Funktionen-Sektion
// ============================================================================
$featuresSectionTitle = 'Funktionen';
$features = [
    'Datenschutz: Alle Operationen laufen client-seitig in Ihrem Browser',
    'Keine Datenübertragung an Server',
    'Schnelle und responsive Oberfläche',
    'Funktioniert offline nach erstem Laden',
    'Ergebnisse mit einem Klick in die Zwischenablage kopieren',
    'Ergebnisse als Datei herunterladen'
];

// ============================================================================
// Ressourcen-Sektion
// ============================================================================
$resourcesSectionTitle = 'Nützliche Ressourcen';
$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/API',
        'title' => 'MDN Web-API-Dokumentation',
        'description' => 'Umfassende Referenz für Web-APIs und Standards'
    ],
    [
        'url' => 'https://example.com/spec',
        'title' => 'Spezifikation',
        'description' => 'Offizielle Spezifikation oder RFC-Dokument'
    ]
];

// ============================================================================
// Zusätzliche Sektionen (Optional)
// ============================================================================
/*
$additionalSections = [
    [
        'title' => 'Funktionsweise',
        'icon' => 'bi-info-circle',
        'content' => <<<HTML
<p>Dieses Tool führt folgende Schritte aus:</p>
<ol>
    <li><strong>Schritt 1:</strong> Eingabe parsen und validieren</li>
    <li><strong>Schritt 2:</strong> Transformation anwenden</li>
    <li><strong>Schritt 3:</strong> Formatierte Ergebnisse anzeigen</li>
</ol>
<p>Die gesamte Verarbeitung erfolgt in Ihrem Browser - keine Daten verlassen Ihr Gerät.</p>
HTML
    ]
];
*/

// ============================================================================
// Basis-Layout laden
// ============================================================================
include __DIR__ . '/../../partials/tool-base.php';
```

---

### Weitere Sprachversionen

**Struktur identisch, nur Texte anpassen:**

| Datei | Sprachcode | Relative Pfad zu tool-base.php |
|-------|------------|--------------------------------|
| `es/tool-name/index.php` | `es` | `../../partials/tool-base.php` |
| `pt/tool-name/index.php` | `pt` | `../../partials/tool-base.php` |
| `fr/tool-name/index.php` | `fr` | `../../partials/tool-base.php` |
| `it/tool-name/index.php` | `it` | `../../partials/tool-base.php` |

---

## JavaScript-Tool-Template

**Datei:** `assets/js/tools/myToolNameTool.js`

```javascript
/**
 * My Tool Name - WebDev-Tools
 * Description: Brief description of what this tool does
 */

(function() {
  'use strict';

  // ==========================================================================
  // Guard: Tools-Registry vorhanden?
  // ==========================================================================
  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'myToolName'})
      : '[myToolName] Tools registry not available.';
    console.warn(msg);
    return;
  }

  // ==========================================================================
  // i18n Helper (Modul-Ebene, außerhalb von open())
  // ==========================================================================
  const t = (key, params) => {
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(key, params);
    }
    return key.split('.').pop();
  };

  // ==========================================================================
  // Tool Initialization
  // ==========================================================================
  function init(container) {
    
    container.innerHTML = `
      <!-- Input Section -->
      <div class="tool-section">
        <label for="input" class="form-label">
          ${t('tools.myToolName.inputLabel')}
        </label>
        <textarea 
          id="input" 
          class="form-control" 
          rows="8"
          placeholder="${t('tools.myToolName.inputPlaceholder')}"
          aria-label="${t('tools.myToolName.inputLabel')}"></textarea>
        
        <div class="mt-2">
          <small class="text-muted">
            ${t('tools.myToolName.inputHint')}
          </small>
        </div>
      </div>

      <!-- Options Section (Optional) -->
      <div class="tool-section">
        <label class="form-label">${t('tools.myToolName.optionsLabel')}</label>
        <div class="form-check">
          <input 
            type="checkbox" 
            class="form-check-input" 
            id="option-1"
            checked>
          <label class="form-check-label" for="option-1">
            ${t('tools.myToolName.option1')}
          </label>
        </div>
      </div>

      <!-- Output Section -->
      <div class="tool-section">
        <label for="output" class="form-label">
          ${t('tools.myToolName.outputLabel')}
        </label>
        <textarea 
          id="output" 
          class="form-control" 
          rows="8" 
          readonly
          aria-label="${t('tools.myToolName.outputLabel')}"></textarea>

        <!-- Action Buttons -->
        <div class="button-group mt-2">
          <button id="copy-btn" class="btn btn-outline-primary">
            <i class="bi bi-clipboard"></i>
            ${t('common.copy')}
          </button>
          <button id="download-btn" class="btn btn-outline-secondary">
            <i class="bi bi-download"></i>
            ${t('common.download')}
          </button>
          <button id="clear-btn" class="btn btn-outline-danger">
            <i class="bi bi-x-circle"></i>
            ${t('common.clear')}
          </button>
        </div>
      </div>

      <!-- Error Display -->
      <div id="error-container" class="alert alert-danger d-none" role="alert"></div>
    `;

    // Register Event Listeners
    attachEventListeners();
  }

  // ==========================================================================
  // Event Listeners
  // ==========================================================================
  function attachEventListeners() {
    document.getElementById('input').addEventListener('input', handleInput);
    document.getElementById('copy-btn').addEventListener('click', copyOutput);
    document.getElementById('download-btn').addEventListener('click', downloadOutput);
    document.getElementById('clear-btn').addEventListener('click', clearAll);
    
    // Optional: Live-Mode toggle
    const option1 = document.getElementById('option-1');
    if (option1) {
      option1.addEventListener('change', handleInput);
    }
  }

  // ==========================================================================
  // Core Functionality
  // ==========================================================================
  function handleInput() {
    const input = document.getElementById('input').value;
    const output = document.getElementById('output');
    const errorContainer = document.getElementById('error-container');

    // Clear previous errors
    hideError();

    // Handle empty input
    if (!input.trim()) {
      output.value = '';
      return;
    }

    try {
      // Input validation
      if (!validateInput(input)) {
        showError(t('tools.myToolName.errors.invalidInput'));
        return;
      }

      // Performance guard for large inputs
      const sizeCheck = window.PerformanceGuards?.checkInputSize(input);
      if (sizeCheck && !sizeCheck.safe) {
        showError(t('tools.myToolName.errors.inputTooLarge', { 
          maxSize: '10 MB' 
        }));
        return;
      }

      // Core transformation
      const result = transformInput(input);
      output.value = result;

    } catch (error) {
      console.error('Processing error:', error);
      showError(t('tools.myToolName.errors.processingFailed'));
      output.value = '';
    }
  }

  // ==========================================================================
  // Input Validation
  // ==========================================================================
  function validateInput(input) {
    // TODO: Implement validation logic
    // Examples:
    // - Check format (JSON, URL, etc.)
    // - Check length
    // - Check special characters
    
    return true;  // Placeholder
  }

  // ==========================================================================
  // Core Transformation
  // ==========================================================================
  function transformInput(input) {
    // TODO: Implement core tool logic
    // Example transformations:
    // - Encoding/Decoding
    // - Formatting
    // - Generation
    // - Conversion

    // Placeholder: Convert to uppercase
    return input.toUpperCase();
  }

  // ==========================================================================
  // Error Handling
  // ==========================================================================
  function showError(message) {
    const errorContainer = document.getElementById('error-container');
    errorContainer.textContent = message;
    errorContainer.classList.remove('d-none');
  }

  function hideError() {
    const errorContainer = document.getElementById('error-container');
    errorContainer.classList.add('d-none');
    errorContainer.textContent = '';
  }

  // ==========================================================================
  // Copy to Clipboard
  // ==========================================================================
  function copyOutput() {
    const output = document.getElementById('output').value;
    
    if (!output) {
      showError(t('tools.myToolName.errors.nothingToCopy'));
      return;
    }

    window.ClipboardUtils.copyToClipboard(
      output,
      function onSuccess() {
        // Optional: Show success toast
        console.log('Copied to clipboard');
      },
      function onError(err) {
        console.error('Copy failed:', err);
        showError(t('tools.myToolName.errors.copyFailed'));
      }
    );
  }

  // ==========================================================================
  // Download as File
  // ==========================================================================
  function downloadOutput() {
    const output = document.getElementById('output').value;
    
    if (!output) {
      showError(t('tools.myToolName.errors.nothingToDownload'));
      return;
    }

    // Generate filename with timestamp
    const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
    const filename = `mytool-output-${timestamp}.txt`;

    window.DownloadUtils.downloadText(
      output,
      filename,
      'text/plain'  // Adjust MIME type as needed
    );
  }

  // ==========================================================================
  // Clear All
  // ==========================================================================
  function clearAll() {
    document.getElementById('input').value = '';
    document.getElementById('output').value = '';
    hideError();
  }

  // ==========================================================================
  // Tool Registration
  // ==========================================================================
  window.Tools.register('myToolName', {
    init: function() {},       // Wird automatisch bei register() aufgerufen
    open: init                 // Wird bei Tool-Aufruf mit container aufgerufen
  });

})();
```

---

## i18n-JSON-Template

### Englisch (`config/i18n/en.json`)

```json
{
  "tools": {
    "myToolName": {
      "meta_title": "My Tool Name - WebDev-Tools",
      "meta_description": "Brief SEO-friendly description for search engines (max 160 chars)",
      "inputLabel": "Input",
      "inputPlaceholder": "Enter your text here...",
      "inputHint": "Supports plain text, max 10 MB",
      "outputLabel": "Output",
      "optionsLabel": "Options",
      "option1": "Enable feature X",
      "errors": {
        "invalidInput": "Invalid input format. Please check your data.",
        "inputTooLarge": "Input too large (max {maxSize})",
        "processingFailed": "Processing failed. Please try again.",
        "nothingToCopy": "Nothing to copy. Please process some input first.",
        "nothingToDownload": "Nothing to download. Please process some input first.",
        "copyFailed": "Failed to copy to clipboard. Please try manually."
      }
    }
  }
}
```

### Deutsche Version (`config/i18n/de.json`)

```json
{
  "tools": {
    "myToolName": {
      "meta_title": "Mein Tool-Name - WebDev-Tools",
      "meta_description": "Kurze SEO-freundliche Beschreibung für Suchmaschinen (max 160 Zeichen)",
      "inputLabel": "Eingabe",
      "inputPlaceholder": "Geben Sie hier Ihren Text ein...",
      "inputHint": "Unterstützt Plaintext, max. 10 MB",
      "outputLabel": "Ausgabe",
      "optionsLabel": "Optionen",
      "option1": "Funktion X aktivieren",
      "errors": {
        "invalidInput": "Ungültiges Eingabeformat. Bitte überprüfen Sie Ihre Daten.",
        "inputTooLarge": "Eingabe zu groß (max. {maxSize})",
        "processingFailed": "Verarbeitung fehlgeschlagen. Bitte versuchen Sie es erneut.",
        "nothingToCopy": "Nichts zum Kopieren. Bitte verarbeiten Sie zuerst eine Eingabe.",
        "nothingToDownload": "Nichts zum Herunterladen. Bitte verarbeiten Sie zuerst eine Eingabe.",
        "copyFailed": "Kopieren in Zwischenablage fehlgeschlagen. Bitte manuell kopieren."
      }
    }
  }
}
```

**Analog für:** `es.json`, `pt.json`, `fr.json`, `it.json`

---

## SEO-Block-Template (`seo`-Sektion in i18n-JSON)

Zusätzlich zum `tools`-Block benötigt jedes Tool einen `seo`-Block in allen 6 JSON-Dateien:

### Englisch (`config/i18n/en.json`)

```json
{
  "seo": {
    "myToolName": {
      "ogImage": "og-default.png",
      "applicationCategory": "UtilityApplication",
      "featureList": [
        "Feature description for structured data",
        "Another feature for search engines",
        "Privacy-first: all processing in browser"
      ],
      "keywords": "keyword1, keyword2, keyword3, webdev tool",
      "meta_title": "My Tool Name – Online Tool | WebDev-Tools",
      "meta_description": "SEO-optimized description (max 160 chars). Explains what the tool does and why it's useful."
    }
  }
}
```

**Hinweis:** `meta_title` und `meta_description` existieren sowohl im `tools`- als auch im `seo`-Block. Der `seo`-Block wird von `tool-base.php` für HTML-Meta-Tags und JSON-LD Schema verwendet.

---

## tools.php-Eintrag-Template

**Datei:** `config/tools.php`

```php
return [
  // ... existing tools

  // ============================================================================
  // My Tool Name
  // ============================================================================
  'myToolName' => [
    'id' => 'myToolName',
    'slug' => 'my-tool-name',
    'slugs' => [
      'en' => 'my-tool-name',
      'de' => 'mein-werkzeug-name',      // Übersetzen!
      'es' => 'mi-herramienta-nombre',   // Übersetzen!
      'pt' => 'minha-ferramenta-nome',   // Übersetzen!
      'fr' => 'mon-outil-nom',           // Übersetzen!
      'it' => 'mio-strumento-nome'       // Übersetzen!
    ],
    'category' => 'converters',  // encoders|formatters|generators|converters|references|stringtools|utilities
    'icon' => 'bi-gear',         // https://icons.getbootstrap.com/
    'jsModule' => 'tools/myToolNameTool.js',
    'jsLibraries' => [
      'clipboard-utils',
      'download-utils',
      'validators'
      // Optional: 'dragdrop-utils', 'formatters', 'wordlist', 'performance-guards'
    ],
    'features' => [
      'privacy-first',
      'live-mode'
      // Optional: 'drag-drop', 'bulk-processing', 'syntax-highlighting'
    ],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
    // Optional: 'hasAboutSection' => true
    // Optional: 'externalLibraries' => [['url' => '...', 'integrity' => 'sha384-...', 'crossorigin' => 'anonymous']]
  ]
];
```

---

## Jest-Test-Template

**Datei:** `tests/unit/myToolNameTool.test.js`

```javascript
describe('MyToolName', () => {
  let tool;

  // ==========================================================================
  // Setup & Teardown
  // ==========================================================================
  beforeAll(() => {
    // Mocks (if not in tests/setup.js)
    window.Tools = { register: jest.fn() };
    window.i18n = { t: jest.fn((key) => key) };
    window.ClipboardUtils = { copyToClipboard: jest.fn() };
    window.DownloadUtils = { downloadText: jest.fn() };

    // Load tool module
    require('../../assets/js/tools/myToolNameTool.js');
    
    // Extract registered tool
    tool = window.Tools.register.mock.calls[0][1];
  });

  beforeEach(() => {
    // Fresh DOM for each test
    document.body.innerHTML = '<div id="tool-container"></div>';
    
    // Clear mock calls
    jest.clearAllMocks();
  });

  // ==========================================================================
  // Initialization Tests
  // ==========================================================================
  describe('Initialization', () => {
    it('should register with correct tool ID', () => {
      expect(window.Tools.register).toHaveBeenCalledWith(
        'myToolName',
        expect.objectContaining({
          open: expect.any(Function)
        })
      );
    });

    it('should render UI on open()', () => {
      tool.open();
      
      const container = document.getElementById('tool-container');
      expect(container.innerHTML).toContain('input');
      expect(container.innerHTML).toContain('output');
      expect(document.getElementById('input')).toBeTruthy();
      expect(document.getElementById('output')).toBeTruthy();
    });

    it('should attach event listeners', () => {
      tool.open();
      
      const input = document.getElementById('input');
      const copyBtn = document.getElementById('copy-btn');
      const downloadBtn = document.getElementById('download-btn');
      
      expect(input).toBeTruthy();
      expect(copyBtn).toBeTruthy();
      expect(downloadBtn).toBeTruthy();
    });
  });

  // ==========================================================================
  // Core Functionality Tests
  // ==========================================================================
  describe('Core Functionality', () => {
    beforeEach(() => {
      tool.open();
    });

    it('should process valid input', () => {
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = 'test input';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('TEST INPUT');  // Adjust expected output
    });

    it('should handle empty input', () => {
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = '';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('');
    });

    it('should handle whitespace-only input', () => {
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = '   \n\t   ';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('');
    });

    it('should handle special characters', () => {
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = '!@#$%^&*()';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBeTruthy();
    });
  });

  // ==========================================================================
  // Error Handling Tests
  // ==========================================================================
  describe('Error Handling', () => {
    beforeEach(() => {
      tool.open();
    });

    it('should show error for invalid input', () => {
      const input = document.getElementById('input');
      const errorContainer = document.getElementById('error-container');

      input.value = 'INVALID_DATA';  // Adjust to trigger error
      input.dispatchEvent(new Event('input'));

      // Uncomment if your tool shows errors:
      // expect(errorContainer.classList.contains('d-none')).toBe(false);
      // expect(errorContainer.textContent).toBeTruthy();
    });

    it('should hide error on valid input', () => {
      const input = document.getElementById('input');
      const errorContainer = document.getElementById('error-container');

      // First: Trigger error
      input.value = 'INVALID';
      input.dispatchEvent(new Event('input'));

      // Then: Valid input
      input.value = 'valid';
      input.dispatchEvent(new Event('input'));

      expect(errorContainer.classList.contains('d-none')).toBe(true);
    });
  });

  // ==========================================================================
  // Copy Functionality Tests
  // ==========================================================================
  describe('Copy Functionality', () => {
    beforeEach(() => {
      tool.open();
    });

    it('should copy output to clipboard', () => {
      const output = document.getElementById('output');
      const copyBtn = document.getElementById('copy-btn');

      output.value = 'test output';
      copyBtn.click();

      expect(window.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(
        'test output',
        expect.any(Function),
        expect.any(Function)
      );
    });

    it('should not copy empty output', () => {
      const output = document.getElementById('output');
      const copyBtn = document.getElementById('copy-btn');

      output.value = '';
      copyBtn.click();

      // Should show error instead of copying
      expect(window.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
    });
  });

  // ==========================================================================
  // Download Functionality Tests
  // ==========================================================================
  describe('Download Functionality', () => {
    beforeEach(() => {
      tool.open();
    });

    it('should download output as file', () => {
      const output = document.getElementById('output');
      const downloadBtn = document.getElementById('download-btn');

      output.value = 'test output';
      downloadBtn.click();

      expect(window.DownloadUtils.downloadText).toHaveBeenCalledWith(
        'test output',
        expect.stringMatching(/mytool-output-.*\.txt/),
        'text/plain'
      );
    });

    it('should not download empty output', () => {
      const output = document.getElementById('output');
      const downloadBtn = document.getElementById('download-btn');

      output.value = '';
      downloadBtn.click();

      expect(window.DownloadUtils.downloadText).not.toHaveBeenCalled();
    });
  });

  // ==========================================================================
  // Clear Functionality Tests
  // ==========================================================================
  describe('Clear Functionality', () => {
    beforeEach(() => {
      tool.open();
    });

    it('should clear all inputs and outputs', () => {
      const input = document.getElementById('input');
      const output = document.getElementById('output');
      const clearBtn = document.getElementById('clear-btn');

      input.value = 'test input';
      output.value = 'test output';
      
      clearBtn.click();

      expect(input.value).toBe('');
      expect(output.value).toBe('');
    });
  });
});
```

---

## Quick Copy-Paste Workflow

### 1. Neue Tool-Dateien erstellen

```bash
# EN-Version
cp docs/techstack/templates/tool.php.template tool-name/index.php

# DE-Version
cp docs/techstack/templates/tool-de.php.template de/tool-name/index.php

# Weitere Sprachen analog...

# JavaScript
cp docs/techstack/templates/tool.js.template assets/js/tools/myToolNameTool.js

# Test
cp docs/techstack/templates/tool.test.js.template tests/unit/myToolNameTool.test.js
```

### 2. Platzhalter ersetzen

**Suchen & Ersetzen in allen Dateien:**
- `myToolName` → Actual camelCase ID
- `my-tool-name` → Actual kebab-case slug
- `My Tool Name` → Actual display name

### 3. Texte anpassen

- PHP: Features, Resources, Additional Sections individualisieren
- JS: Core-Logik in `transformInput()` implementieren
- i18n: Labels, Placeholders, Error-Messages übersetzen

---

**Siehe auch:**
- [CONVENTIONS.md](CONVENTIONS.md) – Naming & Struktur-Regeln
- [INTEGRATION.md](INTEGRATION.md) – Vollständige Integration-Checkliste
