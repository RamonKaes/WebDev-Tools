/**
 * Mobile Offcanvas Navigation
 *
 * Handles smooth navigation in mobile sidebar by closing offcanvas before page transition.
 * Prevents jarring visual behavior when navigating between pages.
 */

(function() {
  'use strict';

  /**
   * Initialize mobile navigation handlers on DOM ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    const mobileSidebar = document.getElementById('mobileSidebar');
    if (!mobileSidebar || typeof bootstrap === 'undefined') return;

    const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(mobileSidebar);

    /**
     * Handle navigation link clicks
     * Closes offcanvas before navigating to prevent visual glitches
     *
     * @param {Event} e - Click event
     */
    mobileSidebar.querySelectorAll('a.mobile-nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetUrl = this.getAttribute('href');

        offcanvasInstance.hide();

        setTimeout(() => {
          window.location.href = targetUrl;
        }, 150);
      });
    });
  });
})();
