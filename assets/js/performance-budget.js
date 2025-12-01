/**
 * Performance Budget Monitoring for WebDev-Tools
 * 
 * Tracks Core Web Vitals and alerts when budgets are exceeded:
 * - FCP (First Contentful Paint): < 1800ms
 * - LCP (Largest Contentful Paint): < 2500ms
 * - FID (First Input Delay): < 100ms
 * - CLS (Cumulative Layout Shift): < 0.1
 * - TTI (Time to Interactive): < 3800ms
 * 
 * Based on Google's Web Vitals recommendations.
 */

class PerformanceBudget {
  constructor(options = {}) {
    this.budgets = {
      FCP: options.FCP || 1800,  // First Contentful Paint (ms)
      LCP: options.LCP || 2500,  // Largest Contentful Paint (ms)
      FID: options.FID || 100,   // First Input Delay (ms)
      CLS: options.CLS || 0.1,   // Cumulative Layout Shift (score)
      TTI: options.TTI || 3800,  // Time to Interactive (ms)
      TTFB: options.TTFB || 600  // Time to First Byte (ms)
    };

    this.onViolation = options.onViolation || this.defaultViolationHandler;
    this.enableConsoleWarnings = options.enableConsoleWarnings ?? true;
    this.metrics = {};

    this.init();
  }

  init() {
    // Use Performance Observer API for modern browsers
    if ('PerformanceObserver' in window) {
      this.observePaintMetrics();
      this.observeLargestContentfulPaint();
      this.observeFirstInputDelay();
      this.observeLayoutShift();
    }

    // Fallback to Navigation Timing API
    if (window.performance && window.performance.timing) {
      this.measureNavigationTiming();
    }

    // Report on page load
    window.addEventListener('load', () => {
      setTimeout(() => this.reportMetrics(), 1000);
    });
  }

  /**
   * Observe paint metrics (FCP, FP)
   */
  observePaintMetrics() {
    try {
      const observer = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
          if (entry.name === 'first-contentful-paint') {
            this.recordMetric('FCP', entry.startTime);
          }
        }
      });
      observer.observe({ entryTypes: ['paint'] });
    } catch (e) {
      console.debug('Paint metrics not supported:', e);
    }
  }

  /**
   * Observe Largest Contentful Paint
   */
  observeLargestContentfulPaint() {
    try {
      const observer = new PerformanceObserver((list) => {
        const entries = list.getEntries();
        const lastEntry = entries[entries.length - 1];
        this.recordMetric('LCP', lastEntry.renderTime || lastEntry.loadTime);
      });
      observer.observe({ entryTypes: ['largest-contentful-paint'] });
    } catch (e) {
      console.debug('LCP not supported:', e);
    }
  }

  /**
   * Observe First Input Delay
   */
  observeFirstInputDelay() {
    try {
      const observer = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
          this.recordMetric('FID', entry.processingStart - entry.startTime);
        }
      });
      observer.observe({ entryTypes: ['first-input'] });
    } catch (e) {
      console.debug('FID not supported:', e);
    }
  }

  /**
   * Observe Cumulative Layout Shift
   */
  observeLayoutShift() {
    try {
      let clsValue = 0;
      const observer = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
          if (!entry.hadRecentInput) {
            clsValue += entry.value;
            this.recordMetric('CLS', clsValue);
          }
        }
      });
      observer.observe({ entryTypes: ['layout-shift'] });
    } catch (e) {
      console.debug('CLS not supported:', e);
    }
  }

  /**
   * Measure using Navigation Timing API (fallback)
   */
  measureNavigationTiming() {
    window.addEventListener('load', () => {
      const timing = performance.timing;
      const navigationStart = timing.navigationStart;

      // TTFB
      const ttfb = timing.responseStart - navigationStart;
      this.recordMetric('TTFB', ttfb);

      // DOM Content Loaded
      const domContentLoaded = timing.domContentLoadedEventEnd - navigationStart;
      
      // Load Complete
      const loadComplete = timing.loadEventEnd - navigationStart;

      // Estimate TTI (simplified - not accurate)
      this.recordMetric('TTI', loadComplete);
    });
  }

  /**
   * Record a performance metric and check against budget
   */
  recordMetric(metric, value) {
    this.metrics[metric] = value;

    const budget = this.budgets[metric];
    if (budget && value > budget) {
      this.onViolation({
        metric,
        value,
        budget,
        overage: value - budget,
        timestamp: Date.now()
      });
    }

    if (this.enableConsoleWarnings && budget && value > budget) {
      console.warn(
        `⚠️ Performance Budget Exceeded: ${metric}\n` +
        `  Actual: ${value.toFixed(2)} ${metric === 'CLS' ? '' : 'ms'}\n` +
        `  Budget: ${budget} ${metric === 'CLS' ? '' : 'ms'}\n` +
        `  Overage: ${(value - budget).toFixed(2)} ${metric === 'CLS' ? '' : 'ms'}`
      );
    } else {
      console.log(
        `✓ ${metric}: ${value.toFixed(2)} ${metric === 'CLS' ? '' : 'ms'} ` +
        `(within budget: ${budget} ${metric === 'CLS' ? '' : 'ms'})`
      );
    }
  }

  /**
   * Default violation handler
   */
  defaultViolationHandler(violation) {
    // Could send to analytics, error tracking, etc.
    console.warn('Performance violation:', violation);
  }

  /**
   * Get current metrics
   */
  getMetrics() {
    return { ...this.metrics };
  }

  /**
   * Report all collected metrics
   */
  reportMetrics() {
    console.group('📊 Performance Budget Report');
    console.log('Current metrics:', this.metrics);
    
    const violations = Object.entries(this.metrics).filter(([metric, value]) => {
      const budget = this.budgets[metric];
      return budget && value > budget;
    });

    if (violations.length === 0) {
      console.log('%c✅ All metrics within budget!', 'color: #3fb950; font-weight: bold;');
    } else {
      console.warn(`❌ ${violations.length} budget violation(s):`, violations);
    }
    
    console.groupEnd();
  }

  /**
   * Get Web Vitals rating
   */
  static getVitalsRating(metric, value) {
    const thresholds = {
      FCP: { good: 1800, needsImprovement: 3000 },
      LCP: { good: 2500, needsImprovement: 4000 },
      FID: { good: 100, needsImprovement: 300 },
      CLS: { good: 0.1, needsImprovement: 0.25 },
      TTFB: { good: 600, needsImprovement: 1500 }
    };

    const threshold = thresholds[metric];
    if (!threshold) return 'unknown';

    if (value <= threshold.good) return 'good';
    if (value <= threshold.needsImprovement) return 'needs-improvement';
    return 'poor';
  }
}

// Auto-initialize if not in production (can be disabled via data attribute)
if (!document.documentElement.hasAttribute('data-disable-perf-monitoring')) {
  const perfMonitor = new PerformanceBudget({
    onViolation: (violation) => {
      // Log to console in development
      if (window.location.hostname === 'localhost' || 
          window.location.hostname.includes('dev')) {
        console.warn('Performance violation detected:', violation);
      }

      // Could send to analytics
      if (typeof gtag !== 'undefined') {
        gtag('event', 'performance_violation', {
          event_category: 'Performance',
          event_label: violation.metric,
          value: Math.round(violation.value)
        });
      }
    }
  });

  // Expose globally for debugging
  window.__perfMonitor = perfMonitor;
}

export default PerformanceBudget;
