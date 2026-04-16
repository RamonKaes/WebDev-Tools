# Naming & Conventions – WebDev-Tools

**Konsistente Namensgebung & Code-Struktur** – Standards für alle Tools.

---

## Naming Conventions

### Tool-IDs

**Format:** `camelCase`

**Regeln:**
- Beschreibend, nicht zu kurz (min. 2 Wörter kombiniert)
- Keine Abkürzungen (außer etabliert wie `jwt`, `uuid`, `url`)
- Suffix vermeiden (kein `Tool`, `Converter` am Ende)

**Beispiele:**

| ✅ Richtig | ❌ Falsch | Grund |
|-----------|----------|-------|
| `base64EncoderDecoder` | `base64Tool` | Zu generisch |
| `jsonFormatterValidator` | `jsonFV` | Abkürzung unklar |
| `passwordGenerator` | `pwdGen` | Abkürzung, kein camelCase |
| `qrCodeGenerator` | `qrcode` | Zu kurz |
| `htmlEntityTool` | `htmlEntityToolConverter` | Redundantes Suffix |

---

### File & Folder Names

#### PHP-Dateien

**Format:** `kebab-case`

**Struktur:**
```
tool-name/index.php           # EN (root-level)
de/tool-name/index.php        # DE
es/tool-name/index.php        # ES
```

**Regeln:**
- Slug = File-Ordner-Name (ohne Sprach-Präfix)
- Immer `index.php` (kein Custom-Name)
- Keine Unterordner innerhalb Tool-Ordner

---

#### JavaScript-Dateien

**Format:** `camelCase` + `Tool.js` Suffix

**Struktur:**
```
assets/js/tools/myToolNameTool.js
```

**Regeln:**
- Dateiname = `toolId` + `Tool.js`
- MUSS mit Tool-ID in `config/tools.php` matchen
- Keine Unterordner in `tools/`

**Beispiele:**

| Tool-ID | JS-Dateiname |
|---------|--------------|
| `base64EncoderDecoder` | `base64EncoderDecoderTool.js` |
| `jsonFormatterValidator` | `jsonFormatterValidatorTool.js` |
| `passwordGenerator` | `passwordGeneratorTool.js` |

---

#### Test-Dateien

**Format:** `camelCase` + `Tool.test.js`

**Struktur:**
```
tests/unit/myToolNameTool.test.js
```

**Regel:** Exakt wie JS-Dateiname, aber `.test.js` statt `.js`

---

### URL-Slugs

**Format:** `kebab-case`

**Englisch (Default):**
- Beschreibend, SEO-freundlich
- 2-4 Wörter, keine Stopwords (`the`, `a`, etc.)
- Keine Verben (außer bei Generatoren/Convertern)

**Lokalisierte Slugs:**
- Übersetzung ins Ziel-Sprache
- Idiomatisch (nicht wörtlich)
- In `config/tools.php` unter `slugs` definiert

**Beispiele:**

| EN | DE | ES | PT |
|----|----|----|-----|
| `base64-encoder-decoder` | `base64-kodierer-dekodierer` | `base64-codificador-decodificador` | `base64-codificador-decodificador` |
| `password-generator` | `passwort-generator` | `generador-contrasenas` | `gerador-senhas` |
| `qr-code-generator` | `qr-code-generator` | `generador-codigo-qr` | `gerador-codigo-qr` |

---

### i18n-Keys

**Format:** Hierarchisch, dot-notation

**Struktur:**
```
tools.{toolId}.{category}.{key}
```

**Kategorien:**
- `meta_title`, `meta_description` (SEO)
- `{elementName}Label`, `{elementName}Placeholder` (UI)
- `errors.{errorType}` (Fehlermeldungen)
- `messages.{messageType}` (Success/Info-Messages)

**Beispiele:**

```json
{
  "tools": {
    "passwordGenerator": {
      "meta_title": "Password Generator - WebDev-Tools",
      "meta_description": "Generate secure passwords...",
      "lengthLabel": "Password Length",
      "optionsLabel": "Options",
      "includeUppercase": "Include uppercase letters",
      "errors": {
        "lengthTooShort": "Length must be at least {min}",
        "noCharactersSelected": "Please select at least one character type"
      },
      "messages": {
        "copied": "Password copied to clipboard!",
        "generated": "New password generated"
      }
    }
  }
}
```

