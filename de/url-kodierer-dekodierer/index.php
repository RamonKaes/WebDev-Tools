<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'de';

$customAboutContent = '
  <p class="mb-2">
    <strong>URL-Kodierung</strong> (auch als Prozent-Kodierung bekannt) konvertiert Zeichen 
    in ein Format, das über das Internet übertragen werden kann. Sonderzeichen werden 
    durch ein "%" gefolgt von zwei Hexadezimalziffern ersetzt.
  </p>
  <p class="mb-0">
    Alle Kodierungs- und Dekodierungsvorgänge erfolgen lokal in Ihrem Browser. Es werden 
    keine Daten an einen Server gesendet, was vollständige Privatsphäre und Sicherheit 
    gewährleistet.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>URL-Kodierung: Kodieren von URLs und Query-Parametern</li>
    <li>URL-Dekodierung: Dekodieren von prozent-kodierten URLs</li>
    <li>Komponenten-Kodierung: Kodieren einzelner URL-Komponenten</li>
    <li>Stapelverarbeitung: Mehrere Zeilen gleichzeitig kodieren/dekodieren</li>
    <li>URL-Parsing: Extrahieren von Protokoll, Host, Pfad und Query-Strings</li>
    <li>Auto-Erkennung: Automatische Erkennung der Kodierungsanforderungen</li>
  </ul>
';

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>URL-Kodierung vs. Komponenten-Kodierung
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> kodiert die gesamte URL unter Beibehaltung von Sonderzeichen wie <code>:</code>, <code>/</code>, <code>?</code> und <code>&</code>.<br>
    <strong>encodeURIComponent()</strong> kodiert alle Sonderzeichen und ist für Query-Parameter geeignet.
  </p>
';

$additionalSections = [
  [
    'title' => 'Anwendungsfälle',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">URL-Kodierung</h3>
    <ul>
      <li>Query-Parameter-Werte</li>
      <li>Formulardaten-Übermittlung</li>
      <li>API-Anfrageparameter</li>
      <li>Teilbare URLs mit Sonderzeichen</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">URL-Dekodierung</h3>
    <ul>
      <li>Kodierte URLs lesen</li>
      <li>API-Antworten debuggen</li>
      <li>Query-Strings parsen</li>
      <li>URL-Komponenten extrahieren</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986: Uniform Resource Identifier (URI) Syntax',
        'description' => 'Offizielle Spezifikation für URI-Syntax und -Kodierung'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'JavaScript-Funktion zur Kodierung von URL-Komponenten'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'JavaScript-Funktion zur Dekodierung von URL-Komponenten'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738: Uniform Resource Locators (URL)',
        'description' => 'Ursprüngliche Spezifikation für URL-Syntax und Kodierungsregeln'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';