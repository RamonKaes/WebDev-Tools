/**
 * JSON Formatter/Validator Tool
 *
 * Format, validate, and minify JSON with drag-and-drop file support.
 * Includes tree view, path extractor, size limits, and auto-fix capabilities.
 */

(function () {
  'use strict';

  /**
   * JSON processing limits
   */
  const JSON_LIMITS = {
    WARNING_SIZE: 1024 * 1024,
    MAX_SIZE: 5 * 1024 * 1024,
    MAX_TREE_DEPTH: 50,
    MAX_TREE_NODES: 10000
  };

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

  /**
   * Check JSON size against limits
   *
   * @param {string} jsonString - JSON string to check
   * @returns {object} - Object with allowed, size, warning, message properties
   */
  const checkJSONSize = (jsonString) => {
    const size = new Blob([jsonString]).size;
    if (size > JSON_LIMITS.MAX_SIZE) {
      return {
        allowed: false,
        size,
        warning: true,
        message: `File too large (${(size / 1024 / 1024).toFixed(2)} MB). Maximum size is ${JSON_LIMITS.MAX_SIZE / 1024 / 1024} MB.`
      };
    }
    if (size > JSON_LIMITS.WARNING_SIZE) {
      return {
        allowed: true,
        size,
        warning: true,
        message: `Large file (${(size / 1024 / 1024).toFixed(2)} MB). Processing may be slow.`
      };
    }
    return { allowed: true, size, warning: false, message: null };
  };

  /**
   * Calculate maximum depth of nested JSON structure
   *
   * @param {*} obj - Object to analyze
   * @param {number} currentDepth - Current recursion depth
   * @returns {number} - Maximum depth
   */
  const getJSONDepth = (obj, currentDepth = 0) => {
    if (currentDepth > JSON_LIMITS.MAX_TREE_DEPTH) return currentDepth;
    if (obj === null || typeof obj !== 'object') return currentDepth;
    let maxDepth = currentDepth;
    for (const key in obj) {
      if (obj.hasOwnProperty(key)) {
        const depth = getJSONDepth(obj[key], currentDepth + 1);
        maxDepth = Math.max(maxDepth, depth);
      }
    }
    return maxDepth;
  };

  /**
   * Count total nodes in JSON structure
   *
   * @param {*} obj - Object to analyze
   * @param {number} maxCount - Maximum node count threshold
   * @returns {number} - Total node count
   */
  const countJSONNodes = (obj, maxCount = JSON_LIMITS.MAX_TREE_NODES) => {
    let count = 0;
    function traverse(node) {
      if (count >= maxCount) return;
      count++;
      if (node !== null && typeof node === 'object') {
        for (const key in node) {
          if (node.hasOwnProperty(key)) traverse(node[key]);
        }
      }
    }
    traverse(obj);
    return count;
  };

  /**
   * Check if JSON tree can be rendered based on complexity limits
   *
   * @param {*} parsedJSON - Parsed JSON object
   * @returns {object} - Object with allowed and reason properties
   */
  const canRenderJSONTree = (parsedJSON) => {
    const depth = getJSONDepth(parsedJSON);
    if (depth > JSON_LIMITS.MAX_TREE_DEPTH) {
      return {
        allowed: false,
        reason: `JSON too deeply nested (${depth} levels). Maximum depth is ${JSON_LIMITS.MAX_TREE_DEPTH}.`
      };
    }
    const nodeCount = countJSONNodes(parsedJSON);
    if (nodeCount > JSON_LIMITS.MAX_TREE_NODES) {
      return {
        allowed: false,
        reason: `JSON too complex (${nodeCount} nodes). Maximum is ${JSON_LIMITS.MAX_TREE_NODES} nodes.`
      };
    }
    return { allowed: true, reason: null };
  };

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function') ? window.i18n.t('errors.registry_missing', {tool: 'jsonFormatterValidator'}) : '[jsonFormatterValidator] Tools registry not available.';
    console.warn(msg);
    return;
  };

  window.Tools.register('jsonFormatterValidator', {
    /**
     * Initialize the JSON Formatter/Validator Tool
     */
    init: function () {
      // no-op
    },

    /**
     * Open the JSON Formatter/Validator Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      // i18n translation helper with fallback
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        // Fallback: return the last part of the key (e.g., 'jsonFormatterValidator.title' -> 'title')
        return key.split('.').pop();
      };

      // Render UI
  container.innerHTML = `
      <div class="row g-4" id="mainRow">
        <div class="col-12 position-relative" id="inputOutputWrapper">
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.jsonFormatterValidator.input_title')}</h2>
                  <div class="drag-drop-area mb-3" id="dropArea">
                    <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                    <p class="mb-0">${t('tools.jsonFormatterValidator.drag_drop_hint')}</p>
                  </div>
                  <textarea id="jsonInput" rows="12" class="form-control font-monospace mb-3" placeholder="${t('tools.jsonFormatterValidator.input_placeholder')}"></textarea>

                  <div class="d-flex flex-wrap gap-2 mb-2">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="formatBtn"><i class="bi bi-indent me-2"></i>${t('tools.jsonFormatterValidator.btn_format')}</button>
                    <button class="btn btn-sm btn-outline-primary" id="validateBtn">${t('tools.jsonFormatterValidator.btn_validate')}</button>
                    <button class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" id="minifyBtn"><i class="bi bi-dash-square me-2"></i>${t('tools.jsonFormatterValidator.btn_minify')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('tools.jsonFormatterValidator.btn_clear')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('tools.jsonFormatterValidator.btn_load_sample')}</button>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="autoFixCheck">
                    <label class="form-check-label" for="autoFixCheck">${t('tools.jsonFormatterValidator.auto_fix_label')}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sortKeysCheck">
                    <label class="form-check-label" for="sortKeysCheck">${t('tools.jsonFormatterValidator.sort_keys_label')}</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-code-square me-2"></i>${t('tools.jsonFormatterValidator.output_title')}</h2>

                  <div class="btn-group btn-group-sm mb-3 w-100" role="group">
                    <input type="radio" class="btn-check" name="viewMode" id="viewText" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="viewText"><i class="bi bi-file-text me-1"></i>${t('tools.jsonFormatterValidator.view_text')}</label>

                    <input type="radio" class="btn-check" name="viewMode" id="viewTree" autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" for="viewTree"><i class="bi bi-diagram-3 me-1"></i>${t('tools.jsonFormatterValidator.view_tree')}</label>
                  </div>

                  <textarea id="jsonOutput" rows="12" class="form-control bg-body-secondary font-monospace mb-3" placeholder="${t('tools.jsonFormatterValidator.output_placeholder')}"></textarea>
                  <div id="jsonTree" class="json-tree-container hidden mb-3"></div>

                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <label class="form-label me-2 mb-0">${t('tools.jsonFormatterValidator.indentation_label')}:</label>
                    <select class="form-select form-select-sm d-inline-block w-auto" id="indentSelect">
                      <option value="2">${t('tools.jsonFormatterValidator.indent_2_spaces')}</option>
                      <option value="4" selected>${t('tools.jsonFormatterValidator.indent_4_spaces')}</option>
                      <option value="tab">${t('tools.jsonFormatterValidator.indent_tab')}</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" id="copyBtn"><i class="bi bi-clipboard me-2"></i>${t('tools.jsonFormatterValidator.btn_copy')}</button>
                    <button class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" id="downloadBtn"><i class="bi bi-download me-2"></i>${t('tools.jsonFormatterValidator.btn_download')}</button>
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

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-info-circle me-2"></i>${t('tools.jsonFormatterValidator.status_title')}</h2>
              <div id="statusOutput"><p class="text-muted mb-0">${t('tools.jsonFormatterValidator.status_initial')}</p></div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <h2 class="h5 mb-2">${t('tools.jsonFormatterValidator.path_extractor_title')}</h2>
                  <div class="input-group input-group-sm mb-2">
                    <input type="text" class="form-control font-monospace" id="jsonPath" placeholder="${t('tools.jsonFormatterValidator.path_placeholder')}">
                    <button class="btn btn-outline-primary btn-sm" id="extractPathBtn">${t('tools.jsonFormatterValidator.btn_extract')}</button>
                  </div>
                  <div id="pathResult" class="mt-2"></div>
                </div>

                <div class="col-md-6">
                  <h2 class="h5 mb-2">${t('tools.jsonFormatterValidator.escape_title')}</h2>
                  <div class="d-flex gap-2 mb-2">
                    <button class="btn btn-sm btn-outline-primary" id="escapeBtn">${t('tools.jsonFormatterValidator.btn_escape')}</button>
                    <button class="btn btn-sm btn-outline-primary" id="unescapeBtn">${t('tools.jsonFormatterValidator.btn_unescape')}</button>
                  </div>
                  <small class="text-muted">${t('tools.jsonFormatterValidator.escape_description')}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      `;

      // initialize listeners
      this.initializeTool(container);
    },

    /**
     * Initialize tool event listeners and functionality
     *
     * @param {HTMLElement} container - Container element
     */
    initializeTool: function (container) {
      // i18n translation helper with fallback
      const t = (key, params) => {
        if (window.i18n && typeof window.i18n.t === 'function') {
          return window.i18n.t(key, params);
        }
        // Fallback: return the last part of the key
        return key.split('.').pop();
      };

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

      const jsonInput = container.querySelector('#jsonInput');
      const jsonOutput = container.querySelector('#jsonOutput');
      const jsonTree = container.querySelector('#jsonTree');
      const statusOutput = container.querySelector('#statusOutput');
      const indentSelect = container.querySelector('#indentSelect');
      const formatBtn = container.querySelector('#formatBtn');
      const validateBtn = container.querySelector('#validateBtn');
      const minifyBtn = container.querySelector('#minifyBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const loadSampleBtn = container.querySelector('#loadSampleBtn');
      const downloadBtn = container.querySelector('#downloadBtn');
      const copyBtn = container.querySelector('#copyBtn');
      const jsonPath = container.querySelector('#jsonPath');
      var extractPathBtn = container.querySelector('#extractPathBtn');
      var pathResult = container.querySelector('#pathResult');
      var escapeBtn = container.querySelector('#escapeBtn');
      var unescapeBtn = container.querySelector('#unescapeBtn');
      var autoFixCheck = container.querySelector('#autoFixCheck');
      var sortKeysCheck = container.querySelector('#sortKeysCheck');
      var dropArea = container.querySelector('#dropArea');
      var viewTextRadio = container.querySelector('#viewText');
      var viewTreeRadio = container.querySelector('#viewTree');

      var currentParsedJSON = null;

      // Drag & Drop functionality
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
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

      ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-over'), false);
      });

      ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-over'), false);
      });

      dropArea.addEventListener('drop', handleDrop, false);
      dropArea.addEventListener('click', function() {
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = '.json,application/json';
        input.onchange = function(e) {
          handleFiles(e.target.files);
        };
        input.click();
      });

      /**
       * Handle dropped files
       *
       * @param {Event} e - Drop event
       */
      function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
      }

      /**
       * Read and load JSON file content
       *
       * Security: Uses textContent for filename to prevent XSS.
       *
       * @param {FileList} files - Files to process
       */
      function handleFiles(files) {
        if (files.length === 0) return;
        const file = files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
          jsonInput.value = e.target.result;
          const messageElement = document.createElement('p');
          messageElement.className = 'text-info mb-0';
          const icon = document.createElement('i');
          icon.className = 'bi bi-check-circle me-2';
          messageElement.appendChild(icon);
          messageElement.appendChild(document.createTextNode(t('tools.jsonFormatterValidator.file_loaded', {filename: file.name})));
          statusOutput.innerHTML = '';
          statusOutput.appendChild(messageElement);
        };
        reader.onerror = function() {
          statusOutput.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-2"></i>${t('tools.jsonFormatterValidator.file_error')}</div>`;
        };
        reader.readAsText(file);
      }

      /**
       * Get indentation setting from UI
       *
       * @returns {string|number} - Tab character or number of spaces
       */
      function getIndent() {
      }

      // View mode toggle
      viewTextRadio.addEventListener('change', function() {
        if (this.checked) {
          jsonOutput.classList.remove('d-none');
          jsonTree.classList.add('d-none');
        }
      });

      viewTreeRadio.addEventListener('change', function() {
        if (this.checked) {
          jsonOutput.classList.add('d-none');
          jsonTree.classList.remove('d-none');
          if (currentParsedJSON) {
            renderTreeView(currentParsedJSON, jsonTree);
          }
        }
      });

      function getIndent() {
        var val = indentSelect.value;
        return val === 'tab' ? '\t' : parseInt(val, 10) || 2;
      }

      /**
       * Format bytes to human-readable size
       *
       * @param {number} bytes - Byte count
       * @returns {string} - Formatted size string
       */
      function formatBytes(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
      }

      /**
       * Count objects, arrays, and total keys in JSON
       *
       * @param {*} obj - Object to analyze
       * @returns {object} - Object with total, objects, arrays properties
       */
      function countKeys(obj) {
        var result = { total: 0, objects: 0, arrays: 0 };
        function count(o) {
          if (Array.isArray(o)) {
            result.arrays++;
            o.forEach(count);
          } else if (o !== null && typeof o === 'object') {
            result.objects++;
            Object.keys(o).forEach(function (k) {
              result.total++;
              count(o[k]);
            });
          }
        }
        count(obj);
        return result;
      }

      /**
       * Calculate maximum nesting depth
       *
       * @param {*} obj - Object to analyze
       * @returns {number} - Maximum depth
       */
      function getDepth(obj) {
        if (obj === null || typeof obj !== 'object') return 0;
        return 1 + Math.max(0, ...Object.values(obj).map(getDepth));
      }

      /**
       * Extract value from JSON using dot or bracket notation path
       *
       * @param {*} obj - JSON object
       * @param {string} path - Path like 'user.name' or 'items[0]'
       * @returns {*} - Extracted value
       * @throws {Error} - If path not found
       */
      function extractJSONPath(obj, path) {
        var parts = path.split(/\.|\[|\]/).filter(Boolean);
        var current = obj;
        for (var i = 0; i < parts.length; i++) {
          var part = parts[i];
          if (current === null || current === undefined) {
            throw new Error(t('tools.jsonFormatterValidator.path_not_found', {path: path}));
          }
          current = current[part];
        }
        if (current === undefined) throw new Error(t('tools.jsonFormatterValidator.path_not_found', {path: path}));
        return current;
      }

      /**
       * Attempt to auto-fix common JSON errors
       *
       * @param {string} str - Invalid JSON string
       * @returns {string} - Auto-fixed JSON string
       */
      function autoFixJSON(str) {
        let fixed = str;

        // Remove comments (single-line and multi-line)
        fixed = fixed.replace(/\/\*[\s\S]*?\*\//g, '');
        fixed = fixed.replace(/\/\/.*/g, '');

        // Fix single quotes to double quotes for strings
        fixed = fixed.replace(/'([^']*)'/g, '"$1"');

        // Add quotes to unquoted keys
        fixed = fixed.replace(/(\w+)(\s*:\s*)/g, '"$1"$2');

        // Remove trailing commas
        fixed = fixed.replace(/,(\s*[}\]])/g, '$1');

        // Fix NaN, Infinity to null
        fixed = fixed.replace(/\bNaN\b/g, 'null');
        fixed = fixed.replace(/\bInfinity\b/g, 'null');

        // Lowercase true, false, null
        fixed = fixed.replace(/\bTrue\b/g, 'true');
        fixed = fixed.replace(/\bFalse\b/g, 'false');
        fixed = fixed.replace(/\bNull\b/g, 'null');

        return fixed;
      }

      /**
       * Sort object keys recursively
       *
       * @param {*} obj - Object to sort
       * @returns {*} - Object with sorted keys
       */
      function sortObjectKeys(obj) {
        if (Array.isArray(obj)) {
          return obj.map(sortObjectKeys);
        } else if (obj !== null && typeof obj === 'object') {
          const sorted = {};
          Object.keys(obj).sort().forEach(key => {
            sorted[key] = sortObjectKeys(obj[key]);
          });
          return sorted;
        }
        return obj;
      }

      /**
       * Render JSON as interactive tree view
       *
       * @param {*} data - JSON data
       * @param {HTMLElement} container - Container element
       */
      function renderTreeView(data, container) {
        container.innerHTML = '';
        const tree = buildTreeNode(data, '', true);
        container.appendChild(tree);
      }

      /**
       * Build tree node element
       *
       * @param {*} data - Node data
       * @param {string} key - Node key
       * @param {boolean} isRoot - Whether this is root node
       * @returns {HTMLElement} - Tree node element
       */
      function buildTreeNode(data, key, isRoot = false) {
        const wrapper = document.createElement('div');
        if (!isRoot) wrapper.className = 'json-tree-item';

        if (Array.isArray(data)) {
          const toggle = document.createElement('span');
          toggle.className = 'json-tree-toggle';
          toggle.textContent = '▼';

          const keySpan = document.createElement('span');
          if (key) {
            keySpan.className = 'json-tree-key';
            keySpan.textContent = key + ': ';
          }

          const bracket = document.createElement('span');
          bracket.textContent = `[${data.length}]`;

          const content = document.createElement('div');
          content.className = 'json-tree-content';

          data.forEach((item, idx) => {
            content.appendChild(buildTreeNode(item, `[${idx}]`));
          });

          if (key) wrapper.appendChild(keySpan);
          wrapper.appendChild(toggle);
          wrapper.appendChild(bracket);
          wrapper.appendChild(content);

          toggle.addEventListener('click', function() {
            const isHidden = content.classList.contains('d-none');
            if (isHidden) {
              content.classList.remove('d-none');
              toggle.textContent = '▼';
            } else {
              content.classList.add('d-none');
              toggle.textContent = '▶';
            }
          });
        } else if (data !== null && typeof data === 'object') {
          const toggle = document.createElement('span');
          toggle.className = 'json-tree-toggle';
          toggle.textContent = '▼';

          const keySpan = document.createElement('span');
          if (key) {
            keySpan.className = 'json-tree-key';
            keySpan.textContent = key + ': ';
          }

          const bracket = document.createElement('span');
          bracket.textContent = `{${Object.keys(data).length}}`;

          const content = document.createElement('div');
          content.className = 'json-tree-content';

          Object.keys(data).forEach(k => {
            content.appendChild(buildTreeNode(data[k], k));
          });

          if (key) wrapper.appendChild(keySpan);
          wrapper.appendChild(toggle);
          wrapper.appendChild(bracket);
          wrapper.appendChild(content);

          toggle.addEventListener('click', function() {
            const isHidden = content.classList.contains('d-none');
            if (isHidden) {
              content.classList.remove('d-none');
              toggle.textContent = '▼';
            } else {
              content.classList.add('d-none');
              toggle.textContent = '▶';
            }
          });
        } else {
          const keySpan = document.createElement('span');
          if (key) {
            keySpan.className = 'json-tree-key';
            keySpan.textContent = key + ': ';
            wrapper.appendChild(keySpan);
          }

          const valueSpan = document.createElement('span');
          if (typeof data === 'string') {
            valueSpan.className = 'json-tree-string';
            valueSpan.textContent = '"' + data + '"';
          } else if (typeof data === 'number') {
            valueSpan.className = 'json-tree-number';
            valueSpan.textContent = data;
          } else if (typeof data === 'boolean') {
            valueSpan.className = 'json-tree-boolean';
            valueSpan.textContent = data;
          } else if (data === null) {
            valueSpan.className = 'json-tree-null';
            valueSpan.textContent = 'null';
          }
          wrapper.appendChild(valueSpan);
        }

        return wrapper;
      }

      // Event handlers
      formatBtn.addEventListener('click', function () {
        var input = jsonInput.value.trim();
        if (!input) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_input')}</p>`;
          return;
        }

        // Check JSON size before processing
        const sizeCheck = checkJSONSize(input);
        if (!sizeCheck.allowed) {
          statusOutput.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-exclamation-triangle me-2"></i><strong>${t('tools.jsonFormatterValidator.error')}</strong><br>${sizeCheck.message}</div>`;
          return;
        }
        if (sizeCheck.warning) {
          console.warn('Large JSON detected:', sizeCheck.message);
        }

        try {
          // Apply auto-fix if enabled
          if (autoFixCheck.checked) {
            input = autoFixJSON(input);
          }

          var parsed = JSON.parse(input);

          // Check if tree rendering is feasible
          const treeCheck = canRenderJSONTree(parsed);
          if (!treeCheck.allowed) {
            console.warn('Tree view disabled:', treeCheck.reason);
          }

          // Apply sort if enabled
          if (sortKeysCheck.checked) {
            parsed = sortObjectKeys(parsed);
          }

          currentParsedJSON = parsed;
          var formatted = JSON.stringify(parsed, null, getIndent());
          jsonOutput.value = formatted;

          var size = new Blob([formatted]).size;
          var keys = countKeys(parsed);
          var sizeWarning = sizeCheck.warning ? `<br><small class="text-warning">⚠️ ${sizeCheck.message}</small>` : '';
          var treeWarning = !treeCheck.allowed ? `<br><small class="text-warning">⚠️ Tree view disabled: ${treeCheck.reason}</small>` : '';
          statusOutput.innerHTML = `<div class="alert alert-success mb-0"><i class="bi bi-check-circle me-2"></i><strong>✅ ${t('tools.jsonFormatterValidator.valid_json')}</strong><br><small>${t('tools.jsonFormatterValidator.size')}: ${formatBytes(size)} | ${t('tools.jsonFormatterValidator.objects')}: ${keys.objects} | ${t('tools.jsonFormatterValidator.arrays')}: ${keys.arrays} | ${t('tools.jsonFormatterValidator.total_keys')}: ${keys.total}</small>${sizeWarning}${treeWarning}</div>`;

          // Update tree view if it's active and feasible
          if (viewTreeRadio.checked && treeCheck.allowed) {
            renderTreeView(parsed, jsonTree);
          }
        } catch (e) {
          jsonOutput.value = '';
          currentParsedJSON = null;
          statusOutput.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-2"></i><strong>❌ ${t('tools.jsonFormatterValidator.invalid_json')}</strong><br><small>${escapeHtml(e.message)}</small></div>`;
        }
      });

      validateBtn.addEventListener('click', function () {
        var input = jsonInput.value.trim();
        if (!input) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_input')}</p>`;
          return;
        }
        try {
          // Apply auto-fix if enabled
          if (autoFixCheck.checked) {
            input = autoFixJSON(input);
          }

          var parsed = JSON.parse(input);
          currentParsedJSON = parsed;
          var size = new Blob([input]).size;
          var keys = countKeys(parsed);
          var depth = getDepth(parsed);
          statusOutput.innerHTML = `<div class="alert alert-success mb-0"><i class="bi bi-check-circle me-2"></i><strong>✅ ${t('tools.jsonFormatterValidator.valid_json')}</strong><br><small>${t('tools.jsonFormatterValidator.size')}: ${formatBytes(size)} | ${t('tools.jsonFormatterValidator.type')}: ${Array.isArray(parsed) ? 'Array' : typeof parsed} | ${t('tools.jsonFormatterValidator.total_keys')}: ${keys.total} | ${t('tools.jsonFormatterValidator.max_depth')}: ${depth}</small></div>`;
        } catch (e) {
          currentParsedJSON = null;
          statusOutput.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-2"></i><strong>❌ ${t('tools.jsonFormatterValidator.invalid_json')}</strong><br><small>${escapeHtml(e.message)}</small></div>`;
        }
      });

      minifyBtn.addEventListener('click', function () {
        var input = jsonInput.value.trim();
        if (!input) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_input')}</p>`;
          return;
        }
        try {
          // Apply auto-fix if enabled
          if (autoFixCheck.checked) {
            input = autoFixJSON(input);
          }

          var parsed = JSON.parse(input);

          // Apply sort if enabled
          if (sortKeysCheck.checked) {
            parsed = sortObjectKeys(parsed);
          }

          currentParsedJSON = parsed;
          var minified = JSON.stringify(parsed);
          jsonOutput.value = minified;
          var originalSize = new Blob([input]).size;
          var minifiedSize = new Blob([minified]).size;
          var saved = ((1 - minifiedSize / originalSize) * 100).toFixed(1);
          statusOutput.innerHTML = `<div class="alert alert-success mb-0"><i class="bi bi-check-circle me-2"></i><strong>✅ ${t('tools.jsonFormatterValidator.minified')}</strong><br><small>${t('tools.jsonFormatterValidator.original')}: ${formatBytes(originalSize)} → ${t('tools.jsonFormatterValidator.minified')}: ${formatBytes(minifiedSize)} (${saved}% ${t('tools.jsonFormatterValidator.saved')})</small></div>`;
        } catch (e) {
          jsonOutput.value = '';
          currentParsedJSON = null;
          statusOutput.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-2"></i><strong>❌ ${t('tools.jsonFormatterValidator.invalid_json')}</strong><br><small>${escapeHtml(e.message)}</small></div>`;
        }
      });

      clearBtn.addEventListener('click', function () {
        jsonInput.value = '';
        jsonOutput.value = '';
        jsonTree.innerHTML = '';
        statusOutput.innerHTML = `<p class="text-muted mb-0">${t('tools.jsonFormatterValidator.status_initial')}</p>`;
        currentParsedJSON = null;
      });

      loadSampleBtn.addEventListener('click', function () {
        var sample = {
          name: 'John Doe',
          age: 30,
          email: 'max@example.com',
          active: true,
          address: { street: 'Main St 1', city: 'Berlin', zip: '10115', country: 'DE' },
          hobbies: ['Coding', 'Gaming', 'Music'],
          metadata: { created: '2024-01-15T10:30:00Z', updated: '2024-10-25T14:20:00Z' }
        };
        jsonInput.value = JSON.stringify(sample, null, 2);
        statusOutput.innerHTML = `<p class="text-info mb-0"><i class="bi bi-info-circle me-2"></i>${t('tools.jsonFormatterValidator.sample_loaded')}</p>`;
      });

      downloadBtn.addEventListener('click', function () {
        if (!jsonOutput.value) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_output_download')}</p>`;
          return;
        }
        var blob = new Blob([jsonOutput.value], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'formatted.json';
        a.click();
        URL.revokeObjectURL(url);
        statusOutput.innerHTML = `<p class="text-success mb-0"><i class="bi bi-check-circle me-2"></i>${t('tools.jsonFormatterValidator.downloaded')}</p>`;
      });

      copyBtn.addEventListener('click', async function () {
        if (!jsonOutput.value) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_output_copy')}</p>`;
          return;
        }
        
        const success = await window.ClipboardUtils.copyToClipboard(jsonOutput.value);
        
        if (success) {
          statusOutput.innerHTML = `<p class="text-success mb-0"><i class="bi bi-check-circle me-2"></i>${t('tools.jsonFormatterValidator.copied')}</p>`;
          setTimeout(function() {
            statusOutput.innerHTML = `<p class="text-muted mb-0">${t('tools.jsonFormatterValidator.status_initial')}</p>`;
          }, 3000);
        } else {
          statusOutput.innerHTML = `<p class="text-danger mb-0"><i class="bi bi-x-circle me-2"></i>${t('tools.jsonFormatterValidator.copy_error')}</p>`;
        }
      });

      extractPathBtn.addEventListener('click', function () {
        var path = jsonPath.value.trim();
        if (!path) {
          pathResult.innerHTML = `<small class="text-warning">${t('tools.jsonFormatterValidator.enter_path')}</small>`;
          return;
        }
        if (!currentParsedJSON) {
          pathResult.innerHTML = `<small class="text-warning">${t('tools.jsonFormatterValidator.format_first')}</small>`;
          return;
        }
        try {
          var value = extractJSONPath(currentParsedJSON, path);
          var displayValue = typeof value === 'object' ? JSON.stringify(value, null, 2) : String(value);
          pathResult.innerHTML = `<div class="alert alert-success small mb-0"><strong>${t('tools.jsonFormatterValidator.value')}:</strong><br><code>${escapeHtml(displayValue)}</code></div>`;
        } catch (e) {
          pathResult.innerHTML = `<small class="text-danger">${escapeHtml(e.message)}</small>`;
        }
      });

      escapeBtn.addEventListener('click', function () {
        var input = jsonInput.value;
        if (!input) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_input')}</p>`;
          return;
        }
        var escaped = JSON.stringify(input);
        jsonOutput.value = escaped;
  statusOutput.innerHTML = `<p class="text-info mb-0"><i class="bi bi-info-circle me-2"></i>${t('tools.jsonFormatterValidator.string_escaped')}</p>`;
      });

      unescapeBtn.addEventListener('click', function () {
        var input = jsonInput.value.trim();
        if (!input) {
          statusOutput.innerHTML = `<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${t('tools.jsonFormatterValidator.no_input')}</p>`;
          return;
        }
        try {
          var unescaped = JSON.parse(input);
          if (typeof unescaped !== 'string') throw new Error(t('tools.jsonFormatterValidator.not_escaped_string'));
          jsonOutput.value = unescaped;
          statusOutput.innerHTML = `<p class="text-info mb-0"><i class="bi bi-info-circle me-2"></i>${t('tools.jsonFormatterValidator.string_unescaped')}</p>`;
        } catch (e) {
          statusOutput.innerHTML = `<p class="text-danger mb-0"><i class="bi bi-x-circle me-2"></i>${t('tools.jsonFormatterValidator.error')}: ${escapeHtml(e.message)}</p>`;
        }
      });
    }
  });

})();