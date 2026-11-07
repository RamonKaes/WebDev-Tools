# Tech Stack Overview – WebDev-Tools

**Privacy-First Developer Toolbox** – All operations run client-side in the browser, no server state, no data transmission.

---

## Architecture Principles

### 1. Client-Side Only
- All sensitive data (passwords, tokens, hashes) stays in the browser
- No backend processing, no analytics tracking
- Nonce-based CSP (`config/security-headers.php`)

### 2. Multi-language (i18n)
- 6 languages: EN, DE, ES, PT, FR, IT
- PHP content (features, resources, sections) hardcoded per language version
- JS UI strings and SEO meta in `config/i18n/{lang}.json`

### 3. Tool Registry
- Central configuration in `config/tools.php`
- `config/generate-manifest.php` dumps it to `config/manifest.json`, which `assets/js/tool-loader.js` reads to load the tool script on demand
- `config/generate-sitemaps.php` writes one sitemap per language

---

## Stack Components

| Layer | Technology | Details |
|-------|------------|---------|
| **Frontend** | Vanilla JS, classic `<script>` IIFEs | Shared globals `ClipboardUtils`, `DownloadUtils`, `A11yUtils`; no framework, no bundler |
| **Styling** | Bootstrap 5.3 (custom Sass build) + `assets/css/style.css` | Bootstrap Icons self-hosted |
| **Backend** | PHP 8 (`strict_types`) | Tool registry, i18n, templating (`partials/tool-base.php`) |
| **Build** | `build.sh` (Bash), csso, sass | Copies files to `dist/`, minifies CSS only |
| **Unit tests** | Jest 30 + jsdom | `tests/unit/`, coverage thresholds in `jest.config.js` |
| **Browser tests** | Playwright + axe-core | `tests/browser/`, against `dist/` behind a local Apache |
| **Lint / checks** | ESLint (flat config), `build-tools/check-i18n.js` | `npm run lint`, `npm run check:i18n` |
| **Deployment** | lftp over FTP(S) | `build-tools/deploy-ftp.sh`, guarded by `check-deploy.sh` |
| **CI** | GitHub Actions | `ci.yml`, `codeql.yml`, `links.yml` (lychee); Dependabot weekly |

---

## Commands

```bash
npm test                    # Jest unit tests
npm run test:coverage       # with coverage report and thresholds
npm run lint                # ESLint
npm run check:i18n          # key parity of the six i18n files
bash build.sh               # production build → dist/
npm run test:browser        # Playwright against dist/ (run build.sh first)
npm run deploy:dry          # show what an upload would change
npm run deploy              # upload dist/ (main checkout only)
npm run verify:prod         # check the live site against dist/ (read-only)

php config/generate-manifest.php    # after changing config/tools.php
php config/generate-sitemaps.php
```

---

## Build (`build.sh`)

1. Wipes `dist/` and writes `.build-commit` (the HEAD commit, or `uncommitted changes`), which the deploy guard compares later
2. Copies root PHP/txt/xml/webmanifest files, `partials/`, `config/*.php`, `config/manifest.json`, `config/i18n/*.json`
3. Copies `.htaccess.production` to `dist/.htaccess`
4. Regenerates the sitemaps (`php config/generate-sitemaps.php`)
5. Copies `assets/js/` unchanged (no bundling, no JS minification)
6. Minifies `assets/css/*.css` with csso (falls back to a plain copy)
7. Compiles a custom Bootstrap from `build-tools/bootstrap-custom.scss` to `dist/assets/bootstrap/css/bootstrap.min.css` and copies `bootstrap.bundle.min.js` and `assets/bootstrap-icons/`
8. Copies `assets/img`, `assets/data`, the tool directories listed in the script and the language directories `de es fr it pt`

Cache busting is not part of the build: `assetSrc()` in `config/helpers.php` appends a content hash (`?v=`) to every asset URL, and `.htaccess.production` serves URLs with `?v=` as immutable for a year.

---

## Deploy

`npm run deploy` runs `build-tools/deploy-ftp.sh`:

1. `build-tools/check-deploy.sh` refuses unless the branch is `main`, the tree is clean, HEAD equals `origin/main`, `.build-commit` equals HEAD, and `dist/` holds no backup/temp files or files unknown to git
2. Connection settings come from `deploy.config` (see `deploy.config.example`), the password from the system keyring (`secret-tool`, service `webdev-tools-ftp`)
3. A dry run lists files that are new on the server; uploading them needs `--allow-new`. `--delete` also removes remote files missing from `dist/`
4. `lftp mirror --reverse` uploads `dist/`
5. `build-tools/verify-prod.js` opens every sitemap URL of the live site in Chrome (status, PHP errors, console errors, tool renders) and compares the deployed tool scripts and i18n files byte for byte with `dist/`

---

## Folder Structure (simplified)

```
tool-name/index.php              # Tool page (EN)
de/tool-name/index.php           # German version (localized slug)
assets/js/tools/toolNameTool.js  # Tool logic (IIFE)
assets/js/lib/                   # clipboard-utils, download-utils, a11y-utils, wordlist, performance-monitoring
assets/js/tool-loader.js         # Loads the tool script named in manifest.json
config/tools.php                 # Tool registry
config/i18n/{lang}.json          # UI strings and SEO meta per language
partials/tool-base.php           # Shared tool layout
build-tools/                     # bootstrap-custom.scss, check-deploy.sh, deploy-ftp.sh, verify-prod.js, check-i18n.js
tests/unit/                      # Jest tests + setup.js
tests/browser/                   # Playwright specs, fixtures.js, serve.sh
```

---

## Further Documentation

- **[NEUES-TOOL.md](NEUES-TOOL.md)** – Adding a tool: PHP page, JS pattern, registry, i18n, tests, rewrites (German)
- **[BACKEND.md](BACKEND.md)** – PHP standards, registry, i18n, helpers, security headers
- **[TESTING.md](TESTING.md)** – Jest setup, Playwright/axe browser tests, CI
- **[SECURITY.md](SECURITY.md)** – CSP, headers, XSS prevention, sensitive data (German)
