/**
 * Base64 Encoder/Decoder Tool
 * 
 * Bidirectional Base64 encoding and decoding for text and files.
 * Supports UTF-8 text, file uploads (max 10MB), and binary data handling.
 */
(function () {
  'use strict';

  const MAX_FILE_SIZE = 10 * 1024 * 1024;

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'base64EncoderDecoder'}) : '[base64EncoderDecoder] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('base64EncoderDecoder', {
    init: function () {
    },

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
                  <h2 class="h5 card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.base64EncoderDecoder.input_title')}</h2>

                  <div class="btn-group btn-group-sm mb-3 w-100" role="group">
                    <input type="radio" class="btn-check" name="mode" id="modeEncode" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeEncode"><i class="bi bi-arrow-right me-1"></i>${t('tools.base64EncoderDecoder.encode_title')}</label>

                    <input type="radio" class="btn-check" name="mode" id="modeDecode" autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="modeDecode"><i class="bi bi-arrow-left me-1"></i>${t('tools.base64EncoderDecoder.decode_title')}</label>
                  </div>

                  <div class="drag-drop-area mb-3" id="dropArea">
                    <input type="file" id="fileInput" class="d-none">
                    <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                    <p class="mb-0">${t('tools.base64EncoderDecoder.drag_drop_hint')}</p>
                  </div>

                  <textarea class="form-control font-monospace mb-3" id="input" rows="12" placeholder="${t('tools.base64EncoderDecoder.encode_placeholder')}"></textarea>

                  <div class="d-flex flex-wrap gap-2 mb-2">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="processBtn"><i class="bi bi-arrow-right me-2"></i>${t('tools.base64EncoderDecoder.encode_btn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('tools.base64EncoderDecoder.clear_btn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('tools.base64EncoderDecoder.load_sample')}</button>
                  </div>

                  <div id="encodeOptions">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="autoEncode">
                      <label class="form-check-label" for="autoEncode">${t('tools.base64EncoderDecoder.auto_encode')}</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="urlSafe" checked>
                      <label class="form-check-label" for="urlSafe">${t('tools.base64EncoderDecoder.url_safe')}</label>
                  </div>
                </div>

                <div id="decodeOptions" class="d-none">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="autoDecode">
                    <label class="form-check-label" for="autoDecode">${t('tools.base64EncoderDecoder.auto_decode')}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="detectFormat" checked>
                    <label class="form-check-label" for="detectFormat">${t('tools.base64EncoderDecoder.detect_format')}</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="card-body">
                <h2 class="h5 card-title mb-3"><i class="bi bi-code-square me-2"></i>${t('tools.base64EncoderDecoder.output_title')}</h2>

                <div id="imagePreviewContainer" class="d-none mb-3">
                  <div class="border rounded p-3 bg-light text-center overflow-auto image-preview-box">
                    <img id="imagePreview" class="img-fluid" alt="Preview">
                  </div>
                  <small class="text-muted d-block mt-2">${t('tools.base64EncoderDecoder.image_preview')}</small>
                </div>
                  <textarea class="form-control bg-body-secondary font-monospace mb-3" id="output" rows="12" placeholder="${t('tools.base64EncoderDecoder.encode_output_placeholder')}"></textarea>

                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <small class="text-muted me-auto" id="outputInfo"></small>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyBtn"><i class="bi bi-clipboard me-2"></i>${t('tools.base64EncoderDecoder.copy_btn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="downloadBtn"><i class="bi bi-download me-2"></i>${t('tools.base64EncoderDecoder.download_btn')}</button>
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

      this.initializeTool(container);
    },

    initializeTool: function (container) {
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        return key.split('.').pop();
      };


      const toggleLayoutBtn = container.querySelector('#toggleLayoutBtn');
      const wrapper = container.querySelector('#inputOutputWrapper');

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

      const modeEncode = container.querySelector('#modeEncode');
      const modeDecode = container.querySelector('#modeDecode');
      const encodeOptions = container.querySelector('#encodeOptions');
      const decodeOptions = container.querySelector('#decodeOptions');

      const input = container.querySelector('#input');
      const output = container.querySelector('#output');
      const processBtn = container.querySelector('#processBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const copyBtn = container.querySelector('#copyBtn');
      const downloadBtn = container.querySelector('#downloadBtn');
      const loadSampleBtn = container.querySelector('#loadSampleBtn');
      const fileInput = container.querySelector('#fileInput');
      const dropArea = container.querySelector('#dropArea');
      const outputInfo = container.querySelector('#outputInfo');
      const imagePreviewContainer = container.querySelector('#imagePreviewContainer');
      const imagePreview = container.querySelector('#imagePreview');

      const autoEncodeCheck = container.querySelector('#autoEncode');
      const autoDecodeCheck = container.querySelector('#autoDecode');
      const urlSafeCheck = container.querySelector('#urlSafe');
      const detectFormatCheck = container.querySelector('#detectFormat');

      let currentMode = 'encode';
      let encodedFileName = 'file';
      let decodedFileName = 'decoded.txt';
      let decodedMimeType = 'text/plain';


      const show = (el) => el.classList.remove('d-none');
      const hide = (el) => el.classList.add('d-none');
      const isVisible = (el) => !el.classList.contains('d-none');

      /**
       * Update UI based on current mode (encode/decode)
       */
      function updateUI() {
        if (currentMode === 'encode') {
          show(encodeOptions);
          hide(decodeOptions);
          input.placeholder = t('tools.base64EncoderDecoder.encode_placeholder');
          output.placeholder = t('tools.base64EncoderDecoder.encode_output_placeholder');
          processBtn.innerHTML = '<i class="bi bi-arrow-right me-2"></i>' + t('tools.base64EncoderDecoder.encode_btn');
          fileInput.accept = '*/*';
          hide(imagePreviewContainer);
        } else {
          hide(encodeOptions);
          show(decodeOptions);
          input.placeholder = t('tools.base64EncoderDecoder.decode_placeholder');
          output.placeholder = t('tools.base64EncoderDecoder.decode_output_placeholder');
          processBtn.innerHTML = '<i class="bi bi-arrow-left me-2"></i>' + t('tools.base64EncoderDecoder.decode_btn');
          fileInput.accept = '.txt,.b64,text/*';
        }
        input.value = '';
        output.value = '';
        outputInfo.textContent = '';
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

      /**
       * Encode string to Base64
       *
       * @param {string} str - String to encode
       * @param {boolean} urlSafe - Whether to use URL-safe Base64 encoding
       * @returns {string} - Base64 encoded string
       */
      function encodeBase64(str, urlSafe) {
        try {
          const encoder = new TextEncoder();
          const bytes = encoder.encode(str);

          let binary = '';
          for (let i = 0; i < bytes.length; i++) {
            binary += String.fromCharCode(bytes[i]);
          }

          let encoded = btoa(binary);
          if (urlSafe) {
            encoded = encoded.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
          }
          return encoded;
        } catch (e) {
          throw new Error(t('tools.base64EncoderDecoder.encode_error'));
        }
      }

      /**
       * Decode Base64 string to UTF-8 text
       *
       * @param {string} str - Base64 string to decode
       * @param {boolean} urlSafe - Whether to decode URL-safe Base64
       * @returns {string} - Decoded string
       */
      function decodeBase64(str, urlSafe) {
        try {
          let base64 = str.trim();
          if (urlSafe) {
            base64 = base64.replace(/-/g, '+').replace(/_/g, '/');
            while (base64.length % 4) {
              base64 += '=';
            }
          }

          const binary = atob(base64);
          const bytes = new Uint8Array(binary.length);
          for (let i = 0; i < binary.length; i++) {
            bytes[i] = binary.charCodeAt(i);
          }

          const decoder = new TextDecoder();
          return decoder.decode(bytes);
        } catch (e) {
          throw new Error(t('tools.base64EncoderDecoder.decode_error'));
        }
      }

      /**
       * Detect Base64 format (standard, URL-safe, or data URL)
       *
       * @param {string} str - String to analyze
       * @returns {object} - { type: string, data: string, mimeType?: string }
       */
      function detectBase64Format(str) {
        const dataUrlMatch = str.match(/^data:([^;]+);base64,(.+)$/);
        if (dataUrlMatch) {
          return {
            type: 'data-url',
            mimeType: dataUrlMatch[1],
            data: dataUrlMatch[2]
          };
        }
        if (/^[A-Za-z0-9+/]*={0,2}$/.test(str.trim())) {
          return { type: 'standard', data: str.trim() };
        }
        if (/^[A-Za-z0-9_-]+$/.test(str.trim())) {
          return { type: 'url-safe', data: str.trim() };
        }
        return { type: 'unknown', data: str };
      }

      /**
       * Encode file to Base64
       *
       * Enforces max file size limit to prevent browser memory issues.
       *
       * @param {File} file - File object to encode
       */
      function encodeFile(file) {
        if (file.size > MAX_FILE_SIZE) {
          const maxSizeMB = (MAX_FILE_SIZE / (1024 * 1024)).toFixed(0);
          output.value = t('tools.base64EncoderDecoder.file_too_large', {maxSize: maxSizeMB}) ||
            `Error: File size exceeds ${maxSizeMB}MB limit. Please choose a smaller file.`;
          output.classList.add('is-invalid');
          outputInfo.textContent = t('tools.base64EncoderDecoder.current_size', {size: (file.size / (1024 * 1024)).toFixed(2)}) ||
            `Current file size: ${(file.size / (1024 * 1024)).toFixed(2)}MB`;
          hide(imagePreviewContainer);
          return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
          const base64 = btoa(Array.from(new Uint8Array(e.target.result))
            .map(byte => String.fromCharCode(byte)).join(''));

          output.value = urlSafeCheck.checked ?
            base64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '') :
            base64;

          output.classList.remove('is-invalid');
          encodedFileName = file.name;
          outputInfo.textContent = t('tools.base64EncoderDecoder.file_encoded', {filename: file.name, size: (file.size / 1024).toFixed(2)});
        };
        reader.onerror = function() {
          output.value = t('tools.base64EncoderDecoder.file_read_error') || 'Error: Could not read file.';
          output.classList.add('is-invalid');
          outputInfo.textContent = '';
        };
        reader.readAsArrayBuffer(file);
      }

      /**
       * Decode Base64 string to binary data
       *
       * Supports images (with preview), text files, and binary files.
       *
       * @param {string} base64Str - Base64 string to decode
       * @param {object} format - Format information from detectBase64Format()
       * @returns {Uint8Array} - Decoded binary data
       */
      function decodeToFile(base64Str, format) {
        try {
          let mimeType = 'application/octet-stream';
          let base64Data = base64Str;

          if (format.type === 'data-url') {
            mimeType = format.mimeType;
            base64Data = format.data;
          }

          let binary = atob(urlSafeCheck.checked ?
            base64Data.replace(/-/g, '+').replace(/_/g, '/') :
            base64Data);

          const bytes = new Uint8Array(binary.length);
          for (let i = 0; i < binary.length; i++) {
            bytes[i] = binary.charCodeAt(i);
          }

          decodedMimeType = mimeType;

          if (mimeType.startsWith('image/')) {
            const blob = new Blob([bytes], { type: mimeType });
            const url = URL.createObjectURL(blob);
            imagePreview.src = url;
            show(imagePreviewContainer);
            output.value = t('tools.base64EncoderDecoder.binary_preview_note');
            decodedFileName = 'image.' + mimeType.split('/')[1];
          } else if (mimeType.startsWith('text/')) {
            const text = new TextDecoder().decode(bytes);
            output.value = text;
            hide(imagePreviewContainer);
            decodedFileName = 'decoded.txt';
          } else {
            output.value = t('tools.base64EncoderDecoder.binary_file_note');
            hide(imagePreviewContainer);
            decodedFileName = 'decoded.bin';
          }

          outputInfo.textContent = t('tools.base64EncoderDecoder.detected_type', {type: mimeType});

          return bytes;
        } catch (e) {
          throw new Error(t('tools.base64EncoderDecoder.decode_error'));
        }
      }

      processBtn.addEventListener('click', function () {
        const inputValue = input.value;
        if (!inputValue) {
          output.value = '';
          hide(imagePreviewContainer);
          return;
        }

        try {
          if (currentMode === 'encode') {
            output.value = encodeBase64(inputValue, urlSafeCheck.checked);
            output.classList.remove('is-invalid');
            outputInfo.textContent = '';
          } else {
            const format = detectFormatCheck.checked ? detectBase64Format(inputValue) : { type: 'standard', data: inputValue };

            if (format.type === 'data-url' || /^[A-Za-z0-9+/=_-]{20,}/.test(inputValue)) {
              decodeToFile(inputValue, format);
            } else {
              output.value = decodeBase64(format.data, format.type === 'url-safe');
              hide(imagePreviewContainer);
              outputInfo.textContent = '';
            }
            output.classList.remove('is-invalid');
          }
        } catch (e) {
          output.value = t('tools.base64EncoderDecoder.error') + ': ' + e.message;
          output.classList.add('is-invalid');
          hide(imagePreviewContainer);
        }
      });

      autoEncodeCheck.addEventListener('change', function () {
        if (this.checked && currentMode === 'encode' && input.value) processBtn.click();
      });

      input.addEventListener('input', function () {
        if (currentMode === 'encode' && autoEncodeCheck.checked) {
          processBtn.click();
        } else if (currentMode === 'decode' && autoDecodeCheck.checked) {
          processBtn.click();
        }
      });

      autoDecodeCheck.addEventListener('change', function () {
        if (this.checked && currentMode === 'decode' && input.value) processBtn.click();
      });

      clearBtn.addEventListener('click', function () {
        input.value = '';
        output.value = '';
        output.classList.remove('is-invalid');
        outputInfo.textContent = '';
        hide(imagePreviewContainer);
      });

      loadSampleBtn.addEventListener('click', function () {
        if (currentMode === 'encode') {
          input.value = 'Hello World! This is a Base64 encoding example.\nSpecial characters: äöü ß € 你好';
          if (autoEncodeCheck.checked) processBtn.click();
        } else {
          input.value = 'SGVsbG8gV29ybGQhIFRoaXMgaXMgYSBCYXNlNjQgZW5jb2RpbmcgZXhhbXBsZS4KU3BlY2lhbCBjaGFyYWN0ZXJzOiDDpMO2w7wgw58g4oKsIOS9oOWlvQ==';
          if (autoDecodeCheck.checked) processBtn.click();
        }
      });

      /**
       * Prevent default drag and drop behavior
       *
       * @param {Event} e - Event object
       */
      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      dropArea.addEventListener('click', () => fileInput.click());

      fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
          if (currentMode === 'encode') {
            encodeFile(this.files[0]);
          } else {
            const reader = new FileReader();
            reader.onload = function(e) {
              input.value = e.target.result;
              if (autoDecodeCheck.checked) processBtn.click();
            };
            reader.readAsText(this.files[0]);
          }
        }
      });

      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
      });

      ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-over'));
      });

      ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-over'));
      });

      dropArea.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
          if (currentMode === 'encode') {
            encodeFile(files[0]);
          } else {
            const reader = new FileReader();
            reader.onload = function(e) {
              input.value = e.target.result;
              if (autoDecodeCheck.checked) processBtn.click();
            };
            reader.readAsText(files[0]);
          }
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

      downloadBtn.addEventListener('click', function () {
        if (!output.value && !imagePreview.src) return;

        if (imagePreview.src && isVisible(imagePreviewContainer)) {
          fetch(imagePreview.src)
            .then(res => res.blob())
            .then(blob => {
              const url = URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = decodedFileName;
              a.click();
              URL.revokeObjectURL(url);
            });
        } else {
          const filename = currentMode === 'encode' ? encodedFileName + '.b64' : decodedFileName;
          const blob = new Blob([output.value], { type: currentMode === 'encode' ? 'text/plain' : decodedMimeType });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = filename;
          a.click();
          URL.revokeObjectURL(url);
        }
      });
    }
  });

})();
