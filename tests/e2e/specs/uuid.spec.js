import { test, expect } from '@playwright/test';

test.describe('UUID Generator', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/uuid-generator/');
  });

  test('should generate single UUID v4', async ({ page }) => {
    // Click generate button
    await page.click('button:has-text("Generate UUID")');
    
    // Verify UUID format (v4: xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx)
    const uuid = await page.inputValue('#uuidOutput');
    expect(uuid).toMatch(/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i);
  });

  test('should generate different UUIDs on each click', async ({ page }) => {
    // Generate first UUID
    await page.click('button:has-text("Generate UUID")');
    const uuid1 = await page.inputValue('#uuidOutput');
    
    // Generate second UUID
    await page.click('button:has-text("Generate UUID")');
    const uuid2 = await page.inputValue('#uuidOutput');
    
    // Should be different
    expect(uuid1).not.toBe(uuid2);
  });

  test('should generate bulk UUIDs (100)', async ({ page }) => {
    // Select bulk generation
    await page.click('button:has-text("Bulk Generate")');
    
    // Enter quantity
    await page.fill('input[name="quantity"]', '100');
    
    // Generate
    await page.click('button:has-text("Generate")');
    
    // Verify output contains 100 UUIDs
    const output = await page.inputValue('textarea#bulkOutput');
    const uuids = output.trim().split('\n');
    expect(uuids.length).toBe(100);
    
    // Verify all are valid UUIDs
    uuids.forEach(uuid => {
      expect(uuid).toMatch(/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i);
    });
    
    // Verify all are unique
    const uniqueUUIDs = new Set(uuids);
    expect(uniqueUUIDs.size).toBe(100);
  });

  test('should copy UUID to clipboard', async ({ page, context }) => {
    await context.grantPermissions(['clipboard-read', 'clipboard-write']);
    
    // Generate UUID
    await page.click('button:has-text("Generate UUID")');
    const uuid = await page.inputValue('#uuidOutput');
    
    // Copy to clipboard
    await page.click('button[aria-label="Copy"]');
    
    // Verify clipboard
    const clipboardText = await page.evaluate(() => navigator.clipboard.readText());
    expect(clipboardText).toBe(uuid);
  });

  test('should download bulk UUIDs as file', async ({ page }) => {
    // Generate bulk UUIDs
    await page.click('button:has-text("Bulk Generate")');
    await page.fill('input[name="quantity"]', '50');
    await page.click('button:has-text("Generate")');
    
    // Start download
    const downloadPromise = page.waitForEvent('download');
    await page.click('button:has-text("Download")');
    
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/uuids.*\.txt/);
  });

  test('should support different UUID versions', async ({ page }) => {
    // Select UUID v1
    await page.selectOption('select[name="version"]', 'v1');
    await page.click('button:has-text("Generate UUID")');
    
    const uuidV1 = await page.inputValue('#uuidOutput');
    // v1 has version bit 1 in 3rd group
    expect(uuidV1).toMatch(/^[0-9a-f]{8}-[0-9a-f]{4}-1[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i);
    
    // Select UUID v4
    await page.selectOption('select[name="version"]', 'v4');
    await page.click('button:has-text("Generate UUID")');
    
    const uuidV4 = await page.inputValue('#uuidOutput');
    expect(uuidV4).toMatch(/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i);
  });

  test('should handle uppercase/lowercase formatting', async ({ page }) => {
    // Generate UUID
    await page.click('button:has-text("Generate UUID")');
    const uuid = await page.inputValue('#uuidOutput');
    
    // Toggle uppercase
    await page.check('input[name="uppercase"]');
    
    const uuidUpper = await page.inputValue('#uuidOutput');
    expect(uuidUpper).toBe(uuid.toUpperCase());
    
    // Toggle back to lowercase
    await page.uncheck('input[name="uppercase"]');
    
    const uuidLower = await page.inputValue('#uuidOutput');
    expect(uuidLower).toBe(uuid.toLowerCase());
  });
});
