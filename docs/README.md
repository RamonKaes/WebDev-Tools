# WebDev-Tools Documentation

**Comprehensive Documentation for Developers** – Tech stack, integration guides, best practices.

---

## 📚 Documentation Overview

### Tech Stack Documentation (`techstack/`)

Detailed description of the technical architecture and best practices:

| Document | Content |
|----------|---------|
| **[OVERVIEW](techstack/OVERVIEW.md)** | Architecture overview, stack components, lifecycle |
| **[FRONTEND](techstack/FRONTEND.md)** | JavaScript (IIFE pattern), shared utilities, security |
| **[BACKEND](techstack/BACKEND.md)** | PHP standards, tool registry, i18n system, routing |
| **[BUILD](techstack/BUILD.md)** | Build process, minification, deployment |
| **[TESTING](techstack/TESTING.md)** | Jest setup, test patterns, coverage |
| **[INTEGRATION](techstack/INTEGRATION.md)** | **Add new tool** – Step-by-step guide |
| **[DEPENDENCIES](techstack/DEPENDENCIES.md)** | External dependencies, versions, upgrade strategies |
| **[SECURITY](techstack/SECURITY.md)** | Security best practices, privacy, CSP, XSS prevention |
| **[TEMPLATES](techstack/TEMPLATES.md)** | **Code templates** – Ready-to-use PHP, JS, test templates |
| **[CONVENTIONS](techstack/CONVENTIONS.md)** | Naming, structure, CSS, accessibility, error handling |

---

## 🚀 Quick Start (for new developers)

### 1. Clone repository & setup

```bash
git clone https://github.com/RamonKaes/WebDev-Tools.git
cd WebDev-Tools
npm install
```

---

### 2. Development environment

**Local server (PHP 8+):**
```bash
# Option 1: PHP built-in server
cd /var/www/html/WebDev-Tools
php -S localhost:8000 -t . dev/router.php

# Option 2: XAMPP/MAMP
# Copy project to htdocs/, start Apache
```

**Run tests:**
```bash
npm test                  # All tests
npm run test:watch        # Watch mode
npm run test:coverage     # With coverage report
```

---

### 3. Create new tool

**Recommended order:**
1. **[INTEGRATION.md](techstack/INTEGRATION.md)** read – Step-by-step checklist
2. **[FRONTEND.md](techstack/FRONTEND.md)** consult – Utilities & patterns
3. **[TESTING.md](techstack/TESTING.md)** – Write tests
4. **[BUILD.md](techstack/BUILD.md)** – Production build

**Typical workflow:**
```bash
# 1. Create feature branch
git checkout -b feature/my-new-tool

# 2. Create PHP files (6 languages)
# - tool-name/index.php
# - de/tool-name/index.php
# - es/tool-name/index.php
# - ... (see INTEGRATION.md)

# 3. Create JavaScript module
# - assets/js/tools/myToolNameTool.js

# 4. Update tool registry
# - config/tools.php

# 5. Add i18n strings
# - config/i18n/{en,de,es,pt,fr,it}.json

# 6. Write tests
# - tests/unit/myToolNameTool.test.js

# 7. Run tests
npm test

# 8. Generate manifest & sitemaps
php config/generate-manifest.php
php config/generate-sitemaps.php

# 9. Production build
bash build.sh

# 10. Commit & push
git add .
git commit -m "feat: add MyTool"
git push origin feature/my-new-tool
```

---

## 🏗️ Project Architecture

```
WebDev-Tools/
├── tool-name/               # Tool pages (EN)
│   └── index.php
├── de/tool-name/            # German versions
│   └── index.php
├── es/tool-name/            # Spanish versions
│   └── index.php
├── assets/
│   ├── js/
│   │   ├── tools/           # Tool modules (IIFE)
│   │   │   └── myToolTool.js
│   │   └── lib/             # Shared utilities
│   │       ├── clipboard-utils.js
│   │       ├── download-utils.js
│   │       ├── dragdrop-utils.js
│   │       ├── validators.js
│   │       └── formatters.js
│   ├── css/                 # Stylesheets
│   └── img/                 # Images
├── config/
│   ├── tools.php            # Tool registry
│   ├── i18n/                # Translations (6 languages)
│   │   ├── en.json
│   │   ├── de.json
│   │   └── ...
│   ├── generate-manifest.php
│   └── generate-sitemaps.php
├── partials/
│   └── tool-base.php        # Shared layout
├── tests/
│   ├── unit/                # Jest tests
│   │   └── myToolTool.test.js
│   └── setup.js             # Test setup (mocks)
├── docs/                    # This documentation
│   ├── README.md
│   └── techstack/
├── dist/                    # Production build (generated)
├── .htaccess                # Development
├── .htaccess.production     # Production
├── build.sh                 # Build script
├── package.json
└── jest.config.js
```

---

## 🔧 Common Tasks

### Switch tool category

**File:** `config/tools.php`
```php
'myToolName' => [
  'category' => 'converters',  // encoders|formatters|generators|converters|references
  // ...
]
```

---

### Add new utility

**File:** `assets/js/lib/my-new-util.js`
```javascript
(function() {
  'use strict';

  window.MyNewUtil = {
    doSomething: function(input) {
      // Implementation
      return result;
    }
  };
})();
```

**Register in `config/tools.php`:**
```php
'jsLibraries' => ['my-new-util', 'clipboard-utils']
```

