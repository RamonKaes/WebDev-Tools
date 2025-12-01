# Code-Splitting Strategy for Large Tools

## Overview
Two tools exceed 1000 LOC and would benefit from code-splitting:
- `dataConverterTool.js` - 1014 lines
- `hashGeneratorTool.js` - 1008 lines

## Benefits
- **Faster initial load**: Only load needed converter/algorithm
- **Better caching**: Individual modules can be cached separately
- **Easier maintenance**: Smaller, focused modules
- **On-demand loading**: Lazy load when specific converter selected

## Data Converter Tool - Split Strategy

### Current Structure (1014 LOC)
Single monolithic file with all converters:
- JSON ↔ XML/CSV/YAML
- XML ↔ JSON/CSV/YAML
- CSV ↔ JSON/XML/YAML
- YAML ↔ JSON/XML/CSV

### Proposed Structure

```
assets/js/tools/
├── dataConverterTool.js              # Main UI (300 LOC)
└── converters/
    ├── json-converter.js             # ~200 LOC
    ├── xml-converter.js              # ~200 LOC
    ├── csv-converter.js              # ~200 LOC
    └── yaml-converter.js             # ~200 LOC
```

### Implementation Pattern

**dataConverterTool.js** (main):
```javascript
class DataConverterTool {
  async loadConverter(type) {
    if (!this.converters[type]) {
      const module = await import(`./converters/${type}-converter.js`);
      this.converters[type] = new module.default();
    }
    return this.converters[type];
  }

  async convert(fromFormat, toFormat, input) {
    const converter = await this.loadConverter(fromFormat);
    return converter.convertTo(toFormat, input);
  }
}
```

**converters/json-converter.js**:
```javascript
export default class JSONConverter {
  convertToXML(json) { /* ... */ }
  convertToCSV(json) { /* ... */ }
  convertToYAML(json) { /* ... */ }
  
  convertTo(format, input) {
    const methods = {
      'xml': this.convertToXML,
      'csv': this.convertToCSV,
      'yaml': this.convertToYAML
    };
    return methods[format].call(this, input);
  }
}
```

## Hash Generator Tool - Split Strategy

### Current Structure (1008 LOC)
Single file with all hash algorithms:
- MD5, SHA-1, SHA-256, SHA-384, SHA-512
- HMAC variants
- CRC32
- Base64/Hex encoding

### Proposed Structure

```
assets/js/tools/
├── hashGeneratorTool.js              # Main UI (200 LOC)
└── hashers/
    ├── sha-family.js                 # SHA-256/384/512 (~200 LOC)
    ├── legacy-hashes.js              # MD5, SHA-1, CRC32 (~200 LOC)
    ├── hmac.js                       # HMAC variants (~150 LOC)
    └── encoders.js                   # Base64/Hex (~100 LOC)
```

### Implementation Pattern

**hashGeneratorTool.js** (main):
```javascript
class HashGeneratorTool {
  async loadHasher(algorithm) {
    const modules = {
      'sha256': () => import('./hashers/sha-family.js'),
      'sha384': () => import('./hashers/sha-family.js'),
      'sha512': () => import('./hashers/sha-family.js'),
      'md5': () => import('./hashers/legacy-hashes.js'),
      'sha1': () => import('./hashers/legacy-hashes.js'),
      'hmac': () => import('./hashers/hmac.js')
    };
    
    if (!this.hashers[algorithm]) {
      const module = await modules[algorithm]();
      this.hashers[algorithm] = module;
    }
    return this.hashers[algorithm];
  }

  async generateHash(algorithm, input) {
    const hasher = await this.loadHasher(algorithm);
    return hasher.hash(input, algorithm);
  }
}
```

## Migration Steps

### Phase 1: Extract Data Converter
1. Create `assets/js/tools/converters/` directory
2. Extract JSON converter logic → `json-converter.js`
3. Extract XML converter logic → `xml-converter.js`
4. Extract CSV converter logic → `csv-converter.js`
5. Extract YAML converter logic → `yaml-converter.js`
6. Update main tool to use dynamic imports
7. Test all conversion paths

### Phase 2: Extract Hash Generator
1. Create `assets/js/tools/hashers/` directory
2. Extract SHA family → `sha-family.js`
3. Extract legacy hashes → `legacy-hashes.js`
4. Extract HMAC → `hmac.js`
5. Extract encoders → `encoders.js`
6. Update main tool to use dynamic imports
7. Test all hash algorithms

### Phase 3: Performance Testing
1. Measure bundle sizes before/after
2. Test initial load time improvement
3. Verify lazy loading works correctly
4. Check network waterfall for optimal loading

## Expected Results

### Data Converter
- **Before**: 1014 LOC loaded upfront
- **After**: 
  - Initial: 300 LOC (main UI)
  - On-demand: ~200 LOC per converter
  - Savings: ~700 LOC on initial load (70%)

### Hash Generator
- **Before**: 1008 LOC loaded upfront
- **After**:
  - Initial: 200 LOC (main UI)
  - On-demand: ~150-200 LOC per algorithm family
  - Savings: ~800 LOC on initial load (80%)

## Considerations

1. **Browser Support**: Dynamic imports work in all modern browsers
2. **Fallback**: For older browsers, bundle can be pre-built
3. **Loading Indicators**: Show spinner while loading converter/hasher
4. **Error Handling**: Handle import failures gracefully
5. **Caching**: Modules cache automatically after first load

## Testing

```javascript
// Test lazy loading
import { test } from '@playwright/test';

test('should lazy load JSON converter', async ({ page }) => {
  await page.goto('/data-converter');
  
  // Initial load - converter not loaded yet
  const initialScripts = await page.evaluate(() => 
    performance.getEntriesByType('resource')
      .filter(r => r.name.includes('json-converter'))
  );
  expect(initialScripts.length).toBe(0);
  
  // Select JSON format
  await page.selectOption('#fromFormat', 'json');
  
  // Converter should now be loaded
  await page.waitForFunction(() => 
    performance.getEntriesByType('resource')
      .some(r => r.name.includes('json-converter'))
  );
});
```

## Implementation Priority

1. ✅ Create migration guide
2. [ ] Extract Data Converter (higher impact - more complex conversions)
3. [ ] Extract Hash Generator (easier - algorithms are more isolated)
4. [ ] Add loading indicators
5. [ ] Update documentation
6. [ ] Performance benchmarking

## Notes

- This is an **architectural improvement**, not a bug fix
- Can be implemented incrementally (one tool at a time)
- Backwards compatible - same API, different loading strategy
- Consider for future tools approaching 500+ LOC
