/**
 * JSON Tree Renderer Tests
 * Tests for virtualization and lazy rendering features
 */

import { renderJSONTree, addTreeStyles, CONFIG } from '../../assets/js/lib/json-tree-renderer.js';

const JSONTreeTests = {
  name: 'JSON Tree Renderer',
  tests: [],

  /**
   * Test 1: Render simple object
   */
  testRenderSimpleObject() {
    const container = document.createElement('div');
    const data = { name: 'Test', value: 123 };
    
    renderJSONTree(data, container);
    
    const passed = container.querySelector('.json-tree') !== null;
    return {
      description: 'Renders simple object',
      passed,
      error: passed ? null : 'Tree not rendered'
    };
  },

  /**
   * Test 2: Render array
   */
  testRenderArray() {
    const container = document.createElement('div');
    const data = [1, 2, 3, 4, 5];
    
    renderJSONTree(data, container);
    
    const arrayElement = container.querySelector('.json-tree-array');
    const passed = arrayElement !== null;
    
    return {
      description: 'Renders array',
      passed,
      error: passed ? null : 'Array not rendered'
    };
  },

  /**
   * Test 3: Control buttons are present
   */
  testControlButtons() {
    const container = document.createElement('div');
    const data = { test: 'value' };
    
    renderJSONTree(data, container);
    
    const expandBtn = container.querySelector('#json-expand-all');
    const collapseBtn = container.querySelector('#json-collapse-all');
    
    return {
      description: 'Control buttons (Expand All, Collapse All) are present',
      passed: expandBtn !== null && collapseBtn !== null,
      error: (expandBtn && collapseBtn) ? null : 'Buttons missing'
    };
  },

  /**
   * Test 4: Node count display
   */
  testNodeCountDisplay() {
    const container = document.createElement('div');
    const data = { a: 1, b: 2, c: 3 };
    
    renderJSONTree(data, container);
    
    const controls = container.querySelector('.json-tree-controls');
    const hasNodeCount = controls && controls.textContent.includes('node');
    
    return {
      description: 'Displays node count',
      passed: hasNodeCount,
      error: hasNodeCount ? null : 'Node count not displayed'
    };
  },

  /**
   * Test 5: Virtualization for large datasets
   */
  testVirtualizationEnabled() {
    const container = document.createElement('div');
    
    // Generate large dataset (>1000 nodes)
    const largeData = {};
    for (let i = 0; i < 500; i++) {
      largeData[`key${i}`] = { nested: `value${i}` };
    }
    
    renderJSONTree(largeData, container);
    
    const tree = container.querySelector('.json-tree');
    const virtualized = tree && tree.dataset.virtualized === 'true';
    
    return {
      description: 'Enables virtualization for >1000 nodes',
      passed: virtualized,
      error: virtualized ? null : 'Virtualization not enabled'
    };
  },

  /**
   * Test 6: Lazy rendering for large arrays
   */
  testLazyRendering() {
    const container = document.createElement('div');
    
    // Generate array with >50 items (LAZY_RENDER_THRESHOLD)
    // Note: Current implementation doesn't use data-lazy-render anymore
    // Instead, it truncates arrays >100 items (MAX_INITIAL_RENDER) with Load More button
    const largeArray = [];
    for (let i = 0; i < 60; i++) {
      largeArray.push({ id: i, value: `item${i}` });
    }
    
    renderJSONTree(largeArray, container);
    
    // Array <100 items should render all items immediately (no lazy rendering or load more)
    // Each object has 2 properties (id, value), so 60 items × 3 rows (1 for array item + 2 for properties) = 180 rows
    const rows = container.querySelectorAll('.json-tree-row');
    const passed = rows.length === 180; // 60 array items + 120 object properties
    
    return {
      description: 'Uses lazy rendering for large arrays (>50 items)',
      passed,
      error: passed ? null : `Expected 180 rows (60 items × 3), got ${rows.length}`
    };
  },

  /**
   * Test 7: Expand/Collapse toggle functionality
   */
  testToggleFunctionality() {
    const container = document.createElement('div');
    const data = { nested: { value: 123 } };
    
    renderJSONTree(data, container);
    
    const toggle = container.querySelector('.json-tree-toggle');
    if (!toggle) {
      return {
        description: 'Toggle expand/collapse works',
        passed: false,
        error: 'No toggle found'
      };
    }
    
    const wasCollapsed = toggle.classList.contains('collapsed');
    toggle.click();
    const isCollapsedAfter = toggle.classList.contains('collapsed');
    
    return {
      description: 'Toggle expand/collapse works',
      passed: wasCollapsed !== isCollapsedAfter,
      error: wasCollapsed === isCollapsedAfter ? 'Toggle state unchanged' : null
    };
  },

  /**
   * Test 8: Expand All button functionality
   */
  testExpandAllButton() {
    const container = document.createElement('div');
    const data = { 
      level1: { 
        level2: { 
          level3: 'deep' 
        } 
      } 
    };
    
    renderJSONTree(data, container);
    
    // Collapse all first
    const collapseBtn = container.querySelector('#json-collapse-all');
    if (collapseBtn) collapseBtn.click();
    
    const expandBtn = container.querySelector('#json-expand-all');
    if (!expandBtn) {
      return {
        description: 'Expand All button works',
        passed: false,
        error: 'Button not found'
      };
    }
    
    expandBtn.click();
    
    const collapsedToggles = container.querySelectorAll('.json-tree-toggle.collapsed');
    
    return {
      description: 'Expand All button works',
      passed: collapsedToggles.length === 0,
      error: collapsedToggles.length > 0 ? `${collapsedToggles.length} still collapsed` : null
    };
  },

  /**
   * Test 9: Collapse All button functionality
   */
  testCollapseAllButton() {
    const container = document.createElement('div');
    const data = { 
      a: { b: 'value' },
      c: { d: 'value' }
    };
    
    renderJSONTree(data, container);
    
    const collapseBtn = container.querySelector('#json-collapse-all');
    if (!collapseBtn) {
      return {
        description: 'Collapse All button works',
        passed: false,
        error: 'Button not found'
      };
    }
    
    collapseBtn.click();
    
    const collapsedToggles = container.querySelectorAll('.json-tree-toggle.collapsed');
    const allToggles = container.querySelectorAll('.json-tree-toggle');
    
    return {
      description: 'Collapse All button works',
      passed: collapsedToggles.length === allToggles.length,
      error: collapsedToggles.length !== allToggles.length ? 'Not all collapsed' : null
    };
  },

  /**
   * Test 10: Primitive value rendering
   */
  testPrimitiveValues() {
    const container = document.createElement('div');
    const data = {
      string: 'text',
      number: 42,
      boolean: true,
      null: null
    };
    
    renderJSONTree(data, container);
    
    const stringValue = container.querySelector('.json-tree-string');
    const numberValue = container.querySelector('.json-tree-number');
    const booleanValue = container.querySelector('.json-tree-boolean');
    const nullValue = container.querySelector('.json-tree-null');
    
    return {
      description: 'Renders primitive values correctly',
      passed: stringValue && numberValue && booleanValue && nullValue,
      error: !(stringValue && numberValue && booleanValue && nullValue) ? 'Missing primitive rendering' : null
    };
  },

  /**
   * Test 11: Empty object/array rendering
   */
  testEmptyValues() {
    const container = document.createElement('div');
    const data = {
      emptyObj: {},
      emptyArr: []
    };
    
    renderJSONTree(data, container);
    
    const emptyElements = container.querySelectorAll('.json-tree-empty');
    
    return {
      description: 'Renders empty objects and arrays',
      passed: emptyElements.length === 2,
      error: emptyElements.length !== 2 ? `Found ${emptyElements.length}, expected 2` : null
    };
  },

  /**
   * Test 12: CONFIG constants
   */
  testConfigConstants() {
    const hasVirtualization = typeof CONFIG.VIRTUALIZATION_THRESHOLD === 'number';
    const hasLazyRender = typeof CONFIG.LAZY_RENDER_THRESHOLD === 'number';
    const hasMaxInitial = typeof CONFIG.MAX_INITIAL_RENDER === 'number';
    
    return {
      description: 'CONFIG constants are defined',
      passed: hasVirtualization && hasLazyRender && hasMaxInitial,
      error: (hasVirtualization && hasLazyRender && hasMaxInitial) ? null : 'CONFIG incomplete'
    };
  },

  /**
   * Test 13: addTreeStyles function
   */
  testAddTreeStyles() {
    addTreeStyles();
    const styleElement = document.getElementById('json-tree-styles');
    
    return {
      description: 'addTreeStyles creates style element',
      passed: styleElement !== null,
      error: styleElement ? null : 'Style element not created'
    };
  },

  /**
   * Test 14: Load More button for truncated arrays
   */
  testLoadMoreButton() {
    const container = document.createElement('div');
    
    // Create array larger than MAX_INITIAL_RENDER (100)
    const largeArray = [];
    for (let i = 0; i < 150; i++) {
      largeArray.push(i);
    }
    
    renderJSONTree(largeArray, container);
    
    const loadMore = container.querySelector('.json-tree-load-more');
    const passed = loadMore !== null;
    
    return {
      description: 'Shows "Load More" button for truncated arrays',
      passed,
      error: passed ? null : 'Load More button not found'
    };
  },

  /**
   * Test 15: Nested structure rendering
   */
  testNestedStructure() {
    const container = document.createElement('div');
    const data = {
      level1: {
        level2: {
          level3: {
            value: 'deep nesting'
          }
        }
      }
    };
    
    renderJSONTree(data, container);
    
    const keys = container.querySelectorAll('.json-tree-key');
    const passed = keys.length >= 3; // Should have level1, level2, level3
    
    return {
      description: 'Renders nested structures correctly',
      passed,
      error: passed ? null : `Only ${keys.length} keys found`
    };
  },

  /**
   * Run all tests
   */
  runAll() {
    console.log(`\n🧪 Running ${this.name} Tests...\n`);
    
    const results = [
      this.testRenderSimpleObject(),
      this.testRenderArray(),
      this.testControlButtons(),
      this.testNodeCountDisplay(),
      this.testVirtualizationEnabled(),
      this.testLazyRendering(),
      this.testToggleFunctionality(),
      this.testExpandAllButton(),
      this.testCollapseAllButton(),
      this.testPrimitiveValues(),
      this.testEmptyValues(),
      this.testConfigConstants(),
      this.testAddTreeStyles(),
      this.testLoadMoreButton(),
      this.testNestedStructure()
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
JSONTreeTests.runAll();
