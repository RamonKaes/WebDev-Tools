# i18n Translation Guidelines

## Key Requirements

All tool translations must follow these character length requirements for optimal SEO and UX:

### Required Keys

| Key | Length Requirement | Purpose | Example |
|-----|-------------------|---------|---------|
| `h1_title` | **45-65 characters** | Main page heading, SEO | "Base64 Encoder/Decoder — Fast & Secure Online Tool" |
| `card_description` | **140-160 characters** | Tool card on homepage | "Encode and decode Base64 strings instantly in your browser. Supports Unicode, files, and URL-safe encoding. No server upload required." |
| `tool_description` | Descriptive (no limit) | Detailed tool explanation | Full explanation of what the tool does, how it works, and its features |
| `toc_title` | **≤ 25 characters** | Table of contents menu | "Base64 Encoder" |
| `meta_title` | **50-65 characters** (~575px) | Browser tab, SEO | "Base64 Encoder/Decoder — Free Online Tool" |
| `meta_description` | **145-160 characters** (~990px) | Search engine snippet | "Encode and decode Base64 strings securely in your browser. Supports Unicode, files, and URL-safe variants. Fast, free, and privacy-focused." |

## Writing Guidelines

### h1_title (45-65 chars)
- Include tool name + technical descriptor or primary function
- Use em dash (—) to separate elements
- Use professional, technical language without marketing terms
- Avoid words like: "Free", "Online", "Fast", "Secure", "Instant"
- Examples:
  - ✅ "UUID Generator — Unique Identifiers v1, v4 and v7"
  - ✅ "Password Generator — Cryptographic Security NIST SP 800-63B"
  - ✅ "Base64 Encoder & Decoder — Binary-to-Text Encoding"
  - ❌ "UUID Generator" (too short)
  - ❌ "Free UUID Generator Online Tool" (marketing terms)
  - ❌ "UUID Generator Version 4 Random String Creator for Development and Testing" (too long)

### card_description (140-160 chars)
- Brief technical feature list (2-3 key features)
- Focus on functionality and technical specifications
- Avoid marketing language ("free", "instant", "fast", "online")
- Include primary use case or technical standards
- Examples:
  - ✅ "Generate cryptographically secure passwords with customizable length and character sets. NIST SP 800-63B compliant. Includes strength meter." (150 chars)
  - ✅ "Encode and decode Base64 strings with Unicode support. Handles files and URL-safe encoding. Client-side processing for privacy." (131 chars)
  - ❌ "Generate passwords" (too short)
  - ❌ "Free password generator online tool instantly" (marketing terms)

### toc_title (≤ 25 chars)
- Short, scannable
- Use abbreviations if needed (PX → REM, not Pixel to REM)
- Examples:
  - ✅ "UUID Generator"
  - ✅ "PX to REM Converter"
  - ❌ "UUID Version 4 Generator" (27 chars, too long)

### meta_title (50-65 chars)
- Similar to h1_title but more concise
- Professional, technical focus
- Avoid marketing terms for consistency
- Examples:
  - ✅ "Base64 Encoder/Decoder — Binary Text Encoding" (50 chars)
  - ✅ "UUID Generator v4 — Unique Identifier Creation" (50 chars)
  - ❌ "Free UUID Generator Online" (marketing terms)

### meta_description (145-160 chars)
- Expand on card_description with technical details
- Include benefits/features using professional language
- Focus on functionality, not marketing appeals
- Examples:
  - ✅ "Generate UUIDs (v4) using cryptographically secure random numbers. Client-side processing ensures privacy. Suitable for development, testing, and production environments." (158 chars)
  - ❌ "Generate UUIDs instantly online for free! Try it now!" (marketing terms, too short)

## Validation

Run the validation script to check all translations:

```bash
php /tmp/validate_i18n_keys.php
```

## Translation Tips

### Professional Writing Style

**Avoid Marketing Language:**
- ❌ Free, Instant, Fast, Quick, Online, Secure (when used as selling points)
- ✅ Technical terms: Cryptographic, Client-side, Standards-compliant, RFC-compliant
- ✅ Functional descriptions: "Binary-to-text encoding", "Pattern matching engine"
- ✅ Technical specifications: "NIST SP 800-63B compliant", "UTF-8 support"

