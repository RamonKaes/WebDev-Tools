/**
 * Formatting Utilities
 *
 * Data formatting helpers for bytes, numbers, dates, colors, and text.
 * Provides consistent output formatting across all tools.
 */

/**
 * Format bytes to human-readable size
 *
 * @param {number} bytes - Size in bytes
 * @param {number} decimals - Number of decimal places
 * @returns {string} - Formatted size (e.g., '1.5 MB')
 */
export function formatBytes(bytes, decimals = null) {
  if (bytes === 0) return '0 Bytes';

  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

  const i = Math.floor(Math.log(bytes) / Math.log(k));
  const dm = decimals !== null ? decimals : (i === 0 ? 0 : 1);

  return (bytes / Math.pow(k, i)).toFixed(dm) + ' ' + sizes[i];
}

/**
 * Format number with thousand separators
 *
 * @param {number} num - Number to format
 * @param {string} separator - Thousands separator
 * @returns {string} - Formatted number
 */
export function formatNumber(num, separator = ',') {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator);
}

/**
 * Format JSON with syntax highlighting for HTML display
 *
 * @param {string} json - JSON string
 * @returns {string} - HTML with syntax highlighting
 */
export function formatJSONWithHighlighting(json) {
  json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

  return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, (match) => {
    let cls = 'json-number';
    if (/^"/.test(match)) {
      if (/:$/.test(match)) {
        cls = 'json-key';
      } else {
        cls = 'json-string';
      }
    } else if (/true|false/.test(match)) {
      cls = 'json-boolean';
    } else if (/null/.test(match)) {
      cls = 'json-null';
    }
    return '<span class="' + cls + '">' + match + '</span>';
  });
}

/**
 * Truncate text with ellipsis
 *
 * @param {string} text - Text to truncate
 * @param {number} maxLength - Maximum length
 * @param {string} ellipsis - Ellipsis string
 * @returns {string} - Truncated text
 */
export function truncateText(text, maxLength, ellipsis = '...') {
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength - ellipsis.length) + ellipsis;
}

/**
 * Format timestamp to relative time (e.g., '2 hours ago')
 *
 * @param {Date|number} date - Date or timestamp
 * @returns {string} - Relative time string
 */
export function formatRelativeTime(date) {
  const now = Date.now();
  const timestamp = date instanceof Date ? date.getTime() : date;
  const seconds = Math.floor((now - timestamp) / 1000);

  if (seconds < 60) return window.i18n?.t('time.just_now') || 'just now';

  const minutes = Math.floor(seconds / 60);
  if (minutes < 60) {
    const key = 'time.minutes_ago';
    const text = window.i18n?.t(key) || '{count} minute{s} ago';
    return text.replace('{count}', minutes).replace('{s}', minutes !== 1 ? 's' : '');
  }

  const hours = Math.floor(minutes / 60);
  if (hours < 24) {
    const key = 'time.hours_ago';
    const text = window.i18n?.t(key) || '{count} hour{s} ago';
    return text.replace('{count}', hours).replace('{s}', hours !== 1 ? 's' : '');
  }

  const days = Math.floor(hours / 24);
  if (days < 30) {
    const key = 'time.days_ago';
    const text = window.i18n?.t(key) || '{count} day{s} ago';
    return text.replace('{count}', days).replace('{s}', days !== 1 ? 's' : '');
  }

  const months = Math.floor(days / 30);
  if (months < 12) {
    const key = 'time.months_ago';
    const text = window.i18n?.t(key) || '{count} month{s} ago';
    return text.replace('{count}', months).replace('{s}', months !== 1 ? 's' : '');
  }

  const years = Math.floor(months / 12);
  const key = 'time.years_ago';
  const text = window.i18n?.t(key) || '{count} year{s} ago';
  return text.replace('{count}', years).replace('{s}', years !== 1 ? 's' : '');
}

/**
 * Format duration in milliseconds to human-readable string
 *
 * @param {number} ms - Duration in milliseconds
 * @returns {string} - Formatted duration (e.g., '2h 30m 15s')
 */
export function formatDuration(ms) {
  if (ms < 1000) return `${ms}ms`;

  const seconds = Math.floor(ms / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);

  if (days > 0) {
    return `${days}d ${hours % 24}h`;
  } else if (hours > 0) {
    return `${hours}h ${minutes % 60}m`;
  } else if (minutes > 0) {
    return `${minutes}m ${seconds % 60}s`;
  } else {
    return `${seconds}s`;
  }
}

/**
 * Format hex color to RGB
 *
 * @param {string} hex - Hex color code (#RGB or #RRGGBB)
 * @returns {object|null} - { r, g, b } or null if invalid
 */
export function hexToRGB(hex) {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  if (!result) {
    const shortResult = /^#?([a-f\d])([a-f\d])([a-f\d])$/i.exec(hex);
    if (shortResult) {
      return {
        r: parseInt(shortResult[1] + shortResult[1], 16),
        g: parseInt(shortResult[2] + shortResult[2], 16),
        b: parseInt(shortResult[3] + shortResult[3], 16)
      };
    }
    return null;
  }
  return {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  };
}

/**
 * Format RGB to hex color
 *
 * @param {number} r - Red (0-255)
 * @param {number} g - Green (0-255)
 * @param {number} b - Blue (0-255)
 * @returns {string} - Hex color code
 */
export function rgbToHex(r, g, b) {
  return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
}

/**
 * Format percentage
 *
 * @param {number} value - Value
 * @param {number} total - Total
 * @param {number} decimals - Decimal places
 * @returns {string} - Formatted percentage (e.g., '75.5%')
 */
export function formatPercentage(value, total, decimals = 1) {
  if (total === 0) return '0%';
  const percentage = (value / total) * 100;
  return percentage.toFixed(decimals) + '%';
}

/**
 * Pluralize word based on count
 *
 * @param {number} count - Count
 * @param {string} singular - Singular form
 * @param {string} plural - Plural form
 * @returns {string} - Pluralized string with count
 */
export function pluralize(count, singular, plural = null) {
  const word = count === 1 ? singular : (plural || singular + 's');
  return `${count} ${word}`;
}

/**
 * Format camelCase to Title Case
 *
 * @param {string} str - camelCase string
 * @returns {string} - Title Case string
 */
export function camelToTitle(str) {
  return str
    .replace(/([A-Z])/g, ' $1')
    .replace(/^./, (s) => s.toUpperCase())
    .trim();
}

/**
 * Format snake_case to Title Case
 *
 * @param {string} str - snake_case string
 * @returns {string} - Title Case string
 */
export function snakeToTitle(str) {
  return str
    .split('_')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
    .join(' ');
}

/**
 * Format date to readable string
 *
 * @param {Date|number|string} date - Date object, timestamp, or ISO string
 * @param {Object} options - Intl.DateTimeFormat options
 * @returns {string} - Formatted date string
 */
export function formatDate(date, options = {}) {
  const dateObj = date instanceof Date ? date : new Date(date);

  if (isNaN(dateObj.getTime())) {
    return window.i18n?.t('date.invalid') || 'Invalid Date';
  }

  const defaultOptions = {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    ...options
  };

  // Get locale from document language attribute or fall back to 'en'
  const userLocale = document.documentElement.lang || 'en';
  return new Intl.DateTimeFormat(userLocale, defaultOptions).format(dateObj);
}
