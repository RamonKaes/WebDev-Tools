<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'de';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>String Escaper</strong> hilft dir, Strings für verschiedene Formate zu maskieren und zu demaskieren, einschließlich HTML, XML, JavaScript, JSON, SQL und CSV.
    Perfekt für Entwickler, die mit String-Daten arbeiten, die für unterschiedliche Kontexte richtig maskiert werden müssen.
</p>
<p class="mb-0">
    Die gesamte Verarbeitung erfolgt clientseitig in deinem Browser – deine Daten verlassen niemals dein Gerät.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HTML/XML Escape – Kodiert Sonderzeichen wie &lt;, &gt;, &amp;</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>JavaScript Escape – Behandelt Anführungszeichen, Zeilenumbrüche und Sonderzeichen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>JSON Escape – Korrekte Maskierung für JSON-Strings</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>SQL Escape – Schutz vor SQL-Injection</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>CSV Escape – Behandelt Anführungszeichen und Trennzeichen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Clientseitige Verarbeitung (Datenschutz zuerst)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mit einem Klick in Zwischenablage kopieren</li>
</ul>
HTML;

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
      <li>XML/HTML-Content-Sanitization</li>
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
        'description' => 'Umfassender Leitfaden zur Verhinderung von Cross-Site Scripting-Angriffen'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'MDN JavaScript String-Referenz',
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
