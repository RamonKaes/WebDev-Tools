const { defineConfig } = require('@playwright/test');

// Browser tests against the production build (`bash build.sh`, then `npm run test:browser`).
//
// config/config.php switches to BASE_PATH '/WebDev-Tools' on localhost, so the
// browser asks for the real host name and Chrome maps it to the local Apache
// from tests/browser/serve.sh. Never use Playwright's `request` fixture here:
// it runs outside Chrome, ignores this mapping and would reach the real site.
const PORT = 8443;

module.exports = defineConfig({
  testDir: 'tests/browser',
  outputDir: 'test-results/playwright',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 1 : 0,
  reporter: process.env.CI ? [['github'], ['list']] : 'list',
  use: {
    baseURL: 'https://webdev-tools.info',
    channel: 'chrome',
    ignoreHTTPSErrors: true,
    trace: 'retain-on-failure',
    launchOptions: {
      args: [
        `--host-resolver-rules=MAP webdev-tools.info:443 127.0.0.1:${PORT}`,
        '--ignore-certificate-errors',
      ],
    },
  },
  webServer: {
    command: `bash tests/browser/serve.sh ${PORT}`,
    url: `https://127.0.0.1:${PORT}/robots.txt`,
    ignoreHTTPSErrors: true,
    reuseExistingServer: false,
    stdout: 'ignore',
    stderr: 'pipe',
  },
});
