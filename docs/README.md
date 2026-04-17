# WebDev-Tools Documentation

**Umfassende Dokumentation für Entwickler** – Tech-Stack, Integration-Guides, Best Practices.

---

## 📚 Dokumentations-Übersicht

### Tech-Stack-Dokumentation (`techstack/`)

Detaillierte Beschreibung der technischen Architektur und Best Practices:

| Dokument | Inhalt |
|----------|--------|
| **[OVERVIEW](techstack/OVERVIEW.md)** | Architektur-Übersicht, Stack-Komponenten, Lifecycle |
| **[FRONTEND](techstack/FRONTEND.md)** | JavaScript (IIFE-Pattern), gemeinsame Utilities, Security |
| **[BACKEND](techstack/BACKEND.md)** | PHP-Standards, Tool-Registry, i18n-System, Routing |
| **[BUILD](techstack/BUILD.md)** | Build-Prozess, Minification, Deployment |
| **[TESTING](techstack/TESTING.md)** | Jest-Setup, Test-Patterns, Coverage |
| **[INTEGRATION](techstack/INTEGRATION.md)** | **Neues Tool hinzufügen** – Schritt-für-Schritt-Anleitung |
| **[DEPENDENCIES](techstack/DEPENDENCIES.md)** | Externe Dependencies, Versionen, Upgrade-Strategien |
| **[SECURITY](techstack/SECURITY.md)** | Security-Best Practices, Privacy, CSP, XSS-Prevention |
| **[TEMPLATES](techstack/TEMPLATES.md)** | **Code-Templates** – Ready-to-use PHP, JS, Test-Vorlagen |
| **[CONVENTIONS](techstack/CONVENTIONS.md)** | Naming, Struktur, CSS, Accessibility, Error-Handling |

---

## 🚀 Quick Start (für neue Entwickler)

### 1. Repository klonen & Setup

```bash
git clone https://github.com/RamonKaes/WebDev-Tools.git
cd WebDev-Tools
npm install
```

---

### 2. Entwicklungsumgebung

**Lokaler Server (PHP 8+):**
```bash
# Variante 1: PHP Built-in Server
cd /var/www/html/WebDev-Tools
php -S localhost:8000 -t . dev/router.php

# Variante 2: XAMPP/MAMP
# Projekt in htdocs/ kopieren, Apache starten
```

**Tests ausführen:**
```bash
npm test                  # Alle Tests
npm run test:watch        # Watch-Modus
npm run test:coverage     # Mit Coverage-Report
```

---

### 3. Neues Tool erstellen

**Empfohlene Reihenfolge:**
1. **[INTEGRATION.md](techstack/INTEGRATION.md)** lesen – Schritt-für-Schritt-Checkliste
2. **[FRONTEND.md](techstack/FRONTEND.md)** konsultieren – Utilities & Patterns
3. **[TESTING.md](techstack/TESTING.md)** – Tests schreiben
4. **[BUILD.md](techstack/BUILD.md)** – Production-Build

**Typischer Workflow:**
```bash
# 1. Feature-Branch erstellen
git checkout -b feature/my-new-tool

# 2. PHP-Dateien erstellen (6 Sprachen)
# - tool-name/index.php
# - de/tool-name/index.php
# - es/tool-name/index.php
# - ... (siehe INTEGRATION.md)

# 3. JavaScript-Modul erstellen
# - assets/js/tools/myToolNameTool.js

# 4. Tool-Registry aktualisieren
# - config/tools.php

# 5. i18n-Strings hinzufügen
# - config/i18n/{en,de,es,pt,fr,it}.json

# 6. Tests schreiben
# - tests/unit/myToolNameTool.test.js

# 7. Tests ausführen
npm test

# 8. Manifest & Sitemaps generieren
php config/generate-manifest.php
php config/generate-sitemaps.php

# 9. Production-Build
bash build.sh

# 10. Commit & Push
git add .
git commit -m "feat: add MyTool"
git push origin feature/my-new-tool
```

---

## 🏗️ Projekt-Architektur

```
WebDev-Tools/
├── tool-name/               # Tool-Seiten (EN)
│   └── index.php
├── de/tool-name/            # Deutsche Versionen
│   └── index.php
├── es/tool-name/            # Spanische Versionen
│   └── index.php
├── assets/
│   ├── js/
│   │   ├── tools/           # Tool-Module (IIFE)
│   │   │   └── myToolTool.js
│   │   └── lib/             # Gemeinsame Utilities
│   │       ├── clipboard-utils.js
│   │       ├── download-utils.js
│   │       ├── dragdrop-utils.js
│   │       ├── validators.js
│   │       └── formatters.js
│   ├── css/                 # Stylesheets
│   └── img/                 # Images
├── config/
│   ├── tools.php            # Tool-Registry
│   ├── i18n/                # Übersetzungen (6 Sprachen)
│   │   ├── en.json
│   │   ├── de.json
│   │   └── ...
│   ├── generate-manifest.php
│   └── generate-sitemaps.php
├── partials/
│   └── tool-base.php        # Gemeinsames Layout
├── tests/
│   ├── unit/                # Jest-Tests
│   │   └── myToolTool.test.js
│   └── setup.js             # Test-Setup (Mocks)
├── docs/                    # Diese Dokumentation
│   ├── README.md
│   └── techstack/
├── dist/                    # Production-Build (generiert)
├── .htaccess                # Entwicklung
├── .htaccess.production     # Produktion
├── build.sh                 # Build-Script
├── package.json
└── jest.config.js
```

---

