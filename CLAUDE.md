# CLAUDE.md – WebDev-Tools

Privacyfirst Developer-Toolbox. Alle Operationen laufen **client-side im Browser** — kein Server-State, keine Datenübertragung.

---

## Befehle

```bash
npm test                        # Jest Unit-Tests
npm run test:coverage           # Mit Coverage-Report und Schwellenwerten (wie in CI)
npm run lint                    # ESLint über assets/js, build-tools und tests
bash build.sh                   # Production-Build nach dist/
npm run test:browser            # Playwright gegen dist/ hinter Apache (vorher build.sh)
npm run test:browser:live       # Dieselbe Suite gegen die Live-Seite (nur lesend, nach einem Deploy)
npm run deploy                  # Upload aus dem Haupt-Checkout, mit Wächter und Prod-Prüfung
npm run deploy:dry              # Zeigt neue und nur auf dem Server liegende Dateien
npm run verify:prod             # Live-Seite gegen dist/ prüfen (nur lesend)
php config/generate-manifest.php    # Nach neuem Tool und nach Änderungen an JS/i18n (Version = Inhalts-Hash, CI prüft)
php config/generate-sitemaps.php    # Nach neuem Tool ausführen
```

---

## Projektstruktur

```
tool-name/index.php             # Tool-Seite (PHP)
assets/js/tools/toolNameTool.js # Tool-Logik (IIFE, registriert sich in window.Tools)
assets/js/lib/                  # Gemeinsame Utilities (clipboard-utils, download-utils, a11y-utils, wordlist)
config/tools.php                # Tool-Registry (Metadaten, Libraries, Features)
config/i18n/{en,de,es,pt,fr,it}.json  # Übersetzungen
tests/unit/toolNameTool.test.js # Jest-Tests
partials/tool-base.php          # Gemeinsames Layout (alle Tools includen dies)
```

---

## PHP-Tool-Interface (`tool-name/index.php`)

Jede Tool-PHP-Datei setzt diese Variablen **vor** dem `require_once tool-base.php`:

```php
declare(strict_types=1);        // Pflicht, erste Zeile

$toolId = 'myToolName';         // camelCase, muss tools.php-Key matchen
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';
$features = ['Feature A', 'Feature B'];  // Einfaches Array, kein HTML
$usefulResources = [
    ['url' => '…', 'title' => '…', 'description' => '…'],
];

// Optional:
// $additionalSections = [['title' => '…', 'icon' => '…', 'content' => <<<HTML … HTML]];
// $customNoticeContent / $customNoticeType ('info'|'warning'|'success')
```

**Regel:** Der gesamte PHP-Content (Überschriften, Features, Ressourcen, Additional Sections) bleibt **hardcoded in PHP** — kein i18n-JSON. Jede Sprachversion (`de/`, `es/`, …) wird **manuell gepflegt**, da Übersetzungen keine 1:1-Entsprechungen sind, sondern kulturell angepasst.

---

## JavaScript-Tool-Konventionen

```js
(function() {
  'use strict';
  // i18n-Helper
  function t(key, params) { … }

  function init() {
    const container = document.getElementById('tool-container');
    container.innerHTML = `…`;
    // Event-Listener hier registrieren
  }

  window.Tools.register('myToolName', { open: init });
})();
```

- `textContent` statt `innerHTML` für User-Input
- `window.ClipboardUtils.copyToClipboard()` für Copy-Buttons
- `window.DownloadUtils.downloadText()` für Downloads
- Kein `document.execCommand`, kein `var`

---

## PHP-Standards

- `declare(strict_types=1)` in **jeder** PHP-Datei
- `htmlspecialchars()` für jeden User-Input-Output
- Keine gemischten Typen ohne Erklärung

---

## i18n-Regeln

- **JS-UI-Strings** (Labels, Buttons, Fehlermeldungen im Tool) → `config/i18n/{lang}.json` unter `tools.myToolName.*`
- **PHP-Content** (Features-Liste, Ressourcen, Additional Sections, Seitentexte) → hardcoded in jeder Sprachversion, **nie** aus JSON
- Schlüssel-Struktur JSON: UI-Strings unter `tools.toolId.*` (`toc_title`, `h1_title`, `card_description`, Labels …), Title/Description/Structured-Data unter `seo.toolId.*` (`meta_title`, `meta_description`, `featureList`, `keywords`)
- Alle 6 Sprach-JSON-Dateien gleichzeitig pflegen

---

## Sicherheit

- Sensible Daten (Passwörter, Hashes, Tokens) verlassen **nie** den Browser
- CSP ist aktiv — kein inline-JS außerhalb der IIFE
- XSS: `textContent` in JS, `htmlspecialchars()` in PHP, `escapeHtml()` in tool-loader

---

## Tests schreiben

Muster: `tests/unit/toolNameTool.test.js`
- `beforeAll`: `window.Tools`, `window.i18n`, `window.ClipboardUtils`, `window.DownloadUtils` mocken, dann `require('…/toolNameTool.js')`
- `openTool()`: `div#tool-container` anlegen, `tool.open()` aufrufen
- Pro Konverter/Feature mindestens 1 Happy-Path + 1 Fehlerfall

Browser-Tests: `tests/browser/` (Chrome + lokaler Apache mit `.htaccess.production`, braucht `apache2`, `libapache2-mod-php`)
- `pages.spec.js`: alle Sitemap-Seiten, Redirects, Security-Header; `tools.spec.js`: Normalfall je Tool mit Erwartungswerten von außerhalb des Tools
- `accessibility.spec.js`: axe-core (WCAG 2.2 AA) über alle englischen Seiten in Hell und Dunkel. Was axe meldet, wird behoben; neue Felder brauchen ein `<label for>` oder `aria-label`
- Der Browser ruft `webdev-tools.info` auf, Chrome leitet lokal um. **Nie** die `request`-Fixture von Playwright nutzen: Sie umgeht die Umleitung und träfe die echte Seite

---

## URL-Änderungen → htaccess-Rewrite-Rules

Bei jeder URL-Änderung (neuer Slug, umbenanntes Tool, neue Sprachversion) **immer beide** Dateien aktualisieren:

- `.htaccess` — Entwicklungsumgebung
- `.htaccess.production` — Produktionsumgebung

Muster (301-Redirect vom alten zum neuen Slug):
```apache
RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]
```

---

## Neues Tool hinzufügen – Checkliste

1. `tool-name/index.php` + Sprachversionen (`de/`, `es/`, `fr/`, `it/`, `pt/`)
2. `assets/js/tools/toolNameTool.js`
3. Eintrag in `config/tools.php`
4. i18n-Keys in allen 6 JSON-Dateien
5. `php config/generate-manifest.php && php config/generate-sitemaps.php`
6. `tests/unit/toolNameTool.test.js` + Normalfall in `tests/browser/tools.spec.js` (Tool-Zahl in `pages.spec.js` anpassen)
7. `bash build.sh`
8. Bei lokalisierten Slugs: Rewrite-Rules in `.htaccess` **und** `.htaccess.production`
