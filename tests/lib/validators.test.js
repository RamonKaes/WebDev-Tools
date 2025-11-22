/**
 * Unit tests for validators.js
 */

import { TestRunner, assert } from '../test-runner.js';
import { 
  validateEmail, 
  validateURL, 
  validateJSON, 
  validateBase64, 
  validateHexColor 
} from '../../assets/js/lib/validators.js';

const runner = new TestRunner();

// Email validation tests
runner.test('validateEmail: accepts valid email', () => {
  assert.equal(validateEmail('test@example.com'), true);
  assert.equal(validateEmail('user.name+tag@example.co.uk'), true);
  assert.equal(validateEmail('test_123@test-domain.org'), true);
});

runner.test('validateEmail: rejects invalid email', () => {
  assert.equal(validateEmail('invalid'), false);
  assert.equal(validateEmail('@example.com'), false);
  assert.equal(validateEmail('test@'), false);
  assert.equal(validateEmail('test @example.com'), false);
});

runner.test('validateEmail: handles edge cases', () => {
  assert.equal(validateEmail(''), false);
  assert.equal(validateEmail(null), false);
  assert.equal(validateEmail(undefined), false);
});

// URL validation tests
runner.test('validateURL: accepts valid HTTP URLs', () => {
  assert.equal(validateURL('http://example.com'), true);
  assert.equal(validateURL('https://example.com'), true);
  assert.equal(validateURL('https://sub.example.com/path?query=value'), true);
});

runner.test('validateURL: rejects invalid URLs', () => {
  assert.equal(validateURL('not-a-url'), false);
  assert.equal(validateURL('//example.com'), false);
});

runner.test('validateURL: handles edge cases', () => {
  assert.equal(validateURL(''), false);
});

// JSON validation tests
runner.test('validateJSON: accepts valid JSON', () => {
  assert.equal(validateJSON('{"key":"value"}').valid, true);
  assert.equal(validateJSON('["array","values"]').valid, true);
  assert.equal(validateJSON('123').valid, true);
  assert.equal(validateJSON('null').valid, true);
  assert.equal(validateJSON('true').valid, true);
});

runner.test('validateJSON: rejects invalid JSON', () => {
  assert.equal(validateJSON('{key:value}').valid, false);
  assert.equal(validateJSON("{'key':'value'}").valid, false);
  assert.equal(validateJSON('{').valid, false);
  assert.equal(validateJSON('undefined').valid, false);
});

runner.test('validateJSON: handles edge cases', () => {
  assert.equal(validateJSON('').valid, false);
  assert.equal(validateJSON('   ').valid, false);
});

// Base64 validation tests
runner.test('validateBase64: accepts valid Base64', () => {
  assert.equal(validateBase64('SGVsbG8gV29ybGQ='), true);
  assert.equal(validateBase64('YWJjZGVmZ2g='), true);
  assert.equal(validateBase64('MTIzNDU2Nzg='), true);
});

runner.test('validateBase64: rejects invalid Base64', () => {
  assert.equal(validateBase64('Hello World'), false);
  assert.equal(validateBase64('SGVsbG8@V29ybGQ='), false); // Invalid char
});

runner.test('validateBase64: handles edge cases', () => {
  assert.equal(validateBase64(''), false);
  assert.equal(validateBase64(null), false);
  assert.equal(validateBase64(undefined), false);
});

// Hex color validation tests
runner.test('validateHexColor: accepts valid hex colors', () => {
  assert.equal(validateHexColor('#fff'), true);
  assert.equal(validateHexColor('#ffffff'), true);
  assert.equal(validateHexColor('#ABC123'), true);
});

runner.test('validateHexColor: rejects invalid hex colors', () => {
  assert.equal(validateHexColor('fff'), false); // Missing #
  assert.equal(validateHexColor('#gg0000'), false); // Invalid char
  assert.equal(validateHexColor('#ff'), false); // Too short
  assert.equal(validateHexColor('#fffffff'), false); // Too long
});

runner.test('validateHexColor: handles edge cases', () => {
  assert.equal(validateHexColor(''), false);
  assert.equal(validateHexColor('#'), false);
});

// Run all tests
runner.run();
