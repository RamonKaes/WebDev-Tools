# Testing – WebDev-Tools

**Jest 30 with jsdom** – 841 tests, 20 suites, unit tests for all tools.

---

## Test Commands

```bash
# Run all tests
npm test

# Watch mode (during development)
npm run test:watch

# Coverage report
npm run test:coverage
```

---

## Jest Configuration (`jest.config.js`)

```javascript
module.exports = {
  testEnvironment: 'jsdom',           // Simulate browser environment
  testMatch: ['**/tests/unit/**/*.test.js'],
  collectCoverageFrom: [
    'assets/js/tools/**/*.js',
    'assets/js/lib/**/*.js',
    '!assets/js/lib/external/**'      // Exclude external libraries
  ],
  coverageThreshold: {
    global: {
      branches: 70,
      functions: 80,
      lines: 80,
      statements: 80
    }
  },
  setupFilesAfterEnv: ['<rootDir>/tests/unit/setup.js']
};
```

---

## Test Setup (`tests/unit/setup.js`)

Global mocks for all tests:

```javascript
// i18n-Mock
global.window.i18n = {
  t: jest.fn((key, params) => {
    // Simple template string replacement
    let str = key;
    if (params) {
      Object.keys(params).forEach(k => {
        str = str.replace(`{${k}}`, params[k]);
      });
    }
    return str;
  })
};

// Tools-Registry-Mock
global.window.Tools = {
  _tools: {},
  register: jest.fn((id, tool) => {
    global.window.Tools._tools[id] = tool;
  }),
  get: jest.fn((id) => {
    return global.window.Tools._tools[id];
  })
};

// ClipboardUtils-Mock
global.window.ClipboardUtils = {
  copyToClipboard: jest.fn((text, onSuccess, onError) => {
    if (onSuccess) onSuccess();
  })
};

// DownloadUtils-Mock
global.window.DownloadUtils = {
  downloadText: jest.fn((content, filename, mimeType) => {}),
  downloadBlob: jest.fn((blob, filename) => {})
};

// DragDropUtils-Mock
global.window.DragDropUtils = {
  init: jest.fn((dropZone, onSuccess, onError, options) => {})
};

// Validators-Mock
global.window.Validators = {
  isValidJSON: jest.fn((str) => {
    try {
      JSON.parse(str);
      return true;
    } catch {
      return false;
    }
  }),
  isValidURL: jest.fn((str) => {
    try {
      new URL(str);
      return true;
    } catch {
      return false;
    }
  })
};

// Performance-Mocks
global.window.performance = {
  now: jest.fn(() => Date.now())
};
```

---

## Test Pattern (Tool Tests)

### Basic Structure

```javascript
describe('MyTool', () => {
  let tool;

  beforeAll(() => {
    // Mocks initialisieren (falls nicht in setup.js)
    window.Tools = { register: jest.fn() };
    window.i18n = { t: jest.fn(key => key) };
    window.ClipboardUtils = { copyToClipboard: jest.fn() };
    window.DownloadUtils = { downloadText: jest.fn() };

    // Tool-Modul laden
    require('../../assets/js/tools/myToolTool.js');
    tool = window.Tools.register.mock.calls[0][1];
  });

  beforeEach(() => {
    // Test-Container anlegen
    document.body.innerHTML = '<div id="tool-container"></div>';
  });

  describe('Initialization', () => {
    it('should register with correct tool ID', () => {
      expect(window.Tools.register).toHaveBeenCalledWith(
        'myTool',
        expect.objectContaining({ open: expect.any(Function) })
      );
    });

    it('should render UI on open()', () => {
      tool.open();
      const container = document.getElementById('tool-container');
      expect(container.innerHTML).toContain('input');
      expect(container.innerHTML).toContain('output');
    });
  });

  describe('Core Functionality', () => {
    it('should convert input correctly', () => {
      tool.open();
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = 'test';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('EXPECTED_OUTPUT');
    });

    it('should handle empty input', () => {
      tool.open();
      const input = document.getElementById('input');
      const output = document.getElementById('output');

      input.value = '';
      input.dispatchEvent(new Event('input'));

      expect(output.value).toBe('');
    });

    it('should handle invalid input gracefully', () => {
      tool.open();
      const input = document.getElementById('input');

      input.value = 'INVALID_DATA';
      input.dispatchEvent(new Event('input'));

      // Error-Message prüfen oder Output leer
      const errorMsg = document.querySelector('.error-message');
      expect(errorMsg).toBeTruthy();
    });
  });

  describe('Copy Functionality', () => {
    it('should copy output to clipboard', () => {
      tool.open();
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
  });

  describe('Download Functionality', () => {
    it('should download output as file', () => {
      tool.open();
      const output = document.getElementById('output');
      const downloadBtn = document.getElementById('download-btn');

      output.value = 'test output';
      downloadBtn.click();

      expect(window.DownloadUtils.downloadText).toHaveBeenCalledWith(
        'test output',
        expect.stringContaining('.txt'),
        'text/plain'
      );
    });
  });
});
```

---

## Test-Kategorien

### 1. Initialization Tests

Prüfen, ob das Tool korrekt registriert und initialisiert wird:

```javascript
it('should register with correct tool ID', () => {
  expect(window.Tools.register).toHaveBeenCalledWith('myTool', expect.any(Object));
});

it('should render UI on open()', () => {
  tool.open();
  expect(document.getElementById('input')).toBeTruthy();
});
```

---

### 2. Functionality Tests

**Happy Path:**
```javascript
it('should encode valid input', () => {
  tool.open();
  document.getElementById('input').value = 'Hello';
  document.getElementById('encode-btn').click();
  expect(document.getElementById('output').value).toBe('SGVsbG8=');
});
```