**Naming-Rules für Keys:**
- Element-Labels: `{elementId}Label` (z.B. `inputLabel`, `outputLabel`)
- Placeholders: `{elementId}Placeholder`
- Hints: `{elementId}Hint`
- Options/Checkboxes: Beschreibend (z.B. `includeUppercase`, `enableLiveMode`)
- Errors: `errors.{errorType}` (z.B. `errors.invalidInput`)

---

## Code-Struktur

### PHP-Datei-Struktur

**Standard-Reihenfolge (immer identisch):**

```php
<?php
declare(strict_types=1);  // ← IMMER erste Zeile

// 1. Tool Configuration
$toolId = 'myToolName';
$lang = 'en';

// 2. Features Section
$featuresSectionTitle = 'Features';
$features = [ /* ... */ ];

// 3. Resources Section
$resourcesSectionTitle = 'Useful Resources';
$usefulResources = [ /* ... */ ];

// 4. Additional Sections (Optional)
// $additionalSections = [ /* ... */ ];

// 5. Custom Notice (Optional)
// $customNoticeContent = '...';
// $customNoticeType = 'info';

// 6. Load Base Layout
require_once __DIR__ . '/../partials/tool-base.php';
```

**Wichtig:**
- Kommentare für Sections (bessere Lesbarkeit)
- Optional-Bereiche auskommentiert (nicht löschen, als Template)
- Kein zusätzlicher Code nach `require_once`

---

### JavaScript-Datei-Struktur

**Standard-Reihenfolge:**

```javascript
/**
 * Tool Name - Brief description
 */

(function() {
  'use strict';

  // ==========================================================================
  // 1. i18n Helper
  // ==========================================================================
  function t(key, params) { /* ... */ }

  // ==========================================================================
  // 2. Tool Initialization
  // ==========================================================================
  function init() { /* ... */ }

  // ==========================================================================
  // 3. Event Listeners
  // ==========================================================================
  function attachEventListeners() { /* ... */ }

  // ==========================================================================
  // 4. Core Functionality
  // ==========================================================================
  function handleInput() { /* ... */ }
  function transformInput(input) { /* ... */ }
  function validateInput(input) { /* ... */ }

  // ==========================================================================
  // 5. Error Handling
  // ==========================================================================
  function showError(message) { /* ... */ }
  function hideError() { /* ... */ }

  // ==========================================================================
  // 6. Utility Functions (Copy, Download, Clear)
  // ==========================================================================
  function copyOutput() { /* ... */ }
  function downloadOutput() { /* ... */ }
  function clearAll() { /* ... */ }

  // ==========================================================================
  // 7. Tool Registration
  // ==========================================================================
  window.Tools.register('myToolName', { open: init });

})();
```

**Wichtig:**
- Kommentar-Trennlinien (`// ====...`) für Sections
- Funktionen gruppiert nach Zweck
- `init()` immer vor Event-Handlern
- `register()` immer als letztes

---

### Test-Datei-Struktur

**Standard-Reihenfolge:**

```javascript
describe('ToolName', () => {
  let tool;

  // 1. Setup & Teardown
  beforeAll(() => { /* ... */ });
  beforeEach(() => { /* ... */ });
  afterEach(() => { /* ... */ });  // Optional

  // 2. Initialization Tests
  describe('Initialization', () => {
    it('should register with correct tool ID', () => { /* ... */ });
    it('should render UI on open()', () => { /* ... */ });
  });

  // 3. Core Functionality Tests
  describe('Core Functionality', () => {
    it('should process valid input', () => { /* ... */ });
    it('should handle empty input', () => { /* ... */ });
  });

  // 4. Error Handling Tests
  describe('Error Handling', () => {
    it('should show error for invalid input', () => { /* ... */ });
  });

  // 5. Copy/Download/Clear Tests
  describe('Copy Functionality', () => { /* ... */ });
  describe('Download Functionality', () => { /* ... */ });
  describe('Clear Functionality', () => { /* ... */ });
});
```

---

## CSS & Styling

### Bootstrap-Klassen (bevorzugt)

**Standard-UI-Komponenten:**

| Element | Klassen |
|---------|---------|
| **Section** | `tool-section` (Custom-Klasse für Spacing) |
| **Label** | `form-label` |
| **Input/Textarea** | `form-control` |
| **Checkbox** | `form-check`, `form-check-input`, `form-check-label` |
| **Radio** | `form-check`, `form-check-input`, `form-check-label` |
| **Select** | `form-select` |
| **Button (Primary)** | `btn btn-primary` oder `btn btn-outline-primary` |
| **Button (Secondary)** | `btn btn-secondary` oder `btn btn-outline-secondary` |
| **Button (Danger)** | `btn btn-danger` oder `btn btn-outline-danger` |
| **Button Group** | `button-group mt-2` (Custom-Wrapper) |
| **Alert (Error)** | `alert alert-danger` |
| **Alert (Warning)** | `alert alert-warning` |
| **Alert (Info)** | `alert alert-info` |
| **Alert (Success)** | `alert alert-success` |

