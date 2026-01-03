<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jwtDecoderTool';
$lang = 'en';

$customAboutContent = '
  <p class="mb-2">
    <strong>JSON Web Tokens (JWT)</strong> are a compact, URL-safe means of representing 
    claims between two parties. They are commonly used for authentication and information 
    exchange in modern web applications and APIs.
  </p>
  <p class="mb-0">
    This decoder extracts and displays the header, payload, and signature components of a JWT. 
    Note: Signature verification requires the secret key and should be done 
    server-side for security.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Header Decoding: View algorithm (alg) and token type (typ)</li>
    <li>Payload Extraction: Decode claims and user data</li>
    <li>Expiry Checking: Automatically verify if token has expired</li>
    <li>Syntax Highlighting: Color-coded JSON for better readability</li>
    <li>Signature Display: Show Base64URL-encoded signature</li>
    <li>Client-Side: All processing happens locally in your browser</li>
  </ul>
';

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Important Security Information</h3>
    <ul class="mb-2">
        <li>Decoding ≠ Verification: This tool only decodes the JWT. It does NOT verify the signature.</li>
        <li>Never trust unverified tokens: Always verify signatures server-side before using JWT data.</li>
        <li>Sensitive Data: JWTs are Base64-encoded, not encrypted. Anyone can decode them.</li>
        <li>Secret Keys: Never paste secret keys into online tools or client-side code.</li>
    </ul>
    <p class="mb-0 small">
        For production applications, use proper JWT libraries like 
        <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python), or 
        <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'JWT Structure',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>A JWT consists of three Base64URL-encoded parts separated by dots (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATURE</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Contains token metadata:</p>
    <ul class="small">
      <li><code>alg</code>: Algorithm (HS256, RS256...)</li>
      <li><code>typ</code>: Token type (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Contains the claims:</p>
    <ul class="small">
      <li><code>sub</code>: Subject (user ID)</li>
      <li><code>exp</code>: Expiration time</li>
      <li><code>iat</code>: Issued at</li>
      <li>Custom claims</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signature</h3>
    <p class="small">Verifies token integrity:</p>
    <ul class="small">
      <li>HMAC or RSA signature</li>
      <li>Requires secret key to verify</li>
      <li>Prevents tampering</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://jwt.io/',
        'title' => 'JWT.io',
        'description' => 'Official JWT website with debugger and library information'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519: JSON Web Token',
        'description' => 'Official IETF specification for JWT'
    ],
    [
        'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
        'title' => 'Auth0: Introduction to JSON Web Tokens',
        'description' => 'Comprehensive guide to understanding and using JWTs'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto',
        'title' => 'MDN: SubtleCrypto',
        'description' => 'Web Crypto API for cryptographic operations in JavaScript'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
