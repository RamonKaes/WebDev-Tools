'use strict';

/**
 * Unit tests for pxToRemConverterTool.js
 *
 * Tests cover: registration, UI rendering, px→rem/em/percent/tailwind
 * conversion, reverse conversion, preset buttons, clear buttons,
 * copy buttons, and the conversion reference table.
 */

const path = require('path');

let tool = null;

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  global.window = global;

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

  require(path.join(__dirname, '../../assets/js/tools/pxToRemConverterTool.js'));

  tool = global.Tools._tools.pxToRemConverter;
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

function setPxInput(container, value) {
  const input = container.querySelector('#pxInput');
  input.value = value;
  input.dispatchEvent(new Event('input', { bubbles: true }));
}

function setBaseFontSize(container, value) {
  const input = container.querySelector('#baseFontSize');
  input.value = value;
  input.dispatchEvent(new Event('input', { bubbles: true }));
}

function setParentSize(container, value) {
  const input = container.querySelector('#parentSize');
  input.value = value;
  input.dispatchEvent(new Event('input', { bubbles: true }));
}

function setReverseInput(container, value) {
  const input = container.querySelector('#reverseInput');
  input.value = value;
  input.dispatchEvent(new Event('input', { bubbles: true }));
}

function setReverseUnit(container, value) {
  const select = container.querySelector('#reverseUnitType');
  select.value = value;
  select.dispatchEvent(new Event('change', { bubbles: true }));
}

// ─── Registration ─────────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Registration', () => {
  test('registers under "pxToRemConverter"', () => {
    expect(tool).toBeDefined();
  });

  test('exposes open function', () => {
    expect(typeof tool.open).toBe('function');
  });
});

// ─── UI Rendering ─────────────────────────────────────────────────────────────

describe('pxToRemConverterTool – UI Rendering', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('renders baseFontSize input with default 16', () => {
    expect(c.querySelector('#baseFontSize').value).toBe('16');
  });

  test('renders parentSize input with default 16', () => {
    expect(c.querySelector('#parentSize').value).toBe('16');
  });

  test('renders px input', () => {
    expect(c.querySelector('#pxInput')).not.toBeNull();
  });

  test('renders remOutput as readonly', () => {
    expect(c.querySelector('#remOutput').readOnly).toBe(true);
  });

  test('renders emOutput as readonly', () => {
    expect(c.querySelector('#emOutput').readOnly).toBe(true);
  });

  test('renders percentOutput as readonly', () => {
    expect(c.querySelector('#percentOutput').readOnly).toBe(true);
  });

  test('renders tailwindOutput as readonly', () => {
    expect(c.querySelector('#tailwindOutput').readOnly).toBe(true);
  });

  test('renders reverse input', () => {
    expect(c.querySelector('#reverseInput')).not.toBeNull();
  });

  test('renders reverse unit select', () => {
    expect(c.querySelector('#reverseUnitType')).not.toBeNull();
  });

  test('renders reversePxOutput as readonly', () => {
    expect(c.querySelector('#reversePxOutput').readOnly).toBe(true);
  });

  test('renders conversion table', () => {
    expect(c.querySelector('#conversionTable')).not.toBeNull();
  });

  test('renders 5 base font size preset buttons', () => {
    expect(c.querySelectorAll('.preset-btn').length).toBe(5);
  });

  test('renders 8 px quick-value preset buttons', () => {
    expect(c.querySelectorAll('.px-preset').length).toBe(8);
  });

  test('renders clearPx button', () => {
    expect(c.querySelector('#clearPx')).not.toBeNull();
  });

  test('renders clearReverse button', () => {
    expect(c.querySelector('#clearReverse')).not.toBeNull();
  });

  test('renders copy buttons', () => {
    expect(c.querySelectorAll('.copy-btn').length).toBeGreaterThan(0);
  });
});

// ─── Conversion: px → rem/em/percent/tailwind ─────────────────────────────────

describe('pxToRemConverterTool – px → rem (base 16)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('16px → 1.0000 rem', () => {
    setPxInput(c, 16);
    expect(c.querySelector('#remOutput').value).toBe('1.0000 rem');
  });

  test('24px → 1.5000 rem', () => {
    setPxInput(c, 24);
    expect(c.querySelector('#remOutput').value).toBe('1.5000 rem');
  });

  test('8px → 0.5000 rem', () => {
    setPxInput(c, 8);
    expect(c.querySelector('#remOutput').value).toBe('0.5000 rem');
  });

  test('0px → 0.0000 rem', () => {
    setPxInput(c, 0);
    expect(c.querySelector('#remOutput').value).toBe('0.0000 rem');
  });

  test('empty input clears remOutput', () => {
    setPxInput(c, 16);
    setPxInput(c, '');
    expect(c.querySelector('#remOutput').value).toBe('');
  });
});

