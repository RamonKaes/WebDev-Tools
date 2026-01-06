/**
 * Sidebar Navigation Helper
 * 
 * Automatically expands the correct category and scrolls to the active tool
 * when navigating from the homepage tool cards.
 * Implements accordion behavior so only one category is open at a time.
 */

(function() {
  'use strict';

  /**
   * Initialize accordion behavior for sidebar categories
   */
  function initAccordionBehavior() {
    // Get all category toggle buttons in both desktop and mobile sidebars
    const desktopButtons = document.querySelectorAll('#desktop-sidebar .btn-toggle[data-bs-toggle="collapse"]');
    const mobileButtons = document.querySelectorAll('#mobileSidebar .btn-toggle[data-bs-toggle="collapse"]');
    
    const allButtons = [...desktopButtons, ...mobileButtons];
    
    allButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        const targetId = this.getAttribute('data-bs-target');
        const targetCollapse = document.querySelector(targetId);
        
        if (!targetCollapse) return;
        
        // Find the parent sidebar (desktop or mobile)
        const sidebar = this.closest('#desktop-sidebar, #mobileSidebar');
        if (!sidebar) return;
        
        // Get all collapse elements in this sidebar
        const allCollapses = sidebar.querySelectorAll('.collapse');
        
        // Close all other collapses in the same sidebar
        allCollapses.forEach(collapse => {
          if (collapse !== targetCollapse && collapse.classList.contains('show')) {
            const bsCollapse = bootstrap.Collapse.getInstance(collapse);
            if (bsCollapse) {
              bsCollapse.hide();
            } else {
              new bootstrap.Collapse(collapse, { toggle: false }).hide();
            }
          }
        });
      });
    });
  }

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
      // Close all other collapses first
      const sidebar = collapseParent.closest('#desktop-sidebar, #mobileSidebar');
      if (sidebar) {
        const allCollapses = sidebar.querySelectorAll('.collapse');
        allCollapses.forEach(collapse => {
          if (collapse !== collapseParent && collapse.classList.contains('show')) {
            const bsCollapse = bootstrap.Collapse.getInstance(collapse);
            if (bsCollapse) {
              bsCollapse.hide();
            }
          }
        });
      }
      
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
    document.addEventListener('DOMContentLoaded', function() {
      initAccordionBehavior();
      initSidebarNavigation();
    });
  } else {
    initAccordionBehavior();
    initSidebarNavigation();
  }

  console.debug('[SidebarNav] Initialized with accordion behavior');

})();
