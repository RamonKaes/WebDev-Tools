'use strict';

/**
 * Unit tests for characterReferenceTool.js
 *
 * Tests cover: XSS escaping (escapeHtml, escapeForAttribute), category filter,
 * text search, pagination (load more), and copy-button delegation.
 */

const path = require('path');

// ─── Test data ────────────────────────────────────────────────────────────────

const TEST_CHARS = [
  { char: '&', name: 'Ampersand', entity: '&amp;', unicode: 'U+0026', decimal: '&#38;', category: 'html' },
  { char: '<', name: 'Less-Than Sign', entity: '&lt;', unicode: 'U+003C', decimal: '&#60;', category: 'html' },
  { char: '→', name: 'Rightwards Arrow', entity: '&rarr;', unicode: 'U+2192', decimal: '&#8594;', category: 'arrows' },
  { char: '€', name: 'Euro Sign', entity: '&euro;', unicode: 'U+20AC', decimal: '&#8364;', category: 'currency' },
  { char: 'α', name: 'Greek Small Letter Alpha', entity: '&alpha;', unicode: 'U+03B1', decimal: '&#945;', category: 'greek' },
];

let tool = null;
let container = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(async () => {
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
    showToast: jest.fn(),
  };

  global.AppHelpers = undefined;

  // Mock fetch to return the test character dataset
  global.fetch = jest.fn().mockResolvedValue({
    ok: true,
    json: () => Promise.resolve(TEST_CHARS),
  });

  // Executing the IIFE registers the tool as a side effect
  require(path.join(__dirname, '../../assets/js/tools/characterReferenceTool.js'));

  tool = global.Tools._tools.characterReferenceTool;

  // Open the tool once; subsequent openings reuse the cached character data
  container = document.createElement('div');
  document.body.appendChild(container);
  tool.open(container);

  // Allow async init (loadCharacters → fetch → renderUI → updateTable) to complete
  await new Promise((resolve) => setTimeout(resolve, 30));
});

afterAll(() => {
  if (container && container.parentNode) {
    document.body.removeChild(container);
  }
});

// ─── Helpers ─────────────────────────────────────────────────────────────────

function getRows() {
  return Array.from(document.querySelectorAll('#charTableBody tr'));
}

/**
 * Trigger the search input and immediately flush the 300ms debounce.
 * Must be called while fake timers are active.
 */
function triggerSearch(query) {
  const input = document.getElementById('charSearch');
  input.value = query;
  input.dispatchEvent(new Event('input'));
  jest.runAllTimers();
}

function triggerCategoryFilter(value) {
  const select = document.getElementById('categoryFilter');
  select.value = value;
  select.dispatchEvent(new Event('change'));
}

// ─── Tests ───────────────────────────────────────────────────────────────────

describe('CharacterReference – Registration', () => {
  test('registers tool under "characterReferenceTool"', () => {
    expect(tool).toBeDefined();
  });
});

describe('CharacterReference – Initial Render', () => {
  test('renders the character table with all test characters', () => {
    const rows = getRows();
    // All 5 test characters should be visible (no filter active)
    expect(rows.length).toBe(TEST_CHARS.length);
  });

  test('table contains a copy-button group in each row', () => {
    const groups = document.querySelectorAll('#charTableBody .btn-group');
    expect(groups.length).toBe(TEST_CHARS.length);
  });
});

