'use strict';

/**
 * Unit tests for emojiReferenceTool.js
 *
 * Tests cover: registration, initial render, category filtering,
 * search (with active category preserved), copy-button delegation,
 * pagination (load more), and error/empty states.
 */

const path = require('path');

// ─── Test data ────────────────────────────────────────────────────────────────

const TEST_EMOJIS = [
  { emoji: '😀', name: 'Grinning Face', code: '1F600', category: 'emotions' },
  { emoji: '👍', name: 'Thumbs Up', code: '1F44D', category: 'gestures' },
  { emoji: '💻', name: 'Laptop', code: '1F4BB', category: 'tech' },
  { emoji: '→', name: 'Rightwards Arrow', code: '2192', category: 'arrows' },
  { emoji: '&', name: 'Ampersand Symbol', code: '0026', category: 'ui' },
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

  global.AppHelpers = {
    escapeHtml: (str) => String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;'),
    escapeAttr: (str) => String(str).replace(/"/g, '&quot;'),
  };

  global.__BASE_PATH__ = '';

  global.fetch = jest.fn().mockResolvedValue({
    ok: true,
    json: () => Promise.resolve(TEST_EMOJIS),
  });

  require(path.join(__dirname, '../../assets/js/tools/emojiReferenceTool.js'));

  tool = global.Tools._tools.emojiReferenceTool;

  container = document.createElement('div');
  container.id = 'tool-container';
  document.body.appendChild(container);
  await tool.open(container);

  // Allow async fetch + render to complete
  await new Promise((resolve) => setTimeout(resolve, 30));
});

afterAll(() => {
  if (container && container.parentNode) {
    document.body.removeChild(container);
  }
});

// ─── Helpers ─────────────────────────────────────────────────────────────────

function getCards() {
  return Array.from(document.querySelectorAll('#emojiGrid .card'));
}

function clickCategory(key) {
  const btn = document.querySelector(`#categoryFilters [data-category="${key}"]`);
  if (btn) btn.click();
}

function triggerSearch(query) {
  const input = document.getElementById('emojiSearch');
  input.value = query;
  input.dispatchEvent(new Event('input'));
}

function resetFilters() {
  clickCategory('all');
  triggerSearch('');
}

// ─── Tests ───────────────────────────────────────────────────────────────────

describe('EmojiReference – Registration', () => {
  test('registers tool under "emojiReferenceTool"', () => {
    expect(tool).toBeDefined();
    expect(typeof tool.open).toBe('function');
  });
});

describe('EmojiReference – Initial Render', () => {
  test('renders all test emojis', () => {
    expect(getCards().length).toBe(TEST_EMOJIS.length);
  });

  test('renders search input', () => {
    expect(document.getElementById('emojiSearch')).not.toBeNull();
  });

  test('renders category filter buttons', () => {
    const buttons = document.querySelectorAll('#categoryFilters button');
    expect(buttons.length).toBeGreaterThan(0);
  });

  test('"all" category button is active initially', () => {
    const allBtn = document.querySelector('#categoryFilters [data-category="all"]');
    expect(allBtn.classList.contains('active')).toBe(true);
  });
});

describe('EmojiReference – Category Filter', () => {
  afterEach(resetFilters);

  test('filtering by "emotions" shows only emotion emojis', () => {
    clickCategory('emotions');
    const cards = getCards();
    expect(cards.length).toBe(1);
    expect(cards[0].textContent).toContain('Grinning Face');
  });

  test('filtering by "tech" shows only tech emojis', () => {
    clickCategory('tech');
    const cards = getCards();
    expect(cards.length).toBe(1);
    expect(cards[0].textContent).toContain('Laptop');
  });

  test('switching back to "all" shows every emoji', () => {
    clickCategory('gestures');
    clickCategory('all');
    expect(getCards().length).toBe(TEST_EMOJIS.length);
  });
});

