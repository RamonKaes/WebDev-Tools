/**
 * Table of Contents Generator
 *
 * Automatically generates "On this Page" navigation from h2/h5 headings.
 * Includes smooth scrolling, unique ID generation, and responsive visibility.
 */

(function() {
  'use strict';

  const DESKTOP_BREAKPOINT = 1480;
  const SCROLL_OFFSET = 160;

  /**
   * Check if TOC should be visible based on viewport width
   *
   * @returns {boolean} True if viewport is wide enough for TOC
   */
  function isTocVisible() {
    return window.innerWidth >= DESKTOP_BREAKPOINT;
  }

  /**
   * Generate unique IDs for headings that lack them
   * Ensures all TOC links have valid anchor targets
   */
  function ensureHeadingIds() {
    const headings = document.querySelectorAll('#main-content h2:not(#tool-container h2), #main-content .h5:not(#tool-container .h5), #main-content h5:not(#tool-container h5)');
    const usedIds = new Set();

    headings.forEach((heading, index) => {
      if (!heading.id) {
        let baseId = heading.textContent
          .trim()
          .toLowerCase()
          .replace(/[^a-z0-9]+/g, '-')
          .replace(/^-+|-+$/g, '');

        let id = baseId;
        let counter = 1;
        while (usedIds.has(id)) {
          id = `${baseId}-${counter}`;
          counter++;
        }

        heading.id = id;
        usedIds.add(id);
      } else {
        usedIds.add(heading.id);
      }
    });
  }

  /**
   * Build TOC navigation from page headings
   * Creates clickable links with smooth scroll behavior
   */
  function buildToc() {
    const tocNav = document.getElementById('toc-nav');

    if (!tocNav) {
      return;
    }

    tocNav.innerHTML = '';

    const toolHeader = document.getElementById('tool-header');

    if (toolHeader) {
      const h1 = toolHeader.querySelector('h1');
      if (h1) {
        if (!toolHeader.id) {
          toolHeader.id = 'tool-header';
        }

        const headerLink = document.createElement('a');
        headerLink.className = 'nav-link py-1 toc-tool-link';
        headerLink.href = '#';
        headerLink.textContent = h1.dataset.tocTitle || h1.textContent.replace(/^[^\w]+/, '').trim();

        headerLink.addEventListener('click', (e) => {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
          history.pushState(null, '', window.location.pathname);
        });

        tocNav.appendChild(headerLink);
      }
    }

    const headings = document.querySelectorAll('#main-content h2:not(#tool-container h2), #main-content .h5:not(#tool-container .h5), #main-content h5:not(#tool-container h5)');

    if (headings.length === 0 && !toolHeader) {
      const sidebar = document.getElementById('toc-sidebar');
      if (sidebar) {
        sidebar.closest('aside').style.display = 'none';
      }
      return;
    }

    headings.forEach((heading, index) => {
      const link = document.createElement('a');
      link.className = 'nav-link py-1';
      link.href = `#${heading.id}`;
      link.textContent = heading.textContent.replace(/^[^\w]+/, '').trim();

      if (heading.classList.contains('h5') || heading.tagName === 'H5') {
        link.style.paddingLeft = '1rem';
        link.style.fontSize = '0.875rem';
      } else {
        link.style.fontSize = '0.9375rem';
      }

      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = heading.id;
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
          const currentScroll = window.pageYOffset || document.documentElement.scrollTop || 0;
          const headingTop = targetElement.getBoundingClientRect().top + currentScroll - SCROLL_OFFSET;
          window.scrollTo({ top: Math.max(headingTop, 0), behavior: 'smooth' });
          history.pushState(null, '', `#${targetId}`);
        }
      });

      tocNav.appendChild(link);
    });

    console.log('[TOC] Total links added:', tocNav.children.length);
  }

  /**
   * Initialize TOC system
   * Only runs if viewport is wide enough
   */
  function initToc() {
    if (!isTocVisible()) {
      return;
    }

    ensureHeadingIds();
    buildToc();
  }

  /**
   * Debounce helper to limit function execution frequency
   *
   * @param {Function} func - Function to debounce
   * @param {number} wait - Delay in milliseconds
   * @returns {Function} Debounced function
   */
  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToc);
  } else {
    initToc();
  }

  let wasVisible = isTocVisible();
  window.addEventListener('resize', debounce(() => {
    const isVisible = isTocVisible();
    if (isVisible !== wasVisible) {
      wasVisible = isVisible;
      if (isVisible) {
        initToc();
      }
    }
  }, 150));

  const observer = new MutationObserver(debounce(() => {
    if (isTocVisible()) {
      initToc();
    }
  }, 200));

  const mainContent = document.getElementById('main-content');
  if (mainContent) {
    observer.observe(mainContent, {
      childList: true,
      subtree: true
    });
  }

})();
