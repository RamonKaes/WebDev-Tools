# Test Suite – WebDev-Tools

Jest-based unit tests for JavaScript tools.

## Structure

```
tests/
  unit/
    setup.js                          – global mocks (TextEncoder, URL.createObjectURL, …)
    aspectRatioCalculator.test.js     – 14 tests
    base64EncoderDecoder.test.js      – 13 tests
    characterReference.test.js        – 16 tests (including debounce fake timer tests)
    codeFormatterTool.test.js         – 35 tests
    dataConverterTool.test.js         – 45 tests
    emojiReferenceTool.test.js        – 19 tests
    hashGeneratorTool.test.js         – 26 tests
    htmlEntityTool.test.js            – 30 tests
    jsonFormatterValidatorTool.test.js – 44 tests
    jwtDecoderTool.test.js            – 30 tests
    loremIpsumTool.test.js            – 42 tests
    passwordGeneratorTool.test.js     – 55 tests
    punycodeConverterTool.test.js     – 36 tests
    pxToRemConverterTool.test.js      – 66 tests
    qrCodeGeneratorTool.test.js       – 65 tests
    regexTesterTool.test.js           – 51 tests
    sriGeneratorTool.test.js          – 31 tests
    stringEscaperTool.test.js         – 83 tests
    urlEncoderDecoderTool.test.js     – 75 tests
    uuidGeneratorTool.test.js         – 60 tests
  README.md
```

## Run Tests

```bash
# All tests once
npm test

# Watch mode (during development)
npm run test:watch

# With coverage report
npm run test:coverage
```

## Test Coverage per Tool

### Aspect Ratio Calculator (`aspectRatioCalculator.test.js`)
| Area | Tests |
|------|-------|
| Calculate height from width (16:9) | ✅ |
| Calculate width from height | ✅ |
| Empty field clears result | ✅ |
| Simplify 32:18 → 16:9 | ✅ |
| Decimal ratio 1.5:1 → 3:2 | ✅ |
| Decimal format (1.7778) | ✅ |
| Percentage value (56.2500%) | ✅ |
| Empty inputs clear outputs | ✅ |
| Modern CSS (`aspect-ratio`) | ✅ |
| Legacy CSS (`padding-bottom`) | ✅ |
| CSS mode "both" | ✅ |
| Preset button (4:3) | ✅ |
| Table row sets ratio | ✅ |
| Clear resets all fields | ✅ |

### Base64 Encoder/Decoder (`base64EncoderDecoder.test.js`)
| Area | Tests |
|------|-------|
| ASCII encoding (URL-safe, no padding) | ✅ |
| ASCII encoding (standard, with padding) | ✅ |
| UTF-8 encoding (Ä) | ✅ |
| URL-safe without +/= in output | ✅ |
| Empty input → empty output | ✅ |
| Decode standard Base64 | ✅ |
| Decode UTF-8 Base64 | ✅ |
| Round-trip encode → decode | ✅ |
| Mode switch clears fields | ✅ |
| Clear button resets state | ✅ |
| Invalid Base64 marks error | ✅ |
| Sample button fills input field | ✅ |

### Character Reference (`characterReference.test.js`)
| Area | Tests |
|------|-------|
| Tool registers correctly | ✅ |
| Table shows all test characters | ✅ |
| Every row has copy button group | ✅ |
| `escapeHtml`: & → &amp;amp; (safe in DOM) | ✅ |
| `escapeHtml`: < doesn't appear as raw HTML | ✅ |
| `escapeForAttribute`: data-copy-value is safe | ✅ |
| Search by name filters results | ✅ |
| Search by entity finds characters | ✅ |
| Search by Unicode codepoint | ✅ |
| No match shows empty state | ✅ |
| Clear search → all characters visible again | ✅ |
| Filter "arrows" shows only arrows | ✅ |
| Filter "html" shows HTML category | ✅ |
| Filter back to "all" | ✅ |
| Copy button calls ClipboardUtils | ✅ |
| Entity copy copies correct value | ✅ |

### Code Formatter (`codeFormatterTool.test.js`)
| Area | Tests |
|------|-------|
| HTML beautify: indentation, void elements, self-closing | ✅ |
| HTML minify: remove comments, collapse whitespace | ✅ |
| CSS beautify: selector, declaration, closing brace | ✅ |
| CSS minify: comments, whitespace, preserve string values | ✅ |
| JS beautify: brace handling, strings, comments | ✅ |
| JS minify (Terser): invocation and output | ✅ |
| XML beautify: child elements indented | ✅ |
| SQL beautify: keywords uppercase, line breaks | ✅ |
| SQL minify: remove comments, whitespace | ✅ |
| UI: clear, stats, samples (html/css/xml/sql), auto-format, copy, download | ✅ |

### Data Converter (`dataConverterTool.test.js`)
| Area | Tests |
|------|-------|
| JSON → XML: flat, array, XML escaping, error case | ✅ |
| XML → JSON: simple, error case | ✅ |
| JSON → YAML: flat, nested, array, colon quoting, error case | ✅ |
| YAML → JSON: flat, boolean, null, tilde, comments | ✅ |
| JSON → CSV: header, delimiter escaping, quote escaping, error case | ✅ |
| CSV → JSON: header, quoted commas, escaped quotes, empty input | ✅ |
| Timestamp → date: UTC output, error case | ✅ |
| Date → timestamp: error case, UTC roundtrip | ✅ |
| UI: clear, indentation visibility, XML/CSV options, samples, auto-convert, download, copy | ✅ |
| Roundtrip JSON↔CSV, timestamp UTC consistency | ✅ |

## Technical Details

- **Framework:** Jest 30 + `jest-environment-jsdom`
- **Configuration:** `jest.config.js` with `setupFilesAfterFramework: ['./tests/unit/setup.js']`
- **Strategy:** IIFE scripts are loaded via `require()`; globals are set as mocks before loading (`window.Tools`, `window.i18n`, `window.ClipboardUtils`, `window.DownloadUtils`, `window.Terser`)
- **Async:** `characterReference` uses `fetch`; this is mocked with `jest.fn()`, tool initializes fully via `await setTimeout(30ms)`

## Prerequisites

```bash
node -v   # >=18.0.0
npm -v    # >=9.0.0
npm install
```
