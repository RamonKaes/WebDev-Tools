# Changelog – WebDev-Tools

Format: [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) · Versioning: [SemVer](https://semver.org/)

---

## [Unreleased]

### 🔒 Security
- `tool-loader.js` / `tool-registry.js`: `toolId` via `escapeHtml()` vor `innerHTML` gesichert (XSS)
- `i18n.js`: `getCookie()` nutzt Regex-Escaping (ReDoS-Prävention)

### 🐛 Bug Fixes
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
- **Emoji Reference** – 7 hardcodierte englische UI-Strings in alle 6 Sprach-JSONs extrahiert (`loadingEmojis`, `loadError`, `noResults`, `loadMore`, `loading`, `copyEmoji`, `copyCode`); Tippfehler in `en.json` `card_description` behoben

### ✨ Features
- Sidebar-Navigation: Accordion-Verhalten (nur eine Kategorie gleichzeitig geöffnet)

### 🏗️ Build
- JS-Bundling entfernt (382 → 129 Zeilen `build.sh`); Dateien werden einzeln geladen
- Dupliziertes Logger-Modul (`assets/js/lib/logger.js`) entfernt

### 🧪 Tests
- `codeFormatterTool.test.js` – 35 Tests (HTML/CSS/JS/XML/SQL Beautify+Minify, UI)
- `dataConverterTool.test.js` – 45 Tests (JSON↔XML, JSON↔YAML, JSON↔CSV, Timestamp↔Datum, UI)
- `aspectRatioCalculator.test.js` – 14 Tests · `base64EncoderDecoder.test.js` – 13 Tests · `characterReference.test.js` – 16 Tests
- `emojiReferenceTool.test.js` – 19 Tests (Registration, Initial Render, Category Filter, Search, XSS, Copy, Fetch Error)
- Gesamt: **147 Tests** (6 Suites) · Framework: Jest 29 + jsdom · Shell-Skripte entfernt

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
