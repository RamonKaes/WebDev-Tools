const fs = require('fs');
const path = require('path');
const AxeBuilder = require('@axe-core/playwright').default;
const { test, expect, SITE } = require('./fixtures');

const TAGS = ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa'];

// One language is enough: all six share the same markup, styles and colors
function englishPaths() {
  const xml = fs.readFileSync(path.join(__dirname, '../../dist/sitemap-en.xml'), 'utf8');
  return [...xml.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/g)].map((match) => match[1].replace(SITE, ''));
}

test.describe('accessibility', () => {
  test.describe.configure({ timeout: 60000 });

  for (const colorScheme of ['light', 'dark']) {
    for (const pagePath of englishPaths()) {
      test(`${pagePath} (${colorScheme})`, async ({ page }) => {
        await page.emulateMedia({ colorScheme });
        await page.goto(pagePath);
        await expect(page.locator('html')).toHaveAttribute('data-bs-theme', colorScheme);

        const container = page.locator('#tool-container');
        if (await container.count()) {
          await expect(container.locator('button, input, select, textarea').first()).toBeVisible();
        }
        // Links in a sidebar group that is still opening measure too small
        await expect(page.locator('.collapsing')).toHaveCount(0);

        const { violations } = await new AxeBuilder({ page }).withTags(TAGS).analyze();
        const found = violations.map(({ id, nodes }) => ({ id, nodes: nodes.map((node) => node.target.join(' ')) }));
        expect(found).toEqual([]);
      });
    }
  }
});
