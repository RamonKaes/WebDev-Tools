# Unit Tests for WebDev-Tools JavaScript Libraries

This directory contains unit tests for the core JavaScript libraries used across all tools.

## 📦 Setup

```bash
cd tests/unit
npm install
```

## 🧪 Running Tests

```bash
# Run all tests
npm test

# Watch mode (re-run on file changes)
npm run test:watch

# Interactive UI
npm run test:ui

# Coverage report
npm run test:coverage
```

## 📁 Test Files

- **validators.test.js** - Tests for JSON, XML, Base64 validation
- **formatters.test.js** - Tests for JSON/XML formatting, HTML escaping
- **clipboard-utils.test.js** - Tests for clipboard operations

## 📊 Coverage Goals

- **Target:** 80%+ coverage for all libraries
- **Critical paths:** 100% coverage for validators and formatters
- **Browser compatibility:** Tests mock both modern and legacy APIs

## 🔗 Integration

Tests use Vitest with jsdom environment to simulate browser APIs.

**Note:** These tests are currently **mocked** and serve as a template. To activate:

1. Extract actual functions from `/assets/js/lib/` into proper ES modules
2. Update imports in test files to use real implementations
3. Run tests to verify functionality

## 🚀 Next Steps

- [ ] Refactor validators.js to export testable functions
- [ ] Refactor formatters.js to export testable functions  
- [ ] Refactor clipboard-utils.js to export testable functions
- [ ] Add tests for crypto-utils.js (password generation, hashing)
- [ ] Add tests for conversion-utils.js (px-to-rem, base64, URL encoding)
