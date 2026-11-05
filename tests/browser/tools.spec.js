const fs = require('fs');
const { test, expect } = require('./fixtures');

const HELLO_SHA256 = '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824';
const HELLO_SHA384_BASE64 = 'WeF0h3dEjGnea4ANejO7+5/xtGPkQ1TDVTvNucZm+pASWjx5+QOXvfX2oT3oKGhP';
const JWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'
  + '.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ'
  + '.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
const UUID_V4 = /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/;

// Unit tests mock the shared libraries and never load the page, so these run
// each tool through its real page: expected values come from outside the tool.
async function openTool(page, slug) {
  await page.goto(`/${slug}/`);
  await expect(page.locator('#tool-container button, #tool-container input').first()).toBeVisible();
}

async function downloadedText(page, trigger) {
  const [download] = await Promise.all([page.waitForEvent('download'), trigger()]);
  return { name: download.suggestedFilename(), text: fs.readFileSync(await download.path(), 'utf8') };
}

const TEXT_TOOLS = [
  {
    // URL-safe without padding is this tool's default
    slug: 'base64-encoder-decoder', input: '#input', run: '#processBtn', output: '#output',
    value: 'hello', expected: 'aGVsbG8', download: '#downloadBtn',
  },
  {
    slug: 'url-encoder-decoder', input: '#input', run: '#processBtn', output: '#output',
    value: 'a b&c', expected: 'a%20b%26c',
  },
  {
    slug: 'html-entity-encoder-decoder', input: '#inputText', run: '#convertBtn', output: '#outputText',
    value: '<b>', expected: '&lt;b&gt;', download: '#downloadBtn',
  },
  {
    slug: 'punycode-converter', input: '#inputText', run: '#convertBtn', output: '#outputText',
    value: 'münchen.de', expected: 'xn--mnchen-3ya.de', download: '#downloadBtn',
  },
  {
    slug: 'json-formatter-validator', input: '#jsonInput', run: '#formatBtn', output: '#jsonOutput',
    value: '{"a":1}', expected: '{\n    "a": 1\n}', download: '#downloadBtn',
  },
  {
    slug: 'string-escaper', input: '#inputText', run: '#processBtn', output: '#outputText',
    value: '<b>', expected: '&lt;b&gt;',
  },
];

test.describe('text tools', () => {
  for (const tool of TEXT_TOOLS) {
    test(tool.slug, async ({ page }) => {
      await openTool(page, tool.slug);
      await page.locator(tool.input).fill(tool.value);
      await page.locator(tool.run).click();
      await expect(page.locator(tool.output)).toHaveValue(tool.expected);

      if (tool.download) {
        const file = await downloadedText(page, () => page.locator(tool.download).click());
        expect(file.text).toBe(tool.expected);
      }
    });
  }
});

test('copy button writes to the clipboard', async ({ page, context }) => {
  await context.grantPermissions(['clipboard-read', 'clipboard-write']);
  await openTool(page, 'base64-encoder-decoder');
  await page.locator('#input').fill('hello');
  await page.locator('#processBtn').click();
  await expect(page.locator('#output')).toHaveValue('aGVsbG8');
  await page.locator('#copyBtn').click();
  await expect.poll(() => page.evaluate(() => navigator.clipboard.readText())).toBe('aGVsbG8');
});

test('code-formatter minifies CSS', async ({ page }) => {
  await openTool(page, 'code-formatter');
  await page.locator('#codeLanguage').selectOption('css');
  await page.locator('label[for="modeMinify"]').click();
  await page.locator('#inputCode').fill('a {\n  color: red;\n}\n');
  await page.locator('#formatBtn').click();
  await expect(page.locator('#outputCode')).toHaveValue(/^a\s*\{\s*color:\s*red;?\s*\}$/);
  const file = await downloadedText(page, () => page.locator('#downloadBtn').click());
  expect(file.text).toContain('color');
});

test('data-converter turns JSON into CSV', async ({ page }) => {
  await openTool(page, 'data-converter');
  await page.locator('#conversionType').selectOption('jsonToCsv');
  await page.locator('#inputData').fill('[{"a":1,"b":2}]');
  await page.locator('#convertBtn').click();
  await expect(page.locator('#outputData')).toHaveValue(/^"?a"?,"?b"?\s+"?1"?,"?2"?\s*$/);
  const file = await downloadedText(page, () => page.locator('#downloadOutput').click());
  expect(file.text).toContain('a');
});

test('jwt-decoder shows header and payload', async ({ page }) => {
  await openTool(page, 'jwt-decoder');
  await page.locator('#jwtInput').fill(JWT);
  await page.locator('#decodeBtn').click();
  await expect(page.locator('#headerContent')).toContainText('HS256');
  await expect(page.locator('#payloadContent')).toContainText('John Doe');
});

