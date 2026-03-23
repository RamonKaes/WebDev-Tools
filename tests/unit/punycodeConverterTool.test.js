'use strict';

/**
 * Unit tests for punycodeConverterTool.js
 *
 * Tests cover: registration, UI rendering, encoding (Unicode→Punycode),
 * decoding (Punycode→Unicode), auto-detection, example loading,
 * clear, copy, download, manual convert, and stats.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.window = global;

  global.Tools = {
    _tools: {},
    register: (name, toolObj) => { global.Tools._tools[name] = toolObj; },
    open: jest.fn(),
  };

  global.i18n = { t: (key) => key };

  global.ClipboardUtils = {
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  require(path.join(__dirname, '../../assets/js/tools/punycodeConverterTool.js'));

  tool = global.Tools._tools.punycodeConverterTool;
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

function setInput(container, value) {
  const input = container.querySelector('#inputText');
  input.value = value;
  input.dispatchEvent(new Event('input', { bubbles: true }));
}

function getOutput(container) {
  return container.querySelector('#outputText').value;
}

function switchMode(container, mode) {
  const radio = container.querySelector(`#mode${mode.charAt(0).toUpperCase() + mode.slice(1)}`);
  radio.checked = true;
  radio.dispatchEvent(new Event('change', { bubbles: true }));
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('punycodeConverterTool – Registration', () => {
  test('registers under "punycodeConverterTool"', () => {
    expect(tool).toBeDefined();
  });

  test('exposes open function', () => {
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('punycodeConverterTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders input textarea', () => {
    expect(c.querySelector('#inputText')).not.toBeNull();
  });

  test('renders output textarea', () => {
    expect(c.querySelector('#outputText')).not.toBeNull();
  });

  test('output textarea is readonly', () => {
    expect(c.querySelector('#outputText').readOnly).toBe(true);
  });

  test('renders 3 mode radio buttons', () => {
    expect(c.querySelectorAll('input[name="mode"]').length).toBe(3);
  });

  test('encode mode is selected by default', () => {
    expect(c.querySelector('#modeEncode').checked).toBe(true);
  });

  test('auto-convert checkbox is checked by default', () => {
    expect(c.querySelector('#autoConvert').checked).toBe(true);
  });

  test('renders convert button', () => {
    expect(c.querySelector('#convertBtn')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearBtn')).not.toBeNull();
  });

  test('renders example button', () => {
    expect(c.querySelector('#exampleBtn')).not.toBeNull();
  });

  test('renders copy button', () => {
    expect(c.querySelector('#copyBtn')).not.toBeNull();
  });

  test('renders download button', () => {
    expect(c.querySelector('#downloadBtn')).not.toBeNull();
  });
});

// ─── Encoding: Unicode → Punycode ─────────────────────────────────────────────

describe('punycodeConverterTool – Encoding (Unicode → Punycode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encodes münchen.de → xn--mnchen-3ya.de', () => {
    setInput(c, 'münchen.de');
    expect(getOutput(c)).toBe('xn--mnchen-3ya.de');
  });

  test('encodes zürich.ch → xn--zrich-kva.ch', () => {
    setInput(c, 'zürich.ch');
    expect(getOutput(c)).toBe('xn--zrich-kva.ch');
  });

  test('leaves ASCII-only domain unchanged', () => {
    setInput(c, 'example.com');
    expect(getOutput(c)).toBe('example.com');
  });

  test('empty input produces empty output', () => {
    setInput(c, '');
    expect(getOutput(c)).toBe('');
  });

  test('encodes multiple domains line by line', () => {
    setInput(c, 'münchen.de\nzürich.ch');
    const lines = getOutput(c).split('\n');
    expect(lines[0]).toBe('xn--mnchen-3ya.de');
    expect(lines[1]).toBe('xn--zrich-kva.ch');
  });
});

// ─── Decoding: Punycode → Unicode ─────────────────────────────────────────────

describe('punycodeConverterTool – Decoding (Punycode → Unicode)', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    switchMode(c, 'Decode');
  });
  afterEach(() => cleanup(c));

  test('decodes xn--mnchen-3ya.de → münchen.de', () => {
    setInput(c, 'xn--mnchen-3ya.de');
    expect(getOutput(c)).toBe('münchen.de');
  });

  test('decodes xn--zrich-kva.ch → zürich.ch', () => {
    setInput(c, 'xn--zrich-kva.ch');
    expect(getOutput(c)).toBe('zürich.ch');
  });

  test('leaves ASCII-only domain unchanged in decode mode', () => {
    setInput(c, 'example.com');
    expect(getOutput(c)).toBe('example.com');
  });
});

// ─── Auto-detection ───────────────────────────────────────────────────────────

describe('punycodeConverterTool – Auto-detection', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    switchMode(c, 'Auto');
  });
  afterEach(() => cleanup(c));

  test('auto-detects Punycode input and decodes', () => {
    setInput(c, 'xn--mnchen-3ya.de');
    expect(getOutput(c)).toBe('münchen.de');
  });

  test('auto-detects Unicode input and encodes', () => {
    setInput(c, 'münchen.de');
    expect(getOutput(c)).toBe('xn--mnchen-3ya.de');
  });
});

// ─── Example Button ───────────────────────────────────────────────────────────

describe('punycodeConverterTool – Example Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('loads example domains into input', () => {
    c.querySelector('#exampleBtn').click();
    expect(c.querySelector('#inputText').value).toContain('münchen.de');
  });

  test('produces non-empty output after loading examples', () => {
    c.querySelector('#exampleBtn').click();
    expect(getOutput(c).length).toBeGreaterThan(0);
  });

  test('encodes münchen.de in example output', () => {
    c.querySelector('#exampleBtn').click();
    expect(getOutput(c)).toContain('xn--mnchen-3ya.de');
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('punycodeConverterTool – Clear Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clears input and output', () => {
    setInput(c, 'münchen.de');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#inputText').value).toBe('');
    expect(getOutput(c)).toBe('');
  });

  test('resets input stats to 0', () => {
    setInput(c, 'münchen.de');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#inputStats').textContent).toContain('0');
  });
});

// ─── Manual Convert (autoConvert off) ─────────────────────────────────────────

describe('punycodeConverterTool – Manual Convert', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    const auto = c.querySelector('#autoConvert');
    auto.checked = false;
    auto.dispatchEvent(new Event('change', { bubbles: true }));
  });
  afterEach(() => cleanup(c));

  test('does not auto-convert on input', () => {
    c.querySelector('#inputText').value = 'münchen.de';
    c.querySelector('#inputText').dispatchEvent(new Event('input', { bubbles: true }));
    expect(getOutput(c)).toBe('');
  });

  test('converts on convert button click', () => {
    c.querySelector('#inputText').value = 'münchen.de';
    c.querySelector('#convertBtn').click();
    expect(getOutput(c)).toBe('xn--mnchen-3ya.de');
  });
});

// ─── Copy Button ──────────────────────────────────────────────────────────────

describe('punycodeConverterTool – Copy Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('calls ClipboardUtils.copyToClipboard with output value', async () => {
    setInput(c, 'münchen.de');
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('#copyBtn').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('xn--mnchen-3ya.de');
  });

  test('does not call copyToClipboard when output is empty', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('#copyBtn').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});

// ─── Download Button ──────────────────────────────────────────────────────────

describe('punycodeConverterTool – Download Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('calls DownloadUtils.downloadText when output is non-empty', () => {
    setInput(c, 'münchen.de');
    global.DownloadUtils.downloadText.mockClear();
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalled();
  });

  test('does not call DownloadUtils.downloadText when output is empty', () => {
    global.DownloadUtils.downloadText.mockClear();
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).not.toHaveBeenCalled();
  });
});

// ─── Stats ────────────────────────────────────────────────────────────────────

describe('punycodeConverterTool – Stats', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows input character count after typing', () => {
    setInput(c, 'münchen.de');
    expect(c.querySelector('#inputStats').textContent).toContain('10');
  });

  test('shows output character count after conversion', () => {
    setInput(c, 'münchen.de');
    expect(c.querySelector('#outputStats').textContent).toContain('17');
  });
});
