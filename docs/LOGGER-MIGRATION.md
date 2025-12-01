# Logger Migration Guide

## Overview
Replace direct `console.*` calls with the centralized Logger for consistent error handling.

## Migration Checklist

### Files to Update (20+ console.* calls found):

**High Priority:**
- [ ] `passwordGeneratorTool.js` (4 calls)
- [ ] `uuidGeneratorTool.js` (5 calls)
- [ ] `loremIpsumTool.js` (4 calls)
- [ ] `htmlEntityTool.js` (3 calls)
- [ ] `emojiReferenceTool.js` (3 calls)
- [ ] `base64EncoderDecoderTool.js` (1 call)
- [ ] `dataConverterTool.js` (1 call)

**Medium Priority:**
- [ ] All other tools in `assets/js/tools/`
- [ ] Core libraries in `assets/js/lib/`

## Migration Pattern

### Before:
```javascript
console.error('[ToolName] Error:', error);
console.warn('[ToolName] Warning message');
console.debug('[ToolName] Debug info');
```

### After:
```javascript
import Logger from '../lib/logger.js';
const log = new Logger('ToolName');

log.error('Error occurred', error);
log.warn('Warning message');
log.debug('Debug info');
```

## Benefits

1. **Consistent Formatting**: All logs follow same pattern
2. **Production Control**: Suppress debug/info logs in production
3. **Performance Tracking**: Built-in timing utilities
4. **Error Reporting**: Hook for external error tracking services
5. **Scoped Loggers**: Create sub-loggers for specific features

## Example Implementation

```javascript
// passwordGeneratorTool.js
import Logger from '../lib/logger.js';

const log = new Logger('PasswordGenerator');

// OLD: console.error('Failed to load wordlist:', error);
// NEW:
log.error('Failed to load wordlist', error);

// OLD: console.debug('Password Generator Tool initialized');
// NEW:
log.debug('Tool initialized');

// Performance tracking
const result = await log.time('Generate password', async () => {
  return generateSecurePassword(options);
});
```

## Advanced Usage

### Scoped Loggers
```javascript
const log = new Logger('DataConverter');
const xmlLog = log.scope('XML');
const jsonLog = log.scope('JSON');

xmlLog.error('Parse failed', error);
jsonLog.info('Validation successful');
```

### Custom Error Reporting
```javascript
const log = new Logger('ToolName', {
  errorReporter: (errorData) => {
    // Send to Sentry, LogRocket, etc.
    fetch('/api/log-error', {
      method: 'POST',
      body: JSON.stringify(errorData)
    });
  }
});
```

## Implementation Steps

1. ✅ Create `assets/js/lib/logger.js`
2. [ ] Update one tool as proof-of-concept (e.g., `passwordGeneratorTool.js`)
3. [ ] Test in browser to verify logging works
4. [ ] Update remaining tools in batches
5. [ ] Update documentation
6. [ ] Remove old console.* calls

## Testing

```javascript
// Test in browser console
import Logger from './assets/js/lib/logger.js';
const log = new Logger('TestTool');

log.debug('Debug message');
log.info('Info message');
log.success('Success!');
log.warn('Warning!');
log.error('Error!', new Error('Test error'));

// Performance test
await log.time('Test operation', async () => {
  await new Promise(resolve => setTimeout(resolve, 100));
  return 'done';
});
```

## Notes

- Logger uses ES6 modules - ensure proper import paths
- Process.env.NODE_ENV check assumes build step (fallback to always-on debug for now)
- Colors only work in modern browsers with console styling support
- Consider adding logger initialization in main app bootstrap