describe('pxToRemConverterTool – px → rem (custom base)', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('32px with base 32 → 1.0000 rem', () => {
    setBaseFontSize(c, 32);
    setPxInput(c, 32);
    expect(c.querySelector('#remOutput').value).toBe('1.0000 rem');
  });

  test('16px with base 10 → 1.6000 rem', () => {
    setBaseFontSize(c, 10);
    setPxInput(c, 16);
    expect(c.querySelector('#remOutput').value).toBe('1.6000 rem');
  });
});

describe('pxToRemConverterTool – px → em', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('16px with parent 16 → 1.0000 em', () => {
    setPxInput(c, 16);
    expect(c.querySelector('#emOutput').value).toBe('1.0000 em');
  });

  test('24px with parent 16 → 1.5000 em', () => {
    setPxInput(c, 24);
    expect(c.querySelector('#emOutput').value).toBe('1.5000 em');
  });

  test('16px with parent 32 → 0.5000 em', () => {
    setParentSize(c, 32);
    setPxInput(c, 16);
    expect(c.querySelector('#emOutput').value).toBe('0.5000 em');
  });
});

describe('pxToRemConverterTool – px → percent', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('16px → 100.00%', () => {
    setPxInput(c, 16);
    expect(c.querySelector('#percentOutput').value).toBe('100.00%');
  });

  test('8px → 50.00%', () => {
    setPxInput(c, 8);
    expect(c.querySelector('#percentOutput').value).toBe('50.00%');
  });

  test('24px → 150.00%', () => {
    setPxInput(c, 24);
    expect(c.querySelector('#percentOutput').value).toBe('150.00%');
  });
});

describe('pxToRemConverterTool – px → tailwind', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('16px → 4.00 (tailwind)', () => {
    setPxInput(c, 16);
    expect(c.querySelector('#tailwindOutput').value).toBe('4.00');
  });

  test('4px → 1.00 (tailwind)', () => {
    setPxInput(c, 4);
    expect(c.querySelector('#tailwindOutput').value).toBe('1.00');
  });

  test('32px → 8.00 (tailwind)', () => {
    setPxInput(c, 32);
    expect(c.querySelector('#tailwindOutput').value).toBe('8.00');
  });
});

// ─── Reverse Conversion ───────────────────────────────────────────────────────

describe('pxToRemConverterTool – Reverse: rem → px', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('1 rem → 16.00 px', () => {
    setReverseInput(c, 1);
    expect(c.querySelector('#reversePxOutput').value).toBe('16.00 px');
  });

  test('1.5 rem → 24.00 px', () => {
    setReverseInput(c, 1.5);
    expect(c.querySelector('#reversePxOutput').value).toBe('24.00 px');
  });

  test('0 rem → 0.00 px', () => {
    setReverseInput(c, 0);
    expect(c.querySelector('#reversePxOutput').value).toBe('0.00 px');
  });

  test('empty input clears reversePxOutput', () => {
    setReverseInput(c, 1);
    setReverseInput(c, '');
    expect(c.querySelector('#reversePxOutput').value).toBe('');
  });
});

describe('pxToRemConverterTool – Reverse: em → px', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('1 em → 16.00 px (parent 16)', () => {
    setReverseUnit(c, 'em');
    setReverseInput(c, 1);
    expect(c.querySelector('#reversePxOutput').value).toBe('16.00 px');
  });

  test('2 em with parent 20 → 40.00 px', () => {
    setParentSize(c, 20);
    setReverseUnit(c, 'em');
    setReverseInput(c, 2);
    expect(c.querySelector('#reversePxOutput').value).toBe('40.00 px');
  });
});

describe('pxToRemConverterTool – Reverse: percent → px', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('100% → 16.00 px', () => {
    setReverseUnit(c, 'percent');
    setReverseInput(c, 100);
    expect(c.querySelector('#reversePxOutput').value).toBe('16.00 px');
  });

  test('50% → 8.00 px', () => {
    setReverseUnit(c, 'percent');
    setReverseInput(c, 50);
    expect(c.querySelector('#reversePxOutput').value).toBe('8.00 px');
  });
});

describe('pxToRemConverterTool – Reverse: tailwind → px', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('4 tailwind → 16.00 px', () => {
    setReverseUnit(c, 'tailwind');
    setReverseInput(c, 4);
    expect(c.querySelector('#reversePxOutput').value).toBe('16.00 px');
  });

  test('1 tailwind → 4.00 px', () => {
    setReverseUnit(c, 'tailwind');
    setReverseInput(c, 1);
    expect(c.querySelector('#reversePxOutput').value).toBe('4.00 px');
  });
});

