# Security Policy — WebDev-Tools

## Reporting a Vulnerability

Please report security issues privately, **not** through a public issue:

- **GitHub Security Advisory** (preferred) — [open a private report](https://github.com/RamonKaes/WebDev-Tools/security/advisories/new)
- **Email** — contact details are listed in the [imprint](https://webdev-tools.info/imprint.php)

You will normally get a first response within a few days. Please include the
affected URL or tool, the browser you used, and the steps to reproduce.

## Supported Versions

| Version | Supported |
|---------|-----------|
| 2.x     | ✅        |
| < 2.0   | ❌        |

## Architecture

WebDev-Tools runs **entirely in the browser**. Password generation, hashing,
encoding and JWT decoding use the Web Crypto API locally; the input never
leaves the page. There is no account system, no database and no server-side
processing of user input — the server only delivers static pages and assets.

## Security Measures

These are the headers the production site actually sends. You can verify them
yourself with `curl -I https://webdev-tools.info/`.

| Header | Value |
|---|---|
| `Content-Security-Policy` | `default-src 'self'`, nonce-based `script-src`, no `unsafe-inline`, `object-src 'none'`, `base-uri 'self'`, `form-action 'self'` |
| `Content-Security-Policy` (framing) | `frame-ancestors 'none'` — embedding in a frame is refused |
| `X-Frame-Options` | `DENY` — the same restriction for browsers predating `frame-ancestors` |
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains; preload` |
| `X-Content-Type-Options` | `nosniff` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | geolocation, microphone, camera, payment, usb and motion sensors all disabled |

**Subresource Integrity** — the two scripts loaded from a CDN
(DOMPurify and qrcode-generator) carry SHA-384 `integrity` hashes and
`crossorigin="anonymous"`, so a modified file is rejected by the browser.

**Dependencies** — no third-party code is bundled into the pages beyond
Bootstrap and Bootstrap Icons, which are served from the site's own origin.

## Scope

In scope: XSS, CSP bypasses, integrity or transport issues, and anything that
causes data entered into a tool to leave the browser.

Out of scope: findings that require a compromised browser or extension,
missing headers with no demonstrable impact, and automated scanner output
without a working proof of concept.

## Further Reading

The implementation details behind these measures — CSP construction, the
nonce mechanism, XSS defences in the tool code and the cryptographic choices —
are documented separately in
**[docs/techstack/SECURITY.md](docs/techstack/SECURITY.md)**, a technical
document aimed at contributors rather than at reporters.
