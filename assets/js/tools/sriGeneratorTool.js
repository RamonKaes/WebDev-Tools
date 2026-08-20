/**
 * SRI Generator Tool
 *
 * Generate Subresource Integrity (SRI) hashes for external resources.
 * Supports URL fetch, file upload, and direct text input.
 * Algorithms: SHA-256, SHA-384, SHA-512 (multi-select).
 * Generates integrity attributes and ready-to-use <script>/<link> tags.
 *
 * Security: Uses Web Crypto API (SubtleCrypto) — all hashing is client-side.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', { tool: 'sriGeneratorTool' })
      : '[sriGeneratorTool] Tools registry not available.';
    console.warn(msg);
    return;
  }

  function t(key, params) {
    if (window.i18n && typeof window.i18n.t === 'function') {
      return window.i18n.t(key, params);
    }
    return key.split('.').pop();
  }

  window.Tools.register('sriGeneratorTool', {

    // ── Init / Open ──────────────────────────────────────────────────────────

    init: function () {
      if (!this.isSupported()) {
        console.warn('[SRI Generator] Web Crypto API not supported.');
      }
    },

    open: function (container) {
      this.buildUI(container);
    },

    // ── Crypto ──────────────────────────────────────────────────────────────

    isSupported: function () {
      return !!(window.crypto && window.crypto.subtle);
    },

    bufferToBase64: function (buffer) {
      const bytes = new Uint8Array(buffer);
      let binary = '';
      for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
      }
      return btoa(binary);
    },

    computeSRI: async function (arrayBuffer, algorithm) {
      const hashBuffer = await window.crypto.subtle.digest(algorithm, arrayBuffer);
      const base64 = this.bufferToBase64(hashBuffer);
      const prefix = algorithm.toLowerCase().replace(/-/g, '');
      return `${prefix}-${base64}`;
    },

    computeAllSRI: async function (arrayBuffer, algorithms) {
      const results = {};
      for (const algo of algorithms) {
        results[algo] = await this.computeSRI(arrayBuffer, algo);
      }
      return results;
    },

    // ── Helpers ─────────────────────────────────────────────────────────────

    escapeHtml: function (str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    },

    guessResourceType: function (urlOrFilename) {
      const s = (urlOrFilename || '').toLowerCase().split('?')[0];
      if (s.endsWith('.css')) return 'stylesheet';
      if (s.endsWith('.js') || s.endsWith('.mjs')) return 'script';
      return 'script'; // default
    },

    buildHtmlTag: function (type, url, integrity, crossorigin) {
      const co = crossorigin || 'anonymous';
      if (type === 'stylesheet') {
        return `<link rel="stylesheet" href="${this.escapeHtml(url)}"\n     integrity="${integrity}"\n     crossorigin="${co}">`;
      }
      return `<script src="${this.escapeHtml(url)}"\n        integrity="${integrity}"\n        crossorigin="${co}"></script>`;
    },

    getSelectedAlgorithms: function (container) {
      return ['SHA-256', 'SHA-384', 'SHA-512'].filter(algo => {
        const cb = container.querySelector(`#sri-algo-${algo.toLowerCase().replace(/-/g, '')}`);
        return cb && cb.checked;
      });
    },

    // ── Render results ───────────────────────────────────────────────────────

    renderResults: function (container, hashes, resourceUrl, resourceType) {
      const resultsEl = container.querySelector('#sri-results');
      const sectionEl = container.querySelector('#sri-results-section');

      if (!resultsEl) return;

      sectionEl && sectionEl.classList.remove('d-none');
      resultsEl.innerHTML = '';

      Object.entries(hashes).forEach(([algo, integrity]) => {
        const tag = this.buildHtmlTag(resourceType, resourceUrl || 'https://cdn.example.com/resource', integrity, 'anonymous');

        const block = document.createElement('div');
        block.className = 'card';
        block.innerHTML = `
          <div class="card-header d-flex justify-content-between align-items-center py-2">
            <span class="fw-semibold">
              <span class="badge bg-primary me-2">${this.escapeHtml(algo)}</span>
              ${t('tools.sriGeneratorTool.integrityAttr')}
            </span>
            <button class="btn btn-sm btn-outline-secondary copy-integrity-btn" data-value="${this.escapeHtml(integrity)}">
              <i class="bi bi-clipboard me-1"></i>${t('common.copy')}
            </button>
          </div>
          <div class="card-body p-0">
            <pre class="m-0 p-3 rounded-bottom user-select-all" style="word-break:break-all;white-space:pre-wrap;font-size:0.8rem;">${this.escapeHtml(integrity)}</pre>
          </div>
          ${resourceUrl ? `
          <div class="card-footer py-2">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <small class="text-muted fw-semibold">${t('tools.sriGeneratorTool.htmlTag')}</small>
              <button class="btn btn-sm btn-outline-secondary copy-tag-btn" data-value="${this.escapeHtml(tag)}">
                <i class="bi bi-clipboard me-1"></i>${t('common.copy')}
              </button>
            </div>
            <pre class="m-0 p-2 bg-body-secondary rounded user-select-all" style="font-size:0.8rem;white-space:pre-wrap;">${this.escapeHtml(tag)}</pre>
          </div>` : ''}
        `;
        resultsEl.appendChild(block);
      });

      // Copy buttons
      resultsEl.querySelectorAll('.copy-integrity-btn, .copy-tag-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const value = btn.dataset.value;
          if (!value) return;
          window.ClipboardUtils.copyToClipboard(
            value,
            () => {
              const orig = btn.innerHTML;
              btn.innerHTML = `<i class="bi bi-check me-1"></i>${t('common.copied')}`;
              btn.disabled = true;
              setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 1500);
            },
            () => {}
          );
        });
      });
    },

    // ── Show / hide error ────────────────────────────────────────────────────

    showError: function (container, msg) {
      const el = container.querySelector('#sri-error');
      if (!el) return;
      el.textContent = msg;
      el.classList.remove('d-none');
    },

    hideError: function (container) {
      const el = container.querySelector('#sri-error');
      if (el) el.classList.add('d-none');
    },

    setLoading: function (container, loading) {
      ['#sri-generate-from-url-btn', '#sri-generate-from-file-btn', '#sri-generate-from-text-btn'].forEach(sel => {
        const btn = container.querySelector(sel);
        if (btn) btn.disabled = loading;
      });
      const spinner = container.querySelector('#sri-spinner');
      if (spinner) spinner.classList.toggle('d-none', !loading);
    },

    // ── Generate ─────────────────────────────────────────────────────────────

    generate: async function (container) {
      this.hideError(container);

      const mode = container.querySelector('input[name="sri-mode"]:checked')?.value || 'url';
      const algorithms = this.getSelectedAlgorithms(container);

      if (!algorithms.length) {
        this.showError(container, t('tools.sriGeneratorTool.errors.noAlgorithm'));
        return;
      }

      this.setLoading(container, true);

      try {
        let arrayBuffer = null;
        let resourceUrl = '';
        let resourceType = 'script';

        if (mode === 'url') {
          resourceUrl = (container.querySelector('#sri-url')?.value || '').trim();
          if (!resourceUrl) {
            this.showError(container, t('tools.sriGeneratorTool.errors.noUrl'));
            this.setLoading(container, false);
            return;
          }
          if (!/^https?:\/\//i.test(resourceUrl)) {
            this.showError(container, t('tools.sriGeneratorTool.errors.invalidUrl'));
            this.setLoading(container, false);
            return;
          }
          resourceType = this.guessResourceType(resourceUrl);

          let response;
          try {
            response = await fetch(resourceUrl);
          } catch (fetchErr) {
            this.showError(container, t('tools.sriGeneratorTool.errors.fetchFailed') + ' (CORS?)');
            this.setLoading(container, false);
            return;
          }
          if (!response.ok) {
            this.showError(container, t('tools.sriGeneratorTool.errors.fetchError', { status: response.status }));
            this.setLoading(container, false);
            return;
          }
          arrayBuffer = await response.arrayBuffer();

        } else if (mode === 'file') {
          const fileInput = container.querySelector('#sri-file');
          if (!fileInput || !fileInput.files.length) {
            this.showError(container, t('tools.sriGeneratorTool.errors.noFile'));
            this.setLoading(container, false);
            return;
          }
          const file = fileInput.files[0];
          resourceType = this.guessResourceType(file.name);
          arrayBuffer = await file.arrayBuffer();

        } else { // text
          const text = container.querySelector('#sri-text')?.value || '';
          if (!text.trim()) {
            this.showError(container, t('tools.sriGeneratorTool.errors.noText'));
            this.setLoading(container, false);
            return;
          }
          arrayBuffer = new TextEncoder().encode(text).buffer;
        }

        const hashes = await this.computeAllSRI(arrayBuffer, algorithms);

        // Resource type override from select
        const typeSelect = container.querySelector('#sri-resource-type');
        if (typeSelect) resourceType = typeSelect.value;

        this.renderResults(container, hashes, mode === 'url' ? resourceUrl : '', resourceType);

      } catch (err) {
        console.error('[SRI Generator]', err);
        this.showError(container, t('tools.sriGeneratorTool.errors.processingFailed'));
      } finally {
        this.setLoading(container, false);
      }
    },

    // ── UI ───────────────────────────────────────────────────────────────────

    buildUI: function (container) {
      if (!this.isSupported()) {
        container.innerHTML = `
          <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>${t('tools.sriGeneratorTool.errors.noWebCrypto')}</strong>
          </div>`;
        return;
      }

      container.innerHTML = `
        <div class="row g-3">

          <!-- Options Card -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <p class="h6 fw-semibold card-title mb-3"><i class="bi bi-sliders me-2"></i>${t('tools.sriGeneratorTool.optionsTitle')}</p>
                <div class="row g-3">

                  <!-- Algorithms -->
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">${t('tools.sriGeneratorTool.algorithmsLabel')}</label>
                    <div class="d-flex flex-wrap gap-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sri-algo-sha256" value="SHA-256">
                        <label class="form-check-label font-monospace" for="sri-algo-sha256">SHA-256</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sri-algo-sha384" value="SHA-384" checked>
                        <label class="form-check-label font-monospace" for="sri-algo-sha384">SHA-384 <span class="badge bg-success-subtle text-success-emphasis">${t('tools.sriGeneratorTool.recommended')}</span></label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sri-algo-sha512" value="SHA-512">
                        <label class="form-check-label font-monospace" for="sri-algo-sha512">SHA-512</label>
                      </div>
                    </div>
                    <div class="form-text">${t('tools.sriGeneratorTool.algorithmsHint')}</div>
                  </div>

                  <!-- Resource type -->
                  <div class="col-12 col-md-6" id="sri-resource-type-wrap">
                    <label for="sri-resource-type" class="form-label fw-semibold">${t('tools.sriGeneratorTool.resourceTypeLabel')}</label>
                    <select id="sri-resource-type" class="form-select form-select-sm">
                      <option value="script">${this.escapeHtml(t('tools.sriGeneratorTool.typeScript'))}</option>
                      <option value="stylesheet">${this.escapeHtml(t('tools.sriGeneratorTool.typeStylesheet'))}</option>
                    </select>
                    <div class="form-text">${t('tools.sriGeneratorTool.resourceTypeHint')}</div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Input Card -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <p class="h6 fw-semibold card-title mb-3"><i class="bi bi-input-cursor-text me-2"></i>${t('tools.sriGeneratorTool.inputTitle')}</p>

                <!-- Mode Selector -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">${t('tools.sriGeneratorTool.modeLabel')}</label>
                  <div class="btn-group btn-group-sm w-100" role="group">
                    <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-url" value="url" checked>
                    <label class="btn btn-outline-primary" for="sri-mode-url">
                      <i class="bi bi-link-45deg me-1"></i>${t('tools.sriGeneratorTool.modeUrl')}
                    </label>
                    <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-file" value="file">
                    <label class="btn btn-outline-primary" for="sri-mode-file">
                      <i class="bi bi-file-earmark-arrow-up me-1"></i>${t('tools.sriGeneratorTool.modeFile')}
                    </label>
                    <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-text" value="text">
                    <label class="btn btn-outline-primary" for="sri-mode-text">
                      <i class="bi bi-textarea-t me-1"></i>${t('tools.sriGeneratorTool.modeText')}
                    </label>
                  </div>
                </div>

                <!-- URL input -->
                <div id="sri-panel-url">
                  <label for="sri-url" class="form-label">${t('tools.sriGeneratorTool.urlLabel')}</label>
                  <div class="input-group input-group-sm mb-2">
                    <input type="url" id="sri-url" class="form-control form-control-sm font-monospace"
                      placeholder="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                      spellcheck="false">
                    <button id="sri-generate-from-url-btn" class="btn btn-primary">
                      <span id="sri-spinner" class="spinner-border spinner-border-sm me-1 d-none" role="status" aria-hidden="true"></span>
                      <i class="bi bi-shield-check me-1"></i>${t('tools.sriGeneratorTool.generateBtn')}
                    </button>
                    <button class="sri-clear-btn btn btn-outline-secondary">
                      <i class="bi bi-trash me-1"></i>${t('common.clear')}
                    </button>
                  </div>
                  <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.urlHint')}
                  </div>
                </div>

                <!-- File input -->
                <div id="sri-panel-file" class="d-none">
                  <label for="sri-file" class="form-label">${t('tools.sriGeneratorTool.fileLabel')}</label>
                  <div class="input-group input-group-sm mb-2">
                    <input type="file" id="sri-file" class="form-control form-control-sm">
                    <button id="sri-generate-from-file-btn" class="btn btn-primary">
                      <i class="bi bi-shield-check me-1"></i>${t('tools.sriGeneratorTool.generateBtn')}
                    </button>
                    <button class="sri-clear-btn btn btn-outline-secondary">
                      <i class="bi bi-trash me-1"></i>${t('common.clear')}
                    </button>
                  </div>
                  <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.fileHint')}
                  </div>
                </div>

                <!-- Text input -->
                <div id="sri-panel-text" class="d-none">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="sri-text" class="form-label mb-0">${t('tools.sriGeneratorTool.textLabel')}</label>
                    <button id="sri-load-sample-btn" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-file-earmark me-1"></i>${t('tools.sriGeneratorTool.loadSampleBtn')}
                    </button>
                  </div>
                  <textarea id="sri-text" class="form-control form-control-sm font-monospace" rows="6"
                    placeholder="${t('tools.sriGeneratorTool.textPlaceholder')}"></textarea>
                  <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.textHint')}
                  </div>
                  <div class="d-flex gap-2 mt-2">
                    <button id="sri-generate-from-text-btn" class="btn btn-sm btn-primary">
                      <i class="bi bi-shield-check me-1"></i>${t('tools.sriGeneratorTool.generateBtn')}
                    </button>
                    <button class="sri-clear-btn btn btn-sm btn-outline-secondary">
                      <i class="bi bi-trash me-1"></i>${t('common.clear')}
                    </button>
                  </div>
                </div>

                <div id="sri-error" class="alert alert-danger d-none mt-3" role="alert"></div>
              </div>
            </div>
          </div>

          <!-- Results -->
          <div class="col-12 d-none" id="sri-results-section" aria-live="polite">
            <div class="card">
              <div class="card-body">
                <p class="h6 fw-semibold card-title mb-3"><i class="bi bi-shield-check me-2"></i>${t('tools.sriGeneratorTool.outputTitle')}</p>
                <div id="sri-results" class="vstack gap-3"></div>
              </div>
            </div>
          </div>

        </div>
      `;

      this.attachEventListeners(container);
    },

    // ── Events ───────────────────────────────────────────────────────────────

    attachEventListeners: function (container) {
      // Mode switching
      container.querySelectorAll('input[name="sri-mode"]').forEach(radio => {
        radio.addEventListener('change', () => this.switchPanel(container, radio.value));
      });

      // Generate buttons
      container.querySelector('#sri-generate-from-url-btn')?.addEventListener('click', () => this.generate(container));
      container.querySelector('#sri-generate-from-file-btn')?.addEventListener('click', () => this.generate(container));
      container.querySelector('#sri-generate-from-text-btn')?.addEventListener('click', () => this.generate(container));

      // URL: Enter key + live auto-detect resource type
      container.querySelector('#sri-url')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') this.generate(container);
      });
      container.querySelector('#sri-url')?.addEventListener('input', e => {
        const typeSelect = container.querySelector('#sri-resource-type');
        if (typeSelect) typeSelect.value = this.guessResourceType(e.target.value);
      });

      // Clear (one button per panel, all share the same id)
      container.querySelectorAll('.sri-clear-btn').forEach(btn => {
        btn.addEventListener('click', () => this.clearAll(container));
      });

      // Load Sample (text mode)
      container.querySelector('#sri-load-sample-btn')?.addEventListener('click', () => {
        const textArea = container.querySelector('#sri-text');
        if (textArea) {
          textArea.value = '/* Sample: minimal CSS reset */\n*, *::before, *::after { box-sizing: border-box; }\nbody { margin: 0; font-family: system-ui, sans-serif; font-size: 1rem; line-height: 1.5; }\nh1, h2, h3 { margin: 0 0 0.5rem; }\na { color: inherit; text-decoration: underline; }';
        }
        const typeSelect = container.querySelector('#sri-resource-type');
        if (typeSelect) typeSelect.value = 'stylesheet';
        this.hideError(container);
      });

      // File: auto-detect resource type
      container.querySelector('#sri-file')?.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const typeSelect = container.querySelector('#sri-resource-type');
        if (typeSelect) typeSelect.value = this.guessResourceType(file.name);
      });
    },

    switchPanel: function (container, mode) {
      ['url', 'file', 'text'].forEach(m => {
        const panel = container.querySelector(`#sri-panel-${m}`);
        if (panel) panel.classList.toggle('d-none', m !== mode);
      });
      // Resource type is irrelevant in text mode (no HTML tag generated)
      const typeWrap = container.querySelector('#sri-resource-type-wrap');
      if (typeWrap) typeWrap.classList.toggle('d-none', mode === 'text');
    },

    clearAll: function (container) {
      const urlInput = container.querySelector('#sri-url');
      const fileInput = container.querySelector('#sri-file');
      const textArea = container.querySelector('#sri-text');
      if (urlInput) urlInput.value = '';
      if (fileInput) fileInput.value = '';
      if (textArea) textArea.value = '';

      this.hideError(container);

      const results = container.querySelector('#sri-results');
      const section = container.querySelector('#sri-results-section');
      if (results) results.innerHTML = '';
      if (section) section.classList.add('d-none');
    },

  });

})();