**Preferred Language Patterns:**
- Use technical terminology appropriate for developers
- Focus on functionality and specifications
- Describe capabilities, not benefits
- Use industry-standard terms and acronyms

### Length Adjustments by Language

Different languages require different character counts for the same meaning:

- **English**: Baseline (most concise)
- **German**: ~10-15% longer (compound words)
- **French**: ~15-20% longer (articles, prepositions)
- **Spanish/Portuguese**: ~10-15% longer
- **Italian**: ~5-10% longer

Adjust content to fit within limits while preserving meaning:
- Use active voice
- Prefer strong verbs over adjectives
- Abbreviate where culturally appropriate
- Use em dash (—) instead of longer conjunctions
- Remove redundant marketing modifiers

### Common Patterns

**h1_title Pattern:**
```
[Tool Name] — [Technical Function/Standard]
[Tool Name] — [Primary Technology] [Technical Descriptor]
```

Examples:
- "Base64 Encoder & Decoder — Binary-to-Text Encoding"
- "JSON Formatter & Validator — Syntax Validation and Formatting"
- "Password Generator — Cryptographic Security NIST SP 800-63B"

**card_description Pattern:**
```
[Technical action]. [Key features/specifications, 2-3]. [Technical benefit or standard].
```

Examples:
- "Encode and decode Base64 strings with Unicode support. Handles files and URL-safe encoding. Client-side processing for privacy."
- "Format, validate, and minify JSON data. Syntax highlighting and error detection. Supports tree view and JSONPath extraction."

**meta_description Pattern:**
```
[Technical action] [specifications]. [Features/capabilities]. [Use cases or standards compliance].
```

Examples:
- "Encode and decode Base64 strings with Unicode and file support. URL-safe variants available. Client-side processing ensures data privacy."
- "Format and validate JSON with syntax highlighting. Supports beautification, minification, and JSONPath queries. RFC 8259 compliant."

## Examples by Tool Type

### Generators
```json
{
  "h1_title": "UUID Generator — Unique Identifiers v1, v4 and v7",
  "card_description": "Generate cryptographically secure UUIDs (versions 1, 4, 7). RFC 4122 compliant with client-side processing. Supports bulk generation and validation.",
  "toc_title": "UUID Generator",
  "meta_title": "UUID Generator — Unique Identifiers v1, v4, v7",
  "meta_description": "Generate UUIDs (v1, v4, v7) using cryptographically secure random numbers. RFC 4122 compliant. Client-side processing with bulk generation support."
}
```

### Encoders/Decoders
```json
{
  "h1_title": "Base64 Encoder & Decoder — Binary-to-Text Encoding",
  "card_description": "Encode and decode Base64 strings with Unicode support. Handles files and URL-safe encoding. Client-side processing for privacy.",
  "toc_title": "Base64 Encoder",
  "meta_title": "Base64 Encoder & Decoder — Binary Text Encoding",
  "meta_description": "Encode and decode Base64 strings with Unicode and file support. URL-safe variants available. Client-side processing ensures data privacy."
}
```

### Formatters/Validators
```json
{
  "h1_title": "JSON Formatter & Validator — Syntax Validation and Formatting",
  "card_description": "Format, validate, and minify JSON data. Syntax highlighting and error detection. Supports tree view and JSONPath extraction.",
  "toc_title": "JSON Formatter",
  "meta_title": "JSON Formatter & Validator — Syntax Validation",
  "meta_description": "Format and validate JSON with syntax highlighting. Supports beautification, minification, and JSONPath queries. RFC 8259 compliant."
}
```

## Validation Script

The validation script checks all 6 languages (EN, DE, ES, FR, IT, PT) and reports:
- ✅ Valid: Meets all criteria
- ⚠️  Warning: Within 10 chars of limit
- ❌ Error: Outside acceptable range

Focus on fixing errors first, then warnings.
