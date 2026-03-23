'use strict';

/**
 * Unit tests for codeFormatterTool.js
 *
 * Tests cover: HTML/CSS/JS/XML/SQL beautify & minify, void-element indentation,
 * UI interactions (format, clear, load sample, auto-format), and JS-minify via
 * a mocked Terser.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.Tools = {
    _tools: {},
    register: (name, toolObj) => { global.Tools._tools[name] = toolObj; },
    open: jest.fn(),
  };

  global.i18n = { t: (key) => key };

  global.ClipboardUtils = { copyToClipboard: jest.fn().mockResolvedValue(true) };
  global.DownloadUtils  = { downloadText: jest.fn() };

  Object.defineProperty(global.navigator, 'clipboard', {
    value: { writeText: jest.fn().mockResolvedValue(undefined) },
    configurable: true,
  });

  require(path.join(__dirname, '../../assets/js/tools/codeFormatterTool.js'));
  tool = global.Tools._tools.codeFormatterTool;
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

function setLanguage(container, lang) {
  const sel = container.querySelector('#codeLanguage');
  sel.value = lang;
  sel.dispatchEvent(new Event('change'));
}

function setMode(container, mode) {
  const radio = container.querySelector(mode === 'minify' ? '#modeMinify' : '#modeBeautify');
  radio.checked = true;
  radio.dispatchEvent(new Event('change'));
}

/**
 * Trigger format and wait one microtask tick so that async paths (minify)
 * can settle before we read the output.
 */
async function format(container, code) {
  container.querySelector('#inputCode').value = code;
  container.querySelector('#formatBtn').click();
  await Promise.resolve();
  return container.querySelector('#outputCode').value;
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('CodeFormatterTool – Registration', () => {
  test('registers tool under "codeFormatterTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── HTML Beautifier ──────────────────────────────────────────────────────────

describe('CodeFormatterTool – HTML beautify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'html'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('nested tags receive correct indentation', async () => {
    const result = await format(c, '<div><p>Hello</p></div>');
    const lines = result.split('\n');
    expect(lines[0]).toBe('<div>');
    expect(lines[1]).toMatch(/^\s+<p>/);
    expect(lines[2]).toBe('</div>');
  });

  test('void elements do not increase indent level', async () => {
    const result = await format(c, '<div><br><img src="x.png"><input type="text"></div>');
    const lines = result.split('\n').filter(l => l.trim());
    const brLine    = lines.find(l => l.trim().startsWith('<br'));
    const imgLine   = lines.find(l => l.trim().startsWith('<img'));
    const inputLine = lines.find(l => l.trim().startsWith('<input'));
    const leading = (s) => s.match(/^(\s*)/)[1].length;
    expect(leading(brLine)).toBe(leading(imgLine));
    expect(leading(brLine)).toBe(leading(inputLine));
    // All void elements should be indented (inside <div>)
    expect(leading(brLine)).toBeGreaterThan(0);
  });

  test('self-closing tags are indented but do not increase indent level', async () => {
    const result = await format(c, '<svg><path d="M0 0"/><circle r="5"/></svg>');
    const lines = result.split('\n').filter(l => l.trim());
    // <path/> and <circle/> should be at depth 1 (indented)
    const pathLine   = lines.find(l => l.trim().startsWith('<path'));
    const circleLine = lines.find(l => l.trim().startsWith('<circle'));
    expect(pathLine).toMatch(/^\s/);
    expect(circleLine).toMatch(/^\s/);
    // </svg> should be at depth 0
    const closeSvg = lines[lines.length - 1];
    expect(closeSvg).toBe('</svg>');
  });

  test('empty input produces empty output', async () => {
    expect(await format(c, '')).toBe('');
  });
});

// ─── HTML Minifier ────────────────────────────────────────────────────────────

describe('CodeFormatterTool – HTML minify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'html'); setMode(c, 'minify'); });
  afterEach(() => cleanup(c));

  test('removes HTML comments', async () => {
    const result = await format(c, '<!-- comment --><div>Hello</div>');
    expect(result).not.toContain('<!--');
    expect(result).toContain('<div>Hello</div>');
  });

  test('collapses whitespace between tags', async () => {
    const result = await format(c, '<div>  <span>  hi  </span>  </div>');
    expect(result).not.toMatch(/>\s{2,}</);
  });
});

