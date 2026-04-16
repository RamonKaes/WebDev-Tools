# Frontend – WebDev-Tools

**Vanilla JavaScript mit IIFE-Pattern** – Kein Framework, maximale Performance und Sicherheit.

---

## JavaScript-Architektur

### IIFE-Pattern (Tool-Module)

Jedes Tool ist ein selbstregistrierendes Modul:

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

  // i18n-Helper (Modul-Ebene, außerhalb von open())
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
    
    // Event-Listener registrieren
    document.getElementById('input').addEventListener('input', handleInput);
  }

  // Registrierung im globalen Tools-Objekt
  window.Tools.register('myToolName', {
    init: function() {},   // Wird automatisch bei register() aufgerufen
    open: init             // Wird bei Tool-Aufruf mit container-Parameter aufgerufen
  });
})();
```

**Wichtig:**
- `'use strict'` am Anfang jeder IIFE
- Guard prüft ob `window.Tools` existiert, bevor registriert wird
- `t()` als `const` auf Modul-Ebene (nicht innerhalb `open()`)
- `init: function(){}` + `open: init` – beide Methoden werden benötigt
- `open(container)` erhält den Container als Parameter
- `toolId` muss `config/tools.php`-Key matchen

---

## Gemeinsame Utilities (`assets/js/lib/`)

### Clipboard Utils (`clipboard-utils.js`)

```javascript
window.ClipboardUtils.copyToClipboard(text, successCallback, errorCallback);
```

**Verwendung:**
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

**Verwendung:**
```javascript
const downloadBtn = document.getElementById('download-btn');
downloadBtn.addEventListener('click', () => {
  const json = JSON.stringify(data, null, 2);
  window.DownloadUtils.downloadText(json, 'data.json', 'application/json');
});
```

---

### Drag & Drop Utils (`dragdrop-utils.js`)

Ermöglicht File-Upload via Drag & Drop:

```javascript
window.DragDropUtils.init(
  dropZoneElement,
  (file, content) => {
    // File erfolgreich geladen
    console.log('File:', file.name, 'Content:', content);
  },
  (error) => {
    // Fehlerbehandlung
    console.error('Drop failed:', error);
  },
  {
    acceptedTypes: ['.json', '.txt'],  // Optional: File-Type-Beschränkung
    maxSizeMB: 10                      // Optional: Max-Größe
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

**Verwendung:**
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

Wrapper für localStorage mit Fehlerbehandlung:

```javascript
window.StorageUtils.set(key, value);
window.StorageUtils.get(key, defaultValue);
window.StorageUtils.remove(key);
window.StorageUtils.clear();
```

---

### Performance Guards (`performance-guards.js`)

Verhindert Rendering-Blockierung bei großen Inputs:

```javascript
window.PerformanceGuards.checkInputSize(text, maxChars = 1000000);
// Returns: { safe: boolean, sizeKB: number, message: string }
```

---

## Sicherheits-Best Practices

### ❌ Niemals:
```javascript
// FALSCH: innerHTML mit User-Input
element.innerHTML = userInput;

// FALSCH: eval() oder new Function()
eval(userCode);

// FALSCH: document.execCommand (deprecated)
document.execCommand('copy');
```

### ✅ Immer:
```javascript
// RICHTIG: textContent für User-Input
element.textContent = userInput;

// RICHTIG: Clipboard API via ClipboardUtils
window.ClipboardUtils.copyToClipboard(text);

// RICHTIG: DOMPurify für HTML (falls notwendig)
element.innerHTML = DOMPurify.sanitize(html);
```

---

## i18n-Integration

### UI-Strings abrufen

```javascript
function t(key, params) {
  return window.i18n.t(key, params);
}

// Verwendung
const label = t('tools.myTool.inputLabel');
const error = t('tools.myTool.errors.invalidInput', { maxLength: 1000 });
```

### JSON-Struktur (`config/i18n/{lang}.json`)

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

**Regel:** Nur JS-UI-Strings (Labels, Buttons, Fehlermeldungen) in JSON – kein PHP-Content!

---

## Event-Handling

### Debouncing für Live-Mode

```javascript
let debounceTimer;
inputElement.addEventListener('input', () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    processInput();
  }, 300); // 300ms Delay
});
```

---

## CSS-Framework

**Bootstrap 5.3** + Custom Sass:

```html
<!-- Tool-Container -->
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
- Tool-Icons in `config/tools.php` definiert

---

## Performance-Tipps

1. **Lazy Loading:** Tools werden erst bei Aufruf geladen (tool-loader.js)
2. **Input-Size-Checks:** `PerformanceGuards.checkInputSize()` vor Verarbeitung
3. **Debouncing:** Bei Live-Convertern 300-500ms Delay
4. **Web Workers:** Für CPU-intensive Tasks (z.B. Hash-Generierung)

---

**Weitere Infos:**
- [BACKEND.md](BACKEND.md) – PHP-Integration
- [TESTING.md](TESTING.md) – Frontend-Tests mit Jest
