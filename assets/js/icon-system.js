/**
 * SVG Icon System
 * Replaces Bootstrap Icon <i> tags with lightweight SVG sprites
 */

(function () {
  'use strict';

  const IconSystem = {
    spritePath: (window.__BASE_PATH__ || '') + '/assets/img/icons.svg',

    iconMap: {
      'bi-list': 'list',
      'bi-house-door': 'house-door',
      'bi-globe': 'globe',
      'bi-arrow-left-right': 'arrow-left-right',
      'bi-stars': 'stars',
      'bi-translate': 'translate',
      'bi-chevron-down': 'chevron-down',
      'bi-hash': 'hash',
      'bi-file-text': 'file-text',
      'bi-shield-lock': 'shield-lock',
      'bi-key': 'key',
      'bi-shield-check': 'shield-check',
      'bi-clipboard': 'clipboard',
      'bi-clipboard-check': 'clipboard-check',
      'bi-pencil': 'pencil',
      'bi-sliders': 'sliders',
      'bi-arrow-clockwise': 'arrow-clockwise',
      'bi-check': 'check',
      'bi-exclamation-triangle': 'exclamation-triangle',
      'bi-exclamation-triangle-fill': 'exclamation-triangle',
      'bi-info-circle': 'info-circle',
      'bi-arrows-angle-expand': 'arrows-angle-expand',
      'bi-file-earmark': 'file-earmark',
      'bi-download': 'download',
      'bi-check-circle': 'check-circle',
      'bi-x-circle': 'x-circle',
      'bi-arrows-collapse': 'arrows-collapse'
    },

    /**
     * Create SVG icon element
     *
     * @param {string} iconId - Icon identifier (e.g., 'hash', 'file-text')
     * @param {string} className - Additional CSS classes
     * @returns {SVGElement}
     */
    createIcon(iconId, className = '') {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', `icon icon-${iconId} ${className}`.trim());

      // Use 48px for error page icons, 16px for everything else
      const size = className.includes('text-danger') && className.includes('error-icon-large') ? '48' : '16';
      svg.setAttribute('width', size);
      svg.setAttribute('height', size);
      svg.setAttribute('fill', 'currentColor');
      svg.setAttribute('aria-hidden', 'true');

      const use = document.createElementNS('http://www.w3.org/2000/svg', 'use');
      use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', `${this.spritePath}#icon-${iconId}`);

      svg.appendChild(use);
      return svg;
    },

    /**
     * Replace all Bootstrap Icon <i> tags with SVG sprites
     */
    replaceIcons() {
      const icons = document.querySelectorAll('i[class*="bi-"]:not(.tool-header-icon):not(.keep-bi)');
      let replacedCount = 0;

      icons.forEach(icon => {
        // Skip icons inside headings (h1-h6)
        if (icon.closest('h1, h2, h3, h4, h5, h6')) {
          return;
        }

        const classList = Array.from(icon.classList);
        const biClass = classList.find(cls => cls.startsWith('bi-') && this.iconMap[cls]);

        if (biClass) {
          const iconId = this.iconMap[biClass];
          const otherClasses = classList.filter(cls => !cls.startsWith('bi-')).join(' ');

          const svg = this.createIcon(iconId, otherClasses);
          icon.parentNode.replaceChild(svg, icon);
          replacedCount++;
        }
      });

      if (replacedCount > 0) {
        console.debug(`[IconSystem] Replaced ${replacedCount} icon(s) with SVG sprites`);
      }

      return replacedCount;
    },

    /**
     * Load sprite file inline for better caching
     */
    async loadSprite() {
      try {
        const response = await fetch(this.spritePath);
        const svgText = await response.text();

        const container = document.createElement('div');
        container.style.display = 'none';
        container.innerHTML = svgText;
        document.body.insertBefore(container, document.body.firstChild);

        console.debug('[IconSystem] SVG sprite loaded inline');
      } catch (error) {
        console.warn('[IconSystem] Failed to load sprite inline, using external reference:', error);
      }
    },

    /**
     * Initialize icon system
     *
     * @param {boolean} preload - Whether to preload sprite inline
     */
    init(preload = false) {
      if (preload) {
        this.loadSprite();
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => this.replaceIcons());
      } else {
        this.replaceIcons();
      }

      // Watch for dynamically added icons (RAF throttled)
      let rafId = null;
      let pendingMutations = [];

      const observer = new MutationObserver((mutations) => {
        pendingMutations.push(...mutations);

        if (!rafId) {
          rafId = requestAnimationFrame(() => {
            rafId = null;

            performance.mark('icon-observer-start');

            let hasNewIcons = false;
            const mutationsToProcess = pendingMutations;
            pendingMutations = [];

            mutationsToProcess.forEach(mutation => {
              mutation.addedNodes.forEach(node => {
                if (node.nodeType === 1) {
                  if (node.classList && Array.from(node.classList).some(cls => cls.startsWith('bi-'))) {
                    hasNewIcons = true;
                  } else if (node.querySelector && node.querySelector('i[class*="bi-"]')) {
                    hasNewIcons = true;
                  }
                }
              });
            });

            if (hasNewIcons) {
              this.replaceIcons();
            }

            performance.mark('icon-observer-end');
            performance.measure('icon-observer-processing', 'icon-observer-start', 'icon-observer-end');

            const measure = performance.getEntriesByName('icon-observer-processing')[0];
            if (measure && measure.duration > 5) {
              console.debug(`[IconSystem] Observer processing took ${measure.duration.toFixed(2)}ms`);
            }
            performance.clearMarks('icon-observer-start');
            performance.clearMarks('icon-observer-end');
            performance.clearMeasures('icon-observer-processing');
          });
        }
      });

      const targetContainer = document.getElementById('tool-container');
      const observeTarget = targetContainer || document.body;

      if (targetContainer) {
        console.debug('[IconSystem] Observing #tool-container');
      } else {
        console.debug('[IconSystem] #tool-container not found, observing document.body');
      }

      if (observeTarget && observeTarget !== document.body) {
        observer.observe(observeTarget, {
          childList: true,
          subtree: true
        });
      } else if (document.body) {
        observer.observe(document.body, {
          childList: true,
          subtree: true
        });
      } else {
        document.addEventListener('DOMContentLoaded', () => {
          const container = document.getElementById('tool-container') || document.body;
          observer.observe(container, {
            childList: true,
            subtree: true
          });

          if (container !== document.body) {
            console.debug('[IconSystem] Observer attached to #tool-container after DOMContentLoaded');
          }
        });
      }

      console.debug('[IconSystem] Initialized with MutationObserver');
    }
  };

  window.IconSystem = IconSystem;

  // Auto-initialize (disable by setting window.IconSystemAutoInit = false)
  if (window.IconSystemAutoInit !== false) {
    IconSystem.init(false);
  }

})();
