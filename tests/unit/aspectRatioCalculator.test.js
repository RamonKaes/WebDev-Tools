'use strict';

/**
 * Unit tests for aspectRatioCalculatorTool.js
 *
 * Tests cover: ratio calculation, dimension derivation, simplification,
 * decimal ratios, CSS generation, preset/table-row interaction, and clear.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.Tools = {
    _tools: {},
    register: (name, toolObj) => {
      global.Tools._tools[name] = toolObj;
    },
    open: jest.fn(),
  };

  global.i18n = { t: (key) => key };

  global.ClipboardUtils = {
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  // Executing the IIFE registers the tool as a side effect
  require(path.join(__dirname, '../../assets/js/tools/aspectRatioCalculatorTool.js'));

  tool = global.Tools._tools.aspectRatioCalculator;
});

// ─── Helpers ─────────────────────────────────────────────────────────────────

function openTool() {
  const container = document.createElement('div');
  document.body.appendChild(container);
  tool.open(container);
  return container;
}

function cleanup(container) {
  document.body.removeChild(container);
}

/** Simulate user typing into a number/text input */
function setInput(container, selector, value) {
  const el = container.querySelector(selector);
  el.value = value;
  el.dispatchEvent(new Event('input'));
}

// ─── Tests ───────────────────────────────────────────────────────────────────

describe('AspectRatioCalculator – Registration', () => {
  test('registers tool under "aspectRatioCalculator"', () => {
    expect(tool).toBeDefined();
  });
});

describe('AspectRatioCalculator – Dimension Calculation', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('calculates height from known width (16:9, width=1920 → height=1080)', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    setInput(c, '#knownWidth', '1920');
    expect(c.querySelector('#calculatedHeight').value).toBe('1080');
  });

  test('calculates width from known height (16:9, height=1080 → width=1920)', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    setInput(c, '#knownHeight', '1080');
    expect(c.querySelector('#calculatedWidth').value).toBe('1920');
  });

  test('empty knownWidth clears calculatedHeight', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    setInput(c, '#knownWidth', '1920');
    setInput(c, '#knownWidth', '');
    expect(c.querySelector('#calculatedHeight').value).toBe('');
  });
});

describe('AspectRatioCalculator – Ratio Formats', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('simplifies 32:18 to 16:9', () => {
    setInput(c, '#ratioWidth', '32');
    setInput(c, '#ratioHeight', '18');
    expect(c.querySelector('#ratioFormat').value).toBe('16:9');
  });

  test('handles decimal ratios: 1.5:1 → 3:2', () => {
    setInput(c, '#ratioWidth', '1.5');
    setInput(c, '#ratioHeight', '1');
    expect(c.querySelector('#ratioFormat').value).toBe('3:2');
  });

  test('calculates decimal format (16:9 → 1.7778)', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    expect(c.querySelector('#decimalFormat').value).toBe('1.7778');
  });

  test('calculates percentage format (16:9 → 56.2500%)', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    expect(c.querySelector('#percentageFormat').value).toBe('56.2500%');
  });

  test('clears format fields when ratio inputs are empty', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    setInput(c, '#ratioWidth', '');
    expect(c.querySelector('#ratioFormat').value).toBe('');
    expect(c.querySelector('#decimalFormat').value).toBe('');
    expect(c.querySelector('#percentageFormat').value).toBe('');
  });
});

describe('AspectRatioCalculator – CSS Generation', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates modern CSS with aspect-ratio property', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    expect(c.querySelector('#cssOutput').value).toContain('aspect-ratio: 16 / 9');
  });

  test('generates padding-bottom CSS for legacy support', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    const method = c.querySelector('#cssMethod');
    method.value = 'padding';
    method.dispatchEvent(new Event('change'));
    expect(c.querySelector('#cssOutput').value).toContain('padding-bottom: 56.2500%');
  });

  test('"both" CSS output contains both approaches', () => {
    setInput(c, '#ratioWidth', '4');
    setInput(c, '#ratioHeight', '3');
    const method = c.querySelector('#cssMethod');
    method.value = 'both';
    method.dispatchEvent(new Event('change'));
    const css = c.querySelector('#cssOutput').value;
    expect(css).toContain('aspect-ratio: 4 / 3');
    expect(css).toContain('padding-bottom:');
  });
});

describe('AspectRatioCalculator – UI Interactions', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('preset button (4:3) sets ratio inputs and calculates', () => {
    c.querySelector('[data-ratio="4:3"]').click();
    expect(c.querySelector('#ratioWidth').value).toBe('4');
    expect(c.querySelector('#ratioHeight').value).toBe('3');
    expect(c.querySelector('#ratioFormat').value).toBe('4:3');
  });

  test('table row click sets ratio and knownWidth', () => {
    c.querySelector('[data-width="1920"][data-height="1080"]').click();
    expect(c.querySelector('#ratioWidth').value).toBe('1920');
    expect(c.querySelector('#ratioHeight').value).toBe('1080');
    expect(c.querySelector('#knownWidth').value).toBe('1920');
  });

  test('clear button resets all input and output fields', () => {
    setInput(c, '#ratioWidth', '16');
    setInput(c, '#ratioHeight', '9');
    setInput(c, '#knownWidth', '1920');
    c.querySelector('#clearAll').click();
    expect(c.querySelector('#ratioWidth').value).toBe('');
    expect(c.querySelector('#ratioHeight').value).toBe('');
    expect(c.querySelector('#knownWidth').value).toBe('');
    expect(c.querySelector('#calculatedHeight').value).toBe('');
    expect(c.querySelector('#ratioFormat').value).toBe('');
  });
});
