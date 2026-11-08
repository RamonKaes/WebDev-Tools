# Testing – WebDev-Tools

**Jest 30 with jsdom** for unit tests, **Playwright with axe-core** for browser and accessibility tests, **ESLint** for static checks. Current counts: run `npm test`.

---

## Commands

```bash
npm test                  # Jest, all suites in tests/unit/
npm run test:watch        # Jest watch mode
npm run test:coverage     # Jest with coverage; fails below the thresholds in jest.config.js
npm run lint              # ESLint over the repository (eslint.config.js)
npm run check:i18n        # key/placeholder parity of config/i18n/*.json
bash build.sh             # production build, required before the browser tests
npm run test:browser      # Playwright: tests/browser/*.spec.js against dist/

npm test -- uuidGeneratorTool          # one suite
npm test -- -t "should encode"         # tests matching a name
npx playwright test tools.spec.js      # one browser spec
```

---

## Jest Configuration (`jest.config.js`)

```javascript
module.exports = {
  testEnvironment: 'jest-environment-jsdom',
  testEnvironmentOptions: { url: 'http://localhost/' },
  setupFiles: ['./tests/unit/setup.js'],
  testMatch: ['**/tests/unit/**/*.test.js'],
  verbose: true,
  collectCoverageFrom: ['assets/js/**/*.js', '!assets/js/lib/wordlist.js', '!assets/js/lib/performance-monitoring.js'],
  coverageThreshold: { global: { statements: 60, branches: 50, functions: 60, lines: 62 } },
};
```

Coverage counts every shipped script, not only the ones a test requires. The thresholds are floors slightly below the measured values; raise them as coverage grows, never lower them.

### `tests/unit/setup.js`

Provides only what jsdom lacks: `TextEncoder`/`TextDecoder` from `util`, `URL.createObjectURL`/`revokeObjectURL` mocks and `HTMLElement.prototype.scrollIntoView`. **No** registry, i18n or library mocks live here; every suite sets up its own.

---

## Tool Test Pattern

Reference: `tests/unit/uuidGeneratorTool.test.js`. Every suite mocks the globals the tool touches, requires the script once (it registers itself) and renders into a fresh container per test.

```javascript
'use strict';
const path = require('path');
let tool;

beforeAll(() => {
  global.window = global;
  global.Tools = { _tools: {}, register: (name, obj) => { global.Tools._tools[name] = obj; }, open: jest.fn() };
  global.i18n = { t: (key) => key };                       // tests assert on keys, not translations
  global.ClipboardUtils = { copyToClipboard: jest.fn().mockResolvedValue(true) };
  global.DownloadUtils = { downloadText: jest.fn() };
  require(path.join(__dirname, '../../assets/js/tools/uuidGeneratorTool.js'));
  tool = global.Tools._tools.uuidGeneratorTool;
});

function openTool() {
  document.body.innerHTML = '<div id="tool-container"></div>';
  const container = document.getElementById('tool-container');
  tool.open(container);
  return container;
}

test('copies the generated UUID', async () => {
  const c = openTool();
  c.querySelector('#generateSingle').click();
  c.querySelector('#copySingle').click();
  await Promise.resolve();
  expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(c.querySelector('#singleUuid').value);
});
```

Notes:

- `copyToClipboard(text, message?)` returns a `Promise<boolean>`; mock it with `mockResolvedValue(true)` and `await` a microtask before asserting on follow-up UI.
- `downloadText(content, filename, mimeType = 'text/plain')`: assert on content and filename, the MIME type is often omitted by callers.
- Deterministic randomness: define `global.crypto.getRandomValues` in `beforeAll` (see the UUID suite); `crypto.subtle` for the hash and SRI tools is mocked per suite.
- Tools that `import()` (password generator) are tested through the `require()` fallback the tool provides.
- Timers: `jest.useFakeTimers()` plus `jest.advanceTimersByTime()` for debounced live modes.
- Per converter or feature: at least one happy path and one error case (invalid input shows the translated error key, output stays empty).

### Non-tool suites