// ─── CSS Beautifier ───────────────────────────────────────────────────────────

describe('CodeFormatterTool – CSS beautify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'css'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('places opening brace on same line as selector', async () => {
    const result = await format(c, 'body{color:red;}');
    expect(result).toMatch(/body \{/);
  });

  test('places closing brace on its own line', async () => {
    const result = await format(c, 'body{color:red;}');
    expect(result).toMatch(/^}/m);
  });

  test('indents declarations inside rule', async () => {
    const result = await format(c, 'body{color:red;margin:0;}');
    const declLine = result.split('\n').find(l => l.includes('color'));
    expect(declLine).toMatch(/^\s+/);
  });
});

// ─── CSS Minifier ─────────────────────────────────────────────────────────────

describe('CodeFormatterTool – CSS minify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'css'); setMode(c, 'minify'); });
  afterEach(() => cleanup(c));

  test('removes CSS block comments', async () => {
    const result = await format(c, '/* header styles */ body { color: red; }');
    expect(result).not.toContain('/*');
    expect(result).toContain('body');
  });

  test('collapses whitespace around braces and semicolons', async () => {
    const result = await format(c, 'body { color: red ; margin: 0 ; }');
    expect(result).not.toMatch(/\s{2,}/);
    // colon spacing inside values is preserved (no colon stripping)
    expect(result).toContain('color: red');
  });

  test('preserves colon spacing inside string values', async () => {
    const result = await format(c, 'p::before { content: "key: value"; }');
    expect(result).toContain('"key: value"');
  });
});

// ─── JavaScript Beautifier ────────────────────────────────────────────────────

describe('CodeFormatterTool – JavaScript beautify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'javascript'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('adds newline and indent after opening brace', async () => {
    const result = await format(c, 'function f(){return 1;}');
    expect(result).toMatch(/function f\(\) \{/);
    expect(result).toMatch(/\n\s+return/);
  });

  test('places closing brace on its own line', async () => {
    const result = await format(c, 'function f(){return 1;}');
    expect(result).toMatch(/^}/m);
  });

  test('preserves string content unchanged', async () => {
    const result = await format(c, 'var s = "hello { world }";');
    expect(result).toContain('"hello { world }"');
  });

  test('preserves single-line comment content', async () => {
    const result = await format(c, 'var x = 1; // { not a block }');
    expect(result).toContain('// { not a block }');
  });
});

// ─── JavaScript Minify (mocked Terser) ───────────────────────────────────────

describe('CodeFormatterTool – JavaScript minify (Terser)', () => {
  let c;
  let appendChildSpy;

  beforeEach(() => {
    global.Terser = {
      minify: jest.fn().mockResolvedValue({ code: 'var x=1;' }),
    };

    // Simulate successful CDN script load: trigger onload on the injected script
    appendChildSpy = jest.spyOn(document.head, 'appendChild').mockImplementation((el) => {
      if (el && el.tagName && el.tagName.toUpperCase() === 'SCRIPT') {
        setTimeout(() => { if (typeof el.onload === 'function') el.onload(); }, 0);
        return el;
      }
      return document.head.appendChild.call(document.head, el);
    });

    c = openTool();
    setLanguage(c, 'javascript');
    setMode(c, 'minify');
  });

  afterEach(() => {
    appendChildSpy.mockRestore();
    delete global.Terser;
    cleanup(c);
  });

  test('calls Terser.minify with the input code', async () => {
    c.querySelector('#inputCode').value = 'var x = 1;';
    c.querySelector('#formatBtn').click();
    await new Promise(r => setTimeout(r, 100));
    expect(global.Terser.minify).toHaveBeenCalledWith(
      'var x = 1;',
      expect.objectContaining({ mangle: false })
    );
  });

  test('writes Terser output to output textarea', async () => {
    c.querySelector('#inputCode').value = 'var x = 1;';
    c.querySelector('#formatBtn').click();
    await new Promise(r => setTimeout(r, 100));
    expect(c.querySelector('#outputCode').value).toBe('var x=1;');
  });
});

