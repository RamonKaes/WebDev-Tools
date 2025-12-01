# E2E Tests for WebDev-Tools

End-to-end tests for critical user flows using Playwright.

## 📦 Setup

```bash
cd tests/e2e
npm install
npx playwright install  # Install browsers
```

## 🧪 Running Tests

```bash
# Run all tests
npm test

# Run with browser UI visible
npm run test:headed

# Interactive UI mode
npm run test:ui

# Debug mode (step through tests)
npm run test:debug

# Generate tests interactively
npm run test:codegen

# View HTML report
npm run report
```

## 📁 Test Suites

### Base64 Encoder/Decoder (`specs/base64.spec.js`)
- ✓ Encode text to Base64
- ✓ Decode Base64 to text
- ✓ Copy output to clipboard
- ✓ Download output as file
- ✓ Handle empty input gracefully
- ✓ Handle invalid Base64 when decoding
- ✓ Swap input and output

### UUID Generator (`specs/uuid.spec.js`)
- ✓ Generate single UUID v4
- ✓ Generate different UUIDs on each click
- ✓ Generate bulk UUIDs (100)
- ✓ Copy UUID to clipboard
- ✓ Download bulk UUIDs as file
- ✓ Support different UUID versions (v1, v4)
- ✓ Handle uppercase/lowercase formatting

### Password Generator (`specs/password.spec.js`)
- ✓ Generate password with default settings
- ✓ Respect length slider
- ✓ Include selected character types
- ✓ Show strength meter
- ✓ Copy password to clipboard
- ✓ Regenerate different passwords
- ✓ Support passphrase generation
- ✓ Exclude ambiguous characters when selected
- ✓ Save preferences

### Accessibility (`specs/accessibility.spec.js`)
- ✓ Base64 tool - WCAG 2.1 AA compliance
- ✓ UUID Generator - WCAG 2.1 AA compliance
- ✓ Password Generator - WCAG 2.1 AA compliance
- ✓ Homepage - WCAG 2.1 AA compliance

## 🌐 Browser Coverage

Tests run across multiple browsers:
- ✓ Chromium (Desktop)
- ✓ Firefox (Desktop)
- ✓ WebKit/Safari (Desktop)
- ✓ Chrome (Mobile - Pixel 5)
- ✓ Safari (Mobile - iPhone 12)

## 📊 Test Results

After running tests, view the HTML report:
```bash
npm run report
```

Report includes:
- Pass/fail status for each test
- Screenshots on failure
- Execution traces for debugging
- Cross-browser results

## 🔧 Configuration

`playwright.config.js` settings:
- **Base URL**: http://localhost:8000
- **Retries**: 2 in CI, 0 locally
- **Parallel execution**: Yes
- **Screenshots**: Only on failure
- **Traces**: On first retry
- **Web server**: Auto-starts dev server if not running

## 🚀 CI/CD Integration

Add to GitHub Actions:

```yaml
- name: Install dependencies
  run: |
    cd tests/e2e
    npm ci
    npx playwright install --with-deps

- name: Run E2E tests
  run: |
    cd tests/e2e
    npm test

- name: Upload test results
  if: always()
  uses: actions/upload-artifact@v3
  with:
    name: playwright-report
    path: tests/e2e/playwright-report/
```

## 📝 Writing New Tests

Example test structure:

```javascript
import { test, expect } from '@playwright/test';

test.describe('Tool Name', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/tool-url/');
  });

  test('should perform action', async ({ page }) => {
    // Arrange
    await page.fill('#input', 'test');
    
    // Act
    await page.click('button:has-text("Submit")');
    
    // Assert
    const result = await page.inputValue('#output');
    expect(result).toBe('expected');
  });
});
```

## 🎯 Coverage Goals

- **Critical paths**: 100% coverage
- **All tools**: Basic smoke tests
- **Accessibility**: All pages WCAG 2.1 AA compliant
- **Cross-browser**: All tests pass on all browsers

## 🐛 Debugging Tips

1. **Use headed mode** to see what's happening:
   ```bash
   npm run test:headed
   ```

2. **Use debug mode** to step through tests:
   ```bash
   npm run test:debug
   ```

3. **Inspect failures** with trace viewer:
   ```bash
   npx playwright show-trace trace.zip
   ```

4. **Generate tests** with codegen:
   ```bash
   npm run test:codegen
   ```

## 📚 Resources

- [Playwright Docs](https://playwright.dev/)
- [Best Practices](https://playwright.dev/docs/best-practices)
- [axe-core Integration](https://github.com/dequelabs/axe-core-npm/tree/develop/packages/playwright)
