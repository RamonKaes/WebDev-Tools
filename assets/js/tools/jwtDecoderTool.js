/**
 * JWT Decoder Tool
 *
 * Decode and analyze JSON Web Tokens (JWT). View header, payload, and signature.
 * Note: This tool only decodes JWTs, it does NOT verify signatures.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'jwtDecoderTool'})
      : '[jwtDecoderTool] Tools registry not available.';
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
   * Decode Base64URL string to UTF-8
   *
   * @param {string} str - Base64URL encoded string
   * @returns {string} - Decoded string
   * @throws {Error} - If decoding fails
   */
  function base64UrlDecode(str) {
    // Replace non-url compatible chars with base64 standard chars
    let base64 = str.replace(/-/g, '+').replace(/_/g, '/');

    // Pad with '=' to make length a multiple of 4
    const pad = base64.length % 4;
    if (pad) {
      base64 += '='.repeat(4 - pad);
    }

    try {
      return decodeURIComponent(atob(base64).split('').map(c =>
        '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
      ).join(''));
    } catch (e) {
      throw new Error('Invalid Base64URL encoding');
    }
  }

  /**
   * Parse JWT token into header, payload, and signature components
   *
   * Security Note: This function only decodes JWT structure, it does NOT verify
   * the signature. Never trust JWT content without proper server-side validation.
   *
   * @param {string} token - JWT token string
   * @returns {object} - Parsed JWT with header, payload, signature, and raw parts
   * @throws {Error} - If JWT format is invalid
   */
  function parseJWT(token) {
    const parts = token.split('.');

    if (parts.length !== 3) {
      throw new Error('Invalid JWT format. Expected 3 parts (header.payload.signature)');
    }

    const [headerB64, payloadB64, signatureB64] = parts;

    let header, payload;

    try {
      header = JSON.parse(base64UrlDecode(headerB64));
    } catch (e) {
      throw new Error('Failed to decode header: ' + e.message);
    }

    try {
      payload = JSON.parse(base64UrlDecode(payloadB64));
    } catch (e) {
      throw new Error('Failed to decode payload: ' + e.message);
    }

    return {
      header,
      payload,
      signature: signatureB64,
      raw: {
        header: headerB64,
        payload: payloadB64,
        signature: signatureB64
      }
    };
  }

  /**
   * Format JSON with syntax highlighting
   *
   * @param {object} obj - Object to format
   * @returns {string} - HTML formatted JSON with color highlighting
   */
  function formatJSON(obj) {
    const json = JSON.stringify(obj, null, 2);
    return json
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/("(?:[^"\\]|\\.)*")\s*:/g, '<span class="text-primary">$1</span>:')
      .replace(/:\s*("(?:[^"\\]|\\.)*")/g, ': <span class="text-success">$1</span>')
      .replace(/:\s*(\d+)/g, ': <span class="text-info">$1</span>')
      .replace(/:\s*(true|false|null)/g, ': <span class="text-warning">$1</span>');
  }

  /**
   * Check if JWT token has expired
   *
   * @param {object} payload - JWT payload object
   * @returns {object|null} - Expiry information or null if no exp claim
   */
  function checkExpiry(payload) {
    if (!payload.exp) return null;

    const expiryDate = new Date(payload.exp * 1000);
    const now = new Date();
    const isExpired = expiryDate < now;
    const userLocale = document.documentElement.lang || 'en';

    return {
      date: expiryDate,
      isExpired,
      formatted: expiryDate.toLocaleString(userLocale)
    };
  }

  window.Tools.register('jwtDecoderTool', {
    open: function (container) {
      try {
        container.innerHTML = `
          <div class="row g-4">
            <!-- JWT Input -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h2 class="h5 card-title mb-3">
                    <i class="bi bi-box-arrow-in-down me-2"></i>${t('tools.jwtDecoderTool.inputTitle')}
                  </h2>

                  <textarea
                    class="form-control font-monospace mb-3"
                    id="jwtInput"
                    rows="4"
                    placeholder="${t('tools.jwtDecoderTool.inputPlaceholder')}"
                  ></textarea>

                  <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary" id="decodeBtn">
                      <i class="bi bi-unlock me-2"></i>${t('tools.jwtDecoderTool.decode')}
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" id="clearBtn">
                      <i class="bi bi-trash me-2"></i>${t('common.clear')}
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" id="exampleBtn">
                      <i class="bi bi-lightning me-2"></i>${t('tools.jwtDecoderTool.loadExample')}
                    </button>
                  </div>

                  <div class="alert alert-danger mt-3 d-none" id="errorAlert" role="alert"></div>
                </div>
              </div>
            </div>

            <!-- Results -->
            <div class="col-12 d-none" id="resultsSection">
              <div class="row g-4">
                <!-- Header -->
                <div class="col-12 col-lg-6">
                  <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                      <h3 class="h6 mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>${t('tools.jwtDecoderTool.header')}
                      </h3>
                    </div>
                    <div class="card-body">
                      <pre class="mb-0 p-3 bg-body-secondary rounded pre-scrollable" id="headerContent"></pre>
                    </div>
                  </div>
                </div>

                <!-- Payload -->
                <div class="col-12 col-lg-6">
                  <div class="card h-100">
                    <div class="card-header bg-success text-white">
                      <h3 class="h6 mb-0">
                        <i class="bi bi-file-earmark-code me-2"></i>${t('tools.jwtDecoderTool.payload')}
                      </h3>
                    </div>
                    <div class="card-body">
                      <pre class="mb-0 p-3 bg-body-secondary rounded pre-scrollable" id="payloadContent"></pre>
                    </div>
                  </div>
                </div>

                <!-- Info Cards -->
                <div class="col-12 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h3 class="h6 mb-3">
                        <i class="bi bi-info-circle me-2"></i>${t('tools.jwtDecoderTool.algorithm')}
                      </h3>
                      <p class="mb-0 font-monospace fs-5" id="algorithmInfo">-</p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6">
                  <div class="card" id="expiryCard">
                    <div class="card-body">
                      <h3 class="h6 mb-3">
                        <i class="bi bi-clock me-2"></i>${t('tools.jwtDecoderTool.expiry')}
                      </h3>
                      <p class="mb-0" id="expiryInfo">-</p>
                    </div>
                  </div>
                </div>

                <!-- Security Warning -->
                <div class="col-12">
                  <div class="alert alert-danger mb-3" role="alert">
                    <div class="d-inline-flex align-items-center">
                      <i class="bi bi-exclamation-triangle-fill me-2"></i>
                      <strong>${t('tools.jwtDecoderTool.verificationWarning')}</strong>
                    </div>
                    <p class="mb-0 mt-2 small">${t('tools.jwtDecoderTool.verificationWarningDetails')}</p>
                  </div>
                </div>

                <!-- Signature -->
                <div class="col-12">
                  <div class="card">
                    <div class="card-header bg-warning text-dark">
                      <h3 class="h6 mb-0">
                        <i class="bi bi-shield-lock me-2"></i>${t('tools.jwtDecoderTool.signature')}
                      </h3>
                    </div>
                    <div class="card-body">
                      <p class="text-muted small mb-2">${t('tools.jwtDecoderTool.signatureNote')}</p>
                      <code class="d-block p-3 bg-body-secondary rounded text-break" id="signatureContent"></code>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;

        this.initializeTool(container);

      } catch (e) {
        container.innerHTML = `
          <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>${t('common.error')}:</strong> ${e.message}
          </div>
        `;
        console.error('Error in jwtDecoderTool.open:', e);
      }
    },

    initializeTool: function(container) {
      const jwtInput = container.querySelector('#jwtInput');
      const decodeBtn = container.querySelector('#decodeBtn');
      const clearBtn = container.querySelector('#clearBtn');
      const exampleBtn = container.querySelector('#exampleBtn');
      const errorAlert = container.querySelector('#errorAlert');
      const resultsSection = container.querySelector('#resultsSection');
      const headerContent = container.querySelector('#headerContent');
      const payloadContent = container.querySelector('#payloadContent');
      const signatureContent = container.querySelector('#signatureContent');
      const algorithmInfo = container.querySelector('#algorithmInfo');
      const expiryInfo = container.querySelector('#expiryInfo');
      const expiryCard = container.querySelector('#expiryCard');

      /**
       * Show error message
       *
       * @param {string} message - Error message to display
       */
      function showError(message) {
        errorAlert.textContent = message;
        errorAlert.classList.remove('d-none');
        resultsSection.classList.add('d-none');
      }

      /**
       * Hide error message
       */
      function hideError() {
        errorAlert.classList.add('d-none');
      }

      /**
       * Decode JWT token and display results
       */
      function decode() {
        const token = jwtInput.value.trim();

        if (!token) {
          showError(t('tools.jwtDecoderTool.errorEmpty'));
          return;
        }

        try {
          const decoded = parseJWT(token);
          hideError();
          displayResults(decoded);
        } catch (e) {
          showError(e.message);
        }
      }

      /**
       * Display decoded JWT results
       *
       * @param {object} decoded - Decoded JWT object
       */
      function displayResults(decoded) {
        // Header
        headerContent.innerHTML = formatJSON(decoded.header);

        // Payload
        payloadContent.innerHTML = formatJSON(decoded.payload);

        // Signature
        signatureContent.textContent = decoded.signature;

        // Algorithm
        algorithmInfo.textContent = decoded.header.alg || 'Unknown';

        // Expiry
        const expiry = checkExpiry(decoded.payload);
        if (expiry) {
          expiryInfo.innerHTML = `
            <div class="${expiry.isExpired ? 'text-danger' : 'text-success'}">
              <i class="bi bi-${expiry.isExpired ? 'x-circle' : 'check-circle'} me-2"></i>
              ${expiry.formatted}
              ${expiry.isExpired ? '<br><small>' + t('tools.jwtDecoderTool.expired') + '</small>' : ''}
            </div>
          `;
          expiryCard.classList.remove('d-none');
        } else {
          expiryInfo.textContent = t('tools.jwtDecoderTool.noExpiry');
          expiryCard.classList.remove('d-none');
        }

        // Show results
        resultsSection.classList.remove('d-none');
      }

      /**
       * Load example JWT for demonstration
       */
      function loadExample() {
        const exampleJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjE1MTYyNDI2MjJ9.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        jwtInput.value = exampleJWT;
        decode();
      }

      decodeBtn.addEventListener('click', decode);

      clearBtn.addEventListener('click', () => {
        jwtInput.value = '';
        hideError();
        resultsSection.classList.add('d-none');
        jwtInput.focus();
      });

      exampleBtn.addEventListener('click', loadExample);

      jwtInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
          decode();
        }
      });
    }
  });

  if (typeof window.logger !== 'undefined') {
    window.logger.info('JWT Decoder Tool loaded');
  }
})();
