<?php

declare(strict_types=1);

$toolId = 'characterReferenceTool';
$lang = 'en';

$customAboutContent = '
  <p class="mb-2">
    Browse and search through a comprehensive collection of HTML entities, Unicode characters, 
    and special symbols. Find the entity codes you need for web development, from common symbols 
    to mathematical operators and emoji.
  </p>
  <p class="mb-0">
    Each character displays its HTML entity, decimal code, hex code, and Unicode representation. 
    Click any format to copy it instantly to your clipboard.
  </p>
';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Over 2,231 HTML entities</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Category-based browsing</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Powerful search function</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multiple copy formats</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unicode, decimal, hex codes</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>One-click copy</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'WHATWG HTML Named Character References',
        'description' => 'Official HTML specification for named character entities'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN HTML Entities Reference',
        'description' => 'Complete guide to HTML character entities and special characters'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'W3C XML Entity Definitions for Characters',
        'description' => 'Official W3C entity definitions and Unicode mappings'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Unicode Character Code Charts',
        'description' => 'Official Unicode Consortium character reference charts'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
