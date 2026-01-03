/**
 * Storage Utilities
 *
 * LocalStorage and SessionStorage helpers with JSON serialization and expiration support.
 * Provides safe storage access with automatic fallback handling.
 */

/**
 * Check if storage is available
 *
 * @param {string} type - Storage type ('localStorage', 'sessionStorage', 'local', or 'session')
 * @returns {boolean} - True if storage is available
 */
function isStorageAvailable(type = 'localStorage') {
  const storageType = type === 'local' ? 'localStorage' :
                     type === 'session' ? 'sessionStorage' : type;

  try {
    const storage = window[storageType];
    const test = '__storage_test__';
    storage.setItem(test, test);
    storage.removeItem(test);
    return true;
  } catch (e) {
    return false;
  }
}

export { isStorageAvailable };

/**
 * Set item in storage with JSON serialization
 *
 * @param {string} key - Storage key
 * @param {any} value - Value to store
 * @param {string} type - Storage type
 * @returns {boolean} - True if successful
 */
export function setStorageItem(key, value, type = 'localStorage') {
  const storageType = type === 'local' ? 'localStorage' :
                     type === 'session' ? 'sessionStorage' : type;

  if (!isStorageAvailable(storageType)) {
    console.warn(`${storageType} is not available`);
    return false;
  }

  try {
    const storage = window[storageType];
    storage.setItem(key, JSON.stringify(value));
    return true;
  } catch (e) {
    console.error(`Failed to set ${storageType} item:`, e);
    return false;
  }
}

/**
 * Get item from storage with JSON parsing
 *
 * @param {string} key - Storage key
 * @param {any} defaultValue - Default value if key doesn't exist
 * @param {string} type - Storage type
 * @returns {any} - Stored value or default value
 */
export function getStorageItem(key, defaultValue = null, type = 'localStorage') {
  const storageType = type === 'local' ? 'localStorage' :
                     type === 'session' ? 'sessionStorage' : type;

  if (!isStorageAvailable(storageType)) {
    return defaultValue;
  }

  try {
    const storage = window[storageType];
    const item = storage.getItem(key);

    if (item === null) {
      return defaultValue;
    }

    return JSON.parse(item);
  } catch (e) {
    console.error(`Failed to get ${storageType} item:`, e);
    return defaultValue;
  }
}

/**
 * Remove item from storage
 *
 * @param {string} key - Storage key
 * @param {string} type - Storage type
 * @returns {boolean} - True if successful
 */
export function removeStorageItem(key, type = 'localStorage') {
  const storageType = type === 'local' ? 'localStorage' :
                     type === 'session' ? 'sessionStorage' : type;

  if (!isStorageAvailable(storageType)) {
    return false;
  }

  try {
    const storage = window[storageType];
    storage.removeItem(key);
    return true;
  } catch (e) {
    console.error(`Failed to remove ${storageType} item:`, e);
    return false;
  }
}

/**
 * Clear all items from storage
 *
 * @param {string} type - Storage type
 * @returns {boolean} - True if successful
 */
export function clearStorage(type = 'localStorage') {
  if (!isStorageAvailable(type)) {
    return false;
  }

  try {
    const storage = window[type];
    storage.clear();
    return true;
  } catch (e) {
    console.error(`Failed to clear ${type}:`, e);
    return false;
  }
}

/**
 * Get all keys from storage
 *
 * @param {string} type - Storage type
 * @returns {string[]} - Array of storage keys
 */
export function getStorageKeys(type = 'localStorage') {
  if (!isStorageAvailable(type)) {
    return [];
  }

  try {
    const storage = window[type];
    return Object.keys(storage);
  } catch (e) {
    console.error(`Failed to get ${type} keys:`, e);
    return [];
  }
}

/**
 * Get storage size in bytes
 *
 * @param {string} type - Storage type
 * @returns {number} - Size in bytes
 */
export function getStorageSize(type = 'localStorage') {
  if (!isStorageAvailable(type)) {
    return 0;
  }

  try {
    const storage = window[type];
    let size = 0;

    for (let key in storage) {
      if (storage.hasOwnProperty(key)) {
        size += key.length + storage[key].length;
      }
    }

    return size;
  } catch (e) {
    console.error(`Failed to calculate ${type} size:`, e);
    return 0;
  }
}

/**
 * Set item with expiration time
 *
 * @param {string} key - Storage key
 * @param {any} value - Value to store
 * @param {number} expirationMs - Expiration time in milliseconds
 * @param {string} type - Storage type
 * @returns {boolean} - True if successful
 */
export function setStorageItemWithExpiry(key, value, expirationMs, type = 'localStorage') {
  const item = {
    value: value,
    expiry: Date.now() + expirationMs
  };

  return setStorageItem(key, item, type);
}

/**
 * Get item with expiration check
 *
 * @param {string} key - Storage key
 * @param {any} defaultValue - Default value if expired or doesn't exist
 * @param {string} type - Storage type
 * @returns {any} - Stored value or default value
 */
export function getStorageItemWithExpiry(key, defaultValue = null, type = 'localStorage') {
  const item = getStorageItem(key, null, type);

  if (!item) {
    return defaultValue;
  }

  if (item.expiry && Date.now() > item.expiry) {
    removeStorageItem(key, type);
    return defaultValue;
  }

  return item.value;
}

/**
 * LocalStorage convenience methods
 */
export const local = {
  set: (key, value) => setStorageItem(key, value, 'localStorage'),
  get: (key, defaultValue = null) => getStorageItem(key, defaultValue, 'localStorage'),
  remove: (key) => removeStorageItem(key, 'localStorage'),
  clear: () => clearStorage('localStorage'),
  keys: () => getStorageKeys('localStorage'),
  size: () => getStorageSize('localStorage')
};

/**
 * SessionStorage convenience methods
 */
export const session = {
  set: (key, value) => setStorageItem(key, value, 'sessionStorage'),
  get: (key, defaultValue = null) => getStorageItem(key, defaultValue, 'sessionStorage'),
  remove: (key) => removeStorageItem(key, 'sessionStorage'),
  clear: () => clearStorage('sessionStorage'),
  keys: () => getStorageKeys('sessionStorage'),
  size: () => getStorageSize('sessionStorage')
};

export const saveToStorage = setStorageItem;
export const getFromStorage = getStorageItem;
export const removeFromStorage = removeStorageItem;
