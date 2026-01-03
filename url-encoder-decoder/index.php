<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'en';

$customAboutContent = '
  <p class="mb-2">
    <strong>URL Encoding</strong> (also known as percent-encoding) converts characters 
    into a format that can be transmitted over the Internet. Special characters are 
    replaced with a "%" followed by two hexadecimal digits.
  </p>
  <p class="mb-0">
    All encoding and decoding happens locally in your browser. No data is sent to any 
    server, ensuring complete privacy and security.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>URL Encoding: Encode URLs and query parameters</li>
    <li>URL Decoding: Decode percent-encoded URLs</li>
    <li>Component Encoding: Encode individual URL components</li>
    <li>Bulk Processing: Encode/decode multiple lines at once</li>
    <li>URL Parsing: Extract protocol, host, path, and query strings</li>
    <li>Auto-detection: Automatically detect encoding requirements</li>
  </ul>
';

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>URL Encoding vs Component Encoding
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> encodes the entire URL, preserving special characters like <code>:</code>, <code>/</code>, <code>?</code>, and <code>&</code>.<br>
    <strong>encodeURIComponent()</strong> encodes all special characters, suitable for query parameters.
  </p>
';

$additionalSections = [
  [
    'title' => 'Common Use Cases',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">URL Encoding</h3>
    <ul>
      <li>Query parameter values</li>
      <li>Form data submission</li>
      <li>API request parameters</li>
      <li>Shareable URLs with special characters</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">URL Decoding</h3>
    <ul>
      <li>Read encoded URLs</li>
      <li>Debug API responses</li>
      <li>Parse query strings</li>
      <li>Extract URL components</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986: Uniform Resource Identifier (URI) Syntax',
        'description' => 'Official specification for URI syntax and encoding'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'JavaScript function for encoding URL components'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'JavaScript function for decoding URL components'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738: Uniform Resource Locators (URL)',
        'description' => 'Original specification for URL syntax and encoding rules'
    ]
];

include __DIR__ . '/../partials/tool-base.php';