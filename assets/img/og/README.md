# OG Images

This directory contains Open Graph (OG) images for social media sharing previews.

## Format Specification

- **Dimensions**: 1200×630 pixels (Facebook/Twitter recommended)
- **Format**: SVG (Scalable Vector Graphics)
- **Template**: Based on `og-muster.png`

## Color Scheme (Tango)

All OG images follow the Tango Color Scheme, with colors assigned by tool category:

| Category      | Color Code | Color Name    | Tool Count |
|---------------|-----------|---------------|------------|
| Encoders      | `#cc0000` | Red           | 5          |
| Formatters    | `#c17d11` | Orange        | 2          |
| Converters    | `#75507b` | Purple        | 2          |
| Generators    | `#3465a4` | Blue          | 5          |
| References    | `#ce5c00` | Dark Orange   | 2          |
| String Tools  | `#4e9a06` | Green         | 1          |
| Utilities     | `#c4a000` | Yellow        | 2          |

## Structure

Each OG image SVG contains:

1. **Background** - Solid color fill based on category
2. **Gradient Overlay** - Linear gradient from category color to black (20% opacity)
3. **Icon** - Centered Bootstrap Icon (300×300px, white, 30% opacity)
4. **Title** - Tool name (68px, bold, white, centered)
5. **Description** - SEO description (42px, regular, white, 90% opacity)
6. **Branding** - "Mini-Tools Collection" (24px, 70% opacity)

## Generation

OG images are automatically generated from tool configuration:

```bash
# Generate all OG images
php config/generate-og-images.php

# Validate OG images
php config/validate-og-images.php

# Update manifest with OG image mappings
php config/generate-manifest.php
```

## File Naming Convention

OG images use the tool's slug as filename:

- `base64-encoder-decoder.svg`
- `json-formatter-validator.svg`
- `px-to-rem-converter.svg`
- etc.

Special files:
- `home.svg` - Homepage/default OG image
- `og-muster.png` - Design template reference

## Integration

OG images are automatically loaded via:

1. **Manifest System**: `config/manifest.json` maps tool IDs to OG image filenames
2. **PHP Template**: `partials/head.php` reads manifest and generates OG meta tags
3. **SEO Data**: `config/i18n/{lang}.json` provides tool descriptions

## Maintenance

- **Adding a new tool**: Run `generate-og-images.php` to create the OG image
- **Updating colors**: Edit `$categoryColors` in `generate-og-images.php`
- **Changing icons**: Update `$iconPaths` mapping in `generate-og-images.php`
- **Validation**: Run `validate-og-images.php` to ensure all tools have images

---

**Generated**: 2025-11-07  
**Last Update**: 2025-11-07  
**Total Images**: 19 tools + 1 home
