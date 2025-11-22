/**
 * I18n Fallback Tests
 * Tests for translation fallback mechanism
 */

const I18nFallbackTests = {
  name: 'I18n Fallback Mechanism',
  tests: [],

  /**
   * Test 1: Fallback to English when German fails
   */
  async testFallbackOnLoadFailure() {
    // Mock fetch to fail for 'de' and succeed for 'en'
    const originalFetch = window.fetch;
    window.fetch = async (url) => {
      if (url.includes('/de.json')) {
        return { ok: false, status: 404 };
      }
      if (url.includes('/en.json')) {
        return {
          ok: true,
          json: async () => ({ common: { test: 'Test EN' } })
        };
      }
    };

    const i18n = new I18n();
    const result = await i18n.loadTranslations('de');
    
    window.fetch = originalFetch;

    return {
      description: 'Falls back to English when German translation fails',
      passed: result === true && i18n.currentLang === 'en',
      error: result ? null : 'Fallback did not work'
    };
  },

  /**
   * Test 2: Warning on missing translation key
   */
  testMissingKeyWarning() {
    const i18n = new I18n();
    i18n.currentLang = 'en';
    i18n.fallbackLang = 'en';
    i18n.translations.en = { common: { hello: 'Hello' } };

    // Mock console.warn
    const warnings = [];
    const originalWarn = console.warn;
    console.warn = (...args) => warnings.push(args.join(' '));

    const result = i18n.t('common.missing_key');

    console.warn = originalWarn;

    return {
      description: 'Logs warning for missing translation key',
      passed: warnings.length > 0 && warnings[0].includes('Missing translation'),
      error: warnings.length === 0 ? 'No warning logged' : null
    };
  },

  /**
   * Test 3: Placeholder text for missing keys
   */
  testMissingKeyPlaceholder() {
    const i18n = new I18n();
    i18n.currentLang = 'en';
    i18n.fallbackLang = 'en';
    i18n.translations.en = { common: { hello: 'Hello' } };

    const result = i18n.t('common.nonexistent_key');

    return {
      description: 'Returns [MISSING: key] placeholder for missing keys',
      passed: result === '[MISSING: common.nonexistent_key]',
      error: result !== '[MISSING: common.nonexistent_key]' ? `Got: ${result}` : null
    };
  },

  /**
   * Test 4: Fallback to English in t() method
   */
  testTranslationFallback() {
    const i18n = new I18n();
    i18n.currentLang = 'de';
    i18n.fallbackLang = 'en';
    i18n.translations.de = { common: { hello: 'Hallo' } };
    i18n.translations.en = { common: { hello: 'Hello', goodbye: 'Goodbye' } };

    // Mock console.warn
    const originalWarn = console.warn;
    console.warn = () => {};

    // Key exists in DE
    const hello = i18n.t('common.hello');
    
    // Key missing in DE, exists in EN
    const goodbye = i18n.t('common.goodbye');

    console.warn = originalWarn;

    return {
      description: 'Falls back to English for missing German translations',
      passed: hello === 'Hallo' && goodbye === 'Goodbye',
      error: (hello !== 'Hallo' || goodbye !== 'Goodbye') ? `hello: ${hello}, goodbye: ${goodbye}` : null
    };
  },

  /**
   * Test 5: getBasePath() returns correct path
   */
  testGetBasePath() {
    const i18n = new I18n();
    
    // Save original location
    const originalLocation = window.location;
    const mockLocation = new URL('http://localhost/WebDev-Tools/de/base64-kodierer-dekodierer/');
    
    // Use Object.defineProperty instead of delete
    Object.defineProperty(window, 'location', {
      value: mockLocation,
      writable: true,
      configurable: true
    });

    const basePath = i18n.getBasePath();

    // Restore original location
    Object.defineProperty(window, 'location', {
      value: originalLocation,
      writable: true,
      configurable: true
    });

    return {
      description: 'getBasePath() returns correct WebDev-Tools path',
      passed: basePath === '/WebDev-Tools/',
      error: basePath !== '/WebDev-Tools/' ? `Got: ${basePath}` : null
    };
  },

  /**
   * Test 6: Parameter interpolation still works
   */
  testParameterInterpolation() {
    const i18n = new I18n();
    i18n.currentLang = 'en';
    i18n.fallbackLang = 'en';
    i18n.translations.en = {
      errors: { file_too_large: 'File too large: {{size}}' }
    };

    const result = i18n.t('errors.file_too_large', { size: '10MB' });

    return {
      description: 'Parameter interpolation works with fallback',
      passed: result === 'File too large: 10MB',
      error: result !== 'File too large: 10MB' ? `Got: ${result}` : null
    };
  },

  /**
   * Test 7: Empty key returns empty string
   */
  testEmptyKey() {
    const i18n = new I18n();
    const result = i18n.t('');

    return {
      description: 'Empty key returns empty string',
      passed: result === '',
      error: result !== '' ? `Got: ${result}` : null
    };
  },

  /**
   * Test 8: Cached translations are reused
   */
  async testTranslationCaching() {
    const i18n = new I18n();
    i18n.translations.en = { common: { test: 'Cached' } };

    const result = await i18n.loadTranslations('en');

    return {
      description: 'Cached translations are reused without re-fetching',
      passed: result === true,
      error: result !== true ? 'Caching failed' : null
    };
  },

  /**
   * Test 9: Fallback language is 'en'
   */
  testFallbackLanguage() {
    const i18n = new I18n();

    return {
      description: 'Fallback language defaults to "en"',
      passed: i18n.fallbackLang === 'en',
      error: i18n.fallbackLang !== 'en' ? `Got: ${i18n.fallbackLang}` : null
    };
  },

  /**
   * Test 10: Nested key paths work
   */
  testNestedKeyPaths() {
    const i18n = new I18n();
    i18n.currentLang = 'en';
    i18n.fallbackLang = 'en';
    i18n.translations.en = {
      tools: {
        base64: {
          title: 'Base64 Encoder/Decoder'
        }
      }
    };

    const result = i18n.t('tools.base64.title');

    return {
      description: 'Nested key paths resolve correctly',
      passed: result === 'Base64 Encoder/Decoder',
      error: result !== 'Base64 Encoder/Decoder' ? `Got: ${result}` : null
    };
  },

  /**
   * Run all tests
   */
  async runAll() {
    console.log(`\n🧪 Running ${this.name} Tests...\n`);
    
    const results = [
      await this.testFallbackOnLoadFailure(),
      this.testMissingKeyWarning(),
      this.testMissingKeyPlaceholder(),
      this.testTranslationFallback(),
      this.testGetBasePath(),
      this.testParameterInterpolation(),
      this.testEmptyKey(),
      await this.testTranslationCaching(),
      this.testFallbackLanguage(),
      this.testNestedKeyPaths()
    ];

    let passed = 0;
    let failed = 0;

    results.forEach(result => {
      if (result.passed) {
        passed++;
        console.log(`✓ PASS: ${result.description}`);
      } else {
        failed++;
        console.log(`✗ FAIL: ${result.description}`);
        if (result.error) {
          console.log(`  Error: ${result.error}`);
        }
      }
    });

    console.log(`\n${'='.repeat(60)}`);
    console.log(`Tests: ${results.length} total, ${passed} passed, ${failed} failed`);
    console.log('='.repeat(60));

    return results;
  }
};

// Auto-run tests when loaded
I18nFallbackTests.runAll();
