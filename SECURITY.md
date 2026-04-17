# Security Policy — WebDev-Tools

## Architecture

WebDev-Tools is a **client-side-only** platform. All sensitive operations (password generation, hashing, encoding, JWT decoding) execute entirely in the user's browser using the Web Crypto API. **No data is transmitted to any server.**

## Supported Versions

| Version | Supported |
|---------|-----------|
| 2.x     | ✅        |
| < 2.0   | ❌        |

## Reporting a Vulnerability

If you discover a security vulnerability, please report it responsibly:

- **Email**: See [Imprint](https://webdev-tools.info/imprint.php) for contact details
- **GitHub**: Open a [Security Advisory](https://github.com/RamonKaes/WebDev-Tools/security/advisories/new)

Please do **not** open a public issue for security vulnerabilities.

## Security Measures

- **Content Security Policy (CSP)**: Nonce-based script execution, no `unsafe-inline`
- **Subresource Integrity (SRI)**: All external CDN resources verified
- **HSTS**: Strict Transport Security enforced
- **X-Content-Type-Options**: `nosniff`
- **X-Frame-Options**: `DENY`
- **Referrer-Policy**: `strict-origin-when-cross-origin`

For detailed technical documentation, see [docs/techstack/SECURITY.md](docs/techstack/SECURITY.md).
