/**
 * Unit tests for dragdrop-utils.js
 */

import { TestRunner, assert } from '../test-runner.js';
import { 
  validateFileSecurity, 
  validateFileSize, 
  validateFileType,
  formatFileSize,
  DEFAULT_CONFIG 
} from '../../assets/js/lib/dragdrop-utils.js';

const runner = new TestRunner();

// File security validation tests
runner.test('validateFileSecurity: accepts valid files', () => {
  const validFile = new File(['content'], 'test.txt', { type: 'text/plain' });
  const result = validateFileSecurity(validFile);
  
  assert.equal(result.valid, true);
  assert.equal(result.error, null);
});

runner.test('validateFileSecurity: rejects oversized files', () => {
  const largeContent = new Array(11 * 1024 * 1024).fill('x').join('');
  const largeFile = new File([largeContent], 'large.txt', { type: 'text/plain' });
  const result = validateFileSecurity(largeFile, { maxSize: 10 * 1024 * 1024 });
  
  assert.equal(result.valid, false);
  assert.ok(result.error.includes('exceeds maximum'));
});

runner.test('validateFileSecurity: rejects blocked extensions', () => {
  const exeFile = new File(['content'], 'malware.exe', { type: 'application/x-msdownload' });
  const result = validateFileSecurity(exeFile);
  
  assert.equal(result.valid, false);
  assert.ok(result.error.includes('not allowed'));
});

runner.test('validateFileSecurity: rejects .bat files', () => {
  const batFile = new File(['@echo off'], 'script.bat', { type: 'application/x-bat' });
  const result = validateFileSecurity(batFile);
  
  assert.equal(result.valid, false);
});

runner.test('validateFileSecurity: rejects .sh files', () => {
  const shFile = new File(['#!/bin/bash'], 'script.sh', { type: 'application/x-sh' });
  const result = validateFileSecurity(shFile);
  
  assert.equal(result.valid, false);
});

runner.test('validateFileSecurity: rejects disallowed MIME types', () => {
  const file = new File(['content'], 'test.xyz', { type: 'application/x-custom' });
  const result = validateFileSecurity(file, {
    allowedTypes: ['text/plain', 'application/json']
  });
  
  assert.equal(result.valid, false);
  assert.ok(result.error.includes('MIME type not allowed'));
});

runner.test('validateFileSecurity: accepts wildcard MIME types', () => {
  const imageFile = new File(['data'], 'test.png', { type: 'image/png' });
  const result = validateFileSecurity(imageFile, {
    allowedTypes: ['image/*']
  });
  
  assert.equal(result.valid, true);
});

runner.test('validateFileSecurity: warns on MIME type mismatch', () => {
  // PNG file with wrong MIME type
  const file = new File(['data'], 'test.png', { type: 'text/plain' });
  const consoleSpy = [];
  const originalWarn = console.warn;
  console.warn = (msg) => consoleSpy.push(msg);
  
  const result = validateFileSecurity(file, {
    allowedTypes: ['text/plain', 'image/png']
  });
  
  console.warn = originalWarn;
  
  assert.equal(result.valid, true); // Still valid but warned
  assert.ok(consoleSpy.some(msg => msg.includes('MIME type mismatch')));
});

// File size validation tests
runner.test('validateFileSize: accepts files within limit', () => {
  const file = new File(['small content'], 'small.txt', { type: 'text/plain' });
  assert.equal(validateFileSize(file, 10), true);
});

runner.test('validateFileSize: rejects files over limit', () => {
  const largeContent = new Array(2 * 1024 * 1024).fill('x').join('');
  const file = new File([largeContent], 'large.txt', { type: 'text/plain' });
  assert.equal(validateFileSize(file, 1), false);
});

// File type validation tests
runner.test('validateFileType: validates MIME types', () => {
  const file = new File(['content'], 'test.txt', { type: 'text/plain' });
  assert.equal(validateFileType(file, ['text/plain']), true);
  assert.equal(validateFileType(file, ['application/json']), false);
});

runner.test('validateFileType: validates extensions', () => {
  const file = new File(['content'], 'test.json', { type: 'application/json' });
  assert.equal(validateFileType(file, ['.json']), true);
  assert.equal(validateFileType(file, ['.txt']), false);
});

runner.test('validateFileType: validates wildcard types', () => {
  const file = new File(['data'], 'test.png', { type: 'image/png' });
  assert.equal(validateFileType(file, ['image/*']), true);
  assert.equal(validateFileType(file, ['text/*']), false);
});

runner.test('validateFileType: case insensitive extension check', () => {
  const file = new File(['content'], 'TEST.TXT', { type: 'text/plain' });
  assert.equal(validateFileType(file, ['.txt']), true);
  assert.equal(validateFileType(file, ['.TXT']), true);
});

// File size formatting tests
runner.test('formatFileSize: formats bytes correctly', () => {
  assert.equal(formatFileSize(0), '0 Bytes');
  assert.equal(formatFileSize(1024), '1 KB');
  assert.equal(formatFileSize(1024 * 1024), '1 MB');
  assert.equal(formatFileSize(1.5 * 1024 * 1024), '1.5 MB');
});

runner.test('formatFileSize: handles large files', () => {
  const result = formatFileSize(5.5 * 1024 * 1024 * 1024);
  assert.ok(result.includes('GB'));
});

// Default configuration tests
runner.test('DEFAULT_CONFIG: has expected properties', () => {
  assert.ok(typeof DEFAULT_CONFIG.MAX_FILE_SIZE === 'number');
  assert.ok(Array.isArray(DEFAULT_CONFIG.ALLOWED_TYPES));
  assert.ok(Array.isArray(DEFAULT_CONFIG.BLOCKED_EXTENSIONS));
});

runner.test('DEFAULT_CONFIG: blocks dangerous extensions', () => {
  const dangerousExtensions = ['.exe', '.bat', '.sh', '.ps1', '.dll'];
  dangerousExtensions.forEach(ext => {
    assert.ok(DEFAULT_CONFIG.BLOCKED_EXTENSIONS.includes(ext), 
      `Should block ${ext}`);
  });
});

runner.test('DEFAULT_CONFIG: allows common safe types', () => {
  const safeTypes = ['text/plain', 'application/json', 'image/png'];
  safeTypes.forEach(type => {
    assert.ok(DEFAULT_CONFIG.ALLOWED_TYPES.includes(type), 
      `Should allow ${type}`);
  });
});

// Run all tests
runner.run();
