/**
 * Theme Initialization (Inline Blocking Script)
 * 
 * Prevents flash of unstyled content (FOUC) by applying theme before page render.
 * Must execute synchronously in <head> before body content loads.
 */
(function() {
  'use strict'

  /**
   * Get stored theme from localStorage
   *
   * @returns {string|null} Stored theme or null
   */
  const getStoredTheme = () => localStorage.getItem('theme')

  /**
   * Get preferred theme based on storage or system preference
   *
   * @returns {string} Preferred theme (light/dark)
   */
  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme()
    if (storedTheme) {
      return storedTheme
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  /**
   * Apply theme to document immediately
   *
   * @param {string} theme - Theme to apply (light/dark/auto)
   */
  const setTheme = theme => {
    if (theme === 'auto') {
      document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
    } else {
      document.documentElement.setAttribute('data-bs-theme', theme)
    }
  }

  setTheme(getPreferredTheme())

  // Load performance monitoring in development only
  if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    window.addEventListener('DOMContentLoaded', () => {
      import('./lib/performance-monitoring.js').then(module => {
        module.initPerformanceMonitoring({
          logToConsole: true,
          trackResources: true
        });
      }).catch(err => console.warn('Performance monitoring unavailable:', err));
    });
  }
})()
