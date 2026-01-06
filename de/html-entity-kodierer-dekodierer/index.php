<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>HTML-Entities</strong> sind spezielle Zeichendarstellungen in HTML, um 
    reservierte Zeichen und Symbole korrekt anzuzeigen. Sie verhindern Browser-Parsing-Probleme 
    und gewährleisten eine korrekte Zeichendarstellung auf verschiedenen Systemen.
</p>
<p class="mb-0">
    Dieses Tool unterstützt benannte Entities (&amp;nbsp;), numerische dezimale Entities (&amp;#160;) 
    und hexadezimale Entities (&amp;#xA0;). Alle Konvertierungen erfolgen lokal in Ihrem Browser 
    für vollständigen Datenschutz.
</p>
HTML;

$features = [
    'Benannte Entities: Konvertierung zu Standard-HTML-Entities wie &nbsp;, &lt;, &gt;',
    'Numerische Entities: Dezimal (&#160;) oder Hexadezimal (&#xA0;) Format',
    'Bidirektional: Text zu Entities encodieren oder Entities zu Text decodieren',
    'Auto-Konvertierung: Echtzeit-Konvertierung während der Eingabe',
    'Zeichen-Referenz: Schneller Link zur Übersicht aller HTML-Entities',
    'Download-Unterstützung: Ergebnisse als Textdatei speichern'
];

$additionalSections = [
  [
    'title' => 'Häufige Anwendungsfälle',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">HTML-Entwicklung</h3>
    <ul>
      <li>Code in HTML anzeigen (&lt;, &gt;, &amp;)</li>
      <li>Sonderzeichen in Attributen</li>
      <li>Copyright & Trademark Symbole</li>
      <li>Geschützte Leerzeichen</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Datenverarbeitung</h3>
    <ul>
      <li>XML/RSS-Feed-Inhalte</li>
      <li>E-Mail-Template-Generierung</li>
      <li>Datenbank-Content-Escaping</li>
      <li>Internationalisierung (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Wichtige Entities',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Zeichen</th>
        <th>Benannte Entity</th>
        <th>Dezimal</th>
        <th>Hex</th>
        <th>Beschreibung</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Kleiner als</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Größer als</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>Kaufmännisches Und</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Anführungszeichen</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Geschütztes Leerzeichen</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Eingetragene Marke</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  Siehe die vollständige Liste in unserer <a href="../zeichen-referenz/">Zeichenreferenz</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/HTML-Entit%C3%A4t',
        'title' => 'Wikipedia: HTML-Entität',
        'description' => 'Einsteigerfreundliche Einführung in HTML-Zeichen-Entitäten'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'HTML Standard: Named Character References',
        'description' => 'Offizielle WHATWG HTML-Spezifikation für benannte Entities'
    ],
    [
        'url' => 'https://developer.mozilla.org/de/docs/Glossary/Entity',
        'title' => 'MDN: HTML-Entities',
        'description' => 'Umfassender Leitfaden zu HTML-Zeichen-Entities'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C: Verwendung von Zeichen-Escapes',
        'description' => 'Best Practices für die Verwendung von Zeichen-Escapes in Markup und CSS'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
