/**
 * Password Generator Tool Tests
 * 
 * Tests for secure password generation with various character sets
 */

import { TestRunner, assert } from '../test-runner.js';

const runner = new TestRunner();

console.log('\n🧪 Password Generator Tool Tests\n');

runner.test('Password: generates with specified length', () => {
  const lengths = [8, 12, 16, 32, 64];
  
  lengths.forEach(length => {
    const password = generatePassword(length, true, true, true, true);
    assert.equal(password.length, length, `Password should be exactly ${length} characters`);
  });
});

runner.test('Password: includes uppercase when enabled', () => {
  const password = generatePassword(50, true, false, false, false);
  const hasUppercase = /[A-Z]/.test(password);
  
  assert.ok(hasUppercase, 'Password should contain uppercase letters');
  assert.ok(!/[a-z]/.test(password), 'Password should not contain lowercase');
  assert.ok(!/[0-9]/.test(password), 'Password should not contain numbers');
  assert.ok(!/[^A-Za-z0-9]/.test(password), 'Password should not contain symbols');
});

runner.test('Password: includes lowercase when enabled', () => {
  const password = generatePassword(50, false, true, false, false);
  const hasLowercase = /[a-z]/.test(password);
  
  assert.ok(hasLowercase, 'Password should contain lowercase letters');
  assert.ok(!/[A-Z]/.test(password), 'Password should not contain uppercase');
});

runner.test('Password: includes numbers when enabled', () => {
  const password = generatePassword(50, false, false, true, false);
  const hasNumbers = /[0-9]/.test(password);
  
  assert.ok(hasNumbers, 'Password should contain numbers');
  assert.ok(!/[A-Za-z]/.test(password), 'Password should not contain letters');
});

runner.test('Password: includes symbols when enabled', () => {
  const password = generatePassword(50, false, false, false, true);
  const hasSymbols = /[^A-Za-z0-9]/.test(password);
  
  assert.ok(hasSymbols, 'Password should contain symbols');
  assert.ok(!/[A-Za-z0-9]/.test(password), 'Password should not contain letters or numbers');
});

runner.test('Password: generates unique passwords', () => {
  const passwords = new Set();
  const count = 100;
  
  for (let i = 0; i < count; i++) {
    const password = generatePassword(16, true, true, true, true);
    passwords.add(password);
  }
  
  assert.ok(passwords.size >= count * 0.99, 'At least 99% of passwords should be unique');
});

runner.test('Password strength: calculates correctly for weak password', () => {
  const strength = calculateStrength('password');
  assert.ok(strength <= 2, 'Common password should have low strength (0-2)');
});

runner.test('Password strength: calculates correctly for strong password', () => {
  const strength = calculateStrength('Tr0ub4dor&3!xY#9pQ');
  assert.ok(strength >= 4, 'Complex password should have high strength (4-5)');
});

runner.test('Password strength: length affects score', () => {
  const short = calculateStrength('Aa1!');
  const medium = calculateStrength('Aa1!Aa1!Aa1!');
  const long = calculateStrength('Aa1!Aa1!Aa1!Aa1!Aa1!Aa1!');
  
  assert.ok(medium > short, 'Longer password should have higher strength');
  assert.ok(long > medium, 'Even longer password should have even higher strength');
});

// Helper functions
function generatePassword(length, uppercase, lowercase, numbers, symbols) {
  const chars = {
    uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    lowercase: 'abcdefghijklmnopqrstuvwxyz',
    numbers: '0123456789',
    symbols: '!@#$%^&*()_+-=[]{}|;:,.<>?'
  };
  
  let charset = '';
  if (uppercase) charset += chars.uppercase;
  if (lowercase) charset += chars.lowercase;
  if (numbers) charset += chars.numbers;
  if (symbols) charset += chars.symbols;
  
  if (!charset) return '';
  
  const array = new Uint8Array(length);
  crypto.getRandomValues(array);
  
  return Array.from(array)
    .map(x => charset[x % charset.length])
    .join('');
}

function calculateStrength(password) {
  let score = 0;
  
  if (password.length >= 8) score++;
  if (password.length >= 12) score++;
  if (password.length >= 16) score++;
  
  if (/[a-z]/.test(password)) score++;
  if (/[A-Z]/.test(password)) score++;
  if (/[0-9]/.test(password)) score++;
  if (/[^A-Za-z0-9]/.test(password)) score++;
  
  if (/(.)\1{2,}/.test(password)) score--;  // Repeated characters
  
  return Math.min(5, Math.max(0, score));
}

runner.run();
