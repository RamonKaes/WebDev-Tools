<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'en';

$customAboutContent = '
  <p class="mb-2">
    <strong>HTML Entities</strong> are special character representations used in HTML to display 
    reserved characters and symbols. They prevent browser parsing issues and ensure proper 
    character rendering across different systems and encodings.
  </p>
  <p class="mb-0">
    This tool supports named entities (&amp;nbsp;), numeric decimal entities (&amp;#160;), 
    and hexadecimal entities (&amp;#xA0;). All conversions happen locally in your browser 
    for complete privacy.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Named Entities: Convert to standard HTML entities like &amp;nbsp;, &amp;lt;, &amp;gt;</li>
    <li>Numeric Entities: Decimal (&amp;#160;) or hexadecimal (&amp;#xA0;) format</li>
    <li>Bidirectional: Encode text to entities or decode entities to text</li>
    <li>Auto-Convert: Real-time conversion as you type</li>
    <li>Character Reference: Quick link to browse all available HTML entities</li>
    <li>Download Support: Save results as text file</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Common Use Cases',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">HTML Development</h3>
    <ul>
      <li>Display Code in HTML (&lt;, &gt;, &amp;)</li>
      <li>Special Characters in Attributes</li>
      <li>Copyright & Trademark Symbols</li>
      <li>Non-Breaking Spaces</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Data Processing</h3>
    <ul>
      <li>XML/RSS Feed Content</li>
      <li>Email Template Generation</li>
      <li>Database Content Escaping</li>
      <li>Internationalization (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Important Entities',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Character</th>
        <th>Named Entity</th>
        <th>Decimal</th>
        <th>Hex</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Less than</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Greater than</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>Ampersand</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Quote</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Non-breaking space</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Registered</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  View the complete list in our <a href="../character-reference/">Character Reference</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references',
        'title' => 'Wikipedia: HTML Character Entities',
        'description' => 'Beginner-friendly introduction to HTML character entities'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'HTML Standard: Named Character References',
        'description' => 'Official WHATWG HTML specification for named entities'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: HTML Entities',
        'description' => 'Comprehensive guide to HTML character entities'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C: Using Character Escapes',
        'description' => 'Best practices for using character escapes in markup and CSS'
    ]
];

require_once __DIR__ . '/../partials/tool-base.php';
