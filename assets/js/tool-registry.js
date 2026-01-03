/**
 * Tool Registry
 *
 * ES6 Map-based registry for tool management with lifecycle hooks.
 * Backward compatible with legacy IIFE tools.
 */

(function (window) {
  'use strict';

  if (window.Tools) {
    console.warn('[ToolRegistry] Already initialized');
    return;
  }

  /**
   * Private symbols for internal state
   */
  const REGISTRY = Symbol('registry');
  const METADATA = Symbol('metadata');
  const LIFECYCLE = Symbol('lifecycle');

  /**
   * WeakMap for private metadata (auto garbage collected)
   */
  const privateMetadata = new WeakMap();

  /**
   * Tool Registry Class
   */
  class ToolRegistry {
    constructor() {
      this[REGISTRY] = new Map();

      this[LIFECYCLE] = {
        beforeInit: [],
        afterInit: [],
        beforeOpen: [],
        afterOpen: []
      };
    }

    /**
     * Register a tool
     *
     * @param {string} name - Tool identifier
     * @param {Object} obj - Tool object with init() and open() methods
     * @param {Object} metadata - Optional metadata (version, author, etc.)
     */
    register(name, obj, metadata = {}) {
      if (this[REGISTRY].has(name)) {
        console.warn(`[ToolRegistry] Tool "${name}" is already registered. Skipping duplicate registration.`);
        return;
      }

      this[REGISTRY].set(name, obj);

      // Store metadata in WeakMap
      privateMetadata.set(obj, {
        name,
        registeredAt: Date.now(),
        initialized: false,
        ...metadata
      });

      // Run beforeInit hooks
      this[LIFECYCLE].beforeInit.forEach(hook => {
        try {
          hook(name, obj);
        } catch (e) {
          console.error('[ToolRegistry] beforeInit hook error:', e);
        }
      });

      // Auto-initialize if init() exists
      if (obj.init && typeof obj.init === 'function') {
        try {
          obj.init();
          const meta = privateMetadata.get(obj);
          if (meta) meta.initialized = true;

          // Run afterInit hooks
          this[LIFECYCLE].afterInit.forEach(hook => {
            try {
              hook(name, obj);
            } catch (e) {
              console.error('[ToolRegistry] afterInit hook error:', e);
            }
          });
        } catch (e) {
          console.error('[ToolRegistry] Init error for tool:', name, e);
        }
      }
    }

    /**
     * Open a tool in container
     *
     * @param {string} name - Tool identifier
     * @param {HTMLElement} container - Target container (defaults to #tool-container or main)
     */
    open(name, container) {
      const tool = this[REGISTRY].get(name);

      if (!container) {
        container = document.querySelector('#tool-container') || document.querySelector('main');
      }

      window.currentToolName = name;

      if (!tool) {
        container.innerHTML =
          '<div class="alert alert-warning mt-4">' +
          '<i class="bi bi-exclamation-triangle me-2"></i>' +
          'Tool "' + name + '" not found.' +
          '</div>';
        console.error('[ToolRegistry] Tool not found:', name);
        return;
      }

      // Run beforeOpen hooks
      this[LIFECYCLE].beforeOpen.forEach(hook => {
        try {
          hook(name, tool, container);
        } catch (e) {
          console.error('[ToolRegistry] beforeOpen hook error:', e);
        }
      });

      try {
        container.innerHTML = '';
        if (typeof tool.open === 'function') {
          tool.open(container);

          // Run afterOpen hooks
          this[LIFECYCLE].afterOpen.forEach(hook => {
            try {
              hook(name, tool, container);
            } catch (e) {
              console.error('[ToolRegistry] afterOpen hook error:', e);
            }
          });
        } else {
          throw new Error('Tool does not have an open() method');
        }
      } catch (e) {
        container.innerHTML =
          '<div class="alert alert-danger mt-4">' +
          '<i class="bi bi-x-circle me-2"></i>' +
          'Error loading tool "' + name + '".' +
          '</div>';
        console.error('[ToolRegistry] Error opening tool:', name, e);
      }
    }

    /**
     * Get registered tool
     *
     * @param {string} name - Tool identifier
     * @returns {Object|null} Tool object or null if not found
     */
    get(name) {
      return this[REGISTRY].get(name) || null;
    }

    /**
     * Get all registered tool names
     *
     * @returns {string[]} Array of tool names
     */
    getAll() {
      return Array.from(this[REGISTRY].keys());
    }

    /**
     * Check if tool is registered
     *
     * @param {string} name - Tool identifier
     * @returns {boolean} True if tool exists in registry
     */
    has(name) {
      return this[REGISTRY].has(name);
    }

    /**
     * Unregister a tool
     *
     * @param {string} name - Tool identifier
     * @returns {boolean} True if tool was successfully removed
     */
    unregister(name) {
      const tool = this[REGISTRY].get(name);
      if (!tool) return false;

      return this[REGISTRY].delete(name);
    }

    /**
     * Get tool metadata
     *
     * @param {string} name - Tool identifier
     * @returns {Object|null} Metadata object or null if not found
     */
    getMetadata(name) {
      const tool = this[REGISTRY].get(name);
      if (!tool) return null;

      return privateMetadata.get(tool) || null;
    }

    /**
     * Get registry size
     *
     * @returns {number} Number of registered tools
     */
    get size() {
      return this[REGISTRY].size;
    }

    /**
     * Clear all registered tools
     */
    clear() {
      this[REGISTRY].clear();
    }

    /**
     * Register lifecycle hook
     *
     * @param {string} event - Hook name (beforeInit, afterInit, beforeOpen, afterOpen)
     * @param {Function} callback - Callback function to execute
     */
    on(event, callback) {
      if (!this[LIFECYCLE][event]) {
        console.warn('[ToolRegistry] Unknown lifecycle event:', event);
        return;
      }

      if (typeof callback !== 'function') {
        console.warn('[ToolRegistry] Callback must be a function');
        return;
      }

      this[LIFECYCLE][event].push(callback);
    }

    /**
     * Unregister lifecycle hook
     *
     * @param {string} event - Hook name
     * @param {Function} callback - Callback function to remove
     */
    off(event, callback) {
      if (!this[LIFECYCLE][event]) return;

      const index = this[LIFECYCLE][event].indexOf(callback);
      if (index > -1) {
        this[LIFECYCLE][event].splice(index, 1);
      }
    }

    /**
     * Get all tools as entries (for debugging)
     *
     * @returns {Array} Array of [name, tool] tuples
     */
    entries() {
      return Array.from(this[REGISTRY].entries());
    }

    /**
     * Iterate over all tools
     *
     * @param {Function} callback - Callback function (tool, name, registry)
     */
    forEach(callback) {
      this[REGISTRY].forEach((tool, name) => {
        callback(tool, name, this);
      });
    }
  }

  /**
   * Create singleton instance
   */
  const registry = new ToolRegistry();

  /**
   * Expose as window.Tools
   * Backward compatible with legacy IIFE tools
   */
  window.Tools = {
    register: (name, obj, metadata) => registry.register(name, obj, metadata),
    open: (name, container) => registry.open(name, container),
    get: (name) => registry.get(name),
    getAll: () => registry.getAll(),
    has: (name) => registry.has(name),

    unregister: (name) => registry.unregister(name),
    getMetadata: (name) => registry.getMetadata(name),
    clear: () => registry.clear(),
    on: (event, callback) => registry.on(event, callback),
    off: (event, callback) => registry.off(event, callback),
    entries: () => registry.entries(),
    forEach: (callback) => registry.forEach(callback),

    get size() {
      return registry.size;
    },

    [Symbol.for('registry')]: registry
  };

  console.log('[ToolRegistry] Initialized (ES6 Map-based)');

})(window);
