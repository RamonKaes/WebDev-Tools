'use strict';

// Provide TextEncoder/TextDecoder (needed for Base64 tool's UTF-8 handling)
const { TextEncoder, TextDecoder } = require('util');
global.TextEncoder = TextEncoder;
global.TextDecoder = TextDecoder;

// Mock URL blob methods (jsdom does not implement these)
global.URL.createObjectURL = jest.fn(() => 'blob:mock-url');
global.URL.revokeObjectURL = jest.fn();

// Mock scrollIntoView (not implemented in jsdom)
global.HTMLElement.prototype.scrollIntoView = jest.fn();
