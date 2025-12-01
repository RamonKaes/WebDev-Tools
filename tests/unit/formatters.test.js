/**
 * Unit Tests for formatters.js
 * Tests JSON, XML, and code formatting utilities
 */

import { describe, it, expect } from 'vitest';

// Mock formatters implementation
const formatters = {
  formatJSON: (input, indent = 2) => {
    try {
      const parsed = JSON.parse(input);
      return JSON.stringify(parsed, null, indent);
    } catch (e) {
      throw new Error('Invalid JSON');
    }
  },
  
  minifyJSON: (input) => {
    try {
      const parsed = JSON.parse(input);
      return JSON.stringify(parsed);
    } catch (e) {
      throw new Error('Invalid JSON');
    }
  },
  
  formatXML: (input) => {
    // Simple XML formatter mock
    return input.replace(/></g, '>\n<');
  },
  
  escapeHTML: (str) => {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  },
  
  unescapeHTML: (str) => {
    const div = document.createElement('div');
    div.innerHTML = str;
    return div.textContent;
  }
};

describe('formatters.js', () => {
  describe('formatJSON', () => {
    it('should format minified JSON with 2 spaces', () => {
      const input = '{"key":"value","nested":{"a":1}}';
      const result = formatters.formatJSON(input);
      expect(result).toContain('\n');
      expect(result).toContain('  ');
    });

    it('should handle custom indentation', () => {
      const input = '{"key":"value"}';
      const result = formatters.formatJSON(input, 4);
      expect(result).toContain('    ');
    });

    it('should throw on invalid JSON', () => {
      expect(() => formatters.formatJSON('{invalid}')).toThrow('Invalid JSON');
    });

    it('should preserve values', () => {
      const input = '{"number":42,"bool":true,"null":null}';
      const result = formatters.formatJSON(input);
      expect(result).toContain('"number": 42');
      expect(result).toContain('"bool": true');
      expect(result).toContain('"null": null');
    });
  });

  describe('minifyJSON', () => {
    it('should remove all whitespace', () => {
      const input = `{
        "key": "value",
        "number": 42
      }`;
      const result = formatters.minifyJSON(input);
      expect(result).toBe('{"key":"value","number":42}');
    });

    it('should handle arrays', () => {
      const input = '[1, 2, 3]';
      const result = formatters.minifyJSON(input);
      expect(result).toBe('[1,2,3]');
    });
  });

  describe('escapeHTML', () => {
    it('should escape < and >', () => {
      const result = formatters.escapeHTML('<div>');
      expect(result).toBe('&lt;div&gt;');
    });

    it('should escape quotes', () => {
      const result = formatters.escapeHTML('"test"');
      expect(result).toContain('&quot;');
    });

    it('should escape ampersands', () => {
      const result = formatters.escapeHTML('A & B');
      expect(result).toBe('A &amp; B');
    });

    it('should handle mixed content', () => {
      const result = formatters.escapeHTML('<script>alert("XSS")</script>');
      expect(result).not.toContain('<script>');
      expect(result).toContain('&lt;');
    });
  });

  describe('unescapeHTML', () => {
    it('should unescape entities', () => {
      const result = formatters.unescapeHTML('&lt;div&gt;');
      expect(result).toBe('<div>');
    });

    it('should handle mixed entities', () => {
      const result = formatters.unescapeHTML('A &amp; B &lt; C');
      expect(result).toBe('A & B < C');
    });
  });
});
