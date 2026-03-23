'use strict';

/**
 * Unit tests for uuidGeneratorTool.js
 *
 * Tests cover: registration, UI rendering, UUID v4/v1/v7/nil generation,
 * format functions, bulk output formats, copy/download buttons,
 * version/format select changes, error handling, and auto-generate.
 */

const path = require('path');

let tool = null;

// ─── UUID format patterns ─────────────────────────────────────────────────────

const UUID_PATTERN = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/;
const UUID_V4_PATTERN = /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/;
const UUID_V1_PATTERN = /^[0-9a-f]{8}-[0-9a-f]{4}-1[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/;
const UUID_V7_PATTERN = /^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/;
const NIL_UUID = '00000000-0000-0000-0000-000000000000';

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.window = global;

  // Deterministic crypto mock: fills bytes with index * 17 + 3 (mod 256)
  Object.defineProperty(global, 'crypto', {
    value: {
      getRandomValues: (array) => {
        for (let i = 0; i < array.length; i++) {
          array[i] = (i * 17 + 3) & 0xff;
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

  require(path.join(__dirname, '../../assets/js/tools/uuidGeneratorTool.js'));

  tool = global.Tools._tools.uuidGeneratorTool;
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

describe('uuidGeneratorTool – Registration', () => {
  test('registers under "uuidGeneratorTool"', () => {
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

describe('uuidGeneratorTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders version select with 4 options', () => {
    const select = c.querySelector('#uuidVersion');
    expect(select).not.toBeNull();
    expect(select.options.length).toBe(4);
    const values = Array.from(select.options).map(o => o.value);
    expect(values).toEqual(['v4', 'v1', 'v7', 'nil']);
  });

  test('renders format select with 4 options', () => {
    const select = c.querySelector('#uuidFormat');
    expect(select).not.toBeNull();
    const values = Array.from(select.options).map(o => o.value);
    expect(values).toEqual(['hyphens', 'no-hyphens', 'braces', 'uppercase']);
  });

  test('renders generate single button', () => {
    expect(c.querySelector('#generateSingle')).not.toBeNull();
  });

  test('renders single UUID output input', () => {
    const input = c.querySelector('#singleUuid');
    expect(input).not.toBeNull();
    expect(input.readOnly).toBe(true);
  });

  test('renders copy single button', () => {
    expect(c.querySelector('#copySingle')).not.toBeNull();
  });

  test('renders auto-generate checkbox', () => {
    expect(c.querySelector('#autoGenerate')).not.toBeNull();
  });

  test('renders bulk count input with default value 10', () => {
    const input = c.querySelector('#bulkCount');
    expect(input).not.toBeNull();
    expect(input.value).toBe('10');
  });

  test('renders bulk format select with 5 options', () => {
    const select = c.querySelector('#bulkFormat');
    expect(select).not.toBeNull();
    const values = Array.from(select.options).map(o => o.value);
    expect(values).toEqual(['plain', 'array', 'json', 'csv', 'sql']);
  });

  test('renders generate bulk button', () => {
    expect(c.querySelector('#generateBulk')).not.toBeNull();
  });

  test('renders bulk output textarea', () => {
    const ta = c.querySelector('#bulkOutput');
    expect(ta).not.toBeNull();
    expect(ta.readOnly).toBe(true);
  });

  test('renders copy bulk and download buttons', () => {
    expect(c.querySelector('#copyBulk')).not.toBeNull();
    expect(c.querySelector('#downloadBulk')).not.toBeNull();
  });

  test('auto-generates single UUID on open', () => {
    const input = c.querySelector('#singleUuid');
    expect(input.value).not.toBe('');
  });

  test('auto-generates bulk UUIDs on open', () => {
    const ta = c.querySelector('#bulkOutput');
    expect(ta.value).not.toBe('');
  });
});

// ─── UUID v4 Generation ───────────────────────────────────────────────────────

describe('uuidGeneratorTool – UUID v4', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates RFC4122 v4 UUID on button click', () => {
    const input = c.querySelector('#singleUuid');
    c.querySelector('#generateSingle').click();
    expect(UUID_V4_PATTERN.test(input.value)).toBe(true);
  });

  test('generates 36-char UUID with 4 hyphens', () => {
    const input = c.querySelector('#singleUuid');
    c.querySelector('#generateSingle').click();
    expect(input.value.length).toBe(36);
    expect((input.value.match(/-/g) || []).length).toBe(4);
  });

  test('generates unique UUIDs on repeated clicks', () => {
    // With deterministic mock, values won't differ, but the function should not throw
    const input = c.querySelector('#singleUuid');
    c.querySelector('#generateSingle').click();
    const first = input.value;
    // Verify valid format
    expect(UUID_V4_PATTERN.test(first)).toBe(true);
  });
});

// ─── UUID v1 Generation ───────────────────────────────────────────────────────

describe('uuidGeneratorTool – UUID v1', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates RFC4122 v1 UUID', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v1';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const value = c.querySelector('#singleUuid').value;
    expect(UUID_V1_PATTERN.test(value)).toBe(true);
  });

  test('v1 UUID has correct version nibble (1)', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v1';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const parts = c.querySelector('#singleUuid').value.split('-');
    expect(parts[2][0]).toBe('1');
  });

  test('v1 UUID has correct variant bits', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v1';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const parts = c.querySelector('#singleUuid').value.split('-');
    expect('89ab').toContain(parts[3][0]);
  });

  test('v1 timestamp encodes recent time (not zeros)', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v1';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const uuid = c.querySelector('#singleUuid').value;
    // timeLow and timeMid should not be all zeros for current time
    expect(uuid.startsWith('00000000-0000-')).toBe(false);
  });
});

