'use strict';

/**
 * Unit tests for i18n.js
 *
 * Tests cover: placeholder interpolation with both {{name}} and {name}
 * syntax, missing parameters, and plain lookups.
 */

const path = require('path');

let i18n = null;

beforeAll(() => {
  require(path.join(__dirname, '../../assets/js/i18n.js'));
  i18n = window.i18n;
  i18n.currentLang = 'en';
  i18n.translations.en = {
    common: { copy: 'Copy' },
    tools: {
      base64EncoderDecoder: { detected_type: 'Detected type: {type}' },
      regexTesterTool: { match_label: 'Match {number}' },
      sriGeneratorTool: { errors: { fetchError: 'HTTP error {status} while fetching the resource.' } },
      demo: { both: '{{a}} and {b}', keep: 'Value {missing} stays' }
    }
  };
});

describe('i18n – interpolation', () => {
  test('returns plain translations', () => {
    expect(i18n.t('common.copy')).toBe('Copy');
  });

  test('replaces single-brace placeholders used by the translation files', () => {
    expect(i18n.t('tools.base64EncoderDecoder.detected_type', { type: 'image/png' })).toBe('Detected type: image/png');
    expect(i18n.t('tools.regexTesterTool.match_label', { number: 3 })).toBe('Match 3');
    expect(i18n.t('tools.sriGeneratorTool.errors.fetchError', { status: 404 })).toBe('HTTP error 404 while fetching the resource.');
  });

  test('replaces double-brace placeholders as well', () => {
    expect(i18n.t('tools.demo.both', { a: 'X', b: 'Y' })).toBe('X and Y');
  });

  test('leaves unknown placeholders untouched', () => {
    expect(i18n.t('tools.demo.keep', { other: 1 })).toBe('Value {missing} stays');
  });

  test('does not interpolate when no params are given', () => {
    expect(i18n.t('tools.regexTesterTool.match_label')).toBe('Match {number}');
  });
});

describe('i18n – language URL building', () => {
  afterEach(() => {
    delete window.__BASE_PATH__;
    window.history.replaceState(null, '', '/');
  });

  test('adds and replaces the language prefix', () => {
    window.history.replaceState(null, '', '/lorem-ipsum/?x=1');
    expect(i18n.buildLanguageURL('de')).toBe(`${window.location.origin}/de/lorem-ipsum/?x=1`);
    window.history.replaceState(null, '', '/de/lorem-ipsum/');
    expect(i18n.buildLanguageURL('fr')).toBe(`${window.location.origin}/fr/lorem-ipsum/`);
    expect(i18n.buildLanguageURL('en')).toBe(`${window.location.origin}/lorem-ipsum/`);
  });

  test('returns null when already on the requested language', () => {
    window.history.replaceState(null, '', '/de/lorem-ipsum/');
    expect(i18n.buildLanguageURL('de')).toBeNull();
  });

  test('never navigates to another origin (protocol-relative path)', () => {
    // Stripping "/de" from "/de//evil.example/" would yield "//evil.example/"
    window.history.replaceState(null, '', '/de//evil.example/');
    const url = i18n.buildLanguageURL('en');
    expect(new URL(url).origin).toBe(window.location.origin);
  });

  test('treats regex characters in the base path literally', () => {
    window.__BASE_PATH__ = '/Web.Tools';
    window.history.replaceState(null, '', '/WebXTools/de/foo/');
    expect(i18n.buildLanguageURL('en')).toBeNull();
    window.history.replaceState(null, '', '/Web.Tools/de/foo/');
    expect(i18n.buildLanguageURL('en')).toBe(`${window.location.origin}/Web.Tools/foo/`);
  });
});
