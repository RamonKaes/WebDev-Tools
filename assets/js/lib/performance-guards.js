/**
 * Performance Guards
 *
 * Size limits and validation helpers for safe processing of large inputs.
 * Prevents browser freezing and memory issues with excessive data.
 */

/**
 * JSON size limits (in bytes)
 */
export const JSON_LIMITS = {
  WARNING_SIZE: 1024 * 1024,
  MAX_SIZE: 5 * 1024 * 1024,
  MAX_TREE_DEPTH: 50,
  MAX_TREE_NODES: 10000
};

/**
 * Password generator limits
 */
export const PASSWORD_LIMITS = {
  MAX_BATCH_SIZE: 1000,
  MAX_LENGTH: 256
};

/**
 * Check if JSON is too large to process safely
 *
 * @param {string} jsonString - JSON string to check
 * @returns {object} - { allowed: boolean, size: number, warning: boolean, message: string }
 */
export function checkJSONSize(jsonString) {
  const size = new Blob([jsonString]).size;

  if (size > JSON_LIMITS.MAX_SIZE) {
    return {
      allowed: false,
      size,
      warning: true,
      message: `File too large (${(size / 1024 / 1024).toFixed(2)} MB). Maximum size is ${JSON_LIMITS.MAX_SIZE / 1024 / 1024} MB.`
    };
  }

  if (size > JSON_LIMITS.WARNING_SIZE) {
    return {
      allowed: true,
      size,
      warning: true,
      message: `Large file (${(size / 1024 / 1024).toFixed(2)} MB). Processing may be slow.`
    };
  }

  return {
    allowed: true,
    size,
    warning: false,
    message: null
  };
}

/**
 * Check JSON tree depth
 *
 * @param {object} obj - Parsed JSON object
 * @param {number} currentDepth - Current depth
 * @returns {number} - Maximum depth found
 */
export function getJSONDepth(obj, currentDepth = 0) {
  if (currentDepth > JSON_LIMITS.MAX_TREE_DEPTH) {
    return currentDepth;
  }

  if (obj === null || typeof obj !== 'object') {
    return currentDepth;
  }

  let maxDepth = currentDepth;

  for (const key in obj) {
    if (obj.hasOwnProperty(key)) {
      const depth = getJSONDepth(obj[key], currentDepth + 1);
      maxDepth = Math.max(maxDepth, depth);
    }
  }

  return maxDepth;
}

/**
 * Count JSON nodes
 *
 * @param {object} obj - Parsed JSON object
 * @param {number} maxCount - Maximum count to stop at
 * @returns {number} - Node count
 */
export function countJSONNodes(obj, maxCount = JSON_LIMITS.MAX_TREE_NODES) {
  let count = 0;

  function traverse(node) {
    if (count >= maxCount) {
      return;
    }

    count++;

    if (node !== null && typeof node === 'object') {
      for (const key in node) {
        if (node.hasOwnProperty(key)) {
          traverse(node[key]);
        }
      }
    }
  }

  traverse(obj);
  return count;
}

/**
 * Check if JSON should render tree view
 *
 * @param {object} parsedJSON - Parsed JSON object
 * @returns {object} - { allowed: boolean, reason: string|null }
 */
export function canRenderJSONTree(parsedJSON) {
  const depth = getJSONDepth(parsedJSON);

  if (depth > JSON_LIMITS.MAX_TREE_DEPTH) {
    return {
      allowed: false,
      reason: `JSON too deeply nested (${depth} levels). Maximum depth is ${JSON_LIMITS.MAX_TREE_DEPTH}.`
    };
  }

  const nodeCount = countJSONNodes(parsedJSON);

  if (nodeCount > JSON_LIMITS.MAX_TREE_NODES) {
    return {
      allowed: false,
      reason: `JSON too complex (${nodeCount} nodes). Maximum is ${JSON_LIMITS.MAX_TREE_NODES} nodes.`
    };
  }

  return {
    allowed: true,
    reason: null
  };
}

/**
 * Validate password generation batch size
 *
 * @param {number} count - Number of passwords to generate
 * @returns {object} - { allowed: boolean, message: string|null }
 */
export function validatePasswordBatchSize(count) {
  if (count > PASSWORD_LIMITS.MAX_BATCH_SIZE) {
    return {
      allowed: false,
      message: `Cannot generate more than ${PASSWORD_LIMITS.MAX_BATCH_SIZE} passwords at once.`
    };
  }

  if (count < 1) {
    return {
      allowed: false,
      message: 'Must generate at least 1 password.'
    };
  }

  return {
    allowed: true,
    message: null
  };
}

/**
 * Validate password length
 *
 * @param {number} length - Password length
 * @returns {object} - { allowed: boolean, message: string|null }
 */
export function validatePasswordLength(length) {
  if (length > PASSWORD_LIMITS.MAX_LENGTH) {
    return {
      allowed: false,
      message: `Password length cannot exceed ${PASSWORD_LIMITS.MAX_LENGTH} characters.`
    };
  }

  if (length < 1) {
    return {
      allowed: false,
      message: 'Password length must be at least 1 character.'
    };
  }

  return {
    allowed: true,
    message: null
  };
}

/**
 * Throttle function to prevent excessive calls
 *
 * @param {Function} func - Function to throttle
 * @param {number} delay - Delay in milliseconds
 * @returns {Function} - Throttled function
 */
export function throttle(func, delay) {
  let timeoutId = null;
  let lastExec = 0;

  return function (...args) {
    const elapsed = Date.now() - lastExec;

    const execute = () => {
      lastExec = Date.now();
      func.apply(this, args);
    };

    if (elapsed > delay) {
      execute();
    } else {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(execute, delay - elapsed);
    }
  };
}

/**
 * Debounce function to delay execution
 *
 * @param {Function} func - Function to debounce
 * @param {number} delay - Delay in milliseconds
 * @returns {Function} - Debounced function
 */
export function debounce(func, delay) {
  let timeoutId = null;

  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => func.apply(this, args), delay);
  };
}
