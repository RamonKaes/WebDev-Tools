<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'dataConverterTool';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$features = [
    'JSON, XML, YAML, CSV conversion',
    'Bidirectional format conversion',
    'Unix timestamp to date conversion',
    'Customizable output formatting',
    'Auto-convert live mode',
    'CSV delimiter options'
];

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">API Development</h3>
    <ul>
      <li>Convert API responses between formats</li>
      <li>Transform configuration files</li>
      <li>Parse timestamp values</li>
      <li>Export data for different systems</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Data Migration</h3>
    <ul>
      <li>Convert database exports</li>
      <li>Transform legacy data formats</li>
      <li>Prepare data for import/export</li>
      <li>Normalize timestamp formats</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Serialization',
        'title' => 'Wikipedia: Serialization',
        'description' => 'Beginner-friendly introduction to data serialization formats'
    ],
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - Introducing JSON',
        'description' => 'Official JSON specification and format documentation'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'YAML Specification',
        'description' => 'Official YAML format specification and examples'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'W3C XML Specification',
        'description' => 'Extensible Markup Language (XML) standard'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: CSV Format Specification',
        'description' => 'Official specification for Comma-Separated Values (CSV) format'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
