# WebDev-Tools Test Suite

Simple vanilla JavaScript test framework with no external dependencies.

## Test Coverage

### ✅ Implemented Tests

#### Unit Tests (JavaScript)
- **validators.test.js** - 15 tests for email, URL, JSON, Base64, hex validation
- **clipboard-utils.test.js** - 5 tests for Clipboard API integration
- **formatters.test.js** - 15 tests for byte/number/date formatting
- **storage-utils.test.js** - 11 tests for localStorage/sessionStorage
- **logger.test.js** - 10 tests for error handling, classification, and stack traces

**Total: 56 tests** | **Coverage: ~40% of utility libraries**

#### Security & Dependency Tests
- **dependency-check.sh** - Automated security checks for:
  - CVE scans (OSV.dev API)
  - Version updates (GitHub Releases)
  - PHP EOL status

## Usage

### Run tests in the browser

1. Open `tests/index.html` in a browser
2. Click "Run Validators Tests" or another test button
3. View the test results in the browser console

### Run tests from the command line

#### JavaScript unit tests (Node.js)
```bash
# Run a single test file
node tests/lib/validators.test.js
```

#### Security & Dependency Check
```bash
# Run dependency security check
cd /var/www/html/WebDev-Tools
./tests/dependency-check.sh
```

**Recommended frequency:** Quarterly (before each release)

## Test Structure

```
tests/
├── test-runner.js          # Test framework core
├── index.html              # Browser test runner UI
├── dependency-check.sh     # Security & dependency scanner
├── lib/                    # Unit tests under lib/
│   ├── validators.test.js
│   ├── clipboard-utils.test.js
│   ├── formatters.test.js
│   ├── storage-utils.test.js
│   └── ...
└── README.md
```

## Create new tests

Create a new `.test.js` file:

```javascript
import { TestRunner, assert } from '../test-runner.js';
import { myFunction } from '../../assets/js/lib/my-module.js';

const runner = new TestRunner();

runner.test('Test Name', () => {
  const result = myFunction('input');
  assert.equal(result, 'expected');
});

// Run the tests
runner.run();
```

## Available assertions

- `assert.ok(value, message)` - Checks if value is truthy
- `assert.equal(actual, expected, message)` - Strict equality (===)
- `assert.deepEqual(actual, expected, message)` - Deep object comparison
- `assert.throws(fn, message)` - Expects function to throw
- `assert.isNull(value, message)` - Checks for null/undefined
- `assert.notNull(value, message)` - Checks that value is not null/undefined
- `assert.includes(array, value, message)` - Array contains value
- `assert.typeOf(value, type, message)` - Type check

## Skipping tests

```javascript
runner.skip('Test Name', () => {
  // This test will be skipped
});
```

## Best practices

1. **One test per function**: Test a specific functionality
2. **Descriptive names**: Describe what is being tested
3. **Arrange-Act-Assert**: Structure tests into setup, execution, verification
4. **Edge cases**: Test boundary cases (null, undefined, empty strings)
5. **Independence**: Tests should not depend on each other

## Example

```javascript
runner.test('isValidEmail: accepts valid email', () => {
  // Arrange
  const email = 'test@example.com';
  
  // Act
  const result = isValidEmail(email);
  
  // Assert
  assert.equal(result, true);
});
```

## Adding additional test suites

1. Create a new `.test.js` file in the appropriate folder
2. Add a button to `index.html`:
   ```html
   <button onclick="runTests('your/test.js')">Run Your Test</button>
   ```
3. Import the test module and call `runner.run()`
