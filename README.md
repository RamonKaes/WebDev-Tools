<div align="center">

# 🛠️ WebDev-Tools.info

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Standards](https://img.shields.io/badge/standards-RFC%20%7C%20ISO%20%7C%20W3C-green.svg)](#standards-compliance)
[![Security](https://img.shields.io/badge/security-client--side%20only-brightgreen.svg)](#-security-architecture)
[![Languages](https://img.shields.io/badge/languages-6-orange.svg)](#internationalization)
[![Tools](https://img.shields.io/badge/tools-20-success.svg)](#%EF%B8%8F-available-tools)
[![CI](https://github.com/RamonKaes/WebDev-Tools/actions/workflows/ci.yml/badge.svg)](https://github.com/RamonKaes/WebDev-Tools/actions/workflows/ci.yml)

### **Privacy-First Developer Utilities for Modern Web Development**

*A professional-grade, client-side-only platform providing 20 essential tools for software developers, system administrators, and web engineers. All operations execute locally in your browser — **your data never leaves your device.***

**🔗 Live Platform:** [https://webdev-tools.info/](https://webdev-tools.info/)

</div>

---

<div align="center">

## 🎯 Why WebDev-Tools?

</div>

| 🔒 **Privacy-First** | ⚡ **Performance** | 🎯 **Standards** | 🌍 **Global** |
|:---:|:---:|:---:|:---:|
| **Zero Server Processing**<br>All operations client-side | **No Network Latency**<br>Limited only by your CPU | **RFC/ISO Compliant**<br>Industry specifications | **6 Languages**<br>Full localization |
| No data transmission | Offline capable | IETF, NIST, W3C standards | EN, DE, ES, PT, FR, IT |
| No tracking, no logs | Bulk operations | Cryptographically secure | Native speaker reviewed |

---

## 📑 Table of Contents

<details>
<summary><strong>Click to expand full table of contents</strong></summary>

- [🎯 Why WebDev-Tools?](#-why-webdev-tools)
- [✨ Key Features](#-key-features)
  - [🔒 Privacy-First Architecture](#-privacy-first-architecture)
  - [⚡ Performance & Reliability](#-performance--reliability)
  - [🎯 Standards-Based Implementation](#-standards-based-implementation)
  - [🌍 Multi-Language Support](#-multi-language-support)
- [🔐 Security Architecture](#-security-architecture)
  - [Client-Side-Only Execution](#client-side-only-execution)
  - [Cryptographic Security](#cryptographic-security)
  - [Risk Mitigation Matrix](#risk-mitigation-matrix)
  - [Open Source & Auditability](#open-source--auditability)
  - [Security Guarantees](#security-guarantees)
- [🛠️ Available Tools](#%EF%B8%8F-available-tools)
  - [🔐 Cryptography & Security](#-cryptography--security)
  - [📊 Data Formatting & Serialization](#-data-formatting--serialization)
  - [🌐 Encoding & Network](#-encoding--network)
  - [🛡️ String Manipulation & Security](#%EF%B8%8F-string-manipulation--security)
  - [🎨 Frontend & Design](#-frontend--design)
  - [📚 Reference & Documentation](#-reference--documentation)
- [Standards Compliance](#standards-compliance)
- [Code Review & Learnings](#code-review--learnings)
- [Internationalization](#internationalization)
- [Technical Foundation](#technical-foundation)
  - [Technology Stack](#technology-stack)
  - [Project Structure](#project-structure)
  - [Content Security Policy (CSP)](#content-security-policy-csp)
- [Development Methodology](#development-methodology)
  - [AI-Assisted Development](#ai-assisted-development)
  - [Quality Assurance Process](#quality-assurance-process)
  - [Challenges & Solutions](#challenges--solutions)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Local setup](#local-setup)
  - [Configuration](#configuration)
  - [Development commands](#development-commands)
- [Browser Compatibility](#browser-compatibility)
- [Technical Audit](#technical-audit)
- [Contributing](#contributing)
- [Documentation](#documentation)
- [Roadmap](#roadmap)
- [License](#license)
- [Acknowledgments](#acknowledgments)
- [Contact & Support](#contact--support)

</details>

---

## ✨ Key Features

<div align="center">

### Core Principles

</div>

<table>
<tr>
<td width="50%">

### 🔒 **Privacy-First Architecture**

**Zero Data Transmission Philosophy**

- ✅ **Zero Server Processing**: All computations happen in your browser
- ✅ **No Data Transmission**: Sensitive data (passwords, tokens, API keys) never leaves your device
- ✅ **GDPR/CCPA Compliant**: Data minimization by design — we don't collect what we don't have access to
- ✅ **No Tracking**: No analytics, no cookies (except language preference), no user profiling
- ✅ **Transparent Operations**: All code is open-source and auditable

**Philosophy**: *"The most secure server is no server at all"*

</td>
<td width="50%">

### ⚡ **Performance & Reliability**

**Blazing Fast, Always Available**

- ✅ **Client-Side Execution**: No network latency — performance limited only by your CPU
- ✅ **Installable**: Add it to your home screen or desktop as an app (web app manifest, no service worker — nothing is cached on your device)
- ✅ **No Network Needed While You Work**: Once a tool page is open, every operation runs locally
- ✅ **Bulk Operations**: Handle thousands of items efficiently (UUID generation, data conversion)
- ✅ **Large File Support**: Process substantial datasets without server upload limits
- ✅ **Instant Results**: Real-time processing without API rate limits

**No queues. No timeouts. No rate limits.**

</td>
</tr>
<tr>
<td width="50%">

### 🎯 **Standards-Based Implementation**

**Built on Industry Specifications**

- 📋 **IETF RFCs**: RFC 4648 (Base64), RFC 8259 (JSON), RFC 4122/9562 (UUID), RFC 7519 (JWT), RFC 3986 (URI), RFC 3492 (Punycode)
- 🏛️ **ISO Standards**: ISO/IEC 18004 (QR Codes)
- 🔐 **NIST Guidelines**: SP 800-63B (Password Authentication)
- ♿ **W3C/WCAG**: Accessibility and web standards compliance
- 🔒 **Cryptographic Standards**: FIPS 180-4 (SHA family), Web Crypto API (CSPRNG)

**Not opinions. Standards.**

</td>
<td width="50%">

### 🌍 **Multi-Language Support**

**Truly International Platform**

Available in **6 languages** with culturally-aware translations:

| Language | Code | Status |
|----------|------|--------|
| 🇬🇧 English | `en` | ✅ Complete (reference) |
| 🇩🇪 German | `de` | ✅ Complete |
| 🇪🇸 Spanish | `es` | ✅ Complete |
| 🇵🇹 Portuguese | `pt` | ✅ Complete |
| 🇫🇷 French | `fr` | ✅ Complete |
| 🇮🇹 Italian | `it` | ✅ Complete |

Key parity between the six files is enforced by `npm run check:i18n`.

**Dynamic switching** — no page reload required

</td>
</tr>
</table>

---

## 🔐 Security Architecture

<div align="center">

### **"The Most Secure Server Is No Server At All"**

WebDev-Tools implements a **Privacy-by-Design** architecture that eliminates common security risks associated with online utilities.

</div>

### Client-Side-Only Execution

```
╔═══════════════════════════════════════════════════════════════╗
║  Your Browser (Client)                                        ║
║  ┌─────────────────────────────────────────────────────────┐  ║
║  │ 1. Input Data (e.g., JWT token, password)               │  ║
║  │ 2. JavaScript Processing (100% Local)                   │  ║
║  │ 3. Result Display (Never transmitted)                   │  ║
║  └─────────────────────────────────────────────────────────┘  ║
║                                                               ║
║  ❌ NO server communication                                   ║
║  ❌ NO data logging                                           ║
║  ❌ NO third-party APIs                                       ║
║  ❌ NO database storage                                       ║
╚═══════════════════════════════════════════════════════════════╝
```

**Impact**: Zero attack surface for man-in-the-middle attacks, data breaches, or unauthorized access.

---

### Cryptographic Security

<table>
<tr>
<td width="50%">

#### 🔐 CSPRNG Usage (Cryptographically Secure Pseudorandom Number Generator)

Security-critical tools utilize the **Web Crypto API** (`crypto.getRandomValues()`), **NOT** the predictable `Math.random()`.

**Entropy Sources:**
- Operating system entropy pool
- Hardware random number generators (HRNG)
- Thermal noise, mouse movements, keyboard timing
- System interrupts and environmental factors

**Tools Using CSPRNG:**
- ✅ Password Generator
- ✅ UUID Generator (v4, v7)
- ✅ QR Code Generation (security-sensitive)

</td>
<td width="50%">

#### 🛡️ Defense in Depth

**Multi-Layer Security Model:**

1. **Content Security Policy (CSP)**
   - Nonce-based script execution
   - No inline scripts permitted
   - Strict external resource policy

2. **Security Headers**
   - HSTS (Strict-Transport-Security)
   - `frame-ancestors 'none'` in the CSP, with `X-Frame-Options: DENY` as the
     equivalent for older browsers
   - X-Content-Type-Options: nosniff
   - Referrer-Policy: strict-origin-when-cross-origin
   - Permissions-Policy: restrictive

3. **Subresource Integrity (SRI)**
   - Both CDN-hosted scripts carry SHA-384 integrity hashes
   - qrcode-generator 1.4.4 (QR code tool) and terser 5.31.0 (code formatter, loaded on first use)
   - Everything else, including Bootstrap and Bootstrap Icons, is served from the site's own origin

</td>
</tr>
</table>

---

### Risk Mitigation Matrix

| Risk Category | Server-Side Tools | WebDev-Tools (Client-Side) | Impact |
|---------------|-------------------|----------------------------|--------|
| **Data Interception** | ⚠️ Possible<br>*(HTTPS mitigates but doesn't eliminate)* | ✅ **Eliminated**<br>*(no transmission)* | 🏆 **Zero risk** |
| **Server Logs** | ⚠️ Credentials/tokens may be logged | ✅ **No logs exist** | 🏆 **Untraceable** |
| **Third-Party Access** | ⚠️ Provider has access to data | ✅ **No third parties** | 🏆 **Private** |
| **MITM Attacks** | ⚠️ Possible if TLS compromised | ✅ **No attack surface** | 🏆 **Immune** |
| **Data Breach** | ⚠️ Server database vulnerable | ✅ **No database** | 🏆 **Breach-proof** |
| **Regulatory Compliance** | ⚠️ GDPR/CCPA burden | ✅ **Compliant by design** | 🏆 **Automatic** |

---

### Open Source & Auditability

**Full Transparency** — The complete source code is available for review and audit:

<div align="center">

| Feature | Status | Link |
|---------|--------|------|
| 🔓 **Public Repository** | ✅ Available | [github.com/RamonKaes/WebDev-Tools](https://github.com/RamonKaes/WebDev-Tools) |
| 📋 **MIT License** | ✅ Open | Free to fork, modify, and distribute |
| 🔍 **Community Review** | ✅ Welcome | Anyone can inspect code and report security issues |
| 🛡️ **Security Policy** | ✅ Documented | See [SECURITY.md](SECURITY.md) |

</div>

**Security researchers welcome** — Found a vulnerability? See our [Security Policy](SECURITY.md) for responsible disclosure.

---

### Security Guarantees

<div align="center">

**WebDev-Tools Security Checklist**

</div>

| Security Feature | Status | Implementation |
|------------------|--------|----------------|
| ✅ **Subresource Integrity (SRI)** | Enabled | Both external scripts verified with SHA-384 hashes |
| ✅ **Content Security Policy (CSP)** | Strict | Nonce-based script execution, no inline or eval allowances |
| ✅ **Security Headers** | Complete | HSTS, X-Frame-Options, CSP, Referrer-Policy, Permissions-Policy, nosniff |
| ✅ **Minimal External Dependencies** | Verified | Data processing uses native browser APIs; only the QR code library and terser come from a CDN |
| ✅ **No Tracking** | Guaranteed | No cookies (except language), no analytics on tool usage |
| ✅ **HTTPS Enforcement** | Production | Redirect in `.htaccess.production`, HSTS with 1-year max-age, includeSubDomains, preload |
| ✅ **XSS Protection** | Code rules | `textContent` for user input in JS, `htmlspecialchars()` in PHP, CSP as backstop; browser tests fail on CSP violations |

**Check the live headers:** [securityheaders.com report](https://securityheaders.com/?q=webdev-tools.info&followRedirects=on)

---

**📚 Detailed Security Documentation**: See [SECURITY.md](SECURITY.md) for comprehensive security architecture details.

---

## 🛠️ Available Tools

<div align="center">

### **20 Professional-Grade Developer Utilities**

*All tools RFC/ISO compliant • Client-side only • Zero data transmission*

</div>

---

### 🔐 Cryptography & Security

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./uuid-generator/">UUID Generator</a></strong></td>
<td>RFC 4122<br>RFC 9562</td>
<td>
• Supports v1, v4, v7 (time-ordered)<br>
• Bulk generation (1-10,000)<br>
• CSPRNG for v4/v7<br>
• Timestamp parsing for v1/v7
</td>
</tr>
<tr>
<td><strong><a href="./password-generator/">Password Generator</a></strong></td>
<td>NIST SP 800-63B</td>
<td>
• Customizable complexity<br>
• Entropy-based strength meter<br>
• Special character sets<br>
• CSPRNG randomness
</td>
</tr>
<tr>
<td><strong><a href="./hash-generator/">Hash Generator</a></strong></td>
<td>FIPS 180-4</td>
<td>
• SHA-1/256/384/512<br>
• HMAC support<br>
• File integrity verification<br>
• Hash comparison
</td>
</tr>
<tr>
<td><strong><a href="./jwt-decoder/">JWT Decoder</a></strong></td>
<td>RFC 7519</td>
<td>
• Header/payload parsing<br>
• Expiry check (exp claim)<br>
• Expiry checking<br>
• Claims extraction
</td>
</tr>
<tr>
<td><strong><a href="./sri-generator/">SRI Generator</a></strong></td>
<td>W3C SRI</td>
<td>
• SHA-256, SHA-384, SHA-512<br>
• Ready-to-use HTML tags<br>
• URL, file, and text input<br>
• Web Crypto API based
</td>
</tr>
</table>

---

### 📊 Data Formatting & Serialization

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./json-formatter-validator/">JSON Formatter & Validator</a></strong></td>
<td>RFC 8259</td>
<td>
• Syntax validation with error reporting<br>
• Tree view & collapsible nodes<br>
• Minification & beautification<br>
• Large file support (>10MB)
</td>
</tr>
<tr>
<td><strong><a href="./code-formatter/">Code Formatter</a></strong></td>
<td>Language-specific</td>
<td>
• HTML, CSS, JS, XML, SQL<br>
• Customizable indentation<br>
• Beautify and minify<br>
• Terser-based JS minification
</td>
</tr>
<tr>
<td><strong><a href="./data-converter/">Data Converter</a></strong></td>
<td>YAML, CSV</td>
<td>
• JSON ↔ XML ↔ YAML ↔ CSV<br>
• Bidirectional conversion<br>
• Clear error messages<br>
• Preserves data types
</td>
</tr>
</table>

---

### 🌐 Encoding & Network

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./base64-encoder-decoder/">Base64 Encoder/Decoder</a></strong></td>
<td>RFC 4648</td>
<td>
• Standard & URL-safe variants<br>
• Binary file support<br>
• Data URIs for images<br>
• Image preview for decoded data
</td>
</tr>
<tr>
<td><strong><a href="./url-encoder-decoder/">URL Encoder/Decoder</a></strong></td>
<td>RFC 3986</td>
<td>
• <code>encodeURI</code> vs <code>encodeURIComponent</code><br>
• Component parsing (protocol, host, path)<br>
• Query string handling<br>
• Fragment identifier support
</td>
</tr>
<tr>
<td><strong><a href="./punycode-converter/">Punycode Converter</a></strong></td>
<td>RFC 3492 (IDNA)</td>
<td>
• Internationalized domain names<br>
• Bidirectional conversion<br>
• Batch conversion (line by line)<br>
• Unicode character support
</td>
</tr>
<tr>
<td><strong><a href="./html-entity-encoder-decoder/">HTML Entity Encoder/Decoder</a></strong></td>
<td>HTML5</td>
<td>
• Named & numeric entities<br>
• XSS prevention escaping<br>
• Full HTML5 entity reference<br>
• Unicode support
</td>
</tr>
</table>

---

### 🛡️ String Manipulation & Security

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./string-escaper/">String Escaper</a></strong></td>
<td>OWASP</td>
<td>
• HTML, SQL, JSON, CSV, JavaScript<br>
• Injection prevention<br>
• Context-aware escaping<br>
• Auto-process mode
</td>
</tr>
<tr>
<td><strong><a href="./regex-tester/">Regex Tester</a></strong></td>
<td>ECMAScript</td>
<td>
• Real-time matching<br>
• Pattern validation<br>
• Performance testing<br>
• Group capture display
</td>
</tr>
</table>

---

### 🎨 Frontend & Design

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./aspect-ratio-calculator/">Aspect Ratio Calculator</a></strong></td>
<td>N/A</td>
<td>
• Bidirectional ratio calculation<br>
• Width/height from ratio<br>
• Responsive design helper<br>
• Common aspect ratios (16:9, 4:3, etc.)
</td>
</tr>
<tr>
<td><strong><a href="./px-to-rem-converter/">Px to Rem Converter</a></strong></td>
<td>WCAG</td>
<td>
• Accessible typography<br>
• Custom base font size<br>
• Bulk conversion<br>
• Reverse conversion (rem → px)
</td>
</tr>
<tr>
<td><strong><a href="./qr-code-generator/">QR Code Generator</a></strong></td>
<td>ISO/IEC 18004</td>
<td>
• Maximum error correction (level H)<br>
• SVG/PNG export<br>
• WiFi/vCard/URL formats<br>
• Customizable size & color
</td>
</tr>
<tr>
<td><strong><a href="./lorem-ipsum/">Lorem Ipsum Generator</a></strong></td>
<td>N/A</td>
<td>
• Configurable paragraphs/words<br>
• Layout testing<br>
• Paragraph/sentence/word modes<br>
• Copy-to-clipboard
</td>
</tr>
</table>

---

### 📚 Reference & Documentation

<table>
<tr>
<th width="25%">Tool</th>
<th width="25%">Standards</th>
<th width="50%">Key Features</th>
</tr>
<tr>
<td><strong><a href="./character-reference/">Character Reference</a></strong></td>
<td>Unicode</td>
<td>
• Search by name/code<br>
• Category filtering<br>
• HTML entities, decimal, hex<br>
• Copy-to-clipboard
</td>
</tr>
<tr>
<td><strong><a href="./emoji-reference/">Emoji Reference</a></strong></td>
<td>Unicode, W3C</td>
<td>
• Categorized emojis<br>
• HTML entities<br>
• Unicode codepoints<br>
• Searchable database
</td>
</tr>
</table>

---

<div align="center">

**🔍 Need something else?**  
[Request a new tool](https://github.com/RamonKaes/WebDev-Tools/issues/new) • [View Roadmap](#roadmap)

</div>

---

## Standards Compliance

WebDev-Tools adheres to established industry specifications to ensure reliability and interoperability:

### RFC Specifications (IETF)

- **RFC 4648** — Base64 Data Encoding
- **RFC 8259** — JSON Data Interchange Format
- **RFC 4122** — UUID URN Namespace (v1, v4)
- **RFC 9562** — UUID Formats (v6, v7, v8)
- **RFC 7519** — JSON Web Token (JWT)
- **RFC 3986** — Uniform Resource Identifier (URI) Generic Syntax
- **RFC 3492** — Punycode (IDNA)

### ISO/IEC Standards

- **ISO/IEC 18004** — QR Code Bar Code Symbology Specification

### NIST Guidelines

- **SP 800-63B** — Digital Identity Guidelines (Authentication and Lifecycle Management)

### W3C & Web Standards

- **WCAG 2.1** — Web Content Accessibility Guidelines
- **HTML5** — Entity references and encoding
- **ECMAScript** — JavaScript language specification for regex and APIs

### Cryptographic Standards

- **FIPS 180-4** — Secure Hash Standard (SHA family)
- **CSPRNG** — Web Crypto API (`crypto.getRandomValues()`)

**Validation**: All implementations have been audited against their respective specifications. See our [Technical Audit Report](#technical-audit) for detailed conformity analysis.

---

## Code Review & Learnings

### External Code Review (2024-12-19)

As part of an external review, four critical issues were identified and addressed:

1. **UUID v1 Security:**
   - Math.random was replaced with crypto.getRandomValues (CSPRNG)
   - Unsafe fallbacks were removed and errors are surfaced in the UI
2. **Manifest Generator BASE_PATH:**
   - BASE_PATH is now read dynamically from `config.php` or via the CLI
   - URLs are validated and corrected for production environments
3. **YAML→JSON Top-Level Lists:**
   - The parser now supports YAML lists at the root level
   - Indentation issues were fixed
4. **JSON→CSV Empty Arrays:**
   - Validation and error handling were added for empty arrays
   - Crash protection and clear error messages implemented

**Key Takeaways:**
- Never use `Math.random` for security-sensitive functionality
- Input validation and robust error handling are essential
- Build scripts must be environment-aware
- Automated checks help prevent regressions

All fixes have been implemented, tested, and documented. See the [CHANGELOG](CHANGELOG.md) for details.

---

## Internationalization

### Language Coverage

The platform provides complete localization across all tools and documentation:

| Language | Code | Scope |
|----------|------|-------|
| English | `en` | Default language |
| German | `de` | Full translation |
| Spanish | `es` | Full translation |
| Portuguese | `pt` | Full translation |
| French | `fr` | Full translation |
| Italian | `it` | Full translation |

### Translation Methodology

- **Static Content**: Translated using Claude Opus 5.5 for technical accuracy
- **Cultural Content**: Translated using Claude Opus 5.5 for nuanced, contextually appropriate language
- **Consistency**: Centralized translation files ensure terminology consistency
- **Quality Assurance**: Manual review by native speakers for critical pages

---

## Technical Foundation

### Technology Stack

```
Frontend:
├── Bootstrap 5.3           # Custom Sass build (build-tools/bootstrap-custom.scss) with only the components in use
├── Bootstrap Icons 1.11.3  # Self-hosted icon font
├── Vanilla JavaScript      # Classic <script> IIFEs, no framework, no bundler
└── Web Crypto API          # Secure random numbers and hashing

Backend:
├── PHP 8 (strict_types)    # Routing, templating, security headers
├── Apache 2.4+             # mod_rewrite, .htaccess
└── Client-side processing  # No backend data processing

Tooling (development only):
├── Jest 30 + jsdom         # Unit tests (tests/unit/)
├── Playwright + axe-core   # Browser and WCAG 2.2 AA tests against the build (tests/browser/)
├── ESLint                  # eslint.config.js
├── build.sh                # Copies to dist/, minifies CSS with csso, compiles Bootstrap with sass
└── lftp                    # FTP(S) deploy (build-tools/deploy-ftp.sh)
```

### Project Structure

```
WebDev-Tools/
├── index.php, about.php, 403/404/500.php
├── config/
│   ├── config.php               # SUPPORTED_LANGS, BASE_PATH, $baseUrl, language detection
│   ├── tools.php                # Tool registry
│   ├── helpers.php              # getToolConfig(), getAllTools(), assetSrc(), loadI18n(), …
│   ├── security-headers.php     # CSP and security headers
│   ├── language-handler.php     # Sets the language cookie (AJAX)
│   ├── manifest.json            # Generated registry dump read by assets/js/tool-loader.js
│   └── i18n/                    # en/de/es/pt/fr/it.json
├── partials/
│   ├── tool-base.php            # Shared tool layout
│   ├── head.php, header-with-sidebar.php, footer.php, related-tools.php, error-template.php
│   └── common-scripts.php       # Shared JS (tool-registry, clipboard/download/a11y utils, tool-loader)
├── assets/
│   ├── js/tools/*Tool.js        # One IIFE per tool
│   ├── js/lib/                  # Shared utilities
│   ├── css/, img/, data/
│   └── bootstrap/, bootstrap-icons/
├── [tool-name]/index.php        # Tool pages (20 tools)
├── de/, es/, pt/, fr/, it/      # Language versions with localized slugs, own sitemap and web manifest
├── build-tools/                 # Sass entry, deploy and verification scripts, i18n check
├── tests/unit/, tests/browser/
├── build.sh, .htaccess, .htaccess.production
└── CHANGELOG.md, SECURITY.md, README.md, docs/
```

### Content Security Policy (CSP)

Set per request in `config/security-headers.php`:

```
default-src 'self';
script-src 'self' 'nonce-{random}' https://cdn.jsdelivr.net;
style-src 'self';
font-src 'self';
img-src 'self' data: blob: https:;
connect-src 'self' https:;
object-src 'none'; media-src 'none'; worker-src 'self'; manifest-src 'self';
frame-ancestors 'none'; base-uri 'self'; form-action 'self'
```

Self-hosted scripts match `'self'`; the few inline scripts in the partials carry the per-request nonce; `cdn.jsdelivr.net` is allowed only for the two SRI-pinned libraries; `connect-src https:` exists for the SRI generator, which fetches arbitrary URLs.

---

## Development Methodology

### AI-Assisted Development

WebDev-Tools was developed using a **hybrid human-AI approach** that combines the efficiency of AI code generation with rigorous human oversight.

#### AI Models Utilized

- **Claude Opus 5.5** (Anthropic) — Primary coding assistant
- **Claude Code** (Anthropic) — Automated code review and quality assurance

#### Quality Assurance Process

1. **Automated Code Review**: Claude Code performs systematic review after each implementation
2. **Human Architecture**: All design decisions made by human developer
3. **Version Control**: Git-based workflow with rollback capability (`git reset --hard`)
4. **Manual Testing**: Comprehensive QA across all 120 tool instances (20 tools × 6 languages)
5. **Standards Validation**: Conformity checks against RFC/ISO specifications

#### Challenges & Solutions

| Challenge | Mitigation |
|-----------|------------|
| **AI Hallucinations** | Claude Code automated review + human oversight |
| **Framework Bias** | Switched from Tailwind to Bootstrap for stability |
| **Code Complexity** | Enforced modular architecture with centralized templates |
| **Translation Quality** | Model selection based on content type (technical vs. cultural) |

**Philosophy**: "Done over Perfect" — Pragmatic choices favoring maintainability and reliability over cutting-edge trends.

---

## Getting Started

### Prerequisites

- **Production**: Apache 2.4 with `mod_rewrite` and PHP 8. The live site runs as a plain PHP/Apache site and **does not need Node.js**; everything under `dist/` is static or PHP.
- **Development**: Node.js >= 22 and npm for tests, lint and the build (`npm install`). The browser tests additionally need `apache2`, `libapache2-mod-php` and a local Chrome.

### Local setup

`config/config.php` sets `BASE_PATH` to `/WebDev-Tools` whenever the host is `localhost` or `127.0.0.1`, so the checkout has to be served at `http://localhost/WebDev-Tools/`:

```bash
cd /var/www/html                 # Apache document root
git clone https://github.com/RamonKaes/WebDev-Tools.git
cd WebDev-Tools && npm install
```

```apache
<Directory /var/www/html/WebDev-Tools>
    AllowOverride All             # the development .htaccess holds the rewrite rules
    Require all granted
</Directory>
```

Then open `http://localhost/WebDev-Tools/`. On any other host name the site assumes the domain root (`BASE_PATH` empty), which is what `dist/` is built for.

### Configuration

- **Base URL and languages**: `config/config.php` (`$baseUrl`, `SUPPORTED_LANGS`, `$supportedLanguages`); the language list is repeated in `config/language-handler.php` and `assets/js/i18n.js`
- **Tools**: `config/tools.php`, then `php config/generate-manifest.php && php config/generate-sitemaps.php`
- **Adding a tool**: step-by-step guide in [docs/techstack/NEUES-TOOL.md](docs/techstack/NEUES-TOOL.md)

### Development commands

```bash
npm test                  # Jest unit tests
npm run test:coverage     # with coverage thresholds
npm run lint              # ESLint
npm run check:i18n        # key parity of the six translation files
bash build.sh             # production build to dist/ (CSS minified, custom Bootstrap compiled)
npm run test:browser      # Playwright + axe against dist/ behind a local Apache
npm run deploy:dry        # what an upload would change; npm run deploy uploads from a clean main checkout
npm run verify:prod       # read-only check of the live site against dist/
```

Developer helper scripts live under `dev/` and `maintenance/`; they are not deployed.

---

## Browser Compatibility

| Browser | Minimum Version | Notes |
|---------|----------------|-------|
| **Chrome** | 90+ | Fully supported |
| **Firefox** | 88+ | Fully supported |
| **Safari** | 14+ | Fully supported |
| **Edge** | 90+ | Fully supported |
| **Opera** | 76+ | Fully supported |

**Requirements**:
- JavaScript enabled
- Web Crypto API support (for CSPRNG tools)
- ES6+ support (modern JavaScript features)

**Progressive Enhancement**: Basic functionality available without JavaScript where applicable.

---

## Technical Audit

What is checked automatically on every push and pull request (`.github/workflows/ci.yml`):

- Jest unit tests on Node 22 and 24 with coverage thresholds, plus ESLint
- Key parity of the six translation files
- `php -l` over every PHP file and up-to-date sitemaps
- The production build, and Playwright browser tests with axe-core (WCAG 2.2 AA) against it
- CodeQL analysis and an external link check run weekly

Normal cases in `tests/browser/tools.spec.js` use expected values from outside the tools (the known SHA-256 digest of `hello`, a public example JWT, known Base64 and Punycode encodings). See the [Technical Documentation](docs/README.md).

---

## Contributing

We welcome contributions from the community! Here's how you can help:

### Areas for Contribution

- 🐛 **Bug Reports**: Found an issue? Open a GitHub issue with reproduction steps
- 🌐 **Translations**: Improve existing translations or add new languages
- 🔧 **New Tools**: Propose or implement additional developer utilities
- 📚 **Documentation**: Enhance README, add tutorials, improve code comments
- ♿ **Accessibility**: Improve WCAG compliance and screen reader support

### Contribution Guidelines

1. **Fork** the repository
2. **Create a feature branch**: `git checkout -b feature/your-feature-name`
3. **Follow coding standards**:
   - Use Bootstrap classes for styling
   - Maintain client-side-only architecture
   - Add appropriate comments and documentation
4. **Verify thoroughly**: Verify across multiple browsers and languages
5. **Submit a Pull Request** with a clear description of changes

### Code Review Process

- All PRs reviewed for security implications
- Standards compliance verification
- Cross-browser testing
- Translation accuracy (for i18n changes)

### Single-Developer Workflow (Recommended)

As the sole maintainer of this repository, you can keep changes lightweight while remaining safe and traceable:

- **Trivial changes (docs, typos)**: Commit directly to `main`:
   ```bash
   git add -A
   git commit -m "docs: fix typo"
   git push origin main
   ```
- **Code changes (recommended)**: Use a feature branch and a quick self-review PR:
   ```bash
   git checkout -b feat/your-change
   npm test
   git add -A
   git commit -m "feat: add ..."
   git push --set-upstream origin feat/your-change
   gh pr create --title "feat: add ..." --body "Short description"
   ```
- **Merge policy**: For most changes, merge PRs yourself once you're confident after running `npm test` and a quick smoke check in the browser.

---

## Documentation

### 📚 Developer Documentation

Detailed technical documentation is available in the [`/docs`](docs/) directory:

- **[Tech Stack Overview](docs/techstack/OVERVIEW.md)** — Architecture, stack components, commands, build and deploy
- **[Adding a Tool](docs/techstack/NEUES-TOOL.md)** — Registry, PHP page, JS pattern, i18n, tests, rewrites (German)
- **[Backend](docs/techstack/BACKEND.md)** — PHP standards, tool registry, i18n, helpers, security headers
- **[Testing](docs/techstack/TESTING.md)** — Jest, Playwright and axe browser tests, lint, CI
- **[Security](docs/techstack/SECURITY.md)** — CSP, headers, XSS prevention, sensitive data (German)

### 🔧 Configuration

- **[Development Server](dev/README.md)** - Local development setup
- **[i18n Translations](config/i18n/README.md)** - Internationalization guide

See [docs/README.md](docs/README.md) for the complete documentation index.

---

## Roadmap

### Planned Features

- [ ] **More Tools**: XML Formatter, Markdown Previewer, Diff Checker
- [ ] **API Mode**: Command-line interface for CI/CD integration
- [ ] **Export/Import**: Save tool configurations

### Version History

See [CHANGELOG.md](CHANGELOG.md) for detailed version history.

---

## License

This project is licensed under the **MIT License**.

```
MIT License

Copyright (c) 2026 WebDev-Tools.info

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## Acknowledgments

### Technology & Tools

- **Bootstrap Team** — For the robust UI framework
- **MDN Web Docs** — For comprehensive web standards documentation
- **IETF & ISO** — For maintaining open, accessible technical standards

### AI Development Partners

- **Anthropic (Claude Opus 5.5)** — Primary development assistant
- **Anthropic (Claude Code)** — Automated code review and quality assurance

### Community

- All users who provided feedback and bug reports
- Open-source community for libraries and frameworks
- Standards organizations for maintaining interoperability

---

## Contact & Support

- **Website**: [https://webdev-tools.info/](https://webdev-tools.info/)
- **Issues**: [GitHub Issues](https://github.com/RamonKaes/WebDev-Tools/issues)
- **Questions & Ideas**: [easyQ project page](https://easyq.info/projects/ramonkaes-webdev-tools)
- **Email**: [Contact Form](https://webdev-tools.info/imprint.php)
- **Documentation**: 
  - [Developer Docs](docs/README.md)
  - [Security Policy](SECURITY.md)
  - [Changelog](CHANGELOG.md)

---

<div align="center">

**Built with commitment to open standards and developer privacy.**

[![Standards](https://img.shields.io/badge/RFC-Compliant-blue.svg)](https://www.ietf.org/)
[![Security](https://img.shields.io/badge/Security-Client--Side%20Only-brightgreen.svg)](SECURITY.md)
[![WCAG](https://img.shields.io/badge/WCAG-2.1-green.svg)](https://www.w3.org/WAI/WCAG21/quickref/)

*Privacy-First • Standards-Based • Developer-Focused*

</div>
