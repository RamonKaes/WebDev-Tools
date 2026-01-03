/**
 * String Escaper Tool
 *
 * Escape and unescape strings for HTML, XML, JavaScript, JSON, SQL, and CSV formats.
 * Provides bidirectional conversion with format-specific rules to prevent injection attacks.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[stringEscaperTool] Tools registry not available.');
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
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(key, params);
    }
    return key.split('.').pop().replace(/([A-Z])/g, ' $1').trim();
  }

  /**
   * Format-specific escape and unescape functions
   *
   * Security: Proper escaping prevents XSS, SQL injection, and CSV injection attacks.
   */
  const escapers = {
    html: {
      /**
       * Escape HTML special characters
       *
       * @param {string} str - Input string
       * @returns {string} - HTML-escaped string
       */
      escape: (str) => {
        if (typeof window !== 'undefined' && window.AppHelpers && typeof window.AppHelpers.escapeHtml === 'function') {
          return window.AppHelpers.escapeHtml(str);
        }

        if (typeof str !== 'string') return '';
        return str
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#039;');
      },
      /**
       * Unescape HTML entities to plain text
       *
       * @param {string} str - HTML-escaped string
       * @returns {string} - Unescaped plain text
       */
      unescape: (str) => {
        const div = document.createElement('div');
        div.innerHTML = str;
        return div.textContent;
      }
    },
    xml: {
      /**
       * Escape XML special characters
       *
       * @param {string} str - Input string
       * @returns {string} - XML-escaped string
       */
      escape: (str) => {
        return str
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&apos;');
      },
      /**
       * Unescape XML entities to plain text
       *
       * @param {string} str - XML-escaped string
       * @returns {string} - Unescaped plain text
       */
      unescape: (str) => {
        return str
          .replace(/&apos;/g, "'")
          .replace(/&quot;/g, '"')
          .replace(/&gt;/g, '>')
          .replace(/&lt;/g, '<')
          .replace(/&amp;/g, '&');
      }
    },
    javascript: {
      /**
       * Escape JavaScript string literals
       *
       * @param {string} str - Input string
       * @returns {string} - JavaScript-escaped string
       */
      escape: (str) => {
        return str
          .replace(/\\/g, '\\\\')
          .replace(/'/g, "\\'")
          .replace(/"/g, '\\"')
          .replace(/\n/g, '\\n')
          .replace(/\r/g, '\\r')
          .replace(/\t/g, '\\t')
          .replace(/\f/g, '\\f')
          .replace(/\v/g, '\\v');
      },
      /**
       * Unescape JavaScript escape sequences
       *
       * @param {string} str - JavaScript-escaped string
       * @returns {string} - Unescaped plain text
       */
      unescape: (str) => {
        return str
          .replace(/\\v/g, '\v')
          .replace(/\\f/g, '\f')
          .replace(/\\t/g, '\t')
          .replace(/\\r/g, '\r')
          .replace(/\\n/g, '\n')
          .replace(/\\"/g, '"')
          .replace(/\\'/g, "'")
          .replace(/\\\\/g, '\\');
      }
    },
    json: {
      /**
       * Escape JSON string values
       *
       * @param {string} str - Input string
       * @returns {string} - JSON-escaped string without quotes
       */
      escape: (str) => {
        return JSON.stringify(str).slice(1, -1);
      },
      /**
       * Unescape JSON escape sequences
       *
       * @param {string} str - JSON-escaped string
       * @returns {string} - Unescaped plain text or original on error
       */
      unescape: (str) => {
        try {
          return JSON.parse('"' + str + '"');
        } catch (e) {
          return str;
        }
      }
    },
    sql: {
      /**
       * Escape SQL single quotes
       *
       * Security: Prevents SQL injection by doubling single quotes.
       *
       * @param {string} str - Input string
       * @returns {string} - SQL-escaped string
       */
      escape: (str) => {
        return str.replace(/'/g, "''");
      },
      /**
       * Unescape SQL doubled single quotes
       *
       * @param {string} str - SQL-escaped string
       * @returns {string} - Unescaped plain text
       */
      unescape: (str) => {
        return str.replace(/''/g, "'");
      }
    },
    csv: {
      /**
       * Escape CSV field values
       *
       * Security: Prevents CSV injection by wrapping fields containing special characters.
       *
       * @param {string} str - Input string
       * @returns {string} - CSV-escaped string with quotes if needed
       */
      escape: (str) => {
        if (str.includes(',') || str.includes('"') || str.includes('\n')) {
          return '"' + str.replace(/"/g, '""') + '"';
        }
        return str;
      },
      /**
       * Unescape CSV quoted fields
       *
       * @param {string} str - CSV-escaped string
       * @returns {string} - Unescaped plain text
       */
      unescape: (str) => {
        if (str.startsWith('"') && str.endsWith('"')) {
          return str.slice(1, -1).replace(/""/g, '"');
        }
        return str;
      }
    }
  };

  const stringEscaperTool = {
    /**
     * Initialize the String Escaper Tool
     */
    init: function () {
      console.debug('String Escaper Tool initialized');
    },

    /**
     * Open the String Escaper Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        return key.split('.').pop();
      };

      container.innerHTML = `
      <div class="row g-4" id="mainRow">
        <div class="col-12 position-relative" id="inputOutputWrapper">
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.stringEscaperTool.input_title')}</h2>

                  <div class="mb-3">
                    <label class="form-label">${t('tools.stringEscaperTool.formatLabel')}</label>
                    <select class="form-select form-select-sm" id="escapeFormat">
                      <option value="html">HTML</option>
                      <option value="xml">XML</option>
                      <option value="javascript">JavaScript</option>
                      <option value="json">JSON</option>
                      <option value="sql">SQL</option>
                      <option value="csv">CSV</option>
                    </select>
                  </div>

                  <div class="btn-group btn-group-sm mb-3 w-100" role="group">
                    <input type="radio" class="btn-check" name="mode" id="modeEscape" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeEscape"><i class="bi bi-lock me-1"></i>${t('tools.stringEscaperTool.escapeBtn')}</label>

                    <input type="radio" class="btn-check" name="mode" id="modeUnescape" autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeUnescape"><i class="bi bi-unlock me-1"></i>${t('tools.stringEscaperTool.unescapeBtn')}</label>
                  </div>

                  <textarea class="form-control font-monospace mb-3" id="inputText" rows="12" placeholder="${t('tools.stringEscaperTool.inputPlaceholder')}"></textarea>

                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="processBtn"><i class="bi bi-arrow-right me-2"></i>${t('tools.stringEscaperTool.processBtn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('common.clear')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('common.load_sample')}</button>
                  </div>

                  <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" type="checkbox" id="autoProcess">
                    <label class="form-check-label" for="autoProcess">${t('tools.stringEscaperTool.autoProcess')}</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-code-square me-2"></i>${t('tools.stringEscaperTool.output_title')}</h2>

                  <textarea class="form-control bg-body-secondary font-monospace mb-3" id="outputText" rows="12" readonly placeholder="${t('tools.stringEscaperTool.outputPlaceholder')}"></textarea>

                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <small class="text-muted me-auto" id="outputInfo"></small>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyBtn"><i class="bi bi-clipboard me-2"></i>${t('common.copy')}</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Floating Toggle Button -->
          <button class="btn btn-secondary btn-layout-toggle d-none d-lg-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle shadow"
                  id="toggleLayoutBtn"
                  title="${t('common.toggle_layout')}">
            <i class="bi bi-layout-three-columns"></i>
          </button>
        </div>
      </div>
      `;

      // DOM elements
      const toggleLayoutBtn = document.getElementById('toggleLayoutBtn');
      const mainRow = document.getElementById('mainRow');
      const inputText = document.getElementById('inputText');
      const outputText = document.getElementById('outputText');
      const formatSelect = document.getElementById('escapeFormat');
      const modeEscape = document.getElementById('modeEscape');
      const modeUnescape = document.getElementById('modeUnescape');
      const processBtn = document.getElementById('processBtn');
      const clearBtn = document.getElementById('clearBtn');
      const loadSampleBtn = document.getElementById('loadSampleBtn');
      const copyBtn = document.getElementById('copyBtn');
      const autoProcess = document.getElementById('autoProcess');
      const outputInfo = document.getElementById('outputInfo');

      // Layout toggle functionality
      const wrapper = document.getElementById('inputOutputWrapper');

      if (toggleLayoutBtn && wrapper) {
        toggleLayoutBtn.addEventListener('click', () => {
          const columns = wrapper.querySelectorAll('.row > .col-12');
          if (columns.length === 0) return;

          const isSideBySide = columns[0].classList.contains('col-lg-6');

          if (isSideBySide) {
            columns.forEach(col => col.classList.remove('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-split"></i>`;
            toggleLayoutBtn.title = t('common.layout_side_by_side');
            toggleLayoutBtn.classList.remove('top-50', 'start-50', 'translate-middle');
            toggleLayoutBtn.classList.add('top-0', 'end-0', 'btn-layout-toggle-stacked');
          } else {
            columns.forEach(col => col.classList.add('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-three-columns"></i>`;
            toggleLayoutBtn.title = t('common.layout_stacked');
            toggleLayoutBtn.classList.remove('top-0', 'end-0', 'btn-layout-toggle-stacked');
            toggleLayoutBtn.classList.add('top-50', 'start-50', 'translate-middle');
          }
        });
      }

      // Process function
      function process() {
        const format = formatSelect.value;
        const input = inputText.value;
        const isEscape = modeEscape.checked;

        if (!input.trim()) {
          outputText.value = '';
          outputInfo.textContent = '';
          return;
        }

        try {
          const result = isEscape
            ? escapers[format].escape(input)
            : escapers[format].unescape(input);

          outputText.value = result;

          // Update info
          const bytes = new Blob([result]).size;
          const chars = result.length;
          outputInfo.textContent = `${chars} ${t('tools.stringEscaperTool.characters')}, ${bytes} ${t('tools.stringEscaperTool.bytes')}`;
        } catch (error) {
          console.error('Process error:', error);
          outputText.value = isEscape
            ? t('tools.stringEscaperTool.errorEscape')
            : t('tools.stringEscaperTool.errorUnescape');
          outputInfo.textContent = '';
        }
      }

      // Update process button text based on mode
      function updateProcessButton() {
        const isEscape = modeEscape.checked;
        const icon = isEscape ? 'lock' : 'unlock';
        const text = isEscape ? t('tools.stringEscaperTool.escapeBtn') : t('tools.stringEscaperTool.unescapeBtn');
        processBtn.innerHTML = `<i class="bi bi-${icon} me-2"></i>${text}`;
      }

      // Event listeners
      processBtn.addEventListener('click', process);

      modeEscape.addEventListener('change', () => {
        updateProcessButton();
        if (autoProcess.checked && inputText.value) {
          process();
        }
      });

      modeUnescape.addEventListener('change', () => {
        updateProcessButton();
        if (autoProcess.checked && inputText.value) {
          process();
        }
      });

      formatSelect.addEventListener('change', () => {
        if (autoProcess.checked && inputText.value) {
          process();
        }
      });

      inputText.addEventListener('input', () => {
        if (autoProcess.checked) {
          process();
        }
      });

      clearBtn.addEventListener('click', () => {
        inputText.value = '';
        outputText.value = '';
        outputInfo.textContent = '';
        inputText.focus();
      });

      loadSampleBtn.addEventListener('click', () => {
        const mode = document.querySelector('input[name="mode"]:checked').id;
        if (mode === 'modeEscape') {
          inputText.value = 'Hello "World"!\nThis has \'quotes\' and special chars: <>&\nBackslash: \\ and newlines\nTabs:\there';
        } else {
          inputText.value = 'Hello \\"World\\"!\\nThis has \\\'quotes\\\' and special chars: &lt;&gt;&amp;\\nBackslash: \\\\ and newlines\\nTabs:\\there';
        }
        if (autoProcess.checked) {
          handleProcess();
        }
      });

      copyBtn.addEventListener('click', async () => {
        const text = outputText.value;
        if (!text) return;

        const success = await window.ClipboardUtils.copyToClipboard(text);
        
        if (success) {
          const originalHTML = copyBtn.innerHTML;
          copyBtn.innerHTML = `<i class="bi bi-check2 me-2"></i>${t('common.copied')}`;
          copyBtn.classList.add('btn-success');

          setTimeout(() => {
            copyBtn.innerHTML = originalHTML;
            copyBtn.classList.remove('btn-success');
          }, 2000);
        } else {
          console.error('Copy failed');
        }
      });

      // Initialize
      updateProcessButton();
      // Don't auto-focus to avoid annoying mobile keyboard popup
    }
  };

  window.Tools.register('stringEscaperTool', stringEscaperTool);

})();
