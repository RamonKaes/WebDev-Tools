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
