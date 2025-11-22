/**
 * Performance Monitoring
 *
 * Navigation Timing API and Web Vitals tracking for performance insights.
 * Measures FCP, LCP, TTI, FID, CLS and provides detailed analytics.
 */

/**
 * Performance thresholds based on Web Vitals
 * @see https://web.dev/vitals/
 */
const THRESHOLDS = {
  // First Contentful Paint (FCP)
  FCP: {
    GOOD: 1800,      // < 1.8s
    NEEDS_IMPROVEMENT: 3000  // < 3.0s
  },
  // Largest Contentful Paint (LCP)
  LCP: {
    GOOD: 2500,      // < 2.5s
    NEEDS_IMPROVEMENT: 4000  // < 4.0s
  },
  // Time to Interactive (TTI)
  TTI: {
    GOOD: 3800,      // < 3.8s
    NEEDS_IMPROVEMENT: 7300  // < 7.3s
  },
  // First Input Delay (FID)
  FID: {
    GOOD: 100,       // < 100ms
    NEEDS_IMPROVEMENT: 300   // < 300ms
  },
  // Cumulative Layout Shift (CLS)
  CLS: {
    GOOD: 0.1,       // < 0.1
    NEEDS_IMPROVEMENT: 0.25  // < 0.25
  }
};

/**
 * Rating levels
 */
const Rating = {
  GOOD: 'good',
  NEEDS_IMPROVEMENT: 'needs-improvement',
  POOR: 'poor'
};

/**
 * Get rating based on value and thresholds
 * @param {number} value - The measured value
 * @param {object} threshold - Threshold object with GOOD and NEEDS_IMPROVEMENT
 * @returns {string} - Rating ('good', 'needs-improvement', 'poor')
 */
function getRating(value, threshold) {
  if (value <= threshold.GOOD) return Rating.GOOD;
  if (value <= threshold.NEEDS_IMPROVEMENT) return Rating.NEEDS_IMPROVEMENT;
  return Rating.POOR;
}

/**
 * Performance metrics storage
 */
class PerformanceMetrics {
  constructor() {
    this.metrics = {};
    this.observers = [];
    this.callbacks = [];
  }

  /**
   * Record a metric
   * @param {string} name - Metric name
   * @param {number} value - Metric value
   * @param {string} rating - Rating (good/needs-improvement/poor)
   */
  record(name, value, rating) {
    this.metrics[name] = {
      value,
      rating,
      timestamp: Date.now()
    };

    // Notify callbacks
    this.callbacks.forEach(callback => {
      try {
        callback(name, value, rating);
      } catch (error) {
        console.error('Performance callback error:', error);
      }
    });
  }

  /**
   * Get all recorded metrics
   * @returns {object} - All metrics
   */
  getAll() {
    return { ...this.metrics };
  }

  /**
   * Get a specific metric
   * @param {string} name - Metric name
   * @returns {object|null} - Metric data or null
   */
  get(name) {
    return this.metrics[name] || null;
  }

  /**
   * Register a callback for metric updates
   * @param {Function} callback - Callback(name, value, rating)
   */
  onMetric(callback) {
    if (typeof callback === 'function') {
      this.callbacks.push(callback);
    }
  }

  /**
   * Disconnect all observers
   */
  disconnect() {
    this.observers.forEach(observer => observer.disconnect());
    this.observers = [];
  }
}

// Singleton instance
const metrics = new PerformanceMetrics();

/**
 * Measure First Contentful Paint (FCP)
 * Uses Performance Observer API
 */
function measureFCP() {
  if (!('PerformanceObserver' in window)) return;

  try {
    const observer = new PerformanceObserver((list) => {
      for (const entry of list.getEntries()) {
        if (entry.name === 'first-contentful-paint') {
          const value = Math.round(entry.startTime);
          const rating = getRating(value, THRESHOLDS.FCP);
          metrics.record('FCP', value, rating);
          observer.disconnect();
        }
      }
    });

    observer.observe({ type: 'paint', buffered: true });
    metrics.observers.push(observer);
  } catch (error) {
    console.warn('FCP measurement failed:', error);
  }
}

