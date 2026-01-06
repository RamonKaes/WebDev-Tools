<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>String Escaper</strong> helps you escape and unescape strings for various formats including HTML, XML, JavaScript, JSON, SQL, and CSV.
    Perfect for developers working with string data that needs proper escaping for different contexts.
</p>
<p class="mb-0">
    All processing happens client-side in your browser – your data never leaves your device.
</p>
HTML;

$features = [
    'HTML/XML Escape – Encode special characters like <, >, &',
    'JavaScript Escape – Handle quotes, newlines, and special characters',
    'JSON Escape – Proper escaping for JSON strings',
    'SQL Escape – Protect against SQL injection',
    'CSV Escape – Handle quotes and delimiters',
    'Client-side processing (privacy-first)',
    'Copy to clipboard with one click'
];

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Security</h3>
    <ul>
      <li>Prevent XSS attacks with HTML escaping</li>
      <li>SQL injection prevention</li>
      <li>Safe string output in JavaScript</li>
      <li>Secure data in JSON APIs</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Data Processing</h3>
    <ul>
      <li>CSV export with proper escaping</li>
      <li>XML/HTML content sanitization</li>
      <li>JavaScript string literals</li>
      <li>Database query preparation</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Escape_character',
        'title' => 'Wikipedia: Escape Character',
        'description' => 'Beginner-friendly introduction to escape sequences and characters'
    ],
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP XSS Prevention Cheat Sheet',
        'description' => 'Comprehensive guide to preventing Cross-Site Scripting attacks'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'MDN JavaScript String Reference',
        'description' => 'Complete documentation for JavaScript string methods and escaping'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP SQL Injection Prevention',
        'description' => 'Best practices for preventing SQL injection vulnerabilities'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5 String Escaping',
        'description' => 'Official specification for escaping strings in HTML'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
