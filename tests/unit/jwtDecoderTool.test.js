'use strict';

/**
 * Unit tests for jwtDecoderTool.js
 *
 * Tests cover: registration, base64url decoding, JWT parsing,
 * decode button, clear button, load example, expiry detection,
 * error handling (empty input, invalid format), keyboard shortcut.
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

  require(path.join(__dirname, '../../assets/js/tools/jwtDecoderTool.js'));

  tool = global.Tools._tools.jwtDecoderTool;
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

// A known-good JWT: { alg: HS256, typ: JWT } / { sub: "1234567890", name: "John Doe", iat: 1516239022, exp: 1516242622 }
const EXAMPLE_JWT =
  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9' +
  '.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjE1MTYyNDI2MjJ9' +
  '.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';

// A JWT without exp claim
const JWT_NO_EXP =
  'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9' +
  '.eyJzdWIiOiJ1c2VyXzEyMyIsIm5hbWUiOiJKYW5lIERvZSJ9' +
  '.c2lnbmF0dXJl';

function decode(container, token) {
  container.querySelector('#jwtInput').value = token;
  container.querySelector('#decodeBtn').click();
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('jwtDecoderTool – Registration', () => {
  test('registers tool under "jwtDecoderTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('jwtDecoderTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders textarea input', () => {
    expect(c.querySelector('#jwtInput')).not.toBeNull();
  });

  test('renders decode button', () => {
    expect(c.querySelector('#decodeBtn')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearBtn')).not.toBeNull();
  });

  test('renders load example button', () => {
    expect(c.querySelector('#exampleBtn')).not.toBeNull();
  });

  test('results section is hidden initially', () => {
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(true);
  });

  test('error alert is hidden initially', () => {
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(true);
  });
});

// ─── Decode: Happy Path ───────────────────────────────────────────────────────

describe('jwtDecoderTool – Decode: Happy Path', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows results section after valid decode', () => {
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(false);
  });

  test('displays algorithm HS256', () => {
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#algorithmInfo').textContent).toBe('HS256');
  });

  test('header content contains "alg"', () => {
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#headerContent').innerHTML).toContain('alg');
  });

  test('payload content contains "sub"', () => {
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#payloadContent').innerHTML).toContain('sub');
  });

  test('signature content is non-empty', () => {
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#signatureContent').textContent.length).toBeGreaterThan(0);
  });

  test('displays expired status for expired token', () => {
    decode(c, EXAMPLE_JWT);
    const expiryInfo = c.querySelector('#expiryInfo').innerHTML;
    expect(expiryInfo).toContain('tools.jwtDecoderTool.expired');
  });

  test('hides error alert on successful decode', () => {
    // trigger error first, then valid decode
    decode(c, 'invalid');
    decode(c, EXAMPLE_JWT);
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(true);
  });
});

// ─── Decode: No Expiry ───────────────────────────────────────────────────────

describe('jwtDecoderTool – Decode: No Expiry Claim', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows noExpiry text when exp claim is missing', () => {
    decode(c, JWT_NO_EXP);
    expect(c.querySelector('#expiryInfo').textContent).toContain(
      'tools.jwtDecoderTool.noExpiry'
    );
  });

  test('displays algorithm RS256', () => {
    decode(c, JWT_NO_EXP);
    expect(c.querySelector('#algorithmInfo').textContent).toBe('RS256');
  });
});

// ─── Decode: Error Handling ───────────────────────────────────────────────────

describe('jwtDecoderTool – Decode: Error Handling', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows error when input is empty', () => {
    decode(c, '');
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#errorAlert').textContent).toContain(
      'tools.jwtDecoderTool.errorEmpty'
    );
  });

  test('shows error for token with only 2 parts', () => {
    decode(c, 'aaa.bbb');
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(false);
  });

  test('shows error for token with only 1 part', () => {
    decode(c, 'onlyonepart');
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(false);
  });

  test('shows error for token with invalid base64 header', () => {
    decode(c, '!!!invalid!!!.eyJzdWIiOiIxIn0.sig');
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(false);
  });

  test('hides results section on error', () => {
    decode(c, 'bad.token');
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(true);
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('jwtDecoderTool – Clear Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clear button resets input', () => {
    decode(c, EXAMPLE_JWT);
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#jwtInput').value).toBe('');
  });

  test('clear button hides results section', () => {
    decode(c, EXAMPLE_JWT);
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(true);
  });

  test('clear button hides error alert', () => {
    decode(c, '');
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#errorAlert').classList.contains('d-none')).toBe(true);
  });
});

// ─── Load Example ─────────────────────────────────────────────────────────────

describe('jwtDecoderTool – Load Example', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('loads a valid JWT into the input', () => {
    c.querySelector('#exampleBtn').click();
    const val = c.querySelector('#jwtInput').value;
    expect(val.split('.').length).toBe(3);
  });

  test('automatically decodes example JWT', () => {
    c.querySelector('#exampleBtn').click();
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(false);
  });

  test('example JWT has HS256 algorithm', () => {
    c.querySelector('#exampleBtn').click();
    expect(c.querySelector('#algorithmInfo').textContent).toBe('HS256');
  });
});

// ─── Keyboard Shortcut ────────────────────────────────────────────────────────

describe('jwtDecoderTool – Keyboard Shortcut', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('Ctrl+Enter triggers decode', () => {
    c.querySelector('#jwtInput').value = EXAMPLE_JWT;
    const event = new KeyboardEvent('keydown', { key: 'Enter', ctrlKey: true, bubbles: true });
    c.querySelector('#jwtInput').dispatchEvent(event);
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(false);
  });

  test('Enter without Ctrl does not trigger decode', () => {
    c.querySelector('#jwtInput').value = EXAMPLE_JWT;
    const event = new KeyboardEvent('keydown', { key: 'Enter', ctrlKey: false, bubbles: true });
    c.querySelector('#jwtInput').dispatchEvent(event);
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(true);
  });
});

// ─── Whitespace Trimming ──────────────────────────────────────────────────────

describe('jwtDecoderTool – Whitespace Trimming', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('trims leading/trailing whitespace before decoding', () => {
    decode(c, '  ' + EXAMPLE_JWT + '\n');
    expect(c.querySelector('#resultsSection').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#algorithmInfo').textContent).toBe('HS256');
  });
});
