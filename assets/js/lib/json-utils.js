/**
 * JSON Utilities
 *
 * JSON parsing, validation, formatting, and analysis helpers.
 * Provides detailed error reporting and auto-fix capabilities.
 */

/**
 * Parse JSON with error details
 *
 * @param {string} jsonString - JSON string to parse
 * @returns {Object} - { success: boolean, data?: any, error?: string, line?: number, column?: number }
 */
export function parseJSON(jsonString) {
  try {
    const data = JSON.parse(jsonString);
    return { success: true, data };
  } catch (error) {
    const match = error.message.match(/position (\d+)/);
    const position = match ? parseInt(match[1]) : 0;

    const lines = jsonString.substring(0, position).split('\n');
    const line = lines.length;
    const column = lines[lines.length - 1].length + 1;

    return {
      success: false,
      error: error.message,
      line,
      column
    };
  }
}

/**
 * Format JSON with specified indentation
 *
 * @param {string} jsonString - JSON string
 * @param {string|number} indent - Indentation ('2', '4', 'tab')
 * @param {boolean} sortKeys - Sort object keys alphabetically
 * @returns {Object} - { success: boolean, formatted?: string, error?: string }
 */
export function formatJSON(jsonString, indent = 4, sortKeys = false) {
  const parseResult = parseJSON(jsonString);

  if (!parseResult.success) {
    return { success: false, error: parseResult.error };
  }

  try {
    const indentValue = indent === 'tab' ? '\t' : parseInt(indent);

    if (sortKeys) {
      const sorted = sortObjectKeys(parseResult.data);
      return { success: true, formatted: JSON.stringify(sorted, null, indentValue) };
    }

    return { success: true, formatted: JSON.stringify(parseResult.data, null, indentValue) };
  } catch (error) {
    return { success: false, error: error.message };
  }
}

/**
 * Minify JSON (remove all whitespace)
 *
 * @param {string} jsonString - JSON string
 * @returns {Object} - { success: boolean, minified?: string, error?: string }
 */
export function minifyJSON(jsonString) {
  const parseResult = parseJSON(jsonString);

  if (!parseResult.success) {
    return { success: false, error: parseResult.error };
  }

  try {
    return { success: true, minified: JSON.stringify(parseResult.data) };
  } catch (error) {
    return { success: false, error: error.message };
  }
}

/**
 * Validate JSON
 *
 * @param {string} jsonString - JSON string
 * @returns {Object} - { valid: boolean, error?: string, line?: number, column?: number }
 */
export function validateJSON(jsonString) {
  const result = parseJSON(jsonString);

  return {
    valid: result.success,
    error: result.error,
    line: result.line,
    column: result.column
  };
}

/**
 * Attempt to auto-fix common JSON errors
 *
 * Applies the following transformations:
 * - Single quotes → double quotes
 * - Trailing commas → removed
 * - Unquoted keys → quoted keys
 * - Escaped single quotes → unescaped
 *
 * @param {string} jsonString - Potentially invalid JSON
 * @returns {string} - Fixed JSON string
 */
export function autoFixJSON(jsonString) {
  let fixed = jsonString;

  fixed = fixed.replace(/'/g, '"');
  fixed = fixed.replace(/,(\s*[}\]])/g, '$1');
  fixed = fixed.replace(/(\{|,)\s*([a-zA-Z_$][a-zA-Z0-9_$]*)\s*:/g, '$1"$2":');
  fixed = fixed.replace(/\\'/g, "'");

  return fixed;
}

/**
 * Sort object keys recursively
 *
 * @param {any} obj - Object or value to sort
 * @returns {any} - Object with sorted keys or original value
 */
function sortObjectKeys(obj) {
  if (obj === null || typeof obj !== 'object') {
    return obj;
  }

  if (Array.isArray(obj)) {
    return obj.map(sortObjectKeys);
  }

  const sorted = {};
  Object.keys(obj).sort().forEach(key => {
    sorted[key] = sortObjectKeys(obj[key]);
  });

  return sorted;
}

/**
 * Get JSON statistics
 *
 * @param {string} jsonString - JSON string
 * @returns {Object} - { keys: number, depth: number, size: number }
 */
export function getJSONStats(jsonString) {
  const parseResult = parseJSON(jsonString);

  if (!parseResult.success) {
    return { keys: 0, depth: 0, size: 0 };
  }

  const countKeys = (obj) => {
    if (obj === null || typeof obj !== 'object') return 0;
    if (Array.isArray(obj)) return obj.reduce((sum, item) => sum + countKeys(item), 0);
    return Object.keys(obj).length + Object.values(obj).reduce((sum, val) => sum + countKeys(val), 0);
  };

  const getDepth = (obj, currentDepth = 1) => {
    if (obj === null || typeof obj !== 'object') return currentDepth;
    if (Array.isArray(obj)) {
      return obj.length === 0 ? currentDepth : Math.max(...obj.map(item => getDepth(item, currentDepth + 1)));
    }
    const values = Object.values(obj);
    return values.length === 0 ? currentDepth : Math.max(...values.map(val => getDepth(val, currentDepth + 1)));
  };

  return {
    keys: countKeys(parseResult.data),
    depth: getDepth(parseResult.data),
    size: new Blob([jsonString]).size
  };
}
