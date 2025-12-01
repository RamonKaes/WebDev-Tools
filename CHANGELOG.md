# Changelog

All notable changes to WebDev-Tools will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **feat(tests):** Comprehensive test suite integration in `tests/index.php` with 40+ checks
  - CSP (Content Security Policy) validation tests
  - Accessibility (WCAG 2.1 AA) compliance tests (page language, alt text, form labels, semantic buttons)
  - Performance budget monitoring (TTFB, DOM Content Loaded, Load Complete)
  - Browser API and cryptography tests
  - 118+ endpoint availability checks
- **feat(tests):** Unit test infrastructure with Vitest (`tests/unit/`)
  - Test templates for validators.js, formatters.js, clipboard-utils.js
  - Comprehensive test documentation and setup guide
- **feat(tests):** E2E test infrastructure with Playwright (`tests/e2e/`)
  - Cross-browser tests (Chromium, Firefox, WebKit, Mobile)
  - Test suites for Base64, UUID Generator, Password Generator
  - Accessibility tests with axe-core integration
- **feat(monitoring):** Performance budget monitoring (`assets/js/performance-budget.js`)
  - Core Web Vitals tracking (FCP, LCP, FID, CLS, TTI)
  - Automatic violation reporting with PerformanceObserver API
  - Google Analytics integration for production monitoring
- **feat(logging):** Centralized Logger class (`assets/js/lib/logger.js`)
  - Consistent error handling with debug/info/warn/error levels
  - Performance timing utilities
  - Scoped loggers for better debugging
  - Optional error reporting integration
- **feat(tools):** Localized slugs for 10 tools in config/tools.php
  - URL Encoder/Decoder, HTML Entity Tool, JSON Formatter/Validator
  - JWT Decoder, Punycode Converter, UUID Generator
  - Hash Generator, Lorem Ipsum, QR Code Generator, Regex Tester
- **feat(bin):** Tool verification script (`bin/verify-tools.sh`)
  - Validates all 118 tool directories across 6 languages
  - Color-coded output with detailed error reporting
- **docs:** Comprehensive developer documentation in `/docs`
  - `docs/README.md` - Documentation index
  - `docs/SITEMAP-GENERATION.md` - Sitemap automation guide
  - `docs/CODE-SPLITTING.md` - Performance optimization strategy for large tools
  - `docs/LOGGER-MIGRATION.md` - Logger migration guide with 20+ affected files
  - `docs/JSDOC-STATUS.md` - JSDoc type annotations status (core libraries complete)
- **feat(dev):** Add development server router (`dev/router.php`) and start script (`dev/start-server.sh`) for local PHP built-in server
- **feat(ci):** Add GitHub Actions CI workflow with PHP checks and PHPCS static analysis (no Composer required)
- **feat(tests):** Add comprehensive security test suite (`tests/security.php`) for CSPRNG validation, hash integrity, and JWT signature verification
- **feat(tests):** Add SHA-512 and HMAC test vectors for cryptographic integrity validation
- **feat(quality):** Add `bin/check` script for syntax and style checks using PHPCS PHAR (no Composer/Node required)
- **docs:** Add `CONTRIBUTING.md` with development workflow and setup instructions
- **docs:** Add `tests/security-tests.md` documenting security test coverage and recommendations

### Changed
- **refactor(tests):** Enhanced `tests/index.php` from "simple checks" to comprehensive test suite
  - Added 15+ new test categories (CSP, Accessibility, Performance)
  - Improved summary reporting with warnings and detailed metrics
  - Updated UI title from "Simple Checks" to "Comprehensive Test Suite"
- **docs:** Updated `README.md` with comprehensive documentation section
  - Links to all developer docs, test suites, and configuration guides
  - Enhanced test suite description with all new categories
- **docs:** Updated `tests/README.md` with detailed test suite breakdown
  - All test categories and their specific checks documented
  - Performance budget thresholds specified
  - Accessibility criteria listed
- **chore(tests):** Replaced the overburdened test-suite with lightweight "simple tests" (PHP CLI + VanillaJS UI) for hosting-friendly verification
- **chore(ci):** CI workflows now run only on pull requests and manual triggers to conserve runner minutes
- **docs:** Update README to clarify production environment (no Node/npm required) vs. optional developer tools

### Fixed
- **fix(i18n):** Added 6 missing translation keys in `config/i18n/it.json`
  - `seo.jsonFormatterValidator.featureList[6]` and `[7]`
  - `seo.passwordGeneratorTool.featureList[6]`
  - `tools.htmlEntityTool.how_to_use_steps[4]`
  - `tools.jwtDecoderTool.how_to_use_steps[4]`
  - `tools.punycodeConverterTool.how_to_use_steps[4]`
