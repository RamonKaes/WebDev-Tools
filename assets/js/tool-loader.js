/**
 * Tool Loader with Code-Splitting
 *
 * Dynamically imports tool modules on-demand using dynamic import().
 * Uses manifest.json as source of truth for tool configuration.
 */

(function() {
  'use strict';

  const BASE_PATH = window.APP_BASE_PATH || '';

  let TOOL_MANIFEST = null;

  const TOOL_MODULES_FALLBACK = {
    'base64EncoderDecoder': '/assets/js/tools/base64EncoderDecoderTool.js',
    'urlEncoderDecoder': '/assets/js/tools/urlEncoderDecoderTool.js',
    'htmlEntityTool': '/assets/js/tools/htmlEntityTool.js',
    'jwtDecoderTool': '/assets/js/tools/jwtDecoderTool.js',
    'punycodeConverterTool': '/assets/js/tools/punycodeConverterTool.js',
    'jsonFormatterValidator': '/assets/js/tools/jsonFormatterValidatorTool.js',
    'codeFormatterTool': '/assets/js/tools/codeFormatterTool.js',
    'pxToRemConverter': '/assets/js/tools/pxToRemConverterTool.js',
    'dataConverterTool': '/assets/js/tools/dataConverterTool.js',
    'uuidGeneratorTool': '/assets/js/tools/uuidGeneratorTool.js',
    'passwordGeneratorTool': '/assets/js/tools/passwordGeneratorTool.js',
    'hashGeneratorTool': '/assets/js/tools/hashGeneratorTool.js',
    'loremIpsumTool': '/assets/js/tools/loremIpsumTool.js',
    'qrCodeGeneratorTool': '/assets/js/tools/qrCodeGeneratorTool.js',
    'characterReferenceTool': '/assets/js/tools/characterReferenceTool.js',
    'emojiReferenceTool': '/assets/js/tools/emojiReferenceTool.js',
    'stringEscaperTool': '/assets/js/tools/stringEscaperTool.js',
    'regexTesterTool': '/assets/js/tools/regexTesterTool.js',
    'aspectRatioCalculator': '/assets/js/tools/aspectRatioCalculatorTool.js'
  };

  const FREQUENTLY_USED = [
    'base64EncoderDecoder',
    'jsonFormatterValidator',
    'urlEncoderDecoder'
  ];

  const moduleCache = new Map();

  /**
   * Load tool manifest with caching strategy
   *
   * Caching strategy:
   * - 24h cache duration with localStorage
   * - Background revalidation after 1h
   * - Fallback to network if cache invalid
   *
   * @returns {Promise<Object|null>} Manifest object or null on error
   */
  async function loadManifest() {
    if (TOOL_MANIFEST) return TOOL_MANIFEST;

    const CACHE_KEY = 'toolbox_manifest';
    const CACHE_DURATION = 24 * 60 * 60 * 1000;

    try {
      const cached = localStorage.getItem(CACHE_KEY);
      if (cached) {
        try {
          const { manifest, cachedAt } = JSON.parse(cached);
          const age = Date.now() - cachedAt;

          if (age < CACHE_DURATION) {
            TOOL_MANIFEST = manifest;
            console.debug(`[ToolLoader] Using cached manifest (age: ${Math.round(age / 1000 / 60)}min)`);

            // Background revalidation if older than 1h
            if (age > 60 * 60 * 1000) {
              revalidateManifest();
            }

            return TOOL_MANIFEST;
          }
        } catch (e) {
          console.warn('[ToolLoader] Invalid cached manifest:', e);
          localStorage.removeItem(CACHE_KEY);
        }
      }

      const response = await fetch(`${BASE_PATH}/config/manifest.json`);
      if (!response.ok) throw new Error('Manifest not found');
      TOOL_MANIFEST = await response.json();

      localStorage.setItem(CACHE_KEY, JSON.stringify({
        manifest: TOOL_MANIFEST,
        cachedAt: Date.now()
      }));

      console.debug('[ToolLoader] Manifest loaded and cached:', TOOL_MANIFEST.version);
      return TOOL_MANIFEST;
    } catch (error) {
      console.warn('[ToolLoader] Failed to load manifest, using fallback:', error);
      return null;
    }
  }

  /**
   * Background revalidation of manifest
   *
   * Non-blocking check for updated manifest.
   * Updates cache if new version available without interrupting user.
   */
  async function revalidateManifest() {
    try {
      const response = await fetch(`${BASE_PATH}/config/manifest.json`);
      if (!response.ok) return;

      const freshManifest = await response.json();
      const cached = JSON.parse(localStorage.getItem('toolbox_manifest') || '{}');

      if (freshManifest.generatedAt !== cached.manifest?.generatedAt) {
        localStorage.setItem('toolbox_manifest', JSON.stringify({
          manifest: freshManifest,
          cachedAt: Date.now()
        }));
        console.debug('[ToolLoader] Manifest revalidated (new version)');
      }
    } catch (error) {
      console.debug('[ToolLoader] Background revalidation failed:', error);
    }
  }

  /**
   * Get tool module path from manifest or fallback
   *
   * @param {string} toolId - Tool identifier
   * @returns {string|null} Full module path with version query string
   */
  function getToolModulePath(toolId) {
    let path = null;

    if (TOOL_MANIFEST && TOOL_MANIFEST.tools && TOOL_MANIFEST.tools[toolId]) {
      path = TOOL_MANIFEST.tools[toolId].jsPath;
    } else {
      path = TOOL_MODULES_FALLBACK[toolId] || null;
    }

    // Prepend BASE_PATH if path is relative
    if (path && !path.startsWith('http')) {
      path = BASE_PATH + path;
    }

    if (path && TOOL_MANIFEST && TOOL_MANIFEST.version) {
      const separator = path.includes('?') ? '&' : '?';
      path = `${path}${separator}v=${TOOL_MANIFEST.version}`;
    }

    return path;
  }

  /**
   * Dynamically import tool module
   *
   * @param {string} toolId - Tool identifier
   * @returns {Promise<void>}
   * @throws {Error} If tool is unknown or loading fails
   */
  async function loadToolModule(toolId) {
    if (moduleCache.has(toolId)) {
      console.log(`[ToolLoader] ${toolId} already loaded`);
      return;
    }

    const modulePath = getToolModulePath(toolId);
    if (!modulePath) {
      throw new Error(`Unknown tool: ${toolId}`);
    }

    try {
      console.log(`[ToolLoader] Loading ${toolId}...`);
      const startTime = performance.now();

      await loadScript(modulePath);

      const loadTime = Math.round(performance.now() - startTime);
      console.log(`[ToolLoader] ${toolId} loaded in ${loadTime}ms`);

      moduleCache.set(toolId, true);
    } catch (error) {
      console.error(`[ToolLoader] Failed to load ${toolId}:`, error);
      throw error;
    }
  }

  /**
   * Load script dynamically
   *
   * @param {string} src - Script source URL
   * @returns {Promise<void>}
   * @throws {Error} If script loading fails
   */
  function loadScript(src) {
    return new Promise((resolve, reject) => {
      let versionedSrc = src;
      if (TOOL_MANIFEST && TOOL_MANIFEST.version && !src.includes('?v=')) {
        const separator = src.includes('?') ? '&' : '?';
        versionedSrc = `${src}${separator}v=${TOOL_MANIFEST.version}`;
      }

      const existing = document.querySelector(`script[src="${versionedSrc}"]`);
      if (existing) {
        resolve();
        return;
      }

      const script = document.createElement('script');
      script.src = versionedSrc;
      script.async = true;
      script.onload = () => resolve();
      script.onerror = () => reject(new Error(`Failed to load script: ${versionedSrc}`));
      document.body.appendChild(script);
    });
  }

  /**
   * Preload tool module using <link rel="prefetch">
   * Improves perceived performance for next tool interaction
   *
   * @param {string} toolId - Tool identifier
   */
  function prefetchTool(toolId) {
    const modulePath = getToolModulePath(toolId);
    if (!modulePath || moduleCache.has(toolId)) {
      return;
    }

    const existingLink = document.querySelector(`link[href="${modulePath}"]`);
    if (existingLink) {
      return;
    }

    const link = document.createElement('link');
    link.rel = 'prefetch';
    link.href = modulePath;
    link.as = 'script';
    link.crossOrigin = 'anonymous';
    document.head.appendChild(link);

    console.log(`[ToolLoader] Prefetching ${toolId}`);
  }

  /**
   * Setup IntersectionObserver for preloading visible tools
   * Prefetches tools when they enter viewport
   */
  function setupPreloading() {
    if (!('IntersectionObserver' in window)) {
      console.warn('[ToolLoader] IntersectionObserver not supported');
      return;
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const toolLink = entry.target;
          const toolId = toolLink.dataset.toolId;

          if (toolId && getToolModulePath(toolId)) {
            prefetchTool(toolId);
            observer.unobserve(toolLink);
          }
        }
      });
    }, {
      rootMargin: '50px',
      threshold: 0.01
    });

    document.querySelectorAll('[data-tool-id]').forEach(link => {
      observer.observe(link);
    });
  }

  /**
   * Prefetch frequently used tools on page load
   * Guards against slow/metered connections
   */
  function prefetchFrequentTools() {
    if (navigator.connection) {
      const conn = navigator.connection;

      if (conn.saveData ||
          (conn.effectiveType && ['slow-2g', '2g', '3g'].includes(conn.effectiveType))) {
        console.log('[ToolLoader] Skipping prefetch (slow/metered connection)');
        return;
      }
    }

    setTimeout(() => {
      FREQUENTLY_USED.forEach(toolId => {
        if (!moduleCache.has(toolId)) {
          prefetchTool(toolId);
        }
      });
    }, 1000);
  }

  const container = document.querySelector('#tool-container');
  if (!container) return;

  const toolId = container.dataset.toolId;
  const lang = container.dataset.lang || 'en';

  if (!toolId) {
    console.warn('[ToolLoader] No tool ID specified');
    return;
  }

  document.addEventListener('DOMContentLoaded', async function() {
    try {
      // Load manifest first
      await loadManifest();

      // Wait for i18n to initialize
      if (window.i18n) {
        await window.i18n.init();
        await window.i18n.setLanguage(lang, false);
      }

      // Dynamically load the tool module
      await loadToolModule(toolId);

      // Load the tool from registry
      if (window.Tools && window.Tools.get) {
        const tool = window.Tools.get(toolId);
        if (tool && typeof tool.open === 'function') {
          tool.open(container);
          console.log(`[Tool] ${toolId} loaded successfully`);
        } else {
          console.error(`[Tool] ${toolId} not found or missing open() method`);
        }
      }

      // Setup preloading for other tools
      setupPreloading();
      prefetchFrequentTools();

    } catch (error) {
      console.error('[ToolLoader] Error:', error);
      container.innerHTML = `
        <div class="alert alert-danger mt-4">
          <i class="bi bi-x-circle me-2"></i>
          Error loading tool "${toolId}". Please try refreshing the page.
        </div>
      `;
    }
  });
})();
