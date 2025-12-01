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

