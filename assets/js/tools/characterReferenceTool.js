/**
 * Character Reference Tool
 *
 * Comprehensive reference for HTML entities, special characters, symbols, and Unicode.
 * Includes search, filtering by category, and copy-to-clipboard functionality.
 */
(function () {
  'use strict';

  /**
   * Copy text to clipboard using global ClipboardUtils
   *
   * @param {string} text - Text to copy
   * @returns {Promise<boolean>} - True if copy succeeded
   */
  async function copyToClipboard(text, message) {
    return await window.ClipboardUtils.copyToClipboard(text, message);
  }

  /**
   * Show toast notification via ClipboardUtils
   *
   * @param {string} message - Message to display
   * @param {string} type - Type of toast ('success', 'error', 'info')
   */
  function showToast(message, type = 'success') {
    if (window.ClipboardUtils && typeof window.ClipboardUtils.showToast === 'function') {
      window.ClipboardUtils.showToast(message, type);
    }
  }

  /**
   * Build the URL of another tool's page in the current language.
   *
   * Tool modules are loaded per page, so a sibling tool cannot be opened in
   * place - its module is not registered here.
   *
   * @param {string} toolId - Registry id of the target tool
   * @param {string} fallbackSlug - English slug used if the manifest is absent
   * @returns {string} - Absolute path to the tool page
   */
  function toolUrl(toolId, fallbackSlug) {
    const basePath = window.APP_BASE_PATH || '';
    const container = document.getElementById('tool-container');
    const lang = (container && container.dataset.lang) || 'en';

    let slug = fallbackSlug;
    try {
      const cached = JSON.parse(localStorage.getItem('toolbox_manifest') || '{}');
      const slugs = cached.manifest && cached.manifest.tools
        && cached.manifest.tools[toolId] && cached.manifest.tools[toolId].slugs;
      if (slugs && slugs[lang]) {
        slug = slugs[lang];
      }
    } catch (e) {
      // Cache unreadable - the English slug still resolves
    }

    const prefix = lang === 'en' ? '' : `/${lang}`;
    return `${basePath}${prefix}/${slug}/`;
  }

  if (typeof window.Tools === 'undefined') {
    console.warn('[characterReference] Tools registry not available.');
    return;
  }

  const t = (key) => {
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(`tools.characterReferenceTool.${key}`);
    }
    return key;
  };

  const state = {
    currentCategory: 'all',
    searchQuery: '',
    characters: [],
    filteredCharacters: [],
    isLoading: false,
    currentPage: 0,
    itemsPerPage: 100,
    isFullDatasetLoaded: false
  };

  /**
   * Initialize the Character Reference Tool
   *
   * @param {HTMLElement} container - Container element for the tool
   */
  async function init(container) {
    try {
      await loadCharacters();
      renderUI(container);
      attachEventListeners();
      setupCopyButtonDelegation();
      updateTable();
    } catch (error) {
      console.error('[characterReference] Failed to load characters:', error);
      showToast(t('errorLoading') || 'Error loading character reference', 'error');
    }
  }

  /**
   * Load character dataset from JSON file
   *
   * Initially loads common.json (27KB), full dataset (2,231 chars) available on demand.
   *
   * @param {boolean} loadFull - Whether to load full dataset (characters-complete.json)
   */
  async function loadCharacters(loadFull = false) {
    if (state.isLoading) return;

    if (!loadFull && state.characters.length > 0) return;
    if (loadFull && state.isFullDatasetLoaded) return;

    state.isLoading = true;

    try {
      const dataset = loadFull ? 'characters-complete.json' : 'characters-common.json';
      const basePath = window.__BASE_PATH__ || '';
      const response = await fetch(`${basePath}/assets/data/${dataset}`);
      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      state.characters = await response.json();
      updateCategoryCounts();

      if (loadFull) {
        state.isFullDatasetLoaded = true;
        console.log(`[CharacterReference] Loaded full dataset (${state.characters.length} characters)`);
      } else {
        console.log(`[CharacterReference] Loaded common dataset (${state.characters.length} characters)`);
      }
    } catch (error) {
      console.error('[CharacterReference] Failed to load characters:', error);
      throw error;
    } finally {
      state.isLoading = false;
    }
  }

  /**
   * Update category option counts based on the loaded dataset
   */
  function updateCategoryCounts() {
    const select = document.getElementById('categoryFilter');
    if (!select) return;

    const counts = {};
    state.characters.forEach(char => {
      counts[char.category] = (counts[char.category] || 0) + 1;
    });

    const categoryKeys = {
      all: 'categoryAll',
      math: 'categoryMath',
      symbols: 'categorySymbols',
      arrows: 'categoryArrows',
      diacritics: 'categoryDiacritics',
      greek: 'categoryGreek',
      punctuation: 'categoryPunctuation',
      html: 'categoryHTML',
      box: 'categoryBox',
      lists: 'categoryLists',
      currency: 'categoryCurrency'
    };

    select.querySelectorAll('option').forEach(opt => {
      const cat = opt.value;
      const key = categoryKeys[cat];
      if (!key) return;
      const count = cat === 'all' ? state.characters.length : (counts[cat] || 0);
      opt.textContent = `${t(key)} (${count})`;
    });
  }

  /**
   * Render the main UI structure with search, filters, and table
   *
   * @param {HTMLElement} container - Container element
   */
  function renderUI(container) {
    if (!container) {
      container = document.getElementById('tool-container');
    }
    if (!container) return;

    container.innerHTML = `
    <div class="row g-3">
      <!-- Controls -->
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="row g-3">
              <!-- Search -->
              <div class="col-md-5">
                <label for="charSearch" class="form-label fw-bold">
                  <i class="bi bi-search me-2"></i>${t('searchTitle')}
                </label>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  id="charSearch"
                  placeholder="${t('searchPlaceholder')}"
                  aria-label="Search characters"
                >
                <small class="form-text text-muted">${t('searchHint')}</small>
              </div>

              <!-- Category Filter -->
              <div class="col-md-5">
                <label for="categoryFilter" class="form-label fw-bold">
                  <i class="bi bi-funnel me-2"></i>${t('categoriesTitle')}
                </label>
                <select class="form-select form-select-sm" id="categoryFilter" aria-label="Category filter">
                  <option value="all">${t('categoryAll')}</option>
                  <option value="math">${t('categoryMath')}</option>
                  <option value="symbols">${t('categorySymbols')}</option>
                  <option value="arrows">${t('categoryArrows')}</option>
                  <option value="diacritics">${t('categoryDiacritics')}</option>
                  <option value="greek">${t('categoryGreek')}</option>
                  <option value="punctuation">${t('categoryPunctuation')}</option>
                  <option value="html">${t('categoryHTML')}</option>
                  <option value="box">${t('categoryBox')}</option>
                  <option value="lists">${t('categoryLists')}</option>
                  <option value="currency">${t('categoryCurrency')}</option>
                </select>
              </div>

              <!-- Link to HTML Entity Tool -->
              <div class="col-md-2">
                <label class="form-label fw-bold invisible">Action</label>
                <a href="#" class="btn btn-sm btn-outline-secondary w-100 d-block" id="openEntityEncoderBtn" title="${t('openEntityEncoder') || 'Open HTML Entity Encoder'}">
                  <i class="bi bi-code-slash me-1"></i>
                  <span class="d-none d-lg-inline">${t('encodeDecodeLabel')}</span>
                  <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
              </div>
            </div>

            <!-- Load Full Dataset Toggle -->
            <div class="row mt-3 d-none" id="loadFullDatasetRow">
              <div class="col-12">
                <div class="alert alert-info mb-0 d-flex align-items-center justify-content-between">
                  <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>${t('loadCommonCount').replace('{count}', state.characters.length)}</strong> —
                    <span>${t('loadCommonHint')}</span>
                  </div>
                  <button class="btn btn-sm btn-primary" id="loadFullDatasetBtn">
                    <i class="bi bi-download me-1"></i>${t('loadFullBtn')}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Character Table -->
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h2 class="h6 fw-semibold mb-0">${t('tableTitle')}</h5>
            <small id="charCount"></small>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover table-striped mb-0" id="charTable">
                <thead class="table-light sticky-top">
                  <tr>
                    <th class="text-center char-col-char">${t('tableHeaderChar')}</th>
                    <th class="char-col-name">${t('tableHeaderName')}</th>
                    <th class="char-col-entity">${t('tableHeaderEntity')}</th>
                    <th class="char-col-unicode">${t('tableHeaderUnicode')}</th>
                    <th class="char-col-decimal">${t('tableHeaderDecimal')}</th>
                    <th class="text-center char-col-copy">${t('tableHeaderCopy')}</th>
                  </tr>
                </thead>
                <tbody id="charTableBody">
                  <!-- Populated by JavaScript -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  }

  /**
   * Attach event listeners
   */
  function attachEventListeners() {
    const searchInput = document.getElementById('charSearch');
    if (searchInput) {
      searchInput.addEventListener('input', debounce((e) => {
        state.searchQuery = e.target.value.toLowerCase();
        updateTable();
      }, 300));
    }

    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
      categoryFilter.addEventListener('change', (e) => {
        state.currentCategory = e.target.value;
        updateTable();
      });
    }

    const openEntityEncoderBtn = document.getElementById('openEntityEncoderBtn');
    if (openEntityEncoderBtn) {
      // Only the current page's tool module is loaded, so the encoder cannot
      // be opened in place - navigate to its page instead.
      openEntityEncoderBtn.href = toolUrl('htmlEntityTool', 'html-entity-encoder-decoder');
    }

    const loadFullDatasetBtn = document.getElementById('loadFullDatasetBtn');
    if (loadFullDatasetBtn) {
      loadFullDatasetBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        const btn = e.target.closest('button');
        const originalHTML = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span>${t('loadingText')}`;

        try {
          await loadCharacters(true);
          updateTable();

          const loadRow = document.getElementById('loadFullDatasetRow');
          if (loadRow) loadRow.classList.add('d-none');

          showToast(t('loadFullSuccess'), 'success');
        } catch (error) {
          btn.disabled = false;
          btn.innerHTML = originalHTML;
          showToast(t('loadFullError'), 'error');
        }
      });
    }
  }

  /**
   * Update the character table based on current filters and search query
   */
  function updateTable() {
    const loadFullRow = document.getElementById('loadFullDatasetRow');
    if (loadFullRow) {
      if (!state.isFullDatasetLoaded && state.characters.length > 0) {
        loadFullRow.classList.remove('d-none');
      } else if (state.isFullDatasetLoaded) {
        loadFullRow.classList.add('d-none');
      }
    }

    state.filteredCharacters = state.characters.filter(char => {
      if (state.currentCategory !== 'all' && char.category !== state.currentCategory) {
        return false;
      }

      if (state.searchQuery) {
        const searchLower = state.searchQuery;
        return (
          char.name.toLowerCase().includes(searchLower) ||
          char.entity.toLowerCase().includes(searchLower) ||
          char.unicode.toLowerCase().includes(searchLower) ||
          char.decimal.toLowerCase().includes(searchLower) ||
          char.char.includes(state.searchQuery) // Case-sensitive for actual character
        );
      }

      return true;
    });

    const countEl = document.getElementById('charCount');
    if (countEl) {
      const showing = state.filteredCharacters.length;
      const total = state.characters.length;
      const countText = t('showingCount') || 'Showing {showing} of {total} characters';
      countEl.textContent = countText.replace('{showing}', showing).replace('{total}', total);
    }

    state.currentPage = 0;
    renderTableRows();
  }

  /**
   * Build HTML for a single character table row
   *
   * @param {Object} char - Character data object
   * @returns {string} - Row HTML string
   */
  function buildRowHTML(char) {
    return `
    <tr>
      <td class="text-center fs-4 align-middle">
        ${escapeHtml(char.char)}
      </td>
      <td class="align-middle">${escapeHtml(char.name)}</td>
      <td class="align-middle"><code>${escapeHtml(char.entity)}</code></td>
      <td class="align-middle"><code>${escapeHtml(char.unicode)}</code></td>
      <td class="align-middle"><code>${escapeHtml(char.decimal)}</code></td>
      <td class="text-center align-middle">
        <div class="btn-group btn-group-sm" role="group">
          <button
            class="btn btn-outline-primary char-copy-btn"
            data-copy-type="char"
            data-copy-value="${escapeForAttribute(char.char)}"
            title="${t('copyChar') || 'Copy character'}"
            aria-label="Copy character ${escapeForAttribute(char.name)}"
          >
            <i class="bi bi-fonts"></i>
          </button>
          <button
            class="btn btn-outline-secondary char-copy-btn"
            data-copy-type="entity"
            data-copy-value="${escapeForAttribute(char.entity)}"
            title="${t('copyEntity') || 'Copy entity'}"
            aria-label="Copy HTML entity ${escapeForAttribute(char.entity)}"
          >
            &amp;
          </button>
          <button
            class="btn btn-outline-info char-copy-btn"
            data-copy-type="unicode"
            data-copy-value="${escapeForAttribute(char.unicode)}"
            title="${t('copyUnicode') || 'Copy Unicode'}"
            aria-label="Copy Unicode ${escapeForAttribute(char.unicode)}"
          >
            U+
          </button>
          <button
            class="btn btn-outline-success char-copy-btn"
            data-copy-type="decimal"
            data-copy-value="${escapeForAttribute(char.decimal)}"
            title="${t('copyDecimal') || 'Copy decimal'}"
            aria-label="Copy decimal ${escapeForAttribute(char.decimal)}"
          >
            #
          </button>
        </div>
      </td>
    </tr>
  `;
  }

  /**
   * Build and append a "Load More" row to the table body
   *
   * @param {HTMLElement} tbody - Table body element
   * @param {number} remaining - Number of remaining characters
   */
  function appendLoadMoreRow(tbody, remaining) {
    const loadMoreRow = document.createElement('tr');
    loadMoreRow.id = 'loadMoreRow';
    loadMoreRow.innerHTML = `
      <td colspan="6" class="text-center py-3">
        <button class="btn btn-primary" id="loadMoreChars">
          <i class="bi bi-arrow-down-circle"></i> ${t('loadMore').replace('{remaining}', remaining)}
        </button>
      </td>
    `;
    tbody.appendChild(loadMoreRow);

    document.getElementById('loadMoreChars')?.addEventListener('click', function () {
      state.currentPage++;
      const btn = this;
      btn.disabled = true;
      btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> ${t('loadingText')}`;
      appendTableRows();
    });
  }

  /**
   * Render character table rows with pagination
   *
   * Supports virtual scrolling with 100 items per page.
   */
  function renderTableRows() {
    const tbody = document.getElementById('charTableBody');
    if (!tbody) return;

    if (state.filteredCharacters.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-5">
            <p class="mb-1">${t('noResults') || 'No characters found'}</p>
            <small class="text-muted">${t('noResultsHint') || 'Try a different search term or category'}</small>
          </td>
        </tr>
      `;
      return;
    }

    const startIdx = state.currentPage * state.itemsPerPage;
    const endIdx = Math.min(startIdx + state.itemsPerPage, state.filteredCharacters.length);
    const pageChars = state.filteredCharacters.slice(startIdx, endIdx);

    tbody.innerHTML = pageChars.map(buildRowHTML).join('');

    const remaining = state.filteredCharacters.length - endIdx;
    if (remaining > 0) {
      appendLoadMoreRow(tbody, remaining);
    }
  }

  /**
   * Append more rows to existing table (for Load More button)
   */
  function appendTableRows() {
    const tbody = document.getElementById('charTableBody');
    const loadMoreRow = document.getElementById('loadMoreRow');
    if (!tbody) return;

    if (loadMoreRow) loadMoreRow.remove();

    const startIdx = state.currentPage * state.itemsPerPage;
    const endIdx = Math.min(startIdx + state.itemsPerPage, state.filteredCharacters.length);
    const pageChars = state.filteredCharacters.slice(startIdx, endIdx);

    tbody.insertAdjacentHTML('beforeend', pageChars.map(buildRowHTML).join(''));

    const remaining = state.filteredCharacters.length - endIdx;
    if (remaining > 0) {
      appendLoadMoreRow(tbody, remaining);
    }
  }

  /**
   * Setup event delegation for copy buttons
   *
   * Called once during initialization to handle all current and future buttons.
   */
  function setupCopyButtonDelegation() {
    const table = document.getElementById('charTable');
    if (!table) return;

    table.addEventListener('click', function (e) {
      const btn = e.target.closest('.char-copy-btn');
      if (!btn) return;

      e.preventDefault();

      const type = btn.getAttribute('data-copy-type');
      const value = btn.getAttribute('data-copy-value');

      if (type && value) {
        copyCharacterData(type, value);
      }
    });
  }

  /**
   * Copy character data to clipboard with feedback
   *
   * @param {string} type - Type of data ('char', 'entity', 'unicode', 'decimal')
   * @param {string} value - Value to copy
   */
  async function copyCharacterData(type, value) {
    const messages = {
      char: t('copiedChar') || 'Character copied',
      entity: t('copiedEntity') || 'HTML entity copied',
      unicode: t('copiedUnicode') || 'Unicode copied',
      decimal: t('copiedDecimal') || 'Decimal code copied'
    };

    try {
      // The message is passed through - copyToClipboard raises the toast itself
      await copyToClipboard(value, messages[type]);
    } catch (error) {
      console.error('[CharacterReference] Copy failed:', error);
    }
  }

  /**
   * Escape HTML special characters for safe rendering
   *
   * @param {string} text - Text to escape
   * @returns {string} - Escaped HTML
   */
  function escapeHtml(text) {
    if (typeof window !== 'undefined' && window.AppHelpers && typeof window.AppHelpers.escapeHtml === 'function') {
      return window.AppHelpers.escapeHtml(text);
    }

    if (typeof text !== 'string') return '';
    return text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  /**
   * Escape text for safe use in HTML attributes
   *
   * @param {string} text - Text to escape
   * @returns {string} - Escaped attribute value
   */
  function escapeForAttribute(text) {
    if (typeof text !== 'string') return '';
    return text
      .replace(/&/g, '&amp;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

  /**
   * Debounce function to limit search input frequency
   *
   * @param {Function} func - Function to debounce
   * @param {number} wait - Wait time in milliseconds
   * @returns {Function} - Debounced function
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

  // Register with Tools registry
  window.Tools.register('characterReferenceTool', {
    init: function () {
      // Empty init - actual initialization happens in open()
    },

    open: function (container) {
      init(container);
    }
  });

})();
