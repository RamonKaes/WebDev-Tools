/**
 * Unit tests for formatters.js
 */

import { TestRunner, assert } from '../test-runner.js';
import { formatBytes, formatNumber, formatDate } from '../../assets/js/lib/formatters.js';

const runner = new TestRunner();

// Byte formatting tests
runner.test('formatBytes: formats 0 bytes', () => {
  assert.equal(formatBytes(0), '0 Bytes');
});

runner.test('formatBytes: formats bytes correctly', () => {
  assert.equal(formatBytes(100), '100 Bytes');
  assert.equal(formatBytes(1023), '1023 Bytes');
});

runner.test('formatBytes: formats KB correctly', () => {
  assert.equal(formatBytes(1024), '1.0 KB');
  assert.equal(formatBytes(2048), '2.0 KB');
});

runner.test('formatBytes: formats MB correctly', () => {
  assert.equal(formatBytes(1048576), '1.0 MB');
  assert.equal(formatBytes(5242880), '5.0 MB');
});

runner.test('formatBytes: formats GB correctly', () => {
  assert.equal(formatBytes(1073741824), '1.0 GB');
});

runner.test('formatBytes: handles decimals parameter', () => {
  const result = formatBytes(1536, 2); // 1.5 KB
  assert.ok(result.includes('1.5') && result.includes('KB'));
});

// Number formatting tests
runner.test('formatNumber: formats integers', () => {
  assert.equal(formatNumber(1000), '1,000');
  assert.equal(formatNumber(1000000), '1,000,000');
});

runner.test('formatNumber: formats decimals', () => {
  const result = formatNumber(1234.56);
  assert.ok(result.includes('1,234') || result.includes('1.234')); // Locale dependent
});

runner.test('formatNumber: handles zero', () => {
  assert.equal(formatNumber(0), '0');
});

runner.test('formatNumber: handles negative numbers', () => {
  const result = formatNumber(-1000);
  assert.ok(result.includes('-') && result.includes('1'));
});

// Date formatting tests
runner.test('formatDate: formats Date object', () => {
  const date = new Date('2025-11-04T12:00:00Z');
  const formatted = formatDate(date);
  assert.typeOf(formatted, 'string');
  assert.ok(formatted.length > 0);
});

runner.test('formatDate: handles timestamp', () => {
  const timestamp = Date.now();
  const formatted = formatDate(timestamp);
  assert.typeOf(formatted, 'string');
  assert.ok(formatted.length > 0);
});

runner.test('formatDate: handles ISO string', () => {
  const isoString = '2025-11-04T12:00:00Z';
  const formatted = formatDate(isoString);
  assert.typeOf(formatted, 'string');
  assert.ok(formatted.includes('2025') || formatted.includes('11') || formatted.includes('04'));
});

// Run all tests
runner.run();
