// ESLint flat config. Run with `npm run lint`; CI runs it in the Jest job.
const js = require('@eslint/js');
const globals = require('globals');

module.exports = [
  {
    ignores: ['dist/**', 'node_modules/**', 'assets/bootstrap/**', 'assets/bootstrap-icons/**', 'coverage/**', 'test-results/**', 'playwright-report/**', '.claude/**'],
  },
  js.configs.recommended,
  {
    rules: {
      'no-var': 'error',
      'prefer-const': 'error',
      'no-unused-vars': ['warn', { argsIgnorePattern: '^_', caughtErrors: 'none' }],
      'no-empty': ['error', { allowEmptyCatch: true }],
      // Regexes that strip control characters from file names and domains are intentional
      'no-control-regex': 'off',
      // The tools rethrow user-facing, translated messages; the original error is not useful to callers
      'preserve-caught-error': 'off',
    },
  },
  {
    // Shipped browser scripts: classic <script> files, not modules
    files: ['assets/js/**/*.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'script',
      globals: {
        ...globals.browser,
        bootstrap: 'readonly',
        qrcode: 'readonly',
        Terser: 'readonly',
        module: 'readonly',
        require: 'readonly',
      },
    },
  },
  {
    // The two files that are loaded with import()
    files: ['assets/js/lib/wordlist.js', 'assets/js/lib/performance-monitoring.js'],
    languageOptions: { sourceType: 'module' },
  },
  {
    files: ['tests/**/*.js', 'build-tools/**/*.js', 'jest.config.js', 'playwright.config.js', 'eslint.config.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'commonjs',
      globals: { ...globals.node, ...globals.browser, ...globals.jest },
    },
  },
];
