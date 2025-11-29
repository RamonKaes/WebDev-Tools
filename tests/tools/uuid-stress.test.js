/**
 * UUID Stress Test - ensure uniqueness in bulk generation (500 samples)
 */

import { TestRunner, assert } from '../test-runner.js';

const runner = new TestRunner();

runner.test('UUID v4 stress: bulk uniqueness 500', () => {
  const count = 500;
  const uuids = new Set();
  for (let i = 0; i < count; i++) {
    const uuid = crypto.randomUUID ? crypto.randomUUID() : generateUUIDv4();
    uuids.add(uuid);
  }
  assert.equal(uuids.size, count, `Expected ${count} unique UUIDs`);
});

// fallback generator helper
function generateUUIDv4() {
  const bytes = new Uint8Array(16);
  crypto.getRandomValues(bytes);
  bytes[6] = (bytes[6] & 0x0f) | 0x40;
  bytes[8] = (bytes[8] & 0x3f) | 0x80;
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
