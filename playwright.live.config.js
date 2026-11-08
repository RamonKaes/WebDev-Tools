const { defineConfig } = require('@playwright/test');

// Runs the browser suite against the LIVE site (read-only interactions only):
//   BROWSER_TEST_LIVE=1 npx playwright test -c playwright.live.config.js
// No local server, no host mapping; fixtures.js skips the test-server header check.
module.exports = defineConfig({
  testDir: 'tests/browser',
  outputDir: 'test-results/playwright-live',
  fullyParallel: true,
  workers: 3,
  retries: 1,
  reporter: 'list',
  use: {
    baseURL: 'https://webdev-tools.info',
    channel: 'chrome',
    trace: 'retain-on-failure',
  },
});
