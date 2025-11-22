# WebDev-Tools.info

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Standards](https://img.shields.io/badge/standards-RFC%20%7C%20ISO%20%7C%20W3C-green.svg)](#standards-compliance)
[![Security](https://img.shields.io/badge/security-client--side%20only-brightgreen.svg)](#security-architecture)
[![Languages](https://img.shields.io/badge/languages-6-orange.svg)](#internationalization)

> **A comprehensive suite of 18+ privacy-focused developer utilities for modern web development**

WebDev-Tools.info is a professional-grade, client-side-only platform providing essential tools for software developers, system administrators, and web engineers. All operations execute locally in your browser — your data never leaves your device.

**🔗 Live Platform:** [https://webdev-tools.info/](https://webdev-tools.info/)

---

## Table of Contents

- [Key Features](#key-features)
- [Security Architecture](#security-architecture)
- [Available Tools](#available-tools)
- [Standards Compliance](#standards-compliance)
- [Internationalization](#internationalization)
- [Technical Foundation](#technical-foundation)
- [Development Methodology](#development-methodology)
- [Getting Started](#getting-started)
- [Browser Compatibility](#browser-compatibility)
- [Contributing](#contributing)
- [License](#license)

---

## Key Features

### 🔒 **Privacy-First Architecture**
- **Zero Server Processing**: All computations happen in your browser
- **No Data Transmission**: Sensitive data (passwords, tokens, API keys) never leaves your device
- **GDPR/CCPA Compliant**: Data minimization by design
- **No Tracking**: No analytics, no cookies, no user profiling

### ⚡ **Performance & Reliability**
- **Client-Side Execution**: No network latency — performance limited only by your CPU
- **Offline Capable**: Works without internet connection (after initial load)
- **Bulk Operations**: Handle thousands of items (UUID generation, data conversion)
- **Large File Support**: Process substantial datasets without server limits

### 🎯 **Standards-Based Implementation**
- **IETF RFCs**: RFC 4648 (Base64), RFC 8259 (JSON), RFC 4122/9562 (UUID), RFC 7519 (JWT), RFC 3986 (URI), RFC 3492 (Punycode)
- **ISO Standards**: ISO/IEC 18004 (QR Codes)
- **NIST Guidelines**: SP 800-63B (Password Authentication)
- **W3C/WCAG**: Accessibility and web standards compliance

### 🌍 **Multi-Language Support**
Available in 6 languages with culturally-aware translations:
- English (EN)
- Deutsch (DE)
- Español (ES)
- Português (PT)
- Français (FR)
- Italiano (IT)

---

## Security Architecture

WebDev-Tools implements a **"Privacy-by-Design"** approach that eliminates common security risks associated with online utilities.

### Client-Side-Only Execution

```
┌─────────────────────────────────────────────────────┐
│  Your Browser (Client)                              │
│  ┌───────────────────────────────────────────────┐  │
│  │ 1. Input Data (e.g., JWT token)               │  │
│  │ 2. JavaScript Processing (Local)              │  │
│  │ 3. Result Display (Never transmitted)         │  │
│  └───────────────────────────────────────────────┘  │
│                                                     │
│  ❌ NO server communication                         │
│  ❌ NO data logging                                 │
│  ❌ NO third-party APIs                             │
└─────────────────────────────────────────────────────┘
```

### Cryptographic Security

**CSPRNG Usage**: Security-critical tools (Password Generator, UUID Generator) utilize the **Web Crypto API** (`crypto.getRandomValues()`), not the predictable `Math.random()`.

**Entropy Sources**:
- Operating system entropy pool
- Hardware random number generators
- Thermal noise, mouse movements, keyboard timing

This guarantees cryptographically secure randomness resistant to prediction attacks.

### Risk Mitigation

| Risk | Server-Side Tools | WebDev-Tools |
|------|-------------------|--------------|
| **Data Interception** | ⚠️ Possible (HTTPS mitigates but doesn't eliminate) | ✅ Eliminated (no transmission) |
| **Server Logs** | ⚠️ Credentials/tokens may be logged | ✅ No logs exist |
| **Third-Party Access** | ⚠️ Provider has access to data | ✅ No third parties involved |
| **MITM Attacks** | ⚠️ Possible if TLS compromised | ✅ No attack surface |
| **Data Breach** | ⚠️ Server database vulnerable | ✅ No server database |

### Open Source & Auditability

**Full Transparency**: The complete source code is available on GitHub for review and audit:
- 🔓 **Public Repository**: [github.com/RamonKaes/WebDev-Tools](https://github.com/RamonKaes/WebDev-Tools)
- 📋 **MIT License**: Free to fork, modify, and distribute
- 🔍 **Community Review**: Anyone can inspect the code and report security issues

### Security Guarantees

WebDev-Tools implements multiple layers of protection:

- ✅ **Subresource Integrity (SRI)**: All external libraries verified with cryptographic hashes
- ✅ **Content Security Policy (CSP)**: Strict nonce-based script execution, no inline code
- ✅ **Security Headers**: HSTS, X-Frame-Options, CSP, Referrer-Policy, Permissions-Policy
- ✅ **Zero External Dependencies**: Data processing uses only native browser APIs
- ✅ **No Tracking**: No cookies (except language preference), no analytics on tool usage

**See [SECURITY.md](SECURITY.md) for detailed security documentation.**

---

## Available Tools

### 🔐 Cryptography & Security

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[UUID Generator](./uuid-generator/)** | RFC 4122, RFC 9562 | Supports v1, v4, v7 (time-ordered); Bulk generation; CSPRNG |
| **[Password Generator](./password-generator/)** | NIST SP 800-63B | Customizable complexity; Strength meter; Special character sets |
| **[Hash Generator](./hash-generator/)** | FIPS 180-4 | MD5, SHA-1/256/512; HMAC support; File integrity verification |
| **[JWT Decoder](./jwt-decoder/)** | RFC 7519 | Header/payload parsing; Signature validation; Expiry checking |

### 📊 Data Formatting & Serialization

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[JSON Formatter & Validator](./json-formatter-validator/)** | RFC 8259 | Syntax validation; Tree view; Minification; Error detection |
| **[Code Formatter](./code-formatter/)** | Language-specific | HTML, CSS, JS, XML, SQL; Customizable indentation |
| **[Data Converter](./data-converter/)** | YAML, TOML, CSV | JSON ↔ XML ↔ YAML ↔ CSV ↔ TOML; Syntax pre-validation |

### 🌐 Encoding & Network

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[Base64 Encoder/Decoder](./base64-encoder-decoder/)** | RFC 4648 | Standard & URL-safe variants; Binary file support; Data URIs |
| **[URL Encoder/Decoder](./url-encoder-decoder/)** | RFC 3986 | `encodeURI` vs `encodeURIComponent`; Component parsing |
| **[Punycode Converter](./punycode-converter/)** | RFC 3492 (IDNA) | Internationalized domain names; Bidirectional conversion |
| **[HTML Entity Encoder/Decoder](./html-entity-encoder-decoder/)** | HTML5 | Named & numeric entities; XSS prevention |

### 🛡️ String Manipulation & Security

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[String Escaper](./string-escaper/)** | OWASP | HTML, SQL, JSON, CSV, JavaScript escaping; Injection prevention |
| **[Regex Tester](./regex-tester/)** | ECMAScript | Real-time matching; Pattern validation; Performance testing |

### 🎨 Frontend & Design

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[Px to Rem Converter](./px-to-rem-converter/)** | WCAG | Accessible typography; Custom base font size; Bulk conversion |
| **[QR Code Generator](./qr-code-generator/)** | ISO/IEC 18004 | Error correction levels; SVG/PNG export; WiFi/vCard formats |
| **[Lorem Ipsum Generator](./lorem-ipsum/)** | N/A | Configurable paragraphs/words; HTML tag injection; Layout testing |

### 📚 Reference & Documentation

| Tool | Standards | Key Features |
|------|-----------|--------------|
| **[Character Reference](./character-reference/)** | Unicode | Search by name/code; Category filtering; Multiple formats |
| **[Emoji Reference](./emoji-reference/)** | Unicode, W3C | Categorized emojis; HTML entities; Copy-to-clipboard |

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

### Externer Code-Review (2024-12-19)

Im Rahmen eines externen Reviews wurden vier kritische Issues identifiziert und behoben:

1. **UUID v1 Sicherheit:**
   - Math.random wurde durch crypto.getRandomValues ersetzt (CSPRNG)
   - Unsichere Fallbacks entfernt, Fehler werden im UI angezeigt
2. **Manifest-Generator BASE_PATH:**
   - BASE_PATH wird jetzt dynamisch aus config.php oder CLI gelesen
   - Validierung und Korrektur der URLs für Produktion
3. **YAML→JSON Top-Level Listen:**
   - Parser unterstützt jetzt YAML-Listen als Root-Element
   - Indentierungsfehler behoben
4. **JSON→CSV leere Arrays:**
   - Validierung und Fehlerbehandlung für leere Arrays
   - Crash-Schutz und klare Fehlermeldungen

**Learnings:**
- Niemals Math.random für sicherheitsrelevante Zwecke
- Input-Validierung und Fehlerbehandlung sind essenziell
- Build-Skripte müssen umgebungsabhängig sein
- Automatisierte Tests verhindern Regressionen

Alle Fixes sind implementiert, getestet und dokumentiert. Weitere Details im [Code-Review-Report](CODE_REVIEW_REPORT.md).

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

- **Static Content**: Translated using GPT-5 Codex for technical accuracy
- **Cultural Content**: Translated using Claude Sonnet 4.5 for nuanced, contextually appropriate language
- **Consistency**: Centralized translation files ensure terminology consistency
- **Quality Assurance**: Manual review by native speakers for critical pages

---

## Technical Foundation

### Technology Stack

```
Frontend:
├── Bootstrap 5.3.0         # UI framework (chosen for stability over Tailwind)
├── Bootstrap Icons 1.11.0  # Icon system
├── Vanilla JavaScript      # No framework dependencies
└── Web Crypto API          # Secure random number generation

Backend:
├── PHP 7.4+                # Server-side routing and templating
├── Apache 2.4+             # Web server with mod_rewrite
└── Client-side processing  # No backend data processing

Architecture:
├── Responsive Design       # Mobile-first approach
├── Progressive Enhancement # Works without JavaScript (where applicable)
├── Modular Components      # Centralized tool template (partials/tool-base.php)
└── SEO Optimized          # Dynamic sitemaps, meta tags
```

### Project Structure

```
/var/www/html/WebDev-Tools/
├── index.php                    # Homepage
├── config/
│   ├── tools.php                # Tool registry
│   ├── language-handler.php     # i18n routing
│   ├── security-headers.php     # CSP and security policies
│   └── i18n/                    # Translation files
├── partials/
│   ├── tool-base.php            # Centralized tool template
│   ├── header.php               # Global header
│   └── footer.php               # Global footer
├── assets/
│   ├── css/                     # Stylesheets
│   ├── js/                      # JavaScript utilities
│   └── img/                     # Static assets
├── [tool-name]/
│   └── index.php                # Individual tool (18 tools)
├── de/, es/, pt/, fr/, it/      # Language-specific directories
├── CHANGELOG.md                 # Version history
├── SECURITY.md                  # Security documentation
└── README.md                    # This file
```

### Content Security Policy (CSP)

Strict CSP enforced to prevent XSS attacks:

```
default-src 'self';
script-src 'self' 'nonce-{random}';
style-src 'self' 'nonce-{random}';
img-src 'self' data:;
font-src 'self';
connect-src 'none';
```

**No inline scripts** — All JavaScript uses nonce-based execution.

---

## Development Methodology

### AI-Assisted Development

WebDev-Tools was developed using a **hybrid human-AI approach** that combines the efficiency of AI code generation with rigorous human oversight.

#### AI Models Utilized

- **Claude Sonnet 4.5** (Anthropic) — Primary coding assistant
- **GitHub Copilot** — Code completion and suggestion
- **GPT-5 Codex** (OpenAI) — Code review and translation

#### Quality Assurance Process

1. **Adversarial Review**: Different AI models cross-review each other's code
2. **Human Architecture**: All design decisions made by human developer
3. **Version Control**: Git-based workflow with rollback capability (`git reset --hard`)
4. **Manual Testing**: Comprehensive QA across all 108 tool instances (18 tools × 6 languages)
5. **Standards Validation**: Conformity checks against RFC/ISO specifications

#### Challenges & Solutions

| Challenge | Mitigation |
|-----------|------------|
| **AI Hallucinations** | Multiple AI models review each other's output |
| **Framework Bias** | Switched from Tailwind to Bootstrap for stability |
| **Code Complexity** | Enforced modular architecture with centralized templates |
| **Translation Quality** | Model selection based on content type (technical vs. cultural) |

**Philosophy**: "Done over Perfect" — Pragmatic choices favoring maintainability and reliability over cutting-edge trends.

---

## Getting Started

### Prerequisites

- **Web Server**: Apache 2.4+ with `mod_rewrite` enabled
- **PHP**: Version 7.4 or higher
- **Browser**: Modern browser with JavaScript enabled

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/WebDev-Tools.git
   cd WebDev-Tools
   ```

2. **Configure Apache**:
   Ensure `.htaccess` is enabled and `mod_rewrite` is active:
   ```apache
   <Directory /var/www/html/WebDev-Tools>
       AllowOverride All
       Require all granted
   </Directory>
   ```

3. **Set permissions**:
   ```bash
   chmod -R 755 /var/www/html/WebDev-Tools
   ```

4. **Access the platform**:
   Navigate to `http://localhost/` or your configured domain.

### Configuration

- **Base URL**: Set in `config/config.php` (if exists)
- **Languages**: Modify `config/language-handler.php` to add/remove languages
- **Tools**: Register new tools in `config/tools.php`

### Development Setup

```bash
# Start local development server (PHP built-in)
php -S localhost:8000

# Watch for file changes (if using build tools)
npm run watch  # (if applicable)
```

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

WebDev-Tools has undergone comprehensive third-party technical auditing:

### Audit Highlights

✅ **Functional Integrity**: All 18 tools generate RFC/ISO-compliant output  
✅ **Security Architecture**: Client-side-only execution verified  
✅ **Cryptographic Security**: CSPRNG usage confirmed for sensitive operations  
✅ **Standards Adherence**: Explicit referencing of normative specifications  
✅ **Development Quality**: Modern QA processes with version control and code review  

**Classification**: **Industry-Standard Compliant / Safe for Professional Use**

For detailed audit findings, see the technical reports in `/docs/audit/` (if published).

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
4. **Test thoroughly**: Verify across multiple browsers and languages
5. **Submit a Pull Request** with a clear description of changes

### Code Review Process

- All PRs reviewed for security implications
- Standards compliance verification
- Cross-browser testing
- Translation accuracy (for i18n changes)

---

## Roadmap

### Planned Features

- [ ] **Dark Mode** (Theme switching)
- [ ] **PWA Support** (Offline-first Progressive Web App)
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

Copyright (c) 2025 WebDev-Tools.info

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

- **Anthropic (Claude)** — Primary development assistant
- **OpenAI (GPT-5)** — Code review and translation
- **GitHub Copilot** — Code completion support

### Community

- All users who provided feedback and bug reports
- Open-source community for libraries and frameworks
- Standards organizations for maintaining interoperability

---

## Contact & Support

- **Website**: [https://webdev-tools.info/](https://webdev-tools.info/)
- **Issues**: [GitHub Issues](https://github.com/yourusername/WebDev-Tools/issues)
- **Email**: [Contact Form](https://webdev-tools.info/imprint.php)
- **Documentation**: [Security Policy](SECURITY.md) | [Changelog](CHANGELOG.md)

---

<div align="center">

**Built with ❤️ using AI-assisted development**

[![Standards](https://img.shields.io/badge/RFC-Compliant-blue.svg)](https://www.ietf.org/)
[![Security](https://img.shields.io/badge/Security-Client--Side%20Only-brightgreen.svg)](SECURITY.md)
[![WCAG](https://img.shields.io/badge/WCAG-2.1-green.svg)](https://www.w3.org/WAI/WCAG21/quickref/)

*Privacy-First • Standards-Based • Developer-Focused*

</div>
