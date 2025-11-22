/**
 * Hash Generator Tool Tests
 * 
 * Tests for hash generation (MD5, SHA-1, SHA-256, SHA-512)
 */

import { TestRunner, assert } from '../test-runner.js';

const runner = new TestRunner();

console.log('\n🧪 Hash Generator Tool Tests\n');

runner.test('Hash: generates consistent output for same input', async () => {
  const input = 'test string';
  const hash1 = await generateHash(input, 'SHA-256');
  const hash2 = await generateHash(input, 'SHA-256');
  
  assert.equal(hash1, hash2, 'Same input should produce identical hash');
});

runner.test('Hash: SHA-256 produces correct length', async () => {
  const input = 'Hello, World!';
  const hash = await generateHash(input, 'SHA-256');
  
  assert.equal(hash.length, 64, 'SHA-256 hash should be 64 hex characters');
  assert.ok(/^[a-f0-9]{64}$/.test(hash), 'Hash should be valid hex string');
});

runner.test('Hash: SHA-512 produces correct length', async () => {
  const input = 'Hello, World!';
  const hash = await generateHash(input, 'SHA-512');
  
  assert.equal(hash.length, 128, 'SHA-512 hash should be 128 hex characters');
  assert.ok(/^[a-f0-9]{128}$/.test(hash), 'Hash should be valid hex string');
});

runner.test('Hash: SHA-1 produces correct length', async () => {
  const input = 'Hello, World!';
  const hash = await generateHash(input, 'SHA-1');
  
  assert.equal(hash.length, 40, 'SHA-1 hash should be 40 hex characters');
  assert.ok(/^[a-f0-9]{40}$/.test(hash), 'Hash should be valid hex string');
});

runner.test('Hash: different inputs produce different outputs', async () => {
  const hash1 = await generateHash('input1', 'SHA-256');
  const hash2 = await generateHash('input2', 'SHA-256');
  
  assert.ok(hash1 !== hash2, 'Different inputs should produce different hashes');
});

runner.test('Hash: empty string produces valid hash', async () => {
  const hash = await generateHash('', 'SHA-256');
  
  assert.equal(hash.length, 64, 'Empty string should still produce valid hash');
  // Known SHA-256 hash of empty string
  assert.equal(hash, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855');
});

runner.test('Hash: handles unicode characters', async () => {
  const input = '你好世界 🌍';
  const hash = await generateHash(input, 'SHA-256');
  
  assert.equal(hash.length, 64, 'Unicode input should produce valid hash');
});

runner.test('Hash: known test vectors (SHA-256)', async () => {
  const testVectors = [
    { input: 'abc', expected: 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad' },
    { input: 'hello', expected: '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824' }
  ];
  
  for (const { input, expected } of testVectors) {
    const hash = await generateHash(input, 'SHA-256');
    assert.equal(hash, expected, `SHA-256('${input}') should match known value`);
  }
});

runner.test('Hash: SRI format includes algorithm prefix', () => {
  const hash = 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad';
  const sri = formatSRI(hash, 'SHA-256');
  
  assert.ok(sri.startsWith('sha256-'), 'SRI should start with algorithm prefix');
  assert.ok(sri.length > 10, 'SRI should contain base64 encoded hash');
  assert.ok(/^sha256-[A-Za-z0-9+/=]+$/.test(sri), 'SRI should be valid format');
});

runner.test('Hash: Base64 encoding for SRI', () => {
  const hexHash = 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad';
  const base64 = hexToBase64(hexHash);
  
  assert.ok(base64.length > 0, 'Base64 encoding should not be empty');
  assert.ok(/^[A-Za-z0-9+/=]+$/.test(base64), 'Base64 should only contain valid characters');
});

// Helper functions
async function generateHash(input, algorithm) {
  const encoder = new TextEncoder();
  const data = encoder.encode(input);
  const hashBuffer = await crypto.subtle.digest(algorithm, data);
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

function formatSRI(hash, algorithm) {
  const base64 = hexToBase64(hash);
  const algoPrefix = algorithm.toLowerCase().replace('-', '');
  return `${algoPrefix}-${base64}`;
}

function hexToBase64(hex) {
  const bytes = hex.match(/.{2}/g).map(byte => parseInt(byte, 16));
  const binary = String.fromCharCode.apply(null, bytes);
  return btoa(binary);
}

runner.run();
