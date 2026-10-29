'use strict';

/**
 * Unit tests for lib/download-utils.js
 *
 * Tests cover: the global window.DownloadUtils API the tool scripts rely on,
 * filename sanitization, MIME whitelist and the anchor-based text download.
 */

const fs = require('fs');
const path = require('path');

const LIB_PATH = path.join(__dirname, '../../assets/js/lib/download-utils.js');

// ─── Global mock setup ────────────────────────────────────────────────────────

beforeAll(() => {
  URL.createObjectURL = jest.fn(() => 'blob:mock');
  URL.revokeObjectURL = jest.fn();
  require(LIB_PATH);
});

beforeEach(() => {
  jest.useFakeTimers();
  document.body.innerHTML = '';
  URL.createObjectURL.mockClear();
  URL.revokeObjectURL.mockClear();
});

afterEach(() => {
  jest.useRealTimers();
});

// ─── Global API ───────────────────────────────────────────────────────────────

describe('global API', () => {
  test('is a classic script, not an ES module', () => {
    // Tool scripts load it via a plain <script> tag; an export would be a syntax error there
    expect(fs.readFileSync(LIB_PATH, 'utf8')).not.toMatch(/^\s*export\s/m);
  });

  test('exposes the download helpers on window.DownloadUtils', () => {
    ['downloadText', 'downloadJSON', 'downloadBlob', 'downloadCSV', 'sanitizeFilename'].forEach(fn => {
      expect(typeof window.DownloadUtils[fn]).toBe('function');
    });
  });

  test('is loaded on every page via common-scripts.php', () => {
    const partial = fs.readFileSync(path.join(__dirname, '../../partials/common-scripts.php'), 'utf8');
    expect(partial).toContain("js/lib/download-utils.js");
  });
});

// ─── sanitizeFilename ─────────────────────────────────────────────────────────

describe('sanitizeFilename', () => {
  test('keeps a normal filename', () => {
    expect(window.DownloadUtils.sanitizeFilename('uuids.txt')).toBe('uuids.txt');
  });

  test('replaces path separators', () => {
    expect(window.DownloadUtils.sanitizeFilename('../etc/passwd')).toBe('_etc_passwd');
  });

  test('falls back for empty or invalid input', () => {
    expect(window.DownloadUtils.sanitizeFilename('')).toBe('download.txt');
    expect(window.DownloadUtils.sanitizeFilename(null)).toBe('download.txt');
  });
});

// ─── downloadText ─────────────────────────────────────────────────────────────

describe('downloadText', () => {
  test('clicks a hidden anchor with the sanitized filename', () => {
    const clickSpy = jest.spyOn(HTMLAnchorElement.prototype, 'click').mockImplementation(function() {
      expect(this.download).toBe('html-entities.txt');
      expect(this.href).toBe('blob:mock');
    });

    window.DownloadUtils.downloadText('&amp;', 'html-entities.txt');

    expect(clickSpy).toHaveBeenCalledTimes(1);
    expect(URL.createObjectURL).toHaveBeenCalledWith(expect.any(Blob));

    jest.advanceTimersByTime(100);
    expect(document.querySelector('a')).toBeNull();
    expect(URL.revokeObjectURL).toHaveBeenCalledWith('blob:mock');

    clickSpy.mockRestore();
  });

  test('falls back to octet-stream for a MIME type outside the whitelist', () => {
    const warnSpy = jest.spyOn(console, 'warn').mockImplementation(() => {});
    const clickSpy = jest.spyOn(HTMLAnchorElement.prototype, 'click').mockImplementation(() => {});

    window.DownloadUtils.downloadText('x', 'x.bin', 'application/x-evil');

    expect(URL.createObjectURL.mock.calls[0][0].type).toBe('application/octet-stream');

    clickSpy.mockRestore();
    warnSpy.mockRestore();
  });
});