- **fix(tests):** Added missing data-converter endpoint to `tests/checks.json`
- **security(uuid):** Remove unsafe Math.random() fallback in UUID generator (v4, v7) — now throws clear error if Web Crypto API unavailable
- **fix(i18n):** Add `crypto_error` translation key in all 6 languages for UUID generator error messages
- **fix(lorem-ipsum):** restore Copy button functionality in `assets/js/tools/loremIpsumTool.js` (PR #1, commit dc9bb4b)
- **fix(tests):** Add copy-button validation (PR #3)

### Security
- **CRITICAL:** Removed cryptographically insecure Math.random() fallback from UUID generator — all UUID generation now requires Web Crypto API
- **Added:** CSP validation tests (eval() blocking, external source restrictions)
- **Added:** CSPRNG validation tests for Password Generator and UUID Generator (v1, v4, v7)
- **Added:** Hash integrity tests with known test vectors (SHA-256, SHA-512, HMAC-SHA256)
- **Added:** JWT signature validation tests (RS256, HS256)

### Technical Improvements
- **Testing:** 40+ browser-based checks covering APIs, security, accessibility, and performance
- **Documentation:** Complete developer documentation structure with guides and migration paths
- **Performance:** Performance budget monitoring with Core Web Vitals tracking
- **Logging:** Centralized error handling with Logger class (20+ files ready for migration)
- **Code Quality:** JSDoc annotations complete for all core libraries (dom-utils, formatters, logger)
- **Tooling:** Automated sitemap verification and tool directory validation
- CI runs lightweight checks without external dependencies (Composer/Node)
- PHPCS style checks via PHAR download (PSR-12 standard)
- Production-ready: all runtime code works without Node/npm

---

## [1.0.0] - 2025-11-22

### Initial Release

#### Core Features
- **18 Developer Tools** with full functionality:
  - Encoders: Base64, URL, HTML Entity, JWT Decoder, Punycode
  - Formatters: JSON, Code (HTML/CSS/JS/XML/SQL)
  - Converters: Px to Rem, Data (JSON/XML/YAML/CSV)
  - Generators: UUID (v1/v4/v7), Password, Hash, Lorem Ipsum, QR Code
  - String Tools: String Escaper
  - Utilities: Regex Tester
  - References: Character Reference, Emoji Reference

#### Internationalization
- **6 Languages**: English, German, Spanish, Portuguese, French, Italian
- Complete translation of UI, tool descriptions, and help texts
- Hreflang tags for SEO optimization
- Language-specific sitemaps

#### Architecture & Security
- **100% Client-Side Processing**: No data transmission to servers
- **Standards Compliance**:
  - RFC 4648 (Base64), RFC 8259 (JSON), RFC 4122/9562 (UUID)
  - RFC 7519 (JWT), RFC 3986 (URI), RFC 3492 (Punycode)
  - ISO/IEC 18004 (QR Code)
  - NIST SP 800-63B (Password Security)
  - WCAG 2.1 (Accessibility)
- **Cryptographically Secure**: Web Crypto API, crypto.getRandomValues()
- **Content Security Policy**: Strict CSP with nonce-based scripts
- **HTTPS Enforcement**: HSTS headers in production

#### Performance
- **Code-Splitting**: Dynamic module loading per tool
- **Prefetch System**: IntersectionObserver-based tool prefetching
- **Aggressive Caching**: 1-year cache for versioned assets
- **Lazy Loading**: Tools load only when needed
- **Optimized Assets**: Minified CSS/JS, compressed images

#### SEO & Metadata
- **Comprehensive Meta Tags**: Open Graph, Twitter Cards
- **Structured Data**: JSON-LD for all tools (WebApplication schema)
- **Breadcrumb Navigation**: Schema.org BreadcrumbList
- **Sitemap Generation**: Automated sitemap creation for 6 languages
- **Canonical URLs**: Proper canonicalization across language versions

#### User Experience
- **Responsive Design**: Mobile-first with Bootstrap 5.3
- **Dark Mode**: Auto, light, and dark theme support with persistence
- **Accessibility**: WCAG 2.1 Level AA compliance
- **Keyboard Navigation**: Full keyboard support for all interactions
- **Progressive Enhancement**: Works without JavaScript where possible

#### Development
- **AI-Assisted Development**: Built with Claude Sonnet 4.5, GitHub Copilot
- **Version Control**: Git-based workflow with feature branches
- **Quality Assurance**: Cross-model code review (Claude ↔ GPT-5 Codex)
- **Modern Stack**: Vanilla JavaScript (ES6+), PHP 7.4+, Bootstrap 5.3
- **No Build Step Required**: Direct deployment, no npm/webpack needed

---

## Release Notes

### Version Numbering
- **Major (X.0.0)**: Breaking changes, major feature additions
- **Minor (1.X.0)**: New features, non-breaking changes
- **Patch (1.0.X)**: Bug fixes, minor improvements

### Upgrade Notes
No database migrations or configuration changes required for any version.
Simply replace files and clear browser cache (Ctrl+Shift+R).

### Browser Compatibility
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers with ES6 support

### Server Requirements
- PHP 7.4 or higher
- Apache with mod_rewrite (for clean URLs)
- HTTPS recommended for production
- No database required

---

**For detailed commit history, see the Git repository.**
