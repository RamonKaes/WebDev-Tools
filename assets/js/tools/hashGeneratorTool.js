/**
 * Hash Generator Tool
 *
 * Generate cryptographic hashes using Web Crypto API.
 * Supports SHA-1, SHA-256, SHA-384, SHA-512, HMAC, and SRI hash generation.
 * Security: Uses native browser crypto for secure hash computation.
 */

(function () {
  'use strict';

  /**
   * File size limit to prevent browser freeze
   */
  const MAX_FILE_SIZE = 100 * 1024 * 1024;

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'hashGeneratorTool'})
      : '[hashGeneratorTool] Tools registry not available.';
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
   * Modern Crypto Utilities using Web Crypto API
   */
  const CryptoUtils = {
    /**
     * Check if Web Crypto API is available
     *
     * @returns {boolean} - True if Web Crypto API is supported
     */
    isSupported() {
      return window.crypto && window.crypto.subtle;
    },

    /**
     * Convert ArrayBuffer to hex string
     *
     * @param {ArrayBuffer} buffer - Input buffer
     * @returns {string} - Hexadecimal string
     */
    bufferToHex(buffer) {
      return Array.from(new Uint8Array(buffer))
        .map(b => b.toString(16).padStart(2, '0'))
        .join('');
    },

    /**
     * Convert ArrayBuffer to Base64
     *
     * @param {ArrayBuffer} buffer - Input buffer
     * @returns {string} - Base64 string
     */
    bufferToBase64(buffer) {
      const bytes = new Uint8Array(buffer);
      let binary = '';
      for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
      }
      return btoa(binary);
    },

    /**
     * Convert string to ArrayBuffer
     *
     * @param {string} str - Input string
     * @returns {ArrayBuffer} - UTF-8 encoded buffer
     */
    stringToBuffer(str) {
      return new TextEncoder().encode(str);
    },

    /**
     * Hash text with specified algorithm
     *
     * Security: Uses Web Crypto API for cryptographically secure hashing.
     *
     * @param {string} text - Text to hash
     * @param {string} algorithm - Algorithm name (SHA-1, SHA-256, SHA-384, SHA-512)
     * @returns {Promise<string>} - Hex hash
     * @throws {Error} - If Web Crypto API is not supported
     */
    async hashText(text, algorithm = 'SHA-256') {
      if (!this.isSupported()) {
        throw new Error('Web Crypto API not supported in this browser');
      }

      const buffer = this.stringToBuffer(text);
      const hashBuffer = await window.crypto.subtle.digest(algorithm, buffer);
      return this.bufferToHex(hashBuffer);
    },

    /**
     * Hash file with specified algorithm
     *
     * @param {File} file - File to hash
     * @param {string} algorithm - Algorithm name
     * @param {Function} progressCallback - Optional progress callback
     * @returns {Promise<string>} - Hex hash
     * @throws {Error} - If Web Crypto API is not supported
     */
    async hashFile(file, algorithm = 'SHA-256', progressCallback = null) {
      if (!this.isSupported()) {
        throw new Error('Web Crypto API not supported in this browser');
      }

      const chunkSize = 1024 * 1024;
      const chunks = Math.ceil(file.size / chunkSize);
      let offset = 0;

      const arrayBuffer = await file.arrayBuffer();

      if (progressCallback) {
        progressCallback(100);
      }

      const hashBuffer = await window.crypto.subtle.digest(algorithm, arrayBuffer);
      return this.bufferToHex(hashBuffer);
    },

    /**
     * Generate HMAC
     *
     * Security: Uses Web Crypto API for secure HMAC generation.
     *
     * @param {string} text - Text to hash
     * @param {string} secret - Secret key
     * @param {string} algorithm - Algorithm (SHA-256, SHA-384, SHA-512)
     * @returns {Promise<string>} - Hex HMAC
     * @throws {Error} - If Web Crypto API is not supported
     */
    async hmac(text, secret, algorithm = 'SHA-256') {
      if (!this.isSupported()) {
        throw new Error('Web Crypto API not supported in this browser');
      }

      const key = await window.crypto.subtle.importKey(
        'raw',
        this.stringToBuffer(secret),
        { name: 'HMAC', hash: algorithm },
        false,
        ['sign']
      );

      const signature = await window.crypto.subtle.sign(
        'HMAC',
        key,
        this.stringToBuffer(text)
      );

      return this.bufferToHex(signature);
    },

    /**
     * Generate SRI hash from URL
     *
     * @param {string} url - Resource URL
     * @param {string} algorithm - Algorithm (SHA-256, SHA-384, SHA-512)
     * @returns {Promise<object>} - Object with hash and integrity string
     * @throws {Error} - If resource fetch fails or Web Crypto API is not supported
     */
    async generateSRI(url, algorithm = 'SHA-384') {
      if (!this.isSupported()) {
        throw new Error('Web Crypto API not supported in this browser');
      }

      try {
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const arrayBuffer = await response.arrayBuffer();
        const hashBuffer = await window.crypto.subtle.digest(algorithm, arrayBuffer);
        const base64Hash = this.bufferToBase64(hashBuffer);

        const algoPrefix = algorithm.toLowerCase().replace('-', '');
        const integrity = `${algoPrefix}-${base64Hash}`;

        return {
          hash: this.bufferToHex(hashBuffer),
          base64: base64Hash,
          integrity: integrity,
          algorithm: algorithm
        };
      } catch (error) {
        throw new Error(`Failed to fetch resource: ${error.message}`);
      }
    }
  };

  window.Tools.register('hashGeneratorTool', {
    /**
     * Initialize the Hash Generator Tool
     */
    init: function () {
      if (!CryptoUtils.isSupported()) {
        console.error('Web Crypto API not supported - Hash Generator will not work');
      } else {
        console.debug('Hash Generator Tool initialized (Web Crypto API)');
      }
    },

    /**
     * Open the Hash Generator Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      try {
        if (!CryptoUtils.isSupported()) {
          container.innerHTML = `
            <div class="alert alert-danger" role="alert">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <strong>Web Crypto API Not Supported</strong><br>
              Your browser doesn't support the Web Crypto API. Please use a modern browser.
            </div>
          `;
          return;
        }

        container.innerHTML = '';
        // Main content
        const row = document.createElement('div');
        row.className = 'row g-4';

        // Mode Selector & Settings Card (combined)
        const modeCol = document.createElement('div');
        modeCol.className = 'col-12';
        modeCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label fw-bold"><i class="bi bi-sliders me-2"></i>${t('tools.hashGeneratorTool.modeTitle')}</label>
                  <div class="btn-group btn-group-sm w-100" role="group">
                    <input type="radio" class="btn-check" name="hashMode" id="modeText" value="text" checked autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeText">
                      <i class="bi bi-file-text me-1"></i>${t('tools.hashGeneratorTool.modeText')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeFile" value="file" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeFile">
                      <i class="bi bi-file-earmark me-1"></i>${t('tools.hashGeneratorTool.modeFile')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeHMAC" value="hmac" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeHMAC">
                      <i class="bi bi-key me-1"></i>${t('tools.hashGeneratorTool.modeHMAC')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeSRI" value="sri" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeSRI">
                      <i class="bi bi-shield-check me-1"></i>${t('tools.hashGeneratorTool.modeSRI')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeCompare" value="compare" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeCompare">
                      <i class="bi bi-clipboard-check me-1"></i>${t('tools.hashGeneratorTool.modeCompare')}
                    </label>
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-bold"><i class="bi bi-gear me-2"></i>Output</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="uppercaseToggle">
                    <label class="form-check-label" for="uppercaseToggle">
                      ${t('tools.hashGeneratorTool.uppercase')}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
        row.appendChild(modeCol);

        // Input & Output in two columns
        const inputOutputWrapper = document.createElement('div');
        inputOutputWrapper.className = 'col-12 position-relative';
        inputOutputWrapper.id = 'inputOutputWrapper';
        inputOutputWrapper.innerHTML = `
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div id="inputCard"></div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="card-title h5 mb-3"><i class="bi bi-hash me-2"></i>${t('tools.hashGeneratorTool.outputTitle')}</h2>
                  <div id="hashResults"></div>
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
        `;
        row.appendChild(inputOutputWrapper);

        container.appendChild(row);

        // Initialize functionality
        this.initializeGenerator(container);

      } catch (e) {
        container.innerHTML = `
          <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>${t('tools.hashGeneratorTool.errorLoading')}:</strong> ${e.message}
          </div>
        `;
        console.error('Error in hashGeneratorTool.open:', e);
      }
    },

    /**
     * Initialize generator event listeners and UI
     *
     * @param {HTMLElement} container - Container element
     */
    initializeGenerator: function(container) {
      const inputCard = container.querySelector('#inputCard');
      const hashResults = container.querySelector('#hashResults');
      const uppercaseToggle = container.querySelector('#uppercaseToggle');

      // Layout toggle functionality
      const toggleLayoutBtn = container.querySelector('#toggleLayoutBtn');
      const wrapper = container.querySelector('#inputOutputWrapper');

      if (toggleLayoutBtn && wrapper) {
        toggleLayoutBtn.addEventListener('click', () => {
          const columns = wrapper.querySelectorAll('.row > .col-12');
          const isSideBySide = columns[0].classList.contains('col-lg-6');

          if (isSideBySide) {
            // Switch to stacked
            columns.forEach(col => col.classList.remove('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-split"></i>`;
            toggleLayoutBtn.classList.remove('top-50', 'start-50', 'translate-middle');
            toggleLayoutBtn.classList.add('top-0', 'end-0', 'btn-layout-toggle-stacked');
          } else {
            // Switch to side by side
            columns.forEach(col => col.classList.add('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-layout-three-columns"></i>`;
            toggleLayoutBtn.classList.remove('top-0', 'end-0', 'btn-layout-toggle-stacked');
            toggleLayoutBtn.classList.add('top-50', 'start-50', 'translate-middle');
          }
        });
      }

      // Mode switcher
      const modeRadios = container.querySelectorAll('input[name="hashMode"]');
      modeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
          this.renderInput(inputCard, radio.value);
          this.setupHashListeners(container);
          hashResults.innerHTML = '';
        });
      });

      // Initial render
      this.renderInput(inputCard, 'text');
      this.setupHashListeners(container);

      // Uppercase toggle
      uppercaseToggle.addEventListener('change', () => {
        this.updateHashCase(hashResults, uppercaseToggle.checked);
      });
    },

    /**
     * Render input UI based on selected mode
     *
     * @param {HTMLElement} container - Container element
     * @param {string} mode - Mode ('text', 'file', 'hmac', 'sri', 'compare')
     */
    renderInput: function(container, mode) {
      if (mode === 'text') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.hashGeneratorTool.inputTitle')}</h2>
              <div class="mb-3">
                <label for="textInput" class="form-label">${t('tools.hashGeneratorTool.textLabel')}</label>
                <textarea class="form-control font-monospace" id="textInput" rows="6"
                  placeholder="${t('tools.hashGeneratorTool.textPlaceholder')}"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Algorithms</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="algoSHA1" value="SHA-1">
                  <label class="form-check-label" for="algoSHA1">SHA-1 <small class="text-muted">(legacy)</small></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="algoSHA256" value="SHA-256" checked>
                  <label class="form-check-label" for="algoSHA256">SHA-256</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="algoSHA384" value="SHA-384" checked>
                  <label class="form-check-label" for="algoSHA384">SHA-384</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="algoSHA512" value="SHA-512" checked>
                  <label class="form-check-label" for="algoSHA512">SHA-512</label>
                </div>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="liveHash" checked>
                <label class="form-check-label" for="liveHash">
                  ${t('tools.hashGeneratorTool.liveMode')}
                </label>
              </div>
              <button class="btn btn-primary btn-sm" id="generateHash">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.hashGeneratorTool.generate')}
              </button>
            </div>
          </div>
        `;
      } else if (mode === 'file') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-file-earmark me-2"></i>${t('tools.hashGeneratorTool.fileTitle')}</h2>
              <div class="mb-3">
                <label for="fileInput" class="form-label">${t('tools.hashGeneratorTool.fileLabel')}</label>
                <input type="file" class="form-control form-control-sm" id="fileInput">
                <small class="text-muted">${t('tools.hashGeneratorTool.fileHint')}</small>
              </div>
              <div class="mb-3">
                <label class="form-label">Algorithms</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="fileAlgoSHA256" value="SHA-256" checked>
                  <label class="form-check-label" for="fileAlgoSHA256">SHA-256</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="fileAlgoSHA384" value="SHA-384">
                  <label class="form-check-label" for="fileAlgoSHA384">SHA-384</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="fileAlgoSHA512" value="SHA-512">
                  <label class="form-check-label" for="fileAlgoSHA512">SHA-512</label>
                </div>
              </div>
              <div id="fileInfo" class="alert alert-info hidden"></div>
              <div class="progress mb-3 hidden" id="fileProgress">
                <div class="progress-bar progress-bar-width-0" role="progressbar"></div>
              </div>
            </div>
          </div>
        `;
      } else if (mode === 'hmac') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-key me-2"></i>${t('tools.hashGeneratorTool.hmacTitle')}</h2>
              <div class="mb-3">
                <label for="hmacText" class="form-label">${t('tools.hashGeneratorTool.textLabel')}</label>
                <textarea class="form-control font-monospace" id="hmacText" rows="4"
                  placeholder="${t('tools.hashGeneratorTool.textPlaceholder')}"></textarea>
              </div>
              <div class="mb-3">
                <label for="hmacSecret" class="form-label">${t('tools.hashGeneratorTool.hmacSecret')}</label>
                <input type="text" class="form-control font-monospace" id="hmacSecret"
                  placeholder="${t('tools.hashGeneratorTool.hmacSecretPlaceholder')}">
              </div>
              <div class="mb-3">
                <label for="hmacAlgorithm" class="form-label">${t('tools.hashGeneratorTool.algorithm')}</label>
                <select class="form-select form-select-sm" id="hmacAlgorithm">
                  <option value="SHA-256">HMAC-SHA-256</option>
                  <option value="SHA-384">HMAC-SHA-384</option>
                  <option value="SHA-512">HMAC-SHA-512</option>
                </select>
              </div>
              <button class="btn btn-primary btn-sm" id="generateHMAC">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.hashGeneratorTool.generate')}
              </button>
            </div>
          </div>
        `;
      } else if (mode === 'sri') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-shield-check me-2"></i>${t('tools.hashGeneratorTool.sriTitle')}</h2>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <small>SRI (Subresource Integrity) verifies that fetched resources haven't been tampered with.</small>
              </div>
              <div class="mb-3">
                <label for="sriURL" class="form-label">${t('tools.hashGeneratorTool.sriURL')}</label>
                <input type="url" class="form-control form-control-sm" id="sriURL"
                  placeholder="https://cdn.example.com/library.js">
                <small class="text-muted">${t('tools.hashGeneratorTool.sriHint')}</small>
              </div>
              <div class="mb-3">
                <label for="sriAlgorithm" class="form-label">${t('tools.hashGeneratorTool.algorithm')}</label>
                <select class="form-select form-select-sm" id="sriAlgorithm">
                  <option value="SHA-256">SHA-256</option>
                  <option value="SHA-384" selected>SHA-384</option>
                  <option value="SHA-512">SHA-512</option>
                </select>
              </div>
              <button class="btn btn-primary" id="generateSRI">
                <i class="bi bi-download me-2"></i>${t('tools.hashGeneratorTool.generate')}
              </button>
              <div id="sriProgress" class="mt-3 hidden">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                <span>Fetching resource...</span>
              </div>
            </div>

            </div>
          </div>
        `;
      } else if (mode === 'compare') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-clipboard-check me-2"></i>${t('tools.hashGeneratorTool.compareTitle')}</h2>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="hash1" class="form-label">${t('tools.hashGeneratorTool.hash1')}</label>
                  <input type="text" class="form-control font-monospace" id="hash1"
                    placeholder="${t('tools.hashGeneratorTool.hashPlaceholder')}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="hash2" class="form-label">${t('tools.hashGeneratorTool.hash2')}</label>
                  <input type="text" class="form-control font-monospace" id="hash2"
                    placeholder="${t('tools.hashGeneratorTool.hashPlaceholder')}">
                </div>
              </div>
              <button class="btn btn-primary btn-sm" id="compareHashes">
                <i class="bi bi-arrows-collapse me-2"></i>${t('tools.hashGeneratorTool.compare')}
              </button>
              <div id="compareResult" class="mt-3"></div>
            </div>
          </div>
        `;
      }
    },

    /**
     * Setup event listeners for current hash mode
     *
     * @param {HTMLElement} container - Container element
     */
    setupHashListeners: function(container) {
      const mode = container.querySelector('input[name="hashMode"]:checked').value;
      const hashResults = container.querySelector('#hashResults');

      if (mode === 'text') {
        const textInput = container.querySelector('#textInput');
        const generateBtn = container.querySelector('#generateHash');
        const liveHash = container.querySelector('#liveHash');

        const generate = () => this.generateTextHash(container);

        generateBtn.addEventListener('click', generate);

        textInput.addEventListener('input', () => {
          if (liveHash.checked) {
            generate();
          }
        });

        // Trigger on algorithm change
        container.querySelectorAll('input[type="checkbox"][id^="algo"]').forEach(cb => {
          cb.addEventListener('change', () => {
            if (textInput.value && liveHash.checked) {
              generate();
            }
          });
        });

      } else if (mode === 'file') {
        const fileInput = container.querySelector('#fileInput');

        fileInput.addEventListener('change', () => {
          this.generateFileHash(container);
        });

      } else if (mode === 'hmac') {
        const generateBtn = container.querySelector('#generateHMAC');
        generateBtn.addEventListener('click', () => this.generateHMAC(container));

      } else if (mode === 'sri') {
        const generateBtn = container.querySelector('#generateSRI');
        generateBtn.addEventListener('click', () => this.generateSRI(container));

      } else if (mode === 'compare') {
        const compareBtn = container.querySelector('#compareHashes');
        compareBtn.addEventListener('click', () => this.compareHashes(container));
      }
    },

    /**
     * Generate hash from text input
     *
     * @param {HTMLElement} container - Container element
     * @returns {Promise<void>} - Async operation
     */
    async generateTextHash(container) {
      const textInput = container.querySelector('#textInput');
      const hashResults = container.querySelector('#hashResults');
      const text = textInput.value;

      if (!text) {
        hashResults.innerHTML = '<div class="alert alert-warning">Please enter text to hash.</div>';
        return;
      }

      const algorithms = [];
      container.querySelectorAll('input[type="checkbox"][id^="algo"]:checked').forEach(cb => {
        algorithms.push(cb.value);
      });

      if (algorithms.length === 0) {
        hashResults.innerHTML = '<div class="alert alert-warning">Please select at least one algorithm.</div>';
        return;
      }

      hashResults.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Generating hashes...';

      try {
        const results = await Promise.all(
          algorithms.map(async algo => {
            const hash = await CryptoUtils.hashText(text, algo);
            return { algorithm: algo, hash };
          })
        );

        this.displayHashResults(hashResults, results);
      } catch (error) {
        hashResults.textContent = '';
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        errorAlert.textContent = `Error: ${error.message}`;
        hashResults.appendChild(errorAlert);
      }
    },

    /**
     * Generate hash from file upload
     *
     * Security: Uses textContent for file name to prevent XSS.
     *
     * @param {HTMLElement} container - Container element
     * @returns {Promise<void>} - Async operation
     */
    async generateFileHash(container) {
      const fileInput = container.querySelector('#fileInput');
      const fileInfo = container.querySelector('#fileInfo');
      const hashResults = container.querySelector('#hashResults');
      const fileProgress = container.querySelector('#fileProgress');
      const progressBar = fileProgress?.querySelector('.progress-bar');

      /**
       * Show element by removing d-none class
       *
       * @param {HTMLElement} el - Element to show
       */
      const show = (el) => el?.classList.remove('d-none');

      /**
       * Hide element by adding d-none class
       *
       * @param {HTMLElement} el - Element to hide
       */
      const hide = (el) => el?.classList.add('d-none');

      /**
       * Set progress bar width
       *
       * @param {HTMLElement} bar - Progress bar element
       * @param {number} percentage - Percentage value
       */
      const setProgressWidth = (bar, percentage) => {
        if (bar) {
          bar.style.width = `${percentage}%`;
          bar.setAttribute('aria-valuenow', percentage);
        }
      };

      const file = fileInput.files[0];
      if (!file) {
        hashResults.innerHTML = '';
        return;
      }

      if (file.size > MAX_FILE_SIZE) {
        hashResults.innerHTML = `
          <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>File too large:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB<br>
            <small>Maximum file size is ${MAX_FILE_SIZE / 1024 / 1024} MB to prevent browser performance issues.</small>
          </div>
        `;
        return;
      }

      const safeName = window.AppHelpers ? window.AppHelpers.escapeHtml(file.name) : file.name;
      const safeType = window.AppHelpers ? window.AppHelpers.escapeHtml(file.type || 'unknown') : (file.type || 'unknown');

      show(fileInfo);
      fileInfo.innerHTML = `
        <strong>File:</strong> ${safeName}<br>
        <strong>Size:</strong> ${(file.size / 1024).toFixed(2)} KB<br>
        <strong>Type:</strong> ${safeType}
      `;

      const algorithms = [];
      container.querySelectorAll('input[type="checkbox"][id^="fileAlgo"]:checked').forEach(cb => {
        algorithms.push(cb.value);
      });

      if (algorithms.length === 0) {
        hashResults.innerHTML = '<div class="alert alert-warning">Please select at least one algorithm.</div>';
        return;
      }

      show(fileProgress);
      setProgressWidth(progressBar, 0);

      hashResults.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Hashing file...';

      try {
        const results = [];
        for (let i = 0; i < algorithms.length; i++) {
          const algo = algorithms[i];
          const hash = await CryptoUtils.hashFile(file, algo, (progress) => {
            setProgressWidth(progressBar, progress);
          });
          results.push({ algorithm: algo, hash });
        }

        hide(fileProgress);

        this.displayHashResults(hashResults, results);
      } catch (error) {
        hide(fileProgress);
        hashResults.textContent = '';
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        errorAlert.textContent = `Error: ${error.message}`;
        hashResults.appendChild(errorAlert);
      }
    },

    /**
     * Generate HMAC from text and secret key
     *
     * @param {HTMLElement} container - Container element
     * @returns {Promise<void>} - Async operation
     */
    async generateHMAC(container) {
      const hmacText = container.querySelector('#hmacText');
      const hmacSecret = container.querySelector('#hmacSecret');
      const hmacAlgorithm = container.querySelector('#hmacAlgorithm');
      const hashResults = container.querySelector('#hashResults');

      const text = hmacText.value;
      const secret = hmacSecret.value;
      const algorithm = hmacAlgorithm.value;

      if (!text || !secret) {
        hashResults.innerHTML = '<div class="alert alert-warning">Please enter both text and secret key.</div>';
        return;
      }

      hashResults.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Generating HMAC...';

      try {
        const hash = await CryptoUtils.hmac(text, secret, algorithm);
        this.displayHashResults(hashResults, [{ algorithm: `HMAC-${algorithm}`, hash }]);
      } catch (error) {
        hashResults.textContent = '';
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        errorAlert.textContent = `Error: ${error.message}`;
        hashResults.appendChild(errorAlert);
      }
    },

    /**
     * Generate SRI hash from URL
     *
     * @param {HTMLElement} container - Container element
     * @returns {Promise<void>} - Async operation
     */
    async generateSRI(container) {
      const sriURL = container.querySelector('#sriURL');
      const sriAlgorithm = container.querySelector('#sriAlgorithm');
      const sriProgress = container.querySelector('#sriProgress');
      const hashResults = container.querySelector('#hashResults');

      /**
       * Show element by removing d-none class
       *
       * @param {HTMLElement} el - Element to show
       */
      const show = (el) => el?.classList.remove('d-none');

      /**
       * Hide element by adding d-none class
       *
       * @param {HTMLElement} el - Element to hide
       */
      const hide = (el) => el?.classList.add('d-none');

      hashResults.addEventListener('click', async function(e) {
        const btn = e.target.closest('.sri-copy-btn');
        if (!btn) return;

        const value = btn.getAttribute('data-copy-value');
        if (value) {
          const success = await window.ClipboardUtils.copyToClipboard(value);
          
          if (success) {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check"></i>';
            setTimeout(() => {
              btn.innerHTML = originalHtml;
            }, 1500);
          }
        }
      });

      const url = sriURL.value.trim();
      const algorithm = sriAlgorithm.value;

      if (!url) {
        hashResults.innerHTML = '<div class="alert alert-warning">Please enter a URL.</div>';
        return;
      }

      show(sriProgress);
      hashResults.innerHTML = '';

      try {
        const result = await CryptoUtils.generateSRI(url, algorithm);
        hide(sriProgress);

        hashResults.innerHTML = `
          <div class="alert alert-success">
            <h6><i class="bi bi-check-circle me-2"></i>SRI Generated Successfully</h6>
            <hr>
            <div class="mb-2">
              <strong>Algorithm:</strong> ${result.algorithm}
            </div>
            <div class="mb-2">
              <strong>Integrity Hash:</strong>
              <div class="input-group input-group-sm mt-1">
                <input type="text" class="form-control font-monospace sri-integrity-value" value="${result.integrity}" readonly>
                <button class="btn btn-outline-secondary sri-copy-btn" data-copy-value="${result.integrity}">
                  <i class="bi bi-clipboard"></i>
                </button>
              </div>
            </div>
            <div class="mb-2">
              <strong>Hex Hash:</strong>
              <div class="input-group input-group-sm mt-1">
                <input type="text" class="form-control font-monospace sri-hash-value" value="${result.hash}" readonly>
                <button class="btn btn-outline-secondary sri-copy-btn" data-copy-value="${result.hash}">
                  <i class="bi bi-clipboard"></i>
                </button>
              </div>
            </div>
            <hr>
            <strong>HTML Example:</strong>
            <pre class="bg-light p-2 mt-2"><code>&lt;script src="${url}"
        integrity="${result.integrity}"
        crossorigin="anonymous"&gt;&lt;/script&gt;</code></pre>
          </div>
        `;
      } catch (error) {
        hide(sriProgress);
        hashResults.textContent = '';
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        const icon = document.createElement('i');
        icon.className = 'bi bi-exclamation-triangle me-2';
        errorAlert.appendChild(icon);
        errorAlert.appendChild(document.createTextNode(`Error: ${error.message}`));
        hashResults.appendChild(errorAlert);
      }
    },

    /**
     * Compare two hash values
     *
     * @param {HTMLElement} container - Container element
     */
    compareHashes(container) {
      const hash1 = container.querySelector('#hash1').value.trim().toLowerCase();
      const hash2 = container.querySelector('#hash2').value.trim().toLowerCase();
      const compareResult = container.querySelector('#compareResult');

      if (!hash1 || !hash2) {
        compareResult.innerHTML = '<div class="alert alert-warning">Please enter both hashes.</div>';
        return;
      }

      const match = hash1 === hash2;

      compareResult.innerHTML = `
        <div class="alert alert-${match ? 'success' : 'danger'}">
          <h6><i class="bi bi-${match ? 'check-circle' : 'x-circle'} me-2"></i>${match ? 'Hashes Match!' : 'Hashes Do Not Match'}</h6>
          ${!match ? `
            <hr>
            <small>
              <strong>Hash 1 length:</strong> ${hash1.length} chars<br>
              <strong>Hash 2 length:</strong> ${hash2.length} chars
            </small>
          ` : ''}
        </div>
      `;
    },

    /**
     * Display hash results in UI
     *
     * @param {HTMLElement} container - Container element
     * @param {Array<object>} results - Array of {algorithm, hash} objects
     */
    displayHashResults(container, results) {
      const uppercase = document.querySelector('#uppercaseToggle')?.checked || false;

      let html = '<div class="list-group">';
      results.forEach(result => {
        const hash = uppercase ? result.hash.toUpperCase() : result.hash;
        html += `
          <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <strong>${result.algorithm}</strong>
              <span class="badge bg-secondary">${result.hash.length / 2} bytes</span>
            </div>
            <div class="input-group input-group-sm">
              <input type="text" class="form-control font-monospace hash-output" value="${hash}" readonly>
              <button class="btn btn-outline-secondary copy-hash" data-hash="${hash}">
                <i class="bi bi-clipboard"></i>
              </button>
            </div>
          </div>
        `;
      });
      html += '</div>';

      container.innerHTML = html;

      // Add copy functionality
      container.querySelectorAll('.copy-hash').forEach(btn => {
        btn.addEventListener('click', async () => {
          const hash = btn.dataset.hash;
          const success = await window.ClipboardUtils.copyToClipboard(hash);
          
          if (success) {
            const icon = btn.querySelector('i');
            if (icon) {
              icon.className = 'bi bi-check';
              setTimeout(() => {
                icon.className = 'bi bi-clipboard';
              }, 2000);
            }
          }
        });
      });
    },

    /**
     * Update hash display case (uppercase/lowercase)
     *
     * @param {HTMLElement} container - Container element
     * @param {boolean} uppercase - Whether to display hashes in uppercase
     */
    updateHashCase(container, uppercase) {
      container.querySelectorAll('.hash-output').forEach(input => {
        const hash = input.value;
        input.value = uppercase ? hash.toUpperCase() : hash.toLowerCase();

        const copyBtn = input.nextElementSibling;
        if (copyBtn && copyBtn.classList.contains('copy-hash')) {
          copyBtn.dataset.hash = input.value;
        }
      });
    }
  });

  if (typeof window.CryptoUtils === 'undefined') {
    window.CryptoUtils = CryptoUtils;
  }

})();
