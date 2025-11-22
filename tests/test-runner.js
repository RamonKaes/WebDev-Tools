/**
 * Simple Vanilla JavaScript Test Runner
 * No external dependencies required
 */

class TestRunner {
  constructor() {
    this.tests = [];
    this.results = {
      total: 0,
      passed: 0,
      failed: 0,
      skipped: 0,
      duration: 0
    };
  }

  /**
   * Register a test
   * @param {string} name - Test name
   * @param {Function} fn - Test function
   */
  test(name, fn) {
    this.tests.push({ name, fn, skip: false });
  }

  /**
   * Register a test to skip
   * @param {string} name - Test name
   * @param {Function} fn - Test function
   */
  skip(name, fn) {
    this.tests.push({ name, fn, skip: true });
  }

  /**
   * Run all registered tests
   */
  async run() {
    console.log(`\n🧪 Running ${this.tests.length} tests...\n`);
    const startTime = performance.now();

    for (const test of this.tests) {
      this.results.total++;

      if (test.skip) {
        console.log(`⊝ SKIP: ${test.name}`);
        this.results.skipped++;
        continue;
      }

      try {
        await test.fn();
        console.log(`✓ PASS: ${test.name}`);
        this.results.passed++;
      } catch (error) {
        console.error(`✗ FAIL: ${test.name}`);
        console.error(`  ${error.message}`);
        if (error.stack) {
          console.error(`  ${error.stack.split('\n').slice(1, 3).join('\n')}`);
        }
        this.results.failed++;
      }
    }

    this.results.duration = performance.now() - startTime;
    this.printSummary();
  }

  /**
   * Print test summary
   */
  printSummary() {
    console.log('\n' + '='.repeat(60));
    console.log('Test Summary:');
    console.log('='.repeat(60));
    console.log(`Total:    ${this.results.total}`);
    console.log(`✓ Passed: ${this.results.passed}`);
    console.log(`✗ Failed: ${this.results.failed}`);
    console.log(`⊝ Skipped: ${this.results.skipped}`);
    console.log(`Duration: ${this.results.duration.toFixed(2)}ms`);
    console.log('='.repeat(60));

    if (this.results.failed === 0) {
      console.log('✅ All tests passed!');
    } else {
      console.log(`❌ ${this.results.failed} test(s) failed`);
    }
  }
}

/**
 * Assertion helpers
 */
const assert = {
  /**
   * Assert that a value is truthy
   */
  ok(value, message = 'Expected value to be truthy') {
    if (!value) {
      throw new Error(message);
    }
  },

  /**
   * Assert strict equality
   */
  equal(actual, expected, message) {
    if (actual !== expected) {
      const msg = message || `Expected ${JSON.stringify(expected)}, got ${JSON.stringify(actual)}`;
      throw new Error(msg);
    }
  },

  /**
   * Assert deep equality
   */
  deepEqual(actual, expected, message) {
    const actualStr = JSON.stringify(actual);
    const expectedStr = JSON.stringify(expected);
    if (actualStr !== expectedStr) {
      const msg = message || `Expected ${expectedStr}, got ${actualStr}`;
      throw new Error(msg);
    }
  },

  /**
   * Assert that a function throws
   */
  throws(fn, message = 'Expected function to throw') {
    let thrown = false;
    try {
      fn();
    } catch (e) {
      thrown = true;
    }
    if (!thrown) {
      throw new Error(message);
    }
  },

  /**
   * Assert that a value is null or undefined
   */
  isNull(value, message = 'Expected value to be null or undefined') {
    if (value !== null && value !== undefined) {
      throw new Error(message);
    }
  },

  /**
   * Assert that a value is not null or undefined
   */
  notNull(value, message = 'Expected value to not be null or undefined') {
    if (value === null || value === undefined) {
      throw new Error(message);
    }
  },

  /**
   * Assert that an array includes a value
   */
  includes(array, value, message) {
    if (!array.includes(value)) {
      const msg = message || `Expected array to include ${JSON.stringify(value)}`;
      throw new Error(msg);
    }
  },

  /**
   * Assert type
   */
  typeOf(value, type, message) {
    const actualType = typeof value;
    if (actualType !== type) {
      const msg = message || `Expected type ${type}, got ${actualType}`;
      throw new Error(msg);
    }
  }
};

// Export for use in test files
if (typeof window !== 'undefined') {
  window.TestRunner = TestRunner;
  window.assert = assert;
}

export { TestRunner, assert };
