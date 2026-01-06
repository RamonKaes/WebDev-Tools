<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'en';

$customAboutContent = <<<HTML
<p class="mb-2">
    Convert between pixels (px) and rem units quickly and accurately. Essential for 
    responsive web design and accessible typography.
</p>
<p class="mb-0">
    The rem (root em) unit is relative to the root element's font size, making it ideal 
    for creating scalable and accessible interfaces. This tool helps you convert px values 
    to rem and vice versa based on your base font size.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Convert px to rem and rem to px</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Customizable base font size (default: 16px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Batch conversion: convert multiple values at once</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time conversion as you type</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copy converted values with one click</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Common breakpoint presets</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% client-side processing</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Why Use rem Units?</h3>
    <ul class="mb-0">
        <li>Accessibility: Users can adjust their browser's font size</li>
        <li>Consistency: All sizes scale proportionally</li>
        <li>Responsive Design: Easier to maintain across different screen sizes</li>
        <li>Best Practice: Industry standard for modern web development</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>Typography: Convert font sizes from px to rem</li>
    <li>Spacing: Convert margins and padding to rem units</li>
    <li>Responsive Breakpoints: Define media queries in rem</li>
    <li>Component Sizing: Scale UI components proportionally</li>
    <li>Accessibility Compliance: Meet WCAG guidelines</li>
</ul>
HTML
    ],
    [
        'title' => 'rem vs em vs px',
        'content' => <<<HTML
<ul>
    <li>px: Absolute unit, fixed size regardless of context</li>
    <li>em: Relative to parent element's font size (can compound)</li>
    <li>rem: Relative to root element's font size (consistent)</li>
    <li>Recommendation: Use rem for global sizing, em for component-specific scaling</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Em_(typography)',
        'title' => 'Wikipedia: Em (typography)',
        'description' => 'Beginner-friendly introduction to typographic units em and rem'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN CSS Values and Units',
        'description' => 'Complete guide to CSS units including px, rem, and em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Module Level 3',
        'description' => 'Official specification for CSS rem units'
    ],
    [
        'url' => 'https://moderncss.dev/generating-font-size-css-rules-and-creating-a-fluid-type-scale/',
        'title' => 'Modern CSS: Generating Font Size Rules and Fluid Type Scale',
        'description' => 'Comprehensive guide to rem units and fluid typography in modern CSS'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixels vs. Relative Units in CSS',
        'description' => 'Accessibility benefits of using rem over px'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