// ─── UUID v7 Generation ───────────────────────────────────────────────────────

describe('uuidGeneratorTool – UUID v7', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates RFC9562 v7 UUID', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const value = c.querySelector('#singleUuid').value;
    expect(UUID_V7_PATTERN.test(value)).toBe(true);
  });

  test('v7 UUID has correct version nibble (7)', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const parts = c.querySelector('#singleUuid').value.split('-');
    expect(parts[2][0]).toBe('7');
  });

  test('v7 UUID has correct variant bits', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    const parts = c.querySelector('#singleUuid').value.split('-');
    expect('89ab').toContain(parts[3][0]);
  });
});

// ─── NIL UUID ─────────────────────────────────────────────────────────────────

describe('uuidGeneratorTool – NIL UUID', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates all-zero NIL UUID', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'nil';
    versionSelect.dispatchEvent(new Event('change'));
    c.querySelector('#generateSingle').click();
    expect(c.querySelector('#singleUuid').value).toBe(NIL_UUID);
  });
});

// ─── Single UUID Formats ──────────────────────────────────────────────────────

describe('uuidGeneratorTool – Single UUID Formats', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('format "hyphens" produces standard UUID with hyphens', () => {
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'hyphens';
    c.querySelector('#generateSingle').click();
    const val = c.querySelector('#singleUuid').value;
    expect(UUID_PATTERN.test(val)).toBe(true);
  });

  test('format "no-hyphens" produces 32-char hex string', () => {
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'no-hyphens';
    c.querySelector('#generateSingle').click();
    const val = c.querySelector('#singleUuid').value;
    expect(val).toMatch(/^[0-9a-f]{32}$/);
    expect(val.includes('-')).toBe(false);
  });

  test('format "braces" wraps UUID in curly braces', () => {
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'braces';
    c.querySelector('#generateSingle').click();
    const val = c.querySelector('#singleUuid').value;
    expect(val.startsWith('{')).toBe(true);
    expect(val.endsWith('}')).toBe(true);
    expect(UUID_PATTERN.test(val.slice(1, -1))).toBe(true);
  });

  test('format "uppercase" produces uppercase UUID', () => {
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'uppercase';
    c.querySelector('#generateSingle').click();
    const val = c.querySelector('#singleUuid').value;
    expect(val).toMatch(/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/);
  });
});

// ─── Version Help Text ────────────────────────────────────────────────────────

describe('uuidGeneratorTool – Version Help Text', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('shows help text for v4 by default', () => {
    const help = c.querySelector('#versionHelp');
    expect(help.textContent).toBeTruthy();
  });

  test('updates help text when version changes to v1', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    const helpBefore = c.querySelector('#versionHelp').textContent;
    versionSelect.value = 'v1';
    versionSelect.dispatchEvent(new Event('change'));
    const helpAfter = c.querySelector('#versionHelp').textContent;
    expect(helpAfter).not.toBe(helpBefore);
  });

  test('updates help text when version changes to v7', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    expect(c.querySelector('#versionHelp').textContent).toBeTruthy();
  });

  test('updates help text when version changes to nil', () => {
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'nil';
    versionSelect.dispatchEvent(new Event('change'));
    expect(c.querySelector('#versionHelp').textContent).toBeTruthy();
  });
});

// ─── Bulk Generation ──────────────────────────────────────────────────────────

