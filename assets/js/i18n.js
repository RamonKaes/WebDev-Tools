/**
 * Internationalization Engine
 *
 * Client-side translation loading with auto-detection, localStorage persistence,
 * and dynamic UI updates.
 */

const DEBUG = false;

class I18n {
  constructor() {
    this.translations = {};
    this.currentLang = null;
    this.fallbackLang = 'en';
    this.supportedLanguages = ['en', 'de', 'es', 'pt', 'fr', 'it'];
    this.languageNames = {
      'en': { name: 'English', native: 'English' },
      'de': { name: 'German', native: 'Deutsch' },
      'es': { name: 'Spanish', native: 'Español' },
      'pt': { name: 'Portuguese', native: 'Português' },
      'fr': { name: 'French', native: 'Français' },
      'it': { name: 'Italian', native: 'Italiano' }
    };
    this.initialized = false;
  }

  /**
   * Initialize i18n system
   * Detects language, loads translations, sets up UI
   *
   * @async
   * @returns {Promise<void>}
   */
  async init() {
  if (this.initialized) return;

  const detectedLang = this.detectLanguage();
  const success = await this.setLanguage(detectedLang, false);

  if (!success) {
    console.error('[i18n] Critical: Failed to load any translations');
    this.currentLang = this.fallbackLang;
    this.translations[this.fallbackLang] = {};
  }

  this.setupLanguageSwitcher();
  this.updateLanguageSwitcher();

  this.initialized = true;

  console.debug('[i18n] Initialized with language:', this.currentLang);
  }

