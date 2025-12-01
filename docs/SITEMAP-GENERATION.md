# Sitemap Generation Documentation

## Overview

The sitemaps for WebDev-Tools are **automatically generated** using the script `config/generate-sitemaps.php`. This ensures consistency between the tool configuration and the sitemap URLs.

## How It Works

### 1. Source of Truth

The sitemap generator uses `config/tools.php` as the single source of truth:
- All tool configurations are read from `tools.php`
- Localized slugs are automatically used for each language
- Static pages (about, privacy, imprint) are added separately

### 2. Generated Files

Running the script creates/updates the following files:
- `sitemap.xml` - Sitemap index (links to all language-specific sitemaps)
- `sitemap-en.xml` - English sitemap
- `de/sitemap.xml` - German sitemap
- `es/sitemap.xml` - Spanish sitemap
- `pt/sitemap.xml` - Portuguese sitemap
- `fr/sitemap.xml` - French sitemap
- `it/sitemap.xml` - Italian sitemap

### 3. Generation Process

```bash
# Run from project root
php config/generate-sitemaps.php
```

The script:
1. Loads tool configuration from `config/tools.php`
2. Reads supported languages from `config/config.php` (SUPPORTED_LANGS)
3. For each language:
   - Generates URLs for static pages (/, /about.php, /privacy.php, /imprint.php)
   - Generates URLs for all tools using `getToolUrl($toolId, $lang)`
   - Writes XML file with proper structure and formatting
4. Creates sitemap index (`sitemap.xml`) linking all language sitemaps

### 4. URL Generation Logic

URLs are constructed using the helper function `getToolUrl()` from `config/helpers.php`:

```php
// Example for base64EncoderDecoder in German:
getToolUrl('base64EncoderDecoder', 'de') 
// Returns: https://webdev-tools.info/de/base64-kodierer-dekodierer/
```

The function automatically:
- Uses localized slugs from the `slugs` array in tools.php
- Falls back to the default `slug` if no localized version exists
- Adds the language prefix (e.g., `/de/`) for non-English languages
- Appends trailing slash for consistency

## When to Regenerate

Sitemaps should be regenerated when:

- ✅ A new tool is added to `config/tools.php`
- ✅ A tool slug is changed
- ✅ Localized slugs are added/modified
- ✅ Static pages are added or removed
- ✅ URLs need to be updated

## Automation

### Manual Execution

```bash
cd /var/www/html/WebDev-Tools
php config/generate-sitemaps.php
```

### Automated (Recommended)

Add to your deployment process:

```bash
# In your deploy script
php config/generate-sitemaps.php
git add sitemap*.xml */sitemap.xml
git commit -m "chore: regenerate sitemaps"
```

Or use a Git pre-commit hook:

```bash
# .git/hooks/pre-commit
#!/bin/bash
php config/generate-sitemaps.php
git add sitemap*.xml */sitemap.xml
```

## Validation

After generation, validate the sitemaps:

### 1. XML Validity

```bash
xmllint --noout sitemap.xml sitemap-en.xml de/sitemap.xml
```

### 2. Tool Count

```bash
# Count tools in config
php -r "echo count(require 'config/tools.php');"

# Count URLs in sitemap (subtract static pages)
grep -c "<loc>" sitemap-en.xml
```

### 3. URL Accessibility

Use the verification script:

```bash
./bin/verify-tools.sh
```

This checks that all URLs in sitemaps point to existing directories with `index.php` files.

## Configuration

### Static Pages

Edit the `$staticPages` array in `generate-sitemaps.php`:

```php
$staticPages = [
  '/' => 'weekly',
  '/about.php' => 'monthly',
  '/imprint.php' => 'monthly',
  '/privacy.php' => 'monthly'
];
```

### Change Frequency

Default for tools is `weekly`. Modify `$defaultChangefreqTools` to change globally.

### Last Modified Date

Automatically set to current date (`date('Y-m-d')`). Can be customized if needed.

## Troubleshooting

### Issue: Missing tools in sitemap

**Solution:** Ensure the tool is registered in `config/tools.php` and has a valid `slug` or `slugs` array.

### Issue: Wrong URLs

**Solution:** Check `getToolUrl()` logic in `config/helpers.php` and verify `BASE_URL` in `config/config.php`.

### Issue: XML parse errors

**Solution:** Run `php -l config/generate-sitemaps.php` to check syntax, and validate output with `xmllint`.

## Related Files

- `config/generate-sitemaps.php` - Generation script
- `config/tools.php` - Tool configuration (source of truth)
- `config/helpers.php` - URL generation helpers
- `config/config.php` - Base URL and language configuration
- `bin/verify-tools.sh` - Validation script for sitemap URLs

## Best Practices

1. **Always regenerate** after modifying `config/tools.php`
2. **Commit sitemaps** with your tool changes
3. **Test URLs** with `bin/verify-tools.sh` before deployment
4. **Submit to search engines** after major changes:
   - Google Search Console: `https://search.google.com/search-console`
   - Bing Webmaster Tools: `https://www.bing.com/webmasters`

## Example Workflow

```bash
# 1. Add new tool to config/tools.php
vim config/tools.php

# 2. Regenerate sitemaps
php config/generate-sitemaps.php

# 3. Verify all URLs work
./bin/verify-tools.sh

# 4. Commit changes
git add config/tools.php sitemap*.xml */sitemap.xml
git commit -m "feat: add new tool X"
git push

# 5. Submit sitemap to search engines (optional)
# Visit Google Search Console and submit sitemap.xml
```

## Last Updated

This documentation was created on 2025-12-01 based on the current sitemap generation implementation.
