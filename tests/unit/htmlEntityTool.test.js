'use strict';

/**
 * Unit tests for htmlEntityTool.js
 *
 * Tests cover: named entity encoding, numeric decimal encoding, hex encoding,
 * all-named encoding (including newlines), decoding, mode switching,
 * auto-convert, load sample, clear, copy, download.
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

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  require(path.join(__dirname, '../../assets/js/tools/htmlEntityTool.js'));

  tool = global.Tools._tools.htmlEntityTool;
});

// ─── Helpers ──────────────────────────────────────────────────────────────────

function openTool() {
  const container = document.createElement('div');
  document.body.appendChild(container);
  tool.open(container);
  return container;
}

function cleanup(container) {
  document.body.removeChild(container);
}

function setMode(container, mode) {
  const radio = container.querySelector(mode === 'decode' ? '#modeDecode' : '#modeEncode');
  radio.checked = true;
  radio.dispatchEvent(new Event('change'));
}

function setEntityType(container, value) {
  const select = container.querySelector('#entityType');
  select.value = value;
  select.dispatchEvent(new Event('change'));
}

function convert(container, text) {
  container.querySelector('#inputText').value = text;
  container.querySelector('#convertBtn').click();
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('htmlEntityTool – Registration', () => {
  test('registers tool under "htmlEntityTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── Encoding: Named Entities ─────────────────────────────────────────────────

describe('htmlEntityTool – Encode: Named Entities', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setEntityType(c, 'named');
  });
  afterEach(() => cleanup(c));

  test('encodes < > & " \' to named entities', () => {
    convert(c, '<div class="test" id=\'x\'>A & B</div>');
    const output = c.querySelector('#outputText').value;
    expect(output).toContain('&lt;');
    expect(output).toContain('&gt;');
    expect(output).toContain('&amp;');
    expect(output).toContain('&quot;');
    expect(output).toContain('&apos;');
  });

  test('does not encode regular alphanumeric characters', () => {
    convert(c, 'Hello World 123');
    expect(c.querySelector('#outputText').value).toBe('Hello World 123');
  });

  test('empty input produces empty output', () => {
    convert(c, '');
    expect(c.querySelector('#outputText').value).toBe('');
  });
});

// ─── Encoding: Numeric Decimal ────────────────────────────────────────────────

describe('htmlEntityTool – Encode: Numeric Decimal', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setEntityType(c, 'numeric');
  });
  afterEach(() => cleanup(c));

  test('encodes < as &#60;', () => {
    convert(c, '<');
    expect(c.querySelector('#outputText').value).toBe('&#60;');
  });

  test('encodes & as &#38;', () => {
    convert(c, '&');
    expect(c.querySelector('#outputText').value).toBe('&#38;');
  });

  test('encodes © as &#169;', () => {
    convert(c, '©');
    expect(c.querySelector('#outputText').value).toBe('&#169;');
  });
});

// ─── Encoding: Numeric Hex ────────────────────────────────────────────────────

describe('htmlEntityTool – Encode: Numeric Hex', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setEntityType(c, 'hex');
  });
  afterEach(() => cleanup(c));

  test('encodes < as &#x3c;', () => {
    convert(c, '<');
    expect(c.querySelector('#outputText').value).toBe('&#x3c;');
  });

  test('encodes & as &#x26;', () => {
    convert(c, '&');
    expect(c.querySelector('#outputText').value).toBe('&#x26;');
  });
});

// ─── Encoding: All Named ──────────────────────────────────────────────────────

describe('htmlEntityTool – Encode: All Named', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setEntityType(c, 'all');
  });
  afterEach(() => cleanup(c));

  test('encodes © to &copy;', () => {
    convert(c, '©');
    expect(c.querySelector('#outputText').value).toBe('&copy;');
  });

  test('encodes € to &euro;', () => {
    convert(c, '€');
    expect(c.querySelector('#outputText').value).toBe('&euro;');
  });

  test('preserves newlines (\\n) in output', () => {
    convert(c, 'line1\nline2');
    const output = c.querySelector('#outputText').value;
    expect(output).toContain('\n');
    expect(output).toBe('line1\nline2');
  });
});

// ─── Decoding ─────────────────────────────────────────────────────────────────

describe('htmlEntityTool – Decode', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setMode(c, 'decode');
  });
  afterEach(() => cleanup(c));

  test('decodes &lt; to <', () => {
    convert(c, '&lt;');
    expect(c.querySelector('#outputText').value).toBe('<');
  });

  test('decodes &amp; to &', () => {
    convert(c, '&amp;');
    expect(c.querySelector('#outputText').value).toBe('&');
  });

  test('decodes &#169; to ©', () => {
    convert(c, '&#169;');
    expect(c.querySelector('#outputText').value).toBe('©');
  });

  test('decodes &#xA9; to ©', () => {
    convert(c, '&#xA9;');
    expect(c.querySelector('#outputText').value).toBe('©');
  });

  test('decodes &copy; to ©', () => {
    convert(c, '&copy;');
    expect(c.querySelector('#outputText').value).toBe('©');
  });

  test('empty input produces empty output', () => {
    convert(c, '');
    expect(c.querySelector('#outputText').value).toBe('');
  });
});

// ─── Round-trip ───────────────────────────────────────────────────────────────

describe('htmlEntityTool – Round-trip', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encode then decode returns original string', () => {
    const original = '<div class="test">Hello & World © 2024</div>';
    setEntityType(c, 'named');
    convert(c, original);
    const encoded = c.querySelector('#outputText').value;
    expect(encoded).not.toBe(original);

    setMode(c, 'decode');
    convert(c, encoded);
    expect(c.querySelector('#outputText').value).toBe(original);
  });
});

// ─── UI State ─────────────────────────────────────────────────────────────────

describe('htmlEntityTool – UI State', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('decode mode hides entity type selector', () => {
    setMode(c, 'decode');
    const wrapper = c.querySelector('#entityTypeWrapper');
    expect(wrapper.style.display).toBe('none');
  });

  test('encode mode shows entity type selector', () => {
    setMode(c, 'decode');
    setMode(c, 'encode');
    const wrapper = c.querySelector('#entityTypeWrapper');
    expect(wrapper.style.display).toBe('block');
  });

  test('clear button resets input and output', () => {
    convert(c, '<test>');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#inputText').value).toBe('');
    expect(c.querySelector('#outputText').value).toBe('');
  });

  test('auto-convert triggers on input', () => {
    const input = c.querySelector('#inputText');
    input.value = '<';
    input.dispatchEvent(new Event('input'));
    expect(c.querySelector('#outputText').value).toContain('&lt;');
  });

  test('load sample (encode mode) inserts HTML snippet', () => {
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputText').value).toContain('<div');
  });

  test('load sample (decode mode) inserts entity-encoded snippet', () => {
    setMode(c, 'decode');
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputText').value).toContain('&lt;');
  });

  test('stats display character count', () => {
    convert(c, 'abc');
    expect(c.querySelector('#inputStats').textContent).toContain('3');
  });
});

// ─── Copy & Download ──────────────────────────────────────────────────────────

describe('htmlEntityTool – Copy & Download', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('copy button calls ClipboardUtils.copyToClipboard with output', async () => {
    convert(c, '<test>');
    await c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(
      expect.stringContaining('&lt;')
    );
  });

  test('copy button does nothing when output is empty', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });

  test('download button calls DownloadUtils.downloadText with output', () => {
    global.DownloadUtils.downloadText.mockClear();
    convert(c, '<test>');
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalledWith(
      expect.stringContaining('&lt;'),
      'html-entities.txt'
    );
  });

  test('download button does nothing when output is empty', () => {
    global.DownloadUtils.downloadText.mockClear();
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).not.toHaveBeenCalled();
  });
});

describe('accessibility', () => {
  test('#outputStats is an aria-live region so status updates are announced', () => {
    const c = openTool();
    const el = c.querySelector('#outputStats');

    expect(el).not.toBeNull();
    expect(el.getAttribute('aria-live')).toBe('polite');

    cleanup(c);
  });
});