/**
 * Measure Largest Contentful Paint (LCP)
 * Uses Performance Observer API
 */
function measureLCP() {
  if (!('PerformanceObserver' in window)) return;

  try {
    const observer = new PerformanceObserver((list) => {
      const entries = list.getEntries();
      const lastEntry = entries[entries.length - 1];
      const value = Math.round(lastEntry.renderTime || lastEntry.loadTime);
      const rating = getRating(value, THRESHOLDS.LCP);
      metrics.record('LCP', value, rating);
    });

    observer.observe({ type: 'largest-contentful-paint', buffered: true });
    metrics.observers.push(observer);
  } catch (error) {
    console.warn('LCP measurement failed:', error);
  }
}

/**
 * Measure Time to Interactive (TTI)
 * Approximation using Navigation Timing API
 */
function measureTTI() {
  if (!('performance' in window) || !performance.timing) return;

  // Wait for load event
  window.addEventListener('load', () => {
    setTimeout(() => {
      const timing = performance.timing;
      const tti = timing.domInteractive - timing.navigationStart;
      const rating = getRating(tti, THRESHOLDS.TTI);
      metrics.record('TTI', tti, rating);
    }, 0);
  }, { once: true });
}

/**
 * Measure First Input Delay (FID)
 * Uses Performance Observer API
 */
function measureFID() {
  if (!('PerformanceObserver' in window)) return;

  try {
    const observer = new PerformanceObserver((list) => {
      for (const entry of list.getEntries()) {
        const value = Math.round(entry.processingStart - entry.startTime);
        const rating = getRating(value, THRESHOLDS.FID);
        metrics.record('FID', value, rating);
        observer.disconnect();
      }
    });

    observer.observe({ type: 'first-input', buffered: true });
    metrics.observers.push(observer);
  } catch (error) {
    console.warn('FID measurement failed:', error);
  }
}

/**
 * Measure Cumulative Layout Shift (CLS)
 * Uses Performance Observer API
 */
function measureCLS() {
  if (!('PerformanceObserver' in window)) return;

  // Check if layout-shift is supported
  if (!PerformanceObserver.supportedEntryTypes.includes('layout-shift')) {
    return; // Skip silently if not supported (e.g., Firefox)
  }

  let clsValue = 0;

  try {
    const observer = new PerformanceObserver((list) => {
      for (const entry of list.getEntries()) {
        if (!entry.hadRecentInput) {
          clsValue += entry.value;
          const rating = getRating(clsValue, THRESHOLDS.CLS);
          metrics.record('CLS', parseFloat(clsValue.toFixed(3)), rating);
        }
      }
    });

    observer.observe({ type: 'layout-shift', buffered: true });
    metrics.observers.push(observer);
  } catch (error) {
    console.warn('CLS measurement failed:', error);
  }
}

/**
 * Measure Navigation Timing metrics
 * Uses Navigation Timing API
 */
function measureNavigationTiming() {
  if (!('performance' in window) || !performance.timing) return;

  window.addEventListener('load', () => {
    setTimeout(() => {
      const timing = performance.timing;

      // DNS lookup time
      const dnsTime = timing.domainLookupEnd - timing.domainLookupStart;
      metrics.record('DNS', dnsTime, dnsTime < 100 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);

      // TCP connection time
      const tcpTime = timing.connectEnd - timing.connectStart;
      metrics.record('TCP', tcpTime, tcpTime < 100 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);

      // Request time
      const requestTime = timing.responseStart - timing.requestStart;
      metrics.record('Request', requestTime, requestTime < 200 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);

      // Response time
      const responseTime = timing.responseEnd - timing.responseStart;
      metrics.record('Response', responseTime, responseTime < 300 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);

      // DOM processing time
      const domProcessing = timing.domComplete - timing.domLoading;
      metrics.record('DOMProcessing', domProcessing, domProcessing < 1000 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);

      // Total page load time
      const totalLoadTime = timing.loadEventEnd - timing.navigationStart;
      metrics.record('TotalLoad', totalLoadTime, totalLoadTime < 3000 ? Rating.GOOD : Rating.NEEDS_IMPROVEMENT);
    }, 0);
  }, { once: true });
}

