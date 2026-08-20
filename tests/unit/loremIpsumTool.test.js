'use strict';

/**
 * Unit tests for loremIpsumTool.js
 *
 * Tests cover: registration, UI rendering, auto-generation on open,
 * paragraph/sentence/word generation, combined generation, validation,
 * character/word count updates, clear button, copy button.
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

  global.DownloadUtils = {
    downloadText: jest.fn(),
  };

  require(path.join(__dirname, '../../assets/js/tools/loremIpsumTool.js'));

  tool = global.Tools._tools.loremIpsumTool;
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

function setInputs(container, { paragraphs = 0, sentences = 0, words = 0 } = {}) {
  container.querySelector('#paragraphCount').value = String(paragraphs);
  container.querySelector('#sentenceCount').value = String(sentences);
  container.querySelector('#wordCount').value = String(words);
}

function clickGenerate(container) {
  container.querySelector('#generateBtn').click();
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('loremIpsumTool – Registration', () => {
  test('registers tool under "loremIpsumTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('loremIpsumTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders paragraph count input', () => {
    expect(c.querySelector('#paragraphCount')).not.toBeNull();
  });

  test('renders sentence count input', () => {
    expect(c.querySelector('#sentenceCount')).not.toBeNull();
  });

  test('renders word count input', () => {
    expect(c.querySelector('#wordCount')).not.toBeNull();
  });

  test('renders generate button', () => {
    expect(c.querySelector('#generateBtn')).not.toBeNull();
  });

  test('renders output textarea', () => {
    expect(c.querySelector('#loremOutput')).not.toBeNull();
  });

  test('renders copy button', () => {
    expect(c.querySelector('#copyBtn')).not.toBeNull();
  });

  test('renders clear button', () => {
    expect(c.querySelector('#clearBtn')).not.toBeNull();
  });

  test('renders character count display', () => {
    expect(c.querySelector('#charCount')).not.toBeNull();
  });

  test('renders word count display', () => {
    expect(c.querySelector('#wordCountDisplay')).not.toBeNull();
  });

  test('paragraph input default value is 3', () => {
    expect(c.querySelector('#paragraphCount').value).toBe('3');
  });

  test('sentence input default value is 0', () => {
    expect(c.querySelector('#sentenceCount').value).toBe('0');
  });

  test('word input default value is 0', () => {
    expect(c.querySelector('#wordCount').value).toBe('0');
  });
});

// ─── Auto-generation on open ─────────────────────────────────────────────────

describe('loremIpsumTool – Auto-generation on open', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('output is not empty after open (default 3 paragraphs)', () => {
    const output = c.querySelector('#loremOutput').value;
    expect(output.trim().length).toBeGreaterThan(0);
  });

  test('char count is > 0 after auto-generation', () => {
    const charCount = parseInt(c.querySelector('#charCount').textContent);
    expect(charCount).toBeGreaterThan(0);
  });

  test('word count display is > 0 after auto-generation', () => {
    const wordCount = parseInt(c.querySelector('#wordCountDisplay').textContent);
    expect(wordCount).toBeGreaterThan(0);
  });

  test('copy button is enabled after auto-generation', () => {
    expect(c.querySelector('#copyBtn').disabled).toBe(false);
  });

  test('clear button is enabled after auto-generation', () => {
    expect(c.querySelector('#clearBtn').disabled).toBe(false);
  });
});

// ─── Generate: Paragraphs ────────────────────────────────────────────────────

describe('loremIpsumTool – Generate: Paragraphs', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates text when paragraphs > 0', () => {
    setInputs(c, { paragraphs: 2 });
    clickGenerate(c);
    expect(c.querySelector('#loremOutput').value.trim().length).toBeGreaterThan(0);
  });

  test('generates 2 paragraphs separated by double newline', () => {
    setInputs(c, { paragraphs: 2 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    const parts = output.split('\n\n');
    expect(parts.length).toBe(2);
  });

  test('generates 1 paragraph with no double newline', () => {
    setInputs(c, { paragraphs: 1 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    expect(output.split('\n\n').length).toBe(1);
  });

  test('generated paragraph ends with a period', () => {
    setInputs(c, { paragraphs: 1 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value.trim();
    expect(output.endsWith('.')).toBe(true);
  });
});

// ─── Generate: Sentences ─────────────────────────────────────────────────────

describe('loremIpsumTool – Generate: Sentences', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates text when sentences > 0', () => {
    setInputs(c, { sentences: 3 });
    clickGenerate(c);
    expect(c.querySelector('#loremOutput').value.trim().length).toBeGreaterThan(0);
  });

  test('generated sentences output ends with period', () => {
    setInputs(c, { sentences: 2 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value.trim();
    expect(output.endsWith('.')).toBe(true);
  });

  test('sentence output starts with uppercase letter', () => {
    setInputs(c, { sentences: 1 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value.trim();
    expect(output.charAt(0)).toMatch(/[A-Z]/);
  });
});

// ─── Generate: Words ─────────────────────────────────────────────────────────

describe('loremIpsumTool – Generate: Words', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('generates text when words > 0', () => {
    setInputs(c, { words: 10 });
    clickGenerate(c);
    expect(c.querySelector('#loremOutput').value.trim().length).toBeGreaterThan(0);
  });

  test('generates exactly the requested number of words', () => {
    setInputs(c, { words: 7 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value.trim();
    const wordCount = output.split(/\s+/).length;
    expect(wordCount).toBe(7);
  });
});

// ─── Generate: Combined ──────────────────────────────────────────────────────

describe('loremIpsumTool – Generate: Combined', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('combines paragraphs + sentences separated by double newline', () => {
    setInputs(c, { paragraphs: 1, sentences: 2 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    const parts = output.split('\n\n');
    expect(parts.length).toBe(2);
  });

  test('combines paragraphs + words with double newline separator', () => {
    setInputs(c, { paragraphs: 1, words: 5 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    const parts = output.split('\n\n');
    expect(parts.length).toBe(2);
  });

  test('combines all three types into 3 blocks', () => {
    setInputs(c, { paragraphs: 1, sentences: 1, words: 5 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    const parts = output.split('\n\n');
    expect(parts.length).toBe(3);
  });
});

// ─── Generate: Validation ────────────────────────────────────────────────────

describe('loremIpsumTool – Generate: Validation', () => {
  let c;
  let alertSpy;
  beforeEach(() => {
    c = openTool();
    alertSpy = jest.spyOn(window, 'alert').mockImplementation(() => {});
  });
  afterEach(() => {
    alertSpy.mockRestore();
    cleanup(c);
  });

  test('shows alert when all inputs are 0', () => {
    setInputs(c, { paragraphs: 0, sentences: 0, words: 0 });
    clickGenerate(c);
    expect(alertSpy).toHaveBeenCalledTimes(1);
  });

  test('does not update output when all inputs are 0', () => {
    // Clear first so output is empty
    c.querySelector('#loremOutput').value = '';
    setInputs(c, { paragraphs: 0, sentences: 0, words: 0 });
    clickGenerate(c);
    expect(c.querySelector('#loremOutput').value).toBe('');
  });
});

// ─── Counts ──────────────────────────────────────────────────────────────────

describe('loremIpsumTool – Counts', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('char count matches output length', () => {
    setInputs(c, { words: 10 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value;
    const charCount = parseInt(c.querySelector('#charCount').textContent);
    expect(charCount).toBe(output.length);
  });

  test('word count display matches actual word count', () => {
    setInputs(c, { words: 10 });
    clickGenerate(c);
    const output = c.querySelector('#loremOutput').value.trim();
    const expected = output ? output.split(/\s+/).length : 0;
    const displayed = parseInt(c.querySelector('#wordCountDisplay').textContent);
    expect(displayed).toBe(expected);
  });
});

// ─── Clear Button ─────────────────────────────────────────────────────────────

describe('loremIpsumTool – Clear Button', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clears the output textarea', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#loremOutput').value).toBe('');
  });

  test('resets char count to 0', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#charCount').textContent).toBe('0');
  });

  test('resets word count display to 0', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#wordCountDisplay').textContent).toBe('0');
  });

  test('disables copy button after clear', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#copyBtn').disabled).toBe(true);
  });

  test('disables clear button after clear', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#clearBtn').disabled).toBe(true);
  });
});

// ─── Copy Button ──────────────────────────────────────────────────────────────

describe('loremIpsumTool – Copy Button', () => {
  let c;
  beforeEach(() => {
    c = openTool();
    global.ClipboardUtils.copyToClipboard.mockClear();
  });
  afterEach(() => cleanup(c));

  test('copy button is disabled when output is empty', () => {
    c.querySelector('#clearBtn').click();
    expect(c.querySelector('#copyBtn').disabled).toBe(true);
  });

  test('calls ClipboardUtils.copyToClipboard with output text', async () => {
    setInputs(c, { words: 5 });
    clickGenerate(c);
    const text = c.querySelector('#loremOutput').value;
    c.querySelector('#copyBtn').click();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(text);
  });

  test('does not call clipboard if output is empty', () => {
    c.querySelector('#loremOutput').value = '';
    // Manually enable the button to simulate edge case
    c.querySelector('#copyBtn').disabled = false;
    c.querySelector('#copyBtn').click();
    // copyToClipboard should not be called for empty text
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});
