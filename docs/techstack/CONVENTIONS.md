# Naming & Conventions – WebDev-Tools

**Consistent naming and code structure standards** for all tools.

---

## Naming Conventions

### Tool IDs

**Format:** `camelCase`

**Rules:**
- Descriptive, not too short (minimum 2 combined words)
- No abbreviations (except established ones like `jwt`, `uuid`, `url`)
- Avoid suffixes (no `Tool`, `Converter` at the end)

**Examples:**

| ✅ Correct | ❌ Wrong | Reason |
|-----------|----------|--------|
| `base64EncoderDecoder` | `base64Tool` | Too generic |
| `jsonFormatterValidator` | `jsonFV` | Unclear abbreviation |
| `passwordGenerator` | `pwdGen` | Abbreviation, not camelCase |
| `qrCodeGenerator` | `qrcode` | Too short |
| `htmlEntityTool` | `htmlEntityToolConverter` | Redundant suffix |

---

### File & Folder Names

#### PHP Files

**Format:** `kebab-case`

**Structure:**
```
tool-name/index.php           # EN (root-level)
de/tool-name/index.php        # DE
es/tool-name/index.php        # ES
```

**Rules:**
- Slug = folder name (without language prefix)
- Always `index.php` (no custom name)
- No subfolders within tool folders

---

#### JavaScript Files

**Format:** `camelCase` + `Tool.js` suffix

**Structure:**
```
assets/js/tools/myToolNameTool.js
```

**Rules:**
- Filename = `toolId` + `Tool.js`
- MUST match tool ID in `config/tools.php`
- No subfolders in `tools/`

**Examples:**

| Tool ID | JS Filename |
|---------|-------------|
| `base64EncoderDecoder` | `base64EncoderDecoderTool.js` |
| `jsonFormatterValidator` | `jsonFormatterValidatorTool.js` |
| `passwordGenerator` | `passwordGeneratorTool.js` |

---

#### Test Files

**Format:** `camelCase` + `Tool.test.js`

**Structure:**
```
tests/unit/myToolNameTool.test.js
```

**Rule:** Exactly like JS filename, but `.test.js` instead of `.js`

---

### URL Slugs

**Format:** `kebab-case`

**English (Default):**
- Descriptive, SEO-friendly
- 2-4 words, no stop words (`the`, `a`, etc.)
- No verbs (except for generators/converters)

**Localized Slugs:**
- Translation into target language
- Idiomatic (not literal)
- Defined in `config/tools.php` under `slugs`

**Examples:**

| EN | DE | ES | PT |
|----|----|----|-----|
| `base64-encoder-decoder` | `base64-kodierer-dekodierer` | `base64-codificador-decodificador` | `base64-codificador-decodificador` |
| `password-generator` | `passwort-generator` | `generador-contrasenas` | `gerador-senhas` |
| `qr-code-generator` | `qr-code-generator` | `generador-codigo-qr` | `gerador-codigo-qr` |

---

### i18n Keys

**Format:** Hierarchical, dot-notation

**Structure:**
```
tools.{toolId}.{category}.{key}
```

**Categories:**
- `meta_title`, `meta_description` (SEO)
- `{elementName}Label`, `{elementName}Placeholder` (UI)
- `errors.{errorType}` (Error messages)
- `messages.{messageType}` (Success/Info messages)

**Examples:**

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

**Naming Rules for Keys:**
- Element labels: `{elementId}Label` (e.g., `inputLabel`, `outputLabel`)
- Placeholders: `{elementId}Placeholder`
- Hints: `{elementId}Hint`
- Options/Checkboxes: Descriptive (e.g., `includeUppercase`, `enableLiveMode`)
- Errors: `errors.{errorType}` (e.g., `errors.invalidInput`)

---

## Code Structure

### PHP File Structure

**Standard order (always identical):**

```php
<?php
declare(strict_types=1);  // ← ALWAYS first line

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

**Important:**
- Section comments (better readability)
- Optional areas commented out (don't delete, keep as template)
- No additional code after `require_once`

---

### JavaScript File Structure

**Standard order:**

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

**Important:**
- Comment separator lines (`// ====...`) for sections
- Functions grouped by purpose
- `init()` always before event handlers
- `register()` always last

---

### Test File Structure

**Standard order:**

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