// ─── Preset Buttons ───────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Base font size preset buttons', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clicking 12px preset sets baseFontSize to 12', () => {
    c.querySelector('.preset-btn[data-size="12"]').click();
    expect(c.querySelector('#baseFontSize').value).toBe('12');
  });

  test('clicking 20px preset updates rem output (16px / 20 = 0.8000)', () => {
    setPxInput(c, 16);
    c.querySelector('.preset-btn[data-size="20"]').click();
    expect(c.querySelector('#remOutput').value).toBe('0.8000 rem');
  });

  test('active preset button gets btn-primary class', () => {
    c.querySelector('.preset-btn[data-size="12"]').click();
    expect(c.querySelector('.preset-btn[data-size="12"]').classList.contains('btn-primary')).toBe(true);
  });

  test('previous active preset loses btn-primary class', () => {
    c.querySelector('.preset-btn[data-size="12"]').click();
    expect(c.querySelector('.preset-btn[data-size="16"]').classList.contains('btn-primary')).toBe(false);
  });
});

describe('pxToRemConverterTool – Quick PX preset buttons', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clicking 32 preset fills px input with 32', () => {
    c.querySelector('.px-preset[data-px="32"]').click();
    expect(c.querySelector('#pxInput').value).toBe('32');
  });

  test('clicking 32 preset produces 2.0000 rem', () => {
    c.querySelector('.px-preset[data-px="32"]').click();
    expect(c.querySelector('#remOutput').value).toBe('2.0000 rem');
  });
});

// ─── Clear Buttons ────────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Clear buttons', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('clearPx clears pxInput and outputs', () => {
    setPxInput(c, 16);
    c.querySelector('#clearPx').click();
    expect(c.querySelector('#pxInput').value).toBe('');
    expect(c.querySelector('#remOutput').value).toBe('');
  });

  test('clearReverse clears reverseInput and reversePxOutput', () => {
    setReverseInput(c, 1);
    c.querySelector('#clearReverse').click();
    expect(c.querySelector('#reverseInput').value).toBe('');
    expect(c.querySelector('#reversePxOutput').value).toBe('');
  });
});

// ─── Copy Buttons ─────────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Copy buttons', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('copy remOutput calls ClipboardUtils with rem value', async () => {
    setPxInput(c, 16);
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="remOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('1.0000 rem');
  });

  test('copy emOutput calls ClipboardUtils with em value', async () => {
    setPxInput(c, 16);
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="emOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('1.0000 em');
  });

  test('copy percentOutput calls ClipboardUtils with percent value', async () => {
    setPxInput(c, 16);
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="percentOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('100.00%');
  });

  test('copy tailwindOutput calls ClipboardUtils with tailwind value', async () => {
    setPxInput(c, 16);
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="tailwindOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('4.00');
  });

  test('copy reversePxOutput calls ClipboardUtils with px value', async () => {
    setReverseInput(c, 1);
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="reversePxOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).toHaveBeenCalledWith('16.00 px');
  });

  test('does not call copyToClipboard when output is empty', async () => {
    global.ClipboardUtils.copyToClipboard.mockClear();
    c.querySelector('.copy-btn[data-target="remOutput"]').click();
    await Promise.resolve();
    expect(global.ClipboardUtils.copyToClipboard).not.toHaveBeenCalled();
  });
});

// ─── Conversion Table ─────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Conversion Table', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('table renders 16 rows', () => {
    expect(c.querySelectorAll('#conversionTable tbody tr').length).toBe(16);
  });

  test('first row shows 4px', () => {
    const firstRow = c.querySelector('#conversionTable tbody tr:first-child');
    expect(firstRow.textContent).toContain('4px');
  });

  test('clicking a table row fills pxInput', () => {
    const firstRow = c.querySelector('#conversionTable tbody tr:first-child');
    firstRow.click();
    expect(c.querySelector('#pxInput').value).toBe('4');
  });

  test('clicking a table row triggers conversion', () => {
    const rows = c.querySelectorAll('#conversionTable tbody tr');
    // 3rd row = 12px → 0.7500 rem
    rows[2].click();
    expect(c.querySelector('#remOutput').value).toBe('0.7500 rem');
  });

  test('table updates when base font size changes', () => {
    setBaseFontSize(c, 10);
    // 4px / 10 = 0.4000 rem
    const firstRow = c.querySelector('#conversionTable tbody tr:first-child');
    expect(firstRow.textContent).toContain('0.4000');
  });
});

// ─── Reverse Labels ───────────────────────────────────────────────────────────

describe('pxToRemConverterTool – Reverse unit labels', () => {
  let c;
  beforeEach(() => { c = openTool(); });
  afterEach(() => cleanup(c));

  test('default reverse label is REM', () => {
    expect(c.querySelector('#reverseInputLabel').textContent).toBe('REM');
  });

  test('switching to em updates label to EM', () => {
    setReverseUnit(c, 'em');
    expect(c.querySelector('#reverseInputLabel').textContent).toBe('EM');
  });

  test('switching to tailwind clears unit suffix', () => {
    setReverseUnit(c, 'tailwind');
    expect(c.querySelector('#reverseInputUnit').textContent).toBe('');
  });
});