  /**
   * Get cookie value by name
   *
   * @param {string} name - Cookie name
   * @returns {string|null} Cookie value or null if not found
   */
  getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
  }

  /**
   * Detect user's preferred language
   *
   * Priority: 1) URL path, 2) URL param, 3) Cookie, 4) localStorage, 5) Browser, 6) Fallback
   *
   * @returns {string} Detected language code
   */
  detectLanguage() {
  const currentPath = window.location.pathname;
  const basePath = window.APP_BASE_PATH || '';
  const relativePath = basePath ? currentPath.replace(basePath, '') : currentPath;

  const pathLangMatch = relativePath.match(/^\/(de|es|pt|fr|it)\//);
  if (pathLangMatch) {
    const detectedLang = pathLangMatch[1];
    console.log('[i18n] Language detected from path:', detectedLang);
    return detectedLang;
  }

  const urlParams = new URLSearchParams(window.location.search);
  const urlLang = urlParams.get('lang');
  if (urlLang && this.supportedLanguages.includes(urlLang)) {
    console.log('[i18n] Language detected from URL param:', urlLang);
    return urlLang;
  }

  const cookieLang = this.getCookie('webdev-tools-lang');
  if (cookieLang && this.supportedLanguages.includes(cookieLang)) {
    console.log('[i18n] Language detected from cookie:', cookieLang);
    return cookieLang;
  }

  const savedLang = localStorage.getItem('webdev-tools-lang');
  if (savedLang && this.supportedLanguages.includes(savedLang)) {
    console.log('[i18n] Language detected from localStorage:', savedLang);
    return savedLang;
  }

  const browserLang = navigator.language.split('-')[0];
  if (this.supportedLanguages.includes(browserLang)) {
    console.log('[i18n] Language detected from browser:', browserLang);
    return browserLang;
  }

  console.log('[i18n] Using fallback language:', this.fallbackLang);
  return this.fallbackLang;
  }

  /**
   * Load translations for a language
   * Falls back to English if requested language fails
   *
   * @param {string} lang - Language code
   * @returns {Promise<{success: boolean, langUsed: string|null}>}
   */
  async loadTranslations(lang) {
    if (this.translations[lang]) {
      return { success: true, langUsed: lang };
    }

    // Check preloaded translations from head.php
    if (window.__I18N__ && window.__I18N__[lang]) {
      console.debug(`[i18n] Using preloaded translations for: ${lang}`);
      this.translations[lang] = window.__I18N__[lang];
      return { success: true, langUsed: lang };
    }

    const buildHash = window.BUILD_HASH || '1.0.0';
    const basePath = this.getBasePath();

    const loadCachedTranslations = (targetLang) => {
      const cacheKey = `toolbox_i18n_${targetLang}`;
      const cached = localStorage.getItem(cacheKey);
      if (!cached) return false;

      try {
        const { translations, buildHash: cachedHash } = JSON.parse(cached);
        if (cachedHash === buildHash) {
          this.translations[targetLang] = translations;
          console.debug(`[i18n] Using cached translations for: ${targetLang}`);
          return true;
        }

        console.debug(`[i18n] Cache outdated, refetching: ${targetLang}`);
        localStorage.removeItem(cacheKey);
      } catch (error) {
        console.warn(`[i18n] Invalid cached translations for ${targetLang}:`, error);
        localStorage.removeItem(cacheKey);
      }

      return false;
    };

    const fetchTranslations = async (targetLang) => {
      const response = await fetch(`${basePath}config/i18n/${targetLang}.json?v=${buildHash}`);
      if (!response.ok) {
        throw new Error(`Failed to load ${targetLang}.json: ${response.status}`);
      }

      const data = await response.json();
      this.translations[targetLang] = data;

      try {
        localStorage.setItem(`toolbox_i18n_${targetLang}`, JSON.stringify({
          translations: data,
          buildHash,
          cachedAt: Date.now()
        }));
      } catch (storageError) {
        console.warn(`[i18n] Failed to cache translations for ${targetLang}:`, storageError);
      }

      console.debug(`[i18n] Loaded translations for: ${targetLang}`);
    };

    if (loadCachedTranslations(lang)) {
      return { success: true, langUsed: lang };
    }

    try {
      await fetchTranslations(lang);
      return { success: true, langUsed: lang };
    } catch (error) {
      if (DEBUG) console.error(`[i18n] Error loading ${lang}.json:`, error);

      if (lang !== this.fallbackLang) {
        if (DEBUG) console.warn(`[i18n] Falling back to ${this.fallbackLang}`);

        if (this.translations[this.fallbackLang]) {
          return { success: true, langUsed: this.fallbackLang };
        }

        if (loadCachedTranslations(this.fallbackLang)) {
          return { success: true, langUsed: this.fallbackLang };
        }

        try {
          await fetchTranslations(this.fallbackLang);
          return { success: true, langUsed: this.fallbackLang };
        } catch (fallbackError) {
          console.error('[i18n] Fallback also failed:', fallbackError);
        }
      }

      return { success: false, langUsed: null };
    }
  }

  /**
   * Get base path for i18n files
   *
   * @returns {string} Base path
   */
  getBasePath() {
    return (window.__BASE_PATH__ || '') + '/';
  }

  /**
   * Translate a key to current language
   *
   * @param {string} key - Translation key (e.g., "common.copy")
   * @param {Object} params - Optional parameters for interpolation
   * @returns {string} Translated text
   */
  t(key, params = {}) {
  if (!key) return '';

  let value = this.getTranslation(key, this.currentLang);

  if (value === key) {
    // Warn whenever translation is missing in the current language
    console.warn(`[i18n] Missing translation for key: ${key} (lang: ${this.currentLang})`);
    // If currentLang is different from fallback, try fallback
    if (this.currentLang !== this.fallbackLang) {
      value = this.getTranslation(key, this.fallbackLang);
      if (value === key) {
        console.warn(`[i18n] Missing translation in fallback for key: ${key}`);
        return `[MISSING: ${key}]`;
      }
    } else {
      return `[MISSING: ${key}]`;
    }
  }

  if (typeof value === 'string' && Object.keys(params).length > 0) {
  Object.keys(params).forEach(paramKey => {
  value = value.replace(new RegExp(`{{${paramKey}}}`, 'g'), params[paramKey]);
  });
  }

  return value;
  }

  /**
   * Get translation from nested object by key path
   *
   * @param {string} key - Translation key
   * @param {string} lang - Language code
   * @returns {string} Translation or original key if not found
   */
  getTranslation(key, lang) {
  if (!this.translations[lang]) return key;

  const keys = key.split('.');
  let value = this.translations[lang];

  for (const k of keys) {
  if (value && typeof value === 'object' && k in value) {
  value = value[k];
  } else {
  return key;
  }
  }

  return typeof value === 'string' ? value : key;
  }

  /**
   * Get raw translation value (string, array, or object)
   * Returns undefined if not found
   *
   * @param {string} key - Translation key
   * @returns {*} Translation value or undefined
   */
  getRaw(key) {
  if (!key) return undefined;

  const tryGet = (lang) => {
    if (!this.translations[lang]) return undefined;
    const keys = key.split('.');
    let value = this.translations[lang];
    for (const k of keys) {
      if (value && typeof value === 'object' && k in value) {
        value = value[k];
      } else {
        return undefined;
      }
    }
    return value;
  };

  let v = tryGet(this.currentLang);
  if (v === undefined && this.currentLang !== this.fallbackLang) {
    v = tryGet(this.fallbackLang);
  }
  return v;
  }

  /**
   * Set current language and update UI
   *
   * @param {string} lang - Language code
   * @param {boolean} updateUI - Whether to update UI elements
   * @returns {Promise<boolean>} True if successful
   */
  async setLanguage(lang, updateUI = true) {
  if (!this.supportedLanguages.includes(lang)) {
  console.warn(`[i18n] Unsupported language: ${lang}, using fallback`);
  lang = this.fallbackLang;
  }

  const { success, langUsed } = await this.loadTranslations(lang);
  if (!success || !langUsed) {
  console.error(`[i18n] Failed to load language: ${lang}`);
  return false;
  }

  if (langUsed !== lang) {
  console.warn(`[i18n] Falling back to language: ${langUsed}`);
  }

  this.currentLang = langUsed;

  localStorage.setItem('webdev-tools-lang', langUsed);
  this.setLanguageCookie(langUsed);

  document.documentElement.lang = langUsed;

  const direction = this.translations[langUsed]?.meta?.direction || 'ltr';
  document.documentElement.dir = direction;

  if (updateUI) {
  this.updateUI();
  this.updateLanguageSwitcher();
  this.reloadActiveTool();
  }

  window.dispatchEvent(new CustomEvent('languageChanged', {
  detail: {
  lang: langUsed,
  translations: this.translations[langUsed]
  }
  }));

  return true;
  }

  /**
   * Update all elements with i18n attributes
   */
  updateUI() {
  document.querySelectorAll('[data-i18n]').forEach(el => {
  const key = el.getAttribute('data-i18n');
  el.textContent = this.t(key);
  });

  document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
  const key = el.getAttribute('data-i18n-placeholder');
  el.placeholder = this.t(key);
  });

  document.querySelectorAll('[data-i18n-title]').forEach(el => {
  const key = el.getAttribute('data-i18n-title');
  el.title = this.t(key);
  });

  document.querySelectorAll('[data-i18n-aria]').forEach(el => {
  const key = el.getAttribute('data-i18n-aria');
  el.setAttribute('aria-label', this.t(key));
  });

  console.debug('[i18n] UI updated for language:', this.currentLang);
  }

  /**
   * Setup language switcher event handlers
   */
  setupLanguageSwitcher() {
  console.debug('[i18n] Setting up language switcher');

  const handleLanguageClick = async (e) => {
    const langLink = e.target.closest('.language-option');
    if (langLink) {
      e.preventDefault();
      e.stopPropagation();

      const lang = langLink.getAttribute('data-lang');
      const targetUrl = langLink.getAttribute('href');

      console.log(`[i18n] Language change requested: ${lang}`);

      if (lang === this.currentLang) {
        console.log('[i18n] Already using language:', lang);
        return;
      }

      const success = await this.setLanguage(lang);

      if (success && targetUrl) {
        // Use the href from the link (supports localized slugs)
        window.location.href = targetUrl;
      } else if (success) {
        // Fallback: use old URL rewriting method
        this.updateURL(this.currentLang);
      } else {
        console.error(`[i18n] Failed to switch to language: ${lang}, staying on ${this.currentLang}`);
      }

      // Close dropdowns
      const dropdowns = document.querySelectorAll('.dropdown-menu.show');
      dropdowns.forEach(dd => dd.classList.remove('show'));

      const offcanvas = document.querySelector('#mobileSidebar');
      if (offcanvas && offcanvas.classList.contains('show')) {
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
        if (bsOffcanvas) bsOffcanvas.hide();
      }
    }
  };

  if (this._languageClickHandler) {
    document.removeEventListener('click', this._languageClickHandler);
  }

  this._languageClickHandler = handleLanguageClick;

  document.addEventListener('click', this._languageClickHandler);

  console.log('[i18n] Language switcher event handler registered');
  }

  /**
   * Update URL to navigate to correct language version
   * English: /lorem-ipsum/
   * German: /de/lorem-ipsum/
   *
   * @param {string} lang - Language code
   */
  updateURL(lang) {
    const currentPath = window.location.pathname;
    const currentSearch = window.location.search;
    const basePath = window.__BASE_PATH__ || '';

    console.log('[i18n] Current path:', currentPath);

    let newPath = currentPath;
    const basePathPattern = basePath ? basePath.replace(/\//g, '\\/') : '';

    if (lang === 'en') {
      // Switch to English: Remove any language prefix
      const pattern = new RegExp(`${basePathPattern}\\/(de|es|pt|fr|it)\\/`);
      newPath = currentPath.replace(pattern, `${basePath}/`);
    } else {
      // Switch to other language
      const existingLangPattern = new RegExp(`${basePathPattern}\\/(de|es|pt|fr|it)\\/`);
      if (currentPath.match(existingLangPattern)) {
        // Replace existing language prefix
        newPath = currentPath.replace(existingLangPattern, `${basePath}/${lang}/`);
      } else {
        // Add language prefix
        const addLangPattern = new RegExp(`${basePathPattern}\\/`);
        newPath = currentPath.replace(addLangPattern, `${basePath}/${lang}/`);
      }
    }

    if (newPath !== currentPath) {
      console.log('[i18n] Navigating to:', newPath);
      window.location.href = newPath + currentSearch;
    } else {
      console.log('[i18n] Already on correct language path');
    }
  }

  /**
   * Update language switcher button to show current language
   */
  updateLanguageSwitcher() {
  const langInfo = this.languageNames[this.currentLang];
  if (!langInfo) return;

  console.debug('[i18n] Updating language switcher to:', langInfo.native);

  // Language switcher is now a floating button with dropdown
  // No need to update desktop/mobile labels anymore

  const options = document.querySelectorAll('.language-option');
  console.debug('[i18n] Found', options.length, 'language options');

  options.forEach(option => {
    const optionLang = option.getAttribute('data-lang');
    if (optionLang === this.currentLang) {
      option.classList.add('active');
    } else {
      option.classList.remove('active');
    }
  });

  console.debug(`[i18n] Language switcher updated to: ${langInfo.native}`);
  }

  /**
   * Get all supported languages with metadata
   *
   * @returns {Array} Array of language objects
   */
  getSupportedLanguages() {
  return this.supportedLanguages.map(code => ({
  code,
  ...this.languageNames[code]
  }));
  }

  /**
   * Get current language code
   *
   * @returns {string} Current language code
   */
  getCurrentLanguage() {
  return this.currentLang;
  }

  /**
   * Get current language info with metadata
   *
   * @returns {Object} Language info object
   */
  getCurrentLanguageInfo() {
  return {
  code: this.currentLang,
  ...this.languageNames[this.currentLang]
  };
  }

  /**
   * Reload active tool to reflect language changes
   */
  reloadActiveTool() {
  const toolContainer = document.querySelector('#tool-container');
  if (!toolContainer || !window.currentToolName) {
  return;
  }

  if (window.Tools && window.Tools.get) {
  const tool = window.Tools.get(window.currentToolName);
  if (tool && typeof tool.open === 'function') {
  toolContainer.innerHTML = '';
  tool.open(toolContainer);
  console.debug('[i18n] Reloaded tool:', window.currentToolName);
  }
  }
  }

  /**
   * Set language cookie via server-side handler
   *
   * @param {string} lang - Language code
   */
  setLanguageCookie(lang) {
    // Use dynamic BASE_PATH for deployment flexibility
    const basePath = window.APP_BASE_PATH || '';
    const handlerUrl = `${basePath}/config/language-handler.php`;

    // Try server-side cookie handler first (for production with proper domain)
    fetch(handlerUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: `lang=${encodeURIComponent(lang)}`,
      signal: typeof AbortSignal !== 'undefined' && AbortSignal.timeout 
        ? AbortSignal.timeout(1000) 
        : undefined
    })
    .then(response => response.json())
    .then(data => {
      if (!data.success) {
        // Server-side handler failed, use client-side fallback
        document.cookie = `webdev-tools-lang=${lang}; path=/; max-age=${30 * 24 * 60 * 60}; SameSite=Strict`;
      }
    })
    .catch(() => {
      // Network error or timeout - use client-side fallback silently
      document.cookie = `webdev-tools-lang=${lang}; path=/; max-age=${30 * 24 * 60 * 60}; SameSite=Strict`;
    });
  }
}

window.I18n = I18n;
window.i18n = new I18n();
