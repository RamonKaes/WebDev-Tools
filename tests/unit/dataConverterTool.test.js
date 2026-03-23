'use strict';

/**
 * Unit tests for dataConverterTool.js
 *
 * Tests cover: JSON↔XML, JSON↔YAML, JSON↔CSV, timestamp↔date conversions,
 * UI state management, sample loading, clear button, auto-convert, download.
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

  require(path.join(__dirname, '../../assets/js/tools/dataConverterTool.js'));

  tool = global.Tools._tools.dataConverterTool;
});

// ─── Helpers ──────────────────────────────────────────────────────────────────

function openTool() {
  const container = document.createElement('div');
  document.getElementById('tool-container')?.remove();
  container.id = 'tool-container';
  document.body.appendChild(container);
  tool.open(container);
  return container;
}

function cleanup(container) {
  document.body.removeChild(container);
}

function setConversionType(type) {
  const select = document.getElementById('conversionType');
  select.value = type;
  select.dispatchEvent(new Event('change'));
}

function convert(inputText) {
  document.getElementById('inputData').value = inputText;
  document.getElementById('convertBtn').click();
  return document.getElementById('outputData').value;
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('DataConverterTool – Registration', () => {
  test('registers tool under "dataConverterTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── JSON → XML ───────────────────────────────────────────────────────────────

describe('DataConverterTool – JSON to XML', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('jsonToXml');
  });
  afterEach(() => cleanup(c));

  test('converts a flat JSON object to XML', () => {
    const output = convert('{"name":"John","age":30}');
    expect(output).toContain('<root>');
    expect(output).toContain('<name>John</name>');
    expect(output).toContain('<age>30</age>');
    expect(output).toContain('</root>');
  });

  test('converts a JSON array to XML with item elements', () => {
    const output = convert('[{"id":1},{"id":2}]');
    expect(output).toContain('<item>');
    expect(output).toContain('<id>1</id>');
    expect(output).toContain('<id>2</id>');
  });

  test('escapes XML special characters', () => {
    const output = convert('{"text":"a & b < c > d"}');
    expect(output).toContain('a &amp; b &lt; c &gt; d');
  });

  test('invalid JSON shows error status', () => {
    convert('{invalid}');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('d-none')).toBe(false);
    expect(status.classList.contains('alert-danger')).toBe(true);
  });

  test('empty input clears output', () => {
    document.getElementById('inputData').value = '';
    document.getElementById('convertBtn').click();
    expect(document.getElementById('outputData').value).toBe('');
  });
});

// ─── XML → JSON ───────────────────────────────────────────────────────────────

describe('DataConverterTool – XML to JSON', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('xmlToJson');
  });
  afterEach(() => cleanup(c));

  test('converts simple XML to JSON', () => {
    const output = convert('<root><name>John</name><age>30</age></root>');
    const parsed = JSON.parse(output);
    expect(parsed).toEqual({ name: 'John', age: '30' });
  });

  test('invalid XML shows error status', () => {
    convert('<root><unclosed>');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('d-none')).toBe(false);
    expect(status.classList.contains('alert-danger')).toBe(true);
  });
});

// ─── JSON → YAML ──────────────────────────────────────────────────────────────

describe('DataConverterTool – JSON to YAML', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('jsonToYaml');
  });
  afterEach(() => cleanup(c));

  test('converts a flat JSON object to YAML', () => {
    const output = convert('{"name":"John","age":30}');
    expect(output).toContain('name: John');
    expect(output).toContain('age: 30');
  });

  test('converts nested JSON to YAML', () => {
    const output = convert('{"address":{"city":"Berlin"}}');
    expect(output).toContain('address:');
    expect(output).toContain('city: Berlin');
  });

  test('converts JSON array to YAML list', () => {
    const output = convert('["a","b","c"]');
    expect(output).toContain('- a');
    expect(output).toContain('- b');
    expect(output).toContain('- c');
  });

  test('quotes YAML strings containing colons', () => {
    const output = convert('{"key":"value: with colon"}');
    expect(output).toContain('"value: with colon"');
  });

  test('invalid JSON shows error', () => {
    convert('{bad json}');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('alert-danger')).toBe(true);
  });
});

// ─── YAML → JSON ──────────────────────────────────────────────────────────────

describe('DataConverterTool – YAML to JSON', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('yamlToJson');
  });
  afterEach(() => cleanup(c));

  test('converts flat YAML to JSON', () => {
    const output = convert('name: John\nage: 30');
    const parsed = JSON.parse(output);
    expect(parsed.name).toBe('John');
    expect(parsed.age).toBe(30);
  });

  test('parses boolean YAML values', () => {
    const output = convert('active: true\ndisabled: false');
    const parsed = JSON.parse(output);
    expect(parsed.active).toBe(true);
    expect(parsed.disabled).toBe(false);
  });

  test('parses null YAML value', () => {
    const output = convert('value: null');
    const parsed = JSON.parse(output);
    expect(parsed.value).toBeNull();
  });

  test('parses tilde as null', () => {
    const output = convert('value: ~');
    const parsed = JSON.parse(output);
    expect(parsed.value).toBeNull();
  });

  test('ignores YAML comments', () => {
    const output = convert('# comment\nname: John');
    const parsed = JSON.parse(output);
    expect(parsed.name).toBe('John');
  });
});

// ─── JSON → CSV ───────────────────────────────────────────────────────────────

describe('DataConverterTool – JSON to CSV', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('jsonToCsv');
  });
  afterEach(() => cleanup(c));

  test('converts JSON array to CSV with header row', () => {
    const output = convert('[{"name":"John","age":30},{"name":"Jane","age":25}]');
    const lines = output.split('\n');
    expect(lines[0]).toBe('name,age');
    expect(lines[1]).toBe('John,30');
    expect(lines[2]).toBe('Jane,25');
  });

  test('wraps fields containing delimiter in quotes', () => {
    const output = convert('[{"note":"a,b"}]');
    expect(output).toContain('"a,b"');
  });

  test('wraps fields containing double quotes in quotes and escapes them', () => {
    const output = convert('[{"text":"say \\"hi\\""}]');
    expect(output).toContain('"say ""hi"""');
  });

  test('non-array JSON shows error', () => {
    convert('{"key":"value"}');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('alert-danger')).toBe(true);
  });
});

// ─── CSV → JSON ───────────────────────────────────────────────────────────────

describe('DataConverterTool – CSV to JSON', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('csvToJson');
  });
  afterEach(() => cleanup(c));

  test('converts CSV with header row to JSON array', () => {
    const output = convert('name,age\nJohn,30\nJane,25');
    const parsed = JSON.parse(output);
    expect(parsed).toHaveLength(2);
    expect(parsed[0]).toEqual({ name: 'John', age: '30' });
    expect(parsed[1]).toEqual({ name: 'Jane', age: '25' });
  });

  test('handles quoted fields containing commas', () => {
    const output = convert('name,note\nJohn,"a,b"');
    const parsed = JSON.parse(output);
    expect(parsed[0].note).toBe('a,b');
  });

  test('handles escaped double quotes inside quoted fields', () => {
    const output = convert('text\n"say ""hi"""');
    const parsed = JSON.parse(output);
    expect(parsed[0].text).toBe('say "hi"');
  });

  test('empty CSV input clears output', () => {
    // performConversion short-circuits on whitespace-only input
    document.getElementById('inputData').value = '   ';
    document.getElementById('convertBtn').click();
    expect(document.getElementById('outputData').value).toBe('');
  });
});

// ─── Timestamp ↔ Date ─────────────────────────────────────────────────────────

describe('DataConverterTool – Timestamp to Date', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('timestampToDate');
  });
  afterEach(() => cleanup(c));

  test('converts Unix timestamp (seconds) to ISO date string', () => {
    const output = convert('0');
    expect(output).toMatch(/^1970-01-01 00:00:00$/);
  });

  test('invalid timestamp shows error', () => {
    convert('not-a-number');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('alert-danger')).toBe(true);
  });
});

describe('DataConverterTool – Date to Timestamp', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    setConversionType('dateToTimestamp');
  });
  afterEach(() => cleanup(c));

  test('converts ISO date string to Unix timestamp (seconds)', () => {
    const output = convert('1970-01-01T00:00:00Z');
    expect(output).toBe('0');
  });

  test('invalid date shows error', () => {
    convert('not-a-date');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('alert-danger')).toBe(true);
  });
});

// ─── UI State ─────────────────────────────────────────────────────────────────

describe('DataConverterTool – UI State', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clear button resets input and output', () => {
    setConversionType('jsonToXml');
    convert('{"a":1}');
    document.getElementById('clearBtn').click();
    expect(document.getElementById('inputData').value).toBe('');
    expect(document.getElementById('outputData').value).toBe('');
  });

  test('indentation control is hidden for timestamp conversion', () => {
    setConversionType('timestampToDate');
    const wrapper = document.getElementById('indentationWrapper');
    expect(wrapper.classList.contains('d-none')).toBe(true);
  });

  test('indentation control is visible after switching from timestamp to JSON→XML', () => {
    setConversionType('timestampToDate');
    setConversionType('jsonToXml');
    const wrapper = document.getElementById('indentationWrapper');
    expect(wrapper.classList.contains('d-none')).toBe(false);
  });

  test('indentation control is visible after switching from timestamp to CSV', () => {
    setConversionType('timestampToDate');
    setConversionType('csvToJson');
    const wrapper = document.getElementById('indentationWrapper');
    expect(wrapper.classList.contains('d-none')).toBe(false);
  });

  test('XML options shown for jsonToXml', () => {
    setConversionType('jsonToXml');
    expect(document.getElementById('xmlOptions').classList.contains('d-none')).toBe(false);
  });

  test('CSV options shown for csvToJson', () => {
    setConversionType('csvToJson');
    expect(document.getElementById('csvOptions').classList.contains('d-none')).toBe(false);
  });

  test('load sample button populates input for jsonToXml', () => {
    setConversionType('jsonToXml');
    document.getElementById('loadSampleBtn').click();
    const input = document.getElementById('inputData').value;
    expect(input.length).toBeGreaterThan(0);
    expect(() => JSON.parse(input)).not.toThrow();
  });

  test('load sample button populates input for timestampToDate', () => {
    setConversionType('timestampToDate');
    document.getElementById('loadSampleBtn').click();
    const input = document.getElementById('inputData').value;
    expect(input).toMatch(/^\d+$/);
  });

  test('load sample button populates input for dateToTimestamp', () => {
    setConversionType('dateToTimestamp');
    document.getElementById('loadSampleBtn').click();
    const input = document.getElementById('inputData').value;
    expect(new Date(input).getTime()).not.toBeNaN();
  });

  test('success status shown after valid conversion', () => {
    setConversionType('jsonToXml');
    convert('{"a":1}');
    const status = document.getElementById('conversionStatus');
    expect(status.classList.contains('alert-success')).toBe(true);
  });

  test('download button calls DownloadUtils', () => {
    setConversionType('jsonToXml');
    convert('{"a":1}');
    document.getElementById('downloadOutput').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalledWith(
      expect.any(String),
      'converted.xml'
    );
  });

  test('copy button calls ClipboardUtils', async () => {
    setConversionType('jsonToXml');
    convert('{"a":1}');
    await document.getElementById('copyOutput').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalled();
  });

  test('auto-convert triggers conversion on input change', () => {
    setConversionType('jsonToXml');
    const autoConvert = document.getElementById('autoConvert');
    autoConvert.checked = true;
    const inputArea = document.getElementById('inputData');
    inputArea.value = '{"x":1}';
    inputArea.dispatchEvent(new Event('input'));
    expect(document.getElementById('outputData').value).toContain('<x>1</x>');
  });
});

// ─── Round-trips ──────────────────────────────────────────────────────────────

describe('DataConverterTool – Round-trips', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('JSON → CSV → JSON round-trip preserves data', () => {
    setConversionType('jsonToCsv');
    const csv = convert('[{"name":"John","age":"30"}]');

    setConversionType('csvToJson');
    const json = convert(csv);
    const parsed = JSON.parse(json);
    expect(parsed[0].name).toBe('John');
    expect(parsed[0].age).toBe('30');
  });

  test('dateToTimestamp (seconds) result is a valid integer', () => {
    setConversionType('dateToTimestamp');
    document.querySelector('input[name="timestampUnit"][value="seconds"]').checked = true;
    const ts = convert('2023-11-06T12:00:00Z');
    expect(ts).toMatch(/^\d+$/);
    expect(parseInt(ts, 10)).toBeGreaterThan(0);
  });
});
