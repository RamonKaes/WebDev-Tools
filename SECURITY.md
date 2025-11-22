# Security Policy

## Architecture Guarantees

**WebDev-Tools.info operates on a strict client-side-only architecture:**

- ✅ All data processing occurs in your browser
- ✅ No data transmission to backend servers
- ✅ No server-side logging of user input
- ✅ Cryptographic operations use Web Crypto API (CSPRNG)

## Verification

You can verify our claims:

1. **Network Monitoring**: Use browser DevTools (Network tab) while using tools - no POST/PUT requests to our servers
2. **Source Code Inspection**: All JavaScript is unminified and readable
3. **Content Security Policy**: Check response headers - we enforce strict CSP

## Standards Compliance

| Tool Category | Standard | Conformance |
|--------------|----------|-------------|
| UUID Generator | RFC 4122/9562 | ✅ Full |
| Base64 Encoder | RFC 4648 | ✅ Full |
| JSON Formatter | RFC 8259 | ✅ Full |
| JWT Decoder | RFC 7519 | ✅ Full |
| Password Gen | NIST SP 800-63B | ✅ CSPRNG |
| QR Code | ISO/IEC 18004 | ✅ Full |

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
