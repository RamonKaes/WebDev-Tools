/**
 * URL Encoder/Decoder Tool
 * 
 * Bidirectional URL encoding and decoding with support for component and full URL modes.
 * Includes URL parser for analyzing URL structure and extracting query parameters.
 */
(function () {
  'use strict';

  /**
   * Escape HTML special characters for XSS protection
   *
   * @param {string} text - Input text
   * @returns {string} - HTML-escaped text
   */
  const escapeHtml = (text) => {
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
  }; 

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'urlEncoderDecoder'}) : '[urlEncoderDecoder] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('urlEncoderDecoder', {
    /**
     * Initialize the URL Encoder/Decoder Tool
     */
    init: function () {
    },

    /**
     * Open the URL Encoder/Decoder Tool in the provided container
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
        <div class="col-12 col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.urlEncoderDecoder.input_title')}</h2>

              <div class="btn-group btn-group-sm mb-3 w-100" role="group">
                <input type="radio" class="btn-check" name="mode" id="modeEncode" autocomplete="off" checked>
                <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeEncode"><i class="bi bi-arrow-right me-1"></i>${t('tools.urlEncoderDecoder.encode_title')}</label>

                <input type="radio" class="btn-check" name="mode" id="modeDecode" autocomplete="off">
                <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeDecode"><i class="bi bi-arrow-left me-1"></i>${t('tools.urlEncoderDecoder.decode_title')}</label>
              </div>

              <textarea class="form-control font-monospace mb-3" id="input" rows="10" placeholder="${t('tools.urlEncoderDecoder.encode_placeholder')}"></textarea>

              <div class="d-flex flex-wrap gap-2 mb-2">
                <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="processBtn"><i class="bi bi-arrow-right me-2"></i>${t('tools.urlEncoderDecoder.encode_btn')}</button>
                <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('tools.urlEncoderDecoder.clear_btn')}</button>
                <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('tools.urlEncoderDecoder.load_sample')}</button>
              </div>

              <div id="encodeOptions">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="liveMode">
                  <label class="form-check-label" for="liveMode">${t('tools.urlEncoderDecoder.live_mode')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="encodeLines">
                  <label class="form-check-label" for="encodeLines">${t('tools.urlEncoderDecoder.encode_each_line')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="encodeMode" id="encodeComponent" checked>
                  <label class="form-check-label" for="encodeComponent">${t('tools.urlEncoderDecoder.mode_component')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="encodeMode" id="encodeURI">
                  <label class="form-check-label" for="encodeURI">${t('tools.urlEncoderDecoder.mode_uri')}</label>
                </div>
              </div>

              <div id="decodeOptions" class="d-none">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="liveModeDecode">
                  <label class="form-check-label" for="liveModeDecode">${t('tools.urlEncoderDecoder.live_mode')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="decodeLines">
                  <label class="form-check-label" for="decodeLines">${t('tools.urlEncoderDecoder.decode_each_line')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decodeMode" id="decodeComponent" checked>
                  <label class="form-check-label" for="decodeComponent">${t('tools.urlEncoderDecoder.mode_component')}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decodeMode" id="decodeURI">
                  <label class="form-check-label" for="decodeURI">${t('tools.urlEncoderDecoder.mode_uri')}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-code-square me-2"></i>${t('tools.urlEncoderDecoder.output_title')}</h2>

              <textarea class="form-control bg-body-secondary font-monospace mb-3" id="output" rows="10" placeholder="${t('tools.urlEncoderDecoder.encode_output_placeholder')}"></textarea>

              <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                <small class="text-muted me-auto" id="outputInfo"></small>
                <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyBtn"><i class="bi bi-clipboard me-2"></i>${t('tools.urlEncoderDecoder.copy_btn')}</button>
              </div>

              <div class="alert alert-info py-2 mb-0" id="modeInfo">
                <small><strong>${t('tools.urlEncoderDecoder.mode_component')}:</strong> ${t('tools.urlEncoderDecoder.component_info')}</small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-diagram-3 me-2"></i>${t('tools.urlEncoderDecoder.parser_title')}</h2>

              <div class="input-group mb-3">
                <input type="text" class="form-control font-monospace" id="parseInput" placeholder="${t('tools.urlEncoderDecoder.parser_placeholder')}">
                <button class="btn btn-primary btn-sm d-inline-flex align-items-center" id="parseBtn"><i class="bi bi-search me-2"></i>${t('tools.urlEncoderDecoder.parse_btn')}</button>
              </div>

              <div id="parseOutput"></div>
            </div>
          </div>
        </div>
      </div>`;

      this.initializeTool(container);
    },

    /**
     * Initialize tool event listeners and functionality
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

      const modeEncode = container.querySelector('#modeEncode');
      const modeDecode = container.querySelector('#modeDecode');
      const encodeOptions = container.querySelector('#encodeOptions');
      const decodeOptions = container.querySelector('#decodeOptions');

      const input = container.querySelector('#input');
      const output = container.querySelector('#output');
      const processBtn = container.querySelector('#processBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const copyBtn = container.querySelector('#copyBtn');
      const loadSampleBtn = container.querySelector('#loadSampleBtn');
      const outputInfo = container.querySelector('#outputInfo');
      const modeInfo = container.querySelector('#modeInfo');

      const liveModeCheck = container.querySelector('#liveMode');
      const liveModeDecodeCheck = container.querySelector('#liveModeDecode');
      const encodeLinesCheck = container.querySelector('#encodeLines');
      const decodeLinesCheck = container.querySelector('#decodeLines');

      const parseInput = container.querySelector('#parseInput');
      const parseOutput = container.querySelector('#parseOutput');
      const parseBtn = container.querySelector('#parseBtn');

      let currentMode = 'encode';

      /**
       * Show element by removing d-none class
       *
       * @param {HTMLElement} el - Element to show
       */
      const show = (el) => el.classList.remove('d-none');

      /**
       * Hide element by adding d-none class
       *
       * @param {HTMLElement} el - Element to hide
       */
      const hide = (el) => el.classList.add('d-none');

      /**
       * Update UI based on current mode
       */
      function updateUI() {
        if (currentMode === 'encode') {
          show(encodeOptions);
          hide(decodeOptions);
          input.placeholder = t('tools.urlEncoderDecoder.encode_placeholder');
          output.placeholder = t('tools.urlEncoderDecoder.encode_output_placeholder');
          processBtn.innerHTML = '<i class="bi bi-arrow-right me-2"></i>' + t('tools.urlEncoderDecoder.encode_btn');
          updateModeInfo();
        } else {
          hide(encodeOptions);
          show(decodeOptions);
          input.placeholder = t('tools.urlEncoderDecoder.decode_placeholder');
          output.placeholder = t('tools.urlEncoderDecoder.decode_output_placeholder');
          processBtn.innerHTML = '<i class="bi bi-arrow-left me-2"></i>' + t('tools.urlEncoderDecoder.decode_btn');
          updateModeInfo();
        }
        input.value = '';
        output.value = '';
        outputInfo.textContent = '';
      }

      /**
       * Update mode information text
       */
      function updateModeInfo() {
        if (currentMode === 'encode') {
          const isComponent = container.querySelector('#encodeComponent').checked;
          if (isComponent) {
            modeInfo.innerHTML = '<small><strong>' + t('tools.urlEncoderDecoder.mode_component') + ':</strong> ' + t('tools.urlEncoderDecoder.component_info') + '</small>';
          } else {
            modeInfo.innerHTML = '<small><strong>' + t('tools.urlEncoderDecoder.mode_uri') + ':</strong> ' + t('tools.urlEncoderDecoder.uri_info') + '</small>';
          }
        } else {
          const isComponent = container.querySelector('#decodeComponent').checked;
          if (isComponent) {
            modeInfo.innerHTML = '<small><strong>' + t('tools.urlEncoderDecoder.mode_component') + ':</strong> ' + t('tools.urlEncoderDecoder.component_info') + '</small>';
          } else {
            modeInfo.innerHTML = '<small><strong>' + t('tools.urlEncoderDecoder.mode_uri') + ':</strong> ' + t('tools.urlEncoderDecoder.uri_info') + '</small>';
          }
        }
      }

      modeEncode.addEventListener('change', function() {
        if (this.checked) {
          currentMode = 'encode';
          updateUI();
        }
      });

      modeDecode.addEventListener('change', function() {
        if (this.checked) {
          currentMode = 'decode';
          updateUI();
        }
      });

      container.querySelectorAll('input[name="encodeMode"], input[name="decodeMode"]').forEach(radio => {
        radio.addEventListener('change', updateModeInfo);
      });

      /**
       * Encode URL using encodeURI or encodeURIComponent
       *
       * @param {string} str - Input string
       * @param {string} mode - Encoding mode ('uri' or 'component')
       * @param {boolean} lineByLine - Whether to process line by line
       * @returns {string} - Encoded URL
       * @throws {Error} - If encoding fails
       */
      function encodeURL(str, mode, lineByLine) {
        try {
          if (lineByLine) {
            return str.split('\n').map(line => {
              if (!line.trim()) return line;
              return mode === 'uri' ? encodeURI(line) : encodeURIComponent(line);
            }).join('\n');
          }
          return mode === 'uri' ? encodeURI(str) : encodeURIComponent(str);
        } catch (e) {
          throw new Error(t('tools.urlEncoderDecoder.encode_error'));
        }
      }

      /**
       * Decode URL using decodeURI or decodeURIComponent
       *
       * @param {string} str - Encoded string
       * @param {string} mode - Decoding mode ('uri' or 'component')
       * @param {boolean} lineByLine - Whether to process line by line
       * @returns {string} - Decoded URL
       * @throws {Error} - If decoding fails
       */
      function decodeURL(str, mode, lineByLine) {
        try {
          if (lineByLine) {
            return str.split('\n').map(line => {
              if (!line.trim()) return line;
              return mode === 'uri' ? decodeURI(line) : decodeURIComponent(line);
            }).join('\n');
          }
          return mode === 'uri' ? decodeURI(str) : decodeURIComponent(str);
        } catch (e) {
          throw new Error(t('tools.urlEncoderDecoder.decode_error'));
        }
      }

      processBtn.addEventListener('click', function () {
        const inputValue = input.value;
        if (!inputValue) {
          output.value = '';
          outputInfo.textContent = '';
          return;
        }

        try {
          if (currentMode === 'encode') {
            const mode = container.querySelector('#encodeURI').checked ? 'uri' : 'component';
            const lineByLine = encodeLinesCheck.checked;
            output.value = encodeURL(inputValue, mode, lineByLine);
            output.classList.remove('is-invalid');
            outputInfo.textContent = t('tools.urlEncoderDecoder.chars_encoded', {count: output.value.length});
          } else {
            const mode = container.querySelector('#decodeURI').checked ? 'uri' : 'component';
            const lineByLine = decodeLinesCheck.checked;
            output.value = decodeURL(inputValue, mode, lineByLine);
            output.classList.remove('is-invalid');
            outputInfo.textContent = t('tools.urlEncoderDecoder.chars_decoded', {count: output.value.length});
          }
        } catch (e) {
          output.value = t('tools.urlEncoderDecoder.error') + ': ' + e.message;
          output.classList.add('is-invalid');
          outputInfo.textContent = '';
        }
      });

      liveModeCheck.addEventListener('change', function () {
        if (this.checked && currentMode === 'encode' && input.value) processBtn.click();
      });

      liveModeDecodeCheck.addEventListener('change', function () {
        if (this.checked && currentMode === 'decode' && input.value) processBtn.click();
      });

      input.addEventListener('input', function () {
        if (currentMode === 'encode' && liveModeCheck.checked) {
          processBtn.click();
        } else if (currentMode === 'decode' && liveModeDecodeCheck.checked) {
          processBtn.click();
        }
      });

      clearBtn.addEventListener('click', function () {
        input.value = '';
        output.value = '';
        output.classList.remove('is-invalid');
        outputInfo.textContent = '';
      });

      loadSampleBtn.addEventListener('click', function () {
        if (currentMode === 'encode') {
          input.value = 'Hello World!\nSpecial chars: äöü ß € & = ? # /\nhttps://example.com/path?name=value';
          if (liveModeCheck.checked) processBtn.click();
        } else {
          input.value = 'Hello%20World%21%0ASpecial%20chars%3A%20%C3%A4%C3%B6%C3%BC%20%C3%9F%20%E2%82%AC%20%26%20%3D%20%3F%20%23%20%2F';
          if (liveModeDecodeCheck.checked) processBtn.click();
        }
      });

      parseBtn.addEventListener('click', function () {
        const urlInput = parseInput.value.trim();
        if (!urlInput) {
          parseOutput.innerHTML = '<p class="text-muted mb-0">' + t('tools.urlEncoderDecoder.parser_empty') + '</p>';
          return;
        }

        try {
          let url;
          try {
            url = new URL(urlInput);
          } catch (err) {
            if (!/^[a-zA-Z][a-zA-Z\d+\-.]*:/.test(urlInput)) {
              url = new URL('http://' + urlInput);
            } else {
              throw err;
            }
          }

          let html = '<div class="table-responsive"><table class="table table-sm mb-0">';
          html += '<tbody>';
          html += '<tr><th>' + t('tools.urlEncoderDecoder.protocol') + '</th><td><code>' + escapeHtml(url.protocol) + '</code></td></tr>';
          html += '<tr><th>' + t('tools.urlEncoderDecoder.host') + '</th><td><code>' + escapeHtml(url.host) + '</code></td></tr>';
          html += '<tr><th>' + t('tools.urlEncoderDecoder.hostname') + '</th><td><code>' + escapeHtml(url.hostname) + '</code></td></tr>';
          if (url.port) {
            html += '<tr><th>' + t('tools.urlEncoderDecoder.port') + '</th><td><code>' + escapeHtml(url.port) + '</code></td></tr>';
          }
          html += '<tr><th>' + t('tools.urlEncoderDecoder.pathname') + '</th><td><code>' + escapeHtml(url.pathname) + '</code></td></tr>';
          if (url.search) {
            html += '<tr><th>' + t('tools.urlEncoderDecoder.search') + '</th><td><code>' + escapeHtml(url.search) + '</code></td></tr>';
            html += '<tr><th colspan="2" class="bg-body-secondary"><strong>' + t('tools.urlEncoderDecoder.query_params') + '</strong></th></tr>';
            url.searchParams.forEach(function(value, key) {
              html += '<tr><td class="ps-4"><code>' + escapeHtml(key) + '</code></td><td><code>' + escapeHtml(value) + '</code></td></tr>';
            });
          }
          if (url.hash) {
            html += '<tr><th>' + t('tools.urlEncoderDecoder.hash') + '</th><td><code>' + escapeHtml(url.hash) + '</code></td></tr>';
          }
          html += '<tr><th>' + t('tools.urlEncoderDecoder.origin') + '</th><td><code>' + escapeHtml(url.origin) + '</code></td></tr>';
          html += '</tbody></table></div>';

          parseOutput.innerHTML = html;
        } catch (e) {
          parseOutput.innerHTML = '<div class="alert alert-danger mb-0">' + t('tools.urlEncoderDecoder.invalid_url') + ': ' + escapeHtml(e.message) + '</div>';
        }
      });

      copyBtn.addEventListener('click', async function () {
        if (output.value) {
          const success = await window.ClipboardUtils.copyToClipboard(output.value);
          
          if (success) {
            const icon = copyBtn.querySelector('i');
            if (icon) {
              icon.className = 'bi bi-check me-2';
              setTimeout(() => { icon.className = 'bi bi-clipboard me-2'; }, 2000);
            }
          }
        }
      });

      input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
          processBtn.click();
        }
      });

      parseInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          parseBtn.click();
        }
      });
    }
  });

})();
