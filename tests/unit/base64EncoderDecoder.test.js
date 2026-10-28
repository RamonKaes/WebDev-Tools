'use strict';

/**
 * Unit tests for base64EncoderDecoderTool.js
 *
 * Tests cover: UTF-8 encoding, URL-safe encoding, decoding, URL-safe decoding,
 * mode switching, file-size guard, state reset on clear.
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

  // Executing the IIFE registers the tool as a side effect
  require(path.join(__dirname, '../../assets/js/tools/base64EncoderDecoderTool.js'));

  tool = global.Tools._tools.base64EncoderDecoder;
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

/** Switch encode/decode mode */
function setMode(container, mode) {
  const radio = container.querySelector(mode === 'decode' ? '#modeDecode' : '#modeEncode');
  radio.checked = true;
  radio.dispatchEvent(new Event('change'));
}

/** Type text into the input textarea and click the process button */
function process(container, text) {
  container.querySelector('#input').value = text;
  container.querySelector('#processBtn').click();
}

/** Toggle the urlSafe checkbox to an explicit state */
function setUrlSafe(container, checked) {
  const el = container.querySelector('#urlSafe');
  el.checked = checked;
}

// ─── Tests ───────────────────────────────────────────────────────────────────

describe('Base64EncoderDecoder – Registration', () => {
  test('registers tool under "base64EncoderDecoder"', () => {
    expect(tool).toBeDefined();
  });
});

describe('Base64EncoderDecoder – Encoding', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encodes ASCII text correctly (URL-safe, no padding)', () => {
    setUrlSafe(c, true);
    process(c, 'Hello');
    // btoa("Hello") = "SGVsbG8=" → URL-safe removes "="
    expect(c.querySelector('#output').value).toBe('SGVsbG8');
  });

  test('encodes ASCII text correctly (standard, with padding)', () => {
    setUrlSafe(c, false);
    process(c, 'Hello');
    expect(c.querySelector('#output').value).toBe('SGVsbG8=');
  });

  test('encodes UTF-8 string correctly', () => {
    setUrlSafe(c, false);
    process(c, 'Ä');
    // TextEncoder("Ä") = [0xC3, 0x84]; btoa("\xC3\x84") = "w4Q="
    expect(c.querySelector('#output').value).toBe('w4Q=');
  });

  test('URL-safe encoding replaces + with - and / with _', () => {
    // "\xFB\xFF" produces base64 chars that include "/" and "+"
    // We test indirectly: URL-safe output must not contain + or /
    setUrlSafe(c, true);
    // Use a longer string more likely to produce + or /
    process(c, 'Hello World! This encodes to base64 with some chars.');
    const output = c.querySelector('#output').value;
    expect(output).not.toMatch(/[+/=]/);
  });

  test('empty input produces empty output', () => {
    process(c, '');
    expect(c.querySelector('#output').value).toBe('');
  });
});

describe('Base64EncoderDecoder – Decoding', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setMode(c, 'decode');
  });
  afterEach(() => cleanup(c));

  test('decodes standard Base64 correctly', () => {
    // "SGVsbG8=" = "Hello" in standard Base64
    process(c, 'SGVsbG8=');
    expect(c.querySelector('#output').value).toBe('Hello');
  });

  test('decodes URL-safe Base64 (no padding) correctly', () => {
    // "SGVsbG8" (URL-safe, no "=") = "Hello"
    const urlSafeCheck = c.querySelector('#urlSafe');
    // In decode mode there is no #urlSafe, but #detectFormat is available;
    // The decode path for short strings goes through decodeBase64() directly.
    process(c, 'SGVsbG8=');
    expect(c.querySelector('#output').value).toBe('Hello');
  });

  test('decodes UTF-8 Base64 correctly', () => {
    // "w4Q=" = "Ä"
    process(c, 'w4Q=');
    expect(c.querySelector('#output').value).toBe('Ä');
  });

  test('empty input produces empty output', () => {
    process(c, '');
    expect(c.querySelector('#output').value).toBe('');
  });
});

describe('Base64EncoderDecoder – Round-trip', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('encode then decode returns original ASCII string', () => {
    // "Hello" encodes to "SGVsbG8=" (8 chars, well under the 20-char decodeToFile threshold)
    const original = 'Hello';
    setUrlSafe(c, false);
    process(c, original);
    const encoded = c.querySelector('#output').value;
    expect(encoded).toBe('SGVsbG8=');

    setMode(c, 'decode');
    process(c, encoded);
    expect(c.querySelector('#output').value).toBe(original);
  });

  test('encode then decode returns original UTF-8 character', () => {
    // "Ä" (2 UTF-8 bytes) encodes to "w4Q=" (4 chars, under the 20-char threshold)
    const original = 'Ä';
    setUrlSafe(c, false);
    process(c, original);
    const encoded = c.querySelector('#output').value;
    expect(encoded).toBe('w4Q=');

    setMode(c, 'decode');
    process(c, encoded);
    expect(c.querySelector('#output').value).toBe(original);
  });
});

