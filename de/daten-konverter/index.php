<?php

declare(strict_types=1);

$toolId = 'dataConverterTool';
$lang = 'de';



$toolId = 'dataConverterTool';
$lang = 'de';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>JSON, XML, YAML, CSV Konvertierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bidirektionale Format-Konvertierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unix-Timestamp zu Datum-Konvertierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anpassbare Ausgabe-Formatierung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Auto-Konvertierungs-Live-Modus</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>CSV-Trennzeichen-Optionen</li>
</ul>
HTML;

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
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - Einführung in JSON',
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
        'description' => 'Extensible Markup Language (XML) Standard'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: CSV-Format-Spezifikation',
        'description' => 'Offizielle Spezifikation für Comma-Separated Values (CSV) Format'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