/**
 * Measure Resource Timing
 * Detects slow-loading resources
 */
function measureResourceTiming() {
  if (!('performance' in window)) return;

  window.addEventListener('load', () => {
    setTimeout(() => {
      const resources = performance.getEntriesByType('resource');
      const slowResources = resources.filter(r => r.duration > 1000);

      if (slowResources.length > 0) {
        metrics.record('SlowResourcesCount', slowResources.length, Rating.NEEDS_IMPROVEMENT);
        console.warn('Slow resources detected:', slowResources.map(r => ({
          name: r.name,
          duration: Math.round(r.duration),
          type: r.initiatorType
        })));
      }
    }, 0);
  }, { once: true });
}

/**
 * Initialize performance monitoring
 * Automatically measures all available metrics
 *
 * @param {object} options - Configuration options
 * @param {boolean} options.logToConsole - Log metrics to console (default: false)
 * @param {Function} options.onMetric - Callback for each metric (name, value, rating)
 * @param {boolean} options.trackResources - Track slow resources (default: true)
 * @returns {object} - PerformanceMetrics instance
 */
export function initPerformanceMonitoring(options = {}) {
  const {
    logToConsole = false,
    onMetric = null,
    trackResources = true
  } = options;

  // Register callback if provided
  if (onMetric) {
    metrics.onMetric(onMetric);
  }

  // Optional console logging
  if (logToConsole) {
    metrics.onMetric((name, value, rating) => {
      const emoji = rating === Rating.GOOD ? '✅' : rating === Rating.NEEDS_IMPROVEMENT ? '⚠️' : '❌';
      console.log(`${emoji} ${name}: ${value}ms (${rating})`);
    });
  }

  // Start measurements
  measureFCP();
  measureLCP();
  measureTTI();
  measureFID();
  measureCLS();
  measureNavigationTiming();

  if (trackResources) {
    measureResourceTiming();
  }

  return metrics;
}

/**
 * Get all performance metrics
 * @returns {object} - All recorded metrics
 */
export function getMetrics() {
  return metrics.getAll();
}

/**
 * Get a specific metric
 * @param {string} name - Metric name (FCP, LCP, TTI, FID, CLS, etc.)
 * @returns {object|null} - Metric data or null
 */
export function getMetric(name) {
  return metrics.get(name);
}

/**
 * Register a callback for metric updates
 * @param {Function} callback - Callback(name, value, rating)
 */
export function onMetric(callback) {
  metrics.onMetric(callback);
}

/**
 * Stop all performance monitoring
 */
export function stopMonitoring() {
  metrics.disconnect();
}

/**
 * Send performance metrics to analytics endpoint
 * @param {string} endpoint - Analytics endpoint URL
 * @param {object} additionalData - Additional data to send
 */
export async function sendMetrics(endpoint, additionalData = {}) {
  const metricsData = {
    ...metrics.getAll(),
    ...additionalData,
    userAgent: navigator.userAgent,
    url: window.location.href,
    timestamp: Date.now()
  };

  try {
    await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(metricsData)
    });
  } catch (error) {
    console.error('Failed to send metrics:', error);
  }
}

// Export thresholds and rating constants
export { THRESHOLDS, Rating };

// Also expose to window for non-module usage (e.g., tests)
if (typeof window !== 'undefined') {
  window.PerformanceMonitoring = {
    initPerformanceMonitoring,
    getMetrics,
    getMetric,
    onMetric,
    stopMonitoring,
    sendMetrics,
    THRESHOLDS,
    Rating
  };
}
