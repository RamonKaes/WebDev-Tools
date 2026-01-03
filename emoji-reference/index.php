<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'en';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Hundreds of emojis</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Category filtering</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Keyword search</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unicode information</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>One-click copy</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Developer-focused categories</li>
</ul>
HTML;

// Useful Resources (Optional)
$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/full-emoji-list.html',
        'title' => 'Unicode Full Emoji List',
        'description' => 'Official Unicode Consortium complete emoji reference'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Comprehensive emoji encyclopedia with meanings and platform variations'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'JavaScript method for creating strings from Unicode code points'
    ],
    [
        'url' => 'https://www.w3.org/TR/emoji/',
        'title' => 'W3C Emoji Requirements',
        'description' => 'Technical specifications for emoji implementation in web standards'
    ]
];

// Load centralized template
include __DIR__ . '/../partials/tool-base.php';
