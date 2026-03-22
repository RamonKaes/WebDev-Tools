/**
 * Sidebar State Persistence
 *
 * Maintains sidebar collapse state across page reloads using localStorage.
 * Restores state early to prevent layout shifts and improve UX.
 */

(function() {
  'use strict';

  const DESKTOP_COLLAPSE_IDS = [
    'encoders-collapse',
    'formatters-collapse',
    'converter-collapse',
    'generator-collapse',
    'stringtools-collapse',
    'references-collapse',
    'utilities-collapse'
  ];
  const MOBILE_COLLAPSE_IDS = DESKTOP_COLLAPSE_IDS.map(id => 'mobile-' + id);
  const ALL_COLLAPSE_IDS = [...DESKTOP_COLLAPSE_IDS, ...MOBILE_COLLAPSE_IDS];

  restoreStatesEarly();

  /**
   * Setup event listeners for sidebar state persistence on DOM ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    /**
     * Attach event listeners to save/remove collapse state
     *
     * @param {string} id - Collapse element ID
     */
    ALL_COLLAPSE_IDS.forEach(id => {
      const element = document.getElementById(id);
      if (!element) return;

      element.addEventListener('shown.bs.collapse', function() {
        localStorage.setItem('sidebar-' + id, 'show');
      });

      element.addEventListener('hidden.bs.collapse', function() {
        localStorage.removeItem('sidebar-' + id);
      });
    });
  });

  /**
   * Restore sidebar states before DOMContentLoaded to prevent layout shifts
   */
  function restoreStatesEarly() {
    const allCollapseIds = ALL_COLLAPSE_IDS;

    allCollapseIds.forEach(id => {
      const savedState = localStorage.getItem('sidebar-' + id);
      if (savedState === 'show') {
        requestAnimationFrame(() => {
          const element = document.getElementById(id);
          if (element) {
            element.classList.add('show');
            const button = document.querySelector(`[data-bs-target="#${id}"]`);
            if (button) {
              button.classList.remove('collapsed');
              button.setAttribute('aria-expanded', 'true');
            }
          }
        });
      }
    });
  }
})();
