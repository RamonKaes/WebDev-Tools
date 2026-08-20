'use strict';

/**
 * Unit tests for qrCodeGeneratorTool.js
 *
 * Tests cover: registration, UI rendering, mode switching,
 * content builders (URL, Text, vCard, WiFi), WiFi escaping,
 * QR generation, download button states, and clearAll.
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

  global.i18n = { t: (key) => key };

  global.ClipboardUtils = {
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  // Mock qrcode-generator library
  global.qrcode = jest.fn(() => ({
    addData: jest.fn(),
    make: jest.fn(),
    getModuleCount: jest.fn(() => 21),
    isDark: jest.fn((row, col) => (row + col) % 2 === 0),
  }));

  // Mock canvas context
  global.HTMLCanvasElement.prototype.getContext = jest.fn(() => ({
    fillStyle: '',
    fillRect: jest.fn(),
  }));

  global.HTMLCanvasElement.prototype.toBlob = jest.fn((cb) => {
    cb(new Blob(['fake-png'], { type: 'image/png' }));
  });

  global.URL.createObjectURL = jest.fn(() => 'blob:mock-url');
  global.URL.revokeObjectURL = jest.fn();

  require(path.join(__dirname, '../../assets/js/tools/qrCodeGeneratorTool.js'));

  tool = global.Tools._tools.qrCodeGeneratorTool;
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
  // Reset tool state
  tool.currentQRCode = null;
  tool.currentMode = 'url';
  tool.currentSize = 256;
  tool.currentFgColor = '#000000';
  tool.currentBgColor = '#ffffff';
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – Registration', () => {
  test('registers tool under "qrCodeGeneratorTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });

  test('has required methods', () => {
    expect(typeof tool.generateQRCode).toBe('function');
    expect(typeof tool.downloadQRCode).toBe('function');
    expect(typeof tool.clearAll).toBe('function');
    expect(typeof tool.switchMode).toBe('function');
    expect(typeof tool.getContent).toBe('function');
    expect(typeof tool.escapeWiFi).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders mode radio buttons', () => {
    expect(c.querySelector('#mode-url')).not.toBeNull();
    expect(c.querySelector('#mode-text')).not.toBeNull();
    expect(c.querySelector('#mode-vcard')).not.toBeNull();
    expect(c.querySelector('#mode-wifi')).not.toBeNull();
  });

  test('URL mode is checked by default', () => {
    expect(c.querySelector('#mode-url').checked).toBe(true);
  });

  test('renders URL input', () => {
    expect(c.querySelector('#url-input')).not.toBeNull();
  });

  test('renders text textarea', () => {
    expect(c.querySelector('#text-input')).not.toBeNull();
  });

  test('renders vCard fields', () => {
    expect(c.querySelector('#vcard-firstname')).not.toBeNull();
    expect(c.querySelector('#vcard-lastname')).not.toBeNull();
    expect(c.querySelector('#vcard-email')).not.toBeNull();
    expect(c.querySelector('#vcard-phone')).not.toBeNull();
  });

  test('renders WiFi fields', () => {
    expect(c.querySelector('#wifi-ssid')).not.toBeNull();
    expect(c.querySelector('#wifi-password')).not.toBeNull();
    expect(c.querySelector('#wifi-encryption')).not.toBeNull();
    expect(c.querySelector('#wifi-hidden')).not.toBeNull();
  });

  test('renders color pickers', () => {
    expect(c.querySelector('#fg-color')).not.toBeNull();
    expect(c.querySelector('#bg-color')).not.toBeNull();
  });

  test('renders size select', () => {
    expect(c.querySelector('#qr-size')).not.toBeNull();
  });

  test('size select has 4 options', () => {
    expect(c.querySelector('#qr-size').options.length).toBe(4);
  });

  test('default size is 256', () => {
    expect(c.querySelector('#qr-size').value).toBe('256');
  });

  test('renders generate button', () => {
    expect(c.querySelector('#generate-btn')).not.toBeNull();
  });

  test('renders download PNG button (disabled)', () => {
    const btn = c.querySelector('#download-png-btn');
    expect(btn).not.toBeNull();
    expect(btn.disabled).toBe(true);
  });

  test('renders download SVG button (disabled)', () => {
    const btn = c.querySelector('#download-svg-btn');
    expect(btn).not.toBeNull();
    expect(btn.disabled).toBe(true);
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clear-btn')).not.toBeNull();
  });

  test('renders QR preview area', () => {
    expect(c.querySelector('#qr-preview')).not.toBeNull();
  });

  test('URL input mode visible by default', () => {
    expect(c.querySelector('#input-url').classList.contains('d-none')).toBe(false);
  });

  test('text input mode hidden by default', () => {
    expect(c.querySelector('#input-text').classList.contains('d-none')).toBe(true);
  });

  test('vCard mode hidden by default', () => {
    expect(c.querySelector('#input-vcard').classList.contains('d-none')).toBe(true);
  });

  test('WiFi mode hidden by default', () => {
    expect(c.querySelector('#input-wifi').classList.contains('d-none')).toBe(true);
  });
});

// ─── Mode Switching ───────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – Mode Switching', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('switchMode("text") shows text panel, hides others', () => {
    tool.switchMode('text');
    expect(c.querySelector('#input-text').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#input-url').classList.contains('d-none')).toBe(true);
    expect(c.querySelector('#input-vcard').classList.contains('d-none')).toBe(true);
    expect(c.querySelector('#input-wifi').classList.contains('d-none')).toBe(true);
  });

  test('switchMode("vcard") shows vcard panel, hides others', () => {
    tool.switchMode('vcard');
    expect(c.querySelector('#input-vcard').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#input-url').classList.contains('d-none')).toBe(true);
  });

  test('switchMode("wifi") shows wifi panel, hides others', () => {
    tool.switchMode('wifi');
    expect(c.querySelector('#input-wifi').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#input-url').classList.contains('d-none')).toBe(true);
  });

  test('switchMode("url") restores url panel', () => {
    tool.switchMode('text');
    tool.switchMode('url');
    expect(c.querySelector('#input-url').classList.contains('d-none')).toBe(false);
    expect(c.querySelector('#input-text').classList.contains('d-none')).toBe(true);
  });

  test('switchMode updates currentMode', () => {
    tool.switchMode('wifi');
    expect(tool.currentMode).toBe('wifi');
  });
});

// ─── Content Builders ─────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – getURLContent', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('returns URL for valid https input', () => {
    c.querySelector('#url-input').value = 'https://example.com';
    expect(tool.getURLContent(t)).toBe('https://example.com');
  });

  test('returns URL for valid http input', () => {
    c.querySelector('#url-input').value = 'http://example.com';
    expect(tool.getURLContent(t)).toBe('http://example.com');
  });

  test('returns null for empty input', () => {
    global.alert = jest.fn();
    c.querySelector('#url-input').value = '';
    expect(tool.getURLContent(t)).toBeNull();
  });

  test('returns null for invalid URL (no protocol)', () => {
    global.alert = jest.fn();
    c.querySelector('#url-input').value = 'example.com';
    expect(tool.getURLContent(t)).toBeNull();
  });

  test('returns null for ftp:// (not http/https)', () => {
    global.alert = jest.fn();
    c.querySelector('#url-input').value = 'ftp://example.com';
    expect(tool.getURLContent(t)).toBeNull();
  });
});

describe('qrCodeGeneratorTool – getTextContent', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('returns text for non-empty input', () => {
    c.querySelector('#text-input').value = 'Hello World';
    expect(tool.getTextContent(t)).toBe('Hello World');
  });

  test('trims whitespace', () => {
    c.querySelector('#text-input').value = '  trimmed  ';
    expect(tool.getTextContent(t)).toBe('trimmed');
  });

  test('returns null for empty input', () => {
    global.alert = jest.fn();
    c.querySelector('#text-input').value = '';
    expect(tool.getTextContent(t)).toBeNull();
  });
});

describe('qrCodeGeneratorTool – getVCardContent', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  function fillVCard(fields) {
    Object.entries(fields).forEach(([id, val]) => {
      const el = c.querySelector(`#${id}`);
      if (el) el.value = val;
    });
  }

  test('returns vCard string with first name only', () => {
    fillVCard({ 'vcard-firstname': 'Jane' });
    const result = tool.getVCardContent(t);
    expect(result).toContain('BEGIN:VCARD');
    expect(result).toContain('VERSION:3.0');
    expect(result).toContain('FN:Jane');
    expect(result).toContain('END:VCARD');
  });

  test('returns vCard string with full name', () => {
    fillVCard({ 'vcard-firstname': 'John', 'vcard-lastname': 'Doe' });
    const result = tool.getVCardContent(t);
    expect(result).toContain('N:Doe;John;;;');
    expect(result).toContain('FN:John Doe');
  });

  test('includes email when provided', () => {
    fillVCard({ 'vcard-firstname': 'John', 'vcard-email': 'john@example.com' });
    const result = tool.getVCardContent(t);
    expect(result).toContain('EMAIL:john@example.com');
  });

  test('includes phone when provided', () => {
    fillVCard({ 'vcard-firstname': 'John', 'vcard-phone': '+49123456' });
    const result = tool.getVCardContent(t);
    expect(result).toContain('TEL:+49123456');
  });

  test('includes address when provided', () => {
    fillVCard({ 'vcard-firstname': 'John', 'vcard-address': 'Main St', 'vcard-city': 'Berlin', 'vcard-country': 'DE' });
    const result = tool.getVCardContent(t);
    expect(result).toContain('ADR:;;Main St;Berlin;;;DE');
  });

  test('omits empty optional fields', () => {
    fillVCard({ 'vcard-firstname': 'John' });
    const result = tool.getVCardContent(t);
    expect(result).not.toContain('TEL:');
    expect(result).not.toContain('EMAIL:');
    expect(result).not.toContain('ORG:');
  });

  test('returns null when both names are empty', () => {
    global.alert = jest.fn();
    expect(tool.getVCardContent(t)).toBeNull();
  });
});

describe('qrCodeGeneratorTool – getWiFiContent', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  function fillWifi(ssid, password = '', encryption = 'WPA', hidden = false) {
    c.querySelector('#wifi-ssid').value = ssid;
    c.querySelector('#wifi-password').value = password;
    c.querySelector('#wifi-encryption').value = encryption;
    c.querySelector('#wifi-hidden').checked = hidden;
  }

  test('returns WPA wifi string', () => {
    fillWifi('MyNetwork', 'MyPass');
    const result = tool.getWiFiContent(t);
    expect(result).toBe('WIFI:T:WPA;S:MyNetwork;P:MyPass;H:false;;');
  });

  test('omits password for nopass encryption', () => {
    fillWifi('OpenNet', 'ignored', 'nopass');
    const result = tool.getWiFiContent(t);
    expect(result).toBe('WIFI:T:nopass;S:OpenNet;H:false;;');
  });

  test('marks hidden network', () => {
    fillWifi('HiddenNet', 'pass', 'WPA', true);
    const result = tool.getWiFiContent(t);
    expect(result).toContain('H:true');
  });

  test('returns null when SSID is empty', () => {
    global.alert = jest.fn();
    fillWifi('');
    expect(tool.getWiFiContent(t)).toBeNull();
  });

  test('WEP encryption', () => {
    fillWifi('Net', 'pass123', 'WEP');
    const result = tool.getWiFiContent(t);
    expect(result).toContain('T:WEP');
    expect(result).toContain('P:pass123');
  });
});

// ─── WiFi Escaping ────────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – escapeWiFi', () => {
  test('escapes backslash', () => {
    expect(tool.escapeWiFi('a\\b')).toBe('a\\\\b');
  });

  test('escapes semicolon', () => {
    expect(tool.escapeWiFi('a;b')).toBe('a\\;b');
  });

  test('escapes comma', () => {
    expect(tool.escapeWiFi('a,b')).toBe('a\\,b');
  });

  test('escapes double quote', () => {
    expect(tool.escapeWiFi('a"b')).toBe('a\\"b');
  });

  test('escapes colon', () => {
    expect(tool.escapeWiFi('a:b')).toBe('a\\:b');
  });

  test('leaves regular characters unchanged', () => {
    expect(tool.escapeWiFi('MyNetwork123')).toBe('MyNetwork123');
  });

  test('escapes multiple special chars', () => {
    expect(tool.escapeWiFi('a;b:c')).toBe('a\\;b\\:c');
  });
});

// ─── QR Generation & Button States ───────────────────────────────────────────

describe('qrCodeGeneratorTool – generateQRCode', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => {
    c = openTool();
    global.alert = jest.fn();
  });
  afterEach(() => cleanup(c));

  test('enables download buttons after successful generation', () => {
    tool.switchMode('url');
    c.querySelector('#url-input').value = 'https://example.com';
    tool.generateQRCode(t);
    expect(c.querySelector('#download-png-btn').disabled).toBe(false);
    expect(c.querySelector('#download-svg-btn').disabled).toBe(false);
  });

  test('stores currentQRCode after generation', () => {
    tool.switchMode('url');
    c.querySelector('#url-input').value = 'https://example.com';
    tool.generateQRCode(t);
    expect(tool.currentQRCode).not.toBeNull();
    expect(tool.currentQRCode.qr).toBeDefined();
    expect(tool.currentQRCode.canvas).toBeDefined();
  });

  test('appends canvas to preview', () => {
    tool.switchMode('url');
    c.querySelector('#url-input').value = 'https://example.com';
    tool.generateQRCode(t);
    expect(c.querySelector('#qr-preview canvas')).not.toBeNull();
  });

  test('gives the canvas a text alternative naming the encoded content', () => {
    tool.switchMode('url');
    c.querySelector('#url-input').value = 'https://example.com';
    tool.generateQRCode(t);

    const canvas = c.querySelector('#qr-preview canvas');
    expect(canvas.getAttribute('role')).toBe('img');
    expect(canvas.getAttribute('aria-label')).toBeTruthy();
  });

  test('preview region announces the generated code', () => {
    expect(c.querySelector('#qr-preview').getAttribute('aria-live')).toBe('polite');
  });

  test('does not generate for empty URL', () => {
    tool.switchMode('url');
    c.querySelector('#url-input').value = '';
    tool.generateQRCode(t);
    expect(tool.currentQRCode).toBeNull();
    expect(c.querySelector('#download-png-btn').disabled).toBe(true);
  });

  test('generates from text content', () => {
    tool.switchMode('text');
    c.querySelector('#text-input').value = 'Hello QR';
    tool.generateQRCode(t);
    expect(tool.currentQRCode).not.toBeNull();
  });
});

// ─── Clear All ────────────────────────────────────────────────────────────────

describe('qrCodeGeneratorTool – clearAll', () => {
  let c;
  const t = (key) => key;
  beforeEach(() => {
    c = openTool();
    // Generate a QR first
    tool.switchMode('url');
    c.querySelector('#url-input').value = 'https://example.com';
    tool.generateQRCode(t);
  });
  afterEach(() => cleanup(c));

  test('disables download buttons after clear', () => {
    tool.clearAll(t);
    expect(c.querySelector('#download-png-btn').disabled).toBe(true);
    expect(c.querySelector('#download-svg-btn').disabled).toBe(true);
  });

  test('resets currentQRCode to null', () => {
    tool.clearAll(t);
    expect(tool.currentQRCode).toBeNull();
  });

  test('clears URL input', () => {
    c.querySelector('#url-input').value = 'https://example.com';
    tool.clearAll(t);
    expect(c.querySelector('#url-input').value).toBe('');
  });

  test('clears text input', () => {
    c.querySelector('#text-input').value = 'some text';
    tool.clearAll(t);
    expect(c.querySelector('#text-input').value).toBe('');
  });

  test('clears vCard fields', () => {
    c.querySelector('#vcard-firstname').value = 'John';
    tool.clearAll(t);
    expect(c.querySelector('#vcard-firstname').value).toBe('');
  });

  test('clears WiFi fields', () => {
    c.querySelector('#wifi-ssid').value = 'MyNet';
    tool.clearAll(t);
    expect(c.querySelector('#wifi-ssid').value).toBe('');
  });

  test('removes canvas from preview', () => {
    tool.clearAll(t);
    expect(c.querySelector('#qr-preview canvas')).toBeNull();
  });
});
