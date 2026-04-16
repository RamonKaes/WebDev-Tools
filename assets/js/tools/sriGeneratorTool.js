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

  // ── Crypto ──────────────────────────────────────────────────────────────────

  function isSupported() {
    return !!(window.crypto && window.crypto.subtle);
  }

  function bufferToBase64(buffer) {
    const bytes = new Uint8Array(buffer);
    let binary = '';
    for (let i = 0; i < bytes.byteLength; i++) {
      binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary);
  }

  async function computeSRI(arrayBuffer, algorithm) {
    const hashBuffer = await window.crypto.subtle.digest(algorithm, arrayBuffer);
    const base64 = bufferToBase64(hashBuffer);
    const prefix = algorithm.toLowerCase().replace('-', '');
    return `${prefix}-${base64}`;
  }

  async function computeAllSRI(arrayBuffer, algorithms) {
    const results = {};
    for (const algo of algorithms) {
      results[algo] = await computeSRI(arrayBuffer, algo);
    }
    return results;
  }

  // ── Helpers ─────────────────────────────────────────────────────────────────

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function guessResourceType(urlOrFilename) {
    const s = (urlOrFilename || '').toLowerCase().split('?')[0];
    if (s.endsWith('.css')) return 'stylesheet';
    if (s.endsWith('.js') || s.endsWith('.mjs')) return 'script';
    return 'script'; // default
  }

  function buildHtmlTag(type, url, integrity, crossorigin) {
    const co = crossorigin || 'anonymous';
    if (type === 'stylesheet') {
      return `<link rel="stylesheet" href="${escapeHtml(url)}"\n     integrity="${integrity}"\n     crossorigin="${co}">`;
    }
    return `<script src="${escapeHtml(url)}"\n        integrity="${integrity}"\n        crossorigin="${co}"></script>`;
  }

  function getSelectedAlgorithms(container) {
    return ['SHA-256', 'SHA-384', 'SHA-512'].filter(algo => {
      const cb = container.querySelector(`#sri-algo-${algo.toLowerCase().replace('-', '')}`);
      return cb && cb.checked;
    });
  }

  // ── Render results ──────────────────────────────────────────────────────────

  function renderResults(container, hashes, resourceUrl, resourceType) {
    const resultsEl = container.querySelector('#sri-results');
    const noResultEl = container.querySelector('#sri-no-result');

    if (!resultsEl) return;

    noResultEl && noResultEl.classList.add('d-none');
    resultsEl.classList.remove('d-none');
    resultsEl.innerHTML = '';

    Object.entries(hashes).forEach(([algo, integrity]) => {
      const tag = buildHtmlTag(resourceType, resourceUrl || 'https://cdn.example.com/resource', integrity, 'anonymous');
      const algoLabel = algo;

      const block = document.createElement('div');
      block.className = 'card mb-3';
      block.innerHTML = `
        <div class="card-header d-flex justify-content-between align-items-center py-2">
          <span class="fw-semibold">
            <span class="badge bg-primary me-2">${escapeHtml(algoLabel)}</span>
            ${t('tools.sriGeneratorTool.integrityAttr')}
          </span>
          <button class="btn btn-sm btn-outline-secondary copy-integrity-btn" data-value="${escapeHtml(integrity)}">
            <i class="bi bi-clipboard me-1"></i>${t('common.copy')}
          </button>
        </div>
        <div class="card-body p-0">
          <pre class="m-0 p-3 rounded-bottom user-select-all" style="word-break:break-all;white-space:pre-wrap;font-size:0.8rem;">${escapeHtml(integrity)}</pre>
        </div>
        ${resourceUrl ? `
        <div class="card-footer py-2">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted fw-semibold">${t('tools.sriGeneratorTool.htmlTag')}</small>
            <button class="btn btn-sm btn-outline-secondary copy-tag-btn" data-value="${escapeHtml(tag)}">
              <i class="bi bi-clipboard me-1"></i>${t('common.copy')}
            </button>
          </div>
          <pre class="m-0 p-2 bg-body-secondary rounded user-select-all" style="font-size:0.8rem;white-space:pre-wrap;">${escapeHtml(tag)}</pre>
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
  }

  // ── Show / hide error ────────────────────────────────────────────────────────

  function showError(container, msg) {
    const el = container.querySelector('#sri-error');
    if (!el) return;
    el.textContent = msg;
    el.classList.remove('d-none');
  }

  function hideError(container) {
    const el = container.querySelector('#sri-error');
    if (el) el.classList.add('d-none');
  }

  function setLoading(container, loading) {
    const btn = container.querySelector('#sri-generate-btn');
    const spinner = container.querySelector('#sri-spinner');
    if (btn) btn.disabled = loading;
    if (spinner) spinner.classList.toggle('d-none', !loading);
  }

  // ── Generate ─────────────────────────────────────────────────────────────────

  async function generate(container) {
    hideError(container);

    const mode = container.querySelector('input[name="sri-mode"]:checked')?.value || 'url';
    const algorithms = getSelectedAlgorithms(container);

    if (!algorithms.length) {
      showError(container, t('tools.sriGeneratorTool.errors.noAlgorithm'));
      return;
    }

    setLoading(container, true);

    try {
      let arrayBuffer = null;
      let resourceUrl = '';
      let resourceType = 'script';

      if (mode === 'url') {
        resourceUrl = (container.querySelector('#sri-url')?.value || '').trim();
        if (!resourceUrl) {
          showError(container, t('tools.sriGeneratorTool.errors.noUrl'));
          setLoading(container, false);
          return;
        }
        if (!/^https?:\/\//i.test(resourceUrl)) {
          showError(container, t('tools.sriGeneratorTool.errors.invalidUrl'));
          setLoading(container, false);
          return;
        }
        resourceType = guessResourceType(resourceUrl);

        let response;
        try {
          response = await fetch(resourceUrl);
        } catch (fetchErr) {
          showError(container, t('tools.sriGeneratorTool.errors.fetchFailed') + ' (CORS?)');
          setLoading(container, false);
          return;
        }
        if (!response.ok) {
          showError(container, t('tools.sriGeneratorTool.errors.fetchError', { status: response.status }));
          setLoading(container, false);
          return;
        }
        arrayBuffer = await response.arrayBuffer();

      } else if (mode === 'file') {
        const fileInput = container.querySelector('#sri-file');
        if (!fileInput || !fileInput.files.length) {
          showError(container, t('tools.sriGeneratorTool.errors.noFile'));
          setLoading(container, false);
          return;
        }
        const file = fileInput.files[0];
        resourceType = guessResourceType(file.name);
        arrayBuffer = await file.arrayBuffer();

      } else { // text
        const text = container.querySelector('#sri-text')?.value || '';
        if (!text.trim()) {
          showError(container, t('tools.sriGeneratorTool.errors.noText'));
          setLoading(container, false);
          return;
        }
        arrayBuffer = new TextEncoder().encode(text).buffer;
      }

      const hashes = await computeAllSRI(arrayBuffer, algorithms);

      // Resource type override from select
      const typeSelect = container.querySelector('#sri-resource-type');
      if (typeSelect) resourceType = typeSelect.value;

      renderResults(container, hashes, mode === 'url' ? resourceUrl : '', resourceType);

    } catch (err) {
      console.error('[SRI Generator]', err);
      showError(container, t('tools.sriGeneratorTool.errors.processingFailed'));
    } finally {
      setLoading(container, false);
    }
  }

  // ── UI ───────────────────────────────────────────────────────────────────────

  function buildUI(container) {
    if (!isSupported()) {
      container.innerHTML = `
        <div class="alert alert-danger" role="alert">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>${t('tools.sriGeneratorTool.errors.noWebCrypto')}</strong>
        </div>`;
      return;
    }

    container.innerHTML = `
      <div class="row g-4">

        <!-- Input Card -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-input-cursor-text me-2"></i>${t('tools.sriGeneratorTool.inputTitle')}</h2>

              <!-- Mode Selector -->
              <div class="mb-3">
                <label class="form-label fw-semibold">${t('tools.sriGeneratorTool.modeLabel')}</label>
                <div class="btn-group w-100" role="group">
                  <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-url" value="url" checked autocomplete="off">
                  <label class="btn btn-outline-primary" for="sri-mode-url">
                    <i class="bi bi-link-45deg me-1"></i>${t('tools.sriGeneratorTool.modeUrl')}
                  </label>
                  <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-file" value="file" autocomplete="off">
                  <label class="btn btn-outline-primary" for="sri-mode-file">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i>${t('tools.sriGeneratorTool.modeFile')}
                  </label>
                  <input type="radio" class="btn-check" name="sri-mode" id="sri-mode-text" value="text" autocomplete="off">
                  <label class="btn btn-outline-primary" for="sri-mode-text">
                    <i class="bi bi-textarea-t me-1"></i>${t('tools.sriGeneratorTool.modeText')}
                  </label>
                </div>
              </div>

              <!-- URL input -->
              <div id="sri-panel-url">
                <label for="sri-url" class="form-label">${t('tools.sriGeneratorTool.urlLabel')}</label>
                <input type="url" id="sri-url" class="form-control font-monospace"
                  placeholder="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                  autocomplete="off" spellcheck="false">
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.urlHint')}
                </div>
              </div>

              <!-- File input -->
              <div id="sri-panel-file" class="d-none">
                <label for="sri-file" class="form-label">${t('tools.sriGeneratorTool.fileLabel')}</label>
                <input type="file" id="sri-file" class="form-control">
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.fileHint')}
                </div>
              </div>

              <!-- Text input -->
              <div id="sri-panel-text" class="d-none">
                <label for="sri-text" class="form-label">${t('tools.sriGeneratorTool.textLabel')}</label>
                <textarea id="sri-text" class="form-control font-monospace" rows="6"
                  placeholder="${t('tools.sriGeneratorTool.textPlaceholder')}"></textarea>
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>${t('tools.sriGeneratorTool.textHint')}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Options Card -->
        <div class="col-12 col-md-6">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h5 card-title mb-3"><i class="bi bi-sliders me-2"></i>${t('tools.sriGeneratorTool.optionsTitle')}</h2>

              <!-- Algorithms -->
              <div class="mb-3">
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
              <div>
                <label for="sri-resource-type" class="form-label fw-semibold">${t('tools.sriGeneratorTool.resourceTypeLabel')}</label>
                <select id="sri-resource-type" class="form-select">
                  <option value="script">${t('tools.sriGeneratorTool.typeScript')}</option>
                  <option value="stylesheet">${t('tools.sriGeneratorTool.typeStylesheet')}</option>
                </select>
                <div class="form-text">${t('tools.sriGeneratorTool.resourceTypeHint')}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick examples -->
        <div class="col-12 col-md-6">
          <div class="card h-100">
            <div class="card-body pb-0">
              <h2 class="h5 card-title mb-3"><i class="bi bi-lightning me-2"></i>${t('tools.sriGeneratorTool.examplesTitle')}</h2>
            </div>
            <div class="list-group list-group-flush" id="sri-examples">
                <button class="list-group-item list-group-item-action py-2 px-3 example-btn"
                  data-url="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
                  data-type="stylesheet">
                  <span class="badge bg-secondary me-2">CSS</span>Bootstrap 5 CSS
                </button>
                <button class="list-group-item list-group-item-action py-2 px-3 example-btn"
                  data-url="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
                  data-type="script">
                  <span class="badge bg-warning text-dark me-2">JS</span>Bootstrap 5 JS Bundle
                </button>
                <button class="list-group-item list-group-item-action py-2 px-3 example-btn"
                  data-url="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"
                  data-type="script">
                  <span class="badge bg-warning text-dark me-2">JS</span>jQuery 3.7.1
                </button>
                <button class="list-group-item list-group-item-action py-2 px-3 example-btn"
                  data-url="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"
                  data-type="script">
                  <span class="badge bg-warning text-dark me-2">JS</span>Alpine.js 3
                </button>
            </div>
          </div>
        </div>

        <!-- Generate button -->
        <div class="col-12">
          <div class="d-flex gap-2 align-items-center">
            <button id="sri-generate-btn" class="btn btn-primary">
              <span id="sri-spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
              <i class="bi bi-shield-check me-1"></i>${t('tools.sriGeneratorTool.generateBtn')}
            </button>
            <button id="sri-clear-btn" class="btn btn-outline-secondary">
              <i class="bi bi-x-circle me-1"></i>${t('common.clear')}
            </button>
          </div>
        </div>

        <!-- Error -->
        <div class="col-12">
          <div id="sri-error" class="alert alert-danger d-none" role="alert"></div>
        </div>

        <!-- Results -->
        <div class="col-12">
          <div id="sri-no-result" class="text-center text-muted py-4">
            <i class="bi bi-shield-check display-6 d-block mb-2 opacity-25"></i>
            <p class="mb-0">${t('tools.sriGeneratorTool.noResult')}</p>
          </div>
          <div id="sri-results" class="d-none"></div>
        </div>

      </div>
    `;

    attachEventListeners(container);
  }

  // ── Events ───────────────────────────────────────────────────────────────────

  function attachEventListeners(container) {
    // Mode switching
    container.querySelectorAll('input[name="sri-mode"]').forEach(radio => {
      radio.addEventListener('change', () => switchPanel(container, radio.value));
    });

    // Generate
    container.querySelector('#sri-generate-btn')?.addEventListener('click', () => generate(container));

    // URL: Enter key
    container.querySelector('#sri-url')?.addEventListener('keydown', e => {
      if (e.key === 'Enter') generate(container);
    });

    // Clear
    container.querySelector('#sri-clear-btn')?.addEventListener('click', () => clearAll(container));

    // Example buttons
    container.querySelectorAll('.example-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const url = btn.dataset.url;
        const type = btn.dataset.type;

        // Switch to URL mode
        const urlRadio = container.querySelector('#sri-mode-url');
        if (urlRadio) { urlRadio.checked = true; switchPanel(container, 'url'); }

        const urlInput = container.querySelector('#sri-url');
        if (urlInput) urlInput.value = url;

        const typeSelect = container.querySelector('#sri-resource-type');
        if (typeSelect) typeSelect.value = type;

        generate(container);
      });
    });

    // File: auto-detect resource type
    container.querySelector('#sri-file')?.addEventListener('change', e => {
      const file = e.target.files[0];
      if (!file) return;
      const type = guessResourceType(file.name);
      const typeSelect = container.querySelector('#sri-resource-type');
      if (typeSelect) typeSelect.value = type;
    });
  }

  function switchPanel(container, mode) {
    ['url', 'file', 'text'].forEach(m => {
      const panel = container.querySelector(`#sri-panel-${m}`);
      if (panel) panel.classList.toggle('d-none', m !== mode);
    });
  }

  function clearAll(container) {
    const urlInput = container.querySelector('#sri-url');
    const fileInput = container.querySelector('#sri-file');
    const textArea = container.querySelector('#sri-text');
    if (urlInput) urlInput.value = '';
    if (fileInput) fileInput.value = '';
    if (textArea) textArea.value = '';

    hideError(container);

    const results = container.querySelector('#sri-results');
    const noResult = container.querySelector('#sri-no-result');
    if (results) { results.classList.add('d-none'); results.innerHTML = ''; }
    if (noResult) noResult.classList.remove('d-none');
  }

  // ── Registration ─────────────────────────────────────────────────────────────

  window.Tools.register('sriGeneratorTool', {
    init: function () {
      if (!isSupported()) {
        console.warn('[SRI Generator] Web Crypto API not supported.');
      }
    },
    open: function (container) {
      buildUI(container);
    }
  });

})();
