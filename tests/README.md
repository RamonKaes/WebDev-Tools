# WebDev-Tools Test Suite

Comprehensive testing infrastructure for URL validation, navigation, and localization.

## Quick Start

```bash
php tests/run.php http://localhost/WebDev-Tools
```

Or use environment variable:
```bash
BASE_URL=https://example.com php tests/run.php
```

Expected: **All 136 checks passed** ✅

## Test Scripts

- **`run.php`** - Comprehensive CLI test suite (136 checks)
  - HTTP endpoint availability (116 endpoints × 6 languages)
  - Homepage localized link validation (10 checks)
  - Sidebar navigation validation (3 checks)
  - Language switcher URL mapping (5 checks)
  - Special pages & mobile navigation (2 checks)
  
- **`index.php`** - Browser-based test UI
  - Client-side JavaScript checks
  - Browser API availability (Fetch, Web Crypto)
  - Cryptographic integrity tests (SHA-256, HMAC)
  - CSP validation, accessibility, performance budgets

## Coverage

**Total: 136 automated checks in run.php**

| Category | Checks | Description |
|----------|--------|-------------|
| HTTP Endpoints | 116 | All tools across 6 languages (EN/DE/ES/PT/FR/IT) |
| Homepage Links | 10 | German & Spanish localized URLs |
| Sidebar Navigation | 3 | Desktop sidebar tool links |
| Language Switcher | 5 | DE↔EN, special pages |
| Mobile Navigation | 2 | OffCanvas presence & localized URLs |

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
