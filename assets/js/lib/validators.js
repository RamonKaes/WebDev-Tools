/**
 * Validation Utilities
 *
 * Input validation helpers for JSON, UUIDs, URLs, emails, passwords, and more.
 * Provides consistent validation across all tools with detailed feedback.
 */

/**
 * Validate JSON string
 *
 * @param {string} str - String to validate
 * @returns {object} - { valid: boolean, error: string|null, data: any|null }
 */
export function validateJSON(str) {
  if (!str || str.trim() === '') {
    return { valid: false, error: window.i18n?.t('validation.empty_input') || 'Empty input', data: null };
  }

  try {
    const data = JSON.parse(str);
    return { valid: true, error: null, data };
  } catch (e) {
    return { valid: false, error: e.message, data: null };
  }
}

/**
 * Validate UUID format (v1, v4, v5)
 *
 * @param {string} uuid - UUID string to validate
 * @returns {boolean} - True if valid UUID format
 */
export function validateUUID(uuid) {
  const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
  return uuidRegex.test(uuid);
}

/**
 * Validate Base64 string
 *
 * @param {string} str - Base64 string to validate
 * @param {boolean} urlSafe - Whether to check for URL-safe Base64
 * @returns {boolean} - True if valid Base64
 */
export function validateBase64(str, urlSafe = false) {
  if (!str || str.trim() === '') return false;

  if (urlSafe) {
    return /^[A-Za-z0-9_-]+$/.test(str.trim());
  } else {
    return /^[A-Za-z0-9+/]*={0,2}$/.test(str.trim());
  }
}

/**
 * Validate URL format
 *
 * @param {string} str - URL string to validate
 * @returns {boolean} - True if valid URL
 */
export function validateURL(str) {
  try {
    new URL(str);
    return true;
  } catch {
    return false;
  }
}

/**
 * Validate email format
 *
 * @param {string} email - Email address to validate
 * @returns {boolean} - True if valid email format
 */
export function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

/**
 * Validate hex color code
 *
 * @param {string} color - Color string to validate
 * @returns {boolean} - True if valid hex color (#RGB or #RRGGBB)
 */
export function validateHexColor(color) {
  return /^#([0-9A-F]{3}|[0-9A-F]{6})$/i.test(color);
}

/**
 * Validate hash format
 *
 * @param {string} hash - Hash string to validate
 * @param {string} algorithm - Hash algorithm ('md5', 'sha1', 'sha256', 'sha512')
 * @returns {boolean} - True if valid hash format
 */
export function validateHash(hash, algorithm) {
  const lengths = {
    'md5': 32,
    'sha1': 40,
    'sha256': 64,
    'sha512': 128
  };

  const expectedLength = lengths[algorithm.toLowerCase()];
  if (!expectedLength) return false;

  const hexRegex = new RegExp(`^[a-f0-9]{${expectedLength}}$`, 'i');
  return hexRegex.test(hash);
}

/**
 * Validate positive integer
 *
 * @param {string|number} value - Value to validate
 * @param {number} min - Minimum value (inclusive)
 * @param {number} max - Maximum value (inclusive)
 * @returns {boolean} - True if valid positive integer in range
 */
export function validatePositiveInteger(value, min = 1, max = Infinity) {
  const num = parseInt(value, 10);
  return Number.isInteger(num) && num >= min && num <= max;
}

/**
 * Validate password strength
 *
 * @param {string} password - Password to validate
 * @returns {object} - { score: 0-4, feedback: string[], strength: string }
 */
export function validatePasswordStrength(password) {
  let score = 0;
  const feedback = [];

  if (!password) {
    return { score: 0, feedback: [window.i18n?.t('validation.password_required') || 'Password is required'], strength: window.i18n?.t('validation.strength.very_weak') || 'Very Weak' };
  }

  if (password.length >= 8) score++;
  if (password.length >= 12) score++;
  if (password.length < 8) feedback.push('Use at least 8 characters');

  if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
    score++;
  } else {
    feedback.push(window.i18n?.t('validation.use_lowercase_uppercase') || 'Use both lowercase and uppercase letters');
  }

  if (/\d/.test(password)) {
    score++;
  } else {
    feedback.push(window.i18n?.t('validation.include_numbers') || 'Include numbers');
  }

  if (/[^a-zA-Z0-9]/.test(password)) {
    score++;
  } else {
    feedback.push(window.i18n?.t('validation.include_special') || 'Include special characters');
  }

  if (/^(.)\1+$/.test(password)) {
    score = Math.max(0, score - 2);
    feedback.push(window.i18n?.t('validation.avoid_repeating') || 'Avoid repeating characters');
  }

  if (/^(123|abc|qwe|password)/i.test(password)) {
    score = Math.max(0, score - 1);
    feedback.push(window.i18n?.t('validation.avoid_common_patterns') || 'Avoid common patterns');
  }

  const strengths = [
    window.i18n?.t('validation.strength.very_weak') || 'Very Weak',
    window.i18n?.t('validation.strength.weak') || 'Weak',
    window.i18n?.t('validation.strength.fair') || 'Fair',
    window.i18n?.t('validation.strength.strong') || 'Strong',
    window.i18n?.t('validation.strength.very_strong') || 'Very Strong'
  ];
  const strength = strengths[Math.min(score, 4)];

  return { score, feedback, strength };
}

/**
 * Sanitize filename for safe downloads
 *
 * @param {string} filename - Filename to sanitize
 * @returns {string} - Sanitized filename
 */
export function sanitizeFilename(filename) {
  return filename
    .replace(/[^a-z0-9._-]/gi, '_')
    .replace(/_{2,}/g, '_')
    .substring(0, 255);
}

/**
 * Validate MIME type
 *
 * @param {string} mimeType - MIME type to validate
 * @returns {boolean} - True if valid MIME type format
 */
export function validateMimeType(mimeType) {
  return /^[a-z]+\/[a-z0-9\-\+\.]+$/i.test(mimeType);
}
