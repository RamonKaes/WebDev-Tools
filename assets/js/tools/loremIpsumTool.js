/**
 * Lorem Ipsum Generator Tool
 * 
 * Generate placeholder text in paragraphs, sentences, or words.
 * Based on classic Lorem Ipsum dictionary with randomized sentence structure.
 */
(function () {
  'use strict';

  if (typeof window.Tools === 'undefined') {
    console.error('[loremIpsumTool] Tools registry not available');
    return;
  }

  /**
   * Lorem Ipsum word library
   *
   * Classic Lorem Ipsum vocabulary pool for text generation.
   */
  const LOREM_WORDS = [
    'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
    'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
    'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud',
    'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo',
    'consequat', 'duis', 'aute', 'irure', 'in', 'reprehenderit', 'voluptate',
    'velit', 'esse', 'cillum', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint',
    'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia',
    'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum', 'vitae', 'risus', 'felis',
    'eleifend', 'donec', 'pretium', 'vulputate', 'sapien', 'nec', 'sagittis',
    'aliquam', 'malesuada', 'bibendum', 'arcu', 'viverra', 'quis', 'varius',
    'quam', 'quisque', 'velit', 'sed', 'ullamcorper', 'morbi', 'tincidunt',
    'ornare', 'massa', 'eget', 'egestas', 'purus', 'viverra', 'accumsan',
    'porttitor', 'rhoncus', 'dolor', 'purus', 'non', 'enim', 'praesent',
    'elementum', 'facilisis', 'leo', 'vel', 'fringilla', 'est', 'ullamcorper'
  ];

  /**
   * Generate random words from lorem ipsum dictionary
   *
   * @param {number} count - Number of words to generate
   * @returns {string} - Generated words
   */
  function generateWords(count) {
    const result = [];
    for (let i = 0; i < count; i++) {
      result.push(LOREM_WORDS[Math.floor(Math.random() * LOREM_WORDS.length)]);
    }
    return result.join(' ');
  }

  /**
   * Generate a single sentence with random length
   *
   * @returns {string} - Generated sentence (5-14 words, capitalized, ending with period)
   */
  function generateSentence() {
    const wordCount = Math.floor(Math.random() * 10) + 5;
    let sentence = generateWords(wordCount);
    sentence = sentence.charAt(0).toUpperCase() + sentence.slice(1) + '.';
    return sentence;
  }

  /**
   * Generate a single paragraph with random sentence count
   *
   * @returns {string} - Generated paragraph (3-6 sentences)
   */
  function generateParagraph() {
    const sentenceCount = Math.floor(Math.random() * 4) + 3;
    const sentences = [];
    for (let i = 0; i < sentenceCount; i++) {
      sentences.push(generateSentence());
    }
    return sentences.join(' ');
  }

  /**
   * Copy text to clipboard using global ClipboardUtils
   *
   * @param {string} text - Text to copy
   * @returns {Promise<boolean>} - Promise that resolves when copy succeeds
   */
  function copyToClipboard(text) {
    return window.ClipboardUtils.copyToClipboard(text);
  }

  window.Tools.register('loremIpsumTool', {
    /**
     * Initialize the Lorem Ipsum Generator Tool
     */
    init: function () {
      console.debug('[loremIpsumTool] Tool registered');
    },

    /**
     * Open the Lorem Ipsum Generator Tool in the provided container
     *
     * @param {HTMLElement} container - Container element to render the tool
     */
    open: function (container) {
      const t = window.i18n ? window.i18n.t.bind(window.i18n) : (key) => key;

      try {
        container.innerHTML = '';

        // Main content
        const row = document.createElement('div');
        row.className = 'row g-4';

        // Generator Card
        const generatorCol = document.createElement('div');
        generatorCol.className = 'col-12';
        generatorCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-gear me-2"></i>${t('tools.loremIpsumTool.optionsTitle')}</h2>

              <div class="row">
                <div class="col-sm-4">
                  <div class="mb-3">
                    <label for="paragraphCount" class="form-label">${t('tools.loremIpsumTool.paragraphs')}</label>
                    <input type="number" class="form-control form-control-sm" id="paragraphCount" value="3" min="0" max="50">
                    <small class="text-muted">${t('tools.loremIpsumTool.paragraphsHint')}</small>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="mb-3">
                    <label for="sentenceCount" class="form-label">${t('tools.loremIpsumTool.sentences')}</label>
                    <input type="number" class="form-control form-control-sm" id="sentenceCount" value="0" min="0" max="100">
                    <small class="text-muted">${t('tools.loremIpsumTool.sentencesHint')}</small>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="mb-3">
                    <label for="wordCount" class="form-label">${t('tools.loremIpsumTool.words')}</label>
                    <input type="number" class="form-control form-control-sm" id="wordCount" value="0" min="0" max="500">
                    <small class="text-muted">${t('tools.loremIpsumTool.wordsHint')}</small>
                  </div>
                </div>
              </div>

              <div class="alert alert-info mb-3">
                <i class="bi bi-info-circle me-2"></i>${t('tools.loremIpsumTool.combineHint')}
              </div>

              <button class="btn btn-primary btn-sm" id="generateBtn">
                <i class="bi bi-arrow-repeat me-2"></i>${t('tools.loremIpsumTool.generate')}
              </button>
            </div>
          </div>
        `;
        row.appendChild(generatorCol);

        // Output Card
        const outputCol = document.createElement('div');
        outputCol.className = 'col-12';
        outputCol.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h2 class="card-title h5 mb-3"><i class="bi bi-file-text me-2"></i>${t('tools.loremIpsumTool.outputTitle')}</h2>
              <div class="mb-3">
                <textarea class="form-control bg-body-secondary font-monospace" id="loremOutput" rows="12" readonly placeholder="${t('tools.loremIpsumTool.outputPlaceholder')}"></textarea>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted small">
                  <span>${t('tools.loremIpsumTool.characters')}: <strong id="charCount">0</strong></span>
                  <span class="ms-3">${t('tools.loremIpsumTool.wordsCount')}: <strong id="wordCountDisplay">0</strong></span>
                </div>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" id="copyBtn" disabled>
                  <i class="bi bi-clipboard me-2" aria-hidden="true"></i><span class="btn-text">${t('tools.loremIpsumTool.copy')}</span>
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="clearBtn" disabled>
                  <i class="bi bi-trash me-2" aria-hidden="true"></i><span class="btn-text">${t('tools.loremIpsumTool.clear')}</span>
                </button>
              </div>
            </div>
          </div>
        `;
        row.appendChild(outputCol);

        container.appendChild(row);

        // Setup event listeners
        this.setupListeners(t);

        // Auto-generate on load
        this.generate();

      } catch (error) {
        console.error('[loremIpsumTool] Error:', error);
        const errorMsg = t('tools.loremIpsumTool.errorLoading');
        container.innerHTML = `<div class="alert alert-danger">${errorMsg}</div>`;
      }
    },

    /**
     * Setup event listeners for generator controls
     *
     * @param {Function} t - Translation function
     */
    setupListeners: function(t) {
      const generateBtn = document.getElementById('generateBtn');
      const copyBtn = document.getElementById('copyBtn');
      const clearBtn = document.getElementById('clearBtn');
      const paragraphCount = document.getElementById('paragraphCount');
      const sentenceCount = document.getElementById('sentenceCount');
      const wordCountInput = document.getElementById('wordCount');
      const loremOutput = document.getElementById('loremOutput');
      const charCount = document.getElementById('charCount');
      const wordCountDisplay = document.getElementById('wordCountDisplay');

      const updateCounts = () => {
        const text = loremOutput.value;
        charCount.textContent = text.length;
        wordCountDisplay.textContent = text.trim() ? text.trim().split(/\s+/).length : 0;

        copyBtn.disabled = !text;
        clearBtn.disabled = !text;
      };

      this.updateCounts = updateCounts;

      generateBtn.addEventListener('click', () => this.generate());

      copyBtn.addEventListener('click', () => {
        const text = loremOutput.value;
        if (!text) return;

        copyToClipboard(text)
          .then(() => {
            // Prefer explicit icon and text elements; gracefully handle absent nodes
            const originalIcon = copyBtn.querySelector('i');
            const originalTextEl = copyBtn.querySelector('.btn-text') || copyBtn.childNodes[copyBtn.childNodes.length - 1];
            const originalTextContent = originalTextEl ? originalTextEl.textContent : '';

            if (originalIcon && typeof originalIcon.className !== 'undefined') {
              originalIcon.className = 'bi bi-check2 me-2';
            } else {
              // fallback: add a temporary success class to the button itself
              copyBtn.classList.add('copied-temp');
            }

            if (originalTextEl) {
              originalTextEl.textContent = t('tools.loremIpsumTool.copied');
            }

            setTimeout(() => {
              if (originalIcon && typeof originalIcon.className !== 'undefined') {
                originalIcon.className = 'bi bi-clipboard me-2';
              } else {
                copyBtn.classList.remove('copied-temp');
              }

              if (originalTextEl) {
                originalTextEl.textContent = originalTextContent;
              }
            }, 2000);
          })
          .catch((err) => {
            console.error('[loremIpsumTool] Copy failed:', err);
            alert(t('tools.loremIpsumTool.copyFailed'));
          });
      });

      clearBtn.addEventListener('click', () => {
        loremOutput.value = '';
        updateCounts();
      });
    },

    /**
     * Generate lorem ipsum text based on current settings
     */
    generate: function() {
      const t = window.i18n ? window.i18n.t.bind(window.i18n) : (key) => key;
      const paragraphCount = document.getElementById('paragraphCount');
      const sentenceCount = document.getElementById('sentenceCount');
      const wordCountInput = document.getElementById('wordCount');
      const loremOutput = document.getElementById('loremOutput');

      const paragraphs = parseInt(paragraphCount.value) || 0;
      const sentences = parseInt(sentenceCount.value) || 0;
      const words = parseInt(wordCountInput.value) || 0;

      if (paragraphs === 0 && sentences === 0 && words === 0) {
        alert(t('tools.loremIpsumTool.selectAtLeastOne'));
        return;
      }

      const results = [];

      // Generate paragraphs
      if (paragraphs > 0) {
        for (let i = 0; i < paragraphs; i++) {
          results.push(generateParagraph());
        }
      }

      // Generate sentences
      if (sentences > 0) {
        const sentenceArray = [];
        for (let i = 0; i < sentences; i++) {
          sentenceArray.push(generateSentence());
        }
        results.push(sentenceArray.join(' '));
      }

      // Generate words
      if (words > 0) {
        results.push(generateWords(words));
      }

      loremOutput.value = results.join('\n\n');
      if (this.updateCounts) this.updateCounts();
    }
  });
})();
