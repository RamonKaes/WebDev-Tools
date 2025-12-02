# WebDev-Tools Test Suite

Comprehensive testing infrastructure for URL validation, navigation, and localization.

## Quick Start

### Run All Tests (Recommended) ⭐
```bash
php tests/run-all.php
# or with custom base URL
php tests/run-all.php http://localhost:8080
```

### Run Individual Tests
```bash
# Slug validation (95 checks)
php tests/validate-slugs.php

# HTTP endpoints & navigation (137 checks)
php tests/run.php http://localhost/WebDev-Tools

# Deep link crawler (optional)
php tests/crawler.php http://localhost/WebDev-Tools
```

Expected: **All critical tests passed** ✅

## Test Scripts

### 1. `run-all.php` - Master Test Runner ⭐
Executes all test suites and provides comprehensive report.
- **Critical:** Slug validation + HTTP endpoints
- **Optional:** Deep link crawler
- **Exit Code:** 0 = all passed, 1 = failures detected

### 2. `validate-slugs.php` - Slug Validation [CRITICAL]
Validates localized tool slugs are properly configured.
- Checks all languages have slug definitions
- Verifies directories and index.php files exist
- Flags warnings when English slugs are reused
- **95 checks** across 19 tools × 5 languages

### 3. `run.php` - HTTP Endpoints & Navigation [CRITICAL]
Comprehensive test suite (137 checks):
- **116 HTTP endpoint checks** - All tool pages return 200 OK
- **10 Homepage localized links** - German/Spanish tool URLs
- **10 Navigation tests** - Language switcher, special pages, mobile nav
- **1 Integrated crawler** - Browser-like navigation across 69 pages

### 4. `crawler.php` - Deep Link Crawler [OPTIONAL]
Standalone browser-like crawler for deep navigation validation.
- Simulates real browser behavior
- Follows navigation links recursively (max depth: 2)
- Tests sidebar, language switcher, footer, offcanvas menus
- Reports broken links and statistics

### 5. `index.php` - Browser-Based Test UI
Client-side testing interface:
- JavaScript API availability checks
- Browser API tests (Fetch, Web Crypto)
- Cryptographic integrity tests (SHA-256, HMAC)
- CSP validation, accessibility, performance budgets

## Coverage

**Total: 137 automated checks in run.php + 95 slug validations**

| Test Suite | Checks | Description |
|----------|--------|-------------|
| **Slug Validation** | 95 | Localized slug configuration across 5 languages |
| **HTTP Endpoints** | 116 | All tools across 6 languages (EN/DE/ES/PT/FR/IT) |
| **Homepage Links** | 10 | German & Spanish localized URLs |
| **Navigation** | 10 | Language switcher, special pages, mobile nav |
| **Integrated Crawler** | 1 | Browser-like navigation (69 pages tested) |

## How It Caught the Italian Slug Bug

The Italian `px-to-rem-converter` was using the English slug instead of `convertitore-px-rem`, causing a redirect loop.

**Why existing tests missed it:**
1. `tests/checks.json` had the wrong slug hardcoded
2. Both test and config were wrong, so they matched

**How the new system caught it:**
1. External SEO crawler detected redirect loop
2. `validate-slugs.php` now flags when localized slugs match English
3. Integrated crawler in `run.php` tests real navigation paths
4. `run-all.php` provides comprehensive validation

## Localized URLs Tested

**German (de)**: code-formatierer, jwt-dekodierer, string-maskierer, html-entity-kodierer-dekodierer, json-formatierer-validator, url-kodierer-dekodierer, punycode-konverter

**Spanish (es)**: escapador-cadenas, generador-contrasenas, conversor-datos

**Portuguese (pt)**: conversor-dados, referencia-emojis

**French (fr)**: generateur-mots-de-passe, convertisseur-donnees

**Italian (it)**: generatore-password, convertitore-dati

## Requirements

**Production**: Apache + PHP 7.4+  
**Development**: PHP 7.4+, localhost HTTP access

Optional: mod_rewrite for `.htaccess` redirects (backward compatibility)

## Usage Examples

```bash
# Full CLI test suite
php tests/run.php http://localhost/WebDev-Tools

# Custom base URL
BASE_URL=https://webdev-tools.info php tests/run.php

# Browser-based tests
# Open tests/index.php in browser for interactive testing
```

## CI/CD Integration

```bash
#!/bin/bash
php tests/run.php http://localhost

if [ $? -eq 0 ]; then
  echo "✅ Deploy to production"
else
  echo "❌ Block deployment"
  exit 1
fi
```

Exit code: 0 = pass, 1 = fail

## Troubleshooting

**Connection errors**: Ensure HTTP server is running and BASE_URL is correct

**Permission errors**: Check PHP has read access to all test files

**Port conflicts**: Update BASE_URL in command or environment variable

## Test Output

```
============================================================
Environment Checks
============================================================
  ✓ PHP version 8.4.11
  ✓ JSON functions available
  ✓ Server config present (config.php)

============================================================
HTTP Endpoint Checks
============================================================
Base URL: http://localhost/WebDev-Tools

→ Core
------------------------------------------------------------
  ✓ index.php [200]
  ✓ sitemap.xml [200]

→ English Tools
------------------------------------------------------------
  ✓ base64-encoder-decoder/index.php [200]
  ✓ code-formatter/index.php [200]
  ...

→ German (de)
------------------------------------------------------------
  ✓ de/code-formatierer/index.php [200]
  ✓ de/jwt-dekodierer/index.php [200]
  ...

============================================================
Homepage Localized Links
============================================================
  ✓ Code Formatter → /de/code-formatierer/
  ✓ JWT Decoder → /de/jwt-dekodierer/
  ...

============================================================
Navigation & Language Switcher
============================================================
  ✓ Sidebar: Code Formatter → /de/code-formatierer/
  ✓ DE→EN: /de/code-formatierer/ → /code-formatter/
  ✓ EN→DE: /code-formatter/ → /de/code-formatierer/
  ✓ Mobile OffCanvas present
  ✓ Mobile nav uses localized URLs

============================================================
Summary
============================================================
Total checks: 140
  ✓ Passed: 140 (100%)
```

## Architecture

- **config/tools.php** - Localized slug definitions
- **config/helpers.php** - Dynamic URL generation (`getToolUrl`, `getNavigationStructure`)
- **partials/header-with-sidebar.php** - Uses `getAllToolLanguageUrls()` for language switcher

**Status**: READY FOR PRODUCTION ✨
