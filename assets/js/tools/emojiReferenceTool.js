/**
 * Emoji Reference Tool
 *
 * Browse and copy emojis with Unicode and HTML decimal codes.
 * Includes category filtering and search functionality.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[emojiReference] Tools registry not available.');
    return;
  }

  /**
   * Helper function for internationalization
   *
   * @param {string} key - Translation key
   * @param {object} params - Parameters for interpolation
   * @returns {string} - Translated string
   */
  function t(key, params) {
    // If key already contains the full path, use it directly
    if (key.includes('.')) {
      return window.i18n && typeof window.i18n.t === 'function'
        ? window.i18n.t(key, params)
        : key.split('.').pop().replace(/([A-Z])/g, ' $1').trim();
    }
    // Otherwise, prefix with tools.emojiReferenceTool
    return window.i18n && typeof window.i18n.t === 'function'
      ? window.i18n.t(`tools.emojiReferenceTool.${key}`, params)
      : key.replace(/([A-Z])/g, ' $1').trim();
  }

  let EMOJI_DATA = [];
  let currentCategory = 'all';
  let currentPage = 0;
  const ITEMS_PER_PAGE = 50;

  const CATEGORIES = {
    all: () => t('categoryAll'),
    ui: () => t('categoryUI'),
    common: () => t('categoryCommon'),
    emotions: () => t('categoryEmotions'),
    gestures: () => t('categoryGestures'),
    tech: () => t('categoryTech'),
    business: () => t('categoryBusiness'),
    dev: () => t('categoryDev'),
    arrows: () => t('categoryArrows')
  };

  /**
   * Loads emoji data from JSON file
   */
  async function loadEmojiData() {
    try {
      const basePath = window.__BASE_PATH__ || '';
      const response = await fetch(`${basePath}/assets/data/emojis.json`);
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      EMOJI_DATA = await response.json();
    } catch (error) {
      console.error('[EmojiReference] Failed to load emoji data:', error);
      throw error;
    }
  }

  window.Tools.register('emojiReferenceTool', {
    init: function () {
      // Empty init - actual initialization happens in open()
    },

    open: async function (container) {
      if (!container) return;

      // Load data if not yet loaded
      if (EMOJI_DATA.length === 0) {
        container.innerHTML = '<div class="text-center p-5"><div class="spinner-border" role="status"></div><p class="mt-2">Loading emojis...</p></div>';
        try {
          await loadEmojiData();
        } catch (error) {
          container.innerHTML = '<div class="alert alert-danger">Failed to load emoji data.</div>';
          return;
        }
      }

      container.innerHTML = `
        <div class="row g-3">
          <div class="col-12">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" id="emojiSearch" placeholder="${t('common.search')}..." autocomplete="off">
            </div>
          </div>
          <div class="col-12">
            <div class="btn-group btn-group-sm w-100 flex-wrap" role="group" id="categoryFilters"></div>
          </div>
          <div class="col-12">
            <div id="emojiGrid" class="row g-2"></div>
          </div>
        </div>
      `;

      setupEventListeners();
      renderCategories();
      renderEmojis();
    }
  });

  function setupEventListeners() {
    const searchInput = document.getElementById('emojiSearch');
    if (searchInput) {
      searchInput.addEventListener('input', () => renderEmojis());
    }
  }

  /**
   * Render category filter buttons
   */
  function renderCategories() {
    const container = document.getElementById('categoryFilters');
    if (!container) return;

    let html = '';

    for (const [key, labelFn] of Object.entries(CATEGORIES)) {
      const active = key === currentCategory ? 'active' : '';
      const label = typeof labelFn === 'function' ? labelFn() : labelFn;
      html += `<button type="button" class="btn btn-outline-primary ${active}" data-category="${key}">${label}</button>`;
    }

    container.innerHTML = html;

    container.addEventListener('click', (e) => {
      const btn = e.target.closest('button[data-category]');
      if (!btn) return;

      container.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentCategory = btn.dataset.category;
      renderEmojis(currentCategory);
    });
  }

  /**
   * Render emoji grid with category and search filtering
   *
   * Supports virtual loading with pagination (50 items per page).
   *
   * @param {string} category - Category filter ('all' or specific category)
   */
  function renderEmojis(category = 'all') {
    const grid = document.getElementById('emojiGrid');
    const search = document.getElementById('emojiSearch');
    if (!grid) return;

    const searchTerm = search ? search.value.toLowerCase() : '';

    let filtered = EMOJI_DATA.filter(item => {
      const matchesCategory = category === 'all' || item.category === category;
      const matchesSearch = !searchTerm || item.name.toLowerCase().includes(searchTerm);
      return matchesCategory && matchesSearch;
    });

    if (filtered.length === 0) {
      grid.innerHTML = `<div class="col-12"><div class="alert alert-info">No emojis found.</div></div>`;
      return;
    }

    // Virtual loading: render first 50 emojis initially
    currentPage = 0;
    grid.innerHTML = '';
    renderEmojiPage(filtered, grid);

    // Add load more button if more than 50 emojis
    if (filtered.length > ITEMS_PER_PAGE) {
      const loadMoreBtn = document.createElement('div');
      loadMoreBtn.className = 'col-12 text-center mt-3';
      loadMoreBtn.innerHTML = `
        <button class="btn btn-primary" id="loadMoreEmojis">
          <i class="bi bi-arrow-down-circle"></i> Load More (${filtered.length - ITEMS_PER_PAGE} remaining)
        </button>
      `;
      grid.appendChild(loadMoreBtn);

      // Load more button event handler
      document.getElementById('loadMoreEmojis')?.addEventListener('click', function() {
        currentPage++;
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';

        setTimeout(() => {
          renderEmojiPage(filtered, grid);
          const remaining = filtered.length - ((currentPage + 1) * ITEMS_PER_PAGE);

          if (remaining > 0) {
            btn.disabled = false;
            btn.innerHTML = `<i class="bi bi-arrow-down-circle"></i> Load More (${remaining} remaining)`;
          } else {
            btn.remove();
          }
        }, 100); // Small delay for better UX
      });
    }
  }

  /**
   * Render a page of emoji cards
   *
   * Includes XSS protection by escaping emoji data from JSON.
   *
   * @param {Array} filtered - Filtered emoji array
   * @param {HTMLElement} grid - Grid container element
   */
  function renderEmojiPage(filtered, grid) {
    const startIdx = currentPage * ITEMS_PER_PAGE;
    const endIdx = Math.min(startIdx + ITEMS_PER_PAGE, filtered.length);
    const pageItems = filtered.slice(startIdx, endIdx);

    let html = '';
    pageItems.forEach(item => {
      const decimal = parseInt(item.code, 16);

      const safeEmoji = window.AppHelpers ? window.AppHelpers.escapeHtml(item.emoji) : item.emoji;
      const safeName = window.AppHelpers ? window.AppHelpers.escapeHtml(item.name) : item.name;
      const safeEmojiAttr = window.AppHelpers ? window.AppHelpers.escapeAttr(item.emoji) : item.emoji.replace(/"/g, '&quot;');

      html += `
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <div class="card h-100 text-center">
            <div class="card-body p-2">
              <div class="fs-1 mb-2">${safeEmoji}</div>
              <small class="d-block mb-1">${safeName}</small>
              <div class="btn-group-vertical w-100" role="group">
                <button class="btn btn-sm btn-outline-primary copy-emoji" data-value="${safeEmojiAttr}" title="Copy emoji">
                  <i class="bi bi-clipboard"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary copy-code" data-value="&amp;#${decimal};" title="Copy HTML code">
                  &amp;#${decimal};
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
    });

    const oldBtn = grid.querySelector('#loadMoreEmojis')?.parentElement;
    if (oldBtn) oldBtn.remove();

    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;
    while (tempDiv.firstChild) {
      grid.appendChild(tempDiv.firstChild);
    }

    setupCopyButtons();
  }

  /**
   * Setup copy-to-clipboard functionality for emoji buttons
   *
   * Uses event delegation for better performance.
   */
  function setupCopyButtons() {
    const grid = document.getElementById('emojiGrid');
    if (!grid) return;

    grid.addEventListener('click', async (e) => {
      const btn = e.target.closest('.copy-emoji, .copy-code');
      if (!btn) return;

      const value = btn.dataset.value;
      const success = await window.ClipboardUtils.copyToClipboard(value);
      
      if (success) {
        const icon = btn.querySelector('i');
        if (icon) {
          icon.className = 'bi bi-check';
          setTimeout(() => icon.className = 'bi bi-clipboard', 1500);
        }
      } else {
        console.error('Copy failed');
      }
    });
  }
})();
