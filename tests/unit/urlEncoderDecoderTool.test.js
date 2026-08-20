'use strict';

/**
 * Unit tests for urlEncoderDecoderTool.js
 *
 * Tests cover: registration, UI rendering, encode (component + URI mode),
 * decode (component + URI mode), line-by-line processing, mode switching,
 * URL parser, clear, load sample, copy, live mode, keyboard shortcuts,
 * and error handling.
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
    t: (key, params) => {
      const last = key.split('.').pop();
      if (params && typeof params === 'object') {
        return Object.entries(params).reduce(
          (acc, [k, v]) => acc.replace(new RegExp(`\\{${k}\\}`, 'g'), v),
          last
        );
      }
      return last;
    },
  };

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
    escapeHtml: (str) =>
      str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;'),
  };

  require(path.join(__dirname, '../../assets/js/tools/urlEncoderDecoderTool.js'));

  tool = global.Tools._tools.urlEncoderDecoder;
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

/**
 * Set encode mode, fill input, trigger process button, return output value.
 */
function encode(container, value, { mode = 'component', lineByLine = false } = {}) {
  container.querySelector('#modeEncode').click();
  container.querySelector('#input').value = value;

  if (mode === 'uri') {
    container.querySelector('#encodeURI').checked = true;
    container.querySelector('#encodeComponent').checked = false;
  } else {
    container.querySelector('#encodeComponent').checked = true;
    container.querySelector('#encodeURI').checked = false;
  }

  container.querySelector('#encodeLines').checked = lineByLine;
  container.querySelector('#processBtn').click();
  return container.querySelector('#output').value;
}

/**
 * Set decode mode, fill input, trigger process button, return output value.
 */
function decode(container, value, { mode = 'component', lineByLine = false } = {}) {
  container.querySelector('#modeDecode').click();
  container.querySelector('#input').value = value;

  if (mode === 'uri') {
    container.querySelector('#decodeURI').checked = true;
    container.querySelector('#decodeComponent').checked = false;
  } else {
    container.querySelector('#decodeComponent').checked = true;
    container.querySelector('#decodeURI').checked = false;
  }

  container.querySelector('#decodeLines').checked = lineByLine;
  container.querySelector('#processBtn').click();
  return container.querySelector('#output').value;
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Registration', () => {
  test('registers tool under "urlEncoderDecoder"', () => {
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

describe('urlEncoderDecoderTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders input textarea', () => {
    expect(c.querySelector('#input')).not.toBeNull();
  });

  test('renders output textarea', () => {
    expect(c.querySelector('#output')).not.toBeNull();
  });

  test('renders encode/decode mode radio buttons', () => {
    expect(c.querySelector('#modeEncode')).not.toBeNull();
    expect(c.querySelector('#modeDecode')).not.toBeNull();
  });

  test('encode mode is selected by default', () => {
    expect(c.querySelector('#modeEncode').checked).toBe(true);
    expect(c.querySelector('#modeDecode').checked).toBe(false);
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

  test('renders encode options panel (visible by default)', () => {
    const panel = c.querySelector('#encodeOptions');
    expect(panel).not.toBeNull();
    expect(panel.classList.contains('d-none')).toBe(false);
  });

  test('renders decode options panel (hidden by default)', () => {
    const panel = c.querySelector('#decodeOptions');
    expect(panel).not.toBeNull();
    expect(panel.classList.contains('d-none')).toBe(true);
  });

  test('encodeComponent radio checked by default', () => {
    expect(c.querySelector('#encodeComponent').checked).toBe(true);
    expect(c.querySelector('#encodeURI').checked).toBe(false);
  });

  test('renders live mode checkbox for encode', () => {
    expect(c.querySelector('#liveMode')).not.toBeNull();
  });

  test('renders encode-each-line checkbox', () => {
    expect(c.querySelector('#encodeLines')).not.toBeNull();
  });

  test('renders URL parser section', () => {
    expect(c.querySelector('#parseInput')).not.toBeNull();
    expect(c.querySelector('#parseBtn')).not.toBeNull();
    expect(c.querySelector('#parseOutput')).not.toBeNull();
  });

  test('#parseOutput is an aria-live region so parse results are announced', () => {
    expect(c.querySelector('#parseOutput').getAttribute('aria-live')).toBe('polite');
  });

  test('renders outputInfo element', () => {
    expect(c.querySelector('#outputInfo')).not.toBeNull();
  });

  test('renders modeInfo alert', () => {
    expect(c.querySelector('#modeInfo')).not.toBeNull();
  });
});

// ─── Mode Switching ───────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Mode Switching', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('switching to decode mode hides encodeOptions, shows decodeOptions', () => {
    c.querySelector('#modeDecode').click();
    expect(c.querySelector('#encodeOptions').classList.contains('d-none')).toBe(true);
    expect(c.querySelector('#decodeOptions').classList.contains('d-none')).toBe(false);
  });

  test('switching back to encode mode restores panels', () => {
    c.querySelector('#modeDecode').click();
    c.querySelector('#modeEncode').click();
    expect(c.querySelector('#encodeOptions').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#decodeOptions').classList.contains('d-none')).toBe(true);
  });

  test('switching modes clears input and output', () => {
    c.querySelector('#input').value = 'hello';
    c.querySelector('#output').value = 'world';
    c.querySelector('#modeDecode').click();
    expect(c.querySelector('#input').value).toBe('');
    expect(c.querySelector('#output').value).toBe('');
  });
});

