/**
 * Unit tests for storage-utils.js
 */

import { TestRunner, assert } from '../test-runner.js';
import { 
  saveToStorage, 
  getFromStorage, 
  removeFromStorage, 
  clearStorage,
  isStorageAvailable 
} from '../../assets/js/lib/storage-utils.js';

const runner = new TestRunner();

// Storage availability tests
runner.test('isStorageAvailable: detects localStorage support', () => {
  const hasStorage = typeof localStorage !== 'undefined';
  assert.equal(isStorageAvailable('local'), hasStorage);
});

runner.test('isStorageAvailable: detects sessionStorage support', () => {
  const hasStorage = typeof sessionStorage !== 'undefined';
  assert.equal(isStorageAvailable('session'), hasStorage);
});

// Save/Get tests
runner.test('saveToStorage and getFromStorage: string values', () => {
  if (!isStorageAvailable('local')) return;
  
  saveToStorage('test-key', 'test-value');
  const value = getFromStorage('test-key');
  assert.equal(value, 'test-value');
  
  // Cleanup
  removeFromStorage('test-key');
});

runner.test('saveToStorage and getFromStorage: object values', () => {
  if (!isStorageAvailable('local')) return;
  
  const testObj = { foo: 'bar', num: 42 };
  saveToStorage('test-obj', testObj);
  const retrieved = getFromStorage('test-obj');
  assert.deepEqual(retrieved, testObj);
  
  // Cleanup
  removeFromStorage('test-obj');
});

runner.test('saveToStorage and getFromStorage: array values', () => {
  if (!isStorageAvailable('local')) return;
  
  const testArr = [1, 2, 3, 'four'];
  saveToStorage('test-arr', testArr);
  const retrieved = getFromStorage('test-arr');
  assert.deepEqual(retrieved, testArr);
  
  // Cleanup
  removeFromStorage('test-arr');
});

runner.test('getFromStorage: returns default for non-existent key', () => {
  if (!isStorageAvailable('local')) return;
  
  const value = getFromStorage('non-existent-key', 'default');
  assert.equal(value, 'default');
});

runner.test('getFromStorage: returns null for non-existent key without default', () => {
  if (!isStorageAvailable('local')) return;
  
  const value = getFromStorage('non-existent-key-2');
  assert.equal(value, null);
});

// Remove tests
runner.test('removeFromStorage: removes existing key', () => {
  if (!isStorageAvailable('local')) return;
  
  saveToStorage('key-to-remove', 'value');
  removeFromStorage('key-to-remove');
  const value = getFromStorage('key-to-remove');
  assert.equal(value, null);
});

runner.test('removeFromStorage: handles non-existent key gracefully', () => {
  if (!isStorageAvailable('local')) return;
  
  // Should not throw
  removeFromStorage('never-existed');
  assert.ok(true);
});

// sessionStorage tests
runner.test('saveToStorage: works with sessionStorage', () => {
  if (!isStorageAvailable('session')) return;
  
  saveToStorage('session-key', 'session-value', 'session');
  const value = getFromStorage('session-key', null, 'session');
  assert.equal(value, 'session-value');
  
  // Cleanup
  removeFromStorage('session-key', 'session');
});

// Run all tests
runner.run();
