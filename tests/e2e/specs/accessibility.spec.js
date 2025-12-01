import { test as base } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';

const test = base.extend({
  makeAxeBuilder: async ({ page }, use) => {
    await use(() => new AxeBuilder({ page })
      .withTags(['wcag2a', 'wcag2aa', 'wcag21aa'])
    );
  },
});

test.describe('Accessibility Tests', () => {
  test('Base64 tool should not have accessibility violations', async ({ page, makeAxeBuilder }) => {
    await page.goto('/base64-encoder-decoder/');
    
    const accessibilityScanResults = await makeAxeBuilder().analyze();
    expect(accessibilityScanResults.violations).toEqual([]);
  });

  test('UUID Generator should not have accessibility violations', async ({ page, makeAxeBuilder }) => {
    await page.goto('/uuid-generator/');
    
    const accessibilityScanResults = await makeAxeBuilder().analyze();
    expect(accessibilityScanResults.violations).toEqual([]);
  });

  test('Password Generator should not have accessibility violations', async ({ page, makeAxeBuilder }) => {
    await page.goto('/password-generator/');
    
    const accessibilityScanResults = await makeAxeBuilder().analyze();
    expect(accessibilityScanResults.violations).toEqual([]);
  });

  test('Homepage should not have accessibility violations', async ({ page, makeAxeBuilder }) => {
    await page.goto('/');
    
    const accessibilityScanResults = await makeAxeBuilder().analyze();
    expect(accessibilityScanResults.violations).toEqual([]);
  });
});
