/** @type {import('jest').Config} */
module.exports = {
  testEnvironment: 'jest-environment-jsdom',
  testEnvironmentOptions: {
    url: 'http://localhost/',
  },
  setupFiles: ['./tests/unit/setup.js'],
  testMatch: ['**/tests/unit/**/*.test.js'],
  verbose: true,
  // Count every shipped script, not only the ones a test happens to require
  collectCoverageFrom: [
    'assets/js/**/*.js',
    '!assets/js/lib/wordlist.js',
    '!assets/js/lib/performance-monitoring.js',
  ],
  // Floors slightly below the measured values; raise them as coverage grows, never lower them
  coverageThreshold: {
    global: {
      statements: 60,
      branches: 50,
      functions: 60,
      lines: 62,
    },
  },
};
