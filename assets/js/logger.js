/**
 * Logger Utility
 *
 * Environment-aware logging with error classification and stack trace collection.
 * Suppresses debug/info logs in production.
 */

const ErrorType = {
  VALIDATION: 'VALIDATION',
  NETWORK: 'NETWORK',
  SYSTEM: 'SYSTEM',
  UNKNOWN: 'UNKNOWN'
};

class Logger {
  constructor() {
    this.isDevelopment = this.detectEnvironment();
    this.prefix = '[WebDev-Tools]';
    this.errorHistory = [];
    this.maxHistorySize = 50;
    this.errorTrackingService = null;
  }

  /**
   * Detect development vs production environment
   *
   * @returns {boolean} True if development
   */
  detectEnvironment() {
    const hostname = window.location.hostname;
    const isDev = hostname === 'localhost' ||
                  hostname === '127.0.0.1' ||
                  hostname.startsWith('192.168.') ||
                  hostname.endsWith('.local') ||
                  hostname.endsWith('.test');

    const urlParams = new URLSearchParams(window.location.search);
    const debugMode = urlParams.has('debug');

    return isDev || debugMode;
  }

  /**
   * Format message with prefix, level, and timestamp
   *
   * @param {string} level - Log level
   * @param {string|Object} message - Message to log
   * @param {Object} context - Additional context
   * @returns {Array} Formatted arguments
   */
  formatMessage(level, message, context = {}) {
    const timestamp = new Date().toISOString().split('T')[1].split('.')[0];
    let formatted = `${this.prefix} [${level}] [${timestamp}]`;

    if (typeof message === 'object') {
      return [formatted, message, context];
    }

    return [formatted, message, ...(Object.keys(context).length ? [context] : [])];
  }

  /**
   * Development and debug logging (suppressed in production)
   *
   * @param {string|Object} message - Message to log
   * @param {Object} [context={}] - Additional context data
   * @returns {void}
   */
  debug(message, context = {}) {
    if (!this.isDevelopment) return;
    const args = this.formatMessage('DEBUG', message, context);
    console.debug(...args);
  }

  /**
   * Informational logging (suppressed in production)
   *
   * @param {string|Object} message - Message to log
   * @param {Object} [context={}] - Additional context data
   * @returns {void}
   */
  log(message, context = {}) {
    if (!this.isDevelopment) return;
    const args = this.formatMessage('INFO', message, context);
    console.log(...args);
  }

  /**
   * Info alias for log
   *
   * @param {string|Object} message - Message to log
   * @param {Object} [context={}] - Additional context data
   * @returns {void}
   */
  info(message, context = {}) {
    this.log(message, context);
  }

  /**
  /**
   * Warning logging (shown in both dev and production)
   *
   * @param {string|Object} message - Message to log
   * @param {Object} context - Additional context
   */
  warn(message, context = {}) {
    const args = this.formatMessage('WARN', message, context);
    console.warn(...args);
  }

  /**
   * Error logging with classification and stack trace collection
   *
   * @param {string|Error} message - Error message or Error object
   * @param {Object|string} contextOrType - Context object or ErrorType
   * @param {string} errorType - Error type classification
   */
  error(message, contextOrType = {}, errorType = ErrorType.UNKNOWN) {
    let context = {};
    let type = errorType;

    if (typeof contextOrType === 'string') {
      type = contextOrType;
    } else if (typeof contextOrType === 'object') {
      context = contextOrType;
    }

    if (!Object.values(ErrorType).includes(type)) {
      type = ErrorType.UNKNOWN;
    }

    let errorMessage = message;
    let stack = null;

    if (message instanceof Error) {
      errorMessage = message.message;
      stack = message.stack;
      context.name = message.name;
    }

    if (!stack && this.isDevelopment) {
      try {
        throw new Error();
      } catch (e) {
        stack = e.stack;
      }
    }

    const errorEntry = {
      message: errorMessage,
      type: type,
      timestamp: new Date().toISOString(),
      context: context,
      stack: stack,
      url: window.location.href,
      userAgent: navigator.userAgent
    };

    this.addToHistory(errorEntry);

    const args = this.formatMessage(`ERROR [${type}]`, errorMessage, context);
    console.error(...args);

    if (stack && this.isDevelopment) {
      console.error('Stack trace:', stack);
    }

    if (this.errorTrackingService) {
      try {
        this.errorTrackingService(errorEntry);
      } catch (e) {
        console.error(`${this.prefix} Failed to send error to tracking service:`, e);
      }
    }
  }