describe('CharacterReference – XSS Escaping', () => {
  test('escapeHtml: ampersand in entity column is HTML-escaped', () => {
    // '&amp;' should appear as literal text, meaning innerHTML = '&amp;amp;'
    const entityCells = document.querySelectorAll('#charTableBody td code');
    const ampersandCell = Array.from(entityCells).find(
      (td) => td.textContent === '&amp;'
    );
    expect(ampersandCell).toBeTruthy();
  });

  test('escapeHtml: less-than sign in entity column does not inject raw HTML', () => {
    const entityCells = document.querySelectorAll('#charTableBody td code');
    const ltCell = Array.from(entityCells).find(
      (td) => td.textContent === '&lt;'
    );
    expect(ltCell).toBeTruthy();
  });

  test('escapeForAttribute: "&" char copy-button stores the raw character as copy value', () => {
    // jsdom decodes HTML entities in attributes: data-copy-value="&amp;" → getAttribute() === '&'
    // This verifies escapeForAttribute produced valid HTML that the parser correctly decodes
    const charCopyBtns = document.querySelectorAll(
      '[data-copy-type="char"][data-copy-value]'
    );
    const ampBtn = Array.from(charCopyBtns).find(
      (btn) => btn.getAttribute('data-copy-value') === '&'
    );
    expect(ampBtn).toBeTruthy();
  });
});

describe('CharacterReference – Search', () => {
  // The search input uses a 300ms debounce; fake timers let us flush it synchronously
  beforeEach(() => { jest.useFakeTimers(); });
  afterEach(() => {
    // Reset search and restore real timers
    triggerSearch('');
    triggerCategoryFilter('all');
    jest.useRealTimers();
  });

  test('searching by name narrows results', () => {
    triggerSearch('arrow');
    const rows = getRows();
    expect(rows.length).toBe(1);
    expect(rows[0].textContent).toContain('Rightwards Arrow');
  });

  test('searching by entity finds the correct character', () => {
    triggerSearch('&euro;');
    const rows = getRows();
    expect(rows.length).toBe(1);
    expect(rows[0].textContent).toContain('Euro Sign');
  });

  test('searching by unicode code point finds the character', () => {
    triggerSearch('U+03B1');
    const rows = getRows();
    expect(rows.length).toBe(1);
    expect(rows[0].textContent).toContain('Greek Small Letter Alpha');
  });

  test('search with no match shows empty-state row', () => {
    triggerSearch('xyzzy-no-match');
    const rows = getRows();
    // Empty-state produces a single row with colspan
    expect(rows.length).toBe(1);
    expect(rows[0].querySelector('[colspan]')).toBeTruthy();
  });

  test('clearing search restores all characters', () => {
    triggerSearch('euro');
    triggerSearch('');
    expect(getRows().length).toBe(TEST_CHARS.length);
  });
});

describe('CharacterReference – Category Filter', () => {
  afterEach(() => {
    triggerSearch('');
    triggerCategoryFilter('all');
  });

  test('filtering by "arrows" shows only arrow characters', () => {
    triggerCategoryFilter('arrows');
    const rows = getRows();
    expect(rows.length).toBe(1);
    expect(rows[0].textContent).toContain('Rightwards Arrow');
  });

  test('filtering by "html" shows only HTML category characters', () => {
    triggerCategoryFilter('html');
    const rows = getRows();
    expect(rows.length).toBe(2); // '&' and '<' are both 'html'
  });

  test('switching back to "all" shows every character', () => {
    triggerCategoryFilter('currency');
    triggerCategoryFilter('all');
    expect(getRows().length).toBe(TEST_CHARS.length);
  });
});

describe('CharacterReference – Copy Delegation', () => {
  test('clicking a char copy button calls ClipboardUtils.copyToClipboard', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    const firstCharBtn = document.querySelector('[data-copy-type="char"]');
    firstCharBtn.click();
    // Allow microtask (async copyCharacterData) to complete
    await new Promise((r) => setTimeout(r, 10));
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledTimes(1);
  });

  test('clicking an entity copy button copies the entity string', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    const entityBtn = document.querySelector('[data-copy-type="entity"]');
    entityBtn.click();
    await new Promise((r) => setTimeout(r, 10));
    // The toast message is passed alongside the value so the confirmation
    // names what was copied ("HTML entity copied") instead of a generic label
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith(
      entityBtn.getAttribute('data-copy-value'),
      expect.any(String)
    );
  });
});
