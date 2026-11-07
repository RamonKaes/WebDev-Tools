# WebDev-Tools Documentation

Developer documentation: tech stack, how to add a tool, testing, security. Every statement here is checked against the code; when a file in the repository disagrees with this text, the file wins and the text needs fixing.

---

## Documentation Index (`techstack/`)

| Document | Content |
|----------|---------|
| **[OVERVIEW](techstack/OVERVIEW.md)** | Architecture, stack components, commands, build and deploy |
| **[NEUES-TOOL](techstack/NEUES-TOOL.md)** | **Add a new tool** – registry, PHP page, JS pattern, i18n, tests, rewrites (German) |
| **[BACKEND](techstack/BACKEND.md)** | PHP standards, tool registry, i18n, helpers, security headers, routing |
| **[TESTING](techstack/TESTING.md)** | Jest unit tests, Playwright and axe browser tests, lint, CI |
| **[SECURITY](techstack/SECURITY.md)** | CSP, security headers, XSS prevention, sensitive data (German) |

Project conventions in short form: [CLAUDE.md](../CLAUDE.md) in the repository root.

---

## Quick Start

```bash
git clone https://github.com/RamonKaes/WebDev-Tools.git
cd WebDev-Tools
npm install           # dev tooling only; production needs PHP and Apache, not Node
```

### Local server

`config/config.php` sets `BASE_PATH` to `/WebDev-Tools` whenever the host is `localhost` or `127.0.0.1`, so the checkout must be reachable at `http://localhost/WebDev-Tools/`. With Apache that means cloning into the document root (for example `/var/www/html/WebDev-Tools`) with `AllowOverride All` and `mod_rewrite` enabled; the development `.htaccess` is used as is. On any other host name the site assumes it runs at the domain root (`BASE_PATH` empty).

### Checks

```bash
npm test                  # Jest unit tests (tests/unit/)
npm run test:coverage     # with coverage thresholds from jest.config.js
npm run lint              # ESLint, flat config in eslint.config.js
npm run check:i18n        # all six i18n files carry the same keys and placeholders
bash build.sh             # production build to dist/
npm run test:browser      # Playwright + axe against dist/ (needs apache2, libapache2-mod-php)
```

### Add a tool

Follow [NEUES-TOOL.md](techstack/NEUES-TOOL.md). In short: registry entry in `config/tools.php`, six PHP pages, one IIFE script, i18n keys in six JSON files, `php config/generate-manifest.php && php config/generate-sitemaps.php`, Jest test, browser test entry, rewrite rules in both `.htaccess` files.

---

## Project Layout

```
WebDev-Tools/
├── tool-name/index.php          # Tool pages (EN)
├── de/ es/ fr/ it/ pt/          # Language versions (localized slugs, own sitemap.xml and site.webmanifest)
├── assets/
│   ├── js/tools/*Tool.js        # One IIFE per tool, loaded on demand by js/tool-loader.js
│   ├── js/lib/                  # clipboard-utils, download-utils, a11y-utils (globals); wordlist, performance-monitoring (import())
│   ├── js/                      # helpers, i18n, tool-registry, tool-loader, sidebar/theme scripts
│   ├── css/                     # style.css (minified by build.sh)
│   ├── bootstrap/, bootstrap-icons/   # self-hosted
│   └── img/, data/
├── config/
│   ├── config.php               # SUPPORTED_LANGS, BASE_PATH, $baseUrl, detectUserLanguage()
│   ├── tools.php                # Tool registry
│   ├── helpers.php              # getToolConfig(), getAllTools(), assetSrc(), loadI18n(), …
│   ├── security-headers.php     # CSP and other headers
│   ├── language-handler.php     # AJAX endpoint that sets the language cookie
│   ├── manifest.json            # Generated registry dump for tool-loader.js
│   ├── generate-manifest.php, generate-sitemaps.php
│   └── i18n/{en,de,es,pt,fr,it}.json
├── partials/                    # head, header-with-sidebar, tool-base, related-tools, footer, error-template, …
├── build-tools/                 # bootstrap-custom.scss, check-deploy.sh, deploy-ftp.sh, verify-prod.js, check-i18n.js
├── tests/unit/                  # Jest tests and setup.js
├── tests/browser/               # pages.spec.js, tools.spec.js, accessibility.spec.js, fixtures.js, serve.sh
├── dist/                        # Build output (generated, not in git)
├── .htaccess                    # Development rewrites
├── .htaccess.production         # Becomes dist/.htaccess
├── build.sh, playwright.config.js, jest.config.js, eslint.config.js, package.json
└── .github/workflows/           # ci.yml, codeql.yml, links.yml; dependabot.yml
```