  /**
   * Add error to history with size limit
   *
   * @param {Object} errorEntry - Error entry object
   */
  addToHistory(errorEntry) {
    this.errorHistory.push(errorEntry);

    if (this.errorHistory.length > this.maxHistorySize) {
      this.errorHistory.shift();
    }
  }

  /**
   * Get error history
   * @returns {Array<Object>} Error history
   */
  getErrorHistory() {
    return [...this.errorHistory];
  }

  /**
   * Clear error history
   */
  clearHistory() {
    this.errorHistory = [];
  }

  /**
   * Configure external error tracking service
   *
   * @param {Function} trackingFn - Function to call with error entries
   */
  setErrorTracking(trackingFn) {
    if (typeof trackingFn === 'function') {
      this.errorTrackingService = trackingFn;
    } else {
      this.warn('setErrorTracking expects a function');
    }
  }

  /**
   * Table logging (development only)
   *
   * @param {*} data - Data to display
   * @param {Array} columns - Columns to show
   */
  table(data, columns) {
    if (!this.isDevelopment) return;
    console.log(`${this.prefix} [TABLE]`);
    console.table(data, columns);
  }

  /**
   * Group logging (development only)
   *
   * @param {string} label - Group label
   */
  group(label) {
    if (!this.isDevelopment) return;
    console.group(`${this.prefix} ${label}`);
  }

  /**
   * Collapsed group logging (development only)
   *
   * @param {string} label - Group label
   */
  groupCollapsed(label) {
    if (!this.isDevelopment) return;
    console.groupCollapsed(`${this.prefix} ${label}`);
  }

  /**
   * End console group (development only)
   */
  groupEnd() {
    if (!this.isDevelopment) return;
    console.groupEnd();
  }

  /**
   * Time logging (development only)
   *
   * @param {string} label - Timer label
   */
  time(label) {
    if (!this.isDevelopment) return;
    console.time(`${this.prefix} ${label}`);
  }

  /**
   * End time logging (development only)
   *
   * @param {string} label - Timer label
   */
  timeEnd(label) {
    if (!this.isDevelopment) return;
    console.timeEnd(`${this.prefix} ${label}`);
  }

  /**
   * Trace logging (development only)
   *
   * @param {string} message - Message to trace
   */
  trace(message) {
    if (!this.isDevelopment) return;
    console.trace(`${this.prefix} ${message}`);
  }

  /**
   * Performance mark (development only)
   *
   * @param {string} name - Mark name
   */
  mark(name) {
    if (!this.isDevelopment) return;
    if (window.performance && window.performance.mark) {
      performance.mark(`${this.prefix}_${name}`);
    }
  }

  /**
   * Performance measure (development only)
   *
   * @param {string} name - Measure name
   * @param {string} startMark - Start mark name
   * @param {string} endMark - End mark name
   */
  measure(name, startMark, endMark) {
    if (!this.isDevelopment) return;
    if (window.performance && window.performance.measure) {
      try {
        performance.measure(
          `${this.prefix}_${name}`,
          `${this.prefix}_${startMark}`,
          `${this.prefix}_${endMark}`
        );
        const measure = performance.getEntriesByName(`${this.prefix}_${name}`)[0];
        this.log(`Performance: ${name} took ${measure.duration.toFixed(2)}ms`);
      } catch (e) {
        this.warn('Performance measurement failed', { name, error: e.message });
      }
    }
  }

  /**
   * Assert logging (development only)
   *
   * @param {boolean} condition - Condition to assert
   * @param {string} message - Assertion message
   */
  assert(condition, message) {
    if (!this.isDevelopment) return;
    console.assert(condition, `${this.prefix} ${message}`);
  }

  /**
   * Get current environment
   *
   * @returns {string} 'development' or 'production'
   */
  getEnvironment() {
    return this.isDevelopment ? 'development' : 'production';
  }

  /**
   * Force enable/disable development mode
   *
   * @param {boolean} isDev - Development mode flag
   */
  setDevelopment(isDev) {
    this.isDevelopment = isDev;
  }
}

const logger = new Logger();

export default logger;
export { logger, Logger, ErrorType };

if (typeof window !== 'undefined') {
  window.logger = logger;
  window.ErrorType = ErrorType;
}
