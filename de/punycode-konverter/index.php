<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'de';

$customAboutContent = '
  <p class="mb-2">
    <strong>Punycode</strong> ist eine Kodierungssyntax zur Darstellung von Unicode-Zeichen 
    in Domainnamen mit ausschließlich ASCII-Zeichen. Sie ermöglicht die Verwendung 
    internationaler Domainnamen (IDN) in der bestehenden DNS-Infrastruktur.
  </p>
  <p class="mb-0">
    Dieses Tool implementiert RFC 3492 zur Konvertierung zwischen Unicode-Domains (münchen.de) 
    und ihren Punycode-Äquivalenten (xn--mnchen-3ya.de). Alle Konvertierungen erfolgen lokal 
    in Ihrem Browser.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Bidirektionale Konvertierung: Unicode zu Punycode und umgekehrt</li>
    <li>Auto-Erkennung: Automatische Erkennung des Eingabeformats</li>
    <li>RFC 3492 Konform: Vollständige Implementierung des Punycode-Standards</li>
    <li>Batch-Verarbeitung: Mehrere Domains gleichzeitig konvertieren (zeilenweise)</li>
    <li>Beispiel-Domains: Internationale Beispiel-Domains zum Testen laden</li>
    <li>Echtzeit-Konvertierung: Auto-Konvertierung während der Eingabe</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Wie Punycode funktioniert',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode konvertiert Unicode-Domainnamen zu ASCII mit einer speziellen Kodierung:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Unicode-Domain</h4>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Punycode-Domain</h4>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>Der Kodierungsprozess:</p>
<ol>
  <li>ASCII-Zeichen extrahieren (mnchen)</li>
  <li>Nicht-ASCII-Positionen und -Werte kodieren</li>
  <li>Präfix <code>xn--</code> hinzufügen für Punycode-Kennzeichnung</li>
  <li>Kodierte Unicode-Information anhängen (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  Alle Punycode-Domains beginnen mit <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Gängige internationale Domains',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Sprache</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>Deutsch</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>Deutsch</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Russisch</td></tr>
      <tr><td>東京.jp</td><td>xn--1lqs71d.jp</td><td>Japanisch</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Arabisch</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Griechisch</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Anwendungsfälle',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Domain-Registrierung</h3>
    <ul>
      <li>IDNs für DNS-Registrierung konvertieren</li>
      <li>Domain-Verfügbarkeit prüfen</li>
      <li>E-Mail-Adressen kodieren</li>
      <li>SSL-Zertifikat-Generierung</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Webentwicklung</h3>
    <ul>
      <li>URL-Handhabung in Anwendungen</li>
      <li>Datenbank-Speicherung von Domains</li>
      <li>API-Anfragen mit IDNs</li>
      <li>Internationalisierung (i18n)</li>
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
        'description' => 'Offizielle IETF-Spezifikation für Punycode-Kodierung'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN: Internationalisierte Domainnamen',
        'description' => 'Übersicht über IDN-Implementierung und -Richtlinien'
    ],
    [
        'url' => 'https://de.wikipedia.org/wiki/Internationalisierter_Domainname',
        'title' => 'Wikipedia: Internationalisierter Domainname',
        'description' => 'Umfassende Informationen über IDN-Systeme'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org: Punycode Converter',
        'description' => 'Zusätzliche Punycode-Konvertierungsbeispiele und Informationen'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
