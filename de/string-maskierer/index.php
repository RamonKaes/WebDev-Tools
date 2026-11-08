<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Der String-Escaper</strong> hilft Ihnen, Strings für verschiedene Formate zu maskieren und zu demaskieren, einschließlich HTML, XML, JavaScript, JSON, SQL und CSV.
    Perfekt für Entwickler, die mit String-Daten arbeiten, die für unterschiedliche Kontexte richtig maskiert werden müssen.
</p>
<p class="mb-0">
    Die gesamte Verarbeitung erfolgt clientseitig in Ihrem Browser – Ihre Daten verlassen niemals Ihr Gerät.
</p>
HTML;

$features = [
    'HTML/XML-Maskierung – kodiert Sonderzeichen wie <, > und &',
    'JavaScript-Maskierung – behandelt Anführungszeichen, Zeilenumbrüche und Sonderzeichen',
    'JSON-Maskierung – korrektes Escaping für JSON-Strings',
    'SQL-Maskierung – Schutz vor SQL-Injection',
    'CSV-Maskierung – behandelt Anführungszeichen und Trennzeichen',
    'Clientseitige Verarbeitung (Datenschutz an erster Stelle)',
    'Mit einem Klick in die Zwischenablage kopieren'
];

/*
$customNoticeType = 'info'; // info, warning, danger, success
$customNoticeContent = <<<HTML
<strong><i class="bi bi-info-circle me-2"></i>Hinweis-Titel</strong>
<p class="mb-0 mt-2">
    Optionale Hinweis- oder Warnmeldung.
</p>
HTML;
*/

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sicherheit</h3>
    <ul>
      <li>XSS-Angriffe mit HTML-Escaping verhindern</li>
      <li>SQL-Injection-Prävention</li>
      <li>Sichere String-Ausgabe in JavaScript</li>
      <li>Sichere Daten in JSON-APIs</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Datenverarbeitung</h3>
    <ul>
      <li>CSV-Export mit korrektem Escaping</li>
      <li>Bereinigung von XML/HTML-Inhalten</li>
      <li>JavaScript-String-Literale</li>
      <li>Datenbank-Abfragevorbereitung</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/Escape-Sequenz',
        'title' => 'Wikipedia: Escape-Sequenz',
        'description' => 'Einsteigerfreundliche Einführung in Escape-Zeichen und -Sequenzen'
    ],
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP XSS Prevention Cheat Sheet',
        'description' => 'Umfassender Leitfaden zur Verhinderung von Cross-Site-Scripting-Angriffen'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'MDN: JavaScript-String-Referenz',
        'description' => 'Vollständige Dokumentation für JavaScript-String-Methoden und Escaping'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP SQL Injection Prevention',
        'description' => 'Best Practices zur Verhinderung von SQL-Injection-Schwachstellen'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5 String Escaping',
        'description' => 'Offizielle Spezifikation für das Maskieren von Strings in HTML'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