---

## Common Tasks

### Change a tool's category

`config/tools.php`, key `category`: one of `encoders`, `formatters`, `converters`, `generators`, `stringtools`, `references`, `utilities` (the list in `getNavigationStructure()` in `config/helpers.php`). Then `php config/generate-manifest.php`.

### Add a shared utility

Create `assets/js/lib/my-util.js` as an IIFE that assigns `window.MyUtil = { … }`, add a `<script src="<?= assetSrc('js/lib/my-util.js') ?>">` line to `partials/common-scripts.php`, and a Jest test in `tests/unit/`. Coverage counts every file under `assets/js/` (`collectCoverageFrom` in `jest.config.js`).

### Update i18n strings

Edit all six files under `config/i18n/`, then `npm run check:i18n`. Tool UI strings live under `tools.<toolId>.*` (snake_case, e.g. `input_title`, `encode_btn`), SEO meta under `seo.<toolId>.{meta_title,meta_description,keywords,featureList,applicationCategory}`. In JS: `window.i18n.t('tools.myTool.input_title', { count: 3 })`; placeholders may be written `{{count}}` or `{count}`.

### Change a URL slug (with redirect)

1. `config/tools.php` → `slugs[lang]`, rename the directory to match
2. Add a 301 rule to **both** `.htaccess` and `.htaccess.production`:
   ```apache
   RewriteRule ^de/alter-slug/?$ /de/neuer-slug/ [R=301,L]
   ```
3. `php config/generate-manifest.php && php config/generate-sitemaps.php`
4. Update the entries in `tests/browser/tools.spec.js` and the redirect checks in `tests/browser/pages.spec.js` if they name the slug

### Add a language

The language list is duplicated in four places; change all of them: `SUPPORTED_LANGS` and `$supportedLanguages` in `config/config.php`, `$allowedLanguages` in `config/language-handler.php`, `supportedLanguages` in `assets/js/i18n.js`. Also `LANGS` in `build-tools/check-i18n.js` and `build-tools/verify-prod.js`, the `lang_dir` loop in `build.sh`, a new `config/i18n/xx.json`, a tool directory per tool under `xx/`, `slugs.xx` for every tool, and `xx/sitemap.xml` / `xx/site.webmanifest`.

---

## Code Standards

| Aspect | Standard |
|--------|----------|
| **PHP** | `declare(strict_types=1)` first, `htmlspecialchars()` for every output of user input, PHP 8 |
| **JavaScript** | IIFE, `'use strict'`, no `var`, `textContent` for user input, no `eval`/`execCommand`; enforced by ESLint (`eslint.config.js`: recommended rules, `no-var`, `prefer-const`) |
| **CSS** | Bootstrap utility classes first, custom rules in `assets/css/style.css` |
| **Accessibility** | WCAG 2.2 AA checked by axe in `tests/browser/accessibility.spec.js`; new form fields need `<label for>` or `aria-label` |
| **Tests** | Jest for every tool and shared lib, coverage floors in `jest.config.js`; one browser normal case per tool |

---

## Release Checklist

- [ ] `npm run lint && npm test && npm run check:i18n` green
- [ ] `bash build.sh && npm run test:browser` green
- [ ] `npm audit` shows no critical/high findings
- [ ] Sitemaps regenerated when tools changed (CI fails otherwise)
- [ ] `CHANGELOG.md` updated
- [ ] Deploy from the `main` checkout: `npm run deploy:dry`, then `npm run deploy`; `npm run verify:prod` runs automatically afterwards

---

## Contributing

1. Branch from `main`: `git checkout -b feature/my-feature`
2. Implement with tests
3. Run the checks above
4. Conventional commits: `feat:`, `fix:`, `docs:`, `test:`, `chore:`, `refactor:`
5. Open a pull request; CI (`.github/workflows/ci.yml`) runs Jest on Node 22 and 24 with lint and coverage, the i18n check, `php -l` over every PHP file, the sitemap diff, the production build and the browser tests

---

## Links

- **Website:** https://webdev-tools.info
- **Repository:** https://github.com/RamonKaes/WebDev-Tools
- **Issues:** https://github.com/RamonKaes/WebDev-Tools/issues
- **Changelog:** [CHANGELOG.md](../CHANGELOG.md)
- **License:** MIT, see [LICENSE](../LICENSE)
