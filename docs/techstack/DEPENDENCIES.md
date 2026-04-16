# Dependencies – WebDev-Tools

**Externe Dependencies & deren Zweck** – Versions-Übersicht und Upgrade-Strategien.

---

## Production Dependencies

### Frontend-Framework

#### Bootstrap 5.3.0
```json
"bootstrap": "^5.3.0"
```

**Zweck:**
- Responsive Grid-System
- Form-Controls & Button-Styles
- Utility-Classes (Spacing, Flexbox)

**Verwendung:**
- Custom Sass-Build (`build-tools/bootstrap-custom.scss`)
- Nur benötigte Module importiert (kein jQuery, kein Popper.js)

**Upgrade-Strategie:**
- Minor-Updates (5.3.x → 5.3.y): Automatisch via `npm update`
- Major-Updates (5.x → 6.x): Breaking Changes prüfen, Tests ausführen

**Alternativen erwogen:**
- Tailwind CSS (verworfen: zu viel Build-Overhead)
- Pure CSS (verworfen: zu viel Custom-Code)

---

#### Bootstrap Icons
```html
<!-- Via CDN, kein npm-Package -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
```

**Zweck:**
- Icon-Set für Buttons & Tool-Kategorien
- 2000+ Icons (nur benötigte werden geladen)

**Verwendung:**
```html
<i class="bi bi-clipboard"></i>
<i class="bi bi-download"></i>
<i class="bi bi-gear"></i>
```

**Warum CDN?**
- Geringere Bundle-Size (keine SVG-Inlines)
- Browser-Caching über Domains hinweg
- Fallback auf lokale Kopie in `assets/bootstrap-icons/`

---

## Development Dependencies

### Build-Tools

#### Terser 5.27.0
```json
"terser": "^5.27.0"
```

**Zweck:**
- JavaScript-Minification
- Code-Compression (Whitespace, Comments entfernen)
- Variable-Mangling (Namen verkürzen)

**Verwendung:**
```bash
terser input.js -c -m -o output.min.js
```

**Optionen in `build.sh`:**
- `-c` (compress): Dead-code elimination
- `-m` (mangle): Variable-Namen verkürzen
- `--keep-fnames`: Function-Namen beibehalten (Debugging)

**Upgrade-Strategie:**
- Patch-Updates: Automatisch
- Minor-Updates: Nach npm-audit prüfen
- Major-Updates: Test-Suite ausführen, minified JS validieren

---

#### cssnano 6.0.3 & csso
```json
"cssnano": "^6.0.3",
"cssnano-cli": "^1.0.5"
```

**Zweck:**
- CSS-Minification & Optimierung
- Kombiniert identische Regeln
- Verkürzt Farb-Codes (`#ffffff` → `#fff`)

**Verwendung:**
```bash
csso assets/css/style.css -o dist/assets/css/style.min.css
```

**Alternative:** PostCSS mit cssnano-Plugin (komplexere Konfiguration)

---

#### Sass 1.70.0
```json
"sass": "^1.70.0"
```

**Zweck:**
- Custom Bootstrap-Builds
- Variablen & Mixins für Theme-Anpassung

**Verwendung:**
```bash
sass build-tools/bootstrap-custom.scss assets/css/bootstrap-custom.css
```

**Wichtige Konfiguration (`bootstrap-custom.scss`):**
```scss
// Nur benötigte Bootstrap-Module importieren
@import "node_modules/bootstrap/scss/functions";
@import "node_modules/bootstrap/scss/variables";
@import "node_modules/bootstrap/scss/mixins";
@import "node_modules/bootstrap/scss/grid";
@import "node_modules/bootstrap/scss/forms";
@import "node_modules/bootstrap/scss/buttons";
@import "node_modules/bootstrap/scss/utilities";
```

**Upgrade-Strategie:**
- Dart Sass ist die Referenz-Implementierung
- LibSass (deprecated) → Dart Sass Migration bereits erfolgt

---

### Testing-Framework

#### Jest 30.3.0
```json
"jest": "^30.3.0",
"jest-environment-jsdom": "^30.3.0"
```

