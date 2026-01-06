<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Text- und Datei-Kodierung/-Dekodierung',
    'Drag & Drop Datei-Unterstützung',
    'URL-sichere Base64-Kodierung',
    'Echtzeit Live-Modus',
    'Mehrzeilige Verarbeitung',
    'Client-seitige Verarbeitung - Ihre Daten verlassen niemals Ihren Browser'
];

$additionalSections = [
  [
    'title' => 'Anwendungsfälle',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Entwicklung</h3>
    <ul>
      <li>API-Authentifizierung (Basic Auth)</li>
      <li>JWT-Token-Dekodierung</li>
      <li>Daten-URIs für Bilder</li>
      <li>E-Mail-Anhänge</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Datenübertragung</h3>
    <ul>
      <li>Binärdaten in JSON</li>
      <li>URL-Parameter-Kodierung</li>
      <li>Cookie-Werte</li>
      <li>XML-Binärdaten</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [        'url' => 'https://de.wikipedia.org/wiki/Base64',
        'title' => 'Base64 - Wikipedia',
        'description' => 'Einführung in das Base64-Kodierungskonzept und Geschichte'
    ],
    [        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648: Base16, Base32 und Base64 Datenkodierung',
        'description' => 'Offizielle IETF-Spezifikation für Base64-Kodierung'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'MDN Base64 Kodierungs-Leitfaden',
        'description' => 'Umfassender Leitfaden für Base64 in der Webentwicklung'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
        'title' => 'MDN btoa() Funktion',
        'description' => 'JavaScript-Funktion zum Kodieren von Strings in Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob() Funktion',
        'description' => 'JavaScript-Funktion zum Dekodieren von Base64 in Strings'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
