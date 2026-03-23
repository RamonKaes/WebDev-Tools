# Changelog – WebDev-Tools

Format: [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) · Versioning: [SemVer](https://semver.org/)

---

## [Unreleased]

### 🔒 Security
- `tool-loader.js` / `tool-registry.js`: `toolId` via `escapeHtml()` vor `innerHTML` gesichert (XSS)
- `i18n.js`: `getCookie()` nutzt Regex-Escaping (ReDoS-Prävention)

### 🐛 Bug Fixes
- **JSON Formatter & Validator** – Leere `getIndent()`-Deklaration (Zeile 421) entfernt (duplizierte Funktion ohne Body); `var` → `const`/`let` für alle Variablen in `initializeTool()` (9 Variablen); `downloadBtn` nutzt jetzt `window.DownloadUtils.downloadText()` statt manuellem Blob/URL-Pattern
- **HTML Entity Encoder/Decoder** – `performConversion` → `convert` (ReferenceError in `loadSampleBtn`-Handler); `encodeToAllNamedEntities` Regex `/./g` → `/[\s\S]/g` (Newlines wurden übersprungen); Download nutzt jetzt `window.DownloadUtils.downloadText()` statt manuellem Blob/URL
- **Hash Generator** – `</h3>` statt `</h2>` in `$customNoticeContent` aller 5 Sprachversionen (de, es, fr, it, pt); tote Variablen (`chunkSize`, `chunks`, `offset`) in `hashFile()` entfernt; Event-Listener-Leak in `generateSRI()` behoben (Guard-Flag verhindert doppelte Registrierung)
- **Emoji Reference** – Suche ignorierte aktive Kategorie (`renderEmojis()` ohne `currentCategory`); `setupCopyButtons()` häufte Event-Listener bei jeder Paginierung an (jetzt einmalig in `setupEventListeners`)
- **Data Converter** – `handleConversion` → `performConversion` (ReferenceError); `indentationWrapper` nach Timestamp → XML/CSV wieder eingeblendet; tote Samples ersetzt; unbenutzte Variablen entfernt
- **Data Converter** – `timestampToDate` gibt ` UTC`-Suffix aus; Roundtrip Timestamp ↔ Datum ist damit timezone-unabhängig korrekt
- **Code Formatter** – `handleFormat` → `formatCode` (ReferenceError); HTML-Beautifier Void/Self-closing-Handling; CSS-Minifier Doppelpunkt-Stripping entfernt; `execCommand` → `clipboard.writeText`; tote Samples ersetzt; duplizierte `t()` entfernt
- **Aspect Ratio Calculator** – GCD rekursiv → iterativ; `simplifyRatio` Decimal-Scaling präzisiert; Preset-Labels i18n-isiert; `t()`-Duplikat entfernt
- **Base64 Encoder/Decoder** – `=`-Padding für URL-safe in `decodeToFile()`; Regex `$`-Anker ergänzt; Memory Leak (unrevokte Object-URLs) behoben; `clearBtn` setzt Datei-State zurück
- **Character Reference** – `t.xxx` → `t('xxx')` (10 Stellen); doppelter Event-Listener entfernt; `buildRowHTML` / `appendLoadMoreRow` extrahiert; 16 fehlende i18n-Keys ergänzt
- **assets/js (20 Fixes)** – Race Condition in `i18n.js`; `throttle()` this-Kontext; Null-Checks in `color-modes.js`; Sidebar-Scroll für Desktop+Mobile; veraltete `performance.timing`-API ersetzt; u. a.
- **Layout Toggle Button** – CSS-Transform-Konflikt behoben (`translate-middle` vs. `.btn-layout-toggle-stacked`)

### 🌐 i18n
- **JSON Formatter & Validator** – `en.json` `card_description`: ". in" → "in" (fehlerhafter Satzumbruch); `de.json` `card_description`: abgeschnittenes "Features:." → vollständiger Satz
- **HTML Entity Encoder/Decoder** – `featureList` und `keywords` in SEO-Sektion aller 6 Sprach-JSONs befüllt (waren leer)
- **Emoji Reference** – 7 hardcodierte englische UI-Strings in alle 6 Sprach-JSONs extrahiert (`loadingEmojis`, `loadError`, `noResults`, `loadMore`, `loading`, `copyEmoji`, `copyCode`); Tippfehler in `en.json` `card_description` behoben

### ✨ Features
- Sidebar-Navigation: Accordion-Verhalten (nur eine Kategorie gleichzeitig geöffnet)

### 🏗️ Build
- JS-Bundling entfernt (382 → 129 Zeilen `build.sh`); Dateien werden einzeln geladen
- Dupliziertes Logger-Modul (`assets/js/lib/logger.js`) entfernt

### 🐛 Bug Fixes
- **Password Generator** – `d-none` statt `hidden` für `#customCharsetOptions` (Bootstrap 5 kennt kein `.hidden`; Custom-Charset-Panel war in allen Modi sichtbar); `</h3>` statt `</h2>` in `$customNoticeContent` aller 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt); Mindestlänge in Features-Liste von „4" auf „8" korrigiert (entspricht `min="8"` des Sliders) – alle 6 Sprachversionen; `require()`-Fallback in `loadWordlist()` für CJS-Umgebungen (Jest) ergänzt
- **JWT Decoder** – `</h3>` statt `</h2>` in `$customNoticeContent` der deutschen Version (`de/jwt-dekodierer/index.php`)
- **Lorem Ipsum** – `</h3>` statt `</h2>` in `$customNoticeContent` aller 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt); fehlende `</p>` in `it/lorem-ipsum/index.php`; fehlende Zeilentrennung in `es/lorem-ipsum/index.php`; falsche HTML-Output-Feature-Claims aus allen 6 PHP-Dateien und `config/tools.php` entfernt (Feature nicht implementiert)

