# Security Tests — Coverage & Recommendations

This document outlines which tools require security testing and what tests are currently implemented or missing.

## Security-Critical Tools

These tools handle cryptographic operations, passwords, or sensitive data and **must** use `crypto.getRandomValues()` (CSPRNG):

| Tool | Security Requirement | Current Status | Test Coverage |
|------|---------------------|----------------|---------------|
| **Password Generator** | CSPRNG for all passwords | ✅ Uses `crypto.getRandomValues()` | ✅ CSPRNG validation test (1000 passwords) |
| **UUID Generator (v1/v4)** | CSPRNG for random bytes | ✅ Fixed — Math.random fallback removed | ✅ CSPRNG validation test (1000 UUIDs) |
| **Hash Generator** | Correct SHA-256/512 implementation | ✅ Uses Web Crypto API | ✅ SHA-256, SHA-512, HMAC-SHA256 test vectors |
| **JWT Decoder** | Secure parsing, signature validation | ✅ Uses JSON.parse + atob | ✅ HS256 signature validation, RS256 structure check |

## Non-Critical Tools (Math.random acceptable)

These tools do NOT handle sensitive data and may use `Math.random()`:

- Lorem Ipsum Generator (placeholder text)
- QR Code Generator (encoding only, no secrets)
- Emoji/Character Reference (static data)

## Current Test Coverage

### Implemented Tests (`tests/index.php`, `tests/run.php`)

✅ **Browser API availability:**
- `fetch` API
- `crypto.getRandomValues` (checks availability, but not actual usage)
- `btoa/atob`

✅ **JWT decode:**
- Basic payload parsing (no signature validation)

✅ **Endpoint checks:**
- HTTP availability for all tool pages

### Missing Tests (Recommendations)

❌ **UUID v4 CSPRNG validation:**
- Generate 1000 UUIDs and verify no repeated patterns (entropy check)
- Verify version/variant bits are correct
- **Critical:** Ensure Math.random fallback is NEVER used
- **Status:** ✅ IMPLEMENTED in `tests/security.php`

❌ **Password CSPRNG validation:**
- Generate passwords and verify character distribution (chi-square test)
- Verify no predictable patterns
- **Status:** ✅ IMPLEMENTED in `tests/security.php`

❌ **Hash integrity:**
- Test SHA-256 with known input/output pairs
- Test SHA-512 with known input/output pairs
- Verify HMAC implementation (if added)
- **Status:** ✅ IMPLEMENTED in `tests/security.php` (SHA-256, SHA-512, HMAC-SHA256)

❌ **JWT signature validation:**
- Test signature verification (currently only decodes payload)
- Test HS256 signature validation
- Test RS256 algorithm detection
- **Status:** ✅ IMPLEMENTED in `tests/security.php` (HS256 full validation, RS256 structure check)

## Critical Issue — UUID Generator Fallback

**File:** `assets/js/tools/uuidGeneratorTool.js`, line 163

**Problem:** ✅ **FIXED** — The UUID v4 generator previously had a Math.random() fallback that was cryptographically insecure.

**Solution:** The fallback has been removed and replaced with a clear error:

```javascript
} catch (e) {
  throw new Error('UUID generation requires Web Crypto API (crypto.getRandomValues)');
}
```

Users now see a clear error message in the UI if CSPRNG is unavailable, with translations in all 6 languages (`crypto_error` i18n key).

**Status:** ✅ **RESOLVED** — No unsafe fallbacks remain in UUID generator (v1, v4, v7).

## Implementation Priority

1. ~~**High Priority:** Fix UUID Math.random fallback (security issue)~~ ✅ **COMPLETED**
2. ~~**Medium Priority:** Add CSPRNG validation tests for UUID/Password generators~~ ✅ **COMPLETED**
3. ~~**Low Priority:** Add hash integrity tests, JWT signature validation tests~~ ✅ **COMPLETED**

**All security improvements have been implemented as of December 1, 2025.**

## Test Execution

Run existing tests:
```bash
# Browser-based checks (basic availability tests)
open tests/index.php

# Browser-based security tests (CSPRNG, hash integrity, JWT signatures)
open tests/security.php

# CLI checks
php tests/run.php
```

## Latest Test Coverage (December 2025)

The security test suite (`tests/security.php`) now includes:

✅ **CSPRNG Validation:**
- UUID v4: 1000 UUIDs generated, collision detection
- UUID v1: Clock sequence and node ID randomness
- Password Generator: 100 passwords, uniqueness verification

✅ **Hash Integrity:**
- SHA-256: Test vector `"abc"` → known digest
- SHA-512: Test vector `"abc"` → known digest
- HMAC-SHA256: Test vector with key `"key"` and message

✅ **JWT Security:**
- HS256: Full signature validation with known secret
- RS256: Algorithm detection and structure validation

All tests run entirely in the browser using Web Crypto API with no external dependencies.

## Notes

- All security-critical tools correctly use `crypto.getRandomValues()` in their primary code path.
- The UUID generator has an unsafe fallback that should be removed.
- Tests currently validate API **availability** but not actual **usage** in generated outputs.
