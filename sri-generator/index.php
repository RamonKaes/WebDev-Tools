<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'en';

$featuresSectionTitle = 'Features';
$features = [
    'Generate SRI hashes from a URL, file upload, or pasted text',
    'Supports SHA-256, SHA-384 (recommended), and SHA-512 simultaneously',
    'Auto-generates ready-to-use <script> and <link> HTML tags',
    'One-click copy of integrity attribute and full HTML tag',
    'Privacy-first: All hashing runs client-side in your browser',
    'Auto-detects resource type (JS vs. CSS) from URL or filename',
];

$resourcesSectionTitle = 'Useful Resources';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN: Subresource Integrity',
        'description' => 'Official MDN documentation on SRI, browser support, and how integrity checking works.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'W3C SRI Specification',
        'description' => 'The official W3C specification defining the Subresource Integrity standard.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Browser compatibility table for the integrity attribute.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN: SubtleCrypto.digest()',
        'description' => 'Web Crypto API documentation — the browser API used by this tool for secure hashing.',
    ],
];

$additionalSections = [
    [
        'title'   => 'What is Subresource Integrity?',
        'icon'    => 'info-circle',
        'content' => <<<HTML
<p>
  <strong>Subresource Integrity (SRI)</strong> is a security feature that allows browsers to verify
  that resources fetched from a CDN or third-party server have not been tampered with.
  When you include an external script or stylesheet, the browser computes its hash and compares it
  against the value you provided in the <code>integrity</code> attribute — if they don't match,
  the resource is blocked.
</p>
<p>
  SRI is especially important for resources loaded from CDNs, where you have no control over the
  server. Even if a CDN is compromised and serves a malicious file, SRI will prevent it from running.
</p>
<pre class="bg-body-secondary p-3 rounded"><code>&lt;script src="https://cdn.example.com/lib.min.js"
        integrity="sha384-abc123..."
        crossorigin="anonymous"&gt;&lt;/script&gt;</code></pre>
HTML,
    ],
    [
        'title'   => 'Which Algorithm Should I Use?',
        'icon'    => 'shield-check',
        'content' => <<<HTML
<ul>
  <li><strong>SHA-384</strong> — Recommended. Strong security, widely supported, standard choice for most CDN resources.</li>
  <li><strong>SHA-512</strong> — Maximum security. Use when you need the highest level of integrity assurance.</li>
  <li><strong>SHA-256</strong> — Supported, but SHA-384+ is preferred for new projects.</li>
</ul>
<p>
  You can specify multiple hashes in a single <code>integrity</code> attribute, separated by spaces.
  The browser will use whichever algorithm it supports and considers the strongest.
</p>
HTML,
    ],
];

include __DIR__ . '/../partials/tool-base.php';
