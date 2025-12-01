import { test, expect } from '@playwright/test';

test.describe('Password Generator', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/password-generator/');
  });

  test('should generate password with default settings', async ({ page }) => {
    // Click generate
    await page.click('button:has-text("Generate Password")');
    
    // Verify password is generated
    const password = await page.inputValue('#passwordOutput');
    expect(password.length).toBeGreaterThan(0);
  });

  test('should respect length slider', async ({ page }) => {
    // Set length to 20
    await page.fill('input[name="length"]', '20');
    
    // Generate password
    await page.click('button:has-text("Generate Password")');
    
    // Verify length
    const password = await page.inputValue('#passwordOutput');
    expect(password.length).toBe(20);
  });

  test('should include selected character types', async ({ page }) => {
    // Enable all character types
    await page.check('input[name="uppercase"]');
    await page.check('input[name="lowercase"]');
    await page.check('input[name="numbers"]');
    await page.check('input[name="symbols"]');
    
    // Generate password
    await page.click('button:has-text("Generate Password")');
    
    const password = await page.inputValue('#passwordOutput');
    
    // Verify contains at least one of each type
    expect(password).toMatch(/[A-Z]/); // Uppercase
    expect(password).toMatch(/[a-z]/); // Lowercase
    expect(password).toMatch(/[0-9]/); // Numbers
    expect(password).toMatch(/[!@#$%^&*]/); // Symbols
  });

  test('should show strength meter', async ({ page }) => {
    // Generate weak password (short, limited charset)
    await page.fill('input[name="length"]', '6');
    await page.uncheck('input[name="symbols"]');
    await page.click('button:has-text("Generate Password")');
    
    // Check strength indicator
    const weakStrength = await page.locator('.strength-meter.weak').isVisible();
    expect(weakStrength).toBeTruthy();
    
    // Generate strong password (long, all charsets)
    await page.fill('input[name="length"]', '32');
    await page.check('input[name="uppercase"]');
    await page.check('input[name="lowercase"]');
    await page.check('input[name="numbers"]');
    await page.check('input[name="symbols"]');
    await page.click('button:has-text("Generate Password")');
    
    // Should show strong
    await expect(page.locator('.strength-meter.strong')).toBeVisible();
  });

  test('should copy password to clipboard', async ({ page, context }) => {
    await context.grantPermissions(['clipboard-read', 'clipboard-write']);
    
    // Generate password
    await page.click('button:has-text("Generate Password")');
    const password = await page.inputValue('#passwordOutput');
    
    // Copy
    await page.click('button[aria-label="Copy password"]');
    
    // Verify clipboard
    const clipboardText = await page.evaluate(() => navigator.clipboard.readText());
    expect(clipboardText).toBe(password);
    
    // Verify success message
    await expect(page.locator('.alert-success')).toContainText('Copied');
  });

  test('should regenerate different passwords', async ({ page }) => {
    // Generate first password
    await page.click('button:has-text("Generate Password")');
    const password1 = await page.inputValue('#passwordOutput');
    
    // Generate second password
    await page.click('button:has-text("Generate Password")');
    const password2 = await page.inputValue('#passwordOutput');
    
    // Should be different (extremely unlikely to be same)
    expect(password1).not.toBe(password2);
  });

  test('should support passphrase generation', async ({ page }) => {
    // Switch to passphrase mode
    await page.click('button:has-text("Passphrase")');
    
    // Set word count
    await page.fill('input[name="wordCount"]', '5');
    
    // Generate
    await page.click('button:has-text("Generate Passphrase")');
    
    // Verify format (words separated by delimiter)
    const passphrase = await page.inputValue('#passwordOutput');
    const words = passphrase.split('-');
    expect(words.length).toBe(5);
    
    // Each word should be alphabetic
    words.forEach(word => {
      expect(word).toMatch(/^[a-z]+$/i);
    });
  });

  test('should exclude ambiguous characters when selected', async ({ page }) => {
    // Enable exclude ambiguous option
    await page.check('input[name="excludeAmbiguous"]');
    
    // Generate many passwords to test
    for (let i = 0; i < 10; i++) {
      await page.click('button:has-text("Generate Password")');
      const password = await page.inputValue('#passwordOutput');
      
      // Should not contain ambiguous chars: 0, O, I, l, 1
      expect(password).not.toMatch(/[0OIl1]/);
    }
  });

  test('should save preferences', async ({ page }) => {
    // Set custom preferences
    await page.fill('input[name="length"]', '24');
    await page.check('input[name="uppercase"]');
    await page.check('input[name="symbols"]');
    
    // Reload page
    await page.reload();
    
    // Preferences should be restored (from localStorage)
    const length = await page.inputValue('input[name="length"]');
    expect(length).toBe('24');
    
    const uppercaseChecked = await page.isChecked('input[name="uppercase"]');
    expect(uppercaseChecked).toBeTruthy();
  });
});
