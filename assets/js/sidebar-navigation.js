/**
 * Sidebar Navigation Helper
 * 
 * Automatically expands the correct category and scrolls to the active tool
 * when navigating from the homepage tool cards.
 */

(function() {
  'use strict';

  /**
   * Initialize sidebar navigation on page load
   */
  function initSidebarNavigation() {
    // Find the active tool link in the sidebar
    const activeLink = document.querySelector('#desktop-sidebar .tool-link.active, #mobileSidebar .tool-link.active');
    
    if (!activeLink) {
      return; // No active tool, nothing to do
    }

    // Find the parent collapse element
    const collapseParent = activeLink.closest('.collapse');
    
    if (collapseParent) {
      // Show the collapse using Bootstrap's Collapse API
      const bsCollapse = new bootstrap.Collapse(collapseParent, {
        toggle: false
      });
      bsCollapse.show();

      // Also update the button's aria-expanded attribute
      const collapseId = collapseParent.id;
      const toggleButton = document.querySelector(`[data-bs-target="#${collapseId}"]`);
      if (toggleButton) {
        toggleButton.setAttribute('aria-expanded', 'true');
        toggleButton.classList.remove('collapsed');
      }

      // Wait for collapse animation to complete, then scroll
      collapseParent.addEventListener('shown.bs.collapse', function onShown() {
        scrollToActiveLink(activeLink);
        collapseParent.removeEventListener('shown.bs.collapse', onShown);
      }, { once: true });
    } else {
      // If no collapse parent (e.g., Home link), just scroll
      scrollToActiveLink(activeLink);
    }
  }

  /**
   * Scroll the active link into view within the sidebar
   * 
   * @param {HTMLElement} link - The active tool link element
   */
  function scrollToActiveLink(link) {
    const sidebar = document.querySelector('#desktop-sidebar');
    
    if (!sidebar) {
      return;
    }

    // Calculate the position to scroll to
    const linkRect = link.getBoundingClientRect();
    const sidebarRect = sidebar.getBoundingClientRect();
    
    // Calculate offset: link position relative to sidebar minus some padding
    const offset = linkRect.top - sidebarRect.top - (sidebar.clientHeight / 3);
    
    // Smooth scroll to the active link
    sidebar.scrollTo({
      top: sidebar.scrollTop + offset,
      behavior: 'smooth'
    });

    console.debug('[SidebarNav] Scrolled to active tool:', link.textContent.trim());
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebarNavigation);
  } else {
    initSidebarNavigation();
  }

  console.debug('[SidebarNav] Initialized');

})();
