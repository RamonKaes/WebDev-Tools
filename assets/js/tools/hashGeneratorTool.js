/**
 * Hash Generator Tool
 *
 * Generate cryptographic hashes using Web Crypto API.
 * Supports SHA-1, SHA-256, SHA-384, SHA-512, HMAC and hash comparison.
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
        throw new Error(t('tools.hashGeneratorTool.cryptoUnsupportedTitle'));
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
        throw new Error(t('tools.hashGeneratorTool.cryptoUnsupportedTitle'));
      }

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
        throw new Error(t('tools.hashGeneratorTool.cryptoUnsupportedTitle'));
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
              <strong>${t('tools.hashGeneratorTool.cryptoUnsupportedTitle')}</strong><br>
              ${t('tools.hashGeneratorTool.cryptoUnsupportedText')}
            </div>
          `;
          return;
        }

        container.innerHTML = '';
        // Main content
        const row = document.createElement('div');
        row.className = 'row g-3';

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
                    <input type="radio" class="btn-check" name="hashMode" id="modeText" value="text" checked>
                    <label class="btn btn-outline-primary" for="modeText">
                      <i class="bi bi-file-text me-1"></i>${t('tools.hashGeneratorTool.modeText')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeFile" value="file">
                    <label class="btn btn-outline-primary" for="modeFile">
                      <i class="bi bi-file-earmark me-1"></i>${t('tools.hashGeneratorTool.modeFile')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeHMAC" value="hmac">
                    <label class="btn btn-outline-primary" for="modeHMAC">
                      <i class="bi bi-key me-1"></i>${t('tools.hashGeneratorTool.modeHMAC')}
                    </label>

                    <input type="radio" class="btn-check" name="hashMode" id="modeCompare" value="compare">
                    <label class="btn btn-outline-primary" for="modeCompare">
                      <i class="bi bi-clipboard-check me-1"></i>${t('tools.hashGeneratorTool.modeCompare')}
                    </label>
                  </div>
                  <small class="text-muted d-block mt-2">${t('tools.hashGeneratorTool.sriLinkHint')} <a href="${toolUrl('sriGeneratorTool', 'sri-generator')}">${t('tools.sriGeneratorTool.linkTitle.nav')}</a></small>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-bold"><i class="bi bi-gear me-2"></i>${t('common.output')}</label>
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
          <div class="row g-3">
            <div class="col-12 col-lg-6">
              <div id="inputCard"></div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="card-title h5 mb-3"><i class="bi bi-hash me-2"></i>${t('tools.hashGeneratorTool.outputTitle')}</h2>
                  <div id="hashResults" aria-live="polite"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Floating Toggle Button -->
          <button class="btn btn-secondary btn-layout-toggle d-none d-lg-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle shadow"
                  id="toggleLayoutBtn"
                  title="${t('common.layout_stacked')}">
            <i class="bi bi-view-stacked"></i>
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
            toggleLayoutBtn.title = t('common.layout_side_by_side');
            toggleLayoutBtn.classList.remove('top-50', 'start-50', 'translate-middle');
            toggleLayoutBtn.classList.add('top-0', 'end-0', 'btn-layout-toggle-stacked');
          } else {
            // Switch to side by side
            columns.forEach(col => col.classList.add('col-lg-6'));
            toggleLayoutBtn.innerHTML = `<i class="bi bi-view-stacked"></i>`;
            toggleLayoutBtn.title = t('common.layout_stacked');
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
     * @param {string} mode - Mode ('text', 'file', 'hmac', 'compare')
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
                <label class="form-label">${t('tools.hashGeneratorTool.algorithms')}</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="algoSHA1" value="SHA-1">
                  <label class="form-check-label" for="algoSHA1">SHA-1 <small class="text-muted">(${t('tools.hashGeneratorTool.legacy')})</small></label>
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
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary btn-sm" id="generateHash">
                  <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.hashGeneratorTool.generate')}
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="loadExampleText">
                  <i class="bi bi-lightning me-2"></i>${t('tools.hashGeneratorTool.loadExample')}
                </button>
              </div>
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
                <label class="form-label">${t('tools.hashGeneratorTool.algorithms')}</label>
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
              <div id="fileInfo" class="alert alert-info d-none"></div>
              <div class="progress mb-3 d-none" id="fileProgress">
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
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary btn-sm" id="generateHMAC">
                  <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.hashGeneratorTool.generate')}
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="loadExampleHMAC">
                  <i class="bi bi-lightning me-2"></i>${t('tools.hashGeneratorTool.loadExample')}
                </button>
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
              <div id="compareResult" class="mt-3" aria-live="polite"></div>
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

        const exampleTextBtn = container.querySelector('#loadExampleText');
        exampleTextBtn.addEventListener('click', () => {
          textInput.value = 'Hello, World!';
          generate();
        });

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

        const exampleHMACBtn = container.querySelector('#loadExampleHMAC');
        exampleHMACBtn.addEventListener('click', () => {
          container.querySelector('#hmacText').value = 'The quick brown fox jumps over the lazy dog';
          container.querySelector('#hmacSecret').value = 'secret-key';
          this.generateHMAC(container);
        });

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
        hashResults.innerHTML = `<div class="alert alert-warning">${t('tools.hashGeneratorTool.errorNoText')}</div>`;
        return;
      }

      const algorithms = [];
      container.querySelectorAll('input[type="checkbox"][id^="algo"]:checked').forEach(cb => {
        algorithms.push(cb.value);
      });

      if (algorithms.length === 0) {
        hashResults.innerHTML = `<div class="alert alert-warning">${t('tools.hashGeneratorTool.errorNoAlgorithm')}</div>`;
        return;
      }

      hashResults.innerHTML = `<div class="spinner-border spinner-border-sm" role="status"></div> ${t('tools.hashGeneratorTool.generating')}`;

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
        errorAlert.textContent = `${t('common.error')}: ${error.message}`;
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
            <strong>${t('tools.hashGeneratorTool.errorFileTooLarge', { size: (file.size / 1024 / 1024).toFixed(2) })}</strong><br>
            <small>${t('tools.hashGeneratorTool.fileMaxSize', { max: MAX_FILE_SIZE / 1024 / 1024 })}</small>
          </div>
        `;
        return;
      }

      const safeName = window.AppHelpers ? window.AppHelpers.escapeHtml(file.name) : file.name;
      const safeType = window.AppHelpers ? window.AppHelpers.escapeHtml(file.type || 'unknown') : (file.type || 'unknown');

      show(fileInfo);
      fileInfo.innerHTML = `
        <strong>${t('tools.hashGeneratorTool.fileName')}:</strong> ${safeName}<br>
        <strong>${t('tools.hashGeneratorTool.fileSize')}:</strong> ${(file.size / 1024).toFixed(2)} KB<br>
        <strong>${t('tools.hashGeneratorTool.fileType')}:</strong> ${safeType}
      `;

      const algorithms = [];
      container.querySelectorAll('input[type="checkbox"][id^="fileAlgo"]:checked').forEach(cb => {
        algorithms.push(cb.value);
      });

      if (algorithms.length === 0) {
        hashResults.innerHTML = `<div class="alert alert-warning">${t('tools.hashGeneratorTool.errorNoAlgorithm')}</div>`;
        return;
      }

      show(fileProgress);
      setProgressWidth(progressBar, 0);

      hashResults.innerHTML = `<div class="spinner-border spinner-border-sm" role="status"></div> ${t('tools.hashGeneratorTool.hashingFile')}`;

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
        errorAlert.textContent = `${t('common.error')}: ${error.message}`;
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
        hashResults.innerHTML = `<div class="alert alert-warning">${t('tools.hashGeneratorTool.errorNoTextSecret')}</div>`;
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
        errorAlert.textContent = `${t('common.error')}: ${error.message}`;
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
        compareResult.innerHTML = `<div class="alert alert-warning">${t('tools.hashGeneratorTool.errorNoHashes')}</div>`;
        return;
      }

      const match = hash1 === hash2;

      compareResult.innerHTML = `
        <div class="alert alert-${match ? 'success' : 'danger'}">
          <h6><i class="bi bi-${match ? 'check-circle' : 'x-circle'} me-2"></i>${match ? t('tools.hashGeneratorTool.hashesMatch') : t('tools.hashGeneratorTool.hashesNoMatch')}</h6>
          ${!match ? `
            <hr>
            <small>
              ${t('tools.hashGeneratorTool.hashLength', { n: 1, length: hash1.length })}<br>
              ${t('tools.hashGeneratorTool.hashLength', { n: 2, length: hash2.length })}
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
              <span class="badge bg-secondary">${result.hash.length / 2} ${t('tools.hashGeneratorTool.bytes')}</span>
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
            const icon = window.ClipboardUtils?.iconHandle?.(btn);
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
