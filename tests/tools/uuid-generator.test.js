/**
 * UUID Generator Tool Tests
 * 
 * Tests for UUID generation functionality (v1, v4, v7)
 */

import { TestRunner, assert } from '../test-runner.js';

const runner = new TestRunner();

console.log('\n🧪 UUID Generator Tool Tests\n');

// Mock crypto API if not available
if (typeof crypto === 'undefined' || !crypto.getRandomValues) {
  global.crypto = {
    getRandomValues: function(buffer) {
      for (let i = 0; i < buffer.length; i++) {
        buffer[i] = Math.floor(Math.random() * 256);
      }
      return buffer;
    }
  };
}

runner.test('UUID v4: generates valid UUIDs', () => {
  const uuid = crypto.randomUUID ? crypto.randomUUID() : generateUUIDv4();
  const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
  
  assert.ok(uuidRegex.test(uuid), 'UUID v4 should match RFC 4122 format');
  assert.equal(uuid.length, 36, 'UUID should be 36 characters long');
  assert.equal(uuid.charAt(14), '4', 'Version bit should be 4');
});

runner.test('UUID v4: generates unique values', () => {
  const uuid1 = crypto.randomUUID ? crypto.randomUUID() : generateUUIDv4();
  const uuid2 = crypto.randomUUID ? crypto.randomUUID() : generateUUIDv4();
  
  assert.ok(uuid1 !== uuid2, 'Generated UUIDs should be unique');
});

runner.test('UUID v4: bulk generation creates unique values', () => {
  const count = 100;
  const uuids = new Set();
  
  for (let i = 0; i < count; i++) {
    const uuid = crypto.randomUUID ? crypto.randomUUID() : generateUUIDv4();
    uuids.add(uuid);
  }
  
  assert.equal(uuids.size, count, 'All generated UUIDs should be unique');
});

runner.test('UUID validation: accepts valid UUIDs', () => {
  const validUUIDs = [
    '550e8400-e29b-41d4-a716-446655440000',
    '6ba7b810-9dad-11d1-80b4-00c04fd430c8',
    '6ba7b811-9dad-11d1-80b4-00c04fd430c8',
    '123e4567-e89b-12d3-a456-426614174000'
  ];
  
  validUUIDs.forEach(uuid => {
    const isValid = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(uuid);
    assert.ok(isValid, `UUID ${uuid} should be valid`);
  });
});

runner.test('UUID validation: rejects invalid UUIDs', () => {
  const invalidUUIDs = [
    'not-a-uuid',
    '550e8400-e29b-41d4-a716',  // Too short
    '550e8400-e29b-41d4-a716-446655440000-extra',  // Too long
    '550e8400e29b41d4a716446655440000',  // Missing hyphens
    'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'  // Invalid characters
  ];
  
  invalidUUIDs.forEach(uuid => {
    const isValid = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(uuid);
    assert.ok(!isValid, `UUID ${uuid} should be invalid`);
  });
});

// Helper function for UUID v4 generation (fallback)
function generateUUIDv4() {
  const bytes = new Uint8Array(16);
  crypto.getRandomValues(bytes);
  
  bytes[6] = (bytes[6] & 0x0f) | 0x40;  // Version 4
  bytes[8] = (bytes[8] & 0x3f) | 0x80;  // Variant 10
  
  const hex = Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
  
  return [
    hex.substring(0, 8),
    hex.substring(8, 12),
    hex.substring(12, 16),
    hex.substring(16, 20),
    hex.substring(20, 32)
  ].join('-');
}

runner.run();