**Zweck:**
- Unit-Tests für alle Tools
- DOM-Testing via jsdom
- Code-Coverage-Reports

**Konfiguration:** `jest.config.js`
```javascript
module.exports = {
  testEnvironment: 'jsdom',
  testMatch: ['**/tests/unit/**/*.test.js'],
  coverageThreshold: {
    global: {
      branches: 70,
      functions: 80,
      lines: 80,
      statements: 80
    }
  }
};
```

**Upgrade-Strategie:**
- Minor-Updates: Automatisch (meist rückwärtskompatibel)
- Major-Updates: Breaking Changes in Release Notes prüfen

**Warum Jest?**
- Batteries-included (Mocking, Assertions, Coverage)
- jsdom-Integration out-of-the-box
- Snapshot-Testing (aktuell nicht genutzt)

**Alternativen erwogen:**
- Vitest (verworfen: zu neu, weniger mature)
- Mocha + Chai (verworfen: mehr Setup-Overhead)

---

### Utilities

#### watch 1.0.2
```json
"watch": "^1.0.2"
```

**Zweck:**
- File-Watching für Test-Driven Development
- Auto-Reload bei Code-Änderungen

**Verwendung:**
```bash
npm run test:watch
```

**Alternative:** Nodemon (schwerer, mehr Features als benötigt)

---

## Runtime-Dependencies (Browser)

### Keine externen Runtime-Dependencies

**Design-Entscheidung:**
- **Kein React/Vue/Angular** – Vanilla JS für maximale Performance
- **Kein jQuery** – Native DOM-API ist ausreichend
- **Kein Lodash** – Eigene Utilities in `assets/js/lib/`
- **Kein Axios** – `fetch()` für API-Calls (aktuell keine)

**Vorteile:**
- Kleinere Bundle-Size
- Keine Version-Konflikte
- Schnellere Ladezeiten
- Kein Supply-Chain-Risiko

---

## Node.js & npm-Versionen

**Minimum-Versionen (`package.json`):**
```json
"engines": {
  "node": ">=18.0.0",
  "npm": ">=9.0.0"
}
```

**Warum Node 18+?**
- Native `fetch()` Support
- Performance-Verbesserungen
- LTS-Version (Long-Term Support bis April 2025)

**Entwicklungs-Empfehlung:**
- Node 20 LTS (bis April 2026)
- nvm für Version-Management: `nvm use 20`

---

## Security & Audit

### npm audit

**Regelmäßige Prüfung:**
```bash
npm audit
npm audit fix           # Auto-Fix für kompatible Updates
npm audit fix --force   # Auch Major-Updates (Vorsicht!)
```

**Aktueller Status:**
```bash
# Beispiel-Output (April 2026)
found 0 vulnerabilities
```

**Workflow:**
1. Wöchentlich `npm audit` ausführen
2. Bei Vulnerabilities: Issue im Repo erstellen
3. Updates prüfen & testen
4. Nach Fix: `npm test` ausführen

---

### Dependency-Bot (GitHub Dependabot)

**Konfiguration (`.github/dependabot.yml`):**
```yaml
version: 2
updates:
  - package-ecosystem: "npm"
    directory: "/"
    schedule:
      interval: "weekly"
    open-pull-requests-limit: 5
    reviewers:
      - "RamonKaes"
    labels:
      - "dependencies"
```

**Automatische PRs für:**
- Security-Updates (sofort)
- Minor-Updates (wöchentlich)
- Major-Updates (mit Changelog-Link)

---

## Dependency-Upgrade-Workflow

### 1. Check for Updates
```bash
npm outdated
```

**Output-Beispiel:**
```
Package    Current  Wanted  Latest  Location
jest       30.3.0   30.3.1  31.0.0  node_modules/jest
terser     5.27.0   5.27.2  5.28.0  node_modules/terser
```

---

### 2. Update Strategy

**Patch-Updates (z.B. 5.27.0 → 5.27.2):**
```bash
npm update              # Automatisch
```

**Minor-Updates (z.B. 30.3.0 → 30.4.0):**
```bash
npm update <package>    # Einzeln updaten
npm test                # Tests ausführen
```

**Major-Updates (z.B. 30.x → 31.x):**
```bash
# 1. Changelog lesen
npm view jest versions  # Alle Versionen anzeigen
npm view jest@31.0.0    # Changelog-Link

# 2. In separatem Branch
git checkout -b upgrade-jest-31
npm install jest@31.0.0

# 3. Tests ausführen
npm test

# 4. Bei Failures: Breaking Changes beheben
# 5. PR erstellen & Review
```

---

### 3. Lockfile-Management

**package-lock.json:**
- Committed ins Repo
- Garantiert reproduzierbare Builds
- Nach Updates aktualisieren: `npm install`

**Lockfile-Konflikte (bei Merge):**
```bash
# Automatisch auflösen
npm install
git add package-lock.json
git commit -m "chore: resolve lockfile conflicts"
```

---

## CDN-Dependencies

### Bootstrap Icons
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
```

**Fallback (wenn CDN down):**
```html
<link rel="stylesheet" href="/assets/bootstrap-icons/bootstrap-icons.css">
```

**Auto-Fallback-Script:**
```javascript
window.addEventListener('DOMContentLoaded', () => {
  const link = document.querySelector('link[href*="cdn.jsdelivr.net"]');
  if (link && !document.fonts.check('1em bootstrap-icons')) {
    // CDN failed, load local copy
    const fallback = document.createElement('link');
    fallback.rel = 'stylesheet';
    fallback.href = '/assets/bootstrap-icons/bootstrap-icons.css';
    document.head.appendChild(fallback);
  }
});
```

---

## Performance-Monitoring

### Bundle-Size-Tracking

**Aktuell (April 2026):**
| Asset | Size (Original) | Size (Minified) | Compression |
|-------|-----------------|-----------------|-------------|
| `app.js` | 45 KB | 18 KB | 60% |
| `style.css` | 120 KB | 35 KB | 71% |
| `tools/*.js` (avg) | 8 KB | 3 KB | 62% |

**Ziel:**
- JS-Tools: < 5 KB (minified + gzipped)
- CSS: < 50 KB (minified + gzipped)

**Tools:**
```bash
# Bundle-Size analysieren
du -sh dist/assets/js/
gzip -c dist/assets/js/app.js | wc -c  # Gzipped size
```

---

## License Compliance

**Alle Dependencies MIT-lizenziert:**
- Bootstrap: MIT
- Jest: MIT
- Terser: BSD-2-Clause
- Sass: MIT

**License-Check:**
```bash
npx license-checker --summary
```

**Keine GPL-Dependencies** (verhindert Copyleft-Probleme)

---

## Dependency-Documentation

**Dependencies mit speziellen Konfigurationen:**

### Terser
- **Config-Location:** `build.sh` (CLI-Flags)
- **Custom-Settings:** `--keep-fnames` für Debugging
- **Exclude-Pattern:** `*.min.js`, `node_modules/**`

### Jest
- **Config-Location:** `jest.config.js`
- **Custom-Matchers:** Keine (nur Built-ins)
- **Setup-File:** `tests/setup.js` (global mocks)

### Sass
- **Config-Location:** `build-tools/bootstrap-custom.scss`
- **Import-Paths:** `node_modules/bootstrap/scss/`
- **Output-Style:** `compressed` (Production)

---

## Future Considerations

### Potenzielle neue Dependencies

**In Evaluation:**
1. **Playwright** (E2E-Tests) – Alternative zu manuellen Browser-Tests
2. **ESLint** (Linting) – Code-Quality-Checks
3. **Prettier** (Formatting) – Konsistente Code-Style

**Abgelehnt:**
- **Webpack/Vite** – Build-Komplexität unnötig für PHP-basiertes Projekt
- **TypeScript** – Overhead für 19 kleine Tools zu hoch
- **React/Vue** – Vanilla JS ist ausreichend performant

---

**Weitere Infos:**
- [BUILD.md](BUILD.md) – Build-Prozess mit Dependencies
- [TESTING.md](TESTING.md) – Jest-Konfiguration
- [SECURITY.md](SECURITY.md) – Dependency-Security
