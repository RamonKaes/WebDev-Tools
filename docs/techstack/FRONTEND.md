# Frontend – WebDev-Tools

**Vanilla JavaScript with IIFE Pattern** – No framework, maximum performance and security.

---

## JavaScript Architecture

### IIFE Pattern (Tool Modules)

Every tool is a self-registering module:

```javascript
(function() {
  'use strict';
  
  // Guard: Tools registry available?
  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'myToolName'})
      : '[myToolName] Tools registry not available.';
    console.warn(msg);
    return;
  }

  // i18n helper (module level, outside of open())
  const t = (key, params) => {
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(key, params);
    }
    return key.split('.').pop();
  };

  function init(container) {
    container.innerHTML = `
      <div class="tool-section">
        <label>${t('tools.myTool.inputLabel')}</label>
        <textarea id="input"></textarea>
      </div>
    `;
    
    // Register event listeners
    document.getElementById('input').addEventListener('input', handleInput);
  }

  // Registration in global Tools object
  window.Tools.register('myToolName', {
    init: function() {},   // Called automatically on register()
    open: init             // Called on tool invocation with container parameter
  });
})();
```

**Important:**
- `'use strict'` at the beginning of every IIFE
- Guard checks if `window.Tools` exists before registering
- `t()` as `const` at module level (not inside `open()`)
- `init: function(){}` + `open: init` – both methods are required
- `open(container)` receives the container as parameter
- `toolId` must match `config/tools.php` key

---

## Shared Utilities (`assets/js/lib/`)

### Clipboard Utils (`clipboard-utils.js`)

```javascript
window.ClipboardUtils.copyToClipboard(text, successCallback, errorCallback);
```

**Usage:**
```javascript
const copyBtn = document.getElementById('copy-btn');
copyBtn.addEventListener('click', () => {
  const text = document.getElementById('output').value;
  window.ClipboardUtils.copyToClipboard(
    text,
    () => console.log('Copied!'),
    (err) => console.error('Copy failed:', err)
  );
});
```

---

### Download Utils (`download-utils.js`)

```javascript
window.DownloadUtils.downloadText(content, filename, mimeType);
window.DownloadUtils.downloadBlob(blob, filename);
```

**Usage:**
```javascript
const downloadBtn = document.getElementById('download-btn');
downloadBtn.addEventListener('click', () => {
  const json = JSON.stringify(data, null, 2);
  window.DownloadUtils.downloadText(json, 'data.json', 'application/json');
});
```

---

### Drag & Drop Utils (`dragdrop-utils.js`)

Enables file upload via drag & drop:

```javascript
window.DragDropUtils.init(
  dropZoneElement,
  (file, content) => {
    // File successfully loaded
    console.log('File:', file.name, 'Content:', content);
  },
  (error) => {
    // Error handling
    console.error('Drop failed:', error);
  },
  {
    acceptedTypes: ['.json', '.txt'],  // Optional: file type restriction
    maxSizeMB: 10                      // Optional: max size
  }
);
```

---

### Validators (`validators.js`)

```javascript
window.Validators.isValidJSON(str);
window.Validators.isValidURL(str);
window.Validators.isValidEmail(str);
window.Validators.isValidHex(str);
```

**Usage:**
```javascript
const input = document.getElementById('json-input').value;
if (!window.Validators.isValidJSON(input)) {
  showError(t('tools.jsonFormatter.invalidJson'));
  return;
}
```

---

### Formatters (`formatters.js`)

```javascript
window.Formatters.formatJSON(jsonString, indent = 2);
window.Formatters.minifyJSON(jsonString);
window.Formatters.escapeHTML(str);
window.Formatters.unescapeHTML(str);
```

---

### Storage Utils (`storage-utils.js`)

Wrapper for localStorage with error handling:

```javascript
window.StorageUtils.set(key, value);
window.StorageUtils.get(key, defaultValue);
window.StorageUtils.remove(key);
window.StorageUtils.clear();
```

---

### Performance Guards (`performance-guards.js`)

Prevents rendering blocking on large inputs:

```javascript
window.PerformanceGuards.checkInputSize(text, maxChars = 1000000);
// Returns: { safe: boolean, sizeKB: number, message: string }
```

---

## Security Best Practices

### ❌ Never:
```javascript
// WRONG: innerHTML with user input
element.innerHTML = userInput;

// WRONG: eval() or new Function()
eval(userCode);

// WRONG: document.execCommand (deprecated)
document.execCommand('copy');
```

### ✅ Always:
```javascript
// CORRECT: textContent for user input
element.textContent = userInput;

// CORRECT: Clipboard API via ClipboardUtils
window.ClipboardUtils.copyToClipboard(text);

// CORRECT: DOMPurify for HTML (if necessary)
element.innerHTML = DOMPurify.sanitize(html);
```

---

## i18n Integration

### Retrieving UI strings

```javascript
function t(key, params) {
  return window.i18n.t(key, params);
}

// Usage
const label = t('tools.myTool.inputLabel');
const error = t('tools.myTool.errors.invalidInput', { maxLength: 1000 });
```

### JSON Structure (`config/i18n/{lang}.json`)

```json
{
  "tools": {
    "myTool": {
      "inputLabel": "Enter text",
      "outputLabel": "Result",
      "errors": {
        "invalidInput": "Invalid input (max {maxLength} chars)"
      }
    }
  }
}
```

**Rule:** Only JS UI strings (labels, buttons, error messages) in JSON – no PHP content!

---

## Event Handling

### Debouncing for Live Mode

```javascript
let debounceTimer;
inputElement.addEventListener('input', () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    processInput();
  }, 300); // 300ms delay
});
```

---

## CSS Framework

**Bootstrap 5.3** + Custom Sass:

```html
<!-- Tool Container -->
<div class="tool-section">
  <label class="form-label">Input</label>
  <textarea class="form-control" rows="8"></textarea>
  <button class="btn btn-primary mt-2">
    <i class="bi bi-clipboard"></i> Copy
  </button>
</div>
```

**Bootstrap Icons:**
- Via `<i class="bi bi-icon-name"></i>`
- Tool icons defined in `config/tools.php`

---

## Performance Tips

1. **Lazy Loading:** Tools are loaded only on invocation (tool-loader.js)
2. **Input Size Checks:** `PerformanceGuards.checkInputSize()` before processing
3. **Debouncing:** For live converters 300-500ms delay
4. **Web Workers:** For CPU-intensive tasks (e.g., hash generation)

---

**More Information:**
- [BACKEND.md](BACKEND.md) – PHP integration
- [TESTING.md](TESTING.md) – Frontend tests with Jest
