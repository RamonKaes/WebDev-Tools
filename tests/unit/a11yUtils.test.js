'use strict';

/**
 * Unit tests for lib/a11y-utils.js
 *
 * Tests cover: live region creation and ARIA attributes, debouncing of rapid
 * announcements, re-announcing identical messages, assertive mode and clearing.
 */

const path = require('path');

const REGION_ID = 'a11y-live-region';

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  require(path.join(__dirname, '../../assets/js/lib/a11y-utils.js'));
});

beforeEach(() => {
  jest.useFakeTimers();
  document.body.innerHTML = '';
  window.A11yUtils.clearAnnouncements();
});

afterEach(() => {
  jest.useRealTimers();
});

/**
 * Run all timers needed for one announcement to land in the DOM
 */
function flushAnnouncement() {
  jest.advanceTimersByTime(400); // debounce
  jest.advanceTimersByTime(50); // reset-then-set gap
}

function region() {
  return document.getElementById(REGION_ID);
}

// ─── Tests ────────────────────────────────────────────────────────────────────

describe('A11yUtils.announce', () => {
  test('creates a visually hidden polite live region', () => {
    window.A11yUtils.announce('3 results');
    flushAnnouncement();

    const el = region();
    expect(el).not.toBeNull();
    expect(el.getAttribute('aria-live')).toBe('polite');
    expect(el.getAttribute('aria-atomic')).toBe('true');
    expect(el.className).toBe('visually-hidden');
    expect(el.textContent).toBe('3 results');
  });

  test('debounces rapid calls into a single final announcement', () => {
    window.A11yUtils.announce('1 result');
    jest.advanceTimersByTime(100);
    window.A11yUtils.announce('2 results');
    jest.advanceTimersByTime(100);
    window.A11yUtils.announce('42 results');

    // Nothing announced yet - still inside the debounce window
    expect(region()).toBeNull();

    flushAnnouncement();
    expect(region().textContent).toBe('42 results');
  });

  test('clears the region before setting text so repeats are re-announced', () => {
    window.A11yUtils.announce('same message');
    flushAnnouncement();
    expect(region().textContent).toBe('same message');

    window.A11yUtils.announce('same message');
    jest.advanceTimersByTime(400);
    // Reset happened, text not yet re-applied
    expect(region().textContent).toBe('');

    jest.advanceTimersByTime(50);
    expect(region().textContent).toBe('same message');
  });

  test('releases the text after the hold period', () => {
    window.A11yUtils.announce('transient');
    flushAnnouncement();
    expect(region().textContent).toBe('transient');

    jest.advanceTimersByTime(5000);
    expect(region().textContent).toBe('');
  });

  test('supports assertive announcements', () => {
    window.A11yUtils.announce('critical', { assertive: true });
    flushAnnouncement();

    expect(region().getAttribute('aria-live')).toBe('assertive');
  });

  test('honours a custom debounce delay', () => {
    window.A11yUtils.announce('fast', { delay: 0 });
    jest.advanceTimersByTime(0);
    jest.advanceTimersByTime(50);

    expect(region().textContent).toBe('fast');
  });

  test('ignores empty messages', () => {
    window.A11yUtils.announce('');
    flushAnnouncement();
    expect(region()).toBeNull();

    window.A11yUtils.announce(null);
    flushAnnouncement();
    expect(region()).toBeNull();
  });

  test('reuses a single region across announcements', () => {
    window.A11yUtils.announce('first');
    flushAnnouncement();
    window.A11yUtils.announce('second');
    flushAnnouncement();

    expect(document.querySelectorAll(`#${REGION_ID}`).length).toBe(1);
    expect(region().textContent).toBe('second');
  });
});

describe('A11yUtils.clearAnnouncements', () => {
  test('cancels a pending announcement', () => {
    window.A11yUtils.announce('never shown');
    window.A11yUtils.clearAnnouncements();
    flushAnnouncement();

    expect(region()).toBeNull();
  });

  test('empties an already rendered region', () => {
    window.A11yUtils.announce('visible');
    flushAnnouncement();
    expect(region().textContent).toBe('visible');

    window.A11yUtils.clearAnnouncements();
    expect(region().textContent).toBe('');
  });
});
