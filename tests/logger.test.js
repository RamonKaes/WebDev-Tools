/**
 * Logger Error Handling Tests
 * Tests for error classification, stack traces, and error tracking
 */

const LoggerTests = {
  name: 'Logger Error Handling',
  tests: [],

  /**
   * Test: Error type classification
   */
  testErrorTypeClassification() {
    const originalError = console.error;
    let capturedError = null;
    console.error = (...args) => { capturedError = args; };

    window.logger.error('Validation error', {field: 'email'}, 'VALIDATION');
    
    console.error = originalError;
    
    const errorMessage = capturedError ? capturedError.join(' ') : '';
    return {
      pass: errorMessage.includes('[VALIDATION]') && errorMessage.includes('Validation error'),
      message: errorMessage.includes('[VALIDATION]') 
        ? 'Error classified as VALIDATION' 
        : `Expected VALIDATION type, got: ${errorMessage}`
    };
  },

  /**
   * Test: Network error classification
   */
  testNetworkErrorType() {
    const originalError = console.error;
    let capturedError = null;
    console.error = (...args) => { capturedError = args; };

    window.logger.error(new Error('Network timeout'), 'NETWORK');
    
    console.error = originalError;
    
    const errorMessage = capturedError ? capturedError.join(' ') : '';
    return {
      pass: errorMessage.includes('[NETWORK]') && errorMessage.includes('Network timeout'),
      message: errorMessage.includes('[NETWORK]') 
        ? 'Network error classified correctly' 
        : `Expected NETWORK type, got: ${errorMessage}`
    };
  },

  /**
   * Test: System error classification
   */
  testSystemErrorType() {
    const originalError = console.error;
    let capturedError = null;
    console.error = (...args) => { capturedError = args; };

    window.logger.error('Database connection failed', {}, 'SYSTEM');
    
    console.error = originalError;
    
    const errorMessage = capturedError ? capturedError.join(' ') : '';
    return {
      pass: errorMessage.includes('[SYSTEM]'),
      message: errorMessage.includes('[SYSTEM]') 
        ? 'System error classified correctly' 
        : `Expected SYSTEM type, got: ${errorMessage}`
    };
  },

  /**
   * Test: Unknown error fallback
   */
  testUnknownErrorFallback() {
    const originalError = console.error;
    let capturedError = null;
    console.error = (...args) => { capturedError = args; };

    window.logger.error('Generic error');
    
    console.error = originalError;
    
    const errorMessage = capturedError ? capturedError.join(' ') : '';
    return {
      pass: errorMessage.includes('[UNKNOWN]'),
      message: errorMessage.includes('[UNKNOWN]') 
        ? 'Default UNKNOWN type applied' 
        : `Expected UNKNOWN type, got: ${errorMessage}`
    };
  },

  /**
   * Test: Error history collection
   */
  testErrorHistory() {
    window.logger.clearErrorHistory();
    
    window.logger.error('Test error 1', {}, 'VALIDATION');
    window.logger.error('Test error 2', {}, 'NETWORK');
    window.logger.error('Test error 3', {}, 'SYSTEM');
    
    const history = window.logger.getErrorHistory();
    
    return {
      pass: history.length === 3 && 
            history[0].type === 'VALIDATION' && 
            history[1].type === 'NETWORK' && 
            history[2].type === 'SYSTEM',
      message: history.length === 3 
        ? `Error history contains 3 entries with correct types` 
        : `Expected 3 errors, got ${history.length}`
    };
  },

  /**
   * Test: Error history size limit
   */
  testErrorHistoryLimit() {
    window.logger.clearErrorHistory();
    
    // Add more than maxHistorySize (50) errors
    for (let i = 0; i < 60; i++) {
      window.logger.error(`Test error ${i}`, {}, 'SYSTEM');
    }
    
    const history = window.logger.getErrorHistory();
    
    return {
      pass: history.length === 50,
      message: history.length === 50 
        ? 'Error history limited to 50 entries' 
        : `Expected 50 entries, got ${history.length}`
    };
  },

  /**
   * Test: Stack trace capture for Error objects
   */
  testStackTraceCapture() {
    window.logger.clearErrorHistory();
    
    const testError = new Error('Test error with stack');
    window.logger.error(testError, 'SYSTEM');
    
    const history = window.logger.getErrorHistory();
    const lastError = history[history.length - 1];
    
    return {
      pass: lastError.stack !== null && typeof lastError.stack === 'string',
      message: lastError.stack 
        ? 'Stack trace captured successfully' 
        : 'Stack trace not captured'
    };
  },

  /**
   * Test: Error tracking service integration
   */
  testErrorTrackingService() {
    let trackedError = null;
    
    window.logger.setErrorTracking((error) => {
      trackedError = error;
    });
    
    window.logger.error('Tracked error', {userId: 123}, 'VALIDATION');
    
    // Reset tracking
    window.logger.setErrorTracking(null);
    
    return {
      pass: trackedError !== null && 
            trackedError.type === 'VALIDATION' && 
            trackedError.context.userId === 123,
      message: trackedError 
        ? 'Error tracking service called with correct data' 
        : 'Error tracking service not called'
    };
  },

  /**
   * Test: Clear error history
   */
  testClearErrorHistory() {
    window.logger.clearErrorHistory();
    window.logger.error('Test error', {}, 'SYSTEM');
    
    let history = window.logger.getErrorHistory();
    const hadError = history.length === 1;
    
    window.logger.clearErrorHistory();
    history = window.logger.getErrorHistory();
    
    return {
      pass: hadError && history.length === 0,
      message: history.length === 0 
        ? 'Error history cleared successfully' 
        : `Expected 0 errors after clear, got ${history.length}`
    };
  },

  /**
   * Test: Error context preservation
   */
  testErrorContextPreservation() {
    window.logger.clearErrorHistory();
    
    const context = {
      userId: 456,
      action: 'save',
      resource: 'document'
    };
    
    window.logger.error('Context test', context, 'VALIDATION');
    
    const history = window.logger.getErrorHistory();
    const lastError = history[history.length - 1];
    
    return {
      pass: lastError.context.userId === 456 && 
            lastError.context.action === 'save' && 
            lastError.context.resource === 'document',
      message: lastError.context.userId === 456 
        ? 'Error context preserved correctly' 
        : `Context mismatch: ${JSON.stringify(lastError.context)}`
    };
  },

  /**
   * Run all tests
   */
  runAll() {
    console.log(`\n=== ${this.name} ===\n`);
    
    this.tests = [
      { name: 'Error Type Classification', fn: this.testErrorTypeClassification },
      { name: 'Network Error Type', fn: this.testNetworkErrorType },
      { name: 'System Error Type', fn: this.testSystemErrorType },
      { name: 'Unknown Error Fallback', fn: this.testUnknownErrorFallback },
      { name: 'Error History Collection', fn: this.testErrorHistory },
      { name: 'Error History Size Limit', fn: this.testErrorHistoryLimit },
      { name: 'Stack Trace Capture', fn: this.testStackTraceCapture },
      { name: 'Error Tracking Service', fn: this.testErrorTrackingService },
      { name: 'Clear Error History', fn: this.testClearErrorHistory },
      { name: 'Error Context Preservation', fn: this.testErrorContextPreservation }
    ];

    let passed = 0;
    let failed = 0;

    this.tests.forEach((test, index) => {
      try {
        const result = test.fn.call(this);
        if (result.pass) {
          console.log(`✅ ${index + 1}. ${test.name}`);
          passed++;
        } else {
          console.log(`❌ ${index + 1}. ${test.name}`);
          console.log(`   ${result.message}`);
          failed++;
        }
      } catch (error) {
        console.log(`❌ ${index + 1}. ${test.name}`);
        console.log(`   Error: ${error.message}`);
        failed++;
      }
    });

    console.log(`\n${passed} passed, ${failed} failed\n`);
    return { passed, failed, total: this.tests.length };
  }
};

// Auto-run if loaded directly
if (typeof window !== 'undefined') {
  window.LoggerTests = LoggerTests;
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
  module.exports = LoggerTests;
}