---

### Custom-CSS (nur wenn nötig)

**Regel:** Bootstrap-First, Custom nur für spezifische Fälle.

**Erlaubt:**
- `.tool-section` (Standard-Spacing zwischen Sektionen)
- `.button-group` (Button-Layout)
- Tool-spezifische Klassen (z.B. `.json-tree`, `.color-preview`)

**Verboten:**
- Inline-Styles in HTML (CSP-Violation)
- `!important` (außer Override von Bootstrap-Bugs)
- ID-Selektoren in CSS (nur für JS-Interaktion nutzen)

---

### Icon-Conventions

**Bootstrap Icons:** Immer mit `bi bi-{icon-name}`

**Standard-Icons:**

| Aktion | Icon | Klasse |
|--------|------|--------|
| **Copy** | Clipboard | `bi bi-clipboard` |
| **Download** | Download | `bi bi-download` |
| **Clear** | X-Circle | `bi bi-x-circle` |
| **Info** | Info-Circle | `bi bi-info-circle` |
| **Warning** | Exclamation-Triangle | `bi bi-exclamation-triangle` |
| **Success** | Check-Circle | `bi bi-check-circle` |
| **Settings** | Gear | `bi bi-gear` |
| **Upload** | Upload | `bi bi-upload` |
| **File** | File-Earmark | `bi bi-file-earmark` |

**Tool-Kategorie-Icons (in `config/tools.php`):**

| Kategorie | Beispiel-Icons |
|-----------|----------------|
| **Encoders** | `bi-file-binary`, `bi-code-square` |
| **Formatters** | `bi-filetype-json`, `bi-code-square` |
| **Generators** | `bi-key`, `bi-qr-code`, `bi-hash` |
| **Converters** | `bi-arrow-left-right`, `bi-shuffle` |
| **References** | `bi-book`, `bi-list-ul` |

---

## Variable & Function Naming

### JavaScript

**Variablen:**
- `camelCase` für normale Variablen
- `UPPER_SNAKE_CASE` für Konstanten (nur echte Konstanten, nicht Config)
- Beschreibend, nicht zu kurz

```javascript
// ✅ Richtig
const inputElement = document.getElementById('input');
const maxPasswordLength = 128;
const MAX_FILE_SIZE_MB = 10;  // Echte Konstante

// ❌ Falsch
const inp = document.getElementById('input');  // Zu kurz
const maxPwdLen = 128;  // Abkürzung
const max_file_size_mb = 10;  // snake_case statt camelCase
```

**Funktionen:**
- `camelCase`
- Verb am Anfang (außer `init`)
- Beschreibend, klar

```javascript
// ✅ Richtig
function handleInput() { }
function transformData(input) { }
function validateEmail(email) { }
function showError(message) { }

// ❌ Falsch
function input() { }  // Nicht beschreibend
function data(input) { }  // Kein Verb
function chkEmail(email) { }  // Abkürzung
```

---

### PHP

**Variablen:**
- `camelCase` für normale Variablen
- `$UPPER_CASE` für Konstanten (via `define()`)

```php
// ✅ Richtig
$toolId = 'myToolName';
$featuresSectionTitle = 'Features';

// ❌ Falsch
$tool_id = 'myToolName';  // snake_case
$TOOL_ID = 'myToolName';  // Nur für Konstanten
```

**Funktionen:**
- `camelCase` (Helper-Funktionen)
- `snake_case` (Legacy-Code, wird zu camelCase migriert)

```php
// ✅ Richtig
function escapeHtml(string $str): string { }
function loadToolConfig(string $id): ?array { }

// ❌ Falsch
function escape_html(string $str): string { }  // Legacy
function LoadToolConfig(string $id): ?array { }  // PascalCase
```

---

## Accessibility (a11y)

### ARIA-Labels

**Pflicht für:**
- Inputs ohne sichtbares Label
- Icon-Only-Buttons
- Dynamische Inhalte (Live-Regions)

