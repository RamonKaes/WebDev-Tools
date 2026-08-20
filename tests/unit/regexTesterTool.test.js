'use strict';

/**
 * Unit tests for regexTesterTool.js
 *
 * Tests cover: registration, UI rendering, flag sync, testRegex via DOM,
 * XSS safety in highlightMatches, clear, copy/download button states.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.window = global;

  global.Tools = {
    _tools: {},
    register: (name, toolObj) => {
      global.Tools._tools[name] = toolObj;
    },
    open: jest.fn(),
  };

  const mockStrings = {
    'tools.regexTesterTool.matches_found': '1 match found|{count} matches found',
    'tools.regexTesterTool.placeholder_text': 'Enter a pattern and click "{button}"',
  };

  global.i18n = { t: (key, params) => {
    const str = mockStrings[key] || key;
    if (params) {
      return Object.entries(params).reduce(
        (s, [k, v]) => s.replace(`{${k}}`, String(v)),
        str
      );
    }
    return str;
  }};

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
    showToast: jest.fn(),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  require(path.join(__dirname, '../../assets/js/tools/regexTesterTool.js'));

  tool = global.Tools._tools.regexTesterTool;
});

// ─── Helpers ──────────────────────────────────────────────────────────────────

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

describe('regexTesterTool – Registration', () => {
  test('registers tool under "regexTesterTool"', () => {
    expect(tool).toBeDefined();
  });

  test('exposes open function', () => {
    expect(typeof tool.open).toBe('function');
  });

  test('exposes init function', () => {
    expect(typeof tool.init).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('regexTesterTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders regex pattern input', () => {
    expect(c.querySelector('#regexPattern')).not.toBeNull();
  });

  test('renders flags input', () => {
    expect(c.querySelector('#regexFlags')).not.toBeNull();
  });

  test('renders test string textarea', () => {
    expect(c.querySelector('#testString')).not.toBeNull();
  });

  test('renders test button', () => {
    expect(c.querySelector('#testButton')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearButton')).not.toBeNull();
  });

  test('renders copy matches button (disabled initially)', () => {
    const btn = c.querySelector('#copyMatchesButton');
    expect(btn).not.toBeNull();
    expect(btn.disabled).toBe(true);
  });

  test('renders download button (disabled initially)', () => {
    const btn = c.querySelector('#downloadButton');
    expect(btn).not.toBeNull();
    expect(btn.disabled).toBe(true);
  });

  test('renders results container', () => {
    expect(c.querySelector('#resultsContainer')).not.toBeNull();
  });

  test('renders highlighted container (hidden initially)', () => {
    const el = c.querySelector('#highlightedContainer');
    expect(el).not.toBeNull();
    expect(el.classList.contains('d-none')).toBe(true);
  });

  test('renders all 6 flag checkboxes', () => {
    const checkboxes = c.querySelectorAll('[data-flag]');
    expect(checkboxes.length).toBe(6);
  });

  test('flag checkboxes have correct data-flag values', () => {
    const flags = Array.from(c.querySelectorAll('[data-flag]')).map(cb => cb.dataset.flag);
    expect(flags).toEqual(expect.arrayContaining(['g', 'i', 'm', 's', 'u', 'y']));
  });

  test('renders toggle layout button on large screens', () => {
    expect(c.querySelector('#toggleLayoutBtn')).not.toBeNull();
  });
});

// ─── Flag Sync ────────────────────────────────────────────────────────────────

describe('regexTesterTool – Flag Sync', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('checking flag_g adds "g" to flags input', () => {
    const cb = c.querySelector('#flag_g');
    cb.checked = true;
    cb.dispatchEvent(new Event('change', { bubbles: true }));
    expect(c.querySelector('#regexFlags').value).toContain('g');
  });

  test('checking flag_i adds "i" to flags input', () => {
    const cb = c.querySelector('#flag_i');
    cb.checked = true;
    cb.dispatchEvent(new Event('change', { bubbles: true }));
    expect(c.querySelector('#regexFlags').value).toContain('i');
  });

  test('unchecking flag removes it from flags input', () => {
    const flagsInput = c.querySelector('#regexFlags');
    const cb = c.querySelector('#flag_g');
    flagsInput.value = 'gi';
    cb.checked = false;
    cb.dispatchEvent(new Event('change', { bubbles: true }));
    expect(flagsInput.value).not.toContain('g');
    expect(flagsInput.value).toContain('i');
  });

  test('typing in flags input syncs checkboxes', () => {
    const flagsInput = c.querySelector('#regexFlags');
    flagsInput.value = 'gi';
    flagsInput.dispatchEvent(new Event('input', { bubbles: true }));
    expect(c.querySelector('#flag_g').checked).toBe(true);
    expect(c.querySelector('#flag_i').checked).toBe(true);
    expect(c.querySelector('#flag_m').checked).toBe(false);
  });

  test('clearing flags input unchecks all checkboxes', () => {
    const flagsInput = c.querySelector('#regexFlags');
    flagsInput.value = '';
    flagsInput.dispatchEvent(new Event('input', { bubbles: true }));
    c.querySelectorAll('[data-flag]').forEach(cb => {
      expect(cb.checked).toBe(false);
    });
  });
});

// ─── Test Button – Successful Match ───────────────────────────────────────────

describe('regexTesterTool – Successful Match', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  function runTest(pattern, flags, testString) {
    c.querySelector('#regexPattern').value = pattern;
    c.querySelector('#regexFlags').value = flags;
    c.querySelector('#testString').value = testString;
    c.querySelector('#testButton').click();
  }

  test('shows match count alert on success', () => {
    runTest('\\d+', 'g', 'abc 123 def 456');
    const alert = c.querySelector('#resultsContainer .alert-success');
    expect(alert).not.toBeNull();
  });

  test('shows match cards for each match', () => {
    runTest('\\d+', 'g', '123 456 789');
    const cards = c.querySelectorAll('#resultsContainer .card');
    expect(cards.length).toBe(3);
  });

  test('reveals highlighted container after match', () => {
    runTest('hello', '', 'say hello world');
    expect(c.querySelector('#highlightedContainer').classList.contains('d-none')).toBe(false);
  });

  test('enables copy button after match', () => {
    runTest('\\d+', 'g', '123');
    expect(c.querySelector('#copyMatchesButton').disabled).toBe(false);
  });

  test('enables download button after match', () => {
    runTest('\\d+', 'g', '123');
    expect(c.querySelector('#downloadButton').disabled).toBe(false);
  });

  test('global flag finds all matches', () => {
    runTest('a', 'g', 'banana');
    const cards = c.querySelectorAll('#resultsContainer .card');
    expect(cards.length).toBe(3);
  });

  test('non-global flag finds only first match', () => {
    runTest('a', '', 'banana');
    const cards = c.querySelectorAll('#resultsContainer .card');
    expect(cards.length).toBe(1);
  });

  test('case-insensitive flag matches upper and lower', () => {
    runTest('hello', 'gi', 'Hello HELLO hello');
    const cards = c.querySelectorAll('#resultsContainer .card');
    expect(cards.length).toBe(3);
  });

  test('match with capture groups shows group section', () => {
    runTest('(\\d+)-(\\d+)', '', 'code: 123-456');
    const results = c.querySelector('#resultsContainer');
    expect(results.innerHTML).toContain('tools.regexTesterTool.capture_groups');
  });
});

// ─── No Match ─────────────────────────────────────────────────────────────────

describe('regexTesterTool – No Match', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows no-matches warning when pattern does not match', () => {
    c.querySelector('#regexPattern').value = 'xyz';
    c.querySelector('#testString').value = 'hello world';
    c.querySelector('#testButton').click();
    const alert = c.querySelector('#resultsContainer .alert-warning');
    expect(alert).not.toBeNull();
  });

  test('hides highlighted container on no match', () => {
    c.querySelector('#regexPattern').value = 'xyz';
    c.querySelector('#testString').value = 'hello world';
    c.querySelector('#testButton').click();
    expect(c.querySelector('#highlightedContainer').classList.contains('d-none')).toBe(true);
  });

  test('copy and download buttons remain disabled on no match', () => {
    c.querySelector('#regexPattern').value = 'xyz';
    c.querySelector('#testString').value = 'hello world';
    c.querySelector('#testButton').click();
    expect(c.querySelector('#copyMatchesButton').disabled).toBe(true);
    expect(c.querySelector('#downloadButton').disabled).toBe(true);
  });
});

// ─── Invalid Pattern ──────────────────────────────────────────────────────────

describe('regexTesterTool – Invalid Pattern', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows error alert for invalid regex', () => {
    c.querySelector('#regexPattern').value = '[invalid';
    c.querySelector('#testString').value = 'test';
    c.querySelector('#testButton').click();
    const alert = c.querySelector('#resultsContainer .alert-danger');
    expect(alert).not.toBeNull();
  });

  test('hides highlighted container on invalid pattern', () => {
    c.querySelector('#regexPattern').value = '[bad';
    c.querySelector('#testString').value = 'test';
    c.querySelector('#testButton').click();
    expect(c.querySelector('#highlightedContainer').classList.contains('d-none')).toBe(true);
  });
});

// ─── XSS Safety ───────────────────────────────────────────────────────────────

describe('regexTesterTool – XSS Safety', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escapes HTML in non-matched text segments', () => {
    c.querySelector('#regexPattern').value = 'world';
    c.querySelector('#regexFlags').value = '';
    c.querySelector('#testString').value = '<script>alert(1)</script> world';
    c.querySelector('#testButton').click();
    const pre = c.querySelector('#highlightedText');
    expect(pre.innerHTML).toContain('&lt;script&gt;');
    expect(pre.innerHTML).not.toContain('<script>');
  });

  test('escapes HTML in matched text', () => {
    c.querySelector('#regexPattern').value = '<b>';
    c.querySelector('#regexFlags').value = '';
    c.querySelector('#testString').value = 'hello <b> world';
    c.querySelector('#testButton').click();
    const pre = c.querySelector('#highlightedText');
    expect(pre.innerHTML).toContain('&lt;b&gt;');
    expect(pre.innerHTML).not.toContain('<b>');
  });

  test('escapes ampersands in test string', () => {
    c.querySelector('#regexPattern').value = 'foo';
    c.querySelector('#regexFlags').value = '';
    c.querySelector('#testString').value = 'foo & bar';
    c.querySelector('#testButton').click();
    const pre = c.querySelector('#highlightedText');
    expect(pre.innerHTML).toContain('&amp;');
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('regexTesterTool – Clear', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    // First run a test to populate state
    c.querySelector('#regexPattern').value = '\\d+';
    c.querySelector('#regexFlags').value = 'g';
    c.querySelector('#testString').value = '123 456';
    c.querySelector('#testButton').click();
  });
  afterEach(() => cleanup(c));

  test('clears pattern input', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#regexPattern').value).toBe('');
  });

  test('clears flags input', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#regexFlags').value).toBe('');
  });

  test('clears test string', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#testString').value).toBe('');
  });

  test('resets all flag checkboxes', () => {
    c.querySelector('#clearButton').click();
    c.querySelectorAll('[data-flag]').forEach(cb => {
      expect(cb.checked).toBe(false);
    });
  });

  test('hides highlighted container', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#highlightedContainer').classList.contains('d-none')).toBe(true);
  });

  test('disables copy button', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#copyMatchesButton').disabled).toBe(true);
  });

  test('disables download button', () => {
    c.querySelector('#clearButton').click();
    expect(c.querySelector('#downloadButton').disabled).toBe(true);
  });

  test('restores placeholder in results container', () => {
    c.querySelector('#clearButton').click();
    const resultsHtml = c.querySelector('#resultsContainer').innerHTML;
    expect(resultsHtml).toContain('alert-light');
  });
});

// ─── Copy Matches ─────────────────────────────────────────────────────────────

describe('regexTesterTool – Copy Matches', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    global.ClipboardUtils.copyToClipboard.mockClear();
  });
  afterEach(() => cleanup(c));

  test('calls copyToClipboard with match text', () => {
    c.querySelector('#regexPattern').value = '\\d+';
    c.querySelector('#regexFlags').value = 'g';
    c.querySelector('#testString').value = '123 456';
    c.querySelector('#testButton').click();
    c.querySelector('#copyMatchesButton').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledTimes(1);
    const arg = global.ClipboardUtils.copyToClipboard.mock.calls[0][0];
    expect(arg).toContain('123');
    expect(arg).toContain('456');
  });

  test('does not call copyToClipboard when no matches', () => {
    // Button is disabled, but ensure no copy is attempted
    expect(c.querySelector('#copyMatchesButton').disabled).toBe(true);
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});

// ─── Download Results ─────────────────────────────────────────────────────────

describe('regexTesterTool – Download Results', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    global.DownloadUtils.downloadText.mockClear();
  });
  afterEach(() => cleanup(c));

  test('calls downloadText with JSON content', () => {
    c.querySelector('#regexPattern').value = '\\d+';
    c.querySelector('#regexFlags').value = 'g';
    c.querySelector('#testString').value = '123';
    c.querySelector('#testButton').click();
    c.querySelector('#downloadButton').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalledTimes(1);
    const [content, filename] = global.DownloadUtils.downloadText.mock.calls[0];
    const parsed = JSON.parse(content);
    expect(parsed.pattern).toBe('\\d+');
    expect(parsed.matchCount).toBe(1);
    expect(parsed.matches[0].text).toBe('123');
    expect(filename).toBe('regex-test-results.json');
  });
});

// ─── Infinite Loop Prevention ─────────────────────────────────────────────────

describe('regexTesterTool – Infinite Loop Prevention', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('zero-length match pattern does not hang (e.g. a*)', () => {
    const start = Date.now();
    c.querySelector('#regexPattern').value = 'a*';
    c.querySelector('#regexFlags').value = 'g';
    c.querySelector('#testString').value = 'bbb';
    c.querySelector('#testButton').click();
    expect(Date.now() - start).toBeLessThan(1000);
  });
});

// ─── Enter Key ────────────────────────────────────────────────────────────────

describe('regexTesterTool – Keyboard Shortcuts', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('Enter on pattern input triggers test', () => {
    c.querySelector('#regexPattern').value = 'hello';
    c.querySelector('#testString').value = 'say hello';
    const event = new KeyboardEvent('keypress', { key: 'Enter', bubbles: true });
    c.querySelector('#regexPattern').dispatchEvent(event);
    const alert = c.querySelector('#resultsContainer .alert-success');
    expect(alert).not.toBeNull();
  });

  test('Ctrl+Enter on test string triggers test', () => {
    c.querySelector('#regexPattern').value = 'world';
    c.querySelector('#testString').value = 'hello world';
    const event = new KeyboardEvent('keypress', { key: 'Enter', ctrlKey: true, bubbles: true });
    c.querySelector('#testString').dispatchEvent(event);
    const alert = c.querySelector('#resultsContainer .alert-success');
    expect(alert).not.toBeNull();
  });
});
