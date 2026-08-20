# Tech Stack Overview – WebDev-Tools

**Privacy-First Developer Toolbox** – All operations run client-side in the browser, no server state, no data transmission.

---

## Architecture Principles

### 1. **Client-Side Only**
- All sensitive data (passwords, tokens, hashes) stays in the browser
- No backend processing, no analytics tracking
- CSP (Content Security Policy) active

### 2. **Multi-language (i18n)**
- 6 languages: EN, DE, ES, PT, FR, IT
- PHP content (features, resources) hardcoded per language
- JS UI strings (labels, buttons) in JSON files (`config/i18n/`)

### 3. **Tool Registry System**
- Central configuration in `config/tools.php`
- Each tool: metadata, libraries, features, SEO template
- Automatic manifest/sitemap generation

---

## Stack Components

| Layer | Technology | Details |
|-------|------------|---------|
| **Frontend** | Vanilla JS (IIFE pattern) | Shared utilities, no framework |
| **Styling** | Bootstrap 5.3 + Custom Sass | Responsive, consistent design |
| **Backend** | PHP 8+ (strict_types) | Tool registry, i18n, routing |
| **Build** | Bash, Terser, csso/cssnano | Minification, optimization |
| **Testing** | Jest 30 + jsdom | 841 tests, 20 suites |
| **Deployment** | rsync + htaccess rewrites | Production build to `dist/` |

---

## Project Lifecycle

```bash
# Development
npm test                  # Run Jest unit tests
npm run test:coverage     # With coverage report

# Build
bash build.sh             # Production build → dist/

# After new tool
php config/generate-manifest.php
php config/generate-sitemaps.php
```

---

## Folder Structure (simplified)

```
tool-name/index.php              # Tool page (PHP)
de/tool-name/index.php           # German version
assets/js/tools/toolNameTool.js  # Tool logic (IIFE)
assets/js/lib/*.js               # Shared utilities
config/tools.php                 # Tool registry
config/i18n/{lang}.json          # UI strings per language
tests/unit/toolNameTool.test.js  # Jest tests
partials/tool-base.php           # Shared layout
```

---

## Further Documentation

- **[FRONTEND.md](FRONTEND.md)** – JS patterns, IIFE conventions, shared utilities
- **[BACKEND.md](BACKEND.md)** – PHP standards, tools.php registry, i18n system
- **[BUILD.md](BUILD.md)** – build.sh, minification, dist/ structure
- **[TESTING.md](TESTING.md)** – Jest setup, test patterns, mocking
- **[INTEGRATION.md](INTEGRATION.md)** – Checklist for new tools

---

**Status:** August 2026 | **Version:** 2.2.0 | **Tools:** 20 | **Languages:** 6