### 🧪 Tests
- `codeFormatterTool.test.js` – 35 Tests (HTML/CSS/JS/XML/SQL Beautify+Minify, UI)
- `dataConverterTool.test.js` – 45 Tests (JSON↔XML, JSON↔YAML, JSON↔CSV, Timestamp↔Datum, UI)
- `aspectRatioCalculator.test.js` – 14 Tests · `base64EncoderDecoder.test.js` – 13 Tests · `characterReference.test.js` – 16 Tests
- `emojiReferenceTool.test.js` – 19 Tests (Registration, Initial Render, Category Filter, Search, XSS, Copy, Fetch Error)
- `hashGeneratorTool.test.js` – 26 Tests (Registration, UI-Rendering alle 5 Modi, CryptoUtils, Text-Hashing, HMAC, Hash-Vergleich, Uppercase-Toggle)
- `htmlEntityTool.test.js` – 30 Tests (Named/Decimal/Hex/All-Named Encoding, Decoding, Round-trip, UI-State, Copy, Download)
- `jsonFormatterValidatorTool.test.js` – 44 Tests (Registration, UI-Rendering, Format, Validate, Minify, Sort Keys, Auto-fix, Clear, Load Sample, Copy, Download, Path Extractor, Escape/Unescape)
- `jwtDecoderTool.test.js` – 30 Tests (Registration, UI-Rendering, Decode Happy Path, No-Expiry, Error Handling, Clear, Load Example, Keyboard Shortcut, Whitespace Trimming)
- `loremIpsumTool.test.js` – 42 Tests (Registration, UI-Rendering, Auto-Generation, Paragraphs, Sentences, Words, Combined, Validation, Counts, Clear, Copy)
- `passwordGeneratorTool.test.js` – 55 Tests (Registration, UI-Rendering, Auto-Generation, Password-Generation, Pattern-Generation, Passphrase-Generation, Strength-Indicator, Download, Mode-Switching, Copy, Clear, Custom-Charset)
- Gesamt: **374 Tests** (12 Suites) · Framework: Jest 30 + jsdom · Shell-Skripte entfernt

---

## [1.0.0] – 2026-01-03

Initiales Production-Release: 19 Tools × 6 Sprachen, Client-Side-only, 100% OWASP-konform.

### Tools
| Kategorie | Tools |
|-----------|-------|
| Kryptografie | UUID Generator, Password Generator, Hash Generator, JWT Decoder |
| Daten | JSON Formatter, Code Formatter, Data Converter |
| Encoding | Base64, URL Encoder, Punycode, HTML Entity |
| Strings | String Escaper, Regex Tester |
| Frontend | Aspect Ratio Calculator, Px→Rem, QR Code, Lorem Ipsum |
| Referenz | Character Reference, Emoji Reference |

### Stack
- Frontend: Bootstrap 5.3.0 + Bootstrap Icons 1.11.0 + Vanilla JS
- Backend: PHP 7.4+ (100% `strict_types`) + Apache 2.4+
- Security: Web Crypto API, CSP (nonce), DOMPurify 3.0.9, SRI, HSTS
- i18n: 6 Sprachen (en, de, es, pt, fr, it), ~1261 Keys pro Sprache

---

## Contributors
- **Ramon Kaes** – Entwicklung, Architektur
- **Claude Sonnet 4.6** (Anthropic) – Code-Assistent & Reviewer
