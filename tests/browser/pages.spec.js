const fs = require('fs');
const path = require('path');
const { test, expect, SITE } = require('./fixtures');

const ROOT = path.join(__dirname, '../..');
const LANGS = ['de', 'es', 'fr', 'it', 'pt'];
const PHP_ERROR = /(Warning|Notice|Deprecated|Fatal error): .+ in \/.+ on line \d+/;

function sitemapPaths() {
  const files = ['sitemap-en.xml', ...LANGS.map((lang) => `${lang}/sitemap.xml`)];
  return files.flatMap((file) => {
    const xml = fs.readFileSync(path.join(ROOT, 'dist', file), 'utf8');
    return [...xml.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/g)].map((match) => match[1].replace(SITE, ''));
  });
}

function redirects() {
  const rules = fs.readFileSync(path.join(ROOT, '.htaccess.production'), 'utf8');
  return [...rules.matchAll(/^\s*RewriteRule \^((?:de|es|fr|it|pt)\/[^/?$]+)\/\?\$ (\/\S+) \[R=301,L\]/gm)]
    .map((match) => ({ from: `/${match[1]}/`, to: match[2] }));
}

test.describe('every page in the sitemap', () => {
  for (const pagePath of sitemapPaths()) {
    test(pagePath, async ({ page }) => {
      const response = await page.goto(pagePath);
      expect(response.status()).toBe(200);
      expect(await response.text()).not.toMatch(PHP_ERROR);

      const lang = LANGS.find((code) => pagePath.startsWith(`/${code}/`)) || 'en';
      await expect(page.locator('html')).toHaveAttribute('lang', lang);
      await expect(page.locator('link[rel="canonical"]')).toHaveAttribute('href', SITE + pagePath);
      await expect(page.locator('h1').first()).toBeVisible();

      // Tool scripts load asynchronously and fill this container themselves
      const container = page.locator('#tool-container');
      if (await container.count()) {
        await expect(container.locator('button, input, select, textarea').first()).toBeVisible();
        // An untranslated key renders as its own name
        await expect(container).not.toContainText(/\btools\.[a-zA-Z]+\.[a-zA-Z]/);
      }
    });
  }
});

test('the sitemap covers all 20 tools in all 6 languages', () => {
  // 20 tools plus start page and about page per language
  expect(sitemapPaths()).toHaveLength(22 * 6);
});

test.describe('.htaccess.production', () => {
  test('finds the redirect rules', () => {
    expect(redirects().length).toBeGreaterThan(50);
  });

  for (const { from, to } of redirects()) {
    test(`${from} redirects to ${to}`, async ({ page }) => {
      const response = await page.goto(from);
      expect(response.status()).toBe(200);
      expect(new URL(page.url()).pathname).toBe(to);
      const redirect = await response.request().redirectedFrom().response();
      expect(redirect.status()).toBe(301);
    });
  }

  test('an unknown page answers 404', async ({ page, problems }) => {
    const response = await page.goto('/does-not-exist/');
    expect(response.status()).toBe(404);
    // Chrome logs the 404 of the document itself as a console error
    problems.length = 0;
  });

  test('sets the security headers', async ({ page }) => {
    const response = await page.goto('/');
    const headers = response.headers();
    expect(headers['content-security-policy']).toContain("default-src 'self'");
    expect(headers['strict-transport-security']).toContain('max-age=31536000');
    // mod_php sends these twice here (PHP and .htaccess), the production host once
    expect(headers['x-content-type-options']).toContain('nosniff');
    expect(headers['x-frame-options']).toContain('DENY');
  });
});
