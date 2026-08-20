'use strict';

/**
 * Unit tests for jsonFormatterValidatorTool.js
 *
 * Tests cover: tool registration, UI rendering, format/validate/minify,
 * auto-fix, sort keys, path extractor, escape/unescape, clear, load sample,
 * copy, download, size limits, XSS protection.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.Tools = {
    _tools: {},
    register: (name, toolObj) => { global.Tools._tools[name] = toolObj; },
    open: jest.fn(),
  };

  global.i18n = { t: (key) => key };

  global.ClipboardUtils = {
    iconHandle: (button) => {
      if (!button || typeof button.querySelector !== 'function') return null;
      const el = button.querySelector('i, svg');
      if (!el) return null;
      if (el.tagName.toLowerCase() === 'i') return el;
      return {
        get className() { return el.getAttribute('class') || ''; },
        set className(v) { el.setAttribute('class', v); }
      };
    },
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  global.AppHelpers = {
    escapeHtml: (s) => String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;'),
  };

  // jsdom doesn't support URL.createObjectURL
  if (!global.URL.createObjectURL) {
    global.URL.createObjectURL = jest.fn(() => 'blob:mock');
    global.URL.revokeObjectURL = jest.fn();
  }

  require(path.join(__dirname, '../../assets/js/tools/jsonFormatterValidatorTool.js'));

  tool = global.Tools._tools.jsonFormatterValidator;
});

// ─── Helpers ─────────────────────────────────────────────────────────────────

function openTool() {
  const container = document.createElement('div');
  container.id = 'tool-container';
  document.body.appendChild(container);
  tool.open(container);
  return container;
}

function cleanup(container) {
  document.body.removeChild(container);
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Registration', () => {
  test('registers tool under "jsonFormatterValidator"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders #jsonInput textarea', () => {
    expect(c.querySelector('#jsonInput')).not.toBeNull();
  });

  test('renders #jsonOutput textarea', () => {
    expect(c.querySelector('#jsonOutput')).not.toBeNull();
  });

  test('renders Format, Validate, Minify, Clear, Load Sample buttons', () => {
    expect(c.querySelector('#formatBtn')).not.toBeNull();
    expect(c.querySelector('#validateBtn')).not.toBeNull();
    expect(c.querySelector('#minifyBtn')).not.toBeNull();
    expect(c.querySelector('#clearBtn')).not.toBeNull();
    expect(c.querySelector('#loadSampleBtn')).not.toBeNull();
  });

  test('renders indentation selector', () => {
    expect(c.querySelector('#indentSelect')).not.toBeNull();
  });

  test('renders view mode radio buttons', () => {
    expect(c.querySelector('#viewText')).not.toBeNull();
    expect(c.querySelector('#viewTree')).not.toBeNull();
  });

  test('renders path extractor section', () => {
    expect(c.querySelector('#jsonPath')).not.toBeNull();
    expect(c.querySelector('#extractPathBtn')).not.toBeNull();
  });

  test('renders escape/unescape buttons', () => {
    expect(c.querySelector('#escapeBtn')).not.toBeNull();
    expect(c.querySelector('#unescapeBtn')).not.toBeNull();
  });

  test('renders status output with initial message', () => {
    const status = c.querySelector('#statusOutput');
    expect(status).not.toBeNull();
    expect(status.textContent.length).toBeGreaterThan(0);
  });
});

// ─── Format ──────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Format', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('formats valid JSON and shows success status', () => {
    c.querySelector('#jsonInput').value = '{"a":1,"b":2}';
    c.querySelector('#formatBtn').click();
    const output = c.querySelector('#jsonOutput').value;
    expect(output).toContain('"a"');
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
  });

  test('shows warning when input is empty', () => {
    c.querySelector('#jsonInput').value = '';
    c.querySelector('#formatBtn').click();
    expect(c.querySelector('#jsonOutput').value).toBe('');
    expect(c.querySelector('#statusOutput').textContent).toContain('jsonFormatterValidator.no_input');
  });

  test('shows error for invalid JSON', () => {
    c.querySelector('#jsonInput').value = '{invalid}';
    c.querySelector('#formatBtn').click();
    expect(c.querySelector('#statusOutput .alert-danger')).not.toBeNull();
  });

  test('respects 4-space indentation', () => {
    c.querySelector('#indentSelect').value = '4';
    c.querySelector('#jsonInput').value = '{"x":1}';
    c.querySelector('#formatBtn').click();
    expect(c.querySelector('#jsonOutput').value).toContain('    "x"');
  });

  test('respects 2-space indentation', () => {
    c.querySelector('#indentSelect').value = '2';
    c.querySelector('#jsonInput').value = '{"x":1}';
    c.querySelector('#formatBtn').click();
    const out = c.querySelector('#jsonOutput').value;
    expect(out).toContain('  "x"');
    expect(out).not.toContain('    "x"');
  });

  test('XSS: error message escapes HTML in JSON parse error', () => {
    c.querySelector('#jsonInput').value = '{<script>alert(1)</script>}';
    c.querySelector('#formatBtn').click();
    const status = c.querySelector('#statusOutput').innerHTML;
    expect(status).not.toContain('<script>');
  });
});

// ─── Validate ────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Validate', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows success for valid JSON object', () => {
    c.querySelector('#jsonInput').value = '{"name":"Alice","age":30}';
    c.querySelector('#validateBtn').click();
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
  });

  test('shows success for valid JSON array', () => {
    c.querySelector('#jsonInput').value = '[1,2,3]';
    c.querySelector('#validateBtn').click();
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
  });

  test('shows error for invalid JSON', () => {
    c.querySelector('#jsonInput').value = 'not json';
    c.querySelector('#validateBtn').click();
    expect(c.querySelector('#statusOutput .alert-danger')).not.toBeNull();
  });

  test('shows warning when input is empty', () => {
    c.querySelector('#jsonInput').value = '';
    c.querySelector('#validateBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_input');
  });
});

// ─── Minify ──────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Minify', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('minifies formatted JSON (removes whitespace)', () => {
    c.querySelector('#jsonInput').value = '{\n  "a": 1,\n  "b": 2\n}';
    c.querySelector('#minifyBtn').click();
    const out = c.querySelector('#jsonOutput').value;
    expect(out).toBe('{"a":1,"b":2}');
  });

  test('shows success status after minify', () => {
    c.querySelector('#jsonInput').value = '{"x": 42}';
    c.querySelector('#minifyBtn').click();
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
  });

  test('shows error for invalid JSON on minify', () => {
    c.querySelector('#jsonInput').value = '{bad json}';
    c.querySelector('#minifyBtn').click();
    expect(c.querySelector('#statusOutput .alert-danger')).not.toBeNull();
  });

  test('shows warning when input is empty', () => {
    c.querySelector('#jsonInput').value = '';
    c.querySelector('#minifyBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_input');
  });
});

// ─── Sort Keys ───────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Sort Keys', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('sorts keys alphabetically when sort checkbox is checked', () => {
    c.querySelector('#sortKeysCheck').checked = true;
    c.querySelector('#jsonInput').value = '{"z":3,"a":1,"m":2}';
    c.querySelector('#formatBtn').click();
    const out = c.querySelector('#jsonOutput').value;
    const aPos = out.indexOf('"a"');
    const mPos = out.indexOf('"m"');
    const zPos = out.indexOf('"z"');
    expect(aPos).toBeLessThan(mPos);
    expect(mPos).toBeLessThan(zPos);
  });
});

// ─── Auto-fix ────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Auto-fix', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('auto-fix removes trailing commas', () => {
    c.querySelector('#autoFixCheck').checked = true;
    c.querySelector('#jsonInput').value = '{"a":1,}';
    c.querySelector('#formatBtn').click();
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
  });

  test('auto-fix handles True/False/Null casing', () => {
    c.querySelector('#autoFixCheck').checked = true;
    c.querySelector('#jsonInput').value = '{"a":True,"b":False,"c":Null}';
    c.querySelector('#formatBtn').click();
    expect(c.querySelector('#statusOutput .alert-success')).not.toBeNull();
    expect(c.querySelector('#jsonOutput').value).toContain('true');
    expect(c.querySelector('#jsonOutput').value).toContain('false');
    expect(c.querySelector('#jsonOutput').value).toContain('null');
  });
});

// ─── Clear ────────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Clear', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clears input and output', () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#jsonInput').value).toBe('');
    expect(c.querySelector('#jsonOutput').value).toBe('');
  });

  test('resets status to initial message after clear', () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#clearBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.status_initial');
  });
});

// ─── Load Sample ─────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Load Sample', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('loads sample JSON into input', () => {
    c.querySelector('#loadSampleBtn').click();
    const input = c.querySelector('#jsonInput').value;
    expect(input.length).toBeGreaterThan(10);
    expect(() => JSON.parse(input)).not.toThrow();
  });

  test('sample JSON is valid and contains expected keys', () => {
    c.querySelector('#loadSampleBtn').click();
    const parsed = JSON.parse(c.querySelector('#jsonInput').value);
    expect(parsed).toHaveProperty('name');
    expect(parsed).toHaveProperty('age');
  });
});

// ─── Copy ─────────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Copy', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows warning when no output to copy', async () => {
    c.querySelector('#copyBtn').click();
    await Promise.resolve();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_output_copy');
  });

  test('calls ClipboardUtils.copyToClipboard with output value', async () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#copyBtn').click();
    await new Promise(r => setTimeout(r, 10));
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(
      c.querySelector('#jsonOutput').value
    );
  });
});

// ─── Download ────────────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Download', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows warning when no output to download', () => {
    c.querySelector('#downloadBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_output_download');
  });

  test('calls DownloadUtils.downloadText with correct arguments', () => {
    c.querySelector('#jsonInput').value = '{"x":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalledWith(
      c.querySelector('#jsonOutput').value,
      'formatted.json',
      'application/json'
    );
  });
});

// ─── Path Extractor ──────────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Path Extractor', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows warning when no path entered', () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#jsonPath').value = '';
    c.querySelector('#extractPathBtn').click();
    const text = c.querySelector('#pathResult').textContent;
    expect(text).toContain('jsonFormatterValidator.enter_path');
  });

  test('shows warning when JSON not formatted first', () => {
    c.querySelector('#jsonPath').value = 'a';
    c.querySelector('#extractPathBtn').click();
    const text = c.querySelector('#pathResult').textContent;
    expect(text).toContain('jsonFormatterValidator.format_first');
  });

  test('extracts top-level value from formatted JSON', () => {
    c.querySelector('#jsonInput').value = '{"name":"Alice","age":30}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#jsonPath').value = 'name';
    c.querySelector('#extractPathBtn').click();
    expect(c.querySelector('#pathResult .alert-success')).not.toBeNull();
    expect(c.querySelector('#pathResult').textContent).toContain('Alice');
  });

  test('extracts nested value using dot notation', () => {
    c.querySelector('#jsonInput').value = '{"user":{"city":"Berlin"}}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#jsonPath').value = 'user.city';
    c.querySelector('#extractPathBtn').click();
    expect(c.querySelector('#pathResult').textContent).toContain('Berlin');
  });

  test('shows error for non-existent path', () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#formatBtn').click();
    c.querySelector('#jsonPath').value = 'x.y.z';
    c.querySelector('#extractPathBtn').click();
    const text = c.querySelector('#pathResult').textContent;
    expect(text).toContain('jsonFormatterValidator.path_not_found');
  });
});

// ─── Escape / Unescape ───────────────────────────────────────────────────────

describe('JsonFormatterValidatorTool – Escape / Unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escape: JSON-stringifies the input string', () => {
    c.querySelector('#jsonInput').value = 'Hello "World"';
    c.querySelector('#escapeBtn').click();
    const out = c.querySelector('#jsonOutput').value;
    expect(out).toBe('"Hello \\"World\\""');
  });

  test('escape: shows warning when input is empty', () => {
    c.querySelector('#jsonInput').value = '';
    c.querySelector('#escapeBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_input');
  });

  test('unescape: parses an escaped JSON string back', () => {
    c.querySelector('#jsonInput').value = '"Hello World"';
    c.querySelector('#unescapeBtn').click();
    expect(c.querySelector('#jsonOutput').value).toBe('Hello World');
  });

  test('unescape: shows error when input is not an escaped string', () => {
    c.querySelector('#jsonInput').value = '{"a":1}';
    c.querySelector('#unescapeBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.error');
  });

  test('unescape: shows warning when input is empty', () => {
    c.querySelector('#jsonInput').value = '';
    c.querySelector('#unescapeBtn').click();
    const text = c.querySelector('#statusOutput').textContent;
    expect(text).toContain('jsonFormatterValidator.no_input');
  });
});