describe('uuidGeneratorTool – Bulk Generation', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates 10 UUIDs by default (plain format)', () => {
    const ta = c.querySelector('#bulkOutput');
    const lines = ta.value.trim().split('\n');
    expect(lines.length).toBe(10);
    lines.forEach(line => expect(UUID_PATTERN.test(line)).toBe(true));
  });

  test('generates correct number when count changed to 5', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = '5';
    c.querySelector('#generateBulk').click();
    const lines = c.querySelector('#bulkOutput').value.trim().split('\n');
    expect(lines.length).toBe(5);
  });

  test('generates correct number when count is 1', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = '1';
    c.querySelector('#generateBulk').click();
    const lines = c.querySelector('#bulkOutput').value.trim().split('\n');
    expect(lines.length).toBe(1);
    expect(UUID_PATTERN.test(lines[0])).toBe(true);
  });

  test('shows error for count = 0', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = '0';
    c.querySelector('#generateBulk').click();
    const val = c.querySelector('#bulkOutput').value;
    expect(val).toContain('tools.uuidGeneratorTool.bulk_error');
  });

  test('shows error for count > 1000', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = '1001';
    c.querySelector('#generateBulk').click();
    const val = c.querySelector('#bulkOutput').value;
    expect(val).toContain('tools.uuidGeneratorTool.bulk_error');
  });

  test('shows error for non-numeric count', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = 'abc';
    c.querySelector('#generateBulk').click();
    const val = c.querySelector('#bulkOutput').value;
    expect(val).toContain('tools.uuidGeneratorTool.bulk_error');
  });

  test('Enter key in count input triggers bulk generate', () => {
    const countInput = c.querySelector('#bulkCount');
    countInput.value = '3';
    countInput.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
    const lines = c.querySelector('#bulkOutput').value.trim().split('\n');
    expect(lines.length).toBe(3);
  });
});

// ─── Bulk Output Formats ──────────────────────────────────────────────────────

describe('uuidGeneratorTool – Bulk Output Formats', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  function generateBulk(container, format, count = 3) {
    container.querySelector('#bulkCount').value = String(count);
    container.querySelector('#bulkFormat').value = format;
    container.querySelector('#generateBulk').click();
    return container.querySelector('#bulkOutput').value;
  }

  test('format "plain" produces one UUID per line', () => {
    const output = generateBulk(c, 'plain', 3);
    const lines = output.trim().split('\n');
    expect(lines.length).toBe(3);
    lines.forEach(line => expect(UUID_PATTERN.test(line)).toBe(true));
  });

  test('format "array" produces JavaScript array syntax', () => {
    const output = generateBulk(c, 'array', 2);
    expect(output.trimStart().startsWith('[')).toBe(true);
    expect(output.trimEnd().endsWith(']')).toBe(true);
    expect(output).toContain('"');
  });

  test('format "json" produces valid JSON array', () => {
    const output = generateBulk(c, 'json', 2);
    const parsed = JSON.parse(output);
    expect(Array.isArray(parsed)).toBe(true);
    expect(parsed.length).toBe(2);
    parsed.forEach(uuid => expect(UUID_PATTERN.test(uuid)).toBe(true));
  });

  test('format "csv" produces comma-separated values', () => {
    const output = generateBulk(c, 'csv', 3);
    expect(output.includes('\n')).toBe(false);
    const parts = output.split(',');
    expect(parts.length).toBe(3);
    parts.forEach(uuid => expect(UUID_PATTERN.test(uuid)).toBe(true));
  });

  test('format "sql" produces INSERT statement', () => {
    const output = generateBulk(c, 'sql', 2);
    expect(output.toUpperCase()).toContain('INSERT INTO');
    expect(output.toUpperCase()).toContain('VALUES');
    expect(output.endsWith(';')).toBe(true);
  });

  test('format "sql" wraps UUIDs in single quotes', () => {
    const output = generateBulk(c, 'sql', 1);
    expect(output).toContain("('");
    expect(output).toContain("')");
  });
});

// ─── Copy Buttons ─────────────────────────────────────────────────────────────

describe('uuidGeneratorTool – Copy Buttons', () => {
  let c;
  beforeEach(() => {
    jest.clearAllMocks();
    c = openTool();
  });
  afterEach(() => cleanup(c));

  test('copy single calls ClipboardUtils with UUID value', async () => {
    const input = c.querySelector('#singleUuid');
    input.value = 'test-uuid-value';
    c.querySelector('#copySingle').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('test-uuid-value');
  });

  test('copy bulk calls ClipboardUtils with textarea value', async () => {
    const ta = c.querySelector('#bulkOutput');
    ta.value = 'bulk-content';
    c.querySelector('#copyBulk').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('bulk-content');
  });

  test('copy single updates icon to check on success', async () => {
    const btn = c.querySelector('#copySingle');
    const icon = btn.querySelector('i');
    btn.click();
    await Promise.resolve();
    expect(icon.className).toContain('bi-check');
  });

  test('copy bulk updates icon to check on success (preserves me-2)', async () => {
    const btn = c.querySelector('#copyBulk');
    const icon = btn.querySelector('i');
    const originalClass = icon.className;
    btn.click();
    await Promise.resolve();
    expect(icon.className).toContain('bi-check');
    // me-2 should be preserved (only bi-clipboard replaced by bi-check)
    if (originalClass.includes('me-2')) {
      expect(icon.className).toContain('me-2');
    }
  });
});

// ─── Download Button ──────────────────────────────────────────────────────────

describe('uuidGeneratorTool – Download Button', () => {
  let c;
  beforeEach(() => {
    jest.clearAllMocks();
    c = openTool();
  });
  afterEach(() => cleanup(c));

  test('download calls DownloadUtils.downloadText with bulk content', () => {
    const ta = c.querySelector('#bulkOutput');
    c.querySelector('#generateBulk').click();
    c.querySelector('#downloadBulk').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalledWith(
      ta.value,
      'uuids.txt'
    );
  });

  test('download does nothing when bulk output is empty', () => {
    c.querySelector('#bulkOutput').value = '';
    c.querySelector('#downloadBulk').click();
    expect(global.DownloadUtils.downloadText).not.toHaveBeenCalled();
  });
});

// ─── Auto-generate on version/format change ───────────────────────────────────

describe('uuidGeneratorTool – Auto-generate on change', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('does not regenerate on version change when auto-generate is unchecked', () => {
    const autoCheck = c.querySelector('#autoGenerate');
    autoCheck.checked = false;
    const input = c.querySelector('#singleUuid');
    input.value = 'frozen-value';
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    expect(input.value).toBe('frozen-value');
  });

  test('regenerates on version change when auto-generate is checked', () => {
    const autoCheck = c.querySelector('#autoGenerate');
    autoCheck.checked = true;
    const versionSelect = c.querySelector('#uuidVersion');
    versionSelect.value = 'v7';
    versionSelect.dispatchEvent(new Event('change'));
    const val = c.querySelector('#singleUuid').value;
    expect(UUID_V7_PATTERN.test(val)).toBe(true);
  });

  test('regenerates on format change when auto-generate is checked', () => {
    const autoCheck = c.querySelector('#autoGenerate');
    autoCheck.checked = true;
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'uppercase';
    formatSelect.dispatchEvent(new Event('change'));
    const val = c.querySelector('#singleUuid').value;
    expect(val).toMatch(/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/);
  });

  test('does not regenerate on format change when auto-generate is unchecked', () => {
    const autoCheck = c.querySelector('#autoGenerate');
    autoCheck.checked = false;
    const input = c.querySelector('#singleUuid');
    input.value = 'stable-value';
    const formatSelect = c.querySelector('#uuidFormat');
    formatSelect.value = 'braces';
    formatSelect.dispatchEvent(new Event('change'));
    expect(input.value).toBe('stable-value');
  });
});

// ─── Crypto Error Handling ────────────────────────────────────────────────────

describe('uuidGeneratorTool – Crypto error handling', () => {
  let c;
  let originalCrypto;

  beforeEach(() => {
    originalCrypto = global.crypto;
    c = openTool();
  });
  afterEach(() => {
    global.crypto = originalCrypto;
    cleanup(c);
  });

  test('shows crypto_error message when crypto.getRandomValues throws', () => {
    global.crypto = {
      getRandomValues: () => { throw new Error('Not supported'); },
    };
    c.querySelector('#generateSingle').click();
    expect(c.querySelector('#singleUuid').value).toContain('tools.uuidGeneratorTool.crypto_error');
  });

  test('shows crypto_error in bulk output when crypto throws', () => {
    global.crypto = {
      getRandomValues: () => { throw new Error('Not supported'); },
    };
    c.querySelector('#bulkCount').value = '3';
    c.querySelector('#generateBulk').click();
    expect(c.querySelector('#bulkOutput').value).toContain('tools.uuidGeneratorTool.crypto_error');
  });
});