`a11yUtils.test.js`, `downloadUtils.test.js`, `i18n.test.js`, `installPrompt.test.js`, `webmanifest.test.js` (the PWA manifests), `checkDeploy.test.js` (runs `build-tools/check-deploy.sh` against temporary git repositories).

---

## Browser Tests (`tests/browser/`)

Run against the **production build**: `playwright.config.js` starts `tests/browser/serve.sh`, a private unprivileged Apache with mod_php and a self-signed certificate serving `dist/` on port 8443 with the real `.htaccess.production`. Chrome is started with `--host-resolver-rules` so that `https://webdev-tools.info` resolves to that server; `BASE_PATH` therefore stays empty, as in production. Requires `apache2`, `libapache2-mod-php` and a local Chrome (`channel: 'chrome'`).

**Never use Playwright's `request` fixture here**: it runs outside Chrome, ignores the host mapping and would hit the live site.

`fixtures.js` fails every test on a page error, a console error (CSP violations surface there), or a response from `webdev-tools.info` that did not come from the local server (header `X-Browser-Test: local`).

| Spec | Covers |
|------|--------|
| `pages.spec.js` | Every sitemap URL returns 200 and shows no untranslated `tools.x.y` keys; the sitemaps list all tools in all six languages (the count is hard-coded: update it when adding a tool); redirects and security headers |
| `tools.spec.js` | One normal case per tool through the real page. Text tools are table-driven (`TEXT_TOOLS`: slug, input/run/output selectors, value, expected, optional download button); hash, SRI, JWT, UUID, QR and others have their own tests. Expected values come from outside the tool (known SHA-256 of `hello`, a public JWT, …) |
| `accessibility.spec.js` | axe-core (`@axe-core/playwright`) with WCAG 2.0/2.1 A+AA and 2.2 AA tags over every English sitemap page, in light and dark mode. Anything axe reports is fixed in the code, not excluded |

Failure artefacts: `test-results/playwright` (traces on failure) and `test-results/apache/error.log`; CI uploads both.

---

## Lint

`eslint.config.js` (flat config): `@eslint/js` recommended plus `no-var`, `prefer-const`, `no-unused-vars` (warn, `_` prefix ignored), `no-empty` with empty `catch` allowed. Shipped scripts under `assets/js/` are linted as classic scripts with browser globals (`bootstrap`, `qrcode`, `Terser` declared); `wordlist.js` and `performance-monitoring.js` as modules; tests and build tools as CommonJS with Node and Jest globals. `dist/`, `node_modules/`, Bootstrap and coverage output are ignored.

---

## CI (`.github/workflows/ci.yml`)

Runs on pushes to `main` and on pull requests:

| Job | Steps |
|-----|-------|
| `test` (Node 22 and 24) | `npm ci`, `npm run lint`, `npm run test:coverage` |
| `i18n` | `node build-tools/check-i18n.js` |
| `php` | `php -l` over every PHP file; `php config/generate-sitemaps.php` followed by `git diff --exit-code` on the sitemaps |
| `build` | `bash build.sh`, then checks that key files exist in `dist/` |
| `browser` | Installs `apache2 libapache2-mod-php php-mbstring`, `bash build.sh`, `npm run test:browser`; uploads `test-results/` on failure |

Additional workflows: `codeql.yml` (JavaScript analysis on push, PR and weekly), `links.yml` (lychee external link check, weekly), and Dependabot (`.github/dependabot.yml`, weekly, npm dev dependencies grouped, GitHub Actions).

---

## Production Check

`npm run verify:prod` (`build-tools/verify-prod.js`, also run by the deploy script) opens every URL of the deployed sitemaps in Chrome, flags non-200 responses, PHP error text, console errors and tools that do not render, and compares the live `assets/js/tools/*.js` and `config/i18n/*.json` byte for byte with `dist/`. It only reads.

---

**See also:** [NEUES-TOOL.md](NEUES-TOOL.md) (tests for a new tool), [OVERVIEW.md](OVERVIEW.md) (commands)
