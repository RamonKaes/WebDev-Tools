<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$features = [
    'Hundreds of emojis',
    'Category filtering',
    'Keyword search',
    'Unicode information',
    'One-click copy',
    'Developer-focused categories'
];

// Useful Resources (Optional)
$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Emoji',
        'title' => 'Wikipedia: Emoji',
        'description' => 'Beginner-friendly introduction to emoji history and usage'
    ],
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Unicode Emoji Charts',
        'description' => 'Official Unicode Consortium emoji reference and documentation'
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
    ]
];

// Load centralized template
include __DIR__ . '/../partials/tool-base.php';
