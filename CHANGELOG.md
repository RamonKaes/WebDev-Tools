# Changelog – WebDev-Tools

Format: [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) · Versioning: [SemVer](https://semver.org/)

---

## [2.1.2] – 2026-04-17

### 🖼️ Assets
- **OG Images** – Standardized to single image:
  - All pages now use `assets/img/webdev-tools.png` (41 KB)
  - Removed: `assets/img/og/` directory (~140 KB, 24+ SVG files)
  - Removed: `config/generate-og-images.php` and `config/validate-og-images.php`
  - Updated: 15 PHP files (index.php, about.php for all 6 languages, partials, config)
  - Updated: `build.sh` (removed OG copy section)
  - Affects: Homepage, About pages, all ~120 tool pages, error pages

### 🐛 Bugfixes
- **Homepage Tool Cards** – Fixed consistency issues:
  - Added missing `$toolsConfig` variable in localized index.php (DE/ES/PT/FR/IT)
  - Removed duplicate variable definitions in de/index.php
  - Replaced 19 incorrect `</h3>` tags with `</div>`
  - Standardized card-body indentation (16 spaces across all languages)
  - Standardized card indentation (14 spaces across all languages)
  - Corrected icon and content indentation (20 spaces)
  - Added 120 missing `title` attributes (20 tools × 6 languages)
  - Result: Identical HTML structure across all 6 languages

---

## [2.1.1] – 2026-04-17

### 🔍 SEO
- **Page Titles** – Optimized 26 problematic page titles (55-65 characters, keyword-optimized):
  - 24 PHP pages: index, about, privacy, imprint (all 6 languages)
  - 6 i18n JSON entries: aspectRatioCalculator meta_title
  - Template: "[Tool] – [Function] [Benefits] [Keywords]"
- **Internal Link Texts** – Improved internal link texts:
  - linkTitle.card expanded from <60 to 60-80 characters (EN: 95%, DE: 80%)
  - Added keywords: Format names (HTML, JSON), features (drag & drop), benefits (secure, online)
  - Navigation: title attributes for legal links (About, Imprint, Privacy) in all 6 languages
- **Heading Structure** – Fixed heading hierarchy:
  - Hierarchy gaps: 6 → 0 (100% fixed)
  - Empty headings: 120 → 0 (100% fixed)
  - Template: `<h6>` → `<h3>` for "On this page" sidebar
  - Homepage: `<h3>` tool-cards → `<div>` (no semantic headings for navigation)
  - Tools: `<h3>` alert-headings → `<div>` in customNoticeContent (~60 files)
  - Correct hierarchy: H1 (tool title) → H2 (sections) → H3 (subsections)
  - Dual-title system: `h1_title` (SEO-optimized, keyword-rich) + `toc_title` (navigation-friendly, short)
  - tool-base.php: `h1_title` for `<h1>` content, `toc_title` for `data-toc-title` attribute
  - index.php (6 languages): `h1_title` in link title attributes for better tooltips
- **Meta-Descriptions** – Added meta-descriptions for static pages:
  - 24 new meta-descriptions: 4 static pages (home, about, privacy, imprint) × 6 languages
  - Critical issues: 24 → 0 (100% fixed)
  - Optimal descriptions (140-160 characters): 75 → 83
  - Template: Call-to-action + keywords + clear value proposition
- **Strong/Bold Tags** – Audit completed, optimization not necessary:
  - Found 10 overly long tags (>70 characters), all in privacy.php
  - Privacy pages have `noindex, follow` → no SEO relevance
  - Emphasis for user experience only, not for search engines
  - Decision: No changes needed

### 🎨 UI/UX
- **Tabler-Style Alert Colors** – Adapted alert colors to Tabler design:
  - Light mode: Brighter pastel backgrounds (#fbe7e7, #fff8e1, #e6f4ea, #e7f1ff)
  - Light mode: Softer border colors (25% transparency)
  - Dark mode: Semi-transparent backgrounds (15% opacity) + visible borders (40% opacity)
  - Dark mode: Brighter text colors for better readability (#f8b4b4, #ffd966, #8fd19e, #74c0fc)
  - No left borders (subtler design)



---

## [2.1.0] – 2026-04-17

### ✨ Features
- **SRI Generator** – New tool (#20): Generate Subresource Integrity hashes for CDN resources; SHA-256, SHA-384, SHA-512; URL fetch, file upload or text input; ready-made `<script>`/`<link>` tags with integrity attribute; Web Crypto API based
- **UI Redesign** – More compact heading hierarchy: Tool titles h3→h5, section headings h5→h6, grid gaps g-4→g-3
- **Tabler Color Palette** – Replaced Bootstrap colors with Tabler-inspired palette (#066fd1 Blue, #2fb344 Green, etc.)

### 🔒 Security
- **CSP** – Added `connect-src 'self' https:` (for SRI URL fetch)

### 🐛 Bug Fixes
- **TOC Generator** – Tool header heading incorrectly appeared in table of contents
- **Tool Cards** – Removed hover animation (translateY) for less distraction

### 🧪 Tests
- `sriGeneratorTool.test.js` – 31 tests (Registration, UI rendering, hash generation, algorithm selection, copy, sample)
- Total: **841 tests** (20 suites)

### 🏗️ Build
- `sri-generator` included in build script
- sass updated from ^1.70.0 to ^1.99.0
- Sitemaps regenerated with updated data

---

## [2.0.2] – 2026-04-02

### 🔒 Security
- **Code Formatter** – Fixed DOM XSS vulnerability in `codeFormatterTool.js`: `error.message` from Terser library was rendered unfiltered via `innerHTML`; since Terser embeds parts of user input in parse error messages, an attacker could execute HTML/JS through crafted code input; Fix: Icon as static `innerHTML`, error message appended as separate text node via `createTextNode()`

---

## [2.0.1] – 2026-03-24

### 🐛 Bug Fixes
- **Sidebar Navigation** – Fixed Bootstrap loading order: `sidebar-navigation.js` checked `typeof bootstrap` on load but couldn't find Bootstrap object yet since `footer.php` (with Bootstrap) was included afterwards; swapped order in `partials/tool-base.php` and all 6 homepage variants (en, de, es, fr, it, pt)
- **Sidebar Navigation** – Fixed race condition between `sidebar-persistence.js` and `sidebar-navigation.js`: `restoreStatesEarly()` opened saved categories via `requestAnimationFrame` **after** DOMContentLoaded and overwrote the correctly set state from `initSidebarNavigation()`; rAF callback now aborts if active tool link exists

### 🔒 Security / CSP
- **clipboard-utils.js** – Fixed CSP violation (`style-src-elem`): `addToastStyles()` injected a dynamic `<style>` element via JavaScript that was blocked by `style-src 'self'`; styles extracted to `assets/css/clipboard-toast.css` and included via `<link>` in `partials/head.php`

### ✨ Features
- **Hash Generator** – Added "Load Example" button in text mode (`Hello, World!`) and HMAC mode (`The quick brown fox…` / Secret `secret-key`); fills input fields and triggers calculation immediately; i18n added in all 6 languages
- **Regex Tester** – Added example dropdown with 5 predefined patterns (Email, URL, Date YYYY-MM-DD, IPv4, Named Groups); fills pattern, flags and test string at once and triggers test automatically; i18n added in all 6 languages

---

## [2.0.0] – 2026-03-23

### 🐛 Bug Fixes
- **UUID Generator** – `generateUUIDv1()` systematically produced incorrect UUIDs: JavaScript bitwise operators (`>>`, `&`) truncate to 32-bit integers, causing the 60-bit timestamp (~1.4×10¹⁷) to overflow — `timeMid` was always `0000`, `timeHiVersion` always `1000` regardless of system time; switched to `BigInt` arithmetic, now generates RFC 4122 compliant v1 UUIDs
- **UUID Generator** – Fixed `<h3>...</h2>` HTML tag mismatch in `$customNoticeContent` of all 5 non-EN language versions (de, es, fr, it, pt)
- **UUID Generator** – `$featuresSectionTitle` and `$resourcesSectionTitle` were missing in `pt/uuid-generator/index.php`
- **UUID Generator** – Download button used direct DOM manipulation (`Blob`, `URL.createObjectURL`, `<a>.click()`) instead of `window.DownloadUtils.downloadText()` — restored project convention
- **UUID Generator** – Copy icon reset bug: after successful copy, icon was reset to `'bi bi-clipboard'`, losing the `me-2` class of the bulk copy button; icon classes are now fully preserved and only `bi-clipboard` is replaced with `bi-check`

### 🧪 Tests
- `uuidGeneratorTool.test.js` – 60 tests (Registration, UI rendering, UUID v4/v1/v7/NIL generation, version format validation, single format options, version help text, bulk generation, bulk output formats, copy buttons, download button, auto-generate checkbox, crypto error handling)
- Total: **810 tests** (19 suites)

### 🐛 Bug Fixes
- **URL Encoder/Decoder** – `uri_info` translation in `fr.json` was `"Informations URI"` (incomplete/incorrect) instead of the correct French description — replaced with complete translation
- **URL Encoder/Decoder** – Removed feature claim "Auto-detection: Automatically detect encoding requirements" in all 6 PHP language versions; feature not implemented in JS — replaced with "Live Mode: Real-time encoding/decoding as you type" (actually present)

### 🧪 Tests
- `urlEncoderDecoderTool.test.js` – 75 tests (Registration, UI rendering, mode switching, encode/decode component+URI, line-by-line, error handling, clear, load sample, live mode, copy, keyboard shortcuts, URL parser, mode info banner)
- Total: **750 tests** (18 suites)

### 🐛 Bug Fixes
- **String Escaper** – `loadSampleBtn` handler called `handleProcess()` (undefined) instead of `process()` — sample data was loaded but never automatically processed when auto-process was enabled
- **String Escaper** – Removed dead outer `t()` helper function (was shadowed by identical local `t()` in `open()` and never called)
- **String Escaper** – Removed unused variable `mainRow` in `open()`

### 🧪 Tests
- `stringEscaperTool.test.js` – 83 tests (Registration, UI rendering, HTML/XML/JavaScript/JSON/SQL/CSV escape+unescape, empty input, output info, clear, auto-process, load sample, copy, layout toggle)
- Total: **675 tests** (17 suites)

### 🔒 Security
- **Regex Tester** – Fixed XSS vulnerability in `highlightMatches()`: `before`/`after` text segments were never escaped with `escapeHtml()` before being rendered via `innerHTML` — `<script>` tags in test string could be executed; highlighting logic switched to linear construction (ascending sorted), all segments now properly escaped

### 🐛 Bug Fixes
- **Regex Tester** – `handleCopyMatches()` built `matchesText` but never called `copyToClipboard()` — clipboard stayed empty, toast appeared anyway; added `copyToClipboard(matchesText)`
- **Regex Tester** – `handleClear()` showed `test_button` translation key as placeholder text instead of the correct `placeholder_text` hint; placeholder HTML now identical to `renderUI()`
- **Regex Tester** – Fixed `<h3>...</h2>` HTML tag mismatch in `$customNoticeContent` of all 5 non-EN language versions (de, es, fr, it, pt)
- **Regex Tester** – Feature list: Removed "Common regex patterns library" (not implemented) in all 6 language versions and replaced with "Copy and download match results"
- **Regex Tester** – Flag listing in all 6 language versions corrected from `(g, i, m, s, u)` to `(g, i, m, s, u, y)` (`y` flag is implemented but was missing in description)
- **Regex Tester** – Replaced hardcoded English strings `"Highlighted Matches"` and `"Match N"` with i18n keys (`highlighted_matches_title`, `match_label`); added 2 new keys to all 6 language JSONs
- **Regex Tester** – Removed unused variable `highlightedText` in `renderResults()`

### 🧪 Tests
- `regexTesterTool.test.js` – 51 tests (Registration, UI rendering, flag sync, successful matches, no match, invalid pattern, XSS security, clear, copy matches, download, infinite loop prevention, keyboard shortcuts)
- Total: **592 tests** (16 suites)

### 🐛 Bug Fixes
- **QR Code Generator** – Fixed `<h3>...</h2>` tag mismatch in `$customNoticeContent` of all 5 non-EN language versions (de, es, fr, it, pt)
- **QR Code Generator** – Corrected size labels in all 6 i18n JSONs: dropdown options showed wrong pixels (200×200/300×300/400×400/512×512 instead of actual 128×128/256×256/512×512/1024×1024)
- **QR Code Generator** – Fixed library resource link in all 6 PHP files: linked to `davidshimjs/qrcodejs` (unused library), now correctly `kazuhikoarase/qrcode-generator`
- **QR Code Generator** – Replaced hardcoded English error messages in `downloadQRCode()` (`'No QR code to download'`, `'Error downloading QR code'`) with i18n keys; added 2 new keys (`noQRCodeToDownload`, `errorDownload`) to all 6 language JSONs
- **QR Code Generator** – Changed `console.log` → `console.debug` in `generateQRCode()`
- **QR Code Generator** – Corrected misleading feature claim "Error correction levels (L, M, Q, H)" in all 6 PHP files: tool hardcodes level H without UI selector; now declared as "Maximum error correction (level H)"

### 🧪 Tests
- `qrCodeGeneratorTool.test.js` – 65 tests (Registration, UI rendering, mode switching, URL/text/vCard/WiFi content builder, WiFi escaping, QR generation, download button states, clearAll)
- Total: **541 tests** (15 suites)

### 🐛 Bug Fixes
- **Homepage (index.php)** – Corrected wrong tool keys `characterReference` / `emojiReference` in es/, fr/, it/, pt/ (correct: `characterReferenceTool` / `emojiReferenceTool`); i18n data for these two cards was never loaded
- **Homepage (index.php)** – Applied missing HTML minification in all 5 language versions (de/, es/, fr/, it/, pt/): added `ob_start()` at beginning and `minify_html_output(ob_get_clean())` at end
- **Homepage (index.php)** – Replaced German fallback texts (`'Daten-Konverter'`, `'PX ⇄ REM Konverter'`, `'Passwort Generator'`) in es/, fr/, it/, pt/ with English fallbacks (`'Data Converter'`, `'PX ⇄ REM Converter'`, `'Password Generator'`)
- **Homepage pt/index.php** – Fixed broken button text `Utilit\n\nários` (line break in middle of word) to `Utilitários`
- **Homepage (index.php)** – Replaced outdated German HTML comments `<!-- Dienstprogramme Kategorie -->` in es/, fr/, it/, pt/ with `<!-- Utilities -->`

- **PX to REM Converter** – Fixed `<h3>...</h2>` tag mismatch in all 5 non-EN language versions (de, es, fr, it, pt)
- **Punycode Converter** – Fixed `<h3>...</h4>` tag mismatch in all 5 non-EN language versions (de, es, fr, it, pt); `downloadBtn` now uses `window.DownloadUtils.downloadText()` instead of manual blob/URL pattern; implemented batch processing (multi-line input) – each line is converted separately (previously entire text was treated as one domain)

### 🧪 Tests
- `pxToRemConverterTool.test.js` – 66 tests (Registration, UI rendering, px→rem/em/percent/tailwind, reverse conversion, preset buttons, clear buttons, copy buttons, conversion table, reverse labels)
- `punycodeConverterTool.test.js` – 36 tests (Registration, UI rendering, encoding Unicode→Punycode, decoding Punycode→Unicode, auto-detection, example button, clear, manual convert, copy, download, stats)
- Total: **476 tests** (14 suites)

### 🔒 Security
- `tool-loader.js` / `tool-registry.js`: `toolId` secured via `escapeHtml()` before `innerHTML` (XSS)
- `i18n.js`: `getCookie()` uses regex escaping (ReDoS prevention)

### 🐛 Bug Fixes
- **JSON Formatter & Validator** – Removed empty `getIndent()` declaration (line 421) (duplicate function without body); changed `var` → `const`/`let` for all variables in `initializeTool()` (9 variables); `downloadBtn` now uses `window.DownloadUtils.downloadText()` instead of manual blob/URL pattern
- **HTML Entity Encoder/Decoder** – Fixed `performConversion` → `convert` (ReferenceError in `loadSampleBtn` handler); `encodeToAllNamedEntities` regex `/./g` → `/[\s\S]/g` (newlines were skipped); download now uses `window.DownloadUtils.downloadText()` instead of manual blob/URL
- **Hash Generator** – Fixed `</h3>` instead of `</h2>` in `$customNoticeContent` of all 5 language versions (de, es, fr, it, pt); removed dead variables (`chunkSize`, `chunks`, `offset`) in `hashFile()`; fixed event listener leak in `generateSRI()` (guard flag prevents double registration)
- **Emoji Reference** – Search ignored active category (`renderEmojis()` without `currentCategory`); `setupCopyButtons()` accumulated event listeners on every pagination (now once in `setupEventListeners`)
- **Data Converter** – Fixed `handleConversion` → `performConversion` (ReferenceError); `indentationWrapper` shown again after timestamp → XML/CSV; replaced dead samples; removed unused variables
- **Data Converter** – `timestampToDate` outputs ` UTC` suffix; roundtrip timestamp ↔ date now timezone-independent and correct
- **Code Formatter** – Fixed `handleFormat` → `formatCode` (ReferenceError); HTML beautifier void/self-closing handling; CSS minifier removed colon stripping; `execCommand` → `clipboard.writeText`; replaced dead samples; removed duplicate `t()`
- **Aspect Ratio Calculator** – GCD recursive → iterative; `simplifyRatio` decimal scaling refined; preset labels i18n-ized; removed `t()` duplicate
- **Base64 Encoder/Decoder** – `=` padding for URL-safe in `decodeToFile()`; added regex `$` anchor; fixed memory leak (unrevoked object URLs); `clearBtn` resets file state
- **Character Reference** – Fixed `t.xxx` → `t('xxx')` (10 places); removed duplicate event listener; extracted `buildRowHTML` / `appendLoadMoreRow`; added 16 missing i18n keys
- **assets/js (20 Fixes)** – Race condition in `i18n.js`; `throttle()` this context; null checks in `color-modes.js`; sidebar scroll for desktop+mobile; replaced deprecated `performance.timing` API; etc.
- **Layout Toggle Button** – Fixed CSS transform conflict (`translate-middle` vs. `.btn-layout-toggle-stacked`)

### 🌐 i18n
- **JSON Formatter & Validator** – `en.json` `card_description`: ". in" → "in" (faulty sentence break); `de.json` `card_description`: truncated "Features:." → complete sentence
- **HTML Entity Encoder/Decoder** – Filled `featureList` and `keywords` in SEO section of all 6 language JSONs (were empty)
- **Emoji Reference** – Extracted 7 hardcoded English UI strings to all 6 language JSONs (`loadingEmojis`, `loadError`, `noResults`, `loadMore`, `loading`, `copyEmoji`, `copyCode`); fixed typo in `en.json` `card_description`

### ✨ Features
- Sidebar navigation: Accordion behavior (only one category open at a time)

### 🏗️ Build
- Removed JS bundling (382 → 129 lines `build.sh`); files loaded individually
- Removed duplicate logger module (`assets/js/lib/logger.js`)

### 🐛 Bug Fixes
- **Password Generator** – Used `d-none` instead of `hidden` for `#customCharsetOptions` (Bootstrap 5 doesn't know `.hidden`; custom charset panel was visible in all modes); fixed `</h3>` instead of `</h2>` in `$customNoticeContent` of all 5 non-EN language versions (de, es, fr, it, pt); corrected minimum length in feature list from "4" to "8" (matches `min="8"` of slider) – all 6 language versions; added `require()` fallback in `loadWordlist()` for CJS environments (Jest)
- **JWT Decoder** – Fixed `</h3>` instead of `</h2>` in `$customNoticeContent` of German version (`de/jwt-dekodierer/index.php`)
- **Lorem Ipsum** – Fixed `</h3>` instead of `</h2>` in `$customNoticeContent` of all 5 non-EN language versions (de, es, fr, it, pt); fixed missing `</p>` in `it/lorem-ipsum/index.php`; fixed missing line breaks in `es/lorem-ipsum/index.php`; removed false HTML output feature claims from all 6 PHP files and `config/tools.php` (feature not implemented)

### 🧪 Tests
- `codeFormatterTool.test.js` – 35 tests (HTML/CSS/JS/XML/SQL beautify+minify, UI)
- `dataConverterTool.test.js` – 45 tests (JSON↔XML, JSON↔YAML, JSON↔CSV, timestamp↔date, UI)
- `aspectRatioCalculator.test.js` – 14 tests · `base64EncoderDecoder.test.js` – 13 tests · `characterReference.test.js` – 16 tests
- `emojiReferenceTool.test.js` – 19 tests (Registration, initial render, category filter, search, XSS, copy, fetch error)
- `hashGeneratorTool.test.js` – 26 tests (Registration, UI rendering all 5 modes, CryptoUtils, text hashing, HMAC, hash comparison, uppercase toggle)
- `htmlEntityTool.test.js` – 30 tests (Named/decimal/hex/all-named encoding, decoding, round-trip, UI state, copy, download)
- `jsonFormatterValidatorTool.test.js` – 44 tests (Registration, UI rendering, format, validate, minify, sort keys, auto-fix, clear, load sample, copy, download, path extractor, escape/unescape)
- `jwtDecoderTool.test.js` – 30 tests (Registration, UI rendering, decode happy path, no-expiry, error handling, clear, load example, keyboard shortcut, whitespace trimming)
- `loremIpsumTool.test.js` – 42 tests (Registration, UI rendering, auto-generation, paragraphs, sentences, words, combined, validation, counts, clear, copy)
- `passwordGeneratorTool.test.js` – 55 tests (Registration, UI rendering, auto-generation, password generation, pattern generation, passphrase generation, strength indicator, download, mode switching, copy, clear, custom charset)
- Total: **374 tests** (12 suites) · Framework: Jest 30 + jsdom · Shell scripts removed

---

## [1.0.0] – 2026-01-03

Initial production release: 19 tools × 6 languages, client-side only, 100% OWASP compliant.

### Tools
| Category | Tools |
|----------|-------|
| Cryptography | UUID Generator, Password Generator, Hash Generator, JWT Decoder |
| Data | JSON Formatter, Code Formatter, Data Converter |
| Encoding | Base64, URL Encoder, Punycode, HTML Entity |
| Strings | String Escaper, Regex Tester |
| Frontend | Aspect Ratio Calculator, Px→Rem, QR Code, Lorem Ipsum |
| Reference | Character Reference, Emoji Reference |

### Stack
- Frontend: Bootstrap 5.3.0 + Bootstrap Icons 1.11.0 + Vanilla JS
- Backend: PHP 8+ (100% `strict_types`) + Apache 2.4+
- Security: Web Crypto API, CSP (nonce), DOMPurify 3.0.9, SRI, HSTS
- i18n: 6 languages (en, de, es, pt, fr, it), ~1261 keys per language

---

## Contributors
- **Ramon Kaes** – Development, Architecture
- **Claude Sonnet 4.6** (Anthropic) – Code Assistant & Reviewer