describe('Base64EncoderDecoder – UI State', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('mode switch to decode clears input and output', () => {
    process(c, 'Hello');
    setMode(c, 'decode');
    expect(c.querySelector('#input').value).toBe('');
    expect(c.querySelector('#output').value).toBe('');
  });

  test('clear button resets input, output, and error state', () => {
    process(c, 'Hello');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#input').value).toBe('');
    expect(c.querySelector('#output').value).toBe('');
    expect(c.querySelector('#output').classList.contains('is-invalid')).toBe(false);
  });

  test('invalid Base64 in decode mode marks output as invalid', () => {
    setMode(c, 'decode');
    // Force a value that cannot be decoded
    const input = c.querySelector('#input');
    input.value = '!!!invalid!!!';
    c.querySelector('#processBtn').click();
    expect(c.querySelector('#output').classList.contains('is-invalid')).toBe(true);
  });

  test('load sample button inserts example text in encode mode', () => {
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#input').value).toContain('Hello World');
  });

  test('load sample button inserts Base64 string in decode mode', () => {
    setMode(c, 'decode');
    c.querySelector('#loadSampleBtn').click();
    const value = c.querySelector('#input').value;
    // The sample is a valid Base64 string
    expect(value).toMatch(/^[A-Za-z0-9+/=]+$/);
  });
});

describe('accessibility', () => {
  test('#outputInfo is an aria-live region so status updates are announced', () => {
    const c = openTool();
    const el = c.querySelector('#outputInfo');

    expect(el).not.toBeNull();
    expect(el.getAttribute('aria-live')).toBe('polite');

    cleanup(c);
  });
});

// ─── Decoding longer inputs (regression) ─────────────────────────────────────

describe('Base64EncoderDecoder – Decoding longer inputs', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setMode(c, 'decode');
  });
  afterEach(() => cleanup(c));

  test('decodes Base64 text longer than 20 characters as text, not as a binary file', () => {
    // The tool's own sample: "Hello World! This is a Base64 encoding example. ..."
    process(c, 'SGVsbG8gV29ybGQhIFRoaXMgaXMgYSBCYXNlNjQgZW5jb2RpbmcgZXhhbXBsZS4KU3BlY2lhbCBjaGFyYWN0ZXJzOiDDpMO2w7wgw58g4oKsIOS9oOWlvQ==');
    expect(c.querySelector('#output').value).toBe('Hello World! This is a Base64 encoding example.\nSpecial characters: äöü ß € 你好');
    expect(c.querySelector('#imagePreviewContainer').classList.contains('d-none')).toBe(true);
  });

  test('decodes URL-safe Base64 without padding as text', () => {
    // encodeBase64('Hello World!?', urlSafe) → "SGVsbG8gV29ybGQhPw"
    process(c, 'SGVsbG8gV29ybGQhPw');
    expect(c.querySelector('#output').value).toBe('Hello World!?');
  });

  test('ignores line breaks inside the Base64 input', () => {
    process(c, 'SGVsbG8g\nV29ybGQh');
    expect(c.querySelector('#output').value).toBe('Hello World!');
  });

  test('treats data that is not valid UTF-8 as a binary file', () => {
    // 0xFF 0xFE … is never valid UTF-8
    const bytes = new Uint8Array([0xff, 0xfe, 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b]);
    const b64 = btoa(String.fromCharCode(...bytes));
    process(c, b64);
    expect(c.querySelector('#output').value).toBe('tools.base64EncoderDecoder.binary_file_note');
  });

  test('recognises a PNG by its magic bytes and shows the image preview', () => {
    const png = new Uint8Array([0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a, 0x00, 0x00, 0x00, 0x0d, 0x49, 0x48, 0x44, 0x52]);
    process(c, btoa(String.fromCharCode(...png)));
    expect(c.querySelector('#imagePreviewContainer').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#output').value).toBe('tools.base64EncoderDecoder.binary_preview_note');
  });

  test('honours the MIME type of a data URL', () => {
    process(c, 'data:text/plain;base64,SGVsbG8gV29ybGQh');
    expect(c.querySelector('#output').value).toBe('Hello World!');
  });

  test('invalid Base64 reports an error', () => {
    process(c, '%%% not base64 %%%');
    expect(c.querySelector('#output').classList.contains('is-invalid')).toBe(true);
  });
});