**Edge Cases:**
```javascript
it('should handle empty input', () => { /* ... */ });
it('should handle very long input', () => { /* ... */ });
it('should handle special characters', () => { /* ... */ });
```

**Error Cases:**
```javascript
it('should show error for invalid JSON', () => { /* ... */ });
it('should handle malformed URLs gracefully', () => { /* ... */ });
```

---

### 3. Integration Tests

Testen von Drag & Drop, File Upload:

```javascript
it('should process dropped file', () => {
  tool.open();
  
  // DragDropUtils.init wurde aufgerufen?
  expect(window.DragDropUtils.init).toHaveBeenCalled();
  
  // Callback extrahieren & manuell aufrufen
  const onSuccess = window.DragDropUtils.init.mock.calls[0][1];
  const mockFile = { name: 'test.json', size: 100 };
  const mockContent = '{"key":"value"}';
  
  onSuccess(mockFile, mockContent);
  
  expect(document.getElementById('output').value).toContain('value');
});
```

---

### 4. Utility Tests (`assets/js/lib/`)

**Beispiel: `validators.test.js`**

```javascript
describe('Validators', () => {
  beforeAll(() => {
    require('../../assets/js/lib/validators.js');
  });

  describe('isValidJSON', () => {
    it('should return true for valid JSON', () => {
      expect(window.Validators.isValidJSON('{"key":"value"}')).toBe(true);
    });

    it('should return false for invalid JSON', () => {
      expect(window.Validators.isValidJSON('{invalid}')).toBe(false);
    });

    it('should handle empty string', () => {
      expect(window.Validators.isValidJSON('')).toBe(false);
    });
  });

  describe('isValidURL', () => {
    it('should validate http URLs', () => {
      expect(window.Validators.isValidURL('http://example.com')).toBe(true);
    });

    it('should validate https URLs', () => {
      expect(window.Validators.isValidURL('https://example.com')).toBe(true);
    });

    it('should reject invalid URLs', () => {
      expect(window.Validators.isValidURL('not a url')).toBe(false);
    });
  });
});
```

---

## Mocking-Strategien

### DOM-Manipulation

```javascript
beforeEach(() => {
  document.body.innerHTML = `
    <div id="tool-container"></div>
    <div id="notifications"></div>
  `;
});
```

---

### Event-Simulation

```javascript
// Input-Event
const input = document.getElementById('input');
input.value = 'test';
input.dispatchEvent(new Event('input'));

// Click-Event
const button = document.getElementById('submit-btn');
button.click();

// Change-Event
const select = document.getElementById('options');
select.value = 'option2';
select.dispatchEvent(new Event('change'));
```

---

### Async-Tests

```javascript
it('should load data asynchronously', async () => {
  tool.open();
  
  const loadBtn = document.getElementById('load-btn');
  loadBtn.click();
  
  // Warten auf Promise-Resolution
  await new Promise(resolve => setTimeout(resolve, 100));
  
  const output = document.getElementById('output');
  expect(output.value).toBe('loaded data');
});
```

---

### Timer-Mocks (Debouncing)

```javascript
beforeEach(() => {
  jest.useFakeTimers();
});

afterEach(() => {
  jest.useRealTimers();
});

it('should debounce input events', () => {
  tool.open();
  const input = document.getElementById('input');
  const processSpy = jest.fn();

  input.addEventListener('input', () => {
    setTimeout(processSpy, 300);
  });

  // Mehrere Events schnell hintereinander
  input.dispatchEvent(new Event('input'));
  input.dispatchEvent(new Event('input'));
  input.dispatchEvent(new Event('input'));

  // Timer vorlaufen lassen
  jest.advanceTimersByTime(300);

  // Nur 1x aufgerufen (debounced)
  expect(processSpy).toHaveBeenCalledTimes(3); // Aber nur letzter zählt
});
```

---

## Coverage-Ziele

| Metrik | Ziel | Aktuell |
|--------|------|---------|
| **Branches** | 70% | ~75% |
| **Functions** | 80% | ~85% |
| **Lines** | 80% | ~82% |
| **Statements** | 80% | ~83% |

**Coverage-Report ansehen:**

```bash
npm run test:coverage
open coverage/lcov-report/index.html
```

---

## Best Practices

### ✅ DO:
- **Einen Test pro Feature/Funktion**
- **Descriptive Test-Namen:** `should convert Base64 to UTF-8`
- **AAA-Pattern:** Arrange → Act → Assert
- **Mock externe Dependencies** (APIs, localStorage, etc.)

### ❌ DON'T:
- **Tests abhängig voneinander machen** (shared state)
- **Implementierungs-Details testen** (z.B. interne Variable-Namen)
- **Zu große Tests** (sollten < 20 Zeilen sein)
- **Flaky Tests** (intermittierende Failures)

---

## Debugging Tests

### Einzelnen Test ausführen

```bash
# Nur eine Test-Datei
npm test -- myToolTool.test.js

# Nur einen Testcase (via -t)
npm test -- -t "should encode valid input"
```

### Verbose Output

```bash
npm test -- --verbose
```

### Debug-Modus (Node Inspector)

```bash
node --inspect-brk node_modules/.bin/jest --runInBand
# Chrome öffnen: chrome://inspect
```

---

## CI-Integration

### GitHub Actions Workflow

```yaml
- name: Run Tests
  run: npm test -- --ci --coverage --maxWorkers=2

- name: Upload Coverage
  uses: codecov/codecov-action@v3
  with:
    files: ./coverage/lcov.info
```

---

**Weitere Infos:**
- [FRONTEND.md](FRONTEND.md) – JS-Code-Struktur
- [INTEGRATION.md](INTEGRATION.md) – Tests für neues Tool schreiben
