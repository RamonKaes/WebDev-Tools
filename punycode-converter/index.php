<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'en';
$featuresSectionTitle = 'Features';
$resourcesSectionTitle = 'Useful Resources';

$customAboutContent = <<<HTML
<p class="mb-2">
    Punycode is a encoding syntax used to represent Unicode characters 
    in domain names using only ASCII characters. It allows international domain names (IDN) 
    to work with the existing DNS infrastructure.
</p>
<p class="mb-0">
    This tool implements RFC 3492 to convert between Unicode domains (münchen.de) and 
    their Punycode equivalents (xn--mnchen-3ya.de). All conversions happen locally in your browser.
</p>
HTML;

$features = [
    'Bidirectional Conversion: Unicode to Punycode and vice versa',
    'Auto-Detection: Automatically detects input format',
    'RFC 3492 Compliant: Full implementation of the Punycode standard',
    'Batch Processing: Convert multiple domains at once (line by line)',
    'Example Domains: Load sample international domains for testing',
    'Real-Time Conversion: Auto-convert as you type'
];

$additionalSections = [
  [
    'title' => 'How Punycode Works',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode converts Unicode domain names to ASCII using a special encoding:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Unicode Domain</h3>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Punycode Domain</h3>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>The encoding process:</p>
<ol>
  <li>Extract ASCII characters (mnchen)</li>
  <li>Encode non-ASCII positions and values</li>
  <li>Add prefix <code>xn--</code> to indicate Punycode</li>
  <li>Append encoded Unicode information (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  All Punycode domains start with <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Common International Domains',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Language</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>German</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>German</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Russian</td></tr>
      <tr><td>东京.jp</td><td>xn--1lqs71d.jp</td><td>Japanese</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Arabic</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Greek</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Use Cases',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Domain Registration</h3>
    <ul>
      <li>Convert IDNs for DNS registration</li>
      <li>Check domain availability</li>
      <li>Email address encoding</li>
      <li>SSL certificate generation</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Web Development</h3>
    <ul>
      <li>URL handling in applications</li>
      <li>Database storage of domains</li>
      <li>API requests with IDNs</li>
      <li>Internationalization (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3492',
        'title' => 'RFC 3492: Punycode',
        'description' => 'Official IETF specification for Punycode encoding'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN: Internationalized Domain Names',
        'description' => 'Overview of IDN implementation and policies'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Internationalized_domain_name',
        'title' => 'Wikipedia: Internationalized Domain Name',
        'description' => 'Comprehensive information about IDN systems'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org: Punycode Converter',
        'description' => 'Additional Punycode conversion examples and information'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
