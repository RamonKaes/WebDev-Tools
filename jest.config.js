/** @type {import('jest').Config} */
module.exports = {
  testEnvironment: 'jest-environment-jsdom',
  testEnvironmentOptions: {
    url: 'http://localhost/',
  },
  setupFiles: ['./tests/unit/setup.js'],
  testMatch: ['**/tests/unit/**/*.test.js'],
  verbose: true,
};
