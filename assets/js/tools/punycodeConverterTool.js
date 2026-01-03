/**
 * Punycode Converter Tool
 *
 * Convert international domain names (IDN) to Punycode ASCII format and vice versa.
 * Implements RFC 3492 for encoding Unicode domain names to ASCII-compatible format.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'punycodeConverterTool'})
      : '[punycodeConverterTool] Tools registry not available.';
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
   * Punycode implementation based on RFC 3492
   *
   * Encodes and decodes Unicode strings to ASCII-compatible format for domain names.
   */
  const Punycode = {
    base: 36,
    tMin: 1,
    tMax: 26,
    skew: 38,
    damp: 700,
    initialBias: 72,
    initialN: 128,
    delimiter: '-',
    maxInt: 2147483647,

    /**
     * Encode Unicode string to Punycode
     *
     * @param {string} input - Unicode string to encode
     * @returns {string} - Punycode-encoded string
     */
    encode: function(input) {
      const output = [];
      const inputLength = input.length;
      let n = this.initialN;
      let delta = 0;
      let bias = this.initialBias;

      // Handle ASCII characters
      for (let i = 0; i < inputLength; i++) {
        const c = input.charCodeAt(i);
        if (c < 0x80) {
          output.push(input.charAt(i));
        }
      }

      const basicLength = output.length;
      let handledCount = basicLength;

      if (basicLength > 0) {
        output.push(this.delimiter);
      }

      // Main encoding loop
      while (handledCount < inputLength) {
        let m = this.maxInt;

        for (let i = 0; i < inputLength; i++) {
          const c = input.charCodeAt(i);
          if (c >= n && c < m) {
            m = c;
          }
        }

        delta += (m - n) * (handledCount + 1);
        n = m;

        for (let i = 0; i < inputLength; i++) {
          const c = input.charCodeAt(i);

          if (c < n) {
            delta++;
          }

          if (c === n) {
            let q = delta;

            for (let k = this.base; ; k += this.base) {
              const t = k <= bias ? this.tMin : (k >= bias + this.tMax ? this.tMax : k - bias);

              if (q < t) {
                break;
              }

              const qMinusT = q - t;
              const baseMinusT = this.base - t;

              output.push(String.fromCharCode(this.digitToBasic(t + qMinusT % baseMinusT)));
              q = Math.floor(qMinusT / baseMinusT);
            }

            output.push(String.fromCharCode(this.digitToBasic(q)));
            bias = this.adapt(delta, handledCount + 1, handledCount === basicLength);
            delta = 0;
            handledCount++;
          }
        }

        delta++;
        n++;
      }

      return output.join('');
    },

    /**
     * Decode Punycode string to Unicode
     *
     * @param {string} input - Punycode string to decode
     * @returns {string} - Decoded Unicode string
     * @throws {Error} - If input contains invalid Punycode
     */
    decode: function(input) {
      const output = [];
      const inputLength = input.length;
      let i = 0;
      let n = this.initialN;
      let bias = this.initialBias;

      // Extract and validate basic ASCII characters
      let basic = input.lastIndexOf(this.delimiter);

      if (basic < 0) {
        basic = 0;
      }

      for (let j = 0; j < basic; j++) {
        if (input.charCodeAt(j) >= 0x80) {
          throw new Error('Invalid input');
        }
        output.push(input.charAt(j));
      }

      // Decode variable-length integers for non-ASCII characters
      for (let index = basic > 0 ? basic + 1 : 0; index < inputLength; ) {
        const oldi = i;
        let w = 1;

        // Decode next code point insertion position
        for (let k = this.base; ; k += this.base) {
          if (index >= inputLength) {
            throw new Error('Invalid input');
          }

          const digit = this.basicToDigit(input.charCodeAt(index++));

          if (digit >= this.base) {
            throw new Error('Invalid input');
          }

          i += digit * w;
          const t = k <= bias ? this.tMin : (k >= bias + this.tMax ? this.tMax : k - bias);

          if (digit < t) {
            break;
          }

          w *= this.base - t;
        }

        const outLength = output.length + 1;
        bias = this.adapt(i - oldi, outLength, oldi === 0);
        n += Math.floor(i / outLength);
        i %= outLength;
        output.splice(i++, 0, String.fromCharCode(n));
      }

      return output.join('');
    },

    /**
     * Adapt bias for variable-length encoding
     *
     * @param {number} delta - Current delta value
     * @param {number} numPoints - Number of code points processed
     * @param {boolean} firstTime - Whether this is the first adaptation
     * @returns {number} - New bias value
     */
    adapt: function(delta, numPoints, firstTime) {
      delta = firstTime ? Math.floor(delta / this.damp) : delta >> 1;
      delta += Math.floor(delta / numPoints);

      let k = 0;
      while (delta > ((this.base - this.tMin) * this.tMax) >> 1) {
        delta = Math.floor(delta / (this.base - this.tMin));
        k += this.base;
      }

      return Math.floor(k + (this.base - this.tMin + 1) * delta / (delta + this.skew));
    },

    /**
     * Convert basic code point to digit
     *
     * @param {number} codePoint - Code point to convert
     * @returns {number} - Corresponding digit value
     */
    basicToDigit: function(codePoint) {
      if (codePoint - 48 < 10) {
        return codePoint - 22;
      }
      if (codePoint - 65 < 26) {
        return codePoint - 65;
      }
      if (codePoint - 97 < 26) {
        return codePoint - 97;
      }
      return this.base;
    },

    /**
     * Convert digit to basic code point
     *
     * @param {number} digit - Digit to convert
     * @returns {number} - Corresponding code point
     */
    digitToBasic: function(digit) {
      return digit + 22 + 75 * (digit < 26 ? 1 : 0);
    }
  };

  /**
   * Convert domain name between Unicode and Punycode
   *
   * @param {string} domain - Domain name to convert
   * @param {boolean} toPunycode - True to encode to Punycode, false to decode
   * @returns {string} - Converted domain name
   */
  function convertDomain(domain, toPunycode) {
    const parts = domain.toLowerCase().split('.');

    return parts.map(part => {
      if (toPunycode) {
        // Check if part contains non-ASCII
        if (/[^\x00-\x7F]/.test(part)) {
          return 'xn--' + Punycode.encode(part);
        }
        return part;
      } else {
        // Decode punycode
        if (part.startsWith('xn--')) {
          return Punycode.decode(part.slice(4));
        }
        return part;
      }
    }).join('.');
  }

  /**
   * Detect if string contains Punycode encoding
   *
   * @param {string} str - String to check
   * @returns {boolean} - True if string contains Punycode prefix (xn--)
   */
  function isPunycode(str) {
    return /xn--/.test(str);
  }

  window.Tools.register('punycodeConverterTool', {
    /**
     * Open the Punycode Converter Tool in the provided container
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
                    <div class="col-md-6">
                      <label class="form-label fw-bold">
                        <i class="bi bi-sliders me-2"></i>${t('tools.punycodeConverterTool.modeLabel')}
                      </label>
                      <div class="btn-group btn-group-sm w-100" role="group">
                        <input type="radio" class="btn-check" name="mode" id="modeEncode" value="encode" checked autocomplete="off">
                        <label class="btn btn-outline-primary" for="modeEncode">
                          <i class="bi bi-arrow-right me-1"></i>${t('tools.punycodeConverterTool.toPunycode')}
                        </label>

                        <input type="radio" class="btn-check" name="mode" id="modeDecode" value="decode" autocomplete="off">
                        <label class="btn btn-outline-primary" for="modeDecode">
                          <i class="bi bi-arrow-left me-1"></i>${t('tools.punycodeConverterTool.toUnicode')}
                        </label>

                        <input type="radio" class="btn-check" name="mode" id="modeAuto" value="auto" autocomplete="off">
                        <label class="btn btn-outline-primary" for="modeAuto">
                          <i class="bi bi-lightning me-1"></i>${t('common.auto')}
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold d-block">
                        <i class="bi bi-lightning me-2"></i>${t('common.auto')}
                      </label>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="autoConvert" checked>
                        <label class="form-check-label" for="autoConvert">
                          ${t('tools.punycodeConverterTool.autoConvert')}
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
                        <i class="bi bi-pencil me-2"></i>${t('tools.punycodeConverterTool.inputTitle')}
                      </h2>

                      <textarea
                        class="form-control font-monospace mb-3"
                        id="inputText"
                        rows="12"
                        placeholder="${t('tools.punycodeConverterTool.inputPlaceholder')}"
                      ></textarea>

                      <div class="d-flex flex-wrap gap-2 align-items-center">
                        <button class="btn btn-sm btn-primary" id="convertBtn">
                          <i class="bi bi-arrow-right me-2"></i>${t('tools.punycodeConverterTool.convert')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="clearBtn">
                          <i class="bi bi-trash me-2"></i>${t('common.clear')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="exampleBtn">
                          <i class="bi bi-lightning me-2"></i>${t('tools.punycodeConverterTool.example')}
                        </button>
                        <small class="text-muted ms-auto" id="inputStats">0 ${t('common.characters')}</small>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-lg-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <h2 class="h5 card-title mb-3">
                        <i class="bi bi-arrow-right me-2"></i>${t('tools.punycodeConverterTool.outputTitle')}
                      </h2>

                      <textarea
                        class="form-control bg-body-secondary font-monospace mb-3"
                        id="outputText"
                        rows="12"
                        readonly
                        placeholder="${t('tools.punycodeConverterTool.outputPlaceholder')}"
                      ></textarea>

                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <small class="text-muted me-auto" id="outputStats">0 ${t('common.characters')}</small>
                        <button class="btn btn-sm btn-outline-secondary" id="copyBtn">
                          <i class="bi bi-clipboard me-2"></i>${t('common.copy')}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="downloadBtn">
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
        console.error('Error in punycodeConverterTool.open:', e);
      }
    },

    initializeTool: function(container) {
      const inputText = container.querySelector('#inputText');
      const outputText = container.querySelector('#outputText');
      const modeRadios = container.querySelectorAll('input[name="mode"]');
      const autoConvert = container.querySelector('#autoConvert');
      const convertBtn = container.querySelector('#convertBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const exampleBtn = container.querySelector('#exampleBtn');
      const copyBtn = container.querySelector('#copyBtn');
      const downloadBtn = container.querySelector('#downloadBtn');
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
        const text = inputText.value.trim();

        if (!text) {
          outputText.value = '';
          updateStats();
          return;
        }

        try {
          let mode = container.querySelector('input[name="mode"]:checked').value;

          // Auto-detect mode
          if (mode === 'auto') {
            mode = isPunycode(text) ? 'decode' : 'encode';
          }

          const result = convertDomain(text, mode === 'encode');
          outputText.value = result;
          updateStats();

        } catch (e) {
          outputText.value = `Error: ${e.message}`;
          updateStats();
        }
      }

      // Mode change handler
      modeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
          if (autoConvert.checked) convert();
        });
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

      // Example button
      exampleBtn.addEventListener('click', () => {
        const examples = [
          'münchen.de',
          'zürich.ch',
          'москва.рф',
          '日本.jp',
          'ελλάδα.gr'
        ];
        inputText.value = examples.join('\n');
        if (autoConvert.checked) convert();
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
        a.download = 'punycode.txt';
        a.click();
        URL.revokeObjectURL(url);
      });

      // Initial stats
      updateStats();
    }
  });

  if (typeof window.logger !== 'undefined') {
    window.logger.info('Punycode Converter Tool loaded');
  }
})();
