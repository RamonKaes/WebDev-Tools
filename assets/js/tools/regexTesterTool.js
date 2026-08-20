/**
 * Regular Expression Tester Tool
 *
 * Test and debug regular expressions with live highlighting, match extraction, and group capture.
 * Supports all JavaScript regex flags (g, i, m, s, u, y) and prevents infinite loops on zero-length matches.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.warn('[regexTesterTool] Tools registry not available.');
    return;
  }

  // Import utilities
  const { copyToClipboard, showToast } = window.ClipboardUtils || {};
  const { downloadText } = window.DownloadUtils || {};

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

  // Announce a short result summary; the results panel itself is too long to
  // mark aria-live without flooding screen readers.
  function announce(message) {
    if (window.A11yUtils && typeof window.A11yUtils.announce === 'function') {
      window.A11yUtils.announce(message);
    }
  }

  let currentMatches = [];
  let currentPattern = '';
  let currentFlags = '';

  const EXAMPLES = [
    {
      key: 'email',
      pattern: '[a-zA-Z0-9._%+\\-]+@[a-zA-Z0-9.\\-]+\\.[a-zA-Z]{2,}',
      flags: 'g',
      testString: 'Contact us at support@example.com or sales@company.org\nInvalid: not-an-email, @missing.com, user@'
    },
    {
      key: 'url',
      pattern: 'https?:\\/\\/[^\\s\\/$.?#][^\\s]*',
      flags: 'gi',
      testString: 'Visit https://www.example.com or http://docs.example.org/path?query=1&page=2\nNot a URL: ftp://other.com'
    },
    {
      key: 'date',
      pattern: '\\d{4}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12]\\d|3[01])',
      flags: 'g',
      testString: 'Valid dates: 2024-01-15, 2024-12-31, 2023-06-01\nInvalid: 2024-13-01, 2024-00-10, 20240115'
    },
    {
      key: 'ipv4',
      pattern: '\\b(?:(?:25[0-5]|2[0-4]\\d|[01]?\\d\\d?)\\.){3}(?:25[0-5]|2[0-4]\\d|[01]?\\d\\d?)\\b',
      flags: 'g',
      testString: 'Servers: 192.168.1.1, 10.0.0.255, 172.16.254.1\nInvalid: 999.0.0.1, 256.1.2.3, 192.168.1'
    },
    {
      key: 'named_groups',
      pattern: '(?<year>\\d{4})-(?<month>\\d{2})-(?<day>\\d{2})',
      flags: 'g',
      testString: 'Dates with named groups: 2024-03-15, 2023-11-28, 2025-07-04'
    }
  ];

  /**
   * Render the regex tester UI
   *
   * @param {HTMLElement} container - Container element to render the UI
   */
  function renderUI(container) {
    container.innerHTML = `
      <div class="row g-3" id="mainRow">
        <!-- Settings Card (Full Width) -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row g-3">
                <!-- Pattern Input -->
                <div class="col-12">
                  <label for="regexPattern" class="form-label fw-bold">
                    <i class="bi bi-code-slash me-1"></i>${t('tools.regexTesterTool.pattern_label')}
                  </label>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text font-monospace">/</span>
                    <input
                      type="text"
                      class="form-control font-monospace"
                      id="regexPattern"
                      placeholder="${t('tools.regexTesterTool.pattern_placeholder')}"
                      aria-label="${t('tools.regexTesterTool.pattern_label')}">
                    <span class="input-group-text font-monospace">/</span>
                    <input
                      type="text"
                      class="form-control font-monospace"
                      id="regexFlags"
                      placeholder="gimsuy"
                      maxlength="6"
                      aria-label="${t('tools.regexTesterTool.flags_label')}">
                  </div>
                </div>

                <!-- Flags Checkboxes -->
                <div class="col-12">
                  <label class="form-label fw-bold">${t('tools.regexTesterTool.flags_label')}</label>
                  <div class="d-flex flex-wrap gap-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_g" data-flag="g">
                      <label class="form-check-label" for="flag_g">
                        <strong>g</strong> – ${t('tools.regexTesterTool.flag_global')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_i" data-flag="i">
                      <label class="form-check-label" for="flag_i">
                        <strong>i</strong> – ${t('tools.regexTesterTool.flag_ignoreCase')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_m" data-flag="m">
                      <label class="form-check-label" for="flag_m">
                        <strong>m</strong> – ${t('tools.regexTesterTool.flag_multiline')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_s" data-flag="s">
                      <label class="form-check-label" for="flag_s">
                        <strong>s</strong> – ${t('tools.regexTesterTool.flag_dotAll')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_u" data-flag="u">
                      <label class="form-check-label" for="flag_u">
                        <strong>u</strong> – ${t('tools.regexTesterTool.flag_unicode')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="flag_y" data-flag="y">
                      <label class="form-check-label" for="flag_y">
                        <strong>y</strong> – ${t('tools.regexTesterTool.flag_sticky')}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Input/Output Row (with floating toggle button) -->
        <div class="col-12 position-relative" id="inputOutputWrapper">
          <div class="row g-3 position-relative">
            <!-- Left Column: Test String Input -->
            <div class="col-12 col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="h6 fw-semibold card-title mb-3">
                    <i class="bi bi-text-paragraph me-2"></i>${t('tools.regexTesterTool.test_string_label')}
                  </p>

                  <textarea
                    class="form-control font-monospace mb-3"
                    id="testString"
                    rows="12"
                    placeholder="${t('tools.regexTesterTool.test_string_placeholder')}"
                    aria-label="${t('tools.regexTesterTool.test_string_label')}"></textarea>

                  <!-- Action Buttons -->
                  <div class="d-flex gap-2 flex-wrap align-items-center">
                    <button id="testButton" class="btn btn-sm btn-primary">
                      <i class="bi bi-play-circle me-1"></i>${t('tools.regexTesterTool.test_button')}
                    </button>
                    <button id="clearButton" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-x-circle me-1"></i>${t('tools.regexTesterTool.clear_button')}
                    </button>
                    <select id="exampleSelect" class="form-select form-select-sm w-auto" aria-label="${t('tools.regexTesterTool.example_placeholder')}">
                      <option value="">${t('tools.regexTesterTool.example_placeholder')}</option>
                      <option value="email">${t('tools.regexTesterTool.example_email')}</option>
                      <option value="url">${t('tools.regexTesterTool.example_url')}</option>
                      <option value="date">${t('tools.regexTesterTool.example_date')}</option>
                      <option value="ipv4">${t('tools.regexTesterTool.example_ipv4')}</option>
                      <option value="named_groups">${t('tools.regexTesterTool.example_named_groups')}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column: Results -->
            <div class="col-12 col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <p class="h6 fw-semibold card-title mb-3">
                <i class="bi bi-list-check me-2"></i>${t('tools.regexTesterTool.results_title')}
              </p>

              <!-- Results Container -->
              <div id="resultsContainer" class="mb-3 results-container">
                <div class="alert alert-light mb-0">
                  <i class="bi bi-info-circle me-2"></i>
                  <small class="text-muted">${t('tools.regexTesterTool.placeholder_text').replace('{button}', t('tools.regexTesterTool.test_button'))}</small>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="d-flex gap-2 flex-wrap">
                <button id="copyMatchesButton" class="btn btn-sm btn-outline-secondary" disabled>
                  <i class="bi bi-clipboard me-1"></i>${t('tools.regexTesterTool.copy_matches')}
                </button>
                <button id="downloadButton" class="btn btn-sm btn-outline-secondary" disabled>
                  <i class="bi bi-download me-1"></i>${t('tools.regexTesterTool.download_results')}
                </button>
              </div>
            </div>
          </div>
        </div>
          </div>

          <!-- Floating Toggle Button (positioned absolutely within inputOutputWrapper) -->
          <button class="btn btn-secondary btn-layout-toggle d-none d-lg-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle shadow"
                  id="toggleLayoutBtn"
                  title="${t('common.toggle_layout')}">
            <i class="bi bi-layout-three-columns"></i>
          </button>
        </div>

        <!-- Full-width: Highlighted Test String -->
        <div class="col-12 d-none" id="highlightedContainer">
          <div class="card">
            <div class="card-body">
              <p class="h6 fw-semibold card-title mb-3">
                <i class="bi bi-brush me-2"></i>${t('tools.regexTesterTool.highlighted_matches_title')}
              </p>
              <pre id="highlightedText" class="p-3 bg-body-secondary rounded mb-0 font-monospace pre-wrap"></pre>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // ============================================================================
  // REGEX TESTING
  // ============================================================================

  /**
   * Test a regular expression pattern against a test string
   *
   * @param {string} pattern - Regular expression pattern
   * @param {string} flags - Regex flags (gimsuy)
   * @param {string} testString - Test string to match against
   * @returns {object} - Result object with success status, matches array, or error message
   */
  function testRegex(pattern, flags, testString) {
    try {
      const regex = new RegExp(pattern, flags);
      const matches = [];
      let match;

      if (flags.includes('g')) {
        // Global: find all matches
        while ((match = regex.exec(testString)) !== null) {
          matches.push({
            fullMatch: match[0],
            index: match.index,
            groups: match.slice(1),
            input: match.input
          });
          // Prevent infinite loop with zero-length matches
          if (match.index === regex.lastIndex) {
            regex.lastIndex++;
          }
        }
      } else {
        // Non-global: find first match only
        match = regex.exec(testString);
        if (match) {
          matches.push({
            fullMatch: match[0],
            index: match.index,
            groups: match.slice(1),
            input: match.input
          });
        }
      }

      return { success: true, matches, regex };
    } catch (error) {
      return { success: false, error: error.message };
    }
  }

  /**
   * Render regex test results to the UI
   *
   * @param {object} result - Test result object from testRegex
   */
  function renderResults(result) {
    const container = document.getElementById('resultsContainer');
    const highlightedContainer = document.getElementById('highlightedContainer');

    if (!result.success) {
      container.innerHTML = `
        <div class="alert alert-danger mb-0">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>${t('tools.regexTesterTool.invalid_pattern')}:</strong> ${result.error}
        </div>
      `;
      highlightedContainer.classList.add('d-none');
      announce(t('tools.regexTesterTool.invalid_pattern'));
      return;
    }

    if (result.matches.length === 0) {
      container.innerHTML = `
        <div class="alert alert-warning mb-0">
          <i class="bi bi-info-circle me-2"></i>
          ${t('tools.regexTesterTool.no_matches')}
        </div>
      `;
      highlightedContainer.classList.add('d-none');
      announce(t('tools.regexTesterTool.no_matches'));
      return;
    }

    // Show match count
    const matchCount = result.matches.length;
    const matchText = matchCount === 1
      ? t('tools.regexTesterTool.matches_found').split('|')[0]
      : t('tools.regexTesterTool.matches_found').split('|')[1].replace('{count}', matchCount);

    announce(matchText);

    let html = `
      <div class="alert alert-success mb-3">
        <i class="bi bi-check-circle me-2"></i>
        <strong>${matchText}</strong>
      </div>
    `;

    // Render each match
    result.matches.forEach((match, index) => {
      html += `
        <div class="card mb-3">
          <div class="card-header bg-primary text-white">
            <strong>${t('tools.regexTesterTool.match_label', {number: index + 1})}</strong>
          </div>
          <div class="card-body">
            <table class="table table-sm mb-0">
              <tbody>
                <tr>
                  <td class="fw-bold col-width-150">${t('tools.regexTesterTool.match_text')}</td>
                  <td><code class="text-primary">${escapeHtml(match.fullMatch)}</code></td>
                </tr>
                <tr>
                  <td class="fw-bold">${t('tools.regexTesterTool.match_position')}</td>
                  <td>${match.index} - ${match.index + match.fullMatch.length}</td>
                </tr>
                ${match.groups.length > 0 ? `
                  <tr>
                    <td class="fw-bold">${t('tools.regexTesterTool.capture_groups')}</td>
                    <td>
                      ${match.groups.map((group, i) => `
                        <div class="mb-1">
                          <span class="badge bg-secondary">${t('tools.regexTesterTool.group_number', {number: i + 1})}</span>
                          <code>${group !== undefined ? escapeHtml(group) : '<em>undefined</em>'}</code>
                        </div>
                      `).join('')}
                    </td>
                  </tr>
                ` : ''}
              </tbody>
            </table>
          </div>
        </div>
      `;
    });

    container.innerHTML = html;

    // Highlight matches in test string
    highlightMatches(result);
    highlightedContainer.classList.remove('d-none');

    // Enable copy/download buttons
    document.getElementById('copyMatchesButton').disabled = false;
    document.getElementById('downloadButton').disabled = false;
  }

  /**
   * Highlight regex matches in the test string
   *
   * Security: All text segments are escaped with escapeHtml to prevent XSS.
   *
   * @param {object} result - Test result object containing matches
   */
  function highlightMatches(result) {
    const testString = document.getElementById('testString').value;
    const highlightedText = document.getElementById('highlightedText');

    if (result.matches.length === 0) {
      highlightedText.textContent = testString;
      return;
    }

    // Sort matches ascending by index and build HTML linearly
    const sortedMatches = [...result.matches].sort((a, b) => a.index - b.index);
    let html = '';
    let lastIndex = 0;

    sortedMatches.forEach((match) => {
      html += escapeHtml(testString.slice(lastIndex, match.index));
      html += `<mark class="bg-warning text-dark">${escapeHtml(match.fullMatch)}</mark>`;
      lastIndex = match.index + match.fullMatch.length;
    });

    html += escapeHtml(testString.slice(lastIndex));
    highlightedText.innerHTML = html;
  }

  /**
   * Handle test button click
   */
  function handleTest() {
    const pattern = document.getElementById('regexPattern').value;
    const flags = document.getElementById('regexFlags').value;
    const testString = document.getElementById('testString').value;

    if (!pattern) {
      showToast(t('tools.regexTesterTool.invalid_pattern'), 'warning', 3000);
      return;
    }

    currentPattern = pattern;
    currentFlags = flags;

    const result = testRegex(pattern, flags, testString);
    currentMatches = result.matches || [];
    renderResults(result);
  }

  /**
   * Handle clear button click
   */
  function handleClear() {
    document.getElementById('regexPattern').value = '';
    document.getElementById('regexFlags').value = '';
    document.getElementById('testString').value = '';
    document.getElementById('resultsContainer').innerHTML = `
      <div class="alert alert-light mb-0">
        <i class="bi bi-info-circle me-2"></i>
        <small class="text-muted">${t('tools.regexTesterTool.placeholder_text').replace('{button}', t('tools.regexTesterTool.test_button'))}</small>
      </div>
    `;
    document.getElementById('highlightedContainer').classList.add('d-none');

    // Reset flag checkboxes
    document.querySelectorAll('[data-flag]').forEach(cb => cb.checked = false);
    currentMatches = [];
    document.getElementById('copyMatchesButton').disabled = true;
    document.getElementById('downloadButton').disabled = true;
  }

  /**
   * Handle copy matches button click
   */
  function handleCopyMatches() {
    if (currentMatches.length === 0) return;

    const matchesText = currentMatches.map((match, i) =>
      `Match ${i + 1}: "${match.fullMatch}" at position ${match.index}`
    ).join('\n');

    // The message is passed through - copyToClipboard raises the toast itself
    copyToClipboard(matchesText, t('tools.regexTesterTool.copied'));
  }

  /**
   * Handle download results button click
   */
  function handleDownload() {
    if (currentMatches.length === 0) return;

    const output = {
      pattern: currentPattern,
      flags: currentFlags,
      testString: document.getElementById('testString').value,
      matchCount: currentMatches.length,
      matches: currentMatches.map((match, i) => ({
        matchNumber: i + 1,
        text: match.fullMatch,
        position: match.index,
        endPosition: match.index + match.fullMatch.length,
        captureGroups: match.groups
      }))
    };

    downloadText(JSON.stringify(output, null, 2), 'regex-test-results.json');
  }

  /**
   * Handle flag checkbox change
   *
   * @param {Event} event - Change event from checkbox
   */
  function handleFlagChange(event) {
    const checkbox = event.target;
    const flag = checkbox.dataset.flag;
    const flagsInput = document.getElementById('regexFlags');
    let flags = flagsInput.value;

    if (checkbox.checked) {
      if (!flags.includes(flag)) {
        flags += flag;
      }
    } else {
      flags = flags.replace(flag, '');
    }

    flagsInput.value = flags;
  }

  /**
   * Handle manual flags input
   *
   * @param {Event} event - Input event from flags field
   */
  function handleFlagsInput(event) {
    const flags = event.target.value;
    document.querySelectorAll('[data-flag]').forEach(cb => {
      cb.checked = flags.includes(cb.dataset.flag);
    });
  }

  /**
   * Escape HTML special characters to prevent XSS
   *
   * @param {string} text - Text to escape
   * @returns {string} - HTML-safe text
   */
  function escapeHtml(text) {
    if (window && window.AppHelpers && typeof window.AppHelpers.escapeHtml === 'function') {
      return window.AppHelpers.escapeHtml(text);
    }

    // Fallback - explicit replacements to ensure quotes are escaped
    if (typeof text !== 'string') return '';
    return text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  /**
   * Handle example selection
   *
   * @param {string} key - Example key to load
   */
  function handleLoadExample(key) {
    const example = EXAMPLES.find(e => e.key === key);
    if (!example) return;

    document.getElementById('regexPattern').value = example.pattern;
    document.getElementById('regexFlags').value = example.flags;
    document.getElementById('testString').value = example.testString;

    document.querySelectorAll('[data-flag]').forEach(cb => {
      cb.checked = example.flags.includes(cb.dataset.flag);
    });

    handleTest();
    document.getElementById('exampleSelect').value = '';
  }

  /**
   * Toggle layout between horizontal and vertical split
   */
  function toggleLayout() {
    const toggleBtn = document.getElementById('toggleLayoutBtn');
    const wrapper = document.getElementById('inputOutputWrapper');

    // Find the input/output columns
    const columns = wrapper.querySelectorAll('.row > .col-12');

    if (columns.length === 0) return;

    // Check if currently in side-by-side mode (has col-lg-6)
    const isSideBySide = columns[0].classList.contains('col-lg-6');

    if (isSideBySide) {
      // Switch to stacked (full width)
      columns.forEach(col => col.classList.remove('col-lg-6'));

      toggleBtn.innerHTML = `<i class="bi bi-layout-split"></i>`;
      toggleBtn.title = t('common.layout_side_by_side');

      // Move button to right of first card when stacked
      toggleBtn.classList.remove('top-50', 'start-50', 'translate-middle');
      toggleBtn.classList.add('top-0', 'end-0', 'btn-layout-toggle-stacked');
    } else {
      // Switch to side by side
      columns.forEach(col => col.classList.add('col-lg-6'));

      toggleBtn.innerHTML = `<i class="bi bi-layout-three-columns"></i>`;
      toggleBtn.title = t('common.layout_stacked');

      // Move button back to center when side by side
      toggleBtn.classList.remove('top-0', 'end-0', 'btn-layout-toggle-stacked');
      toggleBtn.classList.add('top-50', 'start-50', 'translate-middle');
    }
  }

  window.Tools.register('regexTesterTool', {
    init: function () {
      console.debug('Regex Tester Tool initialized');
    },

    open: function (container) {
      renderUI(container);

      // Event listeners
      document.getElementById('testButton').addEventListener('click', handleTest);
      document.getElementById('clearButton').addEventListener('click', handleClear);
      document.getElementById('exampleSelect').addEventListener('change', (e) => {
        if (e.target.value) handleLoadExample(e.target.value);
      });
      document.getElementById('copyMatchesButton').addEventListener('click', handleCopyMatches);
      document.getElementById('downloadButton').addEventListener('click', handleDownload);
      document.getElementById('regexFlags').addEventListener('input', handleFlagsInput);
      document.getElementById('toggleLayoutBtn').addEventListener('click', toggleLayout);

      document.querySelectorAll('[data-flag]').forEach(checkbox => {
        checkbox.addEventListener('change', handleFlagChange);
      });

      // Test on Enter key
      document.getElementById('regexPattern').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleTest();
      });
      document.getElementById('testString').addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && e.ctrlKey) handleTest();
      });
    }
  });

})();
