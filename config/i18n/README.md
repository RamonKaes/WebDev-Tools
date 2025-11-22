# i18n Structure Documentation

## Field Definitions

### Tools Section (`tools.[toolId]`)

| Field | Usage | Location | Length | Example |
|-------|-------|----------|--------|---------|
| `title` | TOC Sidebar navigation ("On this Page" menu) | Right sidebar | Short | "Base64 Encoder" |
| `page_title` | **H1 heading** on tool pages | Main content area | 20-70 chars | "Base64 Encoder & Decoder" |
| `description` | Tool card text on homepage | Homepage cards | 1-2 sentences | "Free Base64 encoder and decoder..." |
| `description_long` | Description below H1 heading | Below H1 in tool | 2-3 sentences | "Base64 is a binary-to-text encoding..." |

### SEO Section (`seo.[toolId]`)

| Field | Usage | Location | Length | Example |
|-------|-------|----------|--------|---------|
| `pageTitle` | **Meta `<title>` tag** | HTML head | 50-60 chars | "Base64 Encoder & Decoder – Online Text & File Converter" |
| `pageDescription` | Meta description tag | HTML head | 150-160 chars | "Free Base64 encoder and decoder for text and files. Encode or decode..." |
| `keywords` | Meta keywords | HTML head | CSV | "base64, encoder, decoder, binary to text" |
| `ogImage` | Open Graph image | Social sharing | Filename | "base64-encoder-decoder.svg" |

## Important Rules

1. **H1 vs Meta Title:**
   - `page_title` (H1) = SHORT (20-70 chars)
   - `pageTitle` (Meta) = DETAILED (50-60 chars)
   - Must be DIFFERENT to avoid SEO duplicate issues

2. **Description Hierarchy:**
   - `description` = Brief (homepage cards)
   - `description_long` = Extended (tool page intro)
   - `pageDescription` = SEO-optimized (meta tag)

3. **Title Hierarchy:**
   - `title` = Shortest (TOC only)
   - `page_title` = Medium (H1)
   - `pageTitle` = Longest (Meta Title)

## Code References

- **H1 Usage:** `partials/tool-base.php` line 60
  ```php
  $toolH1Title = $toolData['page_title'] ?? $toolData['title'] ?? '';
  ```

- **Meta Title:** `partials/head.php` line 14
  ```php
  $pageTitle = $seoData['pageTitle'] ?? 'WebDev-Tools';
  ```

- **TOC Title:** `partials/tool-base.php` line 69
  ```php
  data-toc-title="<?= htmlspecialchars($toolNavTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
  ```

## Examples

### Base64 Tool
```json
"tools": {
  "base64EncoderDecoder": {
    "title": "Base64 Encoder",                    // TOC sidebar
    "page_title": "Base64 Encoder & Decoder",     // H1 heading
    "description": "Free Base64 encoder...",       // Homepage card
    "description_long": "Base64 is a binary..."    // Below H1
  }
},
"seo": {
  "base64EncoderDecoder": {
    "pageTitle": "Base64 Encoder & Decoder – Online Text & File Converter",  // <title>
    "pageDescription": "Free Base64 encoder and decoder for text and files..."  // <meta>
  }
}
```
