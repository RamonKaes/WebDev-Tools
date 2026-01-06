<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generate strong, secure passwords with customizable length and character sets. 
    Perfect for creating passwords that meet specific security requirements.
</p>
<p class="mb-0">
    This tool creates cryptographically secure random passwords using your browser's 
    built-in random number generator. All password generation happens locally - 
    your passwords never leave your device.
</p>
HTML;

$features = [
    'Customizable password length (4-128 characters)',
    'Include uppercase letters, lowercase letters, numbers, and symbols',
    'Exclude ambiguous characters (0,O,l,1, etc.)',
    'Generate multiple passwords at once',
    'Password strength indicator',
    'Copy to clipboard with one click',
    '100% client-side - passwords never sent to server'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Password Security Tips</h3>
    <ul class="mb-0">
        <li>Length matters: Longer passwords are exponentially more secure</li>
        <li>Use all character types: Mix uppercase, lowercase, numbers, and symbols</li>
        <li>Avoid patterns: Don't use dictionary words or personal information</li>
        <li>Unique passwords: Never reuse passwords across different accounts</li>
        <li>Use a password manager: Store generated passwords securely</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>User Accounts: Create secure passwords for new accounts</li>
    <li>API Keys: Generate random strings for API authentication</li>
    <li>Database Credentials: Secure database access with strong passwords</li>
    <li>Wi-Fi Networks: Create strong WPA2/WPA3 passwords</li>
    <li>Encryption Keys: Generate passphrases for encryption</li>
    <li>System Administration: Secure admin and root account access</li>
</ul>
HTML
    ],
    [
        'title' => 'Password Strength Guide',
        'content' => <<<HTML
<ul>
    <li><strong>Weak (< 8 chars):</strong> Easily cracked, avoid if possible</li>
    <li>Fair (8-11 chars): Minimum for most systems</li>
    <li>Good (12-15 chars): Recommended for important accounts</li>
    <li>Strong (16+ chars): Excellent security, hard to crack</li>
    <li>Very Strong (20+ chars): Maximum security for critical systems</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Password_strength',
        'title' => 'Wikipedia: Password Strength',
        'description' => 'Beginner-friendly introduction to password security concepts'
    ],
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B: Digital Identity Guidelines',
        'description' => 'Official guidelines for password creation and authentication'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP Authentication Cheat Sheet',
        'description' => 'Security best practices for password-based authentication'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'Cryptographically secure random number generation API'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'EFF Diceware Passphrase Generator',
        'description' => 'Alternative method for creating strong, memorable passphrases'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
