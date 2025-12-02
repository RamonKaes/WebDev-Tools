/**
 * PX to REM Converter Tool
 * 
 * Convert between pixels and rem units with customizable base font size.
 * Supports batch conversion, real-time calculation, and Tailwind CSS spacing.
 */
(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'pxToRemConverter'}) : '[pxToRemConverter] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('pxToRemConverter', {
    /**
     * Initialize the PX to REM Converter Tool
     */
    init: function () {
    },

    /**
     * Open the PX to REM Converter Tool in the provided container
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

      container.innerHTML = '<div class="row g-4"><div class="col-12"><div class="card"><div class="card-body"><h2 class="h5 card-title mb-3"><i class="bi bi-gear me-2"></i>' + t('tools.pxToRemConverter.base_settings_title') + '</h2><div class="row g-3"><div class="col-md-6"><label for="baseFontSize" class="form-label">' + t('tools.pxToRemConverter.base_font_size_label') + '</label><div class="input-group input-group-sm"><input type="number" class="form-control form-control-sm" id="baseFontSize" value="16" min="1" max="100"><span class="input-group-text">px</span></div><div class="d-flex gap-2 flex-wrap mt-2"><button class="btn btn-sm btn-outline-primary preset-btn" data-size="12">12px</button><button class="btn btn-sm btn-outline-primary preset-btn" data-size="14">14px</button><button class="btn btn-sm btn-primary preset-btn" data-size="16">16px</button><button class="btn btn-sm btn-outline-primary preset-btn" data-size="18">18px</button><button class="btn btn-sm btn-outline-primary preset-btn" data-size="20">20px</button></div><small class="text-muted">' + t('tools.pxToRemConverter.base_font_hint') + '</small></div><div class="col-md-6"><label for="parentSize" class="form-label">' + t('tools.pxToRemConverter.parent_size_label') + '</label><div class="input-group input-group-sm"><input type="number" class="form-control form-control-sm" id="parentSize" value="16" min="1" max="1000"><span class="input-group-text">px</span></div><small class="text-muted">' + t('tools.pxToRemConverter.parent_size_hint') + '</small></div></div></div></div></div><div class="col-12 col-lg-6"><div class="card h-100"><div class="card-body"><h2 class="h5 card-title mb-3"><i class="bi bi-calculator me-2"></i>' + t('tools.pxToRemConverter.converter_title') + '</h2><div class="mb-3"><label for="pxInput" class="form-label">' + t('tools.pxToRemConverter.pixel_label') + '</label><div class="input-group"><input type="number" class="form-control form-control-sm" id="pxInput" placeholder="e.g. 24" step="0.01"><span class="input-group-text">px</span><button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" type="button" id="clearPx"><i class="bi bi-x-lg"></i></button></div></div><div class="mb-3"><small class="text-muted d-block mb-2">' + t('tools.pxToRemConverter.quick_values') + '</small><div class="d-flex gap-1 flex-wrap"><button class="btn btn-sm btn-outline-secondary px-preset" data-px="8">8</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="12">12</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="16">16</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="20">20</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="24">24</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="32">32</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="48">48</button><button class="btn btn-sm btn-outline-secondary px-preset" data-px="64">64</button></div></div><hr><div class="results-grid"><div class="mb-3"><label class="form-label d-flex align-items-center justify-content-between"><span><i class="bi bi-arrow-right text-primary me-1"></i> REM</span><button class="btn btn-sm btn-link p-0 copy-btn d-inline-flex align-items-center" data-target="remOutput"><i class="bi bi-clipboard"></i></button></label><input type="text" class="form-control form-control-sm bg-body-secondary font-monospace" id="remOutput" readonly></div><div class="mb-3"><label class="form-label d-flex align-items-center justify-content-between"><span><i class="bi bi-arrow-right text-success me-1"></i> EM</span><button class="btn btn-sm btn-link p-0 copy-btn d-inline-flex align-items-center" data-target="emOutput"><i class="bi bi-clipboard"></i></button></label><input type="text" class="form-control form-control-sm bg-body-secondary font-monospace" id="emOutput" readonly><small class="text-muted">' + t('tools.pxToRemConverter.em_relative_hint') + '</small></div><div class="mb-3"><label class="form-label d-flex align-items-center justify-content-between"><span><i class="bi bi-arrow-right text-warning me-1"></i> ' + t('tools.pxToRemConverter.percentage_label') + '</span><button class="btn btn-sm btn-link p-0 copy-btn d-inline-flex align-items-center" data-target="percentOutput"><i class="bi bi-clipboard"></i></button></label><input type="text" class="form-control form-control-sm bg-body-secondary font-monospace" id="percentOutput" readonly></div><div class="mb-3"><label class="form-label d-flex align-items-center justify-content-between"><span><i class="bi bi-arrow-right text-info me-1"></i> Tailwind</span><button class="btn btn-sm btn-link p-0 copy-btn d-inline-flex align-items-center" data-target="tailwindOutput"><i class="bi bi-clipboard"></i></button></label><input type="text" class="form-control form-control-sm bg-body-secondary font-monospace" id="tailwindOutput" readonly><small class="text-muted">' + t('tools.pxToRemConverter.tailwind_hint') + '</small></div></div></div></div></div><div class="col-12 col-lg-6"><div class="card h-100"><div class="card-body"><h2 class="h5 card-title mb-3"><i class="bi bi-arrow-left-right me-2"></i>' + t('tools.pxToRemConverter.reverse_title') + '</h2><div class="mb-3"><label class="form-label">' + t('tools.pxToRemConverter.convert_from_label') + '</label><select class="form-select form-select-sm" id="reverseUnitType"><option value="rem">REM</option><option value="em">EM</option><option value="percent">%</option><option value="tailwind">Tailwind</option></select></div><div class="mb-3"><label for="reverseInput" class="form-label" id="reverseInputLabel">REM</label><div class="input-group"><input type="number" class="form-control form-control-sm" id="reverseInput" placeholder="e.g. 1.5" step="0.01"><span class="input-group-text" id="reverseInputUnit">rem</span><button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" type="button" id="clearReverse"><i class="bi bi-x-lg"></i></button></div></div><div class="mb-3"><label class="form-label d-flex align-items-center justify-content-between"><span><i class="bi bi-arrow-down text-primary me-1"></i> ' + t('tools.pxToRemConverter.result_pixels') + '</span><button class="btn btn-sm btn-link p-0 copy-btn d-inline-flex align-items-center" data-target="reversePxOutput"><i class="bi bi-clipboard"></i></button></label><input type="text" class="form-control bg-body-secondary font-monospace" id="reversePxOutput" readonly></div><hr><div class="alert alert-info small mb-0"><h3 class="h6 alert-heading"><i class="bi bi-info-circle me-2"></i>' + t('tools.pxToRemConverter.info_title') + '</h3><ul class="mb-0 ps-3"><li><strong>REM:</strong> ' + t('tools.pxToRemConverter.rem_info') + '</li><li><strong>EM:</strong> ' + t('tools.pxToRemConverter.em_info') + '</li><li><strong>%:</strong> ' + t('tools.pxToRemConverter.percent_info') + '</li><li><strong>Tailwind:</strong> ' + t('tools.pxToRemConverter.tailwind_info') + '</li></ul></div></div></div></div><div class="col-12"><div class="card"><div class="card-body"><h2 class="h5 card-title mb-3"><i class="bi bi-table me-2"></i>' + t('tools.pxToRemConverter.conversion_table_title') + '</h2><div class="table-responsive"><table class="table table-sm table-hover" id="conversionTable"><thead><tr><th>PX</th><th>REM</th><th>EM</th><th>%</th><th>Tailwind</th></tr></thead><tbody></tbody></table></div></div></div></div></div>';

      this.initializeTool(container);
    },

    /**
     * Initialize tool event listeners and conversion logic
     *
     * @param {HTMLElement} container - Container element
     */
    initializeTool: function (container) {
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        return key.split('.').pop();
      };

      const baseFontSize = container.querySelector('#baseFontSize');
      const parentSize = container.querySelector('#parentSize');
      const pxInput = container.querySelector('#pxInput');
      const remOutput = container.querySelector('#remOutput');
      const emOutput = container.querySelector('#emOutput');
      const percentOutput = container.querySelector('#percentOutput');
      const tailwindOutput = container.querySelector('#tailwindOutput');
      const reverseInput = container.querySelector('#reverseInput');
      const reverseUnitType = container.querySelector('#reverseUnitType');
      const reversePxOutput = container.querySelector('#reversePxOutput');
      const reverseInputLabel = container.querySelector('#reverseInputLabel');
      const reverseInputUnit = container.querySelector('#reverseInputUnit');
      const conversionTableBody = container.querySelector('#conversionTable tbody');

      /**
       * Conversion functions for CSS units
       */
      const convert = {
        /**
         * Convert pixels to rem
         *
         * @param {number} px - Pixel value
         * @param {number} base - Base font size in pixels
         * @returns {string} - REM value
         */
        pxToRem: (px, base) => (px / base).toFixed(4),

        /**
         * Convert pixels to em
         *
         * @param {number} px - Pixel value
         * @param {number} parent - Parent font size in pixels
         * @returns {string} - EM value
         */
        pxToEm: (px, parent) => (px / parent).toFixed(4),

        /**
         * Convert pixels to percentage
         *
         * @param {number} px - Pixel value
         * @param {number} base - Base font size in pixels
         * @returns {string} - Percentage value
         */
        pxToPercent: (px, base) => ((px / base) * 100).toFixed(2),

        /**
         * Convert pixels to Tailwind spacing scale
         *
         * @param {number} px - Pixel value
         * @returns {string} - Tailwind spacing value
         */
        pxToTailwind: (px) => (px / 4).toFixed(2),

        /**
         * Convert rem to pixels
         *
         * @param {number} rem - REM value
         * @param {number} base - Base font size in pixels
         * @returns {string} - Pixel value
         */
        remToPx: (rem, base) => (rem * base).toFixed(2),

        /**
         * Convert em to pixels
         *
         * @param {number} em - EM value
         * @param {number} parent - Parent font size in pixels
         * @returns {string} - Pixel value
         */
        emToPx: (em, parent) => (em * parent).toFixed(2),

        /**
         * Convert percentage to pixels
         *
         * @param {number} percent - Percentage value
         * @param {number} base - Base font size in pixels
         * @returns {string} - Pixel value
         */
        percentToPx: (percent, base) => ((percent * base) / 100).toFixed(2),

        /**
         * Convert Tailwind spacing to pixels
         *
         * @param {number} tw - Tailwind spacing value
         * @returns {string} - Pixel value
         */
        tailwindToPx: (tw) => (tw * 4).toFixed(2)
      };

      /**
       * Update conversion outputs from pixel input
       */
      function updateFromPx() {
        const px = parseFloat(pxInput.value);
        const base = parseFloat(baseFontSize.value);
        const parent = parseFloat(parentSize.value);

        if (!isNaN(px) && !isNaN(base) && base > 0) {
          remOutput.value = convert.pxToRem(px, base) + ' rem';
          emOutput.value = convert.pxToEm(px, parent || base) + ' em';
          percentOutput.value = convert.pxToPercent(px, base) + '%';
          tailwindOutput.value = convert.pxToTailwind(px);
        } else {
          remOutput.value = '';
          emOutput.value = '';
          percentOutput.value = '';
          tailwindOutput.value = '';
        }
      }

      /**
       * Update pixel output from reverse conversion input
       */
      function updateReverse() {
        const value = parseFloat(reverseInput.value);
        const base = parseFloat(baseFontSize.value);
        const parent = parseFloat(parentSize.value);
        const unit = reverseUnitType.value;

        if (!isNaN(value) && !isNaN(base) && base > 0) {
          let px;
          switch (unit) {
            case 'rem':
              px = convert.remToPx(value, base);
              break;
            case 'em':
              px = convert.emToPx(value, parent || base);
              break;
            case 'percent':
              px = convert.percentToPx(value, base);
              break;
            case 'tailwind':
              px = convert.tailwindToPx(value);
              break;
          }
          reversePxOutput.value = px + ' px';
        } else {
          reversePxOutput.value = '';
        }
      }

      /**
       * Update reverse conversion input labels based on selected unit
       */
      function updateReverseLabels() {
        const unit = reverseUnitType.value;
        const labels = {
          'rem': 'rem',
          'em': 'em',
          'percent': '%',
          'tailwind': ''
        };
        const names = {
          'rem': 'REM',
          'em': 'EM',
          'percent': t('tools.pxToRemConverter.percentage_label'),
          'tailwind': 'Tailwind'
        };

        reverseInputLabel.textContent = names[unit];
        reverseInputUnit.textContent = labels[unit];
      }

      /**
       * Generate conversion reference table
       */
      function generateTable() {
        const base = parseFloat(baseFontSize.value) || 16;
        const parent = parseFloat(parentSize.value) || 16;
        const commonValues = [4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 48, 56, 64, 72, 80, 96];

        conversionTableBody.innerHTML = '';
        commonValues.forEach(px => {
          const row = document.createElement('tr');
          row.innerHTML = '<td><strong>' + px + 'px</strong></td><td>' + convert.pxToRem(px, base) + ' rem</td><td>' + convert.pxToEm(px, parent) + ' em</td><td>' + convert.pxToPercent(px, base) + '%</td><td>' + convert.pxToTailwind(px) + '</td>';
          row.addEventListener('click', () => {
            pxInput.value = px;
            updateFromPx();
          });
          conversionTableBody.appendChild(row);
        });
      }

      /**
       * Copy text to clipboard
       *
       * @param {string} text - Text to copy
       * @param {HTMLElement} button - Button element for visual feedback
       */
      async function copyToClipboard(text, button) {
        if (text) {
          const success = await window.ClipboardUtils.copyToClipboard(text);
          
          if (success) {
            const icon = button.querySelector('i');
            if (icon) {
              icon.className = 'bi bi-check2';
              setTimeout(() => {
                icon.className = 'bi bi-clipboard';
              }, 2000);
            }
          }
        }
      }

      baseFontSize.addEventListener('input', () => {
        updateFromPx();
        updateReverse();
        generateTable();

        container.querySelectorAll('.preset-btn').forEach(btn => {
          if (btn.dataset.size === baseFontSize.value) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary');
          } else {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
          }
        });
      });

      parentSize.addEventListener('input', () => {
        updateFromPx();
        updateReverse();
        generateTable();
      });

      pxInput.addEventListener('input', updateFromPx);
      reverseInput.addEventListener('input', updateReverse);
      reverseUnitType.addEventListener('change', () => {
        updateReverseLabels();
        updateReverse();
      });

      container.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          baseFontSize.value = this.dataset.size;
          baseFontSize.dispatchEvent(new Event('input'));
        });
      });

      container.querySelectorAll('.px-preset').forEach(btn => {
        btn.addEventListener('click', function() {
          pxInput.value = this.dataset.px;
          updateFromPx();
        });
      });

      container.querySelector('#clearPx').addEventListener('click', () => {
        pxInput.value = '';
        updateFromPx();
      });

      container.querySelector('#clearReverse').addEventListener('click', () => {
        reverseInput.value = '';
        updateReverse();
      });

      container.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const targetId = this.dataset.target;
          const targetElement = container.querySelector('#' + targetId);
          copyToClipboard(targetElement.value, this);
        });
      });

      generateTable();
      updateReverseLabels();
    }
  });

})();
