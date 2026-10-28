/**
 * Data Converter Tool
 *
 * Convert between JSON, XML, YAML, CSV formats and Unix timestamps.
 * Supports bidirectional conversion with customizable formatting options.
 */

(function() {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[dataConverterTool] Tools registry not available.');
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
   * Initialize the Data Converter Tool
   */
  function init() {
    // Create HTML template
    const container = document.getElementById('tool-container');
    if (!container) {
      console.error('Tool container not found');
      return;
    }

    container.innerHTML = `
      <div class="row g-3" id="mainRow">
        <!-- Controls -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="conversionType" class="form-label fw-bold">
                    <i class="bi bi-arrow-left-right me-2"></i>${t('tools.dataConverterTool.conversionLabel')}
                  </label>
                  <select class="form-select form-select-sm" id="conversionType">
                    <option value="jsonToXml">${t('tools.dataConverterTool.jsonToXml')}</option>
                    <option value="xmlToJson">${t('tools.dataConverterTool.xmlToJson')}</option>
                    <option value="jsonToYaml">${t('tools.dataConverterTool.jsonToYaml')}</option>
                    <option value="yamlToJson">${t('tools.dataConverterTool.yamlToJson')}</option>
                    <option value="jsonToCsv">${t('tools.dataConverterTool.jsonToCsv')}</option>
                    <option value="csvToJson">${t('tools.dataConverterTool.csvToJson')}</option>
                    <option value="timestampToDate">${t('tools.dataConverterTool.timestampToDate')}</option>
                    <option value="dateToTimestamp">${t('tools.dataConverterTool.dateToTimestamp')}</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3" id="indentationWrapper">
                  <label for="indentation" class="form-label fw-bold">
                    <i class="bi bi-text-indent-left me-2"></i>${t('tools.dataConverterTool.indentLabel')}
                  </label>
                  <select class="form-select form-select-sm" id="indentation">
                    <option value="2">${t('tools.dataConverterTool.indent2')}</option>
                    <option value="4">${t('tools.dataConverterTool.indent4')}</option>
                    <option value="tab">${t('tools.dataConverterTool.indentTab')}</option>
                    <option value="compact">${t('tools.dataConverterTool.compactMode')}</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-bold d-block">
                    <i class="bi bi-gear me-2"></i>${t('tools.dataConverterTool.autoConvert')}
                  </label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoConvert">
                    <label class="form-check-label" for="autoConvert">
                      ${t('tools.dataConverterTool.autoConvert')}
                    </label>
                  </div>
                </div>
              </div>

              <!-- Conversion Options -->
              <div id="conversionOptions" class="mt-3">
                <!-- XML Options -->
                <div id="xmlOptions" class="conversion-option-group d-none">
                  <div class="row g-2">
                    <div class="col-md-6">
                      <label for="xmlRootElement" class="form-label">${t('tools.dataConverterTool.xmlRootElement')}</label>
                      <input type="text" class="form-control form-control-sm" id="xmlRootElement" value="root" placeholder="${t('tools.dataConverterTool.xmlRootPlaceholder')}">
                    </div>
                    <div class="col-md-6">
                      <label for="xmlItemElement" class="form-label">${t('tools.dataConverterTool.xmlItemElement')}</label>
                      <input type="text" class="form-control form-control-sm" id="xmlItemElement" value="item" placeholder="${t('tools.dataConverterTool.xmlItemPlaceholder')}">
                    </div>
                  </div>
                </div>

                <!-- CSV Options -->
                <div id="csvOptions" class="conversion-option-group d-none">
                  <div class="row g-2">
                    <div class="col-md-4">
                      <label for="csvDelimiter" class="form-label">${t('tools.dataConverterTool.csvDelimiter')}</label>
                      <select class="form-select form-select-sm" id="csvDelimiter">
                        <option value=",">${t('tools.dataConverterTool.csvComma')}</option>
                        <option value=";">${t('tools.dataConverterTool.csvSemicolon')}</option>
                        <option value="	">${t('tools.dataConverterTool.csvTab')}</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label d-block">&nbsp;</label>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="csvHasHeader" checked>
                        <label class="form-check-label" for="csvHasHeader">
                          ${t('tools.dataConverterTool.csvHasHeader')}
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Timestamp Options -->
                <div id="timestampOptions" class="conversion-option-group d-none">
                  <div class="row g-2 align-items-center">
                    <div class="col-auto">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timestampUnit" id="timestampSeconds" value="seconds" checked>
                        <label class="form-check-label" for="timestampSeconds">
                          ${t('tools.dataConverterTool.timestampSeconds')}
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timestampUnit" id="timestampMs" value="milliseconds">
                        <label class="form-check-label" for="timestampMs">
                          ${t('tools.dataConverterTool.timestampMilliseconds')}
                        </label>
                      </div>
                    </div>
                    <div class="col-auto ms-auto">
                      <small class="text-secondary">
                        ${t('tools.dataConverterTool.currentTimestamp')}:
                        <span id="currentTimestampSeconds" class="fw-bold">-</span> s /
                        <span id="currentTimestampMs" class="fw-bold">-</span> ms
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Input/Output Areas with Toggle Button -->
        <div class="col-12 position-relative" id="inputOutputWrapper">
          <div class="row g-3">
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="h6 fw-semibold card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.dataConverterTool.input_title')}</p>

                  <textarea
                    class="form-control font-monospace mb-3"
                    id="inputData"
                    rows="15"
                    placeholder="${t('tools.dataConverterTool.inputPlaceholder')}"
                  ></textarea>

                  <div class="d-flex flex-wrap gap-2 mb-2">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="convertBtn"><i class="bi bi-arrow-left-right me-2"></i>${t('tools.dataConverterTool.convertBtn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('common.clear')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('common.load_sample')}</button>
                  </div>

                  <small class="text-muted" id="inputStats">0 ${t('tools.dataConverterTool.lines')}, 0 ${t('tools.dataConverterTool.characters')}</small>
                  <div id="conversionStatus" class="alert mt-2 d-none" aria-live="polite"></div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="h6 fw-semibold card-title mb-3"><i class="bi bi-arrow-right me-2"></i>${t('tools.dataConverterTool.output_title')}</p>

                  <textarea
                    class="form-control bg-body-secondary font-monospace mb-3"
                    id="outputData"
                    rows="15"
                    placeholder="${t('tools.dataConverterTool.outputPlaceholder')}"
                    readonly
                  ></textarea>

                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <small class="text-muted me-auto" id="outputStats">0 ${t('tools.dataConverterTool.lines')}, 0 ${t('tools.dataConverterTool.characters')}</small>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyOutput"><i class="bi bi-clipboard me-2"></i>${t('common.copy')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="downloadOutput"><i class="bi bi-download me-2"></i>Download</button>
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

    const conversionType = document.getElementById('conversionType');
    const inputArea = document.getElementById('inputData');
    const outputArea = document.getElementById('outputData');
    const convertBtn = document.getElementById('convertBtn');
    const clearBtn = document.getElementById('clearBtn');
    const loadSampleBtn = document.getElementById('loadSampleBtn');
    const autoConvert = document.getElementById('autoConvert');
    const indentationSelect = document.getElementById('indentation');

    // Layout toggle functionality
    const toggleLayoutBtn = document.getElementById('toggleLayoutBtn');
    const wrapper = document.getElementById('inputOutputWrapper');

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

    /**
     * Update UI based on selected conversion type
     */
    function updateUI() {
      const type = conversionType.value;

      // Hide all option groups first
      document.querySelectorAll('.conversion-option-group').forEach(el => {
        el.classList.add('d-none');
      });

      // Show relevant options based on conversion type
      if (type === 'jsonToXml' || type === 'xmlToJson') {
        document.getElementById('xmlOptions')?.classList.remove('d-none');
        document.getElementById('indentationWrapper')?.classList.remove('d-none');
      } else if (type === 'csvToJson' || type === 'jsonToCsv') {
        document.getElementById('csvOptions')?.classList.remove('d-none');
        document.getElementById('indentationWrapper')?.classList.remove('d-none');
      } else if (type === 'timestampToDate' || type === 'dateToTimestamp') {
        document.getElementById('timestampOptions')?.classList.remove('d-none');
        document.getElementById('indentationWrapper')?.classList.add('d-none');
      } else {
        document.getElementById('indentationWrapper')?.classList.remove('d-none');
      }

      // Update placeholders
      updatePlaceholders(type);
    }

    /**
     * Update input/output placeholders based on conversion type
     *
     * @param {string} type - Conversion type
     */
    function updatePlaceholders(type) {
      const placeholders = {
        'jsonToXml': { input: '{"name": "value"}', output: '<root><name>value</name></root>' },
        'xmlToJson': { input: '<root><name>value</name></root>', output: '{"name": "value"}' },
        'jsonToYaml': { input: '{"name": "value"}', output: 'name: value' },
        'yamlToJson': { input: 'name: value', output: '{"name": "value"}' },
        'jsonToCsv': { input: '[{"name":"John","age":30}]', output: 'name,age\nJohn,30' },
        'csvToJson': { input: 'name,age\nJohn,30', output: '[{"name":"John","age":"30"}]' },
        'timestampToDate': { input: '1699272000', output: '2023-11-06 12:00:00 UTC' },
        'dateToTimestamp': { input: '2023-11-06 12:00:00 UTC', output: '1699272000' }
      };

      if (placeholders[type]) {
        inputArea.placeholder = placeholders[type].input;
        outputArea.placeholder = placeholders[type].output;
      }
    }

    /**
     * Conversion functions for each format pair
     */
    const converters = {
      /**
       * Convert JSON to XML
       *
       * @param {string} input - JSON string
       * @returns {string} - XML string
       * @throws {Error} - If JSON is invalid
       */
      jsonToXml: (input) => {
        const obj = JSON.parse(input);
        const rootName = document.getElementById('xmlRootElement')?.value || 'root';
        const itemName = document.getElementById('xmlItemElement')?.value || 'item';
        // A top-level array has no natural root; wrap it so the XML is well-formed
        const wrapped = Array.isArray(obj) ? { [itemName]: obj } : obj;
        return jsonToXml(wrapped, rootName, itemName);
      },

      /**
       * Convert XML to JSON
       *
       * @param {string} input - XML string
       * @returns {string} - JSON string
       * @throws {Error} - If XML is invalid
       */
      xmlToJson: (input) => {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(input, 'text/xml');

        if (xmlDoc.getElementsByTagName('parsererror').length > 0) {
          throw new Error('Invalid XML format');
        }

        const obj = xmlToJson(xmlDoc.documentElement);
        const indent = getIndentation();
        return JSON.stringify(obj, null, indent);
      },

      /**
       * Convert JSON to YAML
       *
       * @param {string} input - JSON string
       * @returns {string} - YAML string
       * @throws {Error} - If JSON is invalid
       */
      jsonToYaml: (input) => {
        const obj = JSON.parse(input);
        return jsonToYaml(obj, 0);
      },

      /**
       * Convert YAML to JSON
       *
       * @param {string} input - YAML string
       * @returns {string} - JSON string
       * @throws {Error} - If YAML is invalid
       */
      yamlToJson: (input) => {
        const obj = yamlToJson(input);
        const indent = getIndentation();
        return JSON.stringify(obj, null, indent);
      },

      /**
       * Convert JSON to CSV
       *
       * @param {string} input - JSON string (must be array of objects)
       * @returns {string} - CSV string
       * @throws {Error} - If JSON is not an array of objects
       */
      jsonToCsv: (input) => {
        const data = JSON.parse(input);
        if (!Array.isArray(data) || data.length === 0) {
          throw new Error('JSON must be an array of objects');
        }
        return jsonToCsv(data);
      },

      /**
       * Convert CSV to JSON
       *
       * @param {string} input - CSV string
       * @returns {string} - JSON string
       * @throws {Error} - If CSV is invalid
       */
      csvToJson: (input) => {
        const delimiter = document.getElementById('csvDelimiter')?.value || ',';
        const hasHeader = document.getElementById('csvHasHeader')?.checked !== false;
        const data = csvToJson(input, delimiter, hasHeader);
        const indent = getIndentation();
        return JSON.stringify(data, null, indent);
      },

      /**
       * Convert Unix timestamp to date string
       *
       * @param {string} input - Timestamp string (seconds or milliseconds)
       * @returns {string} - ISO date string
       * @throws {Error} - If timestamp is invalid
       */
      timestampToDate: (input) => {
        const timestamp = parseInt(input.trim(), 10);
        if (isNaN(timestamp)) {
          throw new Error('Invalid timestamp');
        }

        const unit = document.querySelector('input[name="timestampUnit"]:checked')?.value || 'seconds';
        const ms = unit === 'milliseconds' ? timestamp : timestamp * 1000;
        const date = new Date(ms);

        return date.toISOString().replace('T', ' ').substring(0, 19) + ' UTC';
      },

      /**
       * Convert date string to Unix timestamp
       *
       * @param {string} input - Date string
       * @returns {string} - Timestamp string
       * @throws {Error} - If date format is invalid
       */
      dateToTimestamp: (input) => {
        // Dates without a zone are read as UTC, matching the UTC output of
        // timestampToDate so that both directions round-trip.
        const raw = input.trim().replace(/\s*(UTC|GMT|Z)$/i, '');
        const plain = raw.match(/^(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/);
        let timestamp;
        if (plain) {
          timestamp = Date.UTC(+plain[1], +plain[2] - 1, +plain[3], +(plain[4] || 0), +(plain[5] || 0), +(plain[6] || 0));
        } else {
          timestamp = new Date(input.trim()).getTime();
        }
        if (isNaN(timestamp)) {
          throw new Error('Invalid date format');
        }

        const unit = document.querySelector('input[name="timestampUnit"]:checked')?.value || 'seconds';

        return unit === 'milliseconds' ? timestamp.toString() : Math.floor(timestamp / 1000).toString();
      }
    };

    /**
     * Get indentation setting
     *
     * @returns {string|number} - Tab character or number of spaces
     */
    function getIndentation() {
      const value = indentationSelect?.value || '2';
      if (value === 'tab') return '\t';
      if (value === 'compact') return 0;
      return parseInt(value, 10);
    }

    /**
     * Convert JSON object to XML string
     *
     * @param {*} obj - Object to convert
     * @param {string} rootName - Root element name
     * @param {string} itemName - Array item element name
     * @param {number} indent - Indentation level
     * @returns {string} - XML string
     */
    function jsonToXml(obj, rootName = 'root', itemName = 'item', indent = 0) {
      const spaces = '  '.repeat(indent);

      if (obj === null || obj === undefined) {
        return `${spaces}<${rootName}/>`;
      }

      if (typeof obj !== 'object') {
        return `${spaces}<${rootName}>${escapeXml(String(obj))}</${rootName}>`;
      }

      if (Array.isArray(obj)) {
        let xml = '';
        obj.forEach(item => {
          xml += jsonToXml(item, itemName, itemName, indent) + '\n';
        });
        return xml.trimEnd();
      }

      let xml = `${spaces}<${rootName}>`;
      const keys = Object.keys(obj);

      if (keys.length > 0) {
        xml += '\n';
        keys.forEach(key => {
          if (Array.isArray(obj[key])) {
            obj[key].forEach(item => {
              xml += jsonToXml(item, key, itemName, indent + 1) + '\n';
            });
          } else {
            xml += jsonToXml(obj[key], key, itemName, indent + 1) + '\n';
          }
        });
        xml += spaces;
      }

      xml += `</${rootName}>`;
      return xml;
    }

    /**
     * Convert XML DOM to JSON object
     *
     * @param {Element} xml - XML DOM element
     * @returns {object} - JSON object
     */
    function xmlToJson(xml) {
      const obj = {};

      if (xml.nodeType === 1) { // Element
        if (xml.attributes.length > 0) {
          obj['@attributes'] = {};
          for (let i = 0; i < xml.attributes.length; i++) {
            const attr = xml.attributes.item(i);
            obj['@attributes'][attr.nodeName] = attr.nodeValue;
          }
        }
      } else if (xml.nodeType === 3) { // Text
        return xml.nodeValue;
      }

      if (xml.hasChildNodes()) {
        for (let i = 0; i < xml.childNodes.length; i++) {
          const child = xml.childNodes.item(i);
          const nodeName = child.nodeName;

          if (typeof obj[nodeName] === 'undefined') {
            const converted = xmlToJson(child);
            if (nodeName === '#text') {
              return converted;
            }
            obj[nodeName] = converted;
          } else {
            if (typeof obj[nodeName].push === 'undefined') {
              const old = obj[nodeName];
              obj[nodeName] = [];
              obj[nodeName].push(old);
            }
            obj[nodeName].push(xmlToJson(child));
          }
        }
      }

      return obj;
    }

    /**
     * Convert JSON object to YAML string
     *
     * @param {*} obj - Object to convert
     * @param {number} indent - Indentation level
     * @returns {string} - YAML string
     */
    /**
     * Render a scalar as a YAML value, quoting it where a YAML parser would
     * otherwise read it as a number, boolean, null or structure
     *
     * @param {*} value - Scalar value
     * @returns {string} - YAML scalar
     */
    function yamlScalar(value) {
      if (value === null || value === undefined) return 'null';
      if (typeof value === 'number' || typeof value === 'boolean') return String(value);

      const str = String(value);
      const needsQuotes =
        str === '' ||
        /^\s|\s$/.test(str) ||
        /[:#\n"'\\]/.test(str) ||
        /^[-?!&*@`|>%{}[\],]/.test(str) ||
        /^[\d.+-]/.test(str) ||
        /^(true|false|null|yes|no|on|off|y|n|~)$/i.test(str);

      return needsQuotes ? JSON.stringify(str) : str;
    }

    /**
     * Check whether a value is an object or array with no entries
     *
     * @param {*} value - Value to check
     * @returns {boolean} - True for {} and []
     */
    function isEmptyContainer(value) {
      return Array.isArray(value) ? value.length === 0 : Object.keys(value).length === 0;
    }

    /**
     * Convert a JSON value to a block-style YAML document
     *
     * Every line is returned already indented for its level, so nested
     * structures line up without post-processing.
     *
     * @param {*} obj - Value to convert
     * @param {number} indent - Indentation level (two spaces per level)
     * @returns {string} - YAML text
     */
    function jsonToYaml(obj, indent = 0) {
      const pad = '  '.repeat(indent);

      if (Array.isArray(obj)) {
        if (obj.length === 0) return pad + '[]';
        return obj.map(item => {
          if (item !== null && typeof item === 'object' && !isEmptyContainer(item)) {
            // Render the item one level deeper, then hoist its first line onto the dash
            const nested = jsonToYaml(item, indent + 1);
            return pad + '- ' + nested.slice(pad.length + 2);
          }
          const scalar = item !== null && typeof item === 'object'
            ? (Array.isArray(item) ? '[]' : '{}')
            : yamlScalar(item);
          return pad + '- ' + scalar;
        }).join('\n');
      }

      if (obj !== null && typeof obj === 'object') {
        const keys = Object.keys(obj);
        if (keys.length === 0) return pad + '{}';
        return keys.map(key => {
          const value = obj[key];
          const k = yamlScalar(key);
          if (value !== null && typeof value === 'object') {
            if (isEmptyContainer(value)) {
              return `${pad}${k}: ${Array.isArray(value) ? '[]' : '{}'}`;
            }
            return `${pad}${k}:\n${jsonToYaml(value, indent + 1)}`;
          }
          return `${pad}${k}: ${yamlScalar(value)}`;
        }).join('\n');
      }

      return pad + yamlScalar(obj);
    }

    /**
     * Remove a trailing " # comment" from a YAML line, ignoring '#' inside quotes
     *
     * @param {string} text - Trimmed line
     * @returns {string} - Line without comment
     */
    function stripYamlComment(text) {
      let quote = null;
      for (let i = 0; i < text.length; i++) {
        const ch = text[i];
        if (quote) {
          if (ch === quote) quote = null;
        } else if (ch === '"' || ch === "'") {
          quote = ch;
        } else if (ch === '#' && (i === 0 || /\s/.test(text[i - 1]))) {
          return text.slice(0, i).trimEnd();
        }
      }
      return text;
    }

    /**
     * Split a "key: value" line, honouring quoted keys and colons inside values
     *
     * @param {string} text - Trimmed line
     * @returns {{key: string, value: string}|null} - Parts, or null if not a mapping entry
     */
    function splitYamlEntry(text) {
      const m = text.match(/^("(?:[^"\\]|\\.)*"|'(?:[^']|'')*'|[^:#]+?)\s*:(?:\s+(.*))?$/);
      if (!m) return null;
      return { key: parseYamlValue(m[1].trim()), value: (m[2] || '').trim() };
    }

    /**
     * Convert YAML text to a JSON value
     *
     * Supports block mappings, block sequences (scalars, mappings, nested
     * sequences), empty flow collections, simple flow lists, quoted strings
     * and comments. Anchors, multi-line scalars and multi-document files are
     * out of scope.
     *
     * @param {string} yaml - YAML text
     * @returns {*} - Parsed value
     * @throws {Error} - On lines that cannot be interpreted
     */
    function yamlToJson(yaml) {
      const items = yaml.split('\n')
        .map(line => line.replace(/\r$/, '').replace(/\t/g, '  '))
        .filter(line => line.trim() && !line.trim().startsWith('#') && line.trim() !== '---' && line.trim() !== '...')
        .map(line => ({ indent: line.search(/\S/), text: stripYamlComment(line.trim()) }));

      if (items.length === 0) return {};

      let pos = 0;

      const isSeqItem = (item) => item.text === '-' || item.text.startsWith('- ');

      function parseBlock() {
        return isSeqItem(items[pos]) ? parseSequence(items[pos].indent) : parseMapping(items[pos].indent);
      }

      function parseSequence(indent) {
        const arr = [];
        while (pos < items.length && items[pos].indent === indent && isSeqItem(items[pos])) {
          const item = items[pos];
          const rest = item.text === '-' ? '' : item.text.slice(2).trim();

          if (rest === '') {
            pos++;
            arr.push(pos < items.length && items[pos].indent > indent ? parseBlock() : null);
          } else if (isSeqItem({ text: rest }) || splitYamlEntry(rest)) {
            // "- key: value" or "- - x": re-read the remainder as its own line
            // positioned where it starts, so following lines attach to it.
            const childIndent = indent + item.text.length - rest.length;
            items[pos] = { indent: childIndent, text: rest };
            arr.push(parseBlock());
          } else {
            pos++;
            arr.push(parseYamlValue(rest));
          }
        }
        return arr;
      }

      function parseMapping(indent) {
        const obj = {};
        while (pos < items.length && items[pos].indent === indent && !isSeqItem(items[pos])) {
          const item = items[pos];
          const entry = splitYamlEntry(item.text);
          if (!entry) {
            throw new Error(`Invalid YAML near "${item.text}"`);
          }
          pos++;

          if (entry.value === '') {
            if (pos < items.length && items[pos].indent > indent) {
              obj[entry.key] = parseBlock();
            } else if (pos < items.length && items[pos].indent === indent && isSeqItem(items[pos])) {
              // Sequences may sit at the same indentation as their key
              obj[entry.key] = parseSequence(indent);
            } else {
              obj[entry.key] = null;
            }
          } else {
            obj[entry.key] = parseYamlValue(entry.value);
          }
        }
        return obj;
      }

      const root = parseBlock();
      if (pos < items.length) {
        throw new Error(`Invalid YAML indentation near "${items[pos].text}"`);
      }
      return root;
    }

    /**
     * Parse YAML value to appropriate JavaScript type
     *
     * @param {string} value - YAML value string
     * @returns {*} - Parsed value
     */
    function parseYamlValue(value) {
      if (value === 'null' || value === '~' || value === '') return null;
      if (value === 'true') return true;
      if (value === 'false') return false;
      if (value === '[]') return [];
      if (value === '{}') return {};
      if (/^-?\d+$/.test(value)) return parseInt(value, 10);
      if (/^-?\d+\.\d+(e[+-]?\d+)?$/i.test(value)) return parseFloat(value);
      if (value.startsWith('"') && value.endsWith('"') && value.length >= 2) {
        try {
          return JSON.parse(value);
        } catch (e) {
          return value.substring(1, value.length - 1).replace(/\\"/g, '"');
        }
      }
      if (value.startsWith("'") && value.endsWith("'") && value.length >= 2) {
        return value.substring(1, value.length - 1).replace(/''/g, "'");
      }
      if (value.startsWith('[') && value.endsWith(']')) {
        return value.slice(1, -1).split(',').map(v => v.trim()).filter(v => v !== '').map(parseYamlValue);
      }
      return value;
    }

    /**
     * Convert JSON array to CSV string
     *
     * @param {Array<object>} data - Array of objects
     * @returns {string} - CSV string
     * @throws {Error} - If data is not a valid array or is empty
     */
    function jsonToCsv(data) {
      // Validate input
      if (!Array.isArray(data)) {
        throw new Error('CSV conversion requires an array of objects');
      }
      
      if (data.length === 0) {
        return ''; // Empty CSV for empty array
      }
      
      if (typeof data[0] !== 'object' || data[0] === null) {
        throw new Error('CSV conversion requires an array of objects (got: ' + typeof data[0] + ')');
      }
      
      const delimiter = document.getElementById('csvDelimiter')?.value || ',';
      const headers = Object.keys(data[0]);

      let csv = headers.map(h => escapeCsvField(h, delimiter)).join(delimiter) + '\n';

      data.forEach(row => {
        csv += headers.map(h => escapeCsvField(String(row[h] ?? ''), delimiter)).join(delimiter) + '\n';
      });

      return csv.trimEnd();
    }

    /**
     * Convert CSV string to JSON array
     *
     * @param {string} csv - CSV string
     * @param {string} delimiter - Field delimiter
     * @param {boolean} hasHeader - Whether CSV has header row
     * @returns {Array<object>} - Array of objects
     */
    function csvToJson(csv, delimiter = ',', hasHeader = true) {
      const rows = parseCsv(csv, delimiter);
      if (rows.length === 0) return [];

      const headers = hasHeader ? rows[0] : null;
      const startIndex = hasHeader ? 1 : 0;

      return rows.slice(startIndex).map((values) => {
        const obj = {};

        values.forEach((value, i) => {
          const key = headers ? headers[i] : `column${i + 1}`;
          obj[key] = value;
        });

        return obj;
      });
    }

    /**
     * Parse CSV text into rows of fields (RFC 4180)
     *
     * Quoted fields may contain the delimiter, doubled quotes and line breaks,
     * so the text is scanned as a whole rather than line by line.
     *
     * @param {string} text - CSV text
     * @param {string} delimiter - Field delimiter
     * @returns {Array<Array<string>>} - Rows of field values
     */
    function parseCsv(text, delimiter) {
      const rows = [];
      let row = [];
      let field = '';
      let inQuotes = false;

      for (let i = 0; i < text.length; i++) {
        const char = text[i];

        if (inQuotes) {
          if (char === '"') {
            if (text[i + 1] === '"') {
              field += '"';
              i++;
            } else {
              inQuotes = false;
            }
          } else {
            field += char;
          }
        } else if (char === '"' && field === '') {
          inQuotes = true;
        } else if (char === delimiter) {
          row.push(field);
          field = '';
        } else if (char === '\n' || char === '\r') {
          if (char === '\r' && text[i + 1] === '\n') i++;
          row.push(field);
          rows.push(row);
          row = [];
          field = '';
        } else {
          field += char;
        }
      }

      row.push(field);
      rows.push(row);

      // Drop blank lines
      return rows.filter(r => r.length > 1 || r[0].trim() !== '');
    }

    /**
     * Escape CSV field value
     *
     * Security: Prevents CSV injection by wrapping fields with special characters.
     *
     * @param {string} field - Field value
     * @param {string} delimiter - Field delimiter
     * @returns {string} - Escaped field value
     */
    function escapeCsvField(field, delimiter) {
      if (field.includes(delimiter) || field.includes('"') || field.includes('\n')) {
        return `"${field.replace(/"/g, '""')}"`;
      }
      return field;
    }

    /**
     * Escape XML special characters
     *
     * @param {string} str - String to escape
     * @returns {string} - XML-escaped string
     */
    function escapeXml(str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&apos;');
    }

    /**
     * Perform data conversion based on selected type
     */
    function performConversion() {
      const type = conversionType.value;
      const input = inputArea.value.trim();

      if (!input) {
        outputArea.value = '';
        updateStats('', '');
        return;
      }

      try {
        const converter = converters[type];
        if (!converter) {
          throw new Error('Unknown conversion type');
        }

        const output = converter(input);
        outputArea.value = output;
        updateStats(input, output);

        // Show success message briefly
        showStatus(t('tools.dataConverterTool.conversionSuccess'), 'success');
      } catch (error) {
        outputArea.value = '';
        updateStats(input, '');
        showStatus(t('tools.dataConverterTool.errorConvert') + ': ' + error.message, 'error');
      }
    }

    /**
     * Update input/output statistics display
     *
     * @param {string} input - Input text
     * @param {string} output - Output text
     */
    function updateStats(input, output) {
      const inputLines = input ? input.split('\n').length : 0;
      const inputChars = input.length;
      const outputLines = output ? output.split('\n').length : 0;
      const outputChars = output.length;

      document.getElementById('inputStats').textContent =
        `${inputLines} ${t('tools.dataConverterTool.lines')}, ${inputChars} ${t('tools.dataConverterTool.characters')}`;
      document.getElementById('outputStats').textContent =
        `${outputLines} ${t('tools.dataConverterTool.lines')}, ${outputChars} ${t('tools.dataConverterTool.characters')}`;
    }

    /**
     * Show status message
     *
     * @param {string} message - Status message
     * @param {string} type - Message type ('success' or 'error')
     */
    function showStatus(message, type) {
      const statusEl = document.getElementById('conversionStatus');
      if (!statusEl) return;

      statusEl.textContent = message;
      statusEl.className = `alert alert-${type === 'error' ? 'danger' : 'success'} mt-2`;
      statusEl.classList.remove('d-none');

      setTimeout(() => {
        statusEl.classList.add('d-none');
      }, 3000);
    }

    /**
     * Display current Unix timestamp
     */
    function showCurrentTimestamp() {
      const now = Date.now();
      const seconds = Math.floor(now / 1000);

      document.getElementById('currentTimestampSeconds').textContent = seconds;
      document.getElementById('currentTimestampMs').textContent = now;
    }

    conversionType.addEventListener('change', () => {
      updateUI();
      if (autoConvert.checked) {
        performConversion();
      }
    });

    convertBtn.addEventListener('click', performConversion);

    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        inputArea.value = '';
        outputArea.value = '';
        const statusEl = document.getElementById('conversionStatus');
        if (statusEl) {
          statusEl.textContent = '';
          statusEl.classList.add('d-none');
        }
        updateStats('', '');
      });

      loadSampleBtn.addEventListener('click', () => {
        const type = conversionType.value;
        const samples = {
          jsonToXml: '{"name":"John Doe","age":30,"email":"john@example.com","address":{"street":"Main St","city":"Berlin","country":"Germany"},"hobbies":["coding","reading"]}',
          xmlToJson: '<person><name>John Doe</name><age>30</age><email>john@example.com</email><address><street>Main St</street><city>Berlin</city><country>Germany</country></address></person>',
          jsonToYaml: '{"name":"John Doe","age":30,"active":true,"address":{"city":"Berlin","country":"Germany"},"hobbies":["coding","reading"]}',
          yamlToJson: 'name: John Doe\nage: 30\nactive: true\naddress:\n  city: Berlin\n  country: Germany\nhobbies:\n  - coding\n  - reading',
          jsonToCsv: '[{"name":"John Doe","age":30,"email":"john@example.com"},{"name":"Jane Smith","age":25,"email":"jane@example.com"}]',
          csvToJson: 'name,age,email\nJohn Doe,30,john@example.com\nJane Smith,25,jane@example.com',
          timestampToDate: '1699272000',
          dateToTimestamp: '2023-11-06 12:00:00'
        };
        inputArea.value = samples[type] || samples.jsonToXml;
        if (autoConvert.checked) {
          performConversion();
        }
      });
    }

    inputArea.addEventListener('input', () => {
      if (autoConvert.checked) {
        performConversion();
      }
    });

    autoConvert.addEventListener('change', () => {
      if (autoConvert.checked) {
        performConversion();
      }
    });

    indentationSelect?.addEventListener('change', () => {
      if (autoConvert.checked) {
        performConversion();
      }
    });

    document.getElementById('copyOutput')?.addEventListener('click', async () => {
      const text = outputArea.value;
      if (!text) return;

      try {
        if (window.ClipboardUtils) {
          await window.ClipboardUtils.copyToClipboard(text);
        } else {
          await navigator.clipboard.writeText(text);
        }
        showStatus('Copied to clipboard!', 'success');
      } catch (error) {
        showStatus('Failed to copy', 'error');
      }
    });

    document.getElementById('downloadOutput')?.addEventListener('click', () => {
      const text = outputArea.value;
      if (!text) return;

      const type = conversionType.value;
      const extensions = {
        'jsonToXml': 'xml', 'xmlToJson': 'json', 'jsonToYaml': 'yml',
        'yamlToJson': 'json', 'jsonToCsv': 'csv', 'csvToJson': 'json',
        'timestampToDate': 'txt', 'dateToTimestamp': 'txt'
      };

      const filename = `converted.${extensions[type] || 'txt'}`;

      if (window.DownloadUtils) {
        window.DownloadUtils.downloadText(text, filename);
      } else {
        const blob = new Blob([text], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
      }
    });

    if (document.getElementById('currentTimestampSeconds')) {
      showCurrentTimestamp();
      setInterval(showCurrentTimestamp, 1000);
    }

    updateUI();
    updateStats('', '');
  }

  if (window.Tools) {
    window.Tools.register('dataConverterTool', {
      /**
       * Open the Data Converter Tool
       *
       * @param {HTMLElement} container - Container element to render the tool
       */
      open: init
    });
  } else {
    console.error('Tools registry not found');
  }
})();
