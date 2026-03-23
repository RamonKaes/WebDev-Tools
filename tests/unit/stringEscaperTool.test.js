'use strict';

/**
 * Unit tests for stringEscaperTool.js
 *
 * Tests cover: registration, UI rendering, escape/unescape logic for all 6 formats
 * (HTML, XML, JavaScript, JSON, SQL, CSV), auto-process, clear, copy button,
 * load sample, layout toggle, and edge cases.
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

  global.i18n = {
    t: (key) => key.split('.').pop(),
  };

  global.ClipboardUtils = {
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  global.AppHelpers = {
    escapeHtml: (str) =>
      str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;'),
  };

  require(path.join(__dirname, '../../assets/js/tools/stringEscaperTool.js'));

  tool = global.Tools._tools.stringEscaperTool;
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

function setInputAndProcess(container, inputValue, format, mode = 'escape') {
  const inputText = container.querySelector('#inputText');
  const formatSelect = container.querySelector('#escapeFormat');
  const modeEscape = container.querySelector('#modeEscape');
  const modeUnescape = container.querySelector('#modeUnescape');

  inputText.value = inputValue;
  formatSelect.value = format;

  if (mode === 'escape') {
    modeEscape.checked = true;
    modeUnescape.checked = false;
  } else {
    modeEscape.checked = false;
    modeUnescape.checked = true;
  }

  container.querySelector('#processBtn').click();

  return container.querySelector('#outputText').value;
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('stringEscaperTool – Registration', () => {
  test('registers tool under "stringEscaperTool"', () => {
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

describe('stringEscaperTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders input textarea', () => {
    expect(c.querySelector('#inputText')).not.toBeNull();
  });

  test('renders output textarea (readonly)', () => {
    const output = c.querySelector('#outputText');
    expect(output).not.toBeNull();
    expect(output.readOnly).toBe(true);
  });

  test('renders format selector with 6 options', () => {
    const select = c.querySelector('#escapeFormat');
    expect(select).not.toBeNull();
    expect(select.options.length).toBe(6);
  });

  test('format selector has all expected formats', () => {
    const values = Array.from(c.querySelector('#escapeFormat').options).map(o => o.value);
    expect(values).toEqual(['html', 'xml', 'javascript', 'json', 'sql', 'csv']);
  });

  test('renders escape/unescape radio buttons', () => {
    expect(c.querySelector('#modeEscape')).not.toBeNull();
    expect(c.querySelector('#modeUnescape')).not.toBeNull();
  });

  test('escape mode is selected by default', () => {
    expect(c.querySelector('#modeEscape').checked).toBe(true);
    expect(c.querySelector('#modeUnescape').checked).toBe(false);
  });

  test('renders process button', () => {
    expect(c.querySelector('#processBtn')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearBtn')).not.toBeNull();
  });

  test('renders load sample button', () => {
    expect(c.querySelector('#loadSampleBtn')).not.toBeNull();
  });

  test('renders copy button', () => {
    expect(c.querySelector('#copyBtn')).not.toBeNull();
  });

  test('renders auto-process checkbox (unchecked by default)', () => {
    const cb = c.querySelector('#autoProcess');
    expect(cb).not.toBeNull();
    expect(cb.checked).toBe(false);
  });

  test('renders output info element', () => {
    expect(c.querySelector('#outputInfo')).not.toBeNull();
  });

  test('renders layout toggle button', () => {
    expect(c.querySelector('#toggleLayoutBtn')).not.toBeNull();
  });
});

// ─── HTML Escape / Unescape ───────────────────────────────────────────────────

describe('stringEscaperTool – HTML escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escapes & to &amp;', () => {
    expect(setInputAndProcess(c, 'a & b', 'html')).toBe('a &amp; b');
  });

  test('escapes < to &lt;', () => {
    expect(setInputAndProcess(c, '<div>', 'html')).toBe('&lt;div&gt;');
  });

  test('escapes > to &gt;', () => {
    expect(setInputAndProcess(c, 'a > b', 'html')).toBe('a &gt; b');
  });

  test('escapes " to &quot;', () => {
    expect(setInputAndProcess(c, '"hello"', 'html')).toBe('&quot;hello&quot;');
  });

  test('escapes \' to &#039;', () => {
    expect(setInputAndProcess(c, "it's", 'html')).toBe('it&#039;s');
  });

  test('leaves plain text unchanged', () => {
    expect(setInputAndProcess(c, 'hello world', 'html')).toBe('hello world');
  });

  test('escapes multiple special chars in one string', () => {
    const result = setInputAndProcess(c, '<script>alert("xss")</script>', 'html');
    expect(result).toBe('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;');
  });
});

describe('stringEscaperTool – HTML unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('unescapes &amp; to &', () => {
    expect(setInputAndProcess(c, 'a &amp; b', 'html', 'unescape')).toBe('a & b');
  });

  test('unescapes &lt; to <', () => {
    expect(setInputAndProcess(c, '&lt;div&gt;', 'html', 'unescape')).toBe('<div>');
  });

  test('unescapes &quot; to "', () => {
    expect(setInputAndProcess(c, '&quot;hi&quot;', 'html', 'unescape')).toBe('"hi"');
  });
});

// ─── XML Escape / Unescape ────────────────────────────────────────────────────

describe('stringEscaperTool – XML escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escapes & to &amp;', () => {
    expect(setInputAndProcess(c, 'a & b', 'xml')).toBe('a &amp; b');
  });

  test('escapes < to &lt;', () => {
    expect(setInputAndProcess(c, '<tag>', 'xml')).toBe('&lt;tag&gt;');
  });

  test('escapes \' to &apos; (XML-specific)', () => {
    expect(setInputAndProcess(c, "it's", 'xml')).toBe('it&apos;s');
  });

  test('escapes " to &quot;', () => {
    expect(setInputAndProcess(c, '"val"', 'xml')).toBe('&quot;val&quot;');
  });
});

describe('stringEscaperTool – XML unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('unescapes &apos; to \'', () => {
    expect(setInputAndProcess(c, "it&apos;s", 'xml', 'unescape')).toBe("it's");
  });

  test('unescapes &amp; to &', () => {
    expect(setInputAndProcess(c, '&amp;', 'xml', 'unescape')).toBe('&');
  });

  test('unescapes &lt;&gt; to <>', () => {
    expect(setInputAndProcess(c, '&lt;tag&gt;', 'xml', 'unescape')).toBe('<tag>');
  });

  test('handles mixed entities', () => {
    expect(setInputAndProcess(c, '&lt;a href=&quot;x&quot;&gt;', 'xml', 'unescape')).toBe('<a href="x">');
  });
});

// ─── JavaScript Escape / Unescape ─────────────────────────────────────────────

describe('stringEscaperTool – JavaScript escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escapes backslash', () => {
    expect(setInputAndProcess(c, 'a\\b', 'javascript')).toBe('a\\\\b');
  });

  test('escapes single quote', () => {
    expect(setInputAndProcess(c, "it's", 'javascript')).toBe("it\\'s");
  });

  test('escapes double quote', () => {
    expect(setInputAndProcess(c, '"hello"', 'javascript')).toBe('\\"hello\\"');
  });

  test('escapes newline to \\n', () => {
    expect(setInputAndProcess(c, 'line1\nline2', 'javascript')).toBe('line1\\nline2');
  });

  test('escapes tab to \\t', () => {
    expect(setInputAndProcess(c, 'a\tb', 'javascript')).toBe('a\\tb');
  });

  test('escapes carriage return to \\n (JSDOM normalizes \\r to \\n in textarea)', () => {
    // JSDOM normalizes \r to \n when assigned to textarea.value
    expect(setInputAndProcess(c, 'a\rb', 'javascript')).toBe('a\\nb');
  });
});

describe('stringEscaperTool – JavaScript unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('unescapes \\\\  to backslash', () => {
    expect(setInputAndProcess(c, 'a\\\\b', 'javascript', 'unescape')).toBe('a\\b');
  });

  test("unescapes \\' to single quote", () => {
    expect(setInputAndProcess(c, "it\\'s", 'javascript', 'unescape')).toBe("it's");
  });

  test('unescapes \\n to newline', () => {
    expect(setInputAndProcess(c, 'line1\\nline2', 'javascript', 'unescape')).toBe('line1\nline2');
  });

  test('unescapes \\t to tab', () => {
    expect(setInputAndProcess(c, 'a\\tb', 'javascript', 'unescape')).toBe('a\tb');
  });
});

// ─── JSON Escape / Unescape ───────────────────────────────────────────────────

describe('stringEscaperTool – JSON escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('escapes double quote', () => {
    expect(setInputAndProcess(c, '"hello"', 'json')).toBe('\\"hello\\"');
  });

  test('escapes backslash', () => {
    expect(setInputAndProcess(c, 'a\\b', 'json')).toBe('a\\\\b');
  });

  test('escapes newline', () => {
    expect(setInputAndProcess(c, 'a\nb', 'json')).toBe('a\\nb');
  });

  test('escapes tab', () => {
    expect(setInputAndProcess(c, 'a\tb', 'json')).toBe('a\\tb');
  });

  test('leaves plain ASCII unchanged', () => {
    expect(setInputAndProcess(c, 'hello world', 'json')).toBe('hello world');
  });
});

describe('stringEscaperTool – JSON unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('unescapes \\" to "', () => {
    expect(setInputAndProcess(c, '\\"hello\\"', 'json', 'unescape')).toBe('"hello"');
  });

  test('unescapes \\n to newline', () => {
    expect(setInputAndProcess(c, 'a\\nb', 'json', 'unescape')).toBe('a\nb');
  });

  test('returns original string on invalid JSON escape', () => {
    // \q is not a valid JSON escape — should return original
    const result = setInputAndProcess(c, 'bad\\qescape', 'json', 'unescape');
    expect(result).toBe('bad\\qescape');
  });
});

// ─── SQL Escape / Unescape ────────────────────────────────────────────────────

describe('stringEscaperTool – SQL escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test("escapes single quote to ''", () => {
    expect(setInputAndProcess(c, "it's", 'sql')).toBe("it''s");
  });

  test('escapes multiple single quotes', () => {
    expect(setInputAndProcess(c, "can't stop won't stop", 'sql')).toBe("can''t stop won''t stop");
  });

  test('leaves string without quotes unchanged', () => {
    expect(setInputAndProcess(c, 'hello world', 'sql')).toBe('hello world');
  });

  test('handles string with only a single quote', () => {
    expect(setInputAndProcess(c, "'", 'sql')).toBe("''");
  });
});

describe('stringEscaperTool – SQL unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test("unescapes '' to single quote", () => {
    expect(setInputAndProcess(c, "it''s", 'sql', 'unescape')).toBe("it's");
  });

  test('handles multiple doubled quotes', () => {
    expect(setInputAndProcess(c, "can''t stop won''t stop", 'sql', 'unescape')).toBe("can't stop won't stop");
  });
});

// ─── CSV Escape / Unescape ────────────────────────────────────────────────────

describe('stringEscaperTool – CSV escape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('wraps field containing comma in quotes', () => {
    expect(setInputAndProcess(c, 'hello, world', 'csv')).toBe('"hello, world"');
  });

  test('wraps field containing double quote and escapes it', () => {
    expect(setInputAndProcess(c, 'say "hi"', 'csv')).toBe('"say ""hi"""');
  });

  test('wraps field containing newline', () => {
    expect(setInputAndProcess(c, 'line1\nline2', 'csv')).toBe('"line1\nline2"');
  });

  test('leaves plain field unchanged (no special chars)', () => {
    expect(setInputAndProcess(c, 'hello', 'csv')).toBe('hello');
  });
});

describe('stringEscaperTool – CSV unescape', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('removes surrounding quotes from quoted field', () => {
    expect(setInputAndProcess(c, '"hello, world"', 'csv', 'unescape')).toBe('hello, world');
  });

  test('unescapes doubled quotes', () => {
    expect(setInputAndProcess(c, '"say ""hi"""', 'csv', 'unescape')).toBe('say "hi"');
  });

  test('returns plain field unchanged (not quoted)', () => {
    expect(setInputAndProcess(c, 'hello', 'csv', 'unescape')).toBe('hello');
  });
});

// ─── Empty Input ──────────────────────────────────────────────────────────────

describe('stringEscaperTool – Empty input', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('empty input produces empty output', () => {
    c.querySelector('#inputText').value = '';
    c.querySelector('#processBtn').click();
    expect(c.querySelector('#outputText').value).toBe('');
  });

  test('whitespace-only input produces empty output', () => {
    c.querySelector('#inputText').value = '   ';
    c.querySelector('#processBtn').click();
    expect(c.querySelector('#outputText').value).toBe('');
  });

  test('outputInfo is cleared on empty input', () => {
    c.querySelector('#inputText').value = '';
    c.querySelector('#processBtn').click();
    expect(c.querySelector('#outputInfo').textContent).toBe('');
  });
});

// ─── Output Info ──────────────────────────────────────────────────────────────

describe('stringEscaperTool – Output info', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows character and byte count after processing', () => {
    setInputAndProcess(c, 'hello', 'html');
    const info = c.querySelector('#outputInfo').textContent;
    expect(info).toContain('5');
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('stringEscaperTool – Clear', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setInputAndProcess(c, '<test>', 'html');
  });
  afterEach(() => cleanup(c));

  test('clears input textarea', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#inputText').value).toBe('');
  });

  test('clears output textarea', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#outputText').value).toBe('');
  });

  test('clears output info', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#outputInfo').textContent).toBe('');
  });
});

// ─── Auto-Process ─────────────────────────────────────────────────────────────

describe('stringEscaperTool – Auto-process', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('auto-processes input when checkbox is checked', () => {
    c.querySelector('#autoProcess').checked = true;
    const inputText = c.querySelector('#inputText');
    inputText.value = '<b>';
    inputText.dispatchEvent(new Event('input', { bubbles: true }));
    expect(c.querySelector('#outputText').value).toBe('&lt;b&gt;');
  });

  test('does not auto-process when checkbox is unchecked', () => {
    c.querySelector('#autoProcess').checked = false;
    const inputText = c.querySelector('#inputText');
    inputText.value = '<b>';
    inputText.dispatchEvent(new Event('input', { bubbles: true }));
    expect(c.querySelector('#outputText').value).toBe('');
  });

  test('auto-processes when format changes with auto-process on', () => {
    const inputText = c.querySelector('#inputText');
    const formatSelect = c.querySelector('#escapeFormat');
    c.querySelector('#autoProcess').checked = true;
    inputText.value = "it's";
    inputText.dispatchEvent(new Event('input', { bubbles: true }));
    // Change format, should re-process
    formatSelect.value = 'sql';
    formatSelect.dispatchEvent(new Event('change', { bubbles: true }));
    expect(c.querySelector('#outputText').value).toBe("it''s");
  });

  test('auto-processes when mode changes with auto-process on', () => {
    c.querySelector('#autoProcess').checked = true;
    const inputText = c.querySelector('#inputText');
    inputText.value = '&lt;';
    inputText.dispatchEvent(new Event('input', { bubbles: true }));
    // Switch to unescape mode
    const modeUnescape = c.querySelector('#modeUnescape');
    modeUnescape.checked = true;
    modeUnescape.dispatchEvent(new Event('change', { bubbles: true }));
    expect(c.querySelector('#outputText').value).toBe('<');
  });
});

// ─── Load Sample ──────────────────────────────────────────────────────────────

describe('stringEscaperTool – Load Sample', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('loads escape sample text when in escape mode', () => {
    c.querySelector('#modeEscape').checked = true;
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputText').value).not.toBe('');
  });

  test('loads unescape sample text when in unescape mode', () => {
    c.querySelector('#modeEscape').checked = false;
    c.querySelector('#modeUnescape').checked = true;
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputText').value).not.toBe('');
  });

  test('escape sample contains special characters', () => {
    c.querySelector('#modeEscape').checked = true;
    c.querySelector('#loadSampleBtn').click();
    const sample = c.querySelector('#inputText').value;
    expect(sample).toContain('<');
  });
});

// ─── Copy Button ──────────────────────────────────────────────────────────────

describe('stringEscaperTool – Copy', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    global.ClipboardUtils.copyToClipboard.mockClear();
  });
  afterEach(() => cleanup(c));

  test('calls copyToClipboard with output text', () => {
    setInputAndProcess(c, '<div>', 'html');
    c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('&lt;div&gt;');
  });

  test('does not call copyToClipboard when output is empty', () => {
    c.querySelector('#outputText').value = '';
    c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});

// ─── Layout Toggle ────────────────────────────────────────────────────────────

describe('stringEscaperTool – Layout Toggle', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clicking layout toggle removes col-lg-6 (switches to stacked)', () => {
    const btn = c.querySelector('#toggleLayoutBtn');
    const cols = c.querySelectorAll('#inputOutputWrapper .row > .col-12');
    // Initially side-by-side
    expect(cols[0].classList.contains('col-lg-6')).toBe(true);
    btn.click();
    expect(cols[0].classList.contains('col-lg-6')).toBe(false);
  });

  test('clicking layout toggle twice restores side-by-side layout', () => {
    const btn = c.querySelector('#toggleLayoutBtn');
    const cols = c.querySelectorAll('#inputOutputWrapper .row > .col-12');
    btn.click();
    btn.click();
    expect(cols[0].classList.contains('col-lg-6')).toBe(true);
  });
});
