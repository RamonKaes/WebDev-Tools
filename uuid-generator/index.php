<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'uuidGeneratorTool';
$lang = 'en';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generate unique identifiers (UUIDs/GUIDs) instantly for your applications, databases, 
    and APIs. Supports multiple UUID versions with cryptographically secure generation.
</p>
<p class="mb-0">
    UUIDs (Universally Unique Identifiers) are 128-bit values used to uniquely identify 
    information in computer systems. This tool generates standards-compliant UUIDs that are 
    guaranteed to be unique across space and time.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generate UUID v4 (random) with cryptographic security</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bulk generation: create multiple UUIDs at once</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multiple output formats: standard, uppercase, no hyphens</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copy individual UUIDs or all at once</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>RFC 4122 compliant</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>No server communication - 100% client-side</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Instant generation with no delays</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>About UUID Version 4</h3>
    <p class="mb-2">
        UUID v4 uses random or pseudo-random numbers. The format is:
    </p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">
        Where <code>x</code> is any hexadecimal digit and <code>y</code> is one of 8, 9, A, or B. 
        The 4 indicates the UUID version, and the variant bits ensure RFC compliance.
        With 122 random bits, the probability of collision is astronomically low.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>Database Primary Keys: Unique identifiers for database records</li>
    <li>API Request IDs: Track and correlate API requests</li>
    <li>Session Tokens: Generate secure session identifiers</li>
    <li>File Names: Create unique file names to prevent conflicts</li>
    <li>Distributed Systems: Generate IDs without central coordination</li>
    <li>Transaction IDs: Uniquely identify financial or business transactions</li>
</ul>
HTML
    ],
    [
        'title' => 'UUID Format Explained',
        'content' => <<<HTML
<p>A UUID is typically represented as 32 hexadecimal digits in 5 groups:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Standard format: Lowercase with hyphens (most common)</li>
    <li>Uppercase format: Uppercase with hyphens (some APIs prefer this)</li>
    <li>Compact format: No hyphens, just 32 hex characters</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122: A Universally Unique IDentifier (UUID) URN Namespace',
        'description' => 'Official specification for UUID format and generation'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562: UUID Version 6, 7, and 8',
        'description' => 'Latest UUID specification including new versions and timestamp-based UUIDs'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'Browser API for generating cryptographically secure UUIDs'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Universally_unique_identifier',
        'title' => 'UUID Overview - Wikipedia',
        'description' => 'Comprehensive explanation of UUID versions and use cases'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
