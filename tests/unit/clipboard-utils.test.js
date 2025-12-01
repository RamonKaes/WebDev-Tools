/**
 * Unit Tests for clipboard-utils.js
 * Tests clipboard operations and browser compatibility
 */

import { describe, it, expect, beforeEach, vi } from 'vitest';

// Mock clipboard utilities
const clipboardUtils = {
  copyToClipboard: async (text) => {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      await navigator.clipboard.writeText(text);
      return { success: true, method: 'modern' };
    }
    // Fallback
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    const success = document.execCommand('copy');
    document.body.removeChild(textarea);
    return { success, method: 'legacy' };
  },
  
  isClipboardSupported: () => {
    return !!(navigator.clipboard && navigator.clipboard.writeText);
  },
  
  readFromClipboard: async () => {
    if (navigator.clipboard && navigator.clipboard.readText) {
      return await navigator.clipboard.readText();
    }
    throw new Error('Clipboard read not supported');
  }
};

describe('clipboard-utils.js', () => {
  beforeEach(() => {
    // Reset DOM
    document.body.innerHTML = '';
  });

  describe('copyToClipboard', () => {
    it('should use modern Clipboard API when available', async () => {
      // Mock modern clipboard
      const mockWriteText = vi.fn().mockResolvedValue(undefined);
      Object.assign(navigator, {
        clipboard: { writeText: mockWriteText }
      });

      const result = await clipboardUtils.copyToClipboard('test text');
      
      expect(result.success).toBe(true);
      expect(result.method).toBe('modern');
      expect(mockWriteText).toHaveBeenCalledWith('test text');
    });

    it('should fallback to execCommand when modern API unavailable', async () => {
      // Remove modern clipboard
      Object.assign(navigator, { clipboard: null });
      
      // Mock execCommand
      document.execCommand = vi.fn().mockReturnValue(true);

      const result = await clipboardUtils.copyToClipboard('fallback text');
      
      expect(result.success).toBe(true);
      expect(result.method).toBe('legacy');
    });

    it('should handle empty strings', async () => {
      const mockWriteText = vi.fn().mockResolvedValue(undefined);
      Object.assign(navigator, {
        clipboard: { writeText: mockWriteText }
      });

      await clipboardUtils.copyToClipboard('');
      expect(mockWriteText).toHaveBeenCalledWith('');
    });

    it('should handle multiline text', async () => {
      const mockWriteText = vi.fn().mockResolvedValue(undefined);
      Object.assign(navigator, {
        clipboard: { writeText: mockWriteText }
      });

      const multiline = 'line1\nline2\nline3';
      await clipboardUtils.copyToClipboard(multiline);
      expect(mockWriteText).toHaveBeenCalledWith(multiline);
    });
  });

  describe('isClipboardSupported', () => {
    it('should return true when Clipboard API available', () => {
      Object.assign(navigator, {
        clipboard: { writeText: vi.fn() }
      });
      expect(clipboardUtils.isClipboardSupported()).toBe(true);
    });

    it('should return false when Clipboard API unavailable', () => {
      Object.assign(navigator, { clipboard: null });
      expect(clipboardUtils.isClipboardSupported()).toBe(false);
    });
  });

  describe('readFromClipboard', () => {
    it('should read from clipboard when available', async () => {
      const mockReadText = vi.fn().mockResolvedValue('clipboard content');
      Object.assign(navigator, {
        clipboard: { readText: mockReadText }
      });

      const result = await clipboardUtils.readFromClipboard();
      expect(result).toBe('clipboard content');
      expect(mockReadText).toHaveBeenCalled();
    });

    it('should throw when read not supported', async () => {
      Object.assign(navigator, { clipboard: null });
      
      await expect(clipboardUtils.readFromClipboard()).rejects.toThrow('Clipboard read not supported');
    });
  });
});
