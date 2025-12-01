/**
 * Centralized Logger for WebDev-Tools
 * 
 * Provides consistent logging interface across all tools with:
 * - Log levels (debug, info, warn, error)
 * - Tool-specific prefixes
 * - Production mode (suppress debug/info)
 * - Error tracking and reporting
 * 
 * @example
 * import Logger from './logger.js';
 * const log = new Logger('Base64Tool');
 * log.info('Encoding started');
 * log.error('Invalid input', error);
 */

class Logger {
  /**
   * @param {string} toolName - Name of the tool using this logger
   * @param {Object} options - Configuration options
   * @param {boolean} options.enableDebug - Enable debug logs (default: false in production)
   * @param {boolean} options.enableInfo - Enable info logs (default: true)
   * @param {Function} options.errorReporter - Optional error reporting callback
   */
  constructor(toolName, options = {}) {
    this.toolName = toolName;
    this.enableDebug = options.enableDebug ?? (process.env.NODE_ENV !== 'production');
    this.enableInfo = options.enableInfo ?? true;
    this.errorReporter = options.errorReporter || null;
    
    // Color codes for console output
    this.colors = {
      debug: '#6e7681',
      info: '#58a6ff',
      warn: '#d29922',
      error: '#f85149',
      success: '#3fb950'
    };
  }

  /**
   * Format log message with timestamp and tool name
   * @private
   */
  _formatMessage(level, message) {
    const timestamp = new Date().toISOString().slice(11, 23); // HH:MM:SS.mmm
    return `[${timestamp}] [${this.toolName}] ${level.toUpperCase()}: ${message}`;
  }

  /**
   * Log debug message (development only)
   * @param {string} message - Debug message
   * @param {*} data - Optional data to log
   */
  debug(message, data = null) {
    if (!this.enableDebug) return;
    
    console.log(
      `%c${this._formatMessage('debug', message)}`,
      `color: ${this.colors.debug}`
    );
    if (data) console.log(data);
  }

  /**
   * Log informational message
   * @param {string} message - Info message
   * @param {*} data - Optional data to log
   */
  info(message, data = null) {
    if (!this.enableInfo) return;
    
    console.log(
      `%c${this._formatMessage('info', message)}`,
      `color: ${this.colors.info}`
    );
    if (data) console.log(data);
  }

  /**
   * Log success message
   * @param {string} message - Success message
   * @param {*} data - Optional data to log
   */
  success(message, data = null) {
    console.log(
      `%c${this._formatMessage('success', message)}`,
      `color: ${this.colors.success}; font-weight: bold`
    );
    if (data) console.log(data);
  }

  /**
   * Log warning message
   * @param {string} message - Warning message
   * @param {*} data - Optional data to log
   */
  warn(message, data = null) {
    console.warn(
      `%c${this._formatMessage('warn', message)}`,
      `color: ${this.colors.warn}; font-weight: bold`
    );
    if (data) console.warn(data);
  }

  /**
   * Log error message and optionally report to error tracking service
   * @param {string} message - Error message
   * @param {Error|*} error - Error object or additional data
   */
  error(message, error = null) {
    const formattedMessage = this._formatMessage('error', message);
    
    console.error(
      `%c${formattedMessage}`,
      `color: ${this.colors.error}; font-weight: bold`
    );
    
    if (error) {
      if (error instanceof Error) {
        console.error('Stack trace:', error.stack);
      } else {
        console.error('Error details:', error);
      }
    }

    // Report to external error tracking if configured
    if (this.errorReporter) {
      try {
        this.errorReporter({
          tool: this.toolName,
          message,
          error,
          timestamp: new Date().toISOString(),
          userAgent: navigator.userAgent
        });
      } catch (reportError) {
        console.error('Failed to report error:', reportError);
      }
    }
  }

  /**
   * Log performance metric
   * @param {string} operation - Operation name
   * @param {number} duration - Duration in milliseconds
   */
  performance(operation, duration) {
    const color = duration < 100 ? this.colors.success :
                  duration < 500 ? this.colors.warn :
                  this.colors.error;
    
    console.log(
      `%c[PERF] [${this.toolName}] ${operation}: ${duration.toFixed(2)}ms`,
      `color: ${color}`
    );
  }

  /**
   * Time a synchronous or async operation
   * @param {string} label - Operation label
   * @param {Function} fn - Function to time
   * @returns {Promise<*>|*} Result of the function
   */
  async time(label, fn) {
    const start = performance.now();
    try {
      const result = await fn();
      const duration = performance.now() - start;
      this.performance(label, duration);
      return result;
    } catch (error) {
      const duration = performance.now() - start;
      this.error(`${label} failed after ${duration.toFixed(2)}ms`, error);
      throw error;
    }
  }

  /**
   * Create a scoped logger for a specific feature/module
   * @param {string} scope - Scope name (e.g., 'Encoder', 'Validator')
   * @returns {Logger} New logger instance with scoped name
   */
  scope(scope) {
    return new Logger(`${this.toolName}:${scope}`, {
      enableDebug: this.enableDebug,
      enableInfo: this.enableInfo,
      errorReporter: this.errorReporter
    });
  }
}

// Export singleton for global use
export default Logger;

// Convenience exports for common loggers
export const createLogger = (toolName, options) => new Logger(toolName, options);
