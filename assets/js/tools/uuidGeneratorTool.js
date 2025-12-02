/**
 * UUID Generator Tool
 * 
 * Generates RFC4122-compliant UUIDs (v4) with bulk generation support.
 * Cryptographically secure random number generation via crypto.randomUUID().
 */
(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'uuidGeneratorTool'}) : '[uuidGeneratorTool] Tools registry not available.';
    console.warn(msg);
    return;
  }

  window.Tools.register('uuidGeneratorTool', {
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
      <div class="row g-4">
        <div class="col-12 col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-shuffle me-2"></i>${t('tools.uuidGeneratorTool.single_title')}</h2>

              <div class="mb-3">
                <label for="uuidVersion" class="form-label">${t('tools.uuidGeneratorTool.version_label')}</label>
                <select class="form-select form-select-sm" id="uuidVersion">
                  <option value="v4">${t('tools.uuidGeneratorTool.version_v4')}</option>
                  <option value="v1">${t('tools.uuidGeneratorTool.version_v1')}</option>
                  <option value="v7">${t('tools.uuidGeneratorTool.version_v7')}</option>
                  <option value="nil">${t('tools.uuidGeneratorTool.version_nil')}</option>
                </select>
                <small class="text-muted" id="versionHelp">${t('tools.uuidGeneratorTool.version_v4_help')}</small>
              </div>

              <div class="mb-3">
                <label for="uuidFormat" class="form-label">${t('tools.uuidGeneratorTool.format_label')}</label>
                <select class="form-select form-select-sm" id="uuidFormat">
                  <option value="hyphens">${t('tools.uuidGeneratorTool.format_hyphens')}</option>
                  <option value="no-hyphens">${t('tools.uuidGeneratorTool.format_no_hyphens')}</option>
                  <option value="braces">${t('tools.uuidGeneratorTool.format_braces')}</option>
                  <option value="uppercase">${t('tools.uuidGeneratorTool.format_uppercase')}</option>
                </select>
              </div>

              <button class="btn btn-primary btn-sm w-100 mb-3" id="generateSingle">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.uuidGeneratorTool.generate_btn')}
              </button>

              <div class="mb-3">
                <label class="form-label">${t('tools.uuidGeneratorTool.result_label')}</label>
                <div class="input-group">
                  <input type="text" class="form-control bg-body-secondary font-monospace" id="singleUuid" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="copySingle">
                    <i class="bi bi-clipboard"></i>
                  </button>
                </div>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="autoGenerate">
                <label class="form-check-label" for="autoGenerate">${t('tools.uuidGeneratorTool.auto_generate')}</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-list-ul me-2"></i>${t('tools.uuidGeneratorTool.bulk_title')}</h2>

              <div class="mb-3">
                <label for="bulkCount" class="form-label">${t('tools.uuidGeneratorTool.bulk_count_label')}</label>
                <input type="number" class="form-control form-control-sm" id="bulkCount" value="10" min="1" max="1000">
                <small class="text-muted">${t('tools.uuidGeneratorTool.bulk_count_help')}</small>
              </div>

              <div class="mb-3">
                <label for="bulkFormat" class="form-label">${t('tools.uuidGeneratorTool.bulk_format_label')}</label>
                <select class="form-select form-select-sm" id="bulkFormat">
                  <option value="plain">${t('tools.uuidGeneratorTool.format_plain')}</option>
                  <option value="array">${t('tools.uuidGeneratorTool.format_array')}</option>
                  <option value="json">${t('tools.uuidGeneratorTool.format_json')}</option>
                  <option value="csv">${t('tools.uuidGeneratorTool.format_csv')}</option>
                  <option value="sql">${t('tools.uuidGeneratorTool.format_sql')}</option>
                </select>
              </div>

              <button class="btn btn-primary btn-sm w-100 mb-3" id="generateBulk">
                <i class="bi bi-lightning me-2"></i>${t('tools.uuidGeneratorTool.generate_bulk_btn')}
              </button>

              <div class="mb-3">
                <textarea class="form-control bg-body-secondary font-monospace" id="bulkOutput" rows="10" readonly></textarea>
              </div>

              <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" id="copyBulk">
                  <i class="bi bi-clipboard me-2"></i>${t('tools.uuidGeneratorTool.copy_all_btn')}
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="downloadBulk">
                  <i class="bi bi-download me-2"></i>${t('tools.uuidGeneratorTool.download_btn')}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>`;

      this.initializeGenerator(container);
    },

    initializeGenerator: function(container) {
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        return key.split('.').pop();
      };

      const singleUuidInput = container.querySelector('#singleUuid');
      const uuidVersionSelect = container.querySelector('#uuidVersion');
      const uuidFormatSelect = container.querySelector('#uuidFormat');
      const versionHelp = container.querySelector('#versionHelp');
      const bulkCountInput = container.querySelector('#bulkCount');
      const bulkFormatSelect = container.querySelector('#bulkFormat');
      const bulkOutputTextarea = container.querySelector('#bulkOutput');
      const generateSingleBtn = container.querySelector('#generateSingle');
      const generateBulkBtn = container.querySelector('#generateBulk');
      const copySingleBtn = container.querySelector('#copySingle');
      const copyBulkBtn = container.querySelector('#copyBulk');
      const downloadBulkBtn = container.querySelector('#downloadBulk');
      const autoGenerateCheck = container.querySelector('#autoGenerate');

      /**
       * Generate UUID v4 (Random)
       *
       * Uses crypto.getRandomValues() for cryptographically secure random numbers.
       *
       * @returns {string} - UUID v4 string
       */
      function generateUUIDv4() {
        try {
          const bytes = new Uint8Array(16);
          crypto.getRandomValues(bytes);
          bytes[6] = (bytes[6] & 0x0f) | 0x40;
          bytes[8] = (bytes[8] & 0x3f) | 0x80;
          const hex = Array.from(bytes, b => ('0' + b.toString(16)).slice(-2)).join('');
          return `${hex.substring(0,8)}-${hex.substring(8,12)}-${hex.substring(12,16)}-${hex.substring(16,20)}-${hex.substring(20)}`;
        } catch (e) {
          throw new Error('UUID generation requires Web Crypto API (crypto.getRandomValues). This browser does not support cryptographically secure random number generation.');
        }
      }

      /**
       * Generate UUID v1 (Timestamp-based)
       *
       * Uses crypto.getRandomValues() for the random component (clock sequence and node ID).
       * Falls back to disabling v1 if crypto is unavailable.
       *
       * @returns {string} - UUID v1 string
       */
      function generateUUIDv1() {
        try {
          const d = new Date().getTime();
          const timeBytes = new Uint8Array(8);
          crypto.getRandomValues(timeBytes);
          
          // Timestamp (60-bit, 100ns intervals since 1582-10-15)
          const timestamp = (d * 10000) + 0x01B21DD213814000;
          
          // Build UUID v1: time_low-time_mid-time_hi_and_version-clock_seq-node
          const timeLow = (timestamp & 0xFFFFFFFF).toString(16).padStart(8, '0');
          const timeMid = ((timestamp >> 32) & 0xFFFF).toString(16).padStart(4, '0');
          const timeHiVersion = (((timestamp >> 48) & 0x0FFF) | 0x1000).toString(16).padStart(4, '0');
          
          // Clock sequence (14 bits) + variant bits
          const clockSeq = ((timeBytes[0] << 8 | timeBytes[1]) & 0x3FFF | 0x8000).toString(16).padStart(4, '0');
          
          // Node ID (48 bits from random)
          const node = Array.from(timeBytes.slice(2, 8), b => b.toString(16).padStart(2, '0')).join('');
          
          return `${timeLow}-${timeMid}-${timeHiVersion}-${clockSeq}-${node}`;
        } catch (e) {
          // If crypto is unavailable, throw error to disable v1 in UI
          throw new Error('UUID v1 requires Web Crypto API support');
        }
      }

      /**
       * Generate UUID v7 (Timestamp + Random)
       *
       * Includes millisecond timestamp in first 48 bits, then random data.
       *
       * @returns {string} - UUID v7 string
       */
      function generateUUIDv7() {
        try {
          const ts = Date.now();
          const tsBytes = new Uint8Array(6);
          let temp = ts;
          for (let i = 5; i >= 0; i--) {
            tsBytes[i] = temp & 0xff;
            temp = Math.floor(temp / 256);
          }
          const rand = new Uint8Array(10);
          crypto.getRandomValues(rand);
          const bytes = new Uint8Array(16);
          bytes.set(tsBytes, 0);
          bytes.set(rand, 6);
          bytes[6] = (bytes[6] & 0x0f) | 0x70;
          bytes[8] = (bytes[8] & 0x3f) | 0x80;
          const hex = Array.from(bytes, b => ('0' + b.toString(16)).slice(-2)).join('');
          return `${hex.substring(0,8)}-${hex.substring(8,12)}-${hex.substring(12,16)}-${hex.substring(16,20)}-${hex.substring(20)}`;
        } catch (e) {
          throw new Error('UUID v7 requires Web Crypto API support');
        }
      }

      /**
       * Generate Nil UUID (all zeros)
       *
       * @returns {string} - Nil UUID string
       */
      function generateNilUUID() {
        return '00000000-0000-0000-0000-000000000000';
      }

      /**
       * Generate UUID based on selected version
       *
       * @param {string} version - UUID version ('v1', 'v4', 'v7', 'nil')
       * @returns {string} - Generated UUID
       */
      function generateUUID(version) {
        switch(version) {
          case 'v1': return generateUUIDv1();
          case 'v7': return generateUUIDv7();
          case 'nil': return generateNilUUID();
          default: return generateUUIDv4();
        }
      }

      /**
       * Format UUID according to selected format
       *
       * @param {string} uuid - UUID to format
       * @param {string} format - Format type ('no-hyphens', 'braces', 'uppercase')
       * @returns {string} - Formatted UUID
       */
      function formatUUID(uuid, format) {
        switch(format) {
          case 'no-hyphens': return uuid.replace(/-/g, '');
          case 'braces': return `{${uuid}}`;
          case 'uppercase': return uuid.toUpperCase();
          default: return uuid;
        }
      }

      /**
       * Generate and format single UUID
       *
       * @returns {string} - Formatted UUID
       */
      function generateFormattedUUID() {
        const version = uuidVersionSelect.value;
        const format = uuidFormatSelect.value;
        const uuid = generateUUID(version);
        return formatUUID(uuid, format);
      }

      /**
       * Format multiple UUIDs according to output format
       *
       * @param {string[]} uuids - Array of UUIDs
       * @param {string} format - Output format ('array', 'json', 'csv', 'sql', 'plain')
       * @returns {string} - Formatted output
       */
      function formatBulkUUIDs(uuids, format) {
        switch(format) {
          case 'array':
            return `[\n  "${uuids.join('",\n  "')}"\n]`;
          case 'json':
            return JSON.stringify(uuids, null, 2);
          case 'csv':
            return uuids.join(',');
          case 'sql':
            return `INSERT INTO table_name (id) VALUES\n${uuids.map(u => `  ('${u}')`).join(',\n')};`;
          default:
            return uuids.join('\n');
        }
      }

      /**
       * Copy text to clipboard with visual feedback
       *
       * @param {string} text - Text to copy
       * @param {HTMLElement} button - Button element for visual feedback
       */
      async function copyToClipboard(text, button) {
        const success = await window.ClipboardUtils.copyToClipboard(text);
        
        if (success) {
          const icon = button.querySelector('i');
          if (icon) {
            icon.className = 'bi bi-check';
            setTimeout(() => { icon.className = 'bi bi-clipboard'; }, 2000);
          }
        }
      }

      /**
       * Update help text based on selected UUID version
       */
      function updateVersionHelp() {
        const version = uuidVersionSelect.value;
        const helpTexts = {
          'v4': t('tools.uuidGeneratorTool.version_v4_help'),
          'v1': t('tools.uuidGeneratorTool.version_v1_help'),
          'v7': t('tools.uuidGeneratorTool.version_v7_help'),
          'nil': t('tools.uuidGeneratorTool.version_nil_help')
        };
        versionHelp.textContent = helpTexts[version] || '';
      }

      uuidVersionSelect.addEventListener('change', () => {
        updateVersionHelp();
        if (autoGenerateCheck.checked) {
          try {
            singleUuidInput.value = generateFormattedUUID();
          } catch (e) {
            singleUuidInput.value = t('tools.uuidGeneratorTool.crypto_error');
            console.error('UUID generation failed:', e);
          }
        }
      });

      uuidFormatSelect.addEventListener('change', () => {
        if (autoGenerateCheck.checked) {
          try {
            singleUuidInput.value = generateFormattedUUID();
          } catch (e) {
            singleUuidInput.value = t('tools.uuidGeneratorTool.crypto_error');
            console.error('UUID generation failed:', e);
          }
        }
      });

      generateSingleBtn.addEventListener('click', () => {
        try {
          singleUuidInput.value = generateFormattedUUID();
        } catch (e) {
          singleUuidInput.value = t('tools.uuidGeneratorTool.crypto_error');
          console.error('UUID generation failed:', e);
        }
      });

      generateBulkBtn.addEventListener('click', () => {
        const count = parseInt(bulkCountInput.value, 10);
        if (isNaN(count) || count < 1 || count > 1000) {
          bulkOutputTextarea.value = t('tools.uuidGeneratorTool.bulk_error');
          return;
        }
        try {
          const version = uuidVersionSelect.value;
          const uuids = Array.from({length: count}, () => generateUUID(version));
          bulkOutputTextarea.value = formatBulkUUIDs(uuids, bulkFormatSelect.value);
        } catch (e) {
          bulkOutputTextarea.value = t('tools.uuidGeneratorTool.crypto_error');
          console.error('UUID bulk generation failed:', e);
        }
      });

      copySingleBtn.addEventListener('click', function() {
        copyToClipboard(singleUuidInput.value, this);
      });

      copyBulkBtn.addEventListener('click', function() {
        copyToClipboard(bulkOutputTextarea.value, this);
      });

      downloadBulkBtn.addEventListener('click', () => {
        if (!bulkOutputTextarea.value) return;
        const blob = new Blob([bulkOutputTextarea.value], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'uuids.txt';
        a.click();
        URL.revokeObjectURL(url);
      });

      bulkCountInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') generateBulkBtn.click();
      });

      singleUuidInput.value = generateFormattedUUID();
      generateBulkBtn.click();
    }
  });

})();
