<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jsonFormatterValidator';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';
$customAboutContent = <<<HTML
<p class="mb-2">Formatieren, validieren und visualisieren Sie JSON-Daten mit erweiterten Funktionen. Perfekt für Entwickler, die mit APIs, Konfigurationsdateien und strukturierten Daten arbeiten.</p>
<p>Dieses Tool hilft Ihnen, JSON zu bereinigen, Fehler zu finden und Ihre Datenstruktur zu verstehen. Alle Verarbeitung erfolgt clientseitig für maximale Sicherheit und Datenschutz.</p>
HTML;
$features = [
    'JSON formatieren und verschönern',
    'JSON-Syntax validieren mit detaillierten Fehlermeldungen',
    'JSON minimieren/komprimieren',
    'Baumanzeige mit erweiterbaren/zusammenklappbaren Knoten',
    'Anpassbare Einrückung (2 oder 4 Leerzeichen)',
    'Datentyp-Hervorhebung',
    'Mit einem Klick in die Zwischenablage kopieren',
    '100% clientseitige Verarbeitung - Ihre Daten bleiben privat'
];
$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>JSON-Formatierungsoptionen</h2>
    <ul class="mb-0">
        <li>Verschönern: Fügt Einrückung und Zeilenumbrüche für Lesbarkeit hinzu</li>
        <li>Minimieren: Entfernt alle Leerzeichen, um die Dateigröße zu reduzieren</li>
        <li>Baumansicht: Visualisiert JSON-Struktur mit interaktiven Knoten</li>
        <li>Validieren: Überprüft auf Syntaxfehler und zeigt genaue Fehlerstellen an</li>
    </ul>
HTML;
$additionalSections = [[
    'title' => 'Häufige Anwendungsfälle',
    'content' => <<<HTML
<ul>
    <li>API-Entwicklung: API-Antworten formatieren und debuggen</li>
    <li>Konfigurationsdateien: JSON-Konfigurationen validieren und formatieren</li>
    <li>Datenanalyse: JSON-Datenstrukturen verstehen</li>
    <li>Debugging: Syntaxfehler in JSON-Daten finden</li>
    <li>Dokumentation: Lesbare JSON-Beispiele erstellen</li>
    <li>Datenmigration: JSON-Daten vor der Übertragung überprüfen</li>
</ul>
HTML
]];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/JavaScript_Object_Notation',
        'title' => 'Wikipedia: JSON',
        'description' => 'Einsteigerfreundliche Einführung in JSON-Konzepte und Verwendung'
    ],
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404: JSON Datenaustausch-Syntax',
        'description' => 'Offizielle JSON-Spezifikation von ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259: JavaScript Object Notation (JSON)',
        'description' => 'IETF-Standard für das JSON-Datenformat'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'MDN JSON-Objekt Referenz',
        'description' => 'Vollständige Anleitung zu JSON.parse() und JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'JSON Schema Spezifikation',
        'description' => 'Offizielle Dokumentation zur Validierung von JSON-Struktur und Datentypen'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