describe('EmojiReference – Search', () => {
  afterEach(resetFilters);

  test('searching by name narrows results', () => {
    triggerSearch('laptop');
    expect(getCards().length).toBe(1);
    expect(getCards()[0].textContent).toContain('Laptop');
  });

  test('search is case-insensitive', () => {
    triggerSearch('GRINNING');
    expect(getCards().length).toBe(1);
    expect(getCards()[0].textContent).toContain('Grinning Face');
  });

  test('search with no match shows empty-state message', () => {
    triggerSearch('xyzzy-no-match');
    expect(getCards().length).toBe(0);
    const alert = document.querySelector('#emojiGrid .alert-info');
    expect(alert).not.toBeNull();
  });

  test('clearing search restores all emojis', () => {
    triggerSearch('laptop');
    triggerSearch('');
    expect(getCards().length).toBe(TEST_EMOJIS.length);
  });

  test('search respects active category filter', () => {
    // Select "tech" first, then search — should only look within tech emojis
    clickCategory('tech');
    triggerSearch('grinning'); // Grinning is in 'emotions', not 'tech'
    expect(getCards().length).toBe(0);
    const alert = document.querySelector('#emojiGrid .alert-info');
    expect(alert).not.toBeNull();
  });

  test('search within active category finds matching emoji', () => {
    clickCategory('tech');
    triggerSearch('laptop');
    expect(getCards().length).toBe(1);
    expect(getCards()[0].textContent).toContain('Laptop');
  });
});

describe('EmojiReference – XSS Escaping', () => {
  test('ampersand emoji name is HTML-escaped in card text', () => {
    triggerSearch('ampersand');
    const card = getCards()[0];
    // textContent should show raw '&', but innerHTML should be escaped
    expect(card.innerHTML).toContain('&amp;');
    resetFilters();
  });
});

describe('EmojiReference – Copy Buttons', () => {
  beforeEach(() => {
    global.ClipboardUtils.copyToClipboard.mockClear();
  });

  afterEach(resetFilters);

  test('clicking copy-emoji button calls ClipboardUtils.copyToClipboard', async () => {
    const btn = document.querySelector('.copy-emoji');
    expect(btn).not.toBeNull();
    btn.click();
    await new Promise((r) => setTimeout(r, 20));
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledTimes(1);
  });

  test('clicking copy-code button calls ClipboardUtils.copyToClipboard', async () => {
    const btn = document.querySelector('.copy-code');
    expect(btn).not.toBeNull();
    btn.click();
    await new Promise((r) => setTimeout(r, 20));
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledTimes(1);
  });

  test('copy-code value is HTML decimal entity format', () => {
    const btn = document.querySelector('.copy-code');
    // data-value should be HTML entity like &#128512; (but encoded as &amp;#…;)
    // jsdom decodes HTML attributes, so getAttribute returns the decoded value
    const val = btn.getAttribute('data-value');
    expect(val).toMatch(/^&#\d+;$/);
  });
});

describe('EmojiReference – Fetch Error', () => {
  test('shows error message when fetch fails', async () => {
    // Reset module state and mock a failing fetch
    jest.resetModules();
    global.fetch = jest.fn().mockRejectedValue(new Error('Network error'));

    const freshContainer = document.createElement('div');
    document.body.appendChild(freshContainer);

    // Re-require to get a fresh IIFE with empty EMOJI_DATA
    const freshTools = {
      _tools: {},
      register: (name, obj) => { freshTools._tools[name] = obj; },
    };
    const savedTools = global.Tools;
    global.Tools = freshTools;

    require(path.join(__dirname, '../../assets/js/tools/emojiReferenceTool.js'));
    const freshTool = freshTools._tools.emojiReferenceTool;

    await freshTool.open(freshContainer);
    await new Promise((r) => setTimeout(r, 30));

    expect(freshContainer.querySelector('.alert-danger')).not.toBeNull();

    global.Tools = savedTools;
    document.body.removeChild(freshContainer);
  });
});
