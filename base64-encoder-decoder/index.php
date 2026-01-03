<?php

declare(strict_types=1);

$toolId = 'base64EncoderDecoder';
$lang = 'en';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Text and file encoding/decoding</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Drag & drop file support</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>URL-safe Base64 encoding</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time live mode</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multi-line processing</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Client-side processing - your data never leaves your browser</li>
</ul>
HTML;

$additionalSections = [
  [
    'title' => 'Common Use Cases',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Development</h3>
    <ul>
      <li>API Authentication (Basic Auth)</li>
      <li>JWT Token Decoding</li>
      <li>Data URIs for Images</li>
      <li>Email Attachments</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Data Transfer</h3>
    <ul>
      <li>Binary Data in JSON</li>
      <li>URL Parameter Encoding</li>
      <li>Cookie Values</li>
      <li>XML Binary Data</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648: The Base16, Base32, and Base64 Data Encodings',
        'description' => 'Official IETF specification defining Base64 encoding standard'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'MDN Base64 Encoding Guide',
        'description' => 'Comprehensive guide to Base64 encoding in web development'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
        'title' => 'MDN btoa() Function',
        'description' => 'JavaScript function for encoding strings to Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob() Function',
        'description' => 'JavaScript function for decoding Base64 to strings'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
