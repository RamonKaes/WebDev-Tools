const base = require('@playwright/test');

const SITE = 'https://webdev-tools.info';

// Every test fails on a JavaScript error, a console error (CSP violations end
// up there), a failed request to the site, or a response from anywhere but the
// local test server.
const test = base.test.extend({
  problems: [
    async ({ page }, use) => {
      const problems = [];
      page.on('pageerror', (error) => problems.push(`pageerror: ${error.message}`));
      page.on('console', (message) => {
        // Chrome aborts requests when a network interface changes on the machine
        if (message.type() === 'error' && !message.text().includes('ERR_NETWORK_CHANGED')) {
          problems.push(`console: ${message.text()}`);
        }
      });
      page.on('response', (response) => {
        if (!response.url().startsWith(SITE)) return;
        if (response.headers()['x-browser-test'] !== 'local') {
          problems.push(`not served by the test server: ${response.url()}`);
        }
      });
      await use(problems);
      base.expect(problems).toEqual([]);
    },
    { auto: true },
  ],
});

module.exports = { test, expect: base.expect, SITE };
