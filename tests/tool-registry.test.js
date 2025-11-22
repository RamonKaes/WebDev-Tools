/**
 * Tool Registry Tests
 * Tests for ES6 Map-based tool registry with backward compatibility
 */

const ToolRegistryTests = {
  name: 'Tool Registry (ES6)',
  tests: [],

  /**
   * Test 1: Registry is initialized
   */
  testRegistryInitialized() {
    const passed = typeof window.Tools === 'object';
    return {
      description: 'window.Tools is initialized',
      passed,
      error: passed ? null : 'Tools registry not found'
    };
  },

  /**
   * Test 2: Register a tool
   */
  testRegisterTool() {
    const testTool = {
      init: () => {},
      open: (container) => {
        container.innerHTML = '<div>Test Tool</div>';
      }
    };

    window.Tools.register('test-tool', testTool);
    const passed = window.Tools.has('test-tool');

    return {
      description: 'Can register a tool',
      passed,
      error: passed ? null : 'Tool registration failed'
    };
  },

  /**
   * Test 3: Get a registered tool
   */
  testGetTool() {
    const tool = window.Tools.get('test-tool');
    const passed = tool !== null && typeof tool.open === 'function';

    return {
      description: 'Can retrieve registered tool',
      passed,
      error: passed ? null : 'Tool retrieval failed'
    };
  },

  /**
   * Test 4: Check if tool exists
   */
  testHasTool() {
    const exists = window.Tools.has('test-tool');
    const notExists = window.Tools.has('non-existent-tool');

    return {
      description: 'has() method works correctly',
      passed: exists === true && notExists === false,
      error: (exists && !notExists) ? null : 'has() check failed'
    };
  },

  /**
   * Test 5: Get all tool names
   */
  testGetAllTools() {
    const tools = window.Tools.getAll();
    const passed = Array.isArray(tools) && tools.includes('test-tool');

    return {
      description: 'getAll() returns array of tool names',
      passed,
      error: passed ? null : 'getAll() failed'
    };
  },

  /**
   * Test 6: Registry size property
   */
  testRegistrySize() {
    const size = window.Tools.size;
    const passed = typeof size === 'number' && size > 0;

    return {
      description: 'size property returns correct count',
      passed,
      error: passed ? null : `size is ${size}`
    };
  },

  /**
   * Test 7: Get tool metadata
   */
  testGetMetadata() {
    window.Tools.register('metadata-tool', {
      init: () => {},
      open: () => {}
    }, {
      version: '1.0.0',
      author: 'Test'
    });

    const metadata = window.Tools.getMetadata('metadata-tool');
    const passed = (
      metadata !== null &&
      metadata.name === 'metadata-tool' &&
      metadata.version === '1.0.0' &&
      metadata.author === 'Test' &&
      typeof metadata.registeredAt === 'number'
    );

    return {
      description: 'Metadata is stored and retrievable',
      passed,
      error: passed ? null : 'Metadata retrieval failed'
    };
  },

  /**
   * Test 8: Lifecycle hooks (beforeInit, afterInit)
   */
  testLifecycleHooks() {
    let beforeInitCalled = false;
    let afterInitCalled = false;

    window.Tools.on('beforeInit', (name) => {
      if (name === 'hook-test-tool') beforeInitCalled = true;
    });

    window.Tools.on('afterInit', (name) => {
      if (name === 'hook-test-tool') afterInitCalled = true;
    });

    window.Tools.register('hook-test-tool', {
      init: () => {},
      open: () => {}
    });

    return {
      description: 'Lifecycle hooks (beforeInit, afterInit) are called',
      passed: beforeInitCalled && afterInitCalled,
      error: (beforeInitCalled && afterInitCalled) ? null : `before: ${beforeInitCalled}, after: ${afterInitCalled}`
    };
  },

  /**
   * Test 9: Unregister a tool
   */
  testUnregisterTool() {
    window.Tools.register('temp-tool', {
      init: () => {},
      open: () => {}
    });

    const hadTool = window.Tools.has('temp-tool');
    const unregistered = window.Tools.unregister('temp-tool');
    const noLongerHas = !window.Tools.has('temp-tool');

    return {
      description: 'Can unregister a tool',
      passed: hadTool && unregistered && noLongerHas,
      error: (hadTool && unregistered && noLongerHas) ? null : 'Unregister failed'
    };
  },

  /**
   * Test 10: forEach iteration
   */
  testForEachIteration() {
    let iterationCount = 0;
    window.Tools.forEach((tool, name) => {
      iterationCount++;
    });

    const passed = iterationCount === window.Tools.size;

    return {
      description: 'forEach iterates over all tools',
      passed,
      error: passed ? null : `Iterated ${iterationCount} times, expected ${window.Tools.size}`
    };
  },

  /**
   * Test 11: Open tool in container
   */
  testOpenTool() {
    const container = document.createElement('div');
    
    window.Tools.register('open-test-tool', {
      init: () => {},
      open: (c) => {
        c.innerHTML = '<div id="open-test-content">Opened</div>';
      }
    });

    window.Tools.open('open-test-tool', container);
    
    const passed = container.querySelector('#open-test-content') !== null;

    return {
      description: 'Can open a tool in container',
      passed,
      error: passed ? null : 'Tool open failed'
    };
  },

  /**
   * Test 12: Error handling for non-existent tool
   */
  testOpenNonExistentTool() {
    const container = document.createElement('div');
    window.Tools.open('non-existent-tool', container);

    const hasAlert = container.querySelector('.alert-warning') !== null;

    return {
      description: 'Shows warning for non-existent tool',
      passed: hasAlert,
      error: hasAlert ? null : 'Warning not displayed'
    };
  },

  /**
   * Test 13: Backward compatibility with legacy API
   */
  testBackwardCompatibility() {
    // Old API should still work
    const hasRegister = typeof window.Tools.register === 'function';
    const hasOpen = typeof window.Tools.open === 'function';
    const hasGet = typeof window.Tools.get === 'function';
    const hasGetAll = typeof window.Tools.getAll === 'function';
    const hasHas = typeof window.Tools.has === 'function';

    return {
      description: 'Backward compatible with legacy API',
      passed: hasRegister && hasOpen && hasGet && hasGetAll && hasHas,
      error: (hasRegister && hasOpen && hasGet && hasGetAll && hasHas) ? null : 'Legacy API missing'
    };
  },

  /**
   * Test 14: entries() method
   */
  testEntriesMethod() {
    const entries = window.Tools.entries();
    const passed = Array.isArray(entries) && entries.length === window.Tools.size;

    return {
      description: 'entries() returns array of [name, tool] pairs',
      passed,
      error: passed ? null : 'entries() failed'
    };
  },

  /**
   * Test 15: No duplicate registration warning
   */
  testNoDuplicateRegistration() {
    const originalWarn = console.warn;
    let warningLogged = false;
    console.warn = (...args) => {
      if (args[0].includes('already registered')) {
        warningLogged = true;
      }
    };

    window.Tools.register('duplicate-test', { init: () => {}, open: () => {} });
    window.Tools.register('duplicate-test', { init: () => {}, open: () => {} });

    console.warn = originalWarn;

    return {
      description: 'Warns on duplicate registration',
      passed: warningLogged,
      error: warningLogged ? null : 'No warning for duplicate'
    };
  },

  /**
   * Run all tests
   */
  runAll() {
    console.log(`\n🧪 Running ${this.name} Tests...\n`);
    
    const results = [
      this.testRegistryInitialized(),
      this.testRegisterTool(),
      this.testGetTool(),
      this.testHasTool(),
      this.testGetAllTools(),
      this.testRegistrySize(),
      this.testGetMetadata(),
      this.testLifecycleHooks(),
      this.testUnregisterTool(),
      this.testForEachIteration(),
      this.testOpenTool(),
      this.testOpenNonExistentTool(),
      this.testBackwardCompatibility(),
      this.testEntriesMethod(),
      this.testNoDuplicateRegistration()
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
ToolRegistryTests.runAll();