### Bootstrap Classes (Preferred)

**Standard UI Components:**

| Element | Classes |
|---------|---------|
| **Section** | `tool-section` (custom class for spacing) |
| **Label** | `form-label` |
| **Input/Textarea** | `form-control` |
| **Checkbox** | `form-check`, `form-check-input`, `form-check-label` |
| **Radio** | `form-check`, `form-check-input`, `form-check-label` |
| **Select** | `form-select` |
| **Button (Primary)** | `btn btn-primary` or `btn btn-outline-primary` |
| **Button (Secondary)** | `btn btn-secondary` or `btn btn-outline-secondary` |
| **Button (Danger)** | `btn btn-danger` or `btn btn-outline-danger` |
| **Button Group** | `button-group mt-2` (custom wrapper) |
| **Alert (Error)** | `alert alert-danger` |
| **Alert (Warning)** | `alert alert-warning` |
| **Alert (Info)** | `alert alert-info` |
| **Alert (Success)** | `alert alert-success` |

---

### Custom CSS (Only When Necessary)

**Rule:** Bootstrap-first, custom only for specific cases.

**Allowed:**
- `.tool-section` (standard spacing between sections)
- `.button-group` (button layout)
- Tool-specific classes (e.g., `.json-tree`, `.color-preview`)

**Forbidden:**
- Inline styles in HTML (CSP violation)
- `!important` (except override of Bootstrap bugs)
- ID selectors in CSS (use only for JS interaction)

---

### Icon Conventions

**Bootstrap Icons:** Always with `bi bi-{icon-name}`

**Standard Icons:**

| Action | Icon | Class |
|--------|------|-------|
| **Copy** | Clipboard | `bi bi-clipboard` |
| **Download** | Download | `bi bi-download` |
| **Clear** | X-Circle | `bi bi-x-circle` |
| **Info** | Info-Circle | `bi bi-info-circle` |
| **Warning** | Exclamation-Triangle | `bi bi-exclamation-triangle` |
| **Success** | Check-Circle | `bi bi-check-circle` |
| **Settings** | Gear | `bi bi-gear` |
| **Upload** | Upload | `bi bi-upload` |
| **File** | File-Earmark | `bi bi-file-earmark` |

**Tool Category Icons (in `config/tools.php`):**

| Category | Example Icons |
|----------|---------------|
| **Encoders** | `bi-file-binary`, `bi-code-square` |
| **Formatters** | `bi-filetype-json`, `bi-code-square` |
| **Generators** | `bi-key`, `bi-qr-code`, `bi-hash` |
| **Converters** | `bi-arrow-left-right`, `bi-shuffle` |
| **References** | `bi-book`, `bi-list-ul` |

---

## Variable & Function Naming

### JavaScript

**Variables:**
- `camelCase` for regular variables
- `UPPER_SNAKE_CASE` for constants (only true constants, not config)
- Descriptive, not too short

```javascript
// ✅ Correct
const inputElement = document.getElementById('input');
const maxPasswordLength = 128;
const MAX_FILE_SIZE_MB = 10;  // True constant

// ❌ Wrong
const inp = document.getElementById('input');  // Too short
const maxPwdLen = 128;  // Abbreviation
const max_file_size_mb = 10;  // snake_case instead of camelCase
```

**Functions:**
- `camelCase`
- Verb at beginning (except `init`)
- Descriptive, clear

```javascript
// ✅ Correct
function handleInput() { }
function transformData(input) { }
function validateEmail(email) { }
function showError(message) { }

// ❌ Wrong
function input() { }  // Not descriptive
function data(input) { }  // No verb
function chkEmail(email) { }  // Abbreviation
```

---

### PHP

**Variables:**
- `camelCase` for regular variables
- `$UPPER_CASE` for constants (via `define()`)

```php
// ✅ Correct
$toolId = 'myToolName';
$featuresSectionTitle = 'Features';

// ❌ Wrong
$tool_id = 'myToolName';  // snake_case
$TOOL_ID = 'myToolName';  // Only for constants
```

**Functions:**
- `camelCase` (helper functions)
- `snake_case` (legacy code, migrating to camelCase)

