/**
 * HTML Entity Encoder/Decoder Tool
 *
 * Encode and decode HTML entities with support for named, numeric decimal, and hexadecimal formats.
 * Security: Properly encodes special characters to prevent XSS attacks.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'htmlEntityTool'})
      : '[htmlEntityTool] Tools registry not available.';
    console.warn(msg);
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
   * Common HTML entities mapping
   *
   * Maps special characters to their named HTML entity equivalents.
   */
  const NAMED_ENTITIES = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&apos;',
    '©': '&copy;',
    '®': '&reg;',
    '™': '&trade;',
    '€': '&euro;',
    '£': '&pound;',
    '¥': '&yen;',
    '¢': '&cent;',
    '°': '&deg;',
    '±': '&plusmn;',
    '×': '&times;',
    '÷': '&divide;',
    '¼': '&frac14;',
    '½': '&frac12;',
    '¾': '&frac34;',
    '←': '&larr;',
    '→': '&rarr;',
    '↑': '&uarr;',
    '↓': '&darr;',
    '↔': '&harr;',
    ' ': '&nbsp;',
    '–': '&ndash;',
    '—': '&mdash;',
    '…': '&hellip;',
    '•': '&bull;',
    '§': '&sect;',
    '¶': '&para;',
    '†': '&dagger;',
    '‡': '&Dagger;',
    '‰': '&permil;',
    '‹': '&lsaquo;',
    '›': '&rsaquo;',
    '«': '&laquo;',
    '»': '&raquo;',
    '\u2018': '&lsquo;',
    '\u2019': '&rsquo;',
    '\u201C': '&ldquo;',
    '\u201D': '&rdquo;'
  };

  /**
   * Encode text to named HTML entities
   *
   * Security: Prevents XSS by encoding special HTML characters.
   *
   * @param {string} text - Input text
   * @returns {string} - Text with named entities
   */
  function encodeToNamedEntities(text) {
    return text.replace(/[&<>"']/g, char => NAMED_ENTITIES[char] || char);
  }

  /**
   * Encode text to numeric HTML entities
   *
   * @param {string} text - Input text
   * @param {boolean} useHex - Whether to use hexadecimal format
   * @returns {string} - Text with numeric entities
   */
  function encodeToNumericEntities(text, useHex = false) {
    return text.replace(/[\u00A0-\u9999<>&"']/g, char => {
      const code = char.charCodeAt(0);
      if (useHex) {
        return `&#x${code.toString(16)};`;
      }
      return `&#${code};`;
    });
  }

  /**
   * Encode all characters to named entities where available
   *
   * @param {string} text - Input text
   * @returns {string} - Text with all characters encoded to named entities
   */
  function encodeToAllNamedEntities(text) {
    return text.replace(/./g, char => {
      return NAMED_ENTITIES[char] || char;
    });
  }

  /**
   * Decode HTML entities to plain text
   *
   * @param {string} text - Text with HTML entities
   * @returns {string} - Decoded plain text
   */
  function decodeEntities(text) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = text;
    return textarea.value;
  }

  window.Tools.register('htmlEntityTool', {
    /**
     * Open the HTML Entity Encoder/Decoder Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      try {
        container.innerHTML = `
          <div class="row g-4" id="mainRow">
            <!-- Configuration Card -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-bold">
                        <i class="bi bi-sliders me-2"></i>${t('tools.htmlEntityTool.modeLabel')}
                      </label>
                      <div class="btn-group btn-group-sm w-100" role="group">
                        <input type="radio" class="btn-check" name="mode" id="modeEncode" value="encode" checked autocomplete="off">
                        <label class="btn btn-outline-primary d-inline-flex align-items-center" for="modeEncode">
                          <i class="bi bi-lock me-1"></i>${t('tools.htmlEntityTool.encode')}
                        </label>

                        <input type="radio" class="btn-check" name="mode" id="modeDecode" value="decode" autocomplete="off">
                        <label class="btn btn-outline-primary d-inline-flex align-items-center" for="modeDecode">
                          <i class="bi bi-unlock me-1"></i>${t('tools.htmlEntityTool.decode')}
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4" id="entityTypeWrapper">
                      <label class="form-label fw-bold">
                        <i class="bi bi-gear me-2"></i>${t('tools.htmlEntityTool.entityType')}
                      </label>
                      <select class="form-select form-select-sm" id="entityType">
                        <option value="named">${t('tools.htmlEntityTool.namedEntities')}</option>
                        <option value="numeric">${t('tools.htmlEntityTool.numericDecimal')}</option>
                        <option value="hex">${t('tools.htmlEntityTool.numericHex')}</option>
                        <option value="all">${t('tools.htmlEntityTool.allNamed')}</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-bold d-block">
                        <i class="bi bi-lightning me-2"></i>${t('common.auto')}
                      </label>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="autoConvert" checked>
                        <label class="form-check-label" for="autoConvert">
                          ${t('tools.htmlEntityTool.autoConvert')}
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Input/Output with Toggle Button -->
            <div class="col-12 position-relative" id="inputOutputWrapper">
              <div class="row g-4">
                <div class="col-12 col-lg-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <h2 class="h5 card-title mb-3">
                        <i class="bi bi-pencil me-2"></i>${t('tools.htmlEntityTool.inputTitle')}
                      </h2>

                      <textarea
                        class="form-control font-monospace mb-3"
                        id="inputText"
                        rows="15"
                        placeholder="${t('tools.htmlEntityTool.inputPlaceholder')}"
                      ></textarea>

                      <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="convertBtn">
                          <i class="bi bi-arrow-right me-2"></i>${t('tools.htmlEntityTool.convert')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn">
                          <i class="bi bi-trash me-2"></i>${t('common.clear')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn">
                          <i class="bi bi-file-earmark me-2"></i>${t('common.load_sample')}
                        </button>
                        <a href="#" class="btn btn-sm btn-outline-info ms-auto d-inline-flex align-items-center" id="viewReferenceBtn">
                          <i class="bi bi-book me-2"></i>${t('tools.htmlEntityTool.viewReference')}
                        </a>
                      </div>

                      <small class="text-muted mt-2 d-block" id="inputStats">0 ${t('common.characters')}</small>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-lg-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <h2 class="h5 card-title mb-3">
                        <i class="bi bi-arrow-right me-2"></i>${t('tools.htmlEntityTool.outputTitle')}
                      </h2>

                      <textarea
                        class="form-control bg-body-secondary font-monospace mb-3"
                        id="outputText"
                        rows="15"
                        readonly
                        placeholder="${t('tools.htmlEntityTool.outputPlaceholder')}"
                      ></textarea>

                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <small class="text-muted me-auto" id="outputStats">0 ${t('common.characters')}</small>
                        <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyBtn">
                          <i class="bi bi-clipboard me-2"></i>${t('common.copy')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="downloadBtn">
                          <i class="bi bi-download me-2"></i>Download
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Floating Toggle Button -->
              <button class="btn btn-secondary btn-layout-toggle d-none d-lg-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle shadow"
                      id="toggleLayoutBtn"
                      title="${t('common.toggle_layout', 'Toggle layout')}">
                <i class="bi bi-layout-three-columns"></i>
              </button>
            </div>
          </div>
        `;

        this.initializeTool(container);

      } catch (e) {
        container.innerHTML = `
          <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>${t('common.error')}:</strong> ${e.message}
          </div>
        `;
        console.error('Error in htmlEntityTool.open:', e);
      }
    },

    initializeTool: function(container) {
      const inputText = container.querySelector('#inputText');
      const outputText = container.querySelector('#outputText');
      const modeRadios = container.querySelectorAll('input[name="mode"]');
      const entityTypeSelect = container.querySelector('#entityType');
      const entityTypeWrapper = container.querySelector('#entityTypeWrapper');
      const autoConvert = container.querySelector('#autoConvert');
      const convertBtn = container.querySelector('#convertBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const loadSampleBtn = container.querySelector('#loadSampleBtn');
      const copyBtn = container.querySelector('#copyBtn');
      const downloadBtn = container.querySelector('#downloadBtn');
      const viewReferenceBtn = container.querySelector('#viewReferenceBtn');
      const inputStats = container.querySelector('#inputStats');
      const outputStats = container.querySelector('#outputStats');

      // Layout toggle functionality
      const toggleLayoutBtn = container.querySelector('#toggleLayoutBtn');
      const wrapper = container.querySelector('#inputOutputWrapper');

      if (toggleLayoutBtn && wrapper) {
        toggleLayoutBtn.addEventListener('click', () => {
          const columns = wrapper.querySelectorAll('.row > .col-12');
          const isSideBySide = columns[0].classList.contains('col-lg-6');

          if (isSideBySide) {
            columns.forEach(col => col.classList.remove('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-split"></i>`;
            toggleLayoutBtn.classList.remove('top-50', 'start-50', 'translate-middle');
            toggleLayoutBtn.classList.add('top-0', 'end-0', 'btn-layout-toggle-stacked');
          } else {
            columns.forEach(col => col.classList.add('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-three-columns"></i>`;
            toggleLayoutBtn.classList.remove('top-0', 'end-0', 'btn-layout-toggle-stacked');
            toggleLayoutBtn.classList.add('top-50', 'start-50', 'translate-middle');
          }
        });
      }

      // Update stats
      function updateStats() {
        const inputLength = inputText.value.length;
        const outputLength = outputText.value.length;
        const userLocale = document.documentElement.lang || 'en';
        inputStats.textContent = `${inputLength.toLocaleString(userLocale)} ${t('common.characters')}`;
        outputStats.textContent = `${outputLength.toLocaleString(userLocale)} ${t('common.characters')}`;
      }

      // Perform conversion
      function convert() {
        const text = inputText.value;
        const mode = container.querySelector('input[name="mode"]:checked').value;
        const entityType = entityTypeSelect.value;

        if (!text) {
          outputText.value = '';
          updateStats();
          return;
        }

        let result = '';

        if (mode === 'encode') {
          switch (entityType) {
            case 'named':
              result = encodeToNamedEntities(text);
              break;
            case 'numeric':
              result = encodeToNumericEntities(text, false);
              break;
            case 'hex':
              result = encodeToNumericEntities(text, true);
              break;
            case 'all':
              result = encodeToAllNamedEntities(text);
              break;
          }
        } else {
          result = decodeEntities(text);
        }

        outputText.value = result;
        updateStats();
      }

      // Mode change handler
      modeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
          const isEncode = radio.value === 'encode';
          entityTypeWrapper.style.display = isEncode ? 'block' : 'none';
          if (autoConvert.checked) convert();
        });
      });

      // Entity type change
      entityTypeSelect.addEventListener('change', () => {
        if (autoConvert.checked) convert();
      });

      // Auto convert
      autoConvert.addEventListener('change', () => {
        if (autoConvert.checked) convert();
      });

      // Input listener
      inputText.addEventListener('input', () => {
        updateStats();
        if (autoConvert.checked) convert();
      });

      // Convert button
      convertBtn.addEventListener('click', convert);

      // Clear button
      clearBtn.addEventListener('click', () => {
        inputText.value = '';
        outputText.value = '';
        updateStats();
        inputText.focus();
      });

      // Load sample button
      loadSampleBtn.addEventListener('click', () => {
        const mode = container.querySelector('input[name="mode"]:checked').value;
        if (mode === 'encode') {
          inputText.value = '<div class="example">\n  <h1>Hello World!</h1>\n  <p>Special characters: © ® ™ € £ ¥ &lt;&gt;</p>\n  <a href="https://example.com?id=123&name=test">Link</a>\n</div>';
        } else {
          inputText.value = '&lt;div class=&quot;example&quot;&gt;\n  &lt;h1&gt;Hello World!&lt;/h1&gt;\n  &lt;p&gt;Special characters: &copy; &reg; &trade; &euro; &pound; &yen; &amp;lt;&amp;gt;&lt;/p&gt;\n  &lt;a href=&quot;https://example.com?id=123&amp;name=test&quot;&gt;Link&lt;/a&gt;\n&lt;/div&gt;';
        }
        if (autoConvert.checked) {
          performConversion();
        }
        updateStats();
      });

      // Copy button
      copyBtn.addEventListener('click', async () => {
        if (!outputText.value) return;

        const success = await window.ClipboardUtils.copyToClipboard(outputText.value);
        
        if (success) {
          const icon = copyBtn.querySelector('i');
          if (icon) {
            const originalClass = icon.className;
            icon.className = 'bi bi-check2 me-2';
            copyBtn.classList.add('btn-success');
            copyBtn.classList.remove('btn-outline-secondary');

            setTimeout(() => {
              if (icon) {
                icon.className = originalClass;
              }
              copyBtn.classList.remove('btn-success');
              copyBtn.classList.add('btn-outline-secondary');
            }, 2000);
          }
        } else {
          console.error('Failed to copy to clipboard');
        }
      });

      // Download button
      downloadBtn.addEventListener('click', () => {
        if (!outputText.value) return;

        const blob = new Blob([outputText.value], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'html-entities.txt';
        a.click();
        URL.revokeObjectURL(url);
      });

      // View Reference button
      viewReferenceBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (window.Tools && window.Tools.open) {
          window.Tools.open('characterReferenceTool');
        }
      });

      // Initial stats
      updateStats();
    }
  });

  if (typeof window.logger !== 'undefined') {
    window.logger.info('HTML Entity Encoder/Decoder Tool loaded');
  }
})();
