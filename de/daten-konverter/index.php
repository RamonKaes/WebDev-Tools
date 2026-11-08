<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'dataConverterTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Konvertierung zwischen JSON, XML, YAML und CSV',
    'Bidirektionale Format-Konvertierung',
    'Unix-Timestamp-zu-Datum-Konvertierung',
    'Anpassbare Ausgabeformatierung',
    'Auto-Konvertierung im Live-Modus',
    'CSV-Trennzeichen-Optionen'
];

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">API-Entwicklung</h3>
    <ul>
      <li>API-Antworten zwischen Formaten konvertieren</li>
      <li>Konfigurationsdateien transformieren</li>
      <li>Timestamp-Werte analysieren</li>
      <li>Daten für verschiedene Systeme exportieren</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Datenmigration</h3>
    <ul>
      <li>Datenbank-Exporte konvertieren</li>
      <li>Legacy-Datenformate transformieren</li>
      <li>Daten für Import/Export vorbereiten</li>
      <li>Timestamp-Formate normalisieren</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/Serialisierung',
        'title' => 'Wikipedia: Serialisierung',
        'description' => 'Einsteigerfreundliche Einführung in Datenserialisierungsformate'
    ],
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org – Einführung in JSON',
        'description' => 'Offizielle JSON-Spezifikation und Format-Dokumentation'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'YAML-Spezifikation',
        'description' => 'Offizielle YAML-Format-Spezifikation und Beispiele'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'W3C XML-Spezifikation',
        'description' => 'Der Standard der Extensible Markup Language (XML)'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: CSV-Format-Spezifikation',
        'description' => 'Offizielle Spezifikation für das CSV-Format (Comma-Separated Values)'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