test('hash-generator computes SHA-256', async ({ page }) => {
  await openTool(page, 'hash-generator');
  await page.locator('#textInput').fill('hello');
  await page.locator('#generateHash').click();
  await expect(page.locator('#hashResults input').first()).toHaveValue(HELLO_SHA256);
});

test('sri-generator hashes text with SHA-384', async ({ page }) => {
  await openTool(page, 'sri-generator');
  await page.locator('label[for="sri-mode-text"]').click();
  await page.locator('#sri-text').fill('hello');
  await page.locator('#sri-generate-from-text-btn').click();
  await expect(page.locator('#sri-results')).toContainText(`sha384-${HELLO_SHA384_BASE64}`);
});

test('uuid-generator creates version 4 UUIDs', async ({ page }) => {
  await openTool(page, 'uuid-generator');
  await page.locator('#uuidVersion').selectOption('v4');
  await page.locator('#generateSingle').click();
  await expect(page.locator('#singleUuid')).toHaveValue(UUID_V4);

  await page.locator('#bulkCount').fill('3');
  await page.locator('#generateBulk').click();
  await expect(page.locator('#bulkOutput')).not.toHaveValue('');
  const file = await downloadedText(page, () => page.locator('#downloadBulk').click());
  const lines = file.text.trim().split('\n');
  expect(lines).toHaveLength(3);
  for (const line of lines) expect(line.trim()).toMatch(UUID_V4);
});

test('password-generator honours the length and downloads via the dropdown', async ({ page }) => {
  await openTool(page, 'password-generator');
  await page.locator('#generatePassword').click();
  await expect(page.locator('#passwordOutput')).toHaveValue(/^\S{16}$/);
  const password = await page.locator('#passwordOutput').inputValue();

  // The dropdown only opens when Bootstrap's JavaScript shipped with the build
  await page.locator('#downloadDropdown').click();
  const file = await downloadedText(page, () => page.locator('[data-format="txt"]').click());
  expect(file.text).toContain(password);
});

test('lorem-ipsum generates the requested paragraphs', async ({ page }) => {
  await openTool(page, 'lorem-ipsum');
  await page.locator('#paragraphCount').fill('2');
  await page.locator('#generateBtn').click();
  await expect(page.locator('#loremOutput')).not.toHaveValue('');
  const paragraphs = (await page.locator('#loremOutput').inputValue()).trim().split(/\n\s*\n/);
  expect(paragraphs).toHaveLength(2);
});

test('px-to-rem-converter converts 24px', async ({ page }) => {
  await openTool(page, 'px-to-rem-converter');
  await page.locator('#pxInput').fill('24');
  await expect(page.locator('#remOutput')).toHaveValue(/^1\.5(0+)? rem$/);
});

test('aspect-ratio-calculator derives the height', async ({ page }) => {
  await openTool(page, 'aspect-ratio-calculator');
  await page.locator('#ratioWidth').fill('16');
  await page.locator('#ratioHeight').fill('9');
  await page.locator('#knownWidth').fill('1920');
  await expect(page.locator('#calculatedHeight')).toHaveValue(/^1080/);
});

test('regex-tester finds all matches', async ({ page }) => {
  await openTool(page, 'regex-tester');
  await page.locator('#regexPattern').fill('a+');
  await page.locator('#flag_g').check({ force: true });
  await page.locator('#testString').fill('caaandaa');
  await page.locator('#testButton').click();
  await expect(page.locator('#highlightedText mark')).toHaveText(['aaa', 'aa']);
});

test('qr-code-generator renders a code and offers its download', async ({ page }) => {
  await openTool(page, 'qr-code-generator');
  await page.locator('#url-input').fill('https://example.com/');
  await page.locator('#generate-btn').click();
  await expect(page.locator('#qr-preview').locator('svg, canvas, img').first()).toBeVisible();
  await expect(page.locator('#download-svg-btn')).toBeEnabled();
  const [download] = await Promise.all([page.waitForEvent('download'), page.locator('#download-svg-btn').click()]);
  expect(download.suggestedFilename()).toMatch(/\.svg$/);
});

test('character-reference filters by search', async ({ page }) => {
  await openTool(page, 'character-reference');
  await expect(page.locator('#charTableBody tr').first()).toBeVisible();
  await page.locator('#charSearch').fill('copyright');
  await expect(page.locator('#charTableBody')).toContainText('©');
});

test('emoji-reference filters by search', async ({ page }) => {
  await openTool(page, 'emoji-reference');
  await page.locator('#emojiSearch').fill('rocket');
  await expect(page.locator('#tool-container')).toContainText('🚀');
});