// ─── Encode – Component Mode ──────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Encode (component mode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encodes space as %20', () => {
    expect(encode(c, 'hello world')).toBe('hello%20world');
  });

  test('encodes special chars: & = ? # /', () => {
    const result = encode(c, '&=?#/');
    expect(result).toBe('%26%3D%3F%23%2F');
  });

  test('encodes unicode: ä ö ü', () => {
    const result = encode(c, 'äöü');
    expect(result).toBe('%C3%A4%C3%B6%C3%BC');
  });

  test('encodes euro sign €', () => {
    expect(encode(c, '€')).toBe('%E2%82%AC');
  });

  test('returns empty output for empty input', () => {
    expect(encode(c, '')).toBe('');
  });

  test('outputInfo is non-empty after encoding', () => {
    encode(c, 'hello world');
    expect(c.querySelector('#outputInfo').textContent).not.toBe('');
  });
});

// ─── Encode – URI Mode ────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Encode (URI mode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('preserves colon, slash, question mark, ampersand', () => {
    const result = encode(c, 'https://example.com/path?a=1&b=2', { mode: 'uri' });
    expect(result).toBe('https://example.com/path?a=1&b=2');
  });

  test('encodes space in URI mode', () => {
    expect(encode(c, 'hello world', { mode: 'uri' })).toBe('hello%20world');
  });

  test('encodes unicode in URI mode', () => {
    expect(encode(c, 'ä', { mode: 'uri' })).toBe('%C3%A4');
  });
});

// ─── Encode – Line-by-Line ────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Encode (line-by-line)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encodes each non-empty line separately', () => {
    const input = 'hello world\nfoo bar';
    const result = encode(c, input, { lineByLine: true });
    expect(result).toBe('hello%20world\nfoo%20bar');
  });

  test('preserves empty lines', () => {
    const input = 'a\n\nb';
    const result = encode(c, input, { lineByLine: true });
    expect(result).toBe('a\n\nb');
  });

  test('encodes multiple lines without line-by-line mode as one string', () => {
    const input = 'a b\nc d';
    const result = encode(c, input, { lineByLine: false });
    expect(result).toBe('a%20b%0Ac%20d');
  });
});

// ─── Decode – Component Mode ──────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Decode (component mode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('decodes %20 to space', () => {
    expect(decode(c, 'hello%20world')).toBe('hello world');
  });

  test('decodes %26 %3D %3F %23 %2F', () => {
    expect(decode(c, '%26%3D%3F%23%2F')).toBe('&=?#/');
  });

  test('decodes unicode: %C3%A4 %C3%B6 %C3%BC', () => {
    expect(decode(c, '%C3%A4%C3%B6%C3%BC')).toBe('äöü');
  });

  test('decodes euro sign %E2%82%AC', () => {
    expect(decode(c, '%E2%82%AC')).toBe('€');
  });

  test('returns empty output for empty input', () => {
    expect(decode(c, '')).toBe('');
  });

  test('outputInfo is non-empty after decoding', () => {
    decode(c, 'hello%20world');
    expect(c.querySelector('#outputInfo').textContent).not.toBe('');
  });
});

