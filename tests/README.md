# Simple checks for WebDev-Tools

This folder provides a minimal, hosting-friendly "checks" interface using only PHP and Vanilla JS.

- `index.php` — Browser-based checks (client-side, purely JavaScript). Open in a browser and click "Run checks" to execute basic checks and download a JSON report.
- `run.php` — CLI script for server-side checks (requires PHP CLI). Run `php tests/run.php` to execute server-side checks (file presence, PHP version, manifest parse).
	- Security checks: The CLI and browser checks include security validations (CSPRNG availability, SHA-256 digest validation, UUIDv4 format, and presence of CSP/HSTS directives in `config/security-headers.php`).

Purpose: Provide a lightweight verification surface that works on hosted servers with no Node.js or advanced tooling.

Notes:
- This is intentionally minimal to avoid heavy test harnesses on hosted environments. If you need a more feature-rich setup, consider a separate dev repository.
- Reports: `php tests/run.php` writes a JSON report to `tests/reports/run-summary.json` after each run.

