/**
 * QR Code Generator Tool
 *
 * Generate customizable QR codes for URLs, text, vCard contacts, and WiFi credentials.
 * Supports custom colors, multiple sizes, and export to PNG or SVG formats.
 * Uses qrcode-generator library by David Shim (@kazuhikoarase).
 *
 * @see https://github.com/kazuhikoarase/qrcode-generator
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'qrCodeGeneratorTool'})
      : '[qrCodeGeneratorTool] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('qrCodeGeneratorTool', {
    currentQRCode: null,
    currentMode: 'url',
    currentSize: 256,
    currentFgColor: '#000000',
    currentBgColor: '#ffffff',

    /**
     * Initialize the QR Code Generator Tool
     */
    init: function () {
      console.debug('[qrCodeGeneratorTool] Tool registered');
    },

    /**
     * Open the QR Code Generator Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      const t = window.i18n ? window.i18n.t.bind(window.i18n) : (key) => key;

      try {
        container.innerHTML = '';

        // Main content
        const mainRow = document.createElement('div');
        mainRow.className = 'row g-4';
        mainRow.innerHTML = `
          <!-- Mode Selection Card -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title h5 mb-3"><i class="bi bi-toggles me-2"></i>${t('tools.qrCodeGeneratorTool.modeTitle')}</h2>
                <div class="btn-group w-100" role="group">
                  <input type="radio" class="btn-check" name="qr-mode" id="mode-url" value="url" checked>
                  <label class="btn btn-outline-primary btn-sm" for="mode-url">
                    <i class="bi bi-link-45deg me-1"></i>${t('tools.qrCodeGeneratorTool.modeURL')}
                  </label>

                  <input type="radio" class="btn-check" name="qr-mode" id="mode-text" value="text">
                  <label class="btn btn-outline-primary btn-sm" for="mode-text">
                    <i class="bi bi-file-text me-1"></i>${t('tools.qrCodeGeneratorTool.modeText')}
                  </label>

                  <input type="radio" class="btn-check" name="qr-mode" id="mode-vcard" value="vcard">
                  <label class="btn btn-outline-primary btn-sm" for="mode-vcard">
                    <i class="bi bi-person-vcard me-1"></i>${t('tools.qrCodeGeneratorTool.modeVCard')}
                  </label>

                  <input type="radio" class="btn-check" name="qr-mode" id="mode-wifi" value="wifi">
                  <label class="btn btn-outline-primary btn-sm" for="mode-wifi">
                    <i class="bi bi-wifi me-1"></i>${t('tools.qrCodeGeneratorTool.modeWiFi')}
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Input & Preview Row -->
          <div class="col-lg-7">
            <!-- Input Card -->
            <div class="card h-100">
              <div class="card-body">
                <h2 class="card-title h5 mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.qrCodeGeneratorTool.inputTitle')}</h2>

                <!-- URL Mode -->
                <div id="input-url" class="qr-input-mode">
                  <div class="mb-3">
                    <label for="url-input" class="form-label">${t('tools.qrCodeGeneratorTool.urlLabel')}</label>
                    <input type="url" class="form-control form-control-sm" id="url-input"
                           placeholder="${t('tools.qrCodeGeneratorTool.urlPlaceholder')}">
                    <small class="form-text text-muted">${t('tools.qrCodeGeneratorTool.urlHint')}</small>
                  </div>
                </div>

                <!-- Text Mode -->
                <div id="input-text" class="qr-input-mode d-none">
                  <div class="mb-3">
                    <label for="text-input" class="form-label">${t('tools.qrCodeGeneratorTool.textLabel')}</label>
                    <textarea class="form-control form-control-sm" id="text-input" rows="4"
                              placeholder="${t('tools.qrCodeGeneratorTool.textPlaceholder')}"></textarea>
                    <small class="form-text text-muted">${t('tools.qrCodeGeneratorTool.textHint')}</small>
                  </div>
                </div>

                <!-- vCard Mode -->
                <div id="input-vcard" class="qr-input-mode d-none">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="vcard-firstname" class="form-label">${t('tools.qrCodeGeneratorTool.vCardFirstName')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-firstname">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="vcard-lastname" class="form-label">${t('tools.qrCodeGeneratorTool.vCardLastName')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-lastname">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="vcard-organization" class="form-label">${t('tools.qrCodeGeneratorTool.vCardOrganization')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-organization">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="vcard-title" class="form-label">${t('tools.qrCodeGeneratorTool.vCardTitle')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-title">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="vcard-phone" class="form-label">${t('tools.qrCodeGeneratorTool.vCardPhone')}</label>
                      <input type="tel" class="form-control form-control-sm" id="vcard-phone">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="vcard-email" class="form-label">${t('tools.qrCodeGeneratorTool.vCardEmail')}</label>
                      <input type="email" class="form-control form-control-sm" id="vcard-email">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="vcard-website" class="form-label">${t('tools.qrCodeGeneratorTool.vCardWebsite')}</label>
                    <input type="url" class="form-control form-control-sm" id="vcard-website">
                  </div>
                  <div class="row">
                    <div class="col-md-8 mb-3">
                      <label for="vcard-address" class="form-label">${t('tools.qrCodeGeneratorTool.vCardAddress')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-address">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="vcard-zip" class="form-label">${t('tools.qrCodeGeneratorTool.vCardZip')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-zip">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="vcard-city" class="form-label">${t('tools.qrCodeGeneratorTool.vCardCity')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-city">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="vcard-country" class="form-label">${t('tools.qrCodeGeneratorTool.vCardCountry')}</label>
                      <input type="text" class="form-control form-control-sm" id="vcard-country">
                    </div>
                  </div>
                </div>

                <!-- WiFi Mode -->
                <div id="input-wifi" class="qr-input-mode d-none">
                  <div class="mb-3">
                    <label for="wifi-ssid" class="form-label">${t('tools.qrCodeGeneratorTool.wifiSSID')} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="wifi-ssid" required>
                  </div>
                  <div class="mb-3">
                    <label for="wifi-password" class="form-label">${t('tools.qrCodeGeneratorTool.wifiPassword')}</label>
                    <input type="text" class="form-control form-control-sm" id="wifi-password">
                    <small class="form-text text-muted">${t('tools.qrCodeGeneratorTool.wifiPasswordHint')}</small>
                  </div>
                  <div class="mb-3">
                    <label for="wifi-encryption" class="form-label">${t('tools.qrCodeGeneratorTool.wifiEncryption')}</label>
                    <select class="form-select form-select-sm" id="wifi-encryption">
                      <option value="WPA">${t('tools.qrCodeGeneratorTool.encryptionWPA')}</option>
                      <option value="WEP">${t('tools.qrCodeGeneratorTool.encryptionWEP')}</option>
                      <option value="nopass">${t('tools.qrCodeGeneratorTool.encryptionNone')}</option>
                    </select>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="wifi-hidden">
                    <label class="form-check-label" for="wifi-hidden">
                      ${t('tools.qrCodeGeneratorTool.wifiHidden')}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <!-- Customization Card -->
            <div class="card mb-3">
              <div class="card-body">
                <h2 class="card-title h5 mb-3"><i class="bi bi-palette me-2"></i>${t('tools.qrCodeGeneratorTool.customizationTitle')}</h2>
                <div class="row mb-3">
                  <div class="col-6">
                    <label for="fg-color" class="form-label">${t('tools.qrCodeGeneratorTool.foregroundColor')}</label>
                    <input type="color" class="form-control form-control-color form-control-sm w-100"
                           id="fg-color" value="#000000">
                  </div>
                  <div class="col-6">
                    <label for="bg-color" class="form-label">${t('tools.qrCodeGeneratorTool.backgroundColor')}</label>
                    <input type="color" class="form-control form-control-color form-control-sm w-100"
                           id="bg-color" value="#ffffff">
                  </div>
                </div>
                <div class="mb-0">
                  <label for="qr-size" class="form-label">${t('tools.qrCodeGeneratorTool.qrSize')}</label>
                  <select class="form-select form-select-sm" id="qr-size">
                    <option value="128">${t('tools.qrCodeGeneratorTool.sizeSmall')}</option>
                    <option value="256" selected>${t('tools.qrCodeGeneratorTool.sizeMedium')}</option>
                    <option value="512">${t('tools.qrCodeGeneratorTool.sizeLarge')}</option>
                    <option value="1024">${t('tools.qrCodeGeneratorTool.sizeXLarge')}</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Preview Card -->
            <div class="card">
              <div class="card-body">
                <h2 class="card-title h5 mb-3"><i class="bi bi-eye me-2"></i>${t('tools.qrCodeGeneratorTool.outputTitle')}</h2>
                <div id="qr-preview" class="mb-3 d-flex justify-content-center align-items-center qr-preview-area">
                  <p class="text-muted mb-0">${t('tools.qrCodeGeneratorTool.noPreview')}</p>
                </div>
                <div class="d-grid gap-2">
                  <button type="button" class="btn btn-primary btn-sm" id="generate-btn">
                    <i class="bi bi-qr-code me-1"></i>${t('tools.qrCodeGeneratorTool.generate')}
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm" id="download-png-btn" disabled>
                      <i class="bi bi-download me-1"></i>${t('tools.qrCodeGeneratorTool.downloadPNG')}
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="download-svg-btn" disabled>
                      <i class="bi bi-filetype-svg me-1"></i>${t('tools.qrCodeGeneratorTool.downloadSVG')}
                    </button>
                  </div>
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-btn">
                    ${t('tools.qrCodeGeneratorTool.clear')}
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;

        container.appendChild(mainRow);
        this.attachEventListeners(t);

      } catch (error) {
        console.error('Error initializing QR Code Generator:', error);
        container.innerHTML = `<div class="alert alert-danger">${t('tools.qrCodeGeneratorTool.errorLoading')}</div>`;
      }
    },

    /**
     * Attach event listeners to QR generator controls
     *
     * @param {Function} t - Translation function
     */
    attachEventListeners: function (t) {
      const self = this;

      // Mode switching
      document.querySelectorAll('input[name="qr-mode"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
          self.switchMode(e.target.value);
        });
      });

      // Generate button
      const generateBtn = document.getElementById('generate-btn');
      if (generateBtn) {
        generateBtn.addEventListener('click', () => {
          self.generateQRCode(t);
        });
      }

      // Download buttons
      const downloadPngBtn = document.getElementById('download-png-btn');
      if (downloadPngBtn) {
        downloadPngBtn.addEventListener('click', () => {
          self.downloadQRCode('png');
        });
      }

      const downloadSvgBtn = document.getElementById('download-svg-btn');
      if (downloadSvgBtn) {
        downloadSvgBtn.addEventListener('click', () => {
          self.downloadQRCode('svg');
        });
      }

      // Clear button
      const clearBtn = document.getElementById('clear-btn');
      if (clearBtn) {
        clearBtn.addEventListener('click', () => {
          self.clearAll(t);
        });
      }

      // Color inputs
      const fgColor = document.getElementById('fg-color');
      if (fgColor) {
        fgColor.addEventListener('change', (e) => {
          self.currentFgColor = e.target.value;
        });
      }

      const bgColor = document.getElementById('bg-color');
      if (bgColor) {
        bgColor.addEventListener('change', (e) => {
          self.currentBgColor = e.target.value;
        });
      }

      // Size select
      const qrSize = document.getElementById('qr-size');
      if (qrSize) {
        qrSize.addEventListener('change', (e) => {
          self.currentSize = parseInt(e.target.value);
        });
      }
    },

    /**
     * Switch between QR code input modes (URL, text, vCard, WiFi)
     *
     * @param {string} mode - Mode identifier (url, text, vcard, wifi)
     */
    switchMode: function (mode) {
      this.currentMode = mode;

      // Hide all input modes
      document.querySelectorAll('.qr-input-mode').forEach(el => {
        el.classList.add('d-none');
      });

      // Show selected mode
      const selectedMode = document.getElementById(`input-${mode}`);
      if (selectedMode) {
        selectedMode.classList.remove('d-none');
      }
    },

    /**
     * Get QR code content based on selected mode
     *
     * @param {Function} t - Translation function
     * @returns {string|null} - Content to encode or null if invalid
     */
    getContent: function (t) {
      switch (this.currentMode) {
        case 'url':
          return this.getURLContent(t);
        case 'text':
          return this.getTextContent(t);
        case 'vcard':
          return this.getVCardContent(t);
        case 'wifi':
          return this.getWiFiContent(t);
        default:
          return null;
      }
    },

    /**
     * Get URL content from input
     *
     * @param {Function} t - Translation function
     * @returns {string|null} - Valid URL or null
     */
    getURLContent: function (t) {
      const url = document.getElementById('url-input')?.value.trim();
      if (!url) {
        alert(t('tools.qrCodeGeneratorTool.enterContent'));
        return null;
      }
      if (!url.match(/^https?:\/\/.+/)) {
        alert(t('tools.qrCodeGeneratorTool.invalidURL'));
        return null;
      }
      return url;
    },

    /**
     * Get plain text content from input
     *
     * @param {Function} t - Translation function
     * @returns {string|null} - Text content or null
     */
    getTextContent: function (t) {
      const text = document.getElementById('text-input')?.value.trim();
      if (!text) {
        alert(t('tools.qrCodeGeneratorTool.enterContent'));
        return null;
      }
      return text;
    },

    /**
     * Get vCard 3.0 formatted content from inputs
     *
     * @param {Function} t - Translation function
     * @returns {string|null} - vCard formatted string or null
     */
    getVCardContent: function (t) {
      const firstName = document.getElementById('vcard-firstname')?.value.trim() || '';
      const lastName = document.getElementById('vcard-lastname')?.value.trim() || '';
      const organization = document.getElementById('vcard-organization')?.value.trim() || '';
      const title = document.getElementById('vcard-title')?.value.trim() || '';
      const phone = document.getElementById('vcard-phone')?.value.trim() || '';
      const email = document.getElementById('vcard-email')?.value.trim() || '';
      const website = document.getElementById('vcard-website')?.value.trim() || '';
      const address = document.getElementById('vcard-address')?.value.trim() || '';
      const city = document.getElementById('vcard-city')?.value.trim() || '';
      const zip = document.getElementById('vcard-zip')?.value.trim() || '';
      const country = document.getElementById('vcard-country')?.value.trim() || '';

      if (!firstName && !lastName) {
        alert(t('tools.qrCodeGeneratorTool.vCardAtLeastName'));
        return null;
      }

      // Build vCard 3.0 format
      let vcard = 'BEGIN:VCARD\n';
      vcard += 'VERSION:3.0\n';
      vcard += `N:${lastName};${firstName};;;\n`;
      vcard += `FN:${firstName} ${lastName}\n`;

      if (organization) vcard += `ORG:${organization}\n`;
      if (title) vcard += `TITLE:${title}\n`;
      if (phone) vcard += `TEL:${phone}\n`;
      if (email) vcard += `EMAIL:${email}\n`;
      if (website) vcard += `URL:${website}\n`;

      if (address || city || zip || country) {
        vcard += `ADR:;;${address};${city};;${zip};${country}\n`;
      }

      vcard += 'END:VCARD';

      return vcard;
    },

    /**
     * Get WiFi configuration content in QR code format
     *
     * @param {Function} t - Translation function
     * @returns {string|null} - WiFi QR string or null
     */
    getWiFiContent: function (t) {
      const ssid = document.getElementById('wifi-ssid')?.value.trim();
      const password = document.getElementById('wifi-password')?.value.trim();
      const encryption = document.getElementById('wifi-encryption')?.value;
      const hidden = document.getElementById('wifi-hidden')?.checked;

      if (!ssid) {
        alert(t('tools.qrCodeGeneratorTool.wifiSSIDRequired'));
        return null;
      }

      // WiFi QR Code format: WIFI:T:WPA;S:mynetwork;P:mypass;H:false;;
      let wifi = `WIFI:T:${encryption};S:${this.escapeWiFi(ssid)};`;
      if (password && encryption !== 'nopass') {
        wifi += `P:${this.escapeWiFi(password)};`;
      }
      wifi += `H:${hidden ? 'true' : 'false'};;`;

      return wifi;
    },

    /**
     * Escape special characters for WiFi QR code format
     *
     * @param {string} str - String to escape
     * @returns {string} - Escaped string
     */
    escapeWiFi: function (str) {
      // Escape special characters for WiFi QR format
      return str.replace(/([\\;,":])/g, '\\$1');
    },

    /**
     * Generate QR code from current inputs
     *
     * Creates canvas rendering with customizable colors and size.
     *
     * @param {Function} t - Translation function
     */
    generateQRCode: function (t) {
      const content = this.getContent(t);
      if (!content) return;

      const preview = document.getElementById('qr-preview');
      if (!preview) return;

      // Clear existing QR code
      preview.innerHTML = '';

      try {
        // Create QR code using qrcode-generator library
        // Error correction level: 'L', 'M', 'Q', 'H' (H = highest)
        const typeNumber = 0; // 0 = auto-detect optimal size
        const errorCorrectionLevel = 'H';
        const qr = qrcode(typeNumber, errorCorrectionLevel);
        qr.addData(content);
        qr.make();

        // Create canvas element
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const moduleCount = qr.getModuleCount();
        const cellSize = this.currentSize / moduleCount;

        canvas.width = this.currentSize;
        canvas.height = this.currentSize;

        // Fill background
        ctx.fillStyle = this.currentBgColor;
        ctx.fillRect(0, 0, this.currentSize, this.currentSize);

        // Draw QR code modules
        ctx.fillStyle = this.currentFgColor;
        for (let row = 0; row < moduleCount; row++) {
          for (let col = 0; col < moduleCount; col++) {
            if (qr.isDark(row, col)) {
              ctx.fillRect(
                col * cellSize,
                row * cellSize,
                cellSize,
                cellSize
              );
            }
          }
        }

        // Store QR data for downloads
        this.currentQRCode = { qr, canvas, moduleCount };

        // Append canvas to preview
        preview.appendChild(canvas);

        // Enable download buttons
        const downloadPngBtn = document.getElementById('download-png-btn');
        const downloadSvgBtn = document.getElementById('download-svg-btn');
        if (downloadPngBtn) downloadPngBtn.disabled = false;
        if (downloadSvgBtn) downloadSvgBtn.disabled = false;

        console.log('QR Code generated successfully');
      } catch (error) {
        console.error('Error generating QR code:', error);
        alert(t('tools.qrCodeGeneratorTool.errorGeneration'));
      }
    },

    /**
     * Download generated QR code as PNG or SVG
     *
     * @param {string} format - File format (png or svg)
     */
    downloadQRCode: function (format) {
      if (!this.currentQRCode) {
        alert('No QR code to download');
        return;
      }

      try {
        if (format === 'png') {
          const { canvas } = this.currentQRCode;

          canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `qr-code-${Date.now()}.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
          });
        } else if (format === 'svg') {
          const { qr, moduleCount } = this.currentQRCode;
          const cellSize = this.currentSize / moduleCount;

          // Generate true SVG (not embedded PNG)
          let svgContent = `<svg xmlns="http://www.w3.org/2000/svg" width="${this.currentSize}" height="${this.currentSize}" viewBox="0 0 ${this.currentSize} ${this.currentSize}">`;
          svgContent += `<rect width="${this.currentSize}" height="${this.currentSize}" fill="${this.currentBgColor}"/>`;

          for (let row = 0; row < moduleCount; row++) {
            for (let col = 0; col < moduleCount; col++) {
              if (qr.isDark(row, col)) {
                const x = col * cellSize;
                const y = row * cellSize;
                svgContent += `<rect x="${x}" y="${y}" width="${cellSize}" height="${cellSize}" fill="${this.currentFgColor}"/>`;
              }
            }
          }

          svgContent += '</svg>';

          const blob = new Blob([svgContent], { type: 'image/svg+xml' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = `qr-code-${Date.now()}.svg`;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);
        }
      } catch (error) {
        console.error('Error downloading QR code:', error);
        alert('Error downloading QR code');
      }
    },

    /**
     * Clear all inputs and reset QR code generator
     *
     * @param {Function} t - Translation function
     */
    clearAll: function (t) {
      // Clear all inputs
      const urlInput = document.getElementById('url-input');
      const textInput = document.getElementById('text-input');
      if (urlInput) urlInput.value = '';
      if (textInput) textInput.value = '';

      // Clear vCard inputs
      document.querySelectorAll('#input-vcard input').forEach(input => {
        input.value = '';
      });

      // Clear WiFi inputs
      const wifiSsid = document.getElementById('wifi-ssid');
      const wifiPassword = document.getElementById('wifi-password');
      const wifiHidden = document.getElementById('wifi-hidden');
      if (wifiSsid) wifiSsid.value = '';
      if (wifiPassword) wifiPassword.value = '';
      if (wifiHidden) wifiHidden.checked = false;

      // Clear preview
      const preview = document.getElementById('qr-preview');
      if (preview) {
        preview.innerHTML = `<p class="text-muted mb-0">${t('tools.qrCodeGeneratorTool.noPreview')}</p>`;
      }

      // Disable download buttons
      const downloadPngBtn = document.getElementById('download-png-btn');
      const downloadSvgBtn = document.getElementById('download-svg-btn');
      if (downloadPngBtn) downloadPngBtn.disabled = true;
      if (downloadSvgBtn) downloadSvgBtn.disabled = true;

      this.currentQRCode = null;
    }
  });
})();
