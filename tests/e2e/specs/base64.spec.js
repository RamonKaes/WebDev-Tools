import { test, expect } from '@playwright/test';

test.describe('Base64 Encoder/Decoder', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/base64-encoder-decoder/');
  });

  test('should encode text to Base64', async ({ page }) => {
    // Enter text to encode
    await page.fill('#inputText', 'Hello World');
    
    // Click encode button
    await page.click('button:has-text("Encode")');
    
    // Verify output
    const output = await page.inputValue('#outputText');
    expect(output).toBe('SGVsbG8gV29ybGQ=');
  });

  test('should decode Base64 to text', async ({ page }) => {
    // Switch to decode mode
    await page.click('button:has-text("Decode")');
    
    // Enter Base64 string
    await page.fill('#inputText', 'SGVsbG8gV29ybGQ=');
    
    // Click decode button
    await page.click('button:has-text("Decode")');
    
    // Verify output
    const output = await page.inputValue('#outputText');
    expect(output).toBe('Hello World');
  });

  test('should copy output to clipboard', async ({ page, context }) => {
    // Grant clipboard permissions
    await context.grantPermissions(['clipboard-read', 'clipboard-write']);
    
    // Encode text
    await page.fill('#inputText', 'Test');
    await page.click('button:has-text("Encode")');
    
    // Click copy button
    await page.click('button[aria-label="Copy to clipboard"]');
    
    // Verify success message
    await expect(page.locator('.alert-success')).toBeVisible();
    
    // Verify clipboard content
    const clipboardText = await page.evaluate(() => navigator.clipboard.readText());
    expect(clipboardText).toBe('VGVzdA==');
  });

  test('should download output as file', async ({ page }) => {
    // Encode text
    await page.fill('#inputText', 'Download Test');
    await page.click('button:has-text("Encode")');
    
    // Start waiting for download before clicking
    const downloadPromise = page.waitForEvent('download');
    
    // Click download button
    await page.click('button[aria-label="Download"]');
    
    // Wait for download
    const download = await downloadPromise;
    
    // Verify filename
    expect(download.suggestedFilename()).toMatch(/base64-output/);
  });

  test('should handle empty input gracefully', async ({ page }) => {
    // Click encode without input
    await page.click('button:has-text("Encode")');
    
    // Should show error or empty result
    const output = await page.inputValue('#outputText');
    expect(output).toBe('');
  });

  test('should handle invalid Base64 when decoding', async ({ page }) => {
    // Switch to decode mode
    await page.click('button:has-text("Decode")');
    
    // Enter invalid Base64
    await page.fill('#inputText', 'Invalid!@#$%');
    
    // Click decode
    await page.click('button:has-text("Decode")');
    
    // Should show error message
    await expect(page.locator('.alert-danger')).toBeVisible();
  });

  test('should swap input and output', async ({ page }) => {
    // Encode text
    await page.fill('#inputText', 'Swap Test');
    await page.click('button:has-text("Encode")');
    
    const originalOutput = await page.inputValue('#outputText');
    
    // Click swap button
    await page.click('button[aria-label="Swap"]');
    
    // Verify input now has the output
    const newInput = await page.inputValue('#inputText');
    expect(newInput).toBe(originalOutput);
  });
});
