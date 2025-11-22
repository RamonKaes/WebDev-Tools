<?php

declare(strict_types=1);

$toolId = 'codeFormatterTool';
$lang = 'de';



$toolId = 'codeFormatterTool';
$lang = 'de';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HTML, CSS, JavaScript, XML, SQL Formatierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Verschönerungs- und Minifizierungs-Modi</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anpassbare Einrückung (2/4 Leerzeichen, Tabs)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Echtzeit-Automatische Formatierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Syntax-Validierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Kopier- und Download-Unterstützung</li>
</ul>
HTML;


/*
$customNoticeContent = <<<HTML
<div class="alert alert-info" role="alert">
  <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Formatierungsoptionen</h2>
  <ul class="mb-0">
    <li>Verschönern: Macht Code mit korrekter Einrückung und Zeilenumbrüchen lesbarer</li>
    <li>Minifizieren: Entfernt unnötige Leerzeichen zur Reduzierung der Dateigröße</li>
    <li>Einrückung: Wählen Sie zwischen 2 Leerzeichen, 4 Leerzeichen oder Tabs</li>
  </ul>
</div>
HTML;
*/

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Entwicklung</h3>
    <ul>
      <li>Minifizierten Code für einfacheres Lesen und Debugging verschönern</li>
      <li>Code-Formatierung im Team standardisieren</li>
      <li>Unordentlichen oder automatisch generierten Code aufräumen</li>
      <li>Code vor dem Commit in Versionskontrolle formatieren</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Produktion</h3>
    <ul>
      <li>Code minifizieren zur Reduzierung der Dateigröße und Verbesserung der Ladezeiten</li>
      <li>Code für Deployment vorbereiten</li>
      <li>Bandbreitennutzung optimieren</li>
      <li>Website-Performance verbessern</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/JavaScript/Reference',
        'title' => 'MDN JavaScript-Referenz',
        'description' => 'Vollständiger Leitfaden zur JavaScript-Syntax und Best Practices'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'W3C CSS-Spezifikationen',
        'description' => 'Offizielle CSS-Standards und Formatierungsrichtlinien'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Aktuelle HTML-Spezifikation und Syntaxregeln'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'W3C XML-Spezifikation',
        'description' => 'Extensible Markup Language (XML) Standard'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
