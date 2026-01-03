/**
 * Global Helper Utilities
 *
 * Provides XSS protection and common utilities for all tools.
 */

(function() {
  'use strict';

  window.AppHelpers = {
    /**
     * Escape HTML special characters to prevent XSS attacks
     *
     * Converts dangerous characters to HTML entities for safe display in text content.
     *
     * @param {string} unsafe - Untrusted user input or external data
     * @returns {string} Safely escaped string
     *
     * @example
     * const safe = AppHelpers.escapeHtml('<script>alert("XSS")</script>');
     * // Returns: '&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;'
     */
    escapeHtml: function(unsafe) {
      if (typeof unsafe !== 'string') {
        return '';
      }

      return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    },

    /**
     * Escape values for safe use in HTML attributes
     *
     * More comprehensive than escapeHtml - includes forward slash escaping
     * for additional security in attribute contexts.
     *
     * @param {string} unsafe - Untrusted attribute value
     * @returns {string} Safely escaped attribute string
     *
     * @example
     * const attr = AppHelpers.escapeAttr(userInput);
     * element.setAttribute('data-value', attr);
     */
    escapeAttr: function(unsafe) {
      if (typeof unsafe !== 'string') {
        return '';
      }

      return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#x27;")
        .replace(/\//g, "&#x2F;");
    }
  };

  if (typeof console !== 'undefined' && console.log) {
    console.log('[AppHelpers] Global utilities loaded');
  }
})();
