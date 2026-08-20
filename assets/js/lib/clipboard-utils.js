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
  async function copyRaw(text) {
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
   * Copy text and confirm it with a toast.
   *
   * Every call site in the tools is click-initiated, so the confirmation is
   * always wanted here. Use copyRaw() for a silent copy.
   *
   * @param {string} text - Text to place on the clipboard
   * @param {string} [message] - Toast message; defaults to the translated "Copied!"
   * @returns {Promise<boolean>} - True on success
   */
  async function copyToClipboard(text, message) {
    const success = await copyRaw(text);
    const label = message || translate('common.copied', 'Copied!');

    showToast(success ? label : translate('common.error', 'Copy failed'),
      success ? 'success' : 'error');

    return success;
  }

  /**
   * Look up a translation with a literal fallback
   *
   * @param {string} key - i18n key
   * @param {string} fallback - Text used when i18n is unavailable
   * @returns {string} - Translated text
   */
  function translate(key, fallback) {
    if (window.i18n && typeof window.i18n.t === 'function') {
      const value = window.i18n.t(key);
      if (value && value !== key) return value;
    }
    return fallback;
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

  /**
   * Copy text and confirm it: swap the button icon to a checkmark and show a
   * toast.
   *
   * The icon markup differs at runtime - icon-system.js replaces <i class="bi">
   * with an <svg><use> sprite reference - so both forms are handled here.
   * Looking only for <i> silently did nothing on every page where the sprite
   * replacement had already run.
   *
   * @param {HTMLElement} button - The clicked copy button
   * @param {string} text - Text to place on the clipboard
   * @param {string} message - Toast message shown on success
   * @returns {Promise<boolean>} - True if the copy succeeded
   */
  async function copyWithFeedback(button, text, message) {
    const success = await copyRaw(text);

    if (!success) {
      showToast(translate('common.error', 'Copy failed'), 'error');
      return false;
    }

    showToast(message || translate('common.copied', 'Copied!'), 'success');

    if (button) {
      const restore = swapToCheckIcon(button);
      if (restore) {
        setTimeout(restore, 2000);
      }
    }

    return true;
  }

  /**
   * Swap a button's icon to a checkmark, whatever form it currently has
   *
   * @param {HTMLElement} button - Button containing the icon
   * @returns {Function|null} - Callback restoring the original icon, or null
   */
  function swapToCheckIcon(button) {
    const svgUse = button.querySelector('svg use');
    if (svgUse) {
      const attr = svgUse.getAttribute('href') !== null ? 'href' : 'xlink:href';
      const original = svgUse.getAttribute(attr);
      if (!original) return null;
      svgUse.setAttribute(attr, original.replace(/#icon-.*$/, '#icon-check'));
      return () => svgUse.setAttribute(attr, original);
    }

    const i = button.querySelector('i');
    if (i) {
      const original = i.className;
      i.className = original.replace(/\bbi-[\w-]+/, 'bi-check');
      return () => { i.className = original; };
    }

    return null;
  }

  // icon-system.js swaps <i class="bi bi-x"> for an <svg><use href="#icon-x">
  // sprite reference, so the sprite carries its own id namespace.
  // Names the tools set that the sprite does not define map to a close match.
  const SPRITE_ALIASES = { check2: 'check' };

  /**
   * Get a handle for a button's icon that accepts a Bootstrap icon class name,
   * whether the icon is still an <i> or has been replaced by an SVG sprite.
   *
   * Tools assign to `.className` to swap the icon. That works natively on <i>,
   * but on an <svg> the rendered glyph comes from the <use> reference, so the
   * returned shim updates both.
   *
   * @param {HTMLElement} button - Element containing the icon
   * @returns {HTMLElement|object|null} - Something exposing a className accessor
   */
  function iconHandle(button) {
    if (!button || typeof button.querySelector !== 'function') return null;

    const el = button.querySelector('i, svg');
    if (!el) return null;
    if (el.tagName.toLowerCase() === 'i') return el;

    const use = el.querySelector('use');

    return {
      get className() {
        return el.getAttribute('class') || '';
      },
      set className(value) {
        el.setAttribute('class', value);
        if (!use) return;

        const match = String(value).match(/\bbi-([\w-]+)/);
        if (!match) return;

        const name = SPRITE_ALIASES[match[1]] || match[1];
        const attr = use.getAttribute('href') !== null ? 'href' : 'xlink:href';
        const current = use.getAttribute(attr) || '';
        use.setAttribute(attr, current.replace(/#icon-.*$/, `#icon-${name}`));
      }
    };
  }

  // Expose globally with all utility functions
  window.ClipboardUtils = {
    copyToClipboard: copyToClipboard,
    copyRaw: copyRaw,
    iconHandle: iconHandle,
    copyWithFeedback: copyWithFeedback,
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
    let container = document.getElementById('toast-container');

    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      // Top right: the bottom right corner is occupied by the floating theme
      // and language switchers, which would cover the toast.
      container.className = 'toast-container position-fixed top-0 end-0 p-3';
      // Those switchers sit at z-index 1500/1499 and Bootstrap gives
      // .toast-container none, so it has to be lifted above them.
      container.style.zIndex = '1600';
      document.body.appendChild(container);
    }

    const variants = {
      success: 'text-bg-success',
      error: 'text-bg-danger',
      warning: 'text-bg-warning',
      info: 'text-bg-info'
    };
    const icons = {
      success: 'bi-check-circle',
      error: 'bi-x-circle',
      warning: 'bi-exclamation-triangle',
      info: 'bi-info-circle'
    };

    const toast = document.createElement('div');
    toast.className = `toast align-items-center border-0 ${variants[type] || variants.info}`;
    // role/aria-live make the message reach assistive technology
    toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
    toast.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi ${icons[type] || icons.info} me-2" aria-hidden="true"></i>${escapeHtml(message)}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;

    container.appendChild(toast);

    if (window.bootstrap && window.bootstrap.Toast) {
      const instance = new window.bootstrap.Toast(toast, { delay: duration });
      toast.addEventListener('hidden.bs.toast', () => toast.remove());
      instance.show();
    } else {
      // Bootstrap JS unavailable - keep the message visible, then clean up
      toast.classList.add('show');
      setTimeout(() => toast.remove(), duration);
    }
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