'use strict';

/**
 * Unit tests for hashGeneratorTool.js
 *
 * Tests cover: CryptoUtils (bufferToHex, bufferToBase64, stringToBuffer),
 * tool registration, UI rendering (all 5 modes), text hashing, file hashing,
 * HMAC, hash comparison, uppercase toggle.
 */

const path = require('path');

let tool = null;

// ─── Web Crypto API mock ──────────────────────────────────────────────────────

/**
 * Deterministic fake digest: XORs each byte of the input into a fixed-size buffer
 * matching the real algorithm's output length.
 */
function fakeDigest(algorithm, data) {
  const sizes = { 'SHA-1': 20, 'SHA-256': 32, 'SHA-384': 48, 'SHA-512': 64 };
  const len = sizes[algorithm] || 32;
  const bytes = new Uint8Array(data instanceof ArrayBuffer ? data : new ArrayBuffer(0));
  const result = new Uint8Array(len);
  bytes.forEach((b, i) => { result[i % len] ^= b; });
  return Promise.resolve(result.buffer);
}

async function fakeImportKey(_format, _keyData, algorithm, _extractable, _usages) {
  return { algorithm };
}

function fakeSign(_algorithm, _key, data) {
  return fakeDigest('SHA-256', data instanceof ArrayBuffer ? data : new ArrayBuffer(0));
}

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  // jsdom may define window.crypto as non-writable — use defineProperty
  Object.defineProperty(global, 'crypto', {
    value: {
      subtle: {
        digest: jest.fn(fakeDigest),
        importKey: jest.fn(fakeImportKey),
        sign: jest.fn(fakeSign),
      },
    },
    writable: true,
    configurable: true,
  });

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

  global.AppHelpers = {
    escapeHtml: (s) => String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;'),
  };

  require(path.join(__dirname, '../../assets/js/tools/hashGeneratorTool.js'));

  tool = global.Tools._tools.hashGeneratorTool;
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

function switchMode(container, value) {
  const radio = container.querySelector(`input[name="hashMode"][value="${value}"]`);
  radio.checked = true;
  radio.dispatchEvent(new Event('change'));
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('HashGeneratorTool – Registration', () => {
  test('registers tool under "hashGeneratorTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI rendering ─────────────────────────────────────────────────────────────

describe('HashGeneratorTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders mode selector with all 5 modes', () => {
    expect(c.querySelector('input[name="hashMode"][value="text"]')).not.toBeNull();
    expect(c.querySelector('input[name="hashMode"][value="file"]')).not.toBeNull();
    expect(c.querySelector('input[name="hashMode"][value="hmac"]')).not.toBeNull();
    expect(c.querySelector('input[name="hashMode"][value="sri"]')).not.toBeNull();
    expect(c.querySelector('input[name="hashMode"][value="compare"]')).not.toBeNull();
  });

  test('default mode is text: renders textarea #textInput', () => {
    expect(c.querySelector('#textInput')).not.toBeNull();
  });

  test('switching to file mode renders #fileInput', () => {
    switchMode(c, 'file');
    expect(c.querySelector('#fileInput')).not.toBeNull();
  });

  test('switching to hmac mode renders #hmacText and #hmacSecret', () => {
    switchMode(c, 'hmac');
    expect(c.querySelector('#hmacText')).not.toBeNull();
    expect(c.querySelector('#hmacSecret')).not.toBeNull();
  });

  test('switching to sri mode renders #sriURL', () => {
    switchMode(c, 'sri');
    expect(c.querySelector('#sriURL')).not.toBeNull();
  });

  test('switching to compare mode renders #hash1 and #hash2', () => {
    switchMode(c, 'compare');
    expect(c.querySelector('#hash1')).not.toBeNull();
    expect(c.querySelector('#hash2')).not.toBeNull();
  });

  test('switching modes clears #hashResults', () => {
    c.querySelector('#hashResults').innerHTML = '<p>stale content</p>';
    switchMode(c, 'file');
    expect(c.querySelector('#hashResults').innerHTML).toBe('');
  });
});

// ─── CryptoUtils ─────────────────────────────────────────────────────────────

describe('HashGeneratorTool – CryptoUtils', () => {
  test('bufferToHex converts ArrayBuffer to lowercase hex string', () => {
    const buf = new Uint8Array([0x00, 0x0f, 0xff, 0xab]).buffer;
    expect(global.CryptoUtils.bufferToHex(buf)).toBe('000fffab');
  });

  test('bufferToHex pads single-digit bytes with leading zero', () => {
    const buf = new Uint8Array([0x01]).buffer;
    expect(global.CryptoUtils.bufferToHex(buf)).toBe('01');
  });

  test('bufferToBase64 converts ArrayBuffer to Base64 string', () => {
    const buf = new Uint8Array([72, 101, 108, 108, 111]).buffer; // "Hello"
    expect(global.CryptoUtils.bufferToBase64(buf)).toBe('SGVsbG8=');
  });

  test('stringToBuffer encodes ASCII string to UTF-8 bytes', () => {
    const buf = global.CryptoUtils.stringToBuffer('Hi');
    const bytes = new Uint8Array(buf);
    expect(bytes[0]).toBe(72);  // 'H'
    expect(bytes[1]).toBe(105); // 'i'
  });

  test('isSupported returns true when crypto.subtle is available', () => {
    expect(global.CryptoUtils.isSupported()).toBeTruthy();
  });
});

// ─── Text hashing ─────────────────────────────────────────────────────────────

describe('HashGeneratorTool – Text Hashing', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates hash and shows result element .hash-output', async () => {
    c.querySelector('#textInput').value = 'hello';
    c.querySelector('#generateHash').click();
    await new Promise(r => setTimeout(r, 10));
    expect(c.querySelector('#hashResults .hash-output')).not.toBeNull();
  });

  test('shows warning when no text is entered', async () => {
    c.querySelector('#textInput').value = '';
    c.querySelector('#generateHash').click();
    await Promise.resolve();
    expect(c.querySelector('#hashResults .alert-warning')).not.toBeNull();
  });

  test('shows warning when no algorithm is selected', async () => {
    c.querySelector('#textInput').value = 'test';
    c.querySelectorAll('input[type="checkbox"][id^="algo"]').forEach(cb => { cb.checked = false; });
    c.querySelector('#generateHash').click();
    await Promise.resolve();
    expect(c.querySelector('#hashResults .alert-warning')).not.toBeNull();
  });

  test('uppercase toggle converts hash output to uppercase', async () => {
    c.querySelector('#textInput').value = 'hello';
    c.querySelector('#generateHash').click();
    await new Promise(r => setTimeout(r, 10));

    const toggle = c.querySelector('#uppercaseToggle');
    toggle.checked = true;
    toggle.dispatchEvent(new Event('change'));

    c.querySelectorAll('.hash-output').forEach(el => {
      expect(el.value).toBe(el.value.toUpperCase());
    });
  });

  test('lowercase toggle converts hash output back to lowercase', async () => {
    c.querySelector('#textInput').value = 'hello';
    c.querySelector('#generateHash').click();
    await new Promise(r => setTimeout(r, 10));

    const toggle = c.querySelector('#uppercaseToggle');
    toggle.checked = true;
    toggle.dispatchEvent(new Event('change'));

    toggle.checked = false;
    toggle.dispatchEvent(new Event('change'));

    c.querySelectorAll('.hash-output').forEach(el => {
      expect(el.value).toBe(el.value.toLowerCase());
    });
  });
});

// ─── HMAC ────────────────────────────────────────────────────────────────────

describe('HashGeneratorTool – HMAC', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    switchMode(c, 'hmac');
  });
  afterEach(() => cleanup(c));

  test('generates HMAC and shows .hash-output', async () => {
    c.querySelector('#hmacText').value = 'message';
    c.querySelector('#hmacSecret').value = 'secret';
    c.querySelector('#generateHMAC').click();
    await new Promise(r => setTimeout(r, 10));
    expect(c.querySelector('#hashResults .hash-output')).not.toBeNull();
  });

  test('shows warning when both text and secret are empty', async () => {
    c.querySelector('#hmacText').value = '';
    c.querySelector('#hmacSecret').value = '';
    c.querySelector('#generateHMAC').click();
    await Promise.resolve();
    expect(c.querySelector('#hashResults .alert-warning')).not.toBeNull();
  });

  test('shows warning when secret key is missing', async () => {
    c.querySelector('#hmacText').value = 'message';
    c.querySelector('#hmacSecret').value = '';
    c.querySelector('#generateHMAC').click();
    await Promise.resolve();
    expect(c.querySelector('#hashResults .alert-warning')).not.toBeNull();
  });
});

// ─── Hash Comparison ─────────────────────────────────────────────────────────

describe('HashGeneratorTool – Hash Comparison', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    switchMode(c, 'compare');
  });
  afterEach(() => cleanup(c));

  test('#compareResult is an aria-live region once compare mode is rendered', () => {
    const el = c.querySelector('#compareResult');
    expect(el).not.toBeNull();
    expect(el.getAttribute('aria-live')).toBe('polite');
  });

  test('matching hashes shows success alert', () => {
    c.querySelector('#hash1').value = 'abc123';
    c.querySelector('#hash2').value = 'abc123';
    c.querySelector('#compareHashes').click();
    expect(c.querySelector('#compareResult .alert-success')).not.toBeNull();
  });

  test('mismatched hashes shows danger alert', () => {
    c.querySelector('#hash1').value = 'abc123';
    c.querySelector('#hash2').value = 'xyz789';
    c.querySelector('#compareHashes').click();
    expect(c.querySelector('#compareResult .alert-danger')).not.toBeNull();
  });

  test('comparison is case-insensitive', () => {
    c.querySelector('#hash1').value = 'ABC123';
    c.querySelector('#hash2').value = 'abc123';
    c.querySelector('#compareHashes').click();
    expect(c.querySelector('#compareResult .alert-success')).not.toBeNull();
  });

  test('shows warning when both fields are empty', () => {
    c.querySelector('#hash1').value = '';
    c.querySelector('#hash2').value = '';
    c.querySelector('#compareHashes').click();
    expect(c.querySelector('#compareResult .alert-warning')).not.toBeNull();
  });

  test('mismatched result displays length of both hashes', () => {
    c.querySelector('#hash1').value = 'aabbcc';       // 6 chars
    c.querySelector('#hash2').value = 'aabbccddeeff'; // 12 chars
    c.querySelector('#compareHashes').click();
    const text = c.querySelector('#compareResult').textContent;
    expect(text).toContain('6');
    expect(text).toContain('12');
  });
});
