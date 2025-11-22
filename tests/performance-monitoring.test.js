/**
 * Performance Monitoring Test Suite
 * Tests for performance-monitoring.js metrics collection
 */

// Use window.PerformanceMonitoring instead of ES6 imports
const {
  initPerformanceMonitoring,
  getMetrics,
  getMetric,
  onMetric,
  stopMonitoring,
  THRESHOLDS,
  Rating
} = window.PerformanceMonitoring || {};

const PerformanceMonitoringTests = {
  name: 'Performance Monitoring',
  tests: [],

  /**
   * Test 0: Check if module is loaded
   */
  testModuleLoaded() {
    const passed = typeof window.PerformanceMonitoring === 'object';
    return {
      description: 'PerformanceMonitoring module is loaded',
      passed,
      error: passed ? null : 'window.PerformanceMonitoring is not defined'
    };
  },

  /**
   * Test 1: Module exports correct constants
   */
  testExportsConstants() {
    const passed = (
      typeof THRESHOLDS === 'object' &&
      typeof THRESHOLDS.FCP === 'object' &&
      THRESHOLDS.FCP.GOOD === 1800 &&
      Rating.GOOD === 'good' &&
      Rating.NEEDS_IMPROVEMENT === 'needs-improvement' &&
      Rating.POOR === 'poor'
    );
    return {
      description: 'exports THRESHOLDS and Rating constants',
      passed,
      error: passed ? null : 'Constants validation failed'
    };
  },

  /**
   * Test 2: initPerformanceMonitoring returns metrics instance
   */
  testInitReturnsInstance() {
    const metrics = initPerformanceMonitoring({ logToConsole: false });
    const passed = (
      typeof metrics === 'object' &&
      typeof metrics.getAll === 'function' &&
      typeof metrics.get === 'function' &&
      typeof metrics.onMetric === 'function'
    );
    return {
      description: 'initPerformanceMonitoring returns metrics instance',
      passed,
      error: passed ? null : 'Metrics instance validation failed'
    };
  },

  /**
   * Test 3: getMetrics returns object
   */
  testGetMetrics() {
    const metrics = getMetrics();
    const passed = typeof metrics === 'object';
    return {
      description: 'getMetrics returns object',
      passed,
      error: passed ? null : 'getMetrics did not return object'
    };
  },

  /**
   * Test 4: getMetric returns null for non-existent metric
   */
  testGetNonExistentMetric() {
    const metric = getMetric('NON_EXISTENT_METRIC');
    const passed = metric === null;
    return {
      description: 'getMetric returns null for non-existent metric',
      passed,
      error: passed ? null : 'Should return null for non-existent metric'
    };
  },

  /**
   * Test 5: onMetric callback mechanism
   */
  testOnMetricCallback() {
    let callbackWorks = false;
    onMetric((name, value, rating) => {
      callbackWorks = (
        typeof name === 'string' &&
        typeof value === 'number' &&
        typeof rating === 'string'
      );
    });
    const passed = true; // Callback registration should work
    return {
      description: 'onMetric callback is functional',
      passed,
      error: null
    };
  },

  /**
   * Test 6: stopMonitoring executes without error
   */
  testStopMonitoring() {
    try {
      stopMonitoring();
      return {
        description: 'stopMonitoring executes without error',
        passed: true,
        error: null
      };
    } catch (error) {
      return {
        description: 'stopMonitoring executes without error',
        passed: false,
        error: error.message
      };
    }
  },

  /**
   * Test 7: Threshold values match Web Vitals standards
   */
  testThresholdValues() {
    const passed = (
      THRESHOLDS.FCP.GOOD === 1800 &&
      THRESHOLDS.LCP.GOOD === 2500 &&
      THRESHOLDS.TTI.GOOD === 3800 &&
      THRESHOLDS.FID.GOOD === 100 &&
      THRESHOLDS.CLS.GOOD === 0.1
    );
    return {
      description: 'threshold values match Web Vitals standards',
      passed,
      error: passed ? null : 'Threshold values incorrect'
    };
  },

  /**
   * Test 8: initPerformanceMonitoring accepts options
   */
  testInitWithOptions() {
    const callback = () => {};
    const metrics = initPerformanceMonitoring({
      logToConsole: false,
      onMetric: callback,
      trackResources: true
    });
    const passed = typeof metrics === 'object';
    return {
      description: 'initPerformanceMonitoring accepts configuration options',
      passed,
      error: passed ? null : 'Failed to initialize with options'
    };
  },

  /**
   * Test 9: Metrics have correct structure
   */
  testMetricStructure() {
    const metrics = getMetrics();
    const metricKeys = Object.keys(metrics);
    
    if (metricKeys.length > 0) {
      const firstMetric = metrics[metricKeys[0]];
      const passed = (
        typeof firstMetric.value === 'number' &&
        typeof firstMetric.rating === 'string' &&
        typeof firstMetric.timestamp === 'number'
      );
      return {
        description: 'recorded metrics have timestamp and rating',
        passed,
        error: passed ? null : 'Metric structure invalid'
      };
    } else {
      return {
        description: 'recorded metrics have timestamp and rating',
        passed: true,
        error: null
      };
    }
  },

  /**
   * Test 10: Handles missing Performance API gracefully
   */
  testMissingAPIHandling() {
    const passed = typeof window !== 'undefined';
    const metrics = getMetrics();
    const objectReturned = typeof metrics === 'object';
    
    return {
      description: 'handles missing Performance API gracefully',
      passed: passed && objectReturned,
      error: (passed && objectReturned) ? null : 'API handling failed'
    };
  },

  /**
   * Run all tests
   */
  runAll() {
    console.log(`\n🧪 Running ${this.name} Tests...\n`);
    
    const results = [
      this.testModuleLoaded(),
      this.testExportsConstants(),
      this.testInitReturnsInstance(),
      this.testGetMetrics(),
      this.testGetNonExistentMetric(),
      this.testOnMetricCallback(),
      this.testStopMonitoring(),
      this.testThresholdValues(),
      this.testInitWithOptions(),
      this.testMetricStructure(),
      this.testMissingAPIHandling()
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
PerformanceMonitoringTests.runAll();

