<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'characterReferenceTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Über 2.231 HTML-Entities',
    'Kategoriebasiertes Durchsuchen',
    'Leistungsstarke Suchfunktion',
    'Mehrere Kopierformate',
    'Unicode-, Dezimal-, Hex-Codes',
    'Ein-Klick-Kopie'
];

require_once __DIR__ . '/../../partials/tool-base.php';

$customAboutContent = <<<HTML
<p class="mb-2">
    Durchsuchen Sie eine umfassende Sammlung von HTML-Entities, Unicode-Zeichen und 
    Sondersymbolen. Finden Sie die Entity-Codes, die Sie für die Webentwicklung benötigen, 
    von gängigen Symbolen bis hin zu mathematischen Operatoren und Emojis.
</p>
<p class="mb-0">
    <i class="bi bi-lightbulb me-1"></i>
    <strong>Text konvertieren?</strong> Nutzen Sie unseren 
    <a href="' . getToolUrl('html-entity-encoder-decoder', 'de') . '">HTML Entity Encoder/Decoder</a>, 
    um HTML-Entities in großen Mengen zu kodieren oder dekodieren.
</p>
HTML;

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'WHATWG HTML Named Character References',
        'description' => 'Offizielle HTML-Spezifikation für benannte Zeichenentitäten'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN HTML Entities Referenz',
        'description' => 'Vollständiger Leitfaden zu HTML-Zeichenentitäten und Sonderzeichen'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'W3C XML Entity Definitions for Characters',
        'description' => 'Offizielle W3C Entity-Definitionen und Unicode-Mappings'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Unicode Character Code Charts',
        'description' => 'Offizielle Unicode Consortium Zeichenreferenz-Tabellen'
    ]
];