// ─── Decode – URI Mode ────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Decode (URI mode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('decodes full encoded URL preserving structure', () => {
    const encoded = 'https://example.com/path%20name?q=hello%20world';
    const result = decode(c, encoded, { mode: 'uri' });
    expect(result).toBe('https://example.com/path name?q=hello world');
  });

  test('does not decode reserved chars like %2F in URI mode', () => {
    // decodeURI does NOT decode %2F
    expect(decode(c, '%2F', { mode: 'uri' })).toBe('%2F');
  });

  test('decodes %2F in component mode', () => {
    expect(decode(c, '%2F', { mode: 'component' })).toBe('/');
  });
});

// ─── Decode – Line-by-Line ────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Decode (line-by-line)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('decodes each non-empty line separately', () => {
    const input = 'hello%20world\nfoo%20bar';
    expect(decode(c, input, { lineByLine: true })).toBe('hello world\nfoo bar');
  });

  test('preserves empty lines', () => {
    expect(decode(c, 'a\n\nb', { lineByLine: true })).toBe('a\n\nb');
  });
});

// ─── Error Handling ───────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Error Handling', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows error and is-invalid class for malformed percent-encoding', () => {
    // "%E0%A4" is an incomplete multi-byte sequence – decodeURIComponent throws
    decode(c, '%E0%A4');
    const output = c.querySelector('#output');
    expect(output.classList.contains('is-invalid')).toBe(true);
    expect(output.value).toContain('decode_error');
  });

  test('clears is-invalid class on successful decode', () => {
    decode(c, '%E0%A4'); // cause error
    decode(c, 'hello%20world'); // should succeed
    expect(c.querySelector('#output').classList.contains('is-invalid')).toBe(false);
  });

  test('outputInfo is empty on error', () => {
    decode(c, '%E0%A4');
    expect(c.querySelector('#outputInfo').textContent).toBe('');
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Clear Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clears input and output', () => {
    encode(c, 'hello world');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#input').value).toBe('');
    expect(c.querySelector('#output').value).toBe('');
  });

  test('clears outputInfo', () => {
    encode(c, 'hello world');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#outputInfo').textContent).toBe('');
  });

  test('removes is-invalid class on clear', () => {
    decode(c, '%E0%A4');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#output').classList.contains('is-invalid')).toBe(false);
  });
});

// ─── Load Sample ──────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Load Sample', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('loads encode sample in encode mode', () => {
    c.querySelector('#modeEncode').click();
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#input').value).toContain('Hello World');
  });

  test('encode sample contains special chars', () => {
    c.querySelector('#modeEncode').click();
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#input').value).toContain('äöü');
  });

  test('loads decode sample in decode mode', () => {
    c.querySelector('#modeDecode').click();
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#input').value).toContain('%20');
  });
});

// ─── Live Mode ────────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Live Mode', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encodes automatically on input when live mode is checked', () => {
    const liveMode = c.querySelector('#liveMode');
    const input = c.querySelector('#input');
    liveMode.checked = true;
    liveMode.dispatchEvent(new Event('change'));
    input.value = 'hello world';
    input.dispatchEvent(new Event('input'));
    expect(c.querySelector('#output').value).toBe('hello%20world');
  });

  test('does not auto-encode when live mode is unchecked', () => {
    const input = c.querySelector('#input');
    c.querySelector('#liveMode').checked = false;
    input.value = 'hello world';
    input.dispatchEvent(new Event('input'));
    expect(c.querySelector('#output').value).toBe('');
  });

  test('live mode decode triggers on input', () => {
    c.querySelector('#modeDecode').click();
    const liveMode = c.querySelector('#liveModeDecode');
    const input = c.querySelector('#input');
    liveMode.checked = true;
    liveMode.dispatchEvent(new Event('change'));
    input.value = 'hello%20world';
    input.dispatchEvent(new Event('input'));
    expect(c.querySelector('#output').value).toBe('hello world');
  });
});

