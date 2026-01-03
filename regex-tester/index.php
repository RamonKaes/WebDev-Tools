<?php

declare(strict_types=1);

$toolId = 'regexTesterTool';
$lang = 'en';

$toolId = 'regexTesterTool';
$lang = 'en';


$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Regular Expression Testing</h3>
<ul class="mb-0">
    <li>JavaScript Engine: This tool uses JavaScript's RegExp engine for pattern testing</li>
    <li>Live Testing: Test your patterns against real text with instant visual feedback</li>
    <li>Privacy: All testing happens locally in your browser - no data is sent to servers</li>
</ul>
HTML;


$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN Regular Expressions Guide',
        'description' => 'Comprehensive guide to regular expressions in JavaScript by Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'In-depth tutorial and reference for regex patterns and syntax'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - Community Patterns',
        'description' => 'Learn regex with thousands of community-contributed patterns'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - Testing & Debugger',
        'description' => 'Advanced regex testing with explanation and visualization'
    ]
];


include __DIR__ . '/../partials/tool-base.php';
