# Documentation

This directory contains detailed technical documentation for WebDev-Tools development and maintenance.

## 📚 Available Documentation

### Development Guides

- **[SITEMAP-GENERATION.md](SITEMAP-GENERATION.md)** - How sitemaps are automatically generated from `config/tools.php`
  - Explains the sitemap generation workflow
  - How to add new tools to sitemaps
  - Verification with `bin/verify-tools.sh`

- **[CODE-SPLITTING.md](CODE-SPLITTING.md)** - Strategy for splitting large tools into smaller modules
  - Recommended approach for `dataConverterTool.js` (1014 LOC)
  - Recommended approach for `hashGeneratorTool.js` (1008 LOC)
  - Lazy loading implementation patterns

- **[LOGGER-MIGRATION.md](LOGGER-MIGRATION.md)** - Migration guide for centralized logging
  - How to replace `console.*` calls with the Logger class
  - Benefits of unified error handling
  - Step-by-step migration checklist

- **[JSDOC-STATUS.md](JSDOC-STATUS.md)** - JSDoc type annotations status and guidelines
  - Current JSDoc coverage (core libraries already complete!)
  - Standards and templates for documentation
  - VS Code integration tips

## 🗂️ Documentation Structure

```
docs/
├── README.md                  # This file - documentation overview
├── SITEMAP-GENERATION.md      # Sitemap automation guide
├── CODE-SPLITTING.md          # Code-splitting strategy
├── LOGGER-MIGRATION.md        # Logger migration guide
└── JSDOC-STATUS.md           # JSDoc annotations status
```

## 🔗 Related Documentation

- **Main README:** `/README.md` - Project overview and setup
- **Test Documentation:** `/tests/README.md` - Comprehensive test suite
- **Dev Documentation:** `/dev/README.md` - Local development server
- **Contributing Guidelines:** `/CONTRIBUTING.md` - How to contribute
- **Security Policy:** `/SECURITY.md` - Security reporting guidelines
- **Changelog:** `/CHANGELOG.md` - Version history

## 📝 Adding New Documentation

When creating new documentation:

1. Create the file in `/docs/` with a descriptive name
2. Use clear Markdown formatting
3. Add it to this README index
4. Link to it from the main README if relevant
5. Keep it focused and actionable

## 🎯 Quick Links

### For Developers
- [How to add a new tool](SITEMAP-GENERATION.md#adding-new-tools)
- [Performance optimization](CODE-SPLITTING.md)
- [Error handling best practices](LOGGER-MIGRATION.md)
- [Code documentation standards](JSDOC-STATUS.md)

### For Maintainers
- [Sitemap verification](SITEMAP-GENERATION.md#verification)
- [Logger implementation](LOGGER-MIGRATION.md#implementation-steps)
- [Code review checklist](JSDOC-STATUS.md#migration-checklist)

## 💡 Contributing

Found a mistake or want to improve the documentation? See [CONTRIBUTING.md](../CONTRIBUTING.md) for guidelines.
