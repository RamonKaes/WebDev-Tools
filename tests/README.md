# WebDev-Tools Test Suite

Einfaches Vanilla JavaScript Test-Framework ohne externe Abhängigkeiten.

## Test Coverage

### ✅ Implementierte Tests

#### Unit Tests (JavaScript)
- **validators.test.js** - 15 Tests für Email, URL, JSON, Base64, Hex-Validierung
- **clipboard-utils.test.js** - 5 Tests für Clipboard API Integration
- **formatters.test.js** - 15 Tests für Byte/Number/Date Formatierung
- **storage-utils.test.js** - 11 Tests für localStorage/sessionStorage
- **logger.test.js** - 10 Tests für Error Handling, Classification, Stack Traces

**Total: 56 Tests** | **Coverage: ~40% der Utility-Bibliotheken**

#### Security & Dependency Tests
- **dependency-check.sh** - Automatisierte Sicherheitsprüfung für:
  - CVE-Scans (OSV.dev API)
  - Version-Updates (GitHub Releases)
  - PHP EOL-Status

## Verwendung

### Tests im Browser ausführen

1. Öffne `tests/index.html` in einem Browser
2. Klicke auf "Run Validators Tests" oder einen anderen Test-Button
3. Sieh dir die Ergebnisse in der Konsole an

### Tests in der Kommandozeile ausführen

#### JavaScript Unit Tests (mit Node.js)
```bash
# Einzelne Test-Datei ausführen
node tests/lib/validators.test.js
```

#### Security & Dependency Check
```bash
# Dependency-Sicherheitsprüfung durchführen
cd /var/www/html/WebDev-Tools
./tests/dependency-check.sh
```

**Empfohlene Frequenz:** Vierteljährlich (vor jedem Release)

## Test-Struktur

```
tests/
├── test-runner.js          # Test-Framework Core
├── index.html              # Browser Test Runner UI
├── dependency-check.sh     # Security & Dependency Scanner
├── lib/                    # Unit Tests für lib/
│   ├── validators.test.js
│   ├── clipboard-utils.test.js
│   ├── formatters.test.js
│   ├── storage-utils.test.js
│   └── ...
└── README.md
```

## Neue Tests erstellen

Erstelle eine neue `.test.js` Datei:

```javascript
import { TestRunner, assert } from '../test-runner.js';
import { myFunction } from '../../assets/js/lib/my-module.js';

const runner = new TestRunner();

runner.test('Test-Name', () => {
  const result = myFunction('input');
  assert.equal(result, 'expected');
});

// Tests ausführen
runner.run();
```

## Verfügbare Assertions

- `assert.ok(value, message)` - Prüft ob Wert truthy ist
- `assert.equal(actual, expected, message)` - Strikte Gleichheit (===)
- `assert.deepEqual(actual, expected, message)` - Deep Object-Vergleich
- `assert.throws(fn, message)` - Prüft ob Funktion wirft
- `assert.isNull(value, message)` - Prüft auf null/undefined
- `assert.notNull(value, message)` - Prüft dass nicht null/undefined
- `assert.includes(array, value, message)` - Array enthält Wert
- `assert.typeOf(value, type, message)` - Typ-Prüfung

## Tests überspringen

```javascript
runner.skip('Test-Name', () => {
  // Dieser Test wird übersprungen
});
```

## Best Practices

1. **Ein Test pro Funktion**: Teste eine spezifische Funktionalität
2. **Aussagekräftige Namen**: Beschreibe was getestet wird
3. **Arrange-Act-Assert**: Strukturiere Tests in Setup, Ausführung, Prüfung
4. **Edge Cases**: Teste Grenzfälle (null, undefined, leere Strings)
5. **Unabhängigkeit**: Tests sollten nicht voneinander abhängen

## Beispiel

```javascript
runner.test('isValidEmail: accepts valid email', () => {
  // Arrange
  const email = 'test@example.com';
  
  // Act
  const result = isValidEmail(email);
  
  // Assert
  assert.equal(result, true);
});
```

## Weitere Test-Suites hinzufügen

1. Erstelle neue `.test.js` Datei im entsprechenden Ordner
2. Füge Button in `index.html` hinzu:
   ```html
   <button onclick="runTests('dein/test.js')">Run Dein Test</button>
   ```
3. Import das Test-Modul und führe `runner.run()` aus
