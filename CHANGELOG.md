# Changelog – WebDev-Tools

Format: [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) · Versioning: [SemVer](https://semver.org/)

---

## [2.1.1] – 2026-04-17

### 🔍 SEO
- **Page Titles (TODO #1)** – 26 problematische Seitentitel optimiert (55-65 Zeichen, keyword-optimiert):
  - 24 PHP-Seiten: index, about, privacy, imprint (alle 6 Sprachen)
  - 6 i18n JSON-Einträge: aspectRatioCalculator meta_title
  - Template: "[Tool] – [Function] [Benefits] [Keywords]"
- **Internal Link Texts (TODO #2)** – Interne Linktexte verbessert:
  - linkTitle.card von <60 auf 60-80 Zeichen erweitert (EN: 95%, DE: 80%)
  - Keywords ergänzt: Format-Namen (HTML, JSON), Features (drag & drop), Benefits (secure, online)
  - Navigation: title-Attribute für Legal-Links (About, Imprint, Privacy) in allen 6 Sprachen
- **Heading Structure (TODO #3)** – Überschriften-Hierarchie korrigiert:
  - Hierarchie-Lücken: 6 → 0 (100% behoben)
  - Leere Headings: 120 → 0 (100% behoben)
  - Template: `<h6>` → `<h3>` für "On this page" Sidebar
  - Homepage: `<h3>` Tool-Cards → `<div>` (keine semantischen Überschriften für Navigation)
  - Tools: `<h3>` alert-headings → `<div>` in customNoticeContent (~60 Dateien)
  - Korrekte Hierarchie: H1 (Tool-Titel) → H2 (Sections) → H3 (Unterabschnitte)

### 🛠️ Tools
- **Audit Scripts** – Python-Scripts für SEO-Analyse erstellt:
  - `audit_meta_titles.py` – Page Title Längen-Analyse
  - `audit_all_titles.py` – Vollständige Title-Validierung
  - `audit_link_texts.py` – Generische/leere/zu lange Linktexte
  - `audit_card_titles.py` – linkTitle.card Längen-Analyse (60-80 Zeichen)
  - `audit_headings.py` – Heading-Hierarchie-Analyse (H1-H6)

### 📝 Documentation
- **TODO.md** – SEO-Optimierungen dokumentiert (TODO #1, #2, #3 abgeschlossen)

---

## [2.1.0] – 2026-04-17

### ✨ Features
- **SRI Generator** – Neues Tool (#20): Subresource Integrity Hashes für CDN-Ressourcen generieren; SHA-256, SHA-384, SHA-512; URL-Fetch, Datei-Upload oder Text-Eingabe; fertige `<script>`/`<link>`-Tags mit integrity-Attribut; Web Crypto API basiert
- **UI-Redesign** – Kompaktere Heading-Hierarchie: Tool-Titel h3→h5, Section-Headings h5→h6, Grid-Gaps g-4→g-3
- **Tabler Color Palette** – Bootstrap-Farben durch Tabler-inspirierte Palette ersetzt (#066fd1 Blue, #2fb344 Green, etc.)

### 🔒 Security
- **CSP** – `connect-src 'self' https:` ergänzt (für SRI URL-Fetch)

### 🐛 Bug Fixes
- **TOC Generator** – Tool-Header-Überschrift erschien fälschlicherweise im Inhaltsverzeichnis
- **Tool Cards** – Hover-Animation (translateY) entfernt für weniger Ablenkung

### 🧪 Tests
- `sriGeneratorTool.test.js` – 31 Tests (Registration, UI-Rendering, Hash-Generierung, Algorithmus-Auswahl, Copy, Sample)
- Gesamt: **841 Tests** (20 Suites)

### 🏗️ Build
- `sri-generator` in Build-Skript aufgenommen
- sass von ^1.70.0 auf ^1.99.0 aktualisiert
- Sitemaps mit aktualisierten Daten regeneriert

---

## [2.0.2] – 2026-04-02

### 🔒 Security
- **Code Formatter** – DOM-XSS-Lücke in `codeFormatterTool.js` behoben: `error.message` der Terser-Bibliothek wurde ungefiltert via `innerHTML` gerendert; da Terser Parse-Errors Teile des User-Inputs in die Fehlermeldung einbettet, konnte ein Angreifer HTML/JS durch einen präparierten Code-Input ausführen; Fix: Icon als statisches `innerHTML`, Fehlermeldung via `createTextNode()` als separaten Textknoten angehängt

---

## [2.0.1] – 2026-03-24

### 🐛 Bug Fixes
- **Sidebar Navigation** – Bootstrap-Ladereihenfolge korrigiert: `sidebar-navigation.js` prüfte `typeof bootstrap` beim Laden, fand aber noch kein Bootstrap-Objekt, da `footer.php` (mit Bootstrap) erst danach eingebunden wurde; Reihenfolge in `partials/tool-base.php` und allen 6 Homepage-Varianten (en, de, es, fr, it, pt) getauscht
- **Sidebar Navigation** – Race Condition zwischen `sidebar-persistence.js` und `sidebar-navigation.js` behoben: `restoreStatesEarly()` öffnete per `requestAnimationFrame` gespeicherte Kategorien **nach** DOMContentLoaded und überschrieb damit den von `initSidebarNavigation()` korrekt gesetzten Zustand; rAF-Callback bricht jetzt ab wenn ein aktives Tool-Link vorhanden ist

### 🔒 Security / CSP
- **clipboard-utils.js** – CSP-Verstoß (`style-src-elem`) behoben: `addToastStyles()` injizierte ein dynamisches `<style>`-Element per JavaScript, das von `style-src 'self'` blockiert wurde; Styles in `assets/css/clipboard-toast.css` ausgelagert und via `<link>` in `partials/head.php` eingebunden

### ✨ Features
- **Hash Generator** – „Load Example"-Button in Text-Modus (`Hello, World!`) und HMAC-Modus (`The quick brown fox…` / Secret `secret-key`) hinzugefügt; befüllt Eingabefelder und triggert sofort die Berechnung; i18n in allen 6 Sprachen ergänzt
- **Regex Tester** – Beispiel-Dropdown mit 5 vordefinierten Patterns hinzugefügt (Email, URL, Datum YYYY-MM-DD, IPv4, Named Groups); befüllt Pattern, Flags und Teststring auf einmal und triggert den Test automatisch; i18n in allen 6 Sprachen ergänzt

---

## [2.0.0] – 2026-03-23

### 🐛 Bug Fixes
- **UUID Generator** – `generateUUIDv1()` produzierte systematisch falsche UUIDs: JavaScript-Bitwise-Operatoren (`>>`, `&`) truncaten auf 32-bit-Integer, sodass der 60-bit-Timestamp (~1.4×10¹⁷) überlief — `timeMid` war immer `0000`, `timeHiVersion` immer `1000` unabhängig von der Systemzeit; auf `BigInt`-Arithmetik umgestellt, RFC 4122 korrekte v1-UUIDs werden jetzt generiert
- **UUID Generator** – `<h3>...</h2>` HTML-Tag-Mismatch in `$customNoticeContent` aller 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt) behoben
- **UUID Generator** – `$featuresSectionTitle` und `$resourcesSectionTitle` fehlten in `pt/uuid-generator/index.php`
- **UUID Generator** – Download-Button nutzte direkte DOM-Manipulation (`Blob`, `URL.createObjectURL`, `<a>.click()`) statt `window.DownloadUtils.downloadText()` — Projektkonvention wiederhergestellt
- **UUID Generator** – Copy-Icon-Reset-Bug: nach erfolgreichem Kopieren wurde das Icon auf `'bi bi-clipboard'` zurückgesetzt, verlor dabei aber die `me-2`-Klasse des Bulk-Copy-Buttons; Icon-Klassen werden jetzt vollständig erhalten und nur `bi-clipboard` durch `bi-check` ersetzt

### 🧪 Tests
- `uuidGeneratorTool.test.js` – 60 Tests (Registration, UI-Rendering, UUID-v4/v1/v7/NIL-Generierung, Versionsformat-Validierung, Einzelformat-Optionen, Version-Help-Text, Bulk-Generierung, Bulk-Ausgabeformate, Copy-Buttons, Download-Button, Auto-Generate-Checkbox, Crypto-Error-Handling)
- Gesamt: **810 Tests** (19 Suites)

### 🐛 Bug Fixes
- **URL Encoder/Decoder** – `uri_info`-Übersetzung in `fr.json` war `"Informations URI"` (unvollständig/fehlerhaft) statt der korrekten französischen Beschreibung — durch vollständige Übersetzung ersetzt
- **URL Encoder/Decoder** – Feature-Claim „Auto-detection: Automatically detect encoding requirements" in allen 6 PHP-Sprachversionen entfernt; das Feature ist im JS nicht implementiert — ersetzt durch „Live Mode: Real-time encoding/decoding as you type" (tatsächlich vorhanden)

### 🧪 Tests
- `urlEncoderDecoderTool.test.js` – 75 Tests (Registration, UI-Rendering, Mode-Switching, Encode/Decode Component+URI, Line-by-Line, Error-Handling, Clear, Load-Sample, Live-Mode, Copy, Keyboard-Shortcuts, URL-Parser, ModeInfo-Banner)
- Gesamt: **750 Tests** (18 Suites)

### 🐛 Bug Fixes
- **String Escaper** – `loadSampleBtn`-Handler rief `handleProcess()` auf (undefiniert) statt `process()` — Sample-Daten wurden geladen, aber nie automatisch verarbeitet wenn Auto-Process aktiviert war
- **String Escaper** – Tote äußere `t()`-Hilfsfunktion entfernt (wurde durch identische lokale `t()` in `open()` überschattet und nie aufgerufen)
- **String Escaper** – Unbenutzte Variable `mainRow` in `open()` entfernt

### 🧪 Tests
- `stringEscaperTool.test.js` – 83 Tests (Registration, UI-Rendering, HTML/XML/JavaScript/JSON/SQL/CSV Escape+Unescape, leere Eingabe, Output-Info, Clear, Auto-Process, Load-Sample, Copy, Layout-Toggle)
- Gesamt: **675 Tests** (17 Suites)

### 🔒 Security
- **Regex Tester** – XSS-Lücke in `highlightMatches()` behoben: `before`/`after`-Textsegmente wurden nie mit `escapeHtml()` escaped, bevor sie per `innerHTML` gerendert wurden — `<script>`-Tags im Test-String konnten ausgeführt werden; Highlighting-Logik auf linearen Aufbau (aufsteigend sortiert) umgestellt, alle Segmente werden jetzt korrekt escaped

### 🐛 Bug Fixes
- **Regex Tester** – `handleCopyMatches()` hat `matchesText` aufgebaut, aber `copyToClipboard()` nie aufgerufen — Clipboard blieb leer, Toast erschien trotzdem; `copyToClipboard(matchesText)` ergänzt
- **Regex Tester** – `handleClear()` zeigte `test_button`-Übersetzungsschlüssel als Platzhaltertext statt des korrekten `placeholder_text`-Hinweises; Placeholder-HTML jetzt identisch mit `renderUI()`
- **Regex Tester** – `<h3>...</h2>` HTML-Tag-Mismatch in `$customNoticeContent` aller 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt) behoben
- **Regex Tester** – Feature-Liste: „Common regex patterns library" (nicht implementiert) in allen 6 Sprachversionen entfernt und durch „Copy and download match results" ersetzt
- **Regex Tester** – Flag-Auflistung in allen 6 Sprachversionen von `(g, i, m, s, u)` auf `(g, i, m, s, u, y)` korrigiert (`y`-Flag ist implementiert, fehlte aber in der Beschreibung)
- **Regex Tester** – Hardcodierte englische Strings `"Highlighted Matches"` und `"Match N"` durch i18n-Schlüssel ersetzt (`highlighted_matches_title`, `match_label`); 2 neue Keys in alle 6 Sprach-JSONs ergänzt
- **Regex Tester** – Unbenutzte Variable `highlightedText` in `renderResults()` entfernt

### 🧪 Tests
- `regexTesterTool.test.js` – 51 Tests (Registration, UI-Rendering, Flag-Sync, Erfolgreiche Matches, Kein Match, Ungültiges Pattern, XSS-Sicherheit, Clear, Copy-Matches, Download, Infinite-Loop-Prevention, Keyboard-Shortcuts)
- Gesamt: **592 Tests** (16 Suites)

### 🐛 Bug Fixes
- **QR Code Generator** – `<h3>...</h2>` Tag-Mismatch in `$customNoticeContent` aller 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt) behoben
- **QR Code Generator** – Größen-Labels in allen 6 i18n-JSONs korrigiert: Dropdown-Optionen zeigten falsche Pixel (200×200/300×300/400×400/512×512 statt tatsächlich 128×128/256×256/512×512/1024×1024)
- **QR Code Generator** – Library-Ressourcenlink in allen 6 PHP-Dateien korrigiert: verlinkten auf `davidshimjs/qrcodejs` (nicht genutzte Library), jetzt korrekt `kazuhikoarase/qrcode-generator`
- **QR Code Generator** – Hardcodierte englische Fehlermeldungen in `downloadQRCode()` (`'No QR code to download'`, `'Error downloading QR code'`) durch i18n-Schlüssel ersetzt; 2 neue Keys (`noQRCodeToDownload`, `errorDownload`) in alle 6 Sprach-JSONs ergänzt
- **QR Code Generator** – `console.log` → `console.debug` in `generateQRCode()`
- **QR Code Generator** – Irreführender Feature-Claim „Error correction levels (L, M, Q, H)" in allen 6 PHP-Dateien korrigiert: Tool hardcoded Stufe H ohne UI-Selektor; jetzt als „Maximum error correction (level H)" deklariert

### 🧪 Tests
- `qrCodeGeneratorTool.test.js` – 65 Tests (Registration, UI-Rendering, Mode-Switching, URL/Text/vCard/WiFi Content-Builder, WiFi-Escaping, QR-Generierung, Download-Button-States, clearAll)
- Gesamt: **541 Tests** (15 Suites)

### 🐛 Bug Fixes
- **Homepage (index.php)** – Falsche Tool-Keys `characterReference` / `emojiReference` in es/, fr/, it/, pt/ korrigiert (korrekt: `characterReferenceTool` / `emojiReferenceTool`); i18n-Daten für diese beiden Karten wurden nie geladen
- **Homepage (index.php)** – Fehlende HTML-Minifizierung in allen 5 Sprachversionen (de/, es/, fr/, it/, pt/) nachgezogen: `ob_start()` am Anfang und `minify_html_output(ob_get_clean())` am Ende ergänzt
- **Homepage (index.php)** – Deutsche Fallback-Texte (`'Daten-Konverter'`, `'PX ⇄ REM Konverter'`, `'Passwort Generator'`) in es/, fr/, it/, pt/ durch englische Fallbacks (`'Data Converter'`, `'PX ⇄ REM Converter'`, `'Password Generator'`) ersetzt
- **Homepage pt/index.php** – Gebrochener Button-Text `Utilit\n\nários` (Zeilenumbruch mitten im Wort) zu `Utilitários` zusammengeführt
- **Homepage (index.php)** – Veraltete deutsche HTML-Kommentare `<!-- Dienstprogramme Kategorie -->` in es/, fr/, it/, pt/ durch `<!-- Utilities -->` ersetzt

- **PX to REM Converter** – `<h3>...</h2>` Tag-Mismatch in allen 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt) behoben
- **Punycode Converter** – `<h3>...</h4>` Tag-Mismatch in allen 5 Nicht-EN-Sprachversionen (de, es, fr, it, pt) behoben; `downloadBtn` nutzt jetzt `window.DownloadUtils.downloadText()` statt manuellem Blob/URL-Pattern; Batch-Verarbeitung (mehrzeilige Eingabe) implementiert – jede Zeile wird separat konvertiert (zuvor wurde der gesamte Text als eine Domain behandelt)

### 🧪 Tests
- `pxToRemConverterTool.test.js` – 66 Tests (Registration, UI-Rendering, px→rem/em/percent/tailwind, Reverse-Konvertierung, Preset-Buttons, Clear-Buttons, Copy-Buttons, Conversion Table, Reverse-Labels)
- `punycodeConverterTool.test.js` – 36 Tests (Registration, UI-Rendering, Encoding Unicode→Punycode, Decoding Punycode→Unicode, Auto-Erkennung, Example-Button, Clear, Manual-Convert, Copy, Download, Stats)
- Gesamt: **476 Tests** (14 Suites)

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
- Backend: PHP 8+ (100% `strict_types`) + Apache 2.4+
- Security: Web Crypto API, CSP (nonce), DOMPurify 3.0.9, SRI, HSTS
- i18n: 6 Sprachen (en, de, es, pt, fr, it), ~1261 Keys pro Sprache

---

## Contributors
- **Ramon Kaes** – Entwicklung, Architektur
- **Claude Sonnet 4.6** (Anthropic) – Code-Assistent & Reviewer
