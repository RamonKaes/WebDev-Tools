/**
 * Code Formatter & Beautifier Tool
 *
 * Format and beautify HTML, CSS, JavaScript, XML, and SQL code.
 * Supports both beautification and minification with configurable indentation.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[codeFormatterTool] Tools registry not available.');
    return;
  }

  // Terser minifier lazy-loading
  let terserLoaded = false;
  let terserLoading = false;

  /**
   * Load Terser library from CDN (lazy-loaded on first minify)
   * @returns {Promise<boolean>} - True if loaded successfully
   */
  async function loadTerser() {
    if (terserLoaded) return true;
    if (terserLoading) {
      // Wait for existing load to complete
      while (terserLoading) {
        await new Promise(resolve => setTimeout(resolve, 100));
      }
      return terserLoaded;
    }

    terserLoading = true;
    try {
      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/terser@5.31.0/dist/bundle.min.js';
      script.async = true;
      
      await new Promise((resolve, reject) => {
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
      });
      
      terserLoaded = true;
      return true;
    } catch (error) {
      console.error('[codeFormatterTool] Failed to load Terser:', error);
      return false;
    } finally {
      terserLoading = false;
    }
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

  const formatters = {
    html: {
      /**
       * Beautify HTML code with proper indentation
       *
       * @param {string} code - HTML code to format
       * @param {string} indent - Indentation string (spaces or tab)
       * @returns {string} - Formatted HTML
       */
      beautify: (code, indent = '  ') => {
        let formatted = '';
        let indentLevel = 0;
        const lines = code.split(/>\s*</);

        lines.forEach((line, index) => {
          if (index > 0) line = '<' + line;
          if (index < lines.length - 1) line = line + '>';

          if (line.match(/^<\//) || line.match(/^<.*\/>/)) {
            indentLevel = Math.max(0, indentLevel - 1);
          }

          if (line.trim()) {
            formatted += indent.repeat(indentLevel) + line.trim() + '\n';
          }

          if (line.match(/^<[^/!?]/) && !line.match(/\/>$/)) {
            indentLevel++;
          }
        });

        return formatted.trim();
      },
      /**
       * Minify HTML code by removing comments and whitespace
       *
       * @param {string} code - HTML code to minify
       * @returns {string} - Minified HTML
       */
      minify: (code) => {
        return code
          .replace(/<!--[\s\S]*?-->/g, '')
          .replace(/\s+/g, ' ')
          .replace(/>\s+</g, '><')
          .trim();
      }
    },

    css: {
      /**
       * Beautify CSS code with proper indentation
       *
       * @param {string} code - CSS code to format
       * @param {string} indent - Indentation string (spaces or tab)
       * @returns {string} - Formatted CSS
       */
      beautify: (code, indent = '  ') => {
        let formatted = code
          .replace(/\s+/g, ' ')
          .replace(/\s*{\s*/g, ' {\n')
          .replace(/\s*}\s*/g, '\n}\n')
          .replace(/\s*;\s*/g, ';\n')
          .replace(/,\s*/g, ', ');

        const lines = formatted.split('\n');
        let indentLevel = 0;
        formatted = '';

        lines.forEach(line => {
          line = line.trim();
          if (!line) return;

          if (line === '}') {
            indentLevel = Math.max(0, indentLevel - 1);
          }

          formatted += indent.repeat(indentLevel) + line + '\n';

          if (line.endsWith('{')) {
            indentLevel++;
          }
        });

        return formatted.trim();
      },
      /**
       * Minify CSS code by removing comments and whitespace
       *
       * @param {string} code - CSS code to minify
       * @returns {string} - Minified CSS
       */
      minify: (code) => {
        return code
          .replace(/\/\*[\s\S]*?\*\//g, '')
          .replace(/\s+/g, ' ')
          .replace(/\s*{\s*/g, '{')
          .replace(/\s*}\s*/g, '}')
          .replace(/\s*;\s*/g, ';')
          .replace(/\s*:\s*/g, ':')
          .replace(/\s*,\s*/g, ',')
          .trim();
      }
    },

    javascript: {
      /**
       * Beautify JavaScript code with proper indentation
       *
       * Basic formatter - handles strings, comments, and braces.
       *
       * @param {string} code - JavaScript code to format
       * @param {string} indent - Indentation string (spaces or tab)
       * @returns {string} - Formatted JavaScript
       */
      beautify: (code, indent = '  ') => {
        let formatted = '';
        let indentLevel = 0;
        let inString = false;
        let stringChar = '';
        let inComment = false;

        for (let i = 0; i < code.length; i++) {
          const char = code[i];
          const nextChar = code[i + 1];
          const prevChar = code[i - 1];

          if ((char === '"' || char === "'" || char === '`') && prevChar !== '\\') {
            if (!inString) {
              inString = true;
              stringChar = char;
            } else if (char === stringChar) {
              inString = false;
              stringChar = '';
            }
          }

          if (!inString && char === '/' && nextChar === '/') {
            inComment = true;
          }
          if (inComment && char === '\n') {
            inComment = false;
          }

          if (inString || inComment) {
            formatted += char;
            continue;
          }

          if (char === '{') {
            formatted += ' {\n';
            indentLevel++;
            while (code[i + 1] === ' ' || code[i + 1] === '\n') i++;
            formatted += indent.repeat(indentLevel);
          } else if (char === '}') {
            indentLevel = Math.max(0, indentLevel - 1);
            formatted = formatted.trimEnd();
            formatted += '\n' + indent.repeat(indentLevel) + '}';
            if (nextChar && nextChar !== ';' && nextChar !== ',' && nextChar !== ')') {
              formatted += '\n' + indent.repeat(indentLevel);
            }
          } else if (char === ';') {
            formatted += ';\n' + indent.repeat(indentLevel);
            while (code[i + 1] === ' ' || code[i + 1] === '\n') i++;
          } else if (char === '\n') {
            if (formatted.slice(-1) !== '\n') {
              formatted += '\n' + indent.repeat(indentLevel);
            }
          } else if (char === ' ' && formatted.slice(-1) === ' ') {
            continue;
          } else {
            formatted += char;
          }
        }

        return formatted
          .split('\n')
          .map(line => line.trimEnd())
          .join('\n')
          .replace(/\n{3,}/g, '\n\n')
          .trim();
      },
      /**
       * Minify JavaScript code using Terser library
       *
       * @param {string} code - JavaScript code to minify
       * @returns {Promise<string>} - Minified JavaScript
       */
      minify: async (code) => {
        // Load Terser library on first use
        const loaded = await loadTerser();
        if (!loaded || typeof Terser === 'undefined') {
          throw new Error('Terser library failed to load. Please check your internet connection.');
        }

        try {
          const result = await Terser.minify(code, {
            compress: {
              dead_code: true,
              drop_console: false,
              drop_debugger: false,
              keep_classnames: false,
              keep_fnames: false,
            },
            mangle: false, // Don't mangle names for readability
            format: {
              comments: false,
            }
          });

          if (result.error) {
            throw result.error;
          }

          return result.code;
        } catch (error) {
          console.error('[codeFormatterTool] Terser minify error:', error);
          throw new Error(`Minification failed: ${error.message}`);
        }
      }
    },

    xml: {
      /**
       * Beautify XML code (uses HTML formatter)
       *
       * @param {string} code - XML code to format
       * @param {string} indent - Indentation string
       * @returns {string} - Formatted XML
       */
      beautify: (code, indent = '  ') => {
        return formatters.html.beautify(code, indent);
      },
      /**
       * Minify XML code (uses HTML minifier)
       *
       * @param {string} code - XML code to minify
       * @returns {string} - Minified XML
       */
      minify: (code) => {
        return formatters.html.minify(code);
      }
    },

    sql: {
      /**
       * Beautify SQL code with proper formatting
       *
       * @param {string} code - SQL code to format
       * @param {string} indent - Indentation string
       * @returns {string} - Formatted SQL
       */
      beautify: (code, indent = '  ') => {
        const keywords = /\b(SELECT|FROM|WHERE|JOIN|INNER|LEFT|RIGHT|OUTER|ON|GROUP BY|ORDER BY|HAVING|LIMIT|OFFSET|INSERT INTO|VALUES|UPDATE|SET|DELETE|CREATE|ALTER|DROP|TABLE|DATABASE|INDEX|AS|AND|OR|NOT|IN|EXISTS|LIKE|BETWEEN|DISTINCT|COUNT|SUM|AVG|MAX|MIN)\b/gi;

        let formatted = code
          .replace(/\s+/g, ' ')
          .replace(/,\s*/g, ',\n' + indent)
          .replace(/\(\s*/g, '(\n' + indent.repeat(2))
          .replace(/\s*\)/g, '\n)');

        formatted = formatted.replace(keywords, (match) => {
          return '\n' + match.toUpperCase();
        });

        formatted = formatted
          .split('\n')
          .map(line => line.trim())
          .filter(line => line)
          .join('\n');

        return formatted.trim();
      },
      /**
       * Minify SQL code by removing comments and whitespace
       *
       * @param {string} code - SQL code to minify
       * @returns {string} - Minified SQL
       */
      minify: (code) => {
        return code
          .replace(/--.*$/gm, '')
          .replace(/\s+/g, ' ')
          .trim();
      }
    }
  };

  window.Tools.register('codeFormatterTool', {
    init: function () {
      // no-op
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
        <!-- Configuration Card -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-3 col-lg-2">
                  <label for="codeLanguage" class="form-label fw-bold">
                    <i class="bi bi-code-slash me-2"></i>${t('tools.codeFormatterTool.formatLabel')}
                  </label>
                  <select class="form-select form-select-sm" id="codeLanguage">
                    <option value="html">${t('tools.codeFormatterTool.html')}</option>
                    <option value="css">${t('tools.codeFormatterTool.css')}</option>
                    <option value="javascript">${t('tools.codeFormatterTool.javascript')}</option>
                    <option value="xml">${t('tools.codeFormatterTool.xml')}</option>
                    <option value="sql">${t('tools.codeFormatterTool.sql')}</option>
                  </select>
                </div>
                <div class="col-md-3 col-lg-2">
                  <label for="indentType" class="form-label fw-bold">
                    <i class="bi bi-text-indent-left me-2"></i>${t('tools.codeFormatterTool.indentLabel')}
                  </label>
                  <select class="form-select form-select-sm" id="indentType">
                    <option value="2">${t('tools.codeFormatterTool.indent2')}</option>
                    <option value="4" selected>${t('tools.codeFormatterTool.indent4')}</option>
                    <option value="tab">${t('tools.codeFormatterTool.indentTab')}</option>
                  </select>
                </div>
                <div class="col-md-4 col-lg-4">
                  <label class="form-label fw-bold">
                    <i class="bi bi-sliders me-2"></i>Modus
                  </label>
                  <div class="btn-group btn-group-sm w-100" role="group">
                    <input type="radio" class="btn-check" name="mode" id="modeBeautify" autocomplete="off" checked>
                    <label class="btn btn-outline-primary d-inline-flex align-items-center" for="modeBeautify"><i class="bi bi-stars me-1"></i>${t('tools.codeFormatterTool.beautifyBtn')}</label>

                    <input type="radio" class="btn-check" name="mode" id="modeMinify" autocomplete="off">
                    <label class="btn btn-outline-primary d-inline-flex align-items-center" for="modeMinify"><i class="bi bi-file-earmark-zip me-1"></i>${t('tools.codeFormatterTool.minifyBtn')}</label>
                  </div>
                  <div id="minifyInfo" class="alert alert-info mt-2 mb-0 py-1 px-2 small d-none">
                    <i class="bi bi-info-circle me-1"></i>
                    <span id="minifyInfoText">${t('tools.codeFormatterTool.loadingTerser')}</span>
                  </div>
                </div>
                <div class="col-md-2 col-lg-4">
                  <label class="form-label fw-bold d-block">
                    <i class="bi bi-gear me-2"></i>Auto
                  </label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoFormat">
                    <label class="form-check-label" for="autoFormat">
                      ${t('tools.codeFormatterTool.autoFormat')}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Input/Output with Toggle Button -->
        <div class="col-12 position-relative" id="inputOutputWrapper">
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-pencil me-2"></i>${t('tools.codeFormatterTool.input_title')}</h2>

                  <textarea class="form-control font-monospace mb-3" id="inputCode" rows="20" placeholder="${t('tools.codeFormatterTool.inputPlaceholder')}"></textarea>

                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" id="formatBtn"><i class="bi bi-arrow-right me-2"></i>${t('tools.codeFormatterTool.processBtn')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="clearBtn"><i class="bi bi-trash me-2"></i>${t('common.clear')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="loadSampleBtn"><i class="bi bi-file-earmark me-2"></i>${t('common.load_sample')}</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3"><i class="bi bi-code-square me-2"></i>${t('tools.codeFormatterTool.output_title')}</h2>

                  <textarea class="form-control bg-body-secondary font-monospace mb-3" id="outputCode" rows="20" readonly placeholder="${t('tools.codeFormatterTool.outputPlaceholder')}"></textarea>

                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <small class="text-muted me-auto" id="outputInfo"></small>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="copyBtn"><i class="bi bi-clipboard me-2"></i>${t('common.copy')}</button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center" id="downloadBtn"><i class="bi bi-download me-2"></i>Download</button>
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

      // DOM elements
      const inputCode = document.getElementById('inputCode');
      const outputCode = document.getElementById('outputCode');
      const languageSelect = document.getElementById('codeLanguage');
      const indentSelect = document.getElementById('indentType');
      const modeBeautify = document.getElementById('modeBeautify');
      const modeMinify = document.getElementById('modeMinify');
      const formatBtn = document.getElementById('formatBtn');
      const clearBtn = document.getElementById('clearBtn');
      const loadSampleBtn = document.getElementById('loadSampleBtn');
      const copyBtn = document.getElementById('copyBtn');
      const downloadBtn = document.getElementById('downloadBtn');
      const autoFormat = document.getElementById('autoFormat');
      const outputInfo = document.getElementById('outputInfo');

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

      /**
       * Get indent string based on user selection
       *
       * @returns {string} - Indent string (spaces or tab)
       */
      const getIndent = () => {
        const type = indentSelect.value;
        if (type === 'tab') return '\t';
        return ' '.repeat(parseInt(type));
      };

      /**
       * Format code based on selected language and mode
       */
      const formatCode = async () => {
        const code = inputCode.value.trim();
        if (!code) {
          outputCode.value = '';
          outputInfo.textContent = '';
          return;
        }

        const language = languageSelect.value;
        const isBeautify = modeBeautify.checked;
        const indent = getIndent();

        // Show loading indicator for minify with JavaScript
        const minifyInfo = document.getElementById('minifyInfo');
        const minifyInfoText = document.getElementById('minifyInfoText');
        
        if (!isBeautify && language === 'javascript') {
          minifyInfo.classList.remove('d-none');
          minifyInfoText.textContent = t('tools.codeFormatterTool.loadingTerser');
        }

        try {
          let result;
          if (isBeautify) {
            result = formatters[language].beautify(code, indent);
          } else {
            result = await formatters[language].minify(code);
          }

          outputCode.value = result;

          // Update stats
          const lines = result.split('\n').length;
          const chars = result.length;
          outputInfo.textContent = `${lines} ${t('tools.codeFormatterTool.lines')}, ${chars} ${t('tools.codeFormatterTool.characters')}`;
          
          // Show success message for JS minify
          if (!isBeautify && language === 'javascript') {
            minifyInfoText.innerHTML = '<i class="bi bi-check-circle me-1"></i>' + t('tools.codeFormatterTool.minifiedWithTerser');
            setTimeout(() => minifyInfo.classList.add('d-none'), 3000);
          }
        } catch (error) {
          console.error('Format error:', error);
          outputCode.value = '';
          const errorMsg = isBeautify
            ? t('tools.codeFormatterTool.errorFormat')
            : t('tools.codeFormatterTool.errorMinify');
          outputInfo.textContent = `${errorMsg}: ${error.message}`;
          
          // Show error for JS minify
          if (!isBeautify && language === 'javascript') {
            minifyInfo.classList.remove('alert-info');
            minifyInfo.classList.add('alert-danger');
            minifyInfoText.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>${error.message}`;
          }
        }
      };

      /**
       * Update button text based on current mode
       */
      const updateButtonText = () => {
        const isBeautify = modeBeautify.checked;
        const text = isBeautify
          ? t('tools.codeFormatterTool.beautifyBtn')
          : t('tools.codeFormatterTool.minifyBtn');
        formatBtn.innerHTML = `<i class="bi bi-arrow-right me-2"></i>${text}`;
      };

      // Event listeners
      formatBtn.addEventListener('click', formatCode);
      clearBtn.addEventListener('click', () => {
        inputCode.value = '';
        outputCode.value = '';
        outputInfo.textContent = '';
      });

      loadSampleBtn.addEventListener('click', () => {
        const lang = languageSelect.value;
        const samples = {
          javascript: 'function greet(name){console.log("Hello, "+name+"!");}const user={name:"John",age:30,hobbies:["coding","reading"]};greet(user.name);',
          html: '<!DOCTYPE html><html><head><title>Example</title></head><body><div class="container"><h1>Hello World</h1><p>This is a sample.</p></div></body></html>',
          css: 'body{margin:0;padding:0;font-family:Arial,sans-serif;}.container{max-width:1200px;margin:0 auto;padding:20px;}h1{color:#333;font-size:2rem;}',
          json: '{"name":"John Doe","age":30,"email":"john@example.com","address":{"street":"Main St","city":"Berlin","country":"Germany"},"hobbies":["coding","reading"]}'
        };
        inputCode.value = samples[lang] || samples.javascript;
        if (autoFormat.checked) {
          handleFormat();
        }
      });

      modeBeautify.addEventListener('change', updateButtonText);
      modeMinify.addEventListener('change', updateButtonText);

      // Auto-format
      let autoFormatTimeout;
      const handleAutoFormat = () => {
        if (autoFormat.checked) {
          clearTimeout(autoFormatTimeout);
          autoFormatTimeout = setTimeout(formatCode, 500);
        }
      };

      inputCode.addEventListener('input', handleAutoFormat);
      languageSelect.addEventListener('change', handleAutoFormat);
      indentSelect.addEventListener('change', handleAutoFormat);
      modeBeautify.addEventListener('change', handleAutoFormat);
      modeMinify.addEventListener('change', handleAutoFormat);

      // Copy to clipboard
      copyBtn.addEventListener('click', () => {
        if (!outputCode.value) return;

        if (window.ClipboardUtils && typeof window.ClipboardUtils.copyToClipboard === 'function') {
          window.ClipboardUtils.copyToClipboard(outputCode.value, copyBtn);
        } else {
          outputCode.select();
          document.execCommand('copy');
          const originalText = copyBtn.innerHTML;
          copyBtn.innerHTML = '<i class="bi bi-check me-2"></i>' + t('common.copied');
          setTimeout(() => {
            copyBtn.innerHTML = originalText;
          }, 2000);
        }
      });

      // Download
      downloadBtn.addEventListener('click', () => {
        if (!outputCode.value) return;

        const language = languageSelect.value;
        const extensions = {
          html: 'html',
          css: 'css',
          javascript: 'js',
          xml: 'xml',
          sql: 'sql'
        };
        const ext = extensions[language] || 'txt';
        const mode = modeBeautify.checked ? 'beautified' : 'minified';
        const filename = `code-${mode}.${ext}`;

        if (window.DownloadUtils && typeof window.DownloadUtils.downloadText === 'function') {
          window.DownloadUtils.downloadText(outputCode.value, filename);
        } else {
          const blob = new Blob([outputCode.value], { type: 'text/plain' });
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
