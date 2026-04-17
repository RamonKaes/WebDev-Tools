# Test Suite – WebDev-Tools

Jest-basierte Unit-Tests für die JavaScript-Tools.

## Struktur

```
tests/
  unit/
    setup.js                          – globale Mocks (TextEncoder, URL.createObjectURL, …)
    aspectRatioCalculator.test.js     – 14 Tests
    base64EncoderDecoder.test.js      – 13 Tests
    characterReference.test.js        – 16 Tests (inkl. Debounce-Fake-Timer-Tests)
    codeFormatterTool.test.js         – 35 Tests
    dataConverterTool.test.js         – 45 Tests
    emojiReferenceTool.test.js        – 19 Tests
    hashGeneratorTool.test.js         – 26 Tests
    htmlEntityTool.test.js            – 30 Tests
    jsonFormatterValidatorTool.test.js – 44 Tests
    jwtDecoderTool.test.js            – 30 Tests
    loremIpsumTool.test.js            – 42 Tests
    passwordGeneratorTool.test.js     – 55 Tests
    punycodeConverterTool.test.js     – 36 Tests
    pxToRemConverterTool.test.js      – 66 Tests
    qrCodeGeneratorTool.test.js       – 65 Tests
    regexTesterTool.test.js           – 51 Tests
    sriGeneratorTool.test.js          – 31 Tests
    stringEscaperTool.test.js         – 83 Tests
    urlEncoderDecoderTool.test.js     – 75 Tests
    uuidGeneratorTool.test.js         – 60 Tests
  README.md
```

## Tests ausführen

```bash
# Alle Tests einmalig
npm test

# Watch-Modus (beim Entwickeln)
npm run test:watch

# Mit Coverage-Report
npm run test:coverage
```

## Testabdeckung pro Tool

### Aspect Ratio Calculator (`aspectRatioCalculator.test.js`)
| Bereich | Tests |
|---------|-------|
| Höhe aus Breite berechnen (16:9) | ✅ |
| Breite aus Höhe berechnen | ✅ |
| Leeres Feld löscht Ergebnis | ✅ |
| Vereinfachung 32:18 → 16:9 | ✅ |
| Dezimalverhältnis 1.5:1 → 3:2 | ✅ |
| Dezimalformat (1.7778) | ✅ |
| Prozentwert (56.2500%) | ✅ |
| Leere Eingaben löschen Ausgaben | ✅ |
| Modernes CSS (`aspect-ratio`) | ✅ |
| Legacy-CSS (`padding-bottom`) | ✅ |
| CSS-Modus „both" | ✅ |
| Preset-Button (4:3) | ✅ |
| Tabellenzeile setzt Ratio | ✅ |
| Clear setzt alle Felder zurück | ✅ |

### Base64 Encoder/Decoder (`base64EncoderDecoder.test.js`)
| Bereich | Tests |
|---------|-------|
| ASCII-Kodierung (URL-safe, ohne Padding) | ✅ |
| ASCII-Kodierung (Standard, mit Padding) | ✅ |
| UTF-8-Kodierung (Ä) | ✅ |
| URL-safe ohne +/= im Output | ✅ |
| Leere Eingabe → leere Ausgabe | ✅ |
| Standard-Base64 dekodieren | ✅ |
| UTF-8-Base64 dekodieren | ✅ |
| Round-Trip Encode → Decode | ✅ |
| Modusswitch löscht Felder | ✅ |
| Clear-Button setzt Zustand zurück | ✅ |
| Ungültiges Base64 markiert Fehler | ✅ |
| Sample-Button befüllt Eingabefeld | ✅ |

### Character Reference (`characterReference.test.js`)
| Bereich | Tests |
|---------|-------|
| Tool registriert sich korrekt | ✅ |
| Tabelle zeigt alle Testzeichen | ✅ |
| Jede Zeile hat Copy-Button-Gruppe | ✅ |
| `escapeHtml`: & → &amp;amp; (sicher im DOM) | ✅ |
| `escapeHtml`: < erscheint nicht als rohes HTML | ✅ |
| `escapeForAttribute`: data-copy-value ist sicher | ✅ |
| Suche nach Name filtert Ergebnisse | ✅ |
| Suche nach Entity findet Zeichen | ✅ |
| Suche nach Unicode-Codepoint | ✅ |
| Kein Treffer zeigt Empty-State | ✅ |
| Suche leeren → alle Zeichen wieder sichtbar | ✅ |
| Filter „arrows" zeigt nur Pfeile | ✅ |
| Filter „html" zeigt HTML-Kategorie | ✅ |
| Filter zurück auf „all" | ✅ |
| Copy-Button ruft ClipboardUtils auf | ✅ |
| Entity-Copy kopiert richtigen Wert | ✅ |

### Code Formatter (`codeFormatterTool.test.js`)
| Bereich | Tests |
|---------|-------|
| HTML beautify: Einrückung, Void-Elemente, Self-closing | ✅ |
| HTML minify: Kommentare entfernen, Whitespace kollabieren | ✅ |
| CSS beautify: Selektor, Deklaration, Closing-Brace | ✅ |
| CSS minify: Kommentare, Whitespace, String-Werte erhalten | ✅ |
| JS beautify: Brace-Handling, Strings, Kommentare | ✅ |
| JS minify (Terser): Aufruf und Output | ✅ |
| XML beautify: Kind-Elemente eingerückt | ✅ |
| SQL beautify: Keywords uppercase, Zeilenumbrüche | ✅ |
| SQL minify: Kommentare entfernen, Whitespace | ✅ |
| UI: Clear, Stats, Samples (html/css/xml/sql), Auto-Format, Copy, Download | ✅ |

### Data Converter (`dataConverterTool.test.js`)
| Bereich | Tests |
|---------|-------|
| JSON → XML: Flat, Array, XML-Escaping, Fehlerfall | ✅ |
| XML → JSON: Einfach, Fehlerfall | ✅ |
| JSON → YAML: Flat, Nested, Array, Colon-Quoting, Fehlerfall | ✅ |
| YAML → JSON: Flat, Boolean, Null, Tilde, Kommentare | ✅ |
| JSON → CSV: Header, Delimiter-Escaping, Quote-Escaping, Fehlerfall | ✅ |
| CSV → JSON: Header, Quoted Commas, Escaped Quotes, Leere Eingabe | ✅ |
| Timestamp → Date: UTC-Ausgabe, Fehlerfall | ✅ |
| Date → Timestamp: Fehlerfall, UTC-Roundtrip | ✅ |
| UI: Clear, Indentation-Sichtbarkeit, XML/CSV-Optionen, Samples, Auto-Convert, Download, Copy | ✅ |
| Roundtrip JSON↔CSV, Timestamp UTC-Konsistenz | ✅ |

## Technische Details

- **Framework:** Jest 30 + `jest-environment-jsdom`
- **Konfiguration:** `jest.config.js` mit `setupFilesAfterFramework: ['./tests/unit/setup.js']`
- **Strategie:** IIFE-Skripte werden per `require()` geladen; Globals werden vor
  dem Laden als Mocks gesetzt (`window.Tools`, `window.i18n`, `window.ClipboardUtils`,
  `window.DownloadUtils`, `window.Terser`)
- **Async:** `characterReference` nutzt `fetch`; dieser wird mit `jest.fn()` gemockt,
  das Tool initialisiert sich vollständig via `await setTimeout(30ms)`

## Voraussetzungen

```bash
node -v   # >=18.0.0
npm -v    # >=9.0.0
npm install
```