---

### Update i18n strings

**Edit all 6 files simultaneously:**
- `config/i18n/en.json`
- `config/i18n/de.json`
- `config/i18n/es.json`
- `config/i18n/pt.json`
- `config/i18n/fr.json`
- `config/i18n/it.json`

**Usage in JS:**
```javascript
function t(key, params) {
  return window.i18n.t(key, params);
}

const label = t('tools.myTool.inputLabel');
```

---

### Change URL slug (with redirect)

**1. Update `config/tools.php`:**
```php
'slugs' => [
  'en' => 'new-tool-name',
  'de' => 'neuer-werkzeug-name',
  // ...
]
```

**2. `.htaccess` AND `.htaccess.production`:**
```apache
# 301 redirect old → new
RewriteRule ^old-tool-name/?$ /new-tool-name/ [R=301,L]
RewriteRule ^de/alter-werkzeug-name/?$ /de/neuer-werkzeug-name/ [R=301,L]
```

**3. Regenerate sitemap:**
```bash
php config/generate-sitemaps.php
```

---

## 📊 Code Quality

### Code Standards

| Aspect | Standard |
|--------|----------|
| **PHP** | PSR-12, strict_types, XSS protection |
| **JavaScript** | IIFE pattern, 'use strict', no `var` |
| **CSS** | Bootstrap 5.3, custom Sass |
| **Tests** | Jest, 80% coverage target |

---

### Linting (planned)

**ESLint config (future):**
```json
{
  "extends": "eslint:recommended",
  "env": {
    "browser": true,
    "es2020": true
  },
  "rules": {
    "no-var": "error",
    "prefer-const": "warn",
    "no-eval": "error"
  }
}
```

---

## 🔒 Security Checklist

Before each release check:

- [ ] `npm audit` – No critical/high vulnerabilities
- [ ] CSP header correct (no `'unsafe-eval'`)
- [ ] All user inputs validated & escaped
- [ ] HTTPS enforced (HSTS)
- [ ] No sensitive data in logs/console
- [ ] Tests green (including XSS tests)

**See:** [SECURITY.md](techstack/SECURITY.md) for details

---

## 📈 Performance Metrics

### Current Targets (April 2026)

| Metric | Target | Current |
|--------|--------|---------|
| **Lighthouse Score** | > 90 | 94 |
| **First Contentful Paint** | < 1.5s | 1.2s |
| **Time to Interactive** | < 3s | 2.8s |
| **Bundle Size (JS)** | < 100 KB | 85 KB |
| **Bundle Size (CSS)** | < 50 KB | 42 KB |

**Tools:**
- Lighthouse (Chrome DevTools)
- WebPageTest.org
- GTmetrix

---

## 🤝 Contributing

### Pull Request Workflow

1. **Fork & Branch:** `git checkout -b feature/my-feature`
2. **Code:** Implementation + tests
3. **Tests:** `npm test` (all green)
4. **Commit:** Conventional commits (`feat:`, `fix:`, `docs:`)
5. **Push:** `git push origin feature/my-feature`
6. **PR:** Create on GitHub, fill template
7. **Review:** Implement feedback
8. **Merge:** After approval by maintainer

---

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation change
- `style`: Code formatting (no logic change)
- `refactor`: Code refactoring
- `test`: Add/change tests
- `chore`: Build process, dependencies

**Examples:**
```
feat(uuid-generator): add UUID v7 support

Implements RFC 9562 UUID version 7 with timestamp-based ordering.
Adds new option in UI and updates tests.

Closes #123
```

```
fix(json-formatter): handle very large inputs

Adds performance guard for inputs > 10 MB to prevent browser freezing.

Fixes #456
```

---

## 🌍 Internationalization (i18n)

### Supported Languages

1. **English (EN)** – Default, reference language
2. **German (DE)** – Complete
3. **Spanish (ES)** – Complete
4. **Portuguese (PT)** – Complete
5. **French (FR)** – Complete
6. **Italian (IT)** – Complete

### Add New Language

**1. Create JSON file:**
```bash
cp config/i18n/en.json config/i18n/nl.json
# Translate...
```

**2. Extend language handler:**
```php
// config/language-handler.php
$supportedLangs = ['en', 'de', 'es', 'pt', 'fr', 'it', 'nl'];
```

**3. Create tool directories:**
```bash
mkdir nl/
# For each tool:
mkdir nl/tool-name/
cp tool-name/index.php nl/tool-name/index.php
# Translate...
```

**4. Update `config/tools.php`:**
```php
'slugs' => [
  'en' => 'tool-name',
  'de' => 'werkzeug-name',
  'nl' => 'gereedschap-naam',  // New
  // ...
]
```

---

## 📞 Support & Contact

### Questions?

1. **Search documentation** (these docs)
2. **Read CLAUDE.md** – Project overview
3. **GitHub Issues** – Bug reports, feature requests
4. **GitHub Discussions** – General questions

### Links

- **Website:** https://webdev-tools.info
- **Repository:** https://github.com/RamonKaes/WebDev-Tools
- **Issues:** https://github.com/RamonKaes/WebDev-Tools/issues
- **Changelog:** [CHANGELOG.md](../CHANGELOG.md)

---

## 📝 License

**MIT License** – See [LICENSE](../LICENSE) for details.

---

**Last updated:** April 2026 | **Version:** 2.1.2