// ─── Copy Button ──────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Copy Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('calls ClipboardUtils.copyToClipboard with output value', async () => {
    encode(c, 'hello world');
    c.querySelector('#copyBtn').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('hello%20world');
  });

  test('does not call copyToClipboard when output is empty', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('#copyBtn').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});

// ─── Keyboard Shortcuts ───────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – Keyboard Shortcuts', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('Ctrl+Enter on input triggers process', () => {
    c.querySelector('#input').value = 'hello world';
    const event = new KeyboardEvent('keydown', { key: 'Enter', ctrlKey: true, bubbles: true });
    c.querySelector('#input').dispatchEvent(event);
    expect(c.querySelector('#output').value).toBe('hello%20world');
  });

  test('Enter on parseInput triggers parse', () => {
    const parseInput = c.querySelector('#parseInput');
    parseInput.value = 'https://example.com';
    const event = new KeyboardEvent('keydown', { key: 'Enter', bubbles: true });
    parseInput.dispatchEvent(event);
    expect(c.querySelector('#parseOutput').innerHTML).not.toBe('');
  });
});

// ─── URL Parser ───────────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – URL Parser', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  function parse(container, url) {
    container.querySelector('#parseInput').value = url;
    container.querySelector('#parseBtn').click();
    return container.querySelector('#parseOutput').innerHTML;
  }

  test('parses a full URL and shows protocol', () => {
    const html = parse(c, 'https://example.com/path?q=test#anchor');
    expect(html).toContain('https:');
  });

  test('parses hostname', () => {
    const html = parse(c, 'https://example.com/');
    expect(html).toContain('example.com');
  });

  test('parses pathname', () => {
    const html = parse(c, 'https://example.com/my/path');
    expect(html).toContain('/my/path');
  });

  test('parses query string', () => {
    const html = parse(c, 'https://example.com/?foo=bar&baz=qux');
    expect(html).toContain('foo');
    expect(html).toContain('bar');
  });

  test('parses hash', () => {
    const html = parse(c, 'https://example.com/#section');
    expect(html).toContain('#section');
  });

  test('parses port', () => {
    const html = parse(c, 'https://example.com:8080/path');
    expect(html).toContain('8080');
  });

  test('auto-prepends http:// for URL without scheme', () => {
    const html = parse(c, 'example.com/path');
    expect(html).toContain('example.com');
  });

  test('shows error for truly invalid URL', () => {
    const html = parse(c, '://invalid');
    expect(html).toContain('alert-danger');
  });

  test('shows hint when input is empty', () => {
    parse(c, '');
    expect(c.querySelector('#parseOutput').innerHTML).toContain('parser_empty');
  });

  test('escapes XSS in URL components', () => {
    const html = parse(c, 'https://example.com/?q=<script>alert(1)</script>');
    expect(html).not.toContain('<script>');
    expect(html).toContain('&lt;script&gt;');
  });

  test('shows origin row', () => {
    const html = parse(c, 'https://example.com/path');
    expect(html).toContain('https://example.com');
  });
});

// ─── ModeInfo Banner ──────────────────────────────────────────────────────────

describe('urlEncoderDecoderTool – ModeInfo Banner', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows component_info by default', () => {
    expect(c.querySelector('#modeInfo').innerHTML).toContain('component_info');
  });

  test('switches to uri_info when encodeURI selected', () => {
    c.querySelector('#encodeURI').checked = true;
    c.querySelector('#encodeURI').dispatchEvent(new Event('change'));
    expect(c.querySelector('#modeInfo').innerHTML).toContain('uri_info');
  });

  test('switches back to component_info when encodeComponent selected', () => {
    c.querySelector('#encodeURI').checked = true;
    c.querySelector('#encodeURI').dispatchEvent(new Event('change'));
    c.querySelector('#encodeComponent').checked = true;
    c.querySelector('#encodeComponent').dispatchEvent(new Event('change'));
    expect(c.querySelector('#modeInfo').innerHTML).toContain('component_info');
  });
});