```html
<!-- ✅ Richtig -->
<textarea id="input" aria-label="Input text"></textarea>
<button aria-label="Copy to clipboard">
  <i class="bi bi-clipboard"></i>
</button>

<!-- ❌ Falsch -->
<textarea id="input"></textarea>  <!-- Kein Label -->
<button><i class="bi bi-clipboard"></i></button>  <!-- Icon ohne Label -->
```

---

### Keyboard-Navigation

**Pflicht:**
- Alle interaktiven Elemente via Tab erreichbar
- Enter/Space für Buttons
- Escape für Modals/Dialogs (falls vorhanden)

**Tab-Order:**
1. Input
2. Options/Checkboxes
3. Output (readonly, aber fokussierbar)
4. Action-Buttons (Copy, Download, Clear)

```javascript
// Optionale Keyboard-Shortcuts
document.addEventListener('keydown', (e) => {
  // Ctrl+Enter: Submit/Process
  if (e.ctrlKey && e.key === 'Enter') {
    handleInput();
  }
  
  // Ctrl+C: Copy Output (wenn Output fokussiert)
  if (e.ctrlKey && e.key === 'c' && document.activeElement.id === 'output') {
    copyOutput();
  }
});
```

---

### Semantisches HTML

**Pflicht:**
- `<label for="...">` für alle Inputs
- `<button>` statt `<div onclick="...">`
- `role="alert"` für Error-Messages

```html
<!-- ✅ Richtig -->
<label for="input" class="form-label">Input</label>
<textarea id="input"></textarea>

<button id="copy-btn">Copy</button>

<div role="alert" class="alert alert-danger">Error message</div>

<!-- ❌ Falsch -->
<div>Input</div>  <!-- Kein <label> -->
<textarea></textarea>

<div onclick="copy()">Copy</div>  <!-- Kein <button> -->

<div class="alert alert-danger">Error</div>  <!-- Kein role="alert" -->
```

---

## Error Handling Patterns

### Standardisierte Fehlerbehandlung

**Pattern:**
1. **Validation-Fehler** → User-freundliche Message
2. **Processing-Fehler** → Generische Message + Console-Log
3. **System-Fehler** → Fallback-Message

```javascript
function handleInput() {
  try {
    // 1. Validation
    if (!validateInput(input)) {
      showError(t('tools.myTool.errors.invalidInput'));
      return;
    }

    // 2. Processing
    const result = transformInput(input);
    output.value = result;
    hideError();

  } catch (error) {
    // 3. System-Error
    console.error('Processing error:', error);
    showError(t('tools.myTool.errors.processingFailed'));
  }
}
```

---

### Error-Message-Kategorien

| Kategorie | Beispiel-Key | Wann verwenden |
|-----------|--------------|----------------|
| **Validation** | `errors.invalidInput` | Format-Fehler, fehlende Daten |
| **Size-Limit** | `errors.inputTooLarge` | Performance-Guards |
| **Processing** | `errors.processingFailed` | Unerwartete Exceptions |
| **Action-Failed** | `errors.copyFailed` | Clipboard/Download fehlgeschlagen |
| **Empty-State** | `errors.nothingToCopy` | User-Aktion ohne Daten |

---

## Performance Best Practices

### Input-Size-Guards

**IMMER vor CPU-intensiven Operationen:**

```javascript
function handleInput() {
  const input = document.getElementById('input').value;

  // Size-Check
  if (window.PerformanceGuards) {
    const sizeCheck = window.PerformanceGuards.checkInputSize(input, 10000000);
    if (!sizeCheck.safe) {
      showError(t('tools.myTool.errors.inputTooLarge', {
        maxSize: '10 MB'
      }));
      return;
    }
  }

  // Weiter mit Processing...
}
```

---

### Debouncing für Live-Mode

**Pattern:**

```javascript
let debounceTimer;

function handleInput() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    processInput();
  }, 300);  // 300ms Standard-Delay
}
```

---

## Security Best Practices

### XSS-Prevention

**Regel:** `textContent` für User-Input, `innerHTML` nur für vertrauenswürdige Daten

```javascript
// ✅ Richtig
element.textContent = userInput;
element.innerText = userInput;

// ❌ NIEMALS
element.innerHTML = userInput;  // XSS-Risiko!
```

---

### Input-Sanitization

**IMMER Null-Bytes entfernen:**

```javascript
function sanitizeInput(input) {
  return input.replace(/\0/g, '');
}
```

---

**Weitere Infos:**
- [TEMPLATES.md](TEMPLATES.md) – Code-Templates
- [SECURITY.md](SECURITY.md) – Security-Details
- [FRONTEND.md](FRONTEND.md) – JavaScript-Utilities
