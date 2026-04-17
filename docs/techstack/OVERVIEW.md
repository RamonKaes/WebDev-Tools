# Tech Stack Overview – WebDev-Tools

**Privacy-First Developer Toolbox** – Alle Operationen laufen client-side im Browser, kein Server-State, keine Datenübertragung.

---

## Architektur-Prinzipien

### 1. **Client-Side Only**
- Alle sensiblen Daten (Passwörter, Tokens, Hashes) bleiben im Browser
- Kein Backend-Processing, kein Analytics-Tracking
- CSP (Content Security Policy) aktiv

### 2. **Mehrsprachigkeit (i18n)**
- 6 Sprachen: EN, DE, ES, PT, FR, IT
- PHP-Content (Features, Ressourcen) hardcoded pro Sprache
- JS-UI-Strings (Labels, Buttons) in JSON-Dateien (`config/i18n/`)

### 3. **Tool-Registry System**
- Zentrale Konfiguration in `config/tools.php`
- Jedes Tool: Metadaten, Libraries, Features, SEO-Template
- Automatische Manifest-/Sitemap-Generierung

---

## Stack-Komponenten

| Layer | Technologie | Details |
|-------|-------------|---------|
| **Frontend** | Vanilla JS (IIFE-Pattern) | Gemeinsame Utilities, kein Framework |
| **Styling** | Bootstrap 5.3 + Custom Sass | Responsive, konsistentes Design |
| **Backend** | PHP 8+ (strict_types) | Tool-Registry, i18n, Routing |
| **Build** | Bash, Terser, csso/cssnano | Minification, Optimierung |
| **Testing** | Jest 30 + jsdom | 841 Tests, 20 Suites |
| **Deployment** | rsync + htaccess Rewrites | Production-Build nach `dist/` |

---

## Projekt-Lifecycle

```bash
# Entwicklung
npm test                  # Jest Unit-Tests ausführen
npm run test:coverage     # Mit Coverage-Report

# Build
bash build.sh             # Production-Build → dist/

# Nach neuem Tool
php config/generate-manifest.php
php config/generate-sitemaps.php
```

---

## Ordnerstruktur (vereinfacht)

```
tool-name/index.php              # Tool-Seite (PHP)
de/tool-name/index.php           # Deutsche Version
assets/js/tools/toolNameTool.js  # Tool-Logik (IIFE)
assets/js/lib/*.js               # Gemeinsame Utilities
config/tools.php                 # Tool-Registry
config/i18n/{lang}.json          # UI-Strings pro Sprache
tests/unit/toolNameTool.test.js  # Jest-Tests
partials/tool-base.php           # Gemeinsames Layout
```

---

## Weitere Dokumentation

- **[FRONTEND.md](FRONTEND.md)** – JS-Pattern, IIFE-Konventionen, gemeinsame Utilities
- **[BACKEND.md](BACKEND.md)** – PHP-Standards, tools.php-Registry, i18n-System
- **[BUILD.md](BUILD.md)** – build.sh, Minification, dist/-Struktur
- **[TESTING.md](TESTING.md)** – Jest-Setup, Test-Patterns, Mocking
- **[INTEGRATION.md](INTEGRATION.md)** – Checkliste für neue Tools

---

**Stand:** April 2026 | **Version:** 2.1.0 | **Tools:** 20 | **Sprachen:** 6
