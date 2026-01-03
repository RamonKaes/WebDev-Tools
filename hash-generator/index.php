<?php

declare(strict_types=1);

$toolId = 'hashGeneratorTool';
$lang = 'en';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generate cryptographic hashes for text and files using multiple algorithms. 
    Perfect for data integrity verification, password hashing, and security applications.
</p>
<p class="mb-0">
    This tool supports popular hashing algorithms including MD5, SHA-1, SHA-256, SHA-512, 
    and more. All hashing is performed client-side for maximum privacy and security.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multiple hash algorithms: MD5, SHA-1, SHA-256, SHA-384, SHA-512</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Hash text and files</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Compare hashes for verification</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HMAC support with custom keys</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Uppercase and lowercase output options</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copy hashes with one click</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time hash generation</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% client-side processing - your data never leaves your browser</li>
</ul>
HTML;

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Security Considerations</h3>
    <ul class="mb-0">
        <li>Use SHA-256 or higher: MD5 and SHA-1 are cryptographically broken</li>
        <li>Don't use plain hashes for passwords: Use bcrypt, scrypt, or PBKDF2 instead</li>
        <li>Add salts for password hashing: Prevent rainbow table attacks</li>
        <li>Verify hash integrity: Always compare full hash values, not truncated versions</li>
        <li>Use HMAC for authentication: Provides both integrity and authenticity</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>File Integrity Verification: Verify downloads haven't been tampered with</li>
    <li>Password Hashing: Store secure password hashes (use SHA-256 or higher)</li>
    <li>Data Deduplication: Identify duplicate files or content</li>
    <li>Checksum Generation: Create checksums for data validation</li>
    <li>Digital Signatures: Component of cryptographic signature systems</li>
    <li>API Authentication: Generate HMAC signatures for API requests</li>
</ul>
HTML
    ],
    [
        'title' => 'Hash Algorithm Selection',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5: Fast but not recommended for security (128-bit, vulnerable to collisions)</li>
    <li>SHA-1: Deprecated for security use (160-bit, collision attacks exist)</li>
    <li>SHA-256: Industry standard for security applications (256-bit, secure)</li>
    <li>SHA-384: High security variant (384-bit, very secure)</li>
    <li>SHA-512: Maximum security variant (512-bit, very secure)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'NIST Cryptographic Hash Functions',
        'description' => 'Official NIST documentation and standards for hash algorithms'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Secure_Hash_Algorithms',
        'title' => 'Secure Hash Algorithms (SHA) - Wikipedia',
        'description' => 'Comprehensive overview of SHA family algorithms and their security'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'Browser API documentation for generating cryptographic digests'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP Password Storage Cheat Sheet',
        'description' => 'Security best practices for password hashing and storage'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
