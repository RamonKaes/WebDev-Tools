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

Notes:
- This is intentionally minimal to avoid heavy test harnesses on hosted environments. If you need a more feature-rich setup, consider a separate dev repository.
- Reports: `php tests/run.php` writes a JSON report to `tests/reports/run-summary.json` after each run.
	- Note: On `localhost` the site often runs over `http`, while the hosted environment runs `https`. Runtime HSTS header checks are only validated for HTTPS schemes.

Policy & Guidelines
- Keep the `tests/` minimal and focused on security-relevant and essential correctness checks.
- The test registry (`tests/test-registry.json`) defines the allowed checks and whether they're enabled. Do not add tests ad-hoc — open a PR and document the reason.
- Default rule: only checks included in `test-registry.json` and flagged with `enabled:true` will run. An empty `enabled` set runs all checks (fallback); maintainers should keep only a small approved set enabled for hosting.

How to add a new test
1. Add a new entry to `tests/test-registry.json` with `id`, `description`, `scope` (`host`/`browser`) and `enabled:false` by default.
2. Implement the corresponding check in `tests/run.php` or `tests/index.php` as a guarded function (i.e., execute only if the registry enables the test).
3. Provide justification in the PR — why the test is essential, no Node dependency, and why it should be enabled by default.

