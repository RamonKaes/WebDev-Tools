<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jsonFormatterValidator';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$customAboutContent = <<<HTML
<p class="mb-2">
    Format, validate, and beautify JSON data with our comprehensive JSON tool. 
    Perfect for developers working with APIs, configuration files, and data structures.
</p>
<p class="mb-0">
    This tool parses JSON data, validates syntax, formats it with proper indentation, 
    and provides detailed error messages. All processing happens client-side for maximum privacy.
</p>
HTML;

$features = [
    'Format and beautify JSON with customizable indentation (2 or 4 spaces)',
    'Validate JSON syntax with detailed error messages',
    'Minify JSON to reduce file size',
    'Real-time syntax validation',
    'Line-by-line error detection',
    'Copy formatted result with one click',
    'Clear error highlighting and messages',
    'Privacy-focused: all processing happens in your browser'
];

$customNoticeType = 'info'; // Blue info alert
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>JSON Formatting Options</h3>
<ul class="mb-0">
    <li>Beautify (2 spaces): Standard formatting with 2-space indentation</li>
    <li>Beautify (4 spaces): More readable formatting with 4-space indentation</li>
    <li>Minify: Remove all whitespace to create compact JSON</li>
    <li>Validate: Check JSON syntax without reformatting</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>API Development: Format API responses for better readability</li>
    <li>Configuration Files: Validate and format JSON config files</li>
    <li>Data Inspection: Quickly examine JSON data structures</li>
    <li>Debugging: Identify syntax errors in JSON data</li>
    <li>Code Review: Ensure consistent JSON formatting</li>
    <li>Data Migration: Validate JSON before importing</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/JSON',
        'title' => 'Wikipedia: JSON',
        'description' => 'Beginner-friendly introduction to JSON concepts and usage'
    ],
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404: The JSON Data Interchange Syntax',
        'description' => 'Official JSON specification by ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259: The JavaScript Object Notation (JSON)',
        'description' => 'IETF standard for JSON data format'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'MDN JSON Object Reference',
        'description' => 'Complete guide to JSON.parse() and JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'JSON Schema Specification',
        'description' => 'Official documentation for validating JSON structure and data types'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