```php
// ✅ Correct
function escapeHtml(string $str): string { }
function loadToolConfig(string $id): ?array { }

// ❌ Wrong
function escape_html(string $str): string { }  // Legacy
function LoadToolConfig(string $id): ?array { }  // PascalCase
```

---

## Accessibility (a11y)

### ARIA Labels

**Required for:**
- Inputs without visible label
- Icon-only buttons
- Dynamic content (live regions)

```html
<!-- ✅ Correct -->
<textarea id="input" aria-label="Input text"></textarea>
<button aria-label="Copy to clipboard">
  <i class="bi bi-clipboard"></i>
</button>

<!-- ❌ Wrong -->
<textarea id="input"></textarea>  <!-- No label -->
<button><i class="bi bi-clipboard"></i></button>  <!-- Icon without label -->
```

---

### Keyboard Navigation

**Required:**
- All interactive elements reachable via Tab
- Enter/Space for buttons
- Escape for modals/dialogs (if present)

**Tab Order:**
1. Input
2. Options/Checkboxes
3. Output (readonly, but focusable)
4. Action buttons (Copy, Download, Clear)

```javascript
// Optional keyboard shortcuts
document.addEventListener('keydown', (e) => {
  // Ctrl+Enter: Submit/Process
  if (e.ctrlKey && e.key === 'Enter') {
    handleInput();
  }
  
  // Ctrl+C: Copy output (when output focused)
  if (e.ctrlKey && e.key === 'c' && document.activeElement.id === 'output') {
    copyOutput();
  }
});
```

---

### Semantic HTML

**Required:**
- `<label for="...">` for all inputs
- `<button>` instead of `<div onclick="...">`
- `role="alert"` for error messages

```html
<!-- ✅ Correct -->
<label for="input" class="form-label">Input</label>
<textarea id="input"></textarea>

<button id="copy-btn">Copy</button>

<div role="alert" class="alert alert-danger">Error message</div>

<!-- ❌ Wrong -->
<div>Input</div>  <!-- No <label> -->
<textarea></textarea>

<div onclick="copy()">Copy</div>  <!-- No <button> -->

<div class="alert alert-danger">Error</div>  <!-- No role="alert" -->
```

---

## Error Handling Patterns

### Standardized Error Handling

**Pattern:**
1. **Validation errors** → User-friendly message
2. **Processing errors** → Generic message + console log
3. **System errors** → Fallback message

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
    // 3. System error
    console.error('Processing error:', error);
    showError(t('tools.myTool.errors.processingFailed'));
  }
}
```

---

### Error Message Categories

| Category | Example Key | When to Use |
|----------|-------------|-------------|
| **Validation** | `errors.invalidInput` | Format errors, missing data |
| **Size Limit** | `errors.inputTooLarge` | Performance guards |
| **Processing** | `errors.processingFailed` | Unexpected exceptions |
| **Action Failed** | `errors.copyFailed` | Clipboard/download failed |
| **Empty State** | `errors.nothingToCopy` | User action without data |

---

## Performance Best Practices

### Input Size Guards

**ALWAYS before CPU-intensive operations:**

```javascript
function handleInput() {
  const input = document.getElementById('input').value;

  // Size check
  if (window.PerformanceGuards) {
    const sizeCheck = window.PerformanceGuards.checkInputSize(input, 10000000);
    if (!sizeCheck.safe) {
      showError(t('tools.myTool.errors.inputTooLarge', {
        maxSize: '10 MB'
      }));
      return;
    }
  }

  // Continue with processing...
}
```

---

### Debouncing for Live Mode

**Pattern:**

```javascript
let debounceTimer;

function handleInput() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    processInput();
  }, 300);  // 300ms standard delay
}
```

---

## Security Best Practices

### XSS Prevention

**Rule:** `textContent` for user input, `innerHTML` only for trusted data

```javascript
// ✅ Correct
element.textContent = userInput;
element.innerText = userInput;

// ❌ NEVER
element.innerHTML = userInput;  // XSS risk!
```

---

### Input Sanitization

**ALWAYS remove null bytes:**

```javascript
function sanitizeInput(input) {
  return input.replace(/\0/g, '');
}
```

---

**More Information:**
- [TEMPLATES.md](TEMPLATES.md) – Code templates
- [SECURITY.md](SECURITY.md) – Security details
- [FRONTEND.md](FRONTEND.md) – JavaScript utilities
