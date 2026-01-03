/**
 * Color Mode Toggler
 * 
 * Interactive theme switcher for light/dark/auto modes with persistent storage.
 * Syncs with system preferences and updates UI elements dynamically.
 */
(() => {
  'use strict'

  /**
   * Get stored theme from localStorage
   *
   * @returns {string|null} Stored theme or null
   */
  const getStoredTheme = () => localStorage.getItem('theme')

  /**
   * Save theme to localStorage
   *
   * @param {string} theme - Theme to store
   */
  const setStoredTheme = theme => localStorage.setItem('theme', theme)

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
   * Apply theme to document
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

  /**
   * Update UI to reflect active theme
   *
   * @param {string} theme - Current theme
   * @param {boolean} focus - Whether to focus switcher button
   */
  const showActiveTheme = (theme, focus = false) => {
    const themeSwitcher = document.querySelector('#bd-theme')

    if (!themeSwitcher) {
      return
    }

    const themeSwitcherText = document.querySelector('#bd-theme-text')
    const activeThemeIcon = document.querySelector('.theme-icon-active use')
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
    const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active')
      element.setAttribute('aria-pressed', 'false')
    })

    btnToActive.classList.add('active')
    btnToActive.setAttribute('aria-pressed', 'true')
    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
    const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
    themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

    if (focus) {
      themeSwitcher.focus()
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme()
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
      setTheme(getPreferredTheme())
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    const themeSwitcherText = document.querySelector('#bd-theme-text')
    if (themeSwitcherText && window.i18n && typeof window.i18n.t === 'function') {
      if (!themeSwitcherText.getAttribute('data-i18n')) {
        themeSwitcherText.setAttribute('data-i18n', 'common.toggle_theme')
      }
    }

    showActiveTheme(getPreferredTheme())

    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          setStoredTheme(theme)
          setTheme(theme)
          showActiveTheme(theme, true)
        })
      })
  })
})()
