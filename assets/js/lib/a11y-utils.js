/**
 * Accessibility Utilities
 *
 * Central ARIA live region for status messages (WCAG 2.1 AA, SC 4.1.3).
 *
 * Use announce() for results that are large or update on every keystroke.
 * Marking such containers with aria-live directly would make a screen reader
 * read the whole panel on each change; announcing a short debounced summary
 * conveys the same status without the noise.
 *
 * Small, discrete status containers (a single validation verdict, a strength
 * rating) do not need this - put aria-live="polite" on them directly.
 */

(function() {
  'use strict';

  const REGION_ID = 'a11y-live-region';
  const DEBOUNCE_MS = 400;

  let debounceTimer = null;
  let clearTimer = null;

  /**
   * Get (or lazily create) the shared visually hidden live region
   *
   * @param {boolean} assertive - Use assertive politeness instead of polite
   * @returns {HTMLElement} - The live region element
   */
  function getRegion(assertive) {
    let region = document.getElementById(REGION_ID);

    if (!region) {
      region = document.createElement('div');
      region.id = REGION_ID;
      region.className = 'visually-hidden';
      region.setAttribute('aria-atomic', 'true');
      document.body.appendChild(region);
    }

    region.setAttribute('aria-live', assertive ? 'assertive' : 'polite');
    return region;
  }

  /**
   * Announce a short status message to screen readers
   *
   * Announcements are debounced, so rapid successive calls (for example while
   * the user is typing) result in a single announcement of the final state.
   *
   * @param {string} message - Short plain-text summary, e.g. "3 matches found"
   * @param {object} [options] - Options
   * @param {boolean} [options.assertive=false] - Interrupt the screen reader
   * @param {number} [options.delay=400] - Debounce delay in ms
   */
  function announce(message, options) {
    if (!message) {
      return;
    }

    const opts = options || {};
    const delay = typeof opts.delay === 'number' ? opts.delay : DEBOUNCE_MS;

    if (debounceTimer) {
      clearTimeout(debounceTimer);
    }
    if (clearTimer) {
      clearTimeout(clearTimer);
    }

    debounceTimer = setTimeout(function() {
      const region = getRegion(opts.assertive === true);

      // Reset first so an identical repeated message is announced again
      region.textContent = '';

      setTimeout(function() {
        region.textContent = String(message);

        // Release the text so it is not re-read by navigation commands
        clearTimer = setTimeout(function() {
          region.textContent = '';
        }, 5000);
      }, 50);
    }, delay);
  }

  /**
   * Cancel any pending announcement and clear the live region
   */
  function clearAnnouncements() {
    if (debounceTimer) {
      clearTimeout(debounceTimer);
      debounceTimer = null;
    }
    if (clearTimer) {
      clearTimeout(clearTimer);
      clearTimer = null;
    }

    const region = document.getElementById(REGION_ID);
    if (region) {
      region.textContent = '';
    }
  }

  // Expose globally with all utility functions
  window.A11yUtils = {
    announce: announce,
    clearAnnouncements: clearAnnouncements
  };

})();
