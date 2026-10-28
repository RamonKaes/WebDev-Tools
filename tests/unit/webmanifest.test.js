'use strict';

/**
 * Checks the six web app manifests (site.webmanifest in the root and in
 * every language directory): valid JSON, the fields Chromium needs to offer
 * an install, one start page and id per language, icons that exist on disk,
 * and a theme colour that matches the theme-color meta tag in the head.
 */

const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '../..');
const languages = ['en', 'de', 'es', 'fr', 'it', 'pt'];

function manifestPath(lang) {
  return lang === 'en' ? path.join(root, 'site.webmanifest') : path.join(root, lang, 'site.webmanifest');
}

function load(lang) {
  return JSON.parse(fs.readFileSync(manifestPath(lang), 'utf8'));
}

describe('site.webmanifest', () => {
  test.each(languages)('%s: has the fields an install needs', (lang) => {
    const m = load(lang);
    expect(m.name).toBe('WebDev-Tools');
    expect(m.short_name).toBe('WebDev-Tools');
    expect(m.description.length).toBeGreaterThan(20);
    expect(m.lang).toBe(lang);
    expect(m.display).toBe('standalone');
    expect(m.start_url).toBe('./');
    expect(m.prefer_related_applications).toBe(false);
  });

  test.each(languages)('%s: id and scope point at the language root and the site root', (lang) => {
    const m = load(lang);
    expect(m.id).toBe(lang === 'en' ? '/' : `/${lang}/`);
    expect(m.scope).toBe(lang === 'en' ? './' : '../');
  });

  test.each(languages)('%s: icons exist and cover any and maskable in 192 and 512', (lang) => {
    const m = load(lang);
    const dir = path.dirname(manifestPath(lang));
    for (const icon of m.icons) {
      expect(fs.existsSync(path.join(dir, icon.src))).toBe(true);
      expect(icon.type).toBe('image/png');
      expect(icon.src).toContain(icon.sizes);
    }
    for (const purpose of ['any', 'maskable']) {
      const sizes = m.icons.filter((i) => i.purpose === purpose).map((i) => i.sizes).sort();
      expect(sizes).toEqual(['192x192', '512x512']);
    }
  });

  test('theme colour matches the theme-color meta tag', () => {
    const head = fs.readFileSync(path.join(root, 'partials/head.php'), 'utf8');
    const meta = head.match(/<meta name="theme-color" content="(#[0-9a-f]{6})">/i)[1];
    for (const lang of languages) {
      expect(load(lang).theme_color).toBe(meta);
    }
  });

  test('every page head links the manifest of its language', () => {
    const head = fs.readFileSync(path.join(root, 'partials/head.php'), 'utf8');
    expect(head).toContain('<link rel="manifest" href="<?= $toolBaseUrl ?>/site.webmanifest" />');
    expect(head).not.toContain('assets/img/site.webmanifest');
  });
});