// ─── XML Beautifier ───────────────────────────────────────────────────────────

describe('CodeFormatterTool – XML beautify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'xml'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('indents child elements', async () => {
    const result = await format(c, '<root><item>value</item></root>');
    const lines = result.split('\n');
    expect(lines[0]).toBe('<root>');
    expect(lines[1]).toMatch(/^\s+<item>/);
    expect(lines[2]).toBe('</root>');
  });
});

// ─── SQL Beautifier ───────────────────────────────────────────────────────────

describe('CodeFormatterTool – SQL beautify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'sql'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('places SELECT on its own line', async () => {
    const result = await format(c, 'select id, name from users where id = 1');
    expect(result).toMatch(/^SELECT/m);
  });

  test('places FROM on its own line', async () => {
    const result = await format(c, 'select id from users');
    expect(result).toMatch(/^FROM/m);
  });

  test('uppercases SQL keywords', async () => {
    const result = await format(c, 'select * from users where id = 1');
    expect(result).toContain('SELECT');
    expect(result).toContain('FROM');
    expect(result).toContain('WHERE');
  });
});

// ─── SQL Minifier ─────────────────────────────────────────────────────────────

describe('CodeFormatterTool – SQL minify', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'sql'); setMode(c, 'minify'); });
  afterEach(() => cleanup(c));

  test('removes single-line comments', async () => {
    const result = await format(c, 'SELECT id -- primary key\nFROM users');
    expect(result).not.toContain('--');
  });

  test('collapses whitespace', async () => {
    const result = await format(c, 'SELECT   id   FROM   users');
    expect(result).not.toMatch(/\s{2,}/);
  });
});

// ─── UI – General interactions ────────────────────────────────────────────────

describe('CodeFormatterTool – UI interactions', () => {
  let c;
  beforeEach(() => { c = openTool(); setLanguage(c, 'html'); setMode(c, 'beautify'); });
  afterEach(() => cleanup(c));

  test('clear button empties input and output', () => {
    c.querySelector('#inputCode').value = '<div></div>';
    c.querySelector('#outputCode').value = '<div></div>';
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#inputCode').value).toBe('');
    expect(c.querySelector('#outputCode').value).toBe('');
  });

  test('output shows line and character count after format', async () => {
    await format(c, '<div><p>hi</p></div>');
    const info = c.querySelector('#outputInfo').textContent;
    expect(info).toMatch(/\d+/);
  });

  test('load sample fills input for html', () => {
    setLanguage(c, 'html');
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputCode').value).toContain('<html>');
  });

  test('load sample fills input for css', () => {
    setLanguage(c, 'css');
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputCode').value).toContain('font-family');
  });

  test('load sample fills input for xml', () => {
    setLanguage(c, 'xml');
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputCode').value).toContain('<root>');
  });

  test('load sample fills input for sql', () => {
    setLanguage(c, 'sql');
    c.querySelector('#loadSampleBtn').click();
    expect(c.querySelector('#inputCode').value.toUpperCase()).toContain('SELECT');
  });

  test('auto-format triggers formatCode after debounce when enabled', async () => {
    c.querySelector('#autoFormat').checked = true;
    c.querySelector('#inputCode').value = '<p>hi</p>';
    c.querySelector('#inputCode').dispatchEvent(new Event('input'));
    await new Promise(r => setTimeout(r, 600));
    expect(c.querySelector('#outputCode').value).toContain('<p>');
  });

  test('auto-format does not trigger when disabled', async () => {
    c.querySelector('#autoFormat').checked = false;
    c.querySelector('#inputCode').value = '<p>hi</p>';
    c.querySelector('#inputCode').dispatchEvent(new Event('input'));
    await new Promise(r => setTimeout(r, 600));
    expect(c.querySelector('#outputCode').value).toBe('');
  });

  test('copy button calls ClipboardUtils when available', async () => {
    await format(c, '<div></div>');
    c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalled();
  });

  test('download button calls DownloadUtils when available', async () => {
    await format(c, '<div></div>');
    c.querySelector('#downloadBtn').click();
    expect(global.DownloadUtils.downloadText).toHaveBeenCalled();
  });
});
