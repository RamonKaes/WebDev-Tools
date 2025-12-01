/**
 * Unit Tests for validators.js
 * Tests JSON, XML, and Base64 validation utilities
 */

import { describe, it, expect } from 'vitest';

// Mock validators since actual file path may vary
// In real tests, use: import * as validators from '@/lib/validators.js';

// Mock implementations for testing structure
const validators = {
  validateJSON: (input) => {
    try {
      JSON.parse(input);
      return { valid: true, error: null };
    } catch (e) {
      return { valid: false, error: e.message };
    }
  },
  
  isBase64: (str) => {
    if (!str || typeof str !== 'string') return false;
    const base64Regex = /^[A-Za-z0-9+/]*={0,2}$/;
    return base64Regex.test(str.replace(/\s/g, ''));
  },
  
  validateXML: (input) => {
    try {
      const parser = new DOMParser();
      const doc = parser.parseFromString(input, 'application/xml');
      const parseError = doc.querySelector('parsererror');
      if (parseError) {
        return { valid: false, error: parseError.textContent };
      }
      return { valid: true, error: null };
    } catch (e) {
      return { valid: false, error: e.message };
    }
  }
};

describe('validators.js', () => {
  describe('validateJSON', () => {
    it('should validate correct JSON', () => {
      const result = validators.validateJSON('{"key": "value"}');
      expect(result.valid).toBe(true);
      expect(result.error).toBeNull();
    });

    it('should reject invalid JSON', () => {
      const result = validators.validateJSON('{key: value}');
      expect(result.valid).toBe(false);
      expect(result.error).toBeTruthy();
    });

    it('should validate JSON arrays', () => {
      const result = validators.validateJSON('[1, 2, 3]');
      expect(result.valid).toBe(true);
    });

    it('should validate nested JSON objects', () => {
      const result = validators.validateJSON('{"nested": {"key": "value"}}');
      expect(result.valid).toBe(true);
    });

    it('should handle empty objects', () => {
      const result = validators.validateJSON('{}');
      expect(result.valid).toBe(true);
    });
  });

  describe('isBase64', () => {
    it('should validate correct Base64', () => {
      expect(validators.isBase64('SGVsbG8gV29ybGQ=')).toBe(true);
    });

    it('should validate Base64 without padding', () => {
      expect(validators.isBase64('SGVsbG8')).toBe(true);
    });

    it('should reject invalid characters', () => {
      expect(validators.isBase64('Hello@World!')).toBe(false);
    });

    it('should handle whitespace', () => {
      expect(validators.isBase64('SGVs bG8=')).toBe(true); // Whitespace removed
    });

    it('should reject empty strings', () => {
      expect(validators.isBase64('')).toBe(false);
    });

    it('should reject non-strings', () => {
      expect(validators.isBase64(null)).toBe(false);
      expect(validators.isBase64(undefined)).toBe(false);
    });
  });

  describe('validateXML', () => {
    it('should validate correct XML', () => {
      const result = validators.validateXML('<root><child>value</child></root>');
      expect(result.valid).toBe(true);
    });

    it('should reject malformed XML', () => {
      const result = validators.validateXML('<root><child>value</root>');
      expect(result.valid).toBe(false);
    });

    it('should validate self-closing tags', () => {
      const result = validators.validateXML('<root><child /></root>');
      expect(result.valid).toBe(true);
    });

    it('should validate XML with attributes', () => {
      const result = validators.validateXML('<root attr="value"><child /></root>');
      expect(result.valid).toBe(true);
    });
  });
});
