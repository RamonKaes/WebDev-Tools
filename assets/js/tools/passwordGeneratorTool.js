/**
 * Password Generator Tool
 *
 * Generate secure passwords, memorable passphrases, and pronounceable patterns.
 * Uses crypto.getRandomValues() for cryptographically secure random generation.
 */

(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    const msg = (window.i18n && typeof window.i18n.t === 'function')
      ? window.i18n.t('errors.registry_missing', {tool: 'passwordGeneratorTool'})
      : '[passwordGeneratorTool] Tools registry not available.';
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

  let WORDLIST = null;

  /**
   * Lazy load EFF wordlist for passphrase generation
   *
   * @returns {Promise<Array<string>>} - Array of words
   * @throws {Error} - If wordlist fails to load
   */
  async function loadWordlist() {
    if (!WORDLIST) {
      try {
        const module = await import('../lib/wordlist.js');
        WORDLIST = module.WORDLIST;
      } catch (error) {
        console.error('Failed to load wordlist:', error);
        throw new Error(t('errors.wordlist_load_failed'));
      }
    }
    return WORDLIST;
  }

  window.Tools.register('passwordGeneratorTool', {
    init: function () {
      console.debug('Password Generator Tool initialized');
    },

    open: function (container) {
      try {
        container.innerHTML = '';

        // Main content
        const row = document.createElement('div');
        row.className = 'row g-4';

        // Mode Selector Card
        const modeCol = document.createElement('div');
        modeCol.className = 'col-12';
        modeCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-sliders me-2"></i>${t('tools.passwordGeneratorTool.modeTitle')}</h2>
              <div class="btn-group w-100" role="group" aria-label="${t('tools.passwordGeneratorTool.modeTitle')}">
                <input type="radio" class="btn-check" name="generatorMode" id="modePassword" value="password" checked autocomplete="off">
                <label class="btn btn-outline-primary btn-sm" for="modePassword">
                  <i class="bi bi-key me-2"></i>${t('tools.passwordGeneratorTool.modePassword')}
                </label>

                <input type="radio" class="btn-check" name="generatorMode" id="modePassphrase" value="passphrase" autocomplete="off">
                <label class="btn btn-outline-primary btn-sm" for="modePassphrase">
                  <i class="bi bi-chat-square-text me-2"></i>${t('tools.passwordGeneratorTool.modePassphrase')}
                </label>

                <input type="radio" class="btn-check" name="generatorMode" id="modePattern" value="pattern" autocomplete="off">
                <label class="btn btn-outline-primary btn-sm" for="modePattern">
                  <i class="bi bi-bezier me-2"></i>${t('tools.passwordGeneratorTool.modePattern')}
                </label>
              </div>
            </div>
          </div>
        `;
        row.appendChild(modeCol);

        // Options Card (content changes based on mode)
        const optionsCol = document.createElement('div');
        optionsCol.className = 'col-12';
        optionsCol.id = 'optionsCard';
        row.appendChild(optionsCol);

        // Output Card
        const outputCol = document.createElement('div');
        outputCol.className = 'col-12';
        outputCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-key me-2"></i>${t('tools.passwordGeneratorTool.outputTitle')}</h2>
              <div class="mb-3">
                <textarea class="form-control bg-body-secondary font-monospace" id="passwordOutput" rows="10" readonly
                  placeholder="${t('tools.passwordGeneratorTool.outputPlaceholder')}"></textarea>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-outline-secondary btn-sm" id="copyPasswords">
                  <i class="bi bi-clipboard me-2"></i>${t('tools.passwordGeneratorTool.copy')}
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="clearPasswords">
                  <i class="bi bi-trash me-2"></i>${t('tools.passwordGeneratorTool.clear')}
                </button>
                <div class="dropdown">
                  <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-2"></i>${t('tools.passwordGeneratorTool.download')}
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-format="txt">${t('tools.passwordGeneratorTool.downloadTxt')}</a></li>
                    <li><a class="dropdown-item" href="#" data-format="csv">${t('tools.passwordGeneratorTool.downloadCsv')}</a></li>
                    <li><a class="dropdown-item" href="#" data-format="json">${t('tools.passwordGeneratorTool.downloadJson')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        `;
        row.appendChild(outputCol);

        // Strength Indicator Card
        const strengthCol = document.createElement('div');
        strengthCol.className = 'col-12';
        strengthCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-speedometer me-2"></i>${t('tools.passwordGeneratorTool.strengthTitle')}</h2>
              <div id="strengthIndicator">
                <p class="text-muted">${t('tools.passwordGeneratorTool.strengthPlaceholder')}</p>
              </div>
            </div>
          </div>
        `;
        row.appendChild(strengthCol);

        container.appendChild(row);

        // Initialize functionality
        this.initializeGenerator(container);

      } catch (e) {
        container.innerHTML = `
          <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>${t('tools.passwordGeneratorTool.errorLoading')}:</strong> ${e.message}
          </div>
        `;
        console.error('Error in passwordGeneratorTool.open:', e);
      }
    },

    initializeGenerator: function(container) {
      const optionsCard = container.querySelector('#optionsCard');
      const outputTextarea = container.querySelector('#passwordOutput');
      const strengthIndicator = container.querySelector('#strengthIndicator');

      // Mode switcher
      const modeRadios = container.querySelectorAll('input[name="generatorMode"]');
      modeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
          this.renderOptions(optionsCard, radio.value);
          this.setupEventListeners(container);
        });
      });

      // Initial render
      this.renderOptions(optionsCard, 'password');
      this.setupEventListeners(container);

      // Copy button
      const copyBtn = container.querySelector('#copyPasswords');
      copyBtn.addEventListener('click', async () => {
        if (outputTextarea.value) {
          const success = await window.ClipboardUtils.copyToClipboard(outputTextarea.value);
          
          if (success) {
            const icon = copyBtn.querySelector('i');
            if (icon) {
              const originalClass = icon.className;
              icon.className = 'bi bi-check me-2';
              setTimeout(() => { icon.className = originalClass; }, 2000);
            }
          }
        }
      });

      // Clear button
      const clearBtn = container.querySelector('#clearPasswords');
      clearBtn.addEventListener('click', () => {
        outputTextarea.value = '';
        strengthIndicator.innerHTML = `<p class="text-muted">${t('tools.passwordGeneratorTool.strengthPlaceholder')}</p>`;
      });

      // Download buttons
      const downloadLinks = container.querySelectorAll('[data-format]');
      downloadLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          const format = e.currentTarget.dataset.format;
          this.downloadPasswords(outputTextarea.value, format);
        });
      });
    },

    /**
     * Render options UI based on selected mode
     *
     * @param {HTMLElement} container - Container element
     * @param {string} mode - Generation mode ('password', 'passphrase', 'pattern')
     */
    renderOptions: function(container, mode) {
      if (mode === 'password') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-gear me-2"></i>${t('tools.passwordGeneratorTool.optionsTitle')}</h2>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="passwordLength" class="form-label">${t('tools.passwordGeneratorTool.length')}: <strong id="lengthValue">16</strong></label>
                  <input type="range" class="form-range" id="passwordLength" min="8" max="128" value="16">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.lengthHint')}</small>
                </div>
                <div class="col-md-6">
                  <label for="passwordCount" class="form-label">${t('tools.passwordGeneratorTool.count')}</label>
                  <input type="number" class="form-control form-control-sm" id="passwordCount" value="1" min="1" max="100">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.countHint')}</small>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">${t('tools.passwordGeneratorTool.charsetTitle')}</label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="charsetPreset" id="charsetStandard" value="standard" checked>
                      <label class="form-check-label" for="charsetStandard">
                        ${t('tools.passwordGeneratorTool.charsetStandard')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="charsetPreset" id="charsetAlphanumeric" value="alphanumeric">
                      <label class="form-check-label" for="charsetAlphanumeric">
                        ${t('tools.passwordGeneratorTool.charsetAlphanumeric')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="charsetPreset" id="charsetHex" value="hex">
                      <label class="form-check-label" for="charsetHex">
                        ${t('tools.passwordGeneratorTool.charsetHex')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="charsetPreset" id="charsetCustom" value="custom">
                      <label class="form-check-label" for="charsetCustom">
                        ${t('tools.passwordGeneratorTool.charsetCustom')}
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6 hidden" id="customCharsetOptions">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="includeUppercase" checked>
                      <label class="form-check-label" for="includeUppercase">
                        ${t('tools.passwordGeneratorTool.uppercase')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="includeLowercase" checked>
                      <label class="form-check-label" for="includeLowercase">
                        ${t('tools.passwordGeneratorTool.lowercase')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="includeNumbers" checked>
                      <label class="form-check-label" for="includeNumbers">
                        ${t('tools.passwordGeneratorTool.numbers')}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="includeSymbols" checked>
                      <label class="form-check-label" for="includeSymbols">
                        ${t('tools.passwordGeneratorTool.symbols')}
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="excludeAmbiguous">
                <label class="form-check-label" for="excludeAmbiguous">
                  ${t('tools.passwordGeneratorTool.excludeAmbiguous')}
                </label>
              </div>

              <button class="btn btn-primary btn-sm" id="generatePassword">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.passwordGeneratorTool.generate')}
              </button>
            </div>
          </div>
        `;
      } else if (mode === 'passphrase') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-gear me-2"></i>${t('tools.passwordGeneratorTool.optionsTitle')}</h2>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="wordCount" class="form-label">${t('tools.passwordGeneratorTool.wordCount')}: <strong id="wordCountValue">4</strong></label>
                  <input type="range" class="form-range" id="wordCount" min="3" max="8" value="4">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.wordCountHint')}</small>
                </div>
                <div class="col-md-4">
                  <label for="wordSeparator" class="form-label">${t('tools.passwordGeneratorTool.separator')}</label>
                  <select class="form-select form-select-sm" id="wordSeparator">
                    <option value="-">- (${t('tools.passwordGeneratorTool.hyphen')})</option>
                    <option value="_">_ (${t('tools.passwordGeneratorTool.underscore')})</option>
                    <option value=" ">${t('tools.passwordGeneratorTool.space')}</option>
                    <option value="">${t('tools.passwordGeneratorTool.none')}</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="passphraseCount" class="form-label">${t('tools.passwordGeneratorTool.count')}</label>
                  <input type="number" class="form-control form-control-sm" id="passphraseCount" value="1" min="1" max="100">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.countHint')}</small>
                </div>
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="capitalizeWords" checked>
                  <label class="form-check-label" for="capitalizeWords">
                    ${t('tools.passwordGeneratorTool.capitalize')}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="includeNumber">
                  <label class="form-check-label" for="includeNumber">
                    ${t('tools.passwordGeneratorTool.includeNumber')}
                  </label>
                </div>
              </div>

              <button class="btn btn-primary btn-sm" id="generatePassphrase">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.passwordGeneratorTool.generate')}
              </button>
            </div>
          </div>
        `;
      } else if (mode === 'pattern') {
        container.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-gear me-2"></i>${t('tools.passwordGeneratorTool.optionsTitle')}</h2>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="patternLength" class="form-label">${t('tools.passwordGeneratorTool.patternLength')}: <strong id="patternLengthValue">12</strong></label>
                  <input type="range" class="form-range" id="patternLength" min="6" max="32" value="12">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.patternLengthHint')}</small>
                </div>
                <div class="col-md-6">
                  <label for="patternCount" class="form-label">${t('tools.passwordGeneratorTool.count')}</label>
                  <input type="number" class="form-control form-control-sm" id="patternCount" value="1" min="1" max="100">
                  <small class="text-muted">${t('tools.passwordGeneratorTool.countHint')}</small>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">${t('tools.passwordGeneratorTool.patternType')}</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="patternType" id="patternCVVC" value="cvvc" checked>
                  <label class="form-check-label" for="patternCVVC">
                    CVVC (${t('tools.passwordGeneratorTool.patternCVVC')})
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="patternType" id="patternCVC" value="cvc">
                  <label class="form-check-label" for="patternCVC">
                    CVC (${t('tools.passwordGeneratorTool.patternCVC')})
                  </label>
                </div>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="patternCapitalize" checked>
                <label class="form-check-label" for="patternCapitalize">
                  ${t('tools.passwordGeneratorTool.patternCapitalize')}
                </label>
              </div>

              <button class="btn btn-primary btn-sm" id="generatePattern">
                <i class="bi bi-arrow-clockwise me-2"></i>${t('tools.passwordGeneratorTool.generate')}
              </button>
            </div>
          </div>
        `;
      }
    },

    /**
     * Setup event listeners for current generation mode
     *
     * @param {HTMLElement} container - Container element
     */
    setupEventListeners: function(container) {
      const mode = container.querySelector('input[name="generatorMode"]:checked').value;
      const outputTextarea = container.querySelector('#passwordOutput');
      const strengthIndicator = container.querySelector('#strengthIndicator');

      if (mode === 'password') {
        // Length slider
        const lengthSlider = container.querySelector('#passwordLength');
        const lengthValue = container.querySelector('#lengthValue');

        const updateLengthAndMaybeRegenerate = () => {
          lengthValue.textContent = lengthSlider.value;
          if (outputTextarea.value.trim()) {
            generateBtn.click();
          }
        };

        // Charset preset switcher
        const charsetRadios = container.querySelectorAll('input[name="charsetPreset"]');
        const customOptions = container.querySelector('#customCharsetOptions');

        const show = (el) => el && el.classList.remove('d-none');
        const hide = (el) => el && el.classList.add('d-none');

        charsetRadios.forEach(radio => {
          radio.addEventListener('change', () => {
            if (radio.value === 'custom') {
              show(customOptions);
            } else {
              hide(customOptions);
            }
          });
        });

        // Generate button
        const generateBtn = container.querySelector('#generatePassword');
        lengthSlider.addEventListener('input', updateLengthAndMaybeRegenerate);
        generateBtn.addEventListener('click', () => {
          const length = parseInt(lengthSlider.value);
          const count = parseInt(container.querySelector('#passwordCount').value);
          const preset = container.querySelector('input[name="charsetPreset"]:checked').value;
          const excludeAmbiguous = container.querySelector('#excludeAmbiguous').checked;

          let charset = '';
          if (preset === 'standard') {
            charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
          } else if (preset === 'alphanumeric') {
            charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
          } else if (preset === 'hex') {
            charset = '0123456789abcdef';
          } else if (preset === 'custom') {
            const upper = container.querySelector('#includeUppercase').checked;
            const lower = container.querySelector('#includeLowercase').checked;
            const numbers = container.querySelector('#includeNumbers').checked;
            const symbols = container.querySelector('#includeSymbols').checked;

            if (upper) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if (lower) charset += 'abcdefghijklmnopqrstuvwxyz';
            if (numbers) charset += '0123456789';
            if (symbols) charset += '!@#$%^&*()_+-=[]{}|;:,.<>?';
          }

          if (excludeAmbiguous) {
            const ambiguous = '0O1lI';
            charset = charset.split('').filter(c => !ambiguous.includes(c)).join('');
          }

          if (!charset) {
            outputTextarea.value = t('tools.passwordGeneratorTool.errorNoCharset');
            return;
          }

          const passwords = [];
          for (let i = 0; i < count; i++) {
            passwords.push(this.generatePassword(length, charset));
          }

          outputTextarea.value = passwords.join('\n');
          if (passwords.length > 0) {
            this.updateStrengthIndicator(strengthIndicator, passwords[0]);
          }
        });

        // Auto-generate on load
        generateBtn.click();

      } else if (mode === 'passphrase') {
        // Word count slider
        const wordCountSlider = container.querySelector('#wordCount');
        const wordCountValue = container.querySelector('#wordCountValue');

        const updateWordCountAndMaybeRegenerate = () => {
          wordCountValue.textContent = wordCountSlider.value;
          if (outputTextarea.value.trim()) {
            generateBtn.click();
          }
        };

        // Generate button
        const generateBtn = container.querySelector('#generatePassphrase');
        wordCountSlider.addEventListener('input', updateWordCountAndMaybeRegenerate);
        generateBtn.addEventListener('click', async () => {
          const wordCount = parseInt(wordCountSlider.value);
          const separator = container.querySelector('#wordSeparator').value;
          const capitalize = container.querySelector('#capitalizeWords').checked;
          const includeNumber = container.querySelector('#includeNumber').checked;
          const count = parseInt(container.querySelector('#passphraseCount').value);

          const passphrases = [];
          for (let i = 0; i < count; i++) {
            passphrases.push(await this.generatePassphrase(wordCount, separator, capitalize, includeNumber));
          }

          outputTextarea.value = passphrases.join('\n');
          if (passphrases.length > 0) {
            this.updateStrengthIndicator(strengthIndicator, passphrases[0]);
          }
        });

        // Auto-generate on load
        generateBtn.click();

      } else if (mode === 'pattern') {
        // Pattern length slider
        const patternLengthSlider = container.querySelector('#patternLength');
        const patternLengthValue = container.querySelector('#patternLengthValue');

        const updatePatternLengthAndMaybeRegenerate = () => {
          patternLengthValue.textContent = patternLengthSlider.value;
          if (outputTextarea.value.trim()) {
            generateBtn.click();
          }
        };

        // Generate button
        const generateBtn = container.querySelector('#generatePattern');
        patternLengthSlider.addEventListener('input', updatePatternLengthAndMaybeRegenerate);
        generateBtn.addEventListener('click', () => {
          const length = parseInt(patternLengthSlider.value);
          const patternType = container.querySelector('input[name="patternType"]:checked').value;
          const capitalize = container.querySelector('#patternCapitalize').checked;
          const count = parseInt(container.querySelector('#patternCount').value);

          const patterns = [];
          for (let i = 0; i < count; i++) {
            patterns.push(this.generatePattern(length, patternType, capitalize));
          }

          outputTextarea.value = patterns.join('\n');
          if (patterns.length > 0) {
            this.updateStrengthIndicator(strengthIndicator, patterns[0]);
          }
        });

        // Auto-generate on load
        generateBtn.click();
      }
    },

    /**
     * Generate random password using crypto.getRandomValues()
     *
     * Security: Uses cryptographically secure random number generator.
     *
     * @param {number} length - Password length
     * @param {string} charset - Character set to use
     * @returns {string} - Generated password
     */
    generatePassword: function(length, charset) {
      let password = '';
      const array = new Uint8Array(length);
      window.crypto.getRandomValues(array);

      for (let i = 0; i < length; i++) {
        password += charset[array[i] % charset.length];
      }

      return password;
    },

    /**
     * Generate passphrase from EFF wordlist
     *
     * Security: Uses crypto.getRandomValues() for word selection.
     *
     * @param {number} wordCount - Number of words
     * @param {string} separator - Word separator
     * @param {boolean} capitalize - Whether to capitalize first letter of each word
     * @param {boolean} includeNumber - Whether to append random number
     * @returns {Promise<string>} - Generated passphrase
     */
    generatePassphrase: async function(wordCount, separator, capitalize, includeNumber) {
      const wordlist = await loadWordlist();

      const words = [];
      const array = new Uint32Array(wordCount);
      window.crypto.getRandomValues(array);

      for (let i = 0; i < wordCount; i++) {
        let word = wordlist[array[i] % wordlist.length];
        if (capitalize) {
          word = word.charAt(0).toUpperCase() + word.slice(1);
        }
        words.push(word);
      }

      let passphrase = words.join(separator);

      if (includeNumber) {
        const numArray = new Uint8Array(1);
        window.crypto.getRandomValues(numArray);
        const num = (numArray[0] % 90) + 10; // 10-99
        passphrase += separator + num;
      }

      return passphrase;
    },

    /**
     * Generate pronounceable password using consonant-vowel patterns
     *
     * @param {number} length - Pattern length
     * @param {string} patternType - Pattern type ('cvvc' or 'cvc')
     * @param {boolean} capitalize - Whether to capitalize first letter
     * @returns {string} - Generated pattern-based password
     */
    generatePattern: function(length, patternType, capitalize) {
      const consonants = 'bcdfghjklmnpqrstvwxyz';
      const vowels = 'aeiou';
      let password = '';
      let pattern = '';

      // Create pattern
      if (patternType === 'cvvc') {
        pattern = 'cvvc'.repeat(Math.ceil(length / 4));
      } else {
        pattern = 'cvc'.repeat(Math.ceil(length / 3));
      }

      pattern = pattern.slice(0, length);

      const array = new Uint8Array(length);
      window.crypto.getRandomValues(array);

      for (let i = 0; i < length; i++) {
        if (pattern[i] === 'c') {
          password += consonants[array[i] % consonants.length];
        } else {
          password += vowels[array[i] % vowels.length];
        }
      }

      if (capitalize) {
        password = password.charAt(0).toUpperCase() + password.slice(1);
      }

      return password;
    },

    /**
     * Update strength indicator with entropy calculation
     *
     * @param {HTMLElement} indicator - Indicator element
     * @param {string} password - Password to analyze
     */
    updateStrengthIndicator: function(indicator, password) {
      if (!indicator) {
        return;
      }

      const normalizedPassword = typeof password === 'string' ? password : '';

      if (!normalizedPassword.length) {
        indicator.innerHTML = `<p class="text-muted">${t('tools.passwordGeneratorTool.strengthPlaceholder')}</p>`;
        return;
      }

      let charset = 0;
      if (/[a-z]/.test(normalizedPassword)) charset += 26;
      if (/[A-Z]/.test(normalizedPassword)) charset += 26;
      if (/[0-9]/.test(normalizedPassword)) charset += 10;
      if (/[^a-zA-Z0-9]/.test(normalizedPassword)) charset += 32;

      if (!charset) {
        // Fall back to unique character count for non-Latin character sets
        charset = Math.max(new Set([...normalizedPassword]).size, 1);
      }

      const entropyRaw = normalizedPassword.length * Math.log2(charset);
      const entropy = Number.isFinite(entropyRaw) && entropyRaw > 0 ? entropyRaw : 0;

      const entropyCap = 120; // entropy level that corresponds to a full bar
      const progressWidth = Math.min(
        Math.max((entropy / entropyCap) * 100, 0),
        100
      );

      let strength = '';
      let color = '';
      let description = '';
      let crackTime = '';

      if (entropy < 28) {
        strength = t('tools.passwordGeneratorTool.strengthVeryWeak');
        color = 'danger';
        description = t('tools.passwordGeneratorTool.strengthVeryWeakDesc');
        crackTime = t('tools.passwordGeneratorTool.crackSeconds');
      } else if (entropy < 36) {
        strength = t('tools.passwordGeneratorTool.strengthWeak');
        color = 'warning';
        description = t('tools.passwordGeneratorTool.strengthWeakDesc');
        crackTime = t('tools.passwordGeneratorTool.crackMinutes');
      } else if (entropy < 60) {
        strength = t('tools.passwordGeneratorTool.strengthMedium');
        color = 'info';
        description = t('tools.passwordGeneratorTool.strengthMediumDesc');
        crackTime = t('tools.passwordGeneratorTool.crackHours');
      } else if (entropy < 80) {
        strength = t('tools.passwordGeneratorTool.strengthStrong');
        color = 'success';
        description = t('tools.passwordGeneratorTool.strengthStrongDesc');
        crackTime = t('tools.passwordGeneratorTool.crackYears');
      } else {
        strength = t('tools.passwordGeneratorTool.strengthVeryStrong');
        color = 'success';
        description = t('tools.passwordGeneratorTool.strengthVeryStrongDesc');
        crackTime = t('tools.passwordGeneratorTool.crackCenturies');
      }

      indicator.innerHTML = `
        <div class="d-flex align-items-center mb-2">
          <strong class="me-2">${t('tools.passwordGeneratorTool.strength')}:</strong>
          <span class="badge bg-${color}">${strength}</span>
        </div>
        <div class="progress mb-2 progress-strength-bar">
          <div class="progress-bar bg-${color}" role="progressbar"
            aria-valuenow="${progressWidth}" aria-valuemin="0" aria-valuemax="100"
            id="passwordStrengthBar"></div>
        </div>
        <div class="row g-2">
          <div class="col-md-4">
            <small class="text-muted d-block">${t('tools.passwordGeneratorTool.entropy')}: <strong>${Math.round(entropy)} bits</strong></small>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">${t('tools.passwordGeneratorTool.charset')}: <strong>${charset}</strong></small>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">${t('tools.passwordGeneratorTool.crackTime')}: <strong>${crackTime}</strong></small>
          </div>
        </div>
        <small class="text-muted d-block mt-2">${description}</small>
      `;

      const progressBar = indicator.querySelector('#passwordStrengthBar');
      if (progressBar) {
        progressBar.style.width = `${progressWidth}%`;
      }
    },

    /**
     * Download passwords in specified format
     *
     * @param {string} content - Password content to download
     * @param {string} format - File format ('txt', 'csv', 'json')
     */
    downloadPasswords: function(content, format) {
      if (!content) return;

      const lines = content.split('\n').filter(line => line.trim());
      let blob, filename;

      if (format === 'txt') {
        blob = new Blob([content], { type: 'text/plain' });
        filename = 'passwords.txt';
      } else if (format === 'csv') {
        const csv = 'password\n' + lines.join('\n');
        blob = new Blob([csv], { type: 'text/csv' });
        filename = 'passwords.csv';
      } else if (format === 'json') {
        const json = JSON.stringify(lines, null, 2);
        blob = new Blob([json], { type: 'application/json' });
        filename = 'passwords.json';
      }

      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = filename;
      a.click();
      URL.revokeObjectURL(url);
    }
  });

})();
