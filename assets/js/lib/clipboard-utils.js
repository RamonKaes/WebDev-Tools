/**
 * Clipboard Utilities
 *
 * Centralized clipboard operations with modern Clipboard API and secure fallbacks.
 * Provides consistent error handling and user feedback across all tools.
 */

(function() {
  'use strict';

  /**
   * Copy text to clipboard using modern Clipboard API with fallback
   *
   * @param {string} text - Text to copy
   * @returns {Promise<boolean>} - True on success
   */
  async function copyToClipboard(text) {
    if (!text) {
      console.warn('[clipboard-utils] No text to copy');
      return false;
    }

    // Try modern Clipboard API first
    if (navigator.clipboard && navigator.clipboard.writeText) {
      try {
        await navigator.clipboard.writeText(text);
        return true;
      } catch (error) {
        console.warn('[clipboard-utils] Clipboard API failed, trying fallback:', error);
        return fallbackCopy(text);
      }
    } else {
      // Fallback for browsers without Clipboard API
      return fallbackCopy(text);
    }
  }

  /**
   * Fallback clipboard copy using textarea selection
   *
   * @param {string} text - Text to copy
   * @returns {boolean} - True if successful
   */
  function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;

    textarea.style.position = 'fixed';
    textarea.style.top = '-9999px';
    textarea.style.left = '-9999px';
    textarea.style.opacity = '0';
    textarea.style.pointerEvents = 'none';
    textarea.setAttribute('readonly', '');
    textarea.setAttribute('aria-hidden', 'true');
    textarea.setAttribute('tabindex', '-1');

    document.body.appendChild(textarea);

    try {
      textarea.focus();
      textarea.select();
      textarea.setSelectionRange(0, textarea.value.length);

      const success = document.execCommand('copy');
      document.body.removeChild(textarea);

      if (success) {
        console.info('[clipboard-utils] Fallback copy successful (execCommand)');
      } else {
        console.warn('[clipboard-utils] execCommand returned false');
      }

      return success;
    } catch (error) {
      document.body.removeChild(textarea);
      console.error('[clipboard-utils] Fallback copy failed:', error);
      return false;
    }
  }

  // Expose globally with all utility functions
  window.ClipboardUtils = {
    copyToClipboard: copyToClipboard,
    isClipboardSupported: isClipboardSupported,
    showToast: showToast,
    showCopyFeedback: showCopyFeedback,
    handleCopyButton: handleCopyButton,
    copyWithToast: copyWithToast
  };

  /**
   * Check if Clipboard API is available
   *
   * @returns {boolean} - True if supported
   */
  function isClipboardSupported() {
    return !!(navigator.clipboard && navigator.clipboard.writeText);
  }

  /**
   * Show toast notification with XSS protection
   *
   * @param {string} message - Message to display
   * @param {string} type - Toast type: 'success', 'error', 'warning', 'info'
   * @param {number} duration - Duration in ms
   */
  function showToast(message, type = 'success', duration = 3000) {
  let toastContainer = document.getElementById('clipboard-toast-container');

  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'clipboard-toast-container';
    toastContainer.setAttribute('aria-live', 'polite');
    toastContainer.setAttribute('aria-atomic', 'true');
    document.body.appendChild(toastContainer);
    addToastStyles();
  }

  const toast = document.createElement('div');
  toast.className = `clipboard-toast clipboard-toast-${type}`;
  toast.setAttribute('role', 'status');

  const icons = {
    success: '✓',
    error: '✗',
    warning: '⚠',
    info: 'ℹ'
  };

  toast.innerHTML = `
    <span class="clipboard-toast-icon">${icons[type] || icons.info}</span>
    <span class="clipboard-toast-message">${escapeHtml(message)}</span>
  `;

  toastContainer.appendChild(toast);

  setTimeout(() => toast.classList.add('clipboard-toast-show'), 10);

  setTimeout(() => {
    toast.classList.remove('clipboard-toast-show');
    setTimeout(() => {
      if (toast.parentNode) {
        toastContainer.removeChild(toast);
      }
    }, 300);
  }, duration);
}

  /**
   * Escape HTML to prevent XSS
   *
   * @param {string} html - Raw HTML string
   * @returns {string} - Escaped HTML
   */
  function escapeHtml(html) {
    if (typeof window !== 'undefined' && window.AppHelpers && typeof window.AppHelpers.escapeHtml === 'function') {
      return window.AppHelpers.escapeHtml(html);
    }

    if (typeof html !== 'string') return '';
    return html
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  /**
   * Add CSS styles for toast notifications
   */
  function addToastStyles() {
  if (document.getElementById('clipboard-toast-styles')) {
    return;
  }

  const style = document.createElement('style');
  style.id = 'clipboard-toast-styles';
  style.textContent = `
    #clipboard-toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      pointer-events: none;
    }

    .clipboard-toast {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      min-width: 250px;
      max-width: 400px;
      padding: 1rem 1.25rem;
      margin-bottom: 0.75rem;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      opacity: 0;
      transform: translateX(400px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      pointer-events: auto;
    }

    .clipboard-toast-show {
      opacity: 1;
      transform: translateX(0);
    }

    .clipboard-toast-icon {
      font-size: 1.25rem;
      font-weight: bold;
      flex-shrink: 0;
    }

    .clipboard-toast-message {
      flex: 1;
      font-size: 0.95rem;
      color: #333;
    }

    .clipboard-toast-success {
      border-left: 4px solid #28a745;
    }

    .clipboard-toast-success .clipboard-toast-icon {
      color: #28a745;
    }

    .clipboard-toast-error {
      border-left: 4px solid #dc3545;
    }

    .clipboard-toast-error .clipboard-toast-icon {
      color: #dc3545;
    }

    .clipboard-toast-warning {
      border-left: 4px solid #ffc107;
    }

    .clipboard-toast-warning .clipboard-toast-icon {
      color: #ffc107;
    }

    .clipboard-toast-info {
      border-left: 4px solid #17a2b8;
    }

    .clipboard-toast-info .clipboard-toast-icon {
      color: #17a2b8;
    }

    @media (max-width: 576px) {
      #clipboard-toast-container {
        top: 10px;
        right: 10px;
        left: 10px;
      }

      .clipboard-toast {
        min-width: auto;
        max-width: none;
      }
    }
  `;

  document.head.appendChild(style);
}

  /**
   * Show temporary success message after copying
   *
   * @param {HTMLElement} element - Element to show feedback on
   * @param {string} successText - Text to display on success
   * @param {string} originalText - Original text to restore
   * @param {number} duration - Duration in ms
   */
  function showCopyFeedback(element, successText = '✓ Copied!', originalText = null, duration = 2000) {
  const original = originalText || element.textContent;
  const originalHTML = element.innerHTML;

  element.textContent = successText;
  element.disabled = true;

  setTimeout(() => {
    if (originalText === null) {
      element.innerHTML = originalHTML;
    } else {
      element.textContent = original;
    }
    element.disabled = false;
  }, duration);
}

  /**
   * Copy button handler with automatic feedback
   *
   * @param {HTMLElement} button - Copy button element
   * @param {string|Function} textOrGetter - Text to copy or function that returns text
   * @param {object} options - Optional configuration
   * @param {string} options.successMessage - Custom success message
   * @param {string} options.errorMessage - Custom error message
   * @param {number} options.duration - Feedback duration in ms
   * @param {boolean} options.useToast - Show toast notification
   * @param {boolean} options.showButtonFeedback - Show button feedback
   * @returns {Promise<boolean>} - Success status
   */
  async function handleCopyButton(button, textOrGetter, options = {}) {
  const {
    successMessage = 'Copied to clipboard!',
    errorMessage = 'Failed to copy',
    duration = 2000,
    useToast = true,
    showButtonFeedback = true
  } = options;

  const text = typeof textOrGetter === 'function' ? textOrGetter() : textOrGetter;

  if (!text) {
    console.warn('No text to copy');
    if (useToast) {
      showToast('No content to copy', 'warning', duration);
    }
    return false;
  }

  const success = await copyToClipboard(text);

  if (success) {
    if (useToast) {
      showToast(successMessage, 'success', duration);
    }
    if (showButtonFeedback && button) {
      showCopyFeedback(button, '✓', null, duration);
    }
  } else {
    if (useToast) {
      showToast(errorMessage, 'error', duration);
    }
    if (showButtonFeedback && button) {
      showCopyFeedback(button, '✗', null, duration);
    }
  }

  return success;
}

  /**
   * Copy with toast notification (no button feedback)
   *
   * @param {string} text - Text to copy
   * @param {object} options - Optional configuration
   * @returns {Promise<boolean>} - Success status
   */
  async function copyWithToast(text, options = {}) {
    const {
      successMessage = 'Copied to clipboard!',
      errorMessage = 'Failed to copy to clipboard'
    } = options;

    if (!text) {
      showToast('No content to copy', 'warning');
      return false;
    }

    const success = await copyToClipboard(text);

    if (success) {
      showToast(successMessage, 'success');
    } else {
      showToast(errorMessage, 'error');
    }

    return success;
  }

})();