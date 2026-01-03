/**
 * Aspect Ratio Calculator Tool
 * 
 * Calculate dimensions, maintain aspect ratios, and generate CSS for responsive media.
 * Supports common presets, multiple ratio formats, and CSS code generation.
 */
(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'aspectRatioCalculator'}) : '[aspectRatioCalculator] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('aspectRatioCalculator', {
    /**
     * Initialize the Aspect Ratio Calculator Tool
     */
    init: function () {
    },

    /**
     * Open the Aspect Ratio Calculator Tool in the provided container
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
        <div class="row g-4">
          <!-- Aspect Ratio Presets -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h2 class="h5 card-title mb-3">
                  <i class="bi bi-collection me-2"></i>${t('tools.aspectRatioCalculator.presets_title')}
                </h2>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-8 g-2" id="ratioPresets">
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="16:9">
                      <div>16:9</div>
                      <small class="d-block text-body-secondary">HD Video</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="4:3">
                      <div>4:3</div>
                      <small class="d-block text-body-secondary">Classic TV</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="21:9">
                      <div>21:9</div>
                      <small class="d-block text-body-secondary">Ultrawide</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="1:1">
                      <div>1:1</div>
                      <small class="d-block text-body-secondary">Square</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="9:16">
                      <div>9:16</div>
                      <small class="d-block text-body-secondary">Vertical</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="3:2">
                      <div>3:2</div>
                      <small class="d-block text-body-secondary">Photo</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="2:1">
                      <div>2:1</div>
                      <small class="d-block text-body-secondary">Wide Banner</small>
                    </button>
                  </div>
                  <div class="col">
                    <button class="btn btn-sm btn-outline-primary ratio-preset w-100" data-ratio="5:4">
                      <div>5:4</div>
                      <small class="d-block text-body-secondary">Large Format</small>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Calculator -->
          <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="card-body">
                <h2 class="h5 card-title mb-3">
                  <i class="bi bi-calculator me-2"></i>${t('tools.aspectRatioCalculator.calculator_title')}
                </h2>
                
                <!-- Aspect Ratio Input -->
                <div class="mb-3">
                  <label class="form-label">${t('tools.aspectRatioCalculator.aspect_ratio_label')}</label>
                  <div class="row g-2">
                    <div class="col">
                      <input type="number" class="form-control form-control-sm" id="ratioWidth" placeholder="16" min="0" step="0.01">
                      <small class="text-muted">${t('tools.aspectRatioCalculator.width_label')}</small>
                    </div>
                    <div class="col-auto d-flex align-items-center pt-3">
                      <strong>:</strong>
                    </div>
                    <div class="col">
                      <input type="number" class="form-control form-control-sm" id="ratioHeight" placeholder="9" min="0" step="0.01">
                      <small class="text-muted">${t('tools.aspectRatioCalculator.height_label')}</small>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Dimension Calculator -->
                <div class="mb-3">
                  <label class="form-label">${t('tools.aspectRatioCalculator.calculate_dimensions_label')}</label>
                  <div class="row g-2 mb-2">
                    <div class="col">
                      <label class="form-label small">${t('tools.aspectRatioCalculator.known_width_label')}</label>
                      <div class="input-group input-group-sm">
                        <input type="number" class="form-control" id="knownWidth" placeholder="1920" min="0" step="1">
                        <span class="input-group-text">px</span>
                      </div>
                    </div>
                    <div class="col">
                      <label class="form-label small">${t('tools.aspectRatioCalculator.calculated_height_label')}</label>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control bg-body-secondary" id="calculatedHeight" readonly>
                        <span class="input-group-text">px</span>
                        <button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" type="button" id="copyHeight">
                          <i class="bi bi-clipboard"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="row g-2">
                    <div class="col">
                      <label class="form-label small">${t('tools.aspectRatioCalculator.known_height_label')}</label>
                      <div class="input-group input-group-sm">
                        <input type="number" class="form-control" id="knownHeight" placeholder="1080" min="0" step="1">
                        <span class="input-group-text">px</span>
                      </div>
                    </div>
                    <div class="col">
                      <label class="form-label small">${t('tools.aspectRatioCalculator.calculated_width_label')}</label>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control bg-body-secondary" id="calculatedWidth" readonly>
                        <span class="input-group-text">px</span>
                        <button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" type="button" id="copyWidth">
                          <i class="bi bi-clipboard"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Ratio Formats -->
                <div class="mb-3">
                  <label class="form-label">${t('tools.aspectRatioCalculator.ratio_formats_label')}</label>
                  <div class="row g-2">
                    <div class="col-12">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text">${t('tools.aspectRatioCalculator.ratio_format')}</span>
                        <input type="text" class="form-control bg-body-secondary font-monospace" id="ratioFormat" readonly>
                        <button class="btn btn-outline-secondary btn-sm copy-btn d-inline-flex align-items-center" data-target="ratioFormat">
                          <i class="bi bi-clipboard"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text">${t('tools.aspectRatioCalculator.decimal_format')}</span>
                        <input type="text" class="form-control bg-body-secondary font-monospace" id="decimalFormat" readonly>
                        <button class="btn btn-outline-secondary btn-sm copy-btn d-inline-flex align-items-center" data-target="decimalFormat">
                          <i class="bi bi-clipboard"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text">${t('tools.aspectRatioCalculator.percentage_format')}</span>
                        <input type="text" class="form-control bg-body-secondary font-monospace" id="percentageFormat" readonly>
                        <button class="btn btn-outline-secondary btn-sm copy-btn d-inline-flex align-items-center" data-target="percentageFormat">
                          <i class="bi bi-clipboard"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <button class="btn btn-outline-secondary btn-sm w-100 d-inline-flex align-items-center" id="clearAll">
                  <i class="bi bi-x-circle me-1"></i>${t('common.clear')}
                </button>
              </div>
            </div>
          </div>

          <!-- CSS Code Generator -->
          <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="card-body">
                <h2 class="h5 card-title mb-3">
                  <i class="bi bi-code-square me-2"></i>${t('tools.aspectRatioCalculator.css_generator_title')}
                </h2>

                <!-- CSS Method Selection -->
                <div class="mb-3">
                  <label class="form-label">${t('tools.aspectRatioCalculator.css_method_label')}</label>
                  <select class="form-select form-select-sm" id="cssMethod">
                    <option value="modern">${t('tools.aspectRatioCalculator.css_modern')}</option>
                    <option value="padding">${t('tools.aspectRatioCalculator.css_padding_trick')}</option>
                    <option value="both">${t('tools.aspectRatioCalculator.css_both')}</option>
                  </select>
                </div>

                <!-- Generated CSS -->
                <div class="mb-3">
                  <label class="d-flex justify-content-between align-items-center mb-1">
                    <span>CSS ${t('common.code')}</span>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyCss">
                      <i class="bi bi-clipboard me-1"></i>${t('common.copy')}
                    </button>
                  </label>
                  <textarea class="form-control form-control-sm font-monospace bg-body-secondary" id="cssOutput" rows="12" readonly></textarea>
                </div>

                <!-- Info Alert -->
                <div class="alert alert-info small mb-0">
                  <h3 class="h6 alert-heading">
                    <i class="bi bi-info-circle me-2"></i>${t('tools.aspectRatioCalculator.css_info_title')}
                  </h3>
                  <p class="mb-2"><strong>${t('tools.aspectRatioCalculator.css_modern')}:</strong> ${t('tools.aspectRatioCalculator.css_modern_info')}</p>
                  <p class="mb-0"><strong>${t('tools.aspectRatioCalculator.css_padding_trick')}:</strong> ${t('tools.aspectRatioCalculator.css_padding_info')}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Common Resolutions Table -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h2 class="h5 card-title mb-3">
                  <i class="bi bi-table me-2"></i>${t('tools.aspectRatioCalculator.common_resolutions_title')}
                </h2>
                <div class="table-responsive">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>${t('tools.aspectRatioCalculator.resolution')}</th>
                        <th>${t('tools.aspectRatioCalculator.dimensions')}</th>
                        <th>${t('tools.aspectRatioCalculator.ratio')}</th>
                        <th>${t('tools.aspectRatioCalculator.common_use')}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="table-row-clickable" data-width="1920" data-height="1080">
                        <td><strong>Full HD</strong></td>
                        <td>1920 × 1080</td>
                        <td>16:9</td>
                        <td>YouTube, Standard HD</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="1280" data-height="720">
                        <td><strong>HD</strong></td>
                        <td>1280 × 720</td>
                        <td>16:9</td>
                        <td>720p Video</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="3840" data-height="2160">
                        <td><strong>4K UHD</strong></td>
                        <td>3840 × 2160</td>
                        <td>16:9</td>
                        <td>4K Video, Modern Displays</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="2560" data-height="1440">
                        <td><strong>QHD</strong></td>
                        <td>2560 × 1440</td>
                        <td>16:9</td>
                        <td>1440p Gaming</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="1080" data-height="1080">
                        <td><strong>Square</strong></td>
                        <td>1080 × 1080</td>
                        <td>1:1</td>
                        <td>Instagram Post</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="1080" data-height="1920">
                        <td><strong>Vertical HD</strong></td>
                        <td>1080 × 1920</td>
                        <td>9:16</td>
                        <td>Instagram Stories, TikTok</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="2560" data-height="1080">
                        <td><strong>Ultrawide</strong></td>
                        <td>2560 × 1080</td>
                        <td>21:9</td>
                        <td>Ultrawide Monitor</td>
                      </tr>
                      <tr class="table-row-clickable" data-width="1024" data-height="768">
                        <td><strong>XGA</strong></td>
                        <td>1024 × 768</td>
                        <td>4:3</td>
                        <td>Classic Display</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <small class="text-muted">
                  <i class="bi bi-info-circle me-1"></i>${t('tools.aspectRatioCalculator.click_row_hint')}
                </small>
              </div>
            </div>
          </div>
        </div>
      `;

      this.initializeTool(container);
    },

    /**
     * Initialize tool event listeners and calculation logic
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

      // Get all input elements
      const ratioWidth = container.querySelector('#ratioWidth');
      const ratioHeight = container.querySelector('#ratioHeight');
      const knownWidth = container.querySelector('#knownWidth');
      const knownHeight = container.querySelector('#knownHeight');
      const calculatedWidth = container.querySelector('#calculatedWidth');
      const calculatedHeight = container.querySelector('#calculatedHeight');
      const ratioFormat = container.querySelector('#ratioFormat');
      const decimalFormat = container.querySelector('#decimalFormat');
      const percentageFormat = container.querySelector('#percentageFormat');
      const cssMethod = container.querySelector('#cssMethod');
      const cssOutput = container.querySelector('#cssOutput');

      /**
       * Calculate GCD (Greatest Common Divisor) using Euclidean algorithm
       *
       * @param {number} a - First number
       * @param {number} b - Second number
       * @returns {number} - GCD
       */
      function gcd(a, b) {
        return b === 0 ? a : gcd(b, a % b);
      }

      /**
       * Simplify aspect ratio to lowest terms
       *
       * @param {number} width - Width value
       * @param {number} height - Height value
       * @returns {object} - Simplified ratio {width, height}
       */
      function simplifyRatio(width, height) {
        const divisor = gcd(Math.round(width * 1000), Math.round(height * 1000));
        return {
          width: Math.round(width * 1000) / divisor,
          height: Math.round(height * 1000) / divisor
        };
      }

      /**
       * Calculate all ratio formats and dimensions
       */
      function calculate() {
        const rw = parseFloat(ratioWidth.value);
        const rh = parseFloat(ratioHeight.value);
        const kw = parseFloat(knownWidth.value);
        const kh = parseFloat(knownHeight.value);

        // Validate ratio inputs
        if (!rw || !rh || rw <= 0 || rh <= 0) {
          ratioFormat.value = '';
          decimalFormat.value = '';
          percentageFormat.value = '';
          calculatedWidth.value = '';
          calculatedHeight.value = '';
          generateCSS();
          return;
        }

        // Calculate ratio formats
        const simplified = simplifyRatio(rw, rh);
        const decimal = (rw / rh).toFixed(4);
        const percentage = ((rh / rw) * 100).toFixed(4);

        ratioFormat.value = `${simplified.width}:${simplified.height}`;
        decimalFormat.value = decimal;
        percentageFormat.value = `${percentage}%`;

        // Calculate dimensions
        if (kw && kw > 0) {
          const height = Math.round((kw / rw) * rh);
          calculatedHeight.value = height;
        } else {
          calculatedHeight.value = '';
        }

        if (kh && kh > 0) {
          const width = Math.round((kh / rh) * rw);
          calculatedWidth.value = width;
        } else {
          calculatedWidth.value = '';
        }

        // Update CSS
        generateCSS();
      }

      /**
       * Generate CSS code based on selected method
       */
      function generateCSS() {
        const rw = parseFloat(ratioWidth.value);
        const rh = parseFloat(ratioHeight.value);
        const method = cssMethod.value;

        if (!rw || !rh || rw <= 0 || rh <= 0) {
          cssOutput.value = t('tools.aspectRatioCalculator.css_enter_ratio');
          return;
        }

        const percentage = ((rh / rw) * 100).toFixed(4);
        let css = '';

        if (method === 'modern' || method === 'both') {
          css += `/* Modern CSS (aspect-ratio property) */\n`;
          css += `.container {\n`;
          css += `  aspect-ratio: ${rw} / ${rh};\n`;
          css += `  width: 100%;\n`;
          css += `}\n`;
        }

        if (method === 'both') {
          css += `\n`;
        }

        if (method === 'padding' || method === 'both') {
          css += `/* Legacy approach (padding-bottom trick) */\n`;
          css += `.container {\n`;
          css += `  position: relative;\n`;
          css += `  width: 100%;\n`;
          css += `  padding-bottom: ${percentage}%; /* ${rw}:${rh} ratio */\n`;
          css += `}\n\n`;
          css += `.container > * {\n`;
          css += `  position: absolute;\n`;
          css += `  top: 0;\n`;
          css += `  left: 0;\n`;
          css += `  width: 100%;\n`;
          css += `  height: 100%;\n`;
          css += `}`;
        }

        cssOutput.value = css;
      }

      // Event listeners for inputs
      ratioWidth.addEventListener('input', calculate);
      ratioHeight.addEventListener('input', calculate);
      knownWidth.addEventListener('input', calculate);
      knownHeight.addEventListener('input', calculate);
      cssMethod.addEventListener('change', generateCSS);

      // Preset buttons
      const presetButtons = container.querySelectorAll('.ratio-preset');
      presetButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          const ratio = btn.dataset.ratio.split(':');
          ratioWidth.value = ratio[0];
          ratioHeight.value = ratio[1];
          
          // Visual feedback
          presetButtons.forEach(b => {
            b.classList.remove('active');
            const small = b.querySelector('small');
            if (small) small.classList.replace('text-white', 'text-body-secondary');
          });
          btn.classList.add('active');
          const activeSmall = btn.querySelector('small');
          if (activeSmall) activeSmall.classList.replace('text-body-secondary', 'text-white');
          
          calculate();
        });
      });

      // Table row click handlers
      const tableRows = container.querySelectorAll('.table-row-clickable');
      tableRows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', () => {
          const width = row.dataset.width;
          const height = row.dataset.height;
          
          ratioWidth.value = width;
          ratioHeight.value = height;
          knownWidth.value = width;
          
          calculate();
          
          // Scroll to calculator
          container.querySelector('.card').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
      });

      // Copy buttons
      const copyButtons = container.querySelectorAll('.copy-btn');
      copyButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
          const targetId = btn.dataset.target;
          const targetInput = container.querySelector(`#${targetId}`);
          const text = targetInput.value;
          
          if (!text) return;
          
          const success = await window.ClipboardUtils.copyToClipboard(text);
          if (success) {
            const icon = btn.querySelector('i');
            if (icon) {
              const originalClass = icon.className;
              icon.className = 'bi bi-check';
              setTimeout(() => icon.className = originalClass, 1500);
            }
          }
        });
      });

      // Individual copy buttons for dimensions
      container.querySelector('#copyWidth').addEventListener('click', async () => {
        const text = calculatedWidth.value;
        if (!text) return;
        
        const success = await window.ClipboardUtils.copyToClipboard(text);
        if (success) {
          const icon = container.querySelector('#copyWidth i');
          icon.className = 'bi bi-check';
          setTimeout(() => icon.className = 'bi bi-clipboard', 1500);
        }
      });

      container.querySelector('#copyHeight').addEventListener('click', async () => {
        const text = calculatedHeight.value;
        if (!text) return;
        
        const success = await window.ClipboardUtils.copyToClipboard(text);
        if (success) {
          const icon = container.querySelector('#copyHeight i');
          icon.className = 'bi bi-check';
          setTimeout(() => icon.className = 'bi bi-clipboard', 1500);
        }
      });

      // Copy CSS button
      container.querySelector('#copyCss').addEventListener('click', async () => {
        const text = cssOutput.value;
        if (!text || text === t('tools.aspectRatioCalculator.css_enter_ratio')) return;
        
        const success = await window.ClipboardUtils.copyToClipboard(text);
        if (success) {
          const btn = container.querySelector('#copyCss');
          if (btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check me-1"></i>' + t('common.copied');
            setTimeout(() => btn.innerHTML = originalText, 1500);
          }
        }
      });

      // Clear all button
      container.querySelector('#clearAll').addEventListener('click', () => {
        ratioWidth.value = '';
        ratioHeight.value = '';
        knownWidth.value = '';
        knownHeight.value = '';
        calculatedWidth.value = '';
        calculatedHeight.value = '';
        ratioFormat.value = '';
        decimalFormat.value = '';
        percentageFormat.value = '';
        cssOutput.value = t('tools.aspectRatioCalculator.css_enter_ratio');
        
        // Remove active state from presets
        presetButtons.forEach(b => b.classList.remove('active'));
      });

      // Initial CSS message
      cssOutput.value = t('tools.aspectRatioCalculator.css_enter_ratio');
    }
  });
})();
