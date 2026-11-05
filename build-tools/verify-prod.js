#!/usr/bin/env node
// Checks the live site against the local dist/: every sitemap page in Chrome,
// and the deployed scripts and translations byte for byte. Only reads.
// Run by deploy-ftp.sh after an upload, or with `npm run verify:prod`.

const crypto = require('crypto');
const fs = require('fs');
const path = require('path');
const { chromium } = require('@playwright/test');

const SITE = 'https://webdev-tools.info';
const DIST = path.join(__dirname, '../dist');
const LANGS = ['de', 'es', 'fr', 'it', 'pt'];
const PHP_ERROR = /(Warning|Notice|Deprecated|Fatal error): .+ in \/.+ on line \d+/;
const WORKERS = 4;

function sitemapUrls() {
  const files = ['sitemap-en.xml', ...LANGS.map((lang) => `${lang}/sitemap.xml`)];
  return files.flatMap((file) => {
    const xml = fs.readFileSync(path.join(DIST, file), 'utf8');
    return [...xml.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/g)].map((match) => match[1]);
  });
}

function deployedFiles() {
  const inDir = (dir, ext) => fs.readdirSync(path.join(DIST, dir))
    .filter((name) => name.endsWith(ext))
    .map((name) => `${dir}/${name}`);
  return [...inDir('assets/js/tools', '.js'), ...inDir('config/i18n', '.json')];
}

const sha256 = (data) => crypto.createHash('sha256').update(data).digest('hex');

async function checkPages(context, urls, problems) {
  const queue = [...urls];
  await Promise.all(Array.from({ length: WORKERS }, async () => {
    const page = await context.newPage();
    let current;
    page.on('pageerror', (error) => problems.push(`${current}: ${error.message}`));
    page.on('console', (message) => {
      if (message.type() === 'error' && !message.text().includes('ERR_NETWORK_CHANGED')) {
        problems.push(`${current}: ${message.text()}`);
      }
    });
    while (queue.length) {
      current = queue.shift();
      try {
        const response = await page.goto(current);
        if (response.status() !== 200) problems.push(`${current}: status ${response.status()}`);
        if (PHP_ERROR.test(await response.text())) problems.push(`${current}: PHP error in the page`);
        if (await page.locator('#tool-container').count()) {
          await page.locator('#tool-container').locator('button, input, select, textarea').first()
            .waitFor({ timeout: 15000 });
        }
      } catch (error) {
        problems.push(`${current}: ${error.message.split('\n')[0]}`);
      }
    }
    await page.close();
  }));
}

async function checkFiles(context, files, problems) {
  for (const file of files) {
    const response = await context.request.get(`${SITE}/${file}`);
    const local = sha256(fs.readFileSync(path.join(DIST, file)));
    if (!response.ok()) problems.push(`${file}: status ${response.status()}`);
    else if (sha256(await response.body()) !== local) problems.push(`${file}: differs from dist/`);
  }
}

async function checkHeaders(context, problems) {
  const { 'content-security-policy': csp, 'strict-transport-security': hsts } = (await context.request.get(SITE)).headers();
  if (!csp || !csp.includes("default-src 'self'")) problems.push('Content-Security-Policy is missing');
  if (!hsts) problems.push('Strict-Transport-Security is missing');
}

async function main() {
  const urls = sitemapUrls();
  const files = deployedFiles();
  const problems = [];
  const browser = await chromium.launch({ channel: 'chrome' });
  const context = await browser.newContext();
  try {
    await checkPages(context, urls, problems);
    await checkFiles(context, files, problems);
    await checkHeaders(context, problems);
  } finally {
    await browser.close();
  }

  if (problems.length) {
    console.error(`❌ Production check failed (${problems.length}):`);
    for (const problem of problems) console.error(`   - ${problem}`);
    process.exit(1);
  }
  console.log(`✓ Production matches dist/: ${urls.length} pages load, ${files.length} files identical`);
}

main().catch((error) => {
  console.error(`❌ Production check could not run: ${error.message}`);
  process.exit(1);
});
