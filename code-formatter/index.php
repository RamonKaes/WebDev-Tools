<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'codeFormatterTool';
$lang = 'en';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HTML, CSS, JavaScript, XML, SQL formatting</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Beautify and minify modes</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Customizable indentation (2/4 spaces, tabs)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time auto-formatting</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Syntax validation</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copy and download support</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Development</h3>
    <ul>
      <li>Beautify minified code for easier reading and debugging</li>
      <li>Standardize code formatting across your team</li>
      <li>Clean up messy or auto-generated code</li>
      <li>Format code before committing to version control</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Production</h3>
    <ul>
      <li>Minify code to reduce file size and improve load times</li>
      <li>Prepare code for deployment</li>
      <li>Optimize bandwidth usage</li>
      <li>Improve website performance</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Prettyprint',
        'title' => 'Wikipedia: Pretty-printing',
        'description' => 'Beginner-friendly introduction to code formatting and pretty-printing'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
        'title' => 'MDN JavaScript Reference',
        'description' => 'Complete guide to JavaScript syntax and best practices'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'W3C CSS Specifications',
        'description' => 'Official CSS standards and formatting guidelines'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Current HTML specification and syntax rules'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'W3C XML Specification',
        'description' => 'Extensible Markup Language (XML) standard'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
