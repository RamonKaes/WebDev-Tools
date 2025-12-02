# Contributing & Local development notes

Thank you for contributing! A quick note about environments:

- Production hosting (https://webdev-tools.info/) is served by PHP + Apache and **does not provide Node.js or npm**. The site is intentionally implemented so the runtime does not depend on Node.
- Developer tools (npm scripts, local http-server, etc.) are provided as convenience utilities for contributors — they are optional and should not be required for production deployments.

Suggested workflow
------------------
1. Run the built-in PHP tests locally:

   ```bash
   php tests/run.php           # 136 automated checks
   php tests/crawler.php        # Browser-like navigation crawler
   ```

2. Start a local dev server (optional, Node not required):

   ```bash
   ./dev/start-server.sh
   # or (if you have Node locally)
   npm run dev
   ```

3. Make changes, add tests, and open a PR. CI runs server checks and lightweight static analysis without Composer or Node.

Running local checks (no Composer needed)
--------------------------------------

You can run lightweight project checks locally without Composer or Node. The `bin/check` script performs:

- syntactic validation (`php -l`) across PHP files
- PHP_CodeSniffer (PHPCS) style checks by downloading the PHAR automatically

Run it from the project root:

```bash
./bin/check
```

If you prefer to run PHPCS manually, the CI downloads `phpcs.phar` from the official SquizLabs distribution and executes it.

If you need help reproducing the production environment locally, ask in an issue and we can add a devcontainer / Dockerfile for reproducible environments.
# Contributing to WebDev-Tools

Thank you for your interest in contributing! This file gives a quick start for local development and tests so you can build and verify changes before opening a PR.

## Quick local setup

- PHP >= 7.4 (8.x recommended)
- Node.js (optional) if you want to use the `package.json` convenience scripts

### Start a development server

The simplest way is the bundled script (uses PHP built-in server):

```bash
# from the project root
./dev/start-server.sh
# open http://127.0.0.1:8080
```

Alternatively you can use npm:

```bash
npm run dev
```

### Run tests

Server-side checks are intentionally minimal and CLI-friendly. Run them with:

```bash
php tests/run.php           # 136 automated checks (HTTP + navigation + i18n)
php tests/crawler.php        # Browser-like link crawler (cross-language validation)
# or via npm
npm run test
```

### Pull Requests

- Keep changes focused and small.
- Add tests for new features when possible (see `tests/`).
- Describe your change in the PR, reference related issues, and include screenshots/steps if UI changes.

## CI

We run a small GitHub Actions workflow that executes the CLI checks defined in `tests/run.php`. Keep these checks green before merging.
