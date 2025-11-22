# Security Policy

## Architecture Guarantees

**WebDev-Tools.info operates on a strict client-side-only architecture:**

- ✅ All data processing occurs in your browser
- ✅ No data transmission to backend servers
- ✅ No server-side logging of user input
- ✅ Cryptographic operations use Web Crypto API (CSPRNG)

## Open Source Transparency

**Full Source Code Access**: The complete codebase is publicly available on GitHub:
- **Repository**: [github.com/RamonKaes/WebDev-Tools](https://github.com/RamonKaes/WebDev-Tools)
- **License**: MIT
- **Review**: Anyone can audit the code, report issues, or contribute improvements

## Verification

You can verify our claims:

1. **Network Monitoring**: Use browser DevTools (Network tab) while using tools - no POST/PUT requests to our servers
2. **Source Code Inspection**: All JavaScript is unminified and readable
3. **Content Security Policy**: Check response headers - we enforce strict CSP
4. **GitHub Repository**: Review the complete source code and commit history

## Standards Compliance

| Tool Category | Standard | Conformance |
|--------------|----------|-------------|
| UUID Generator | RFC 4122/9562 | ✅ Full |
| Base64 Encoder | RFC 4648 | ✅ Full |
| JSON Formatter | RFC 8259 | ✅ Full |
| JWT Decoder | RFC 7519 | ✅ Full |
| Password Gen | NIST SP 800-63B | ✅ CSPRNG |
| QR Code | ISO/IEC 18004 | ✅ Full |

## Security Implementation Details

### Content Security Policy (CSP)

We enforce a strict Content Security Policy to prevent XSS attacks and code injection:

```http
Content-Security-Policy: 
  default-src 'self';
  script-src 'self' 'nonce-{random}' https://cdn.jsdelivr.net https://www.googletagmanager.com;
  style-src 'self' https://cdn.jsdelivr.net;
  font-src 'self' https://cdn.jsdelivr.net;
  img-src 'self' data: blob: https:;
  object-src 'none';
  frame-ancestors 'none';
  base-uri 'self';
  form-action 'self';
```

**Key Protection Mechanisms**:
- ✅ Nonce-based script execution (prevents inline script injection)
- ✅ No `unsafe-inline` or `unsafe-eval`
- ✅ Restricted external resource loading (only from trusted CDNs)
- ✅ Frame embedding completely disabled (clickjacking protection)
- ✅ Object and plugin execution blocked

### Subresource Integrity (SRI)

All external libraries are loaded with cryptographic integrity hashes:

| Library | Version | SRI Hash (SHA-384) |
|---------|---------|-------------------|
| qrcode-generator | 1.4.4 | `sha384-lQXOAyZwHXE55JFyrOMB7nY2Wv+m5ZWNtJcHrd1rceRQXAYNLak8ukN5TjBTcIwz` |

**Verification**: SRI ensures that CDN-delivered code hasn't been tampered with. If the hash doesn't match, the browser refuses to load the script.

Full SRI hashes can be verified in our [config/tools.php](https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php).

### Additional Security Headers

We implement defense-in-depth with multiple HTTP security headers:

```http
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()
```

**Header Explanations**:
- **X-Frame-Options: DENY** - Prevents iframe embedding attacks (clickjacking)
- **X-Content-Type-Options: nosniff** - Prevents MIME-type sniffing vulnerabilities
- **HSTS** - Forces HTTPS connections for 1 year, protects against downgrade attacks
- **Permissions-Policy** - Disables unnecessary browser APIs (geolocation, camera, etc.)
- **Referrer-Policy** - Limits information leakage in HTTP referrer headers

### Zero External Dependencies for Data Processing

**Core Philosophy**: All data processing uses native browser APIs only.

- ✅ No external API calls for encoding/decoding operations
- ✅ No cloud-based processing services
- ✅ External libraries used ONLY for UI components (e.g., QR code rendering)
- ✅ All external libraries loaded with SRI verification

## Reporting Vulnerabilities

If you discover a security issue, please report it to:
- **Email**: ramon.kaes@webdev-tools.info
- **Subject**: [SECURITY] Brief description

We commit to:
- Acknowledge receipt within 48 hours
- Provide status update within 7 days
- Credit reporters (unless anonymity requested)

## Privacy Commitment

**We do NOT collect:**
- ❌ User input data
- ❌ Generated outputs (passwords, hashes, UUIDs)
- ❌ Clipboard contents
- ❌ File contents uploaded to tools

**We DO collect (anonymized analytics):**
- ✅ Page views (no personal data)
- ✅ Tool usage frequency (aggregated)

See our [Privacy Policy](https://webdev-tools.info/privacy.php) for details.

## Responsible AI Development

This platform was developed with AI assistance (Claude Sonnet 4.5, GitHub Copilot):
- All AI-generated code undergoes human review
- Git version control with rollback capability
- Cross-model validation (adversarial review)

---

**Last Updated**: November 2025  
**Security Contact**: ramon.kaes@webdev-tools.info
