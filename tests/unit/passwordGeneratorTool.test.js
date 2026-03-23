'use strict';

/**
 * Unit tests for passwordGeneratorTool.js
 *
 * Tests cover: registration, UI rendering (all 3 modes), auto-generation,
 * password generation, passphrase generation, pattern generation,
 * strength indicator, download, copy, clear, mode switching.
 */

const path = require('path');

// Mock wordlist BEFORE requiring the tool (Jest hoists jest.mock; must use string literal)
jest.mock(
  '../../assets/js/lib/wordlist.js',
  () => ({ WORDLIST: ['correct', 'horse', 'battery', 'staple', 'extra', 'test', 'alpha', 'bravo'] })
);

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.window = global;

  // Deterministic crypto.getRandomValues: fills with index * 31 + 7
  Object.defineProperty(global, 'crypto', {
    value: {
      getRandomValues: (array) => {
        for (let i = 0; i < array.length; i++) {
          array[i] = (i * 31 + 7) & 0xff;
        }
        return array;
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
    copyToClipboard: jest.fn().mockResolvedValue(true),
  };

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  require(path.join(__dirname, '../../assets/js/tools/passwordGeneratorTool.js'));

  tool = global.Tools._tools.passwordGeneratorTool;
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

function switchMode(container, mode) {
  const radio = container.querySelector(`input[value="${mode}"]`);
  radio.checked = true;
  radio.dispatchEvent(new Event('change', { bubbles: true }));
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('passwordGeneratorTool – Registration', () => {
  test('registers under "passwordGeneratorTool"', () => {
    expect(tool).toBeDefined();
  });

  test('exposes open function', () => {
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering (password mode) ────────────────────────────────────────────

describe('passwordGeneratorTool – UI Rendering (password mode)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders mode selector with 3 radio buttons', () => {
    const radios = c.querySelectorAll('input[name="generatorMode"]');
    expect(radios.length).toBe(3);
  });

  test('password mode is selected by default', () => {
    expect(c.querySelector('input[value="password"]').checked).toBe(true);
  });

  test('renders output textarea', () => {
    expect(c.querySelector('#passwordOutput')).not.toBeNull();
  });

  test('output textarea is readonly', () => {
    expect(c.querySelector('#passwordOutput').readOnly).toBe(true);
  });

  test('renders copy button', () => {
    expect(c.querySelector('#copyPasswords')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearPasswords')).not.toBeNull();
  });

  test('renders strength indicator', () => {
    expect(c.querySelector('#strengthIndicator')).not.toBeNull();
  });

  test('renders length slider', () => {
    expect(c.querySelector('#passwordLength')).not.toBeNull();
  });

  test('renders count input', () => {
    expect(c.querySelector('#passwordCount')).not.toBeNull();
  });

  test('renders generate button', () => {
    expect(c.querySelector('#generatePassword')).not.toBeNull();
  });

  test('customCharsetOptions is hidden by default (d-none)', () => {
    expect(c.querySelector('#customCharsetOptions').classList.contains('d-none')).toBe(true);
  });
});

// ─── Auto-generation (password mode) ─────────────────────────────────────────

describe('passwordGeneratorTool – Auto-generation', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('output is non-empty after open', () => {
    expect(c.querySelector('#passwordOutput').value.trim().length).toBeGreaterThan(0);
  });

  test('strength indicator shows content after open', () => {
    const si = c.querySelector('#strengthIndicator');
    expect(si.querySelector('.badge')).not.toBeNull();
  });

  test('default password length is 16', () => {
    const pw = c.querySelector('#passwordOutput').value.trim();
    expect(pw.length).toBe(16);
  });
});

// ─── generatePassword ─────────────────────────────────────────────────────────

describe('passwordGeneratorTool – generatePassword', () => {
  test('returns string of correct length', () => {
    const pw = tool.generatePassword(20, 'abc');
    expect(pw.length).toBe(20);
  });

  test('only uses characters from charset', () => {
    const charset = 'abc';
    const pw = tool.generatePassword(50, charset);
    for (const ch of pw) {
      expect(charset).toContain(ch);
    }
  });

  test('works with standard charset', () => {
    const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    const pw = tool.generatePassword(16, charset);
    expect(pw.length).toBe(16);
    for (const ch of pw) {
      expect(charset).toContain(ch);
    }
  });

  test('works with hex charset', () => {
    const charset = '0123456789abcdef';
    const pw = tool.generatePassword(8, charset);
    expect(pw).toMatch(/^[0-9a-f]{8}$/);
  });

  test('works with single-char charset', () => {
    const pw = tool.generatePassword(5, 'x');
    expect(pw).toBe('xxxxx');
  });
});

// ─── generatePattern ──────────────────────────────────────────────────────────

describe('passwordGeneratorTool – generatePattern', () => {
  test('returns string of correct length (CVVC)', () => {
    const pw = tool.generatePattern(12, 'cvvc', false);
    expect(pw.length).toBe(12);
  });

  test('returns string of correct length (CVC)', () => {
    const pw = tool.generatePattern(9, 'cvc', false);
    expect(pw.length).toBe(9);
  });

  test('capitalizes first letter when capitalize=true', () => {
    const pw = tool.generatePattern(6, 'cvc', true);
    expect(pw.charAt(0)).toMatch(/[A-Z]/);
  });

  test('does not capitalize when capitalize=false', () => {
    const pw = tool.generatePattern(6, 'cvc', false);
    expect(pw.charAt(0)).toMatch(/[a-z]/);
  });

  test('CVVC pattern only contains consonants and vowels', () => {
    const pw = tool.generatePattern(8, 'cvvc', false);
    expect(pw).toMatch(/^[a-zA-Z]+$/);
  });
});

// ─── generatePassphrase ───────────────────────────────────────────────────────

describe('passwordGeneratorTool – generatePassphrase', () => {
  test('returns a non-empty string', async () => {
    const pp = await tool.generatePassphrase(4, '-', false, false);
    expect(typeof pp).toBe('string');
    expect(pp.length).toBeGreaterThan(0);
  });

  test('contains correct word count separated by hyphen', async () => {
    const pp = await tool.generatePassphrase(4, '-', false, false);
    const parts = pp.split('-');
    expect(parts.length).toBe(4);
  });

  test('respects empty separator (no separator)', async () => {
    const pp = await tool.generatePassphrase(3, '', false, false);
    expect(pp).not.toContain('-');
    expect(pp).not.toContain(' ');
  });

  test('capitalizes words when capitalize=true', async () => {
    const pp = await tool.generatePassphrase(3, '-', true, false);
    const parts = pp.split('-');
    for (const word of parts) {
      expect(word.charAt(0)).toMatch(/[A-Z]/);
    }
  });

  test('appends number when includeNumber=true', async () => {
    const pp = await tool.generatePassphrase(3, '-', false, true);
    const parts = pp.split('-');
    const lastPart = parts[parts.length - 1];
    expect(/^\d+$/.test(lastPart)).toBe(true);
  });

  test('appended number is between 10 and 99', async () => {
    const pp = await tool.generatePassphrase(3, '-', false, true);
    const parts = pp.split('-');
    const num = parseInt(parts[parts.length - 1], 10);
    expect(num).toBeGreaterThanOrEqual(10);
    expect(num).toBeLessThanOrEqual(99);
  });

  test('uses words from wordlist only', async () => {
    const wordlist = ['correct', 'horse', 'battery', 'staple', 'extra', 'test', 'alpha', 'bravo'];
    const pp = await tool.generatePassphrase(4, '-', false, false);
    const parts = pp.split('-');
    for (const word of parts) {
      expect(wordlist).toContain(word.toLowerCase());
    }
  });
});

// ─── updateStrengthIndicator ──────────────────────────────────────────────────

describe('passwordGeneratorTool – updateStrengthIndicator', () => {
  let indicator;

  beforeEach(() => {
    indicator = document.createElement('div');
    document.body.appendChild(indicator);
  });

  afterEach(() => {
    document.body.removeChild(indicator);
  });

  test('shows placeholder for empty string', () => {
    tool.updateStrengthIndicator(indicator, '');
    expect(indicator.querySelector('p')).not.toBeNull();
  });

  test('shows very weak badge for 4-char lowercase password', () => {
    tool.updateStrengthIndicator(indicator, 'abcd');
    const badge = indicator.querySelector('.badge');
    expect(badge.classList.contains('bg-danger')).toBe(true);
  });

  test('shows progress bar for valid password', () => {
    tool.updateStrengthIndicator(indicator, 'Abc123!@#xyz');
    expect(indicator.querySelector('.progress-bar')).not.toBeNull();
  });

  test('shows strong badge for 16-char mixed password', () => {
    tool.updateStrengthIndicator(indicator, 'Abc123!@#xyzDEFG');
    const badge = indicator.querySelector('.badge');
    expect(['bg-success', 'bg-info']).toContain(badge.className.match(/bg-\w+/)[0]);
  });

  test('shows entropy value', () => {
    tool.updateStrengthIndicator(indicator, 'Abc123!xyz');
    expect(indicator.textContent).toMatch(/bits/);
  });

  test('handles non-string input gracefully', () => {
    expect(() => tool.updateStrengthIndicator(indicator, null)).not.toThrow();
  });

  test('handles missing indicator element gracefully', () => {
    expect(() => tool.updateStrengthIndicator(null, 'test')).not.toThrow();
  });
});

// ─── downloadPasswords ────────────────────────────────────────────────────────

describe('passwordGeneratorTool – downloadPasswords', () => {
  test('does nothing if content is empty', () => {
    const createObjectURL = global.URL.createObjectURL;
    tool.downloadPasswords('', 'txt');
    expect(createObjectURL).not.toHaveBeenCalled();
  });

  test('creates blob URL for txt format', () => {
    tool.downloadPasswords('password1\npassword2', 'txt');
    expect(global.URL.createObjectURL).toHaveBeenCalledTimes(1);
    expect(global.URL.revokeObjectURL).toHaveBeenCalledTimes(1);
  });

  test('creates blob URL for csv format', () => {
    jest.clearAllMocks();
    tool.downloadPasswords('password1\npassword2', 'csv');
    expect(global.URL.createObjectURL).toHaveBeenCalledTimes(1);
  });

  test('creates blob URL for json format', () => {
    jest.clearAllMocks();
    tool.downloadPasswords('password1\npassword2', 'json');
    expect(global.URL.createObjectURL).toHaveBeenCalledTimes(1);
  });
});

// ─── Mode Switching ───────────────────────────────────────────────────────────

describe('passwordGeneratorTool – Mode Switching', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('switching to passphrase mode shows word count slider', () => {
    switchMode(c, 'passphrase');
    expect(c.querySelector('#wordCount')).not.toBeNull();
  });

  test('switching to passphrase mode shows separator select', () => {
    switchMode(c, 'passphrase');
    expect(c.querySelector('#wordSeparator')).not.toBeNull();
  });

  test('switching to pattern mode shows pattern length slider', () => {
    switchMode(c, 'pattern');
    expect(c.querySelector('#patternLength')).not.toBeNull();
  });

  test('switching to pattern mode shows pattern type radios', () => {
    switchMode(c, 'pattern');
    const radios = c.querySelectorAll('input[name="patternType"]');
    expect(radios.length).toBe(2);
  });

  test('switching back to password mode restores password options', () => {
    switchMode(c, 'passphrase');
    switchMode(c, 'password');
    expect(c.querySelector('#passwordLength')).not.toBeNull();
  });
});

// ─── Copy & Clear ─────────────────────────────────────────────────────────────

describe('passwordGeneratorTool – Copy & Clear', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('copy button calls ClipboardUtils with output content', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    const textarea = c.querySelector('#passwordOutput');
    textarea.value = 'test-password';
    await c.querySelector('#copyPasswords').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('test-password');
  });

  test('clear button empties output textarea', () => {
    c.querySelector('#passwordOutput').value = 'some-password';
    c.querySelector('#clearPasswords').click();
    expect(c.querySelector('#passwordOutput').value).toBe('');
  });

  test('clear button resets strength indicator to placeholder', () => {
    c.querySelector('#clearPasswords').click();
    const si = c.querySelector('#strengthIndicator');
    expect(si.querySelector('p')).not.toBeNull();
  });
});

// ─── Custom Charset Options ───────────────────────────────────────────────────

describe('passwordGeneratorTool – Custom Charset', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('custom charset options revealed when custom preset selected', () => {
    const customRadio = c.querySelector('#charsetCustom');
    customRadio.checked = true;
    customRadio.dispatchEvent(new Event('change', { bubbles: true }));
    expect(c.querySelector('#customCharsetOptions').classList.contains('d-none')).toBe(false);
  });

  test('custom charset options re-hidden when switching back to standard', () => {
    const customRadio = c.querySelector('#charsetCustom');
    customRadio.checked = true;
    customRadio.dispatchEvent(new Event('change', { bubbles: true }));

    const standardRadio = c.querySelector('#charsetStandard');
    standardRadio.checked = true;
    standardRadio.dispatchEvent(new Event('change', { bubbles: true }));

    expect(c.querySelector('#customCharsetOptions').classList.contains('d-none')).toBe(true);
  });

  test('error message shown when no character type selected in custom mode', () => {
    const customRadio = c.querySelector('#charsetCustom');
    customRadio.checked = true;
    customRadio.dispatchEvent(new Event('change', { bubbles: true }));

    c.querySelector('#includeUppercase').checked = false;
    c.querySelector('#includeLowercase').checked = false;
    c.querySelector('#includeNumbers').checked = false;
    c.querySelector('#includeSymbols').checked = false;

    c.querySelector('#generatePassword').click();
    expect(c.querySelector('#passwordOutput').value).toContain('tools.passwordGeneratorTool.errorNoCharset');
  });
});