## 🔧 Häufige Aufgaben

### Tool-Kategorie wechseln

**Datei:** `config/tools.php`
```php
'myToolName' => [
  'category' => 'converters',  // encoders|formatters|generators|converters|references
  // ...
]
```

---

### Neue Utility hinzufügen

**Datei:** `assets/js/lib/my-new-util.js`
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

**Registrieren in `config/tools.php`:**
```php
'jsLibraries' => ['my-new-util', 'clipboard-utils']
```

---

### i18n-Strings aktualisieren

**Alle 6 Dateien gleichzeitig bearbeiten:**
- `config/i18n/en.json`
- `config/i18n/de.json`
- `config/i18n/es.json`
- `config/i18n/pt.json`
- `config/i18n/fr.json`
- `config/i18n/it.json`

**Verwendung in JS:**
```javascript
function t(key, params) {
  return window.i18n.t(key, params);
}

const label = t('tools.myTool.inputLabel');
```

---

### URL-Slug ändern (mit Redirect)

**1. `config/tools.php` aktualisieren:**
```php
'slugs' => [
  'en' => 'new-tool-name',
  'de' => 'neuer-werkzeug-name',
  // ...
]
```

**2. `.htaccess` UND `.htaccess.production`:**
```apache
# 301-Redirect Alt → Neu
RewriteRule ^old-tool-name/?$ /new-tool-name/ [R=301,L]
RewriteRule ^de/alter-werkzeug-name/?$ /de/neuer-werkzeug-name/ [R=301,L]
```

**3. Sitemap neu generieren:**
```bash
php config/generate-sitemaps.php
```

---

## 📊 Code-Qualität

### Code-Standards

| Aspekt | Standard |
|--------|----------|
| **PHP** | PSR-12, strict_types, XSS-Protection |
| **JavaScript** | IIFE-Pattern, 'use strict', keine `var` |
| **CSS** | Bootstrap 5.3, Custom Sass |
| **Tests** | Jest, 80% Coverage-Ziel |

---

### Linting (geplant)

**ESLint-Config (zukünftig):**
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

## 🔒 Security-Checkliste

Vor jedem Release prüfen:

- [ ] `npm audit` – Keine Critical/High Vulnerabilities
- [ ] CSP-Header korrekt (kein `'unsafe-eval'`)
- [ ] Alle User-Inputs validiert & escaped
- [ ] HTTPS erzwungen (HSTS)
- [ ] Keine sensiblen Daten in Logs/Console
- [ ] Tests grün (inkl. XSS-Tests)

**Siehe:** [SECURITY.md](techstack/SECURITY.md) für Details

---

## 📈 Performance-Metriken

### Aktuelle Ziele (April 2026)

| Metrik | Ziel | Aktuell |
|--------|------|---------|
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
2. **Code:** Implementierung + Tests
3. **Tests:** `npm test` (alle grün)
4. **Commit:** Conventional Commits (`feat:`, `fix:`, `docs:`)
5. **Push:** `git push origin feature/my-feature`
6. **PR:** Auf GitHub erstellen, Template ausfüllen
7. **Review:** Feedback umsetzen
8. **Merge:** Nach Approval durch Maintainer

---

### Commit-Message-Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Typen:**
- `feat`: Neues Feature
- `fix`: Bugfix
- `docs`: Dokumentations-Änderung
- `style`: Code-Formatierung (kein Logic-Change)
- `refactor`: Code-Refactoring
- `test`: Tests hinzufügen/ändern
- `chore`: Build-Prozess, Dependencies

**Beispiele:**
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

## 🌍 Internationalisierung (i18n)

### Unterstützte Sprachen

1. **Englisch (EN)** – Default, Referenz-Sprache
2. **Deutsch (DE)** – Vollständig
3. **Spanisch (ES)** – Vollständig
4. **Portugiesisch (PT)** – Vollständig
5. **Französisch (FR)** – Vollständig
6. **Italienisch (IT)** – Vollständig

### Neue Sprache hinzufügen

**1. JSON-Datei erstellen:**
```bash
cp config/i18n/en.json config/i18n/nl.json
# Übersetzen...
```

**2. Language-Handler erweitern:**
```php
// config/language-handler.php
$supportedLangs = ['en', 'de', 'es', 'pt', 'fr', 'it', 'nl'];
```

**3. Tool-Verzeichnisse erstellen:**
```bash
mkdir nl/
# Für jedes Tool:
mkdir nl/tool-name/
cp tool-name/index.php nl/tool-name/index.php
# Übersetzen...
```

**4. `config/tools.php` aktualisieren:**
```php
'slugs' => [
  'en' => 'tool-name',
  'de' => 'werkzeug-name',
  'nl' => 'gereedschap-naam',  // Neu
  // ...
]
```

---

## 📞 Support & Kontakt

### Fragen?

1. **Dokumentation durchsuchen** (diese Docs)
2. **CLAUDE.md lesen** – Projekt-Übersicht
3. **GitHub Issues** – Bug-Reports, Feature-Requests
4. **GitHub Discussions** – Allgemeine Fragen

### Links

- **Website:** https://webdev-tools.info
- **Repository:** https://github.com/RamonKaes/WebDev-Tools
- **Issues:** https://github.com/RamonKaes/WebDev-Tools/issues
- **Changelog:** [CHANGELOG.md](../CHANGELOG.md)

---

## 📝 License

**MIT License** – Siehe [LICENSE](../LICENSE) für Details.

---

**Letzte Aktualisierung:** April 2026 | **Version:** 2.1.0
