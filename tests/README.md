# Tests — Minimal, host-friendly checks

This folder contains a minimal test suite that runs without Node.js or browser automation. It's intentionally "host-friendly" and designed to be run locally (in a browser or via PHP CLI) to provide a small set of essential checks.

- `index.php`: Browser-side checks (Vanilla JS).
- `run.php`: CLI runner for basic server-side checks via PHP CLI (optional).
- `test-registry.json`: Enables/disables tests by ID.
- `checks.json`: Canonical list of endpoints that will be tested by both the browser UI and the CLI.
- `reports/`: Generated JSON reports saved locally; reports are NOT tracked in Git (ignored by `.gitignore`).

Usage
-----
Open `index.php` in a browser and click **Run checks** to execute a **comprehensive test suite** including:

**Browser APIs & Core Functionality:**
- Fetch API availability
- Web Crypto API (CSPRNG)
- Base64 encoding/decoding
- JWT decoding
- JSON parsing/validation
- URL encoding/decoding
- HTML entity encoding/decoding

**Cryptography & Security:**
- SHA-256/SHA-512 integrity tests
- HMAC-SHA256 signatures
- JWT HS256 signature validation
- Content Security Policy (CSP) validation
- eval() blocking tests

**Accessibility (WCAG 2.1 AA):**
- Page language attributes
- Image alt text validation
- Form input labels
- Semantic button usage

**Performance Budgets:**
- TTFB (Time to First Byte) < 600ms
- DOM Content Loaded < 1800ms
- Load Complete < 3800ms
- PerformanceObserver API availability

**Endpoint Checks:**
- All 118+ tool endpoints (from `checks.json`)

Results are shown in real-time with ✅/❌ indicators. Download a JSON report for detailed analysis.

**Security Tests:** Open `security.php` in a browser to run cryptographic security tests:
- UUID v4/v1 CSPRNG validation (no Math.random fallback)
- Password generator CSPRNG validation
- SHA-256 integrity test with known test vectors

To run server-side checks (requires PHP CLI):
```bash
php tests/run.php http://localhost/WebDev-Tools
```
Or use an environment variable:
```bash
BASE_URL=https://example.com php tests/run.php
```

Design & URL resolution
------
The tests are intentionally minimal and do feature detection only (no remote dependencies). If you want to expand the test suite, use `test-registry.json` to keep the UI fast and minimally invasive.

URL resolution rules (important):
- `checks.json` is loaded from the `tests/` directory (e.g. `/WebDev-Tools/tests/checks.json`).
- Each path in `checks.json` is resolved as follows:
	- If path starts with a leading `/`, it's treated as an absolute host path: `new URL(path, origin)`.
	- Otherwise it's resolved relative to the **site root** (the folder that contains `tests/`) so localized tools like `de/...` or `fr/...` are correctly requested as `https://<host>/<siteRoot>/de/...`.
# Simple checks for WebDev-Tools

This folder provides a minimal, hosting-friendly "checks" interface using only PHP and Vanilla JS.

- `index.php` — Browser-based checks (client-side, purely JavaScript). Open in a browser and click "Run checks" to execute basic checks and download a JSON report.
- `run.php` — CLI script for server-side checks (requires PHP CLI). Run `php tests/run.php` to execute server-side checks (file presence, PHP version, manifest parse).
	- You can optionally pass a BASE_URL to `run.php` to validate runtime HTTP response headers (CSP/HSTS):
		```bash
		# Check runtime headers at https://example.com
		php tests/run.php https://example.com
		# Or via environment variable
		BASE_URL=https://example.com php tests/run.php
		```
	- Note: HSTS will only be checked when the runtime scheme is `https`. On localhost (http) HSTS checks are not expected.
	- Security checks: The CLI and browser checks include security validations (CSPRNG availability, SHA-256 digest validation, UUIDv4 format, and presence of CSP/HSTS directives in `config/security-headers.php`).

Purpose: Provide a lightweight verification surface that works on hosted servers with no Node.js or advanced tooling.

Notes
-----
- This is intentionally minimal to avoid heavy test harnesses on hosted environments. If you need a more feature-rich setup, consider a separate dev repository.
- Reports: `php tests/run.php` writes a JSON report to `tests/reports/run-summary.json` locally after each run.
	- The `tests/reports/` directory is ignored and `run-summary.json` is not tracked by git. A `.gitkeep` keeps the folder present in the repo.
	- For CI pipelining, collect `run-summary.json` as an artifact instead of adding it to the repository.

Policy & Guidelines
- Keep the `tests/` minimal and focused on security-relevant and essential correctness checks.
- The test registry (`tests/test-registry.json`) defines the allowed checks and whether they're enabled. Do not add tests ad-hoc — open a PR and document the reason.
- Default rule: only checks included in `test-registry.json` and flagged with `enabled:true` will run. An empty `enabled` set runs all checks (fallback); maintainers should keep only a small approved set enabled for hosting.

How to add a new test
1. Add a new entry to `tests/test-registry.json` with `id`, `description`, `scope` (`host`/`browser`) and `enabled:false` by default.
2. Implement the corresponding check in `tests/run.php` or `tests/index.php` as a guarded function (i.e., execute only if the registry enables the test).
3. Provide justification in the PR — why the test is essential, no Node dependency, and why it should be enabled by default.

