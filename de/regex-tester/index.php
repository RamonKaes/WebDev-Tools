<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Musterabgleich mit hervorgehobenen Treffern',
    'Regex-Flags g, i, m, s, u und y',
    'Treffer-Hervorhebung mit Erfassungsgruppen',
    'Detaillierte Treffer-Informationen und Statistiken',
    'Treffer kopieren und herunterladen',
    '100 % clientseitige Verarbeitung'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h2 class="h6 fw-semibold alert-heading mb-3"><i class="bi bi-info-circle me-2"></i>Reguläre Ausdrücke testen</h2>
<ul class="mb-0">
    <li>JavaScript-Engine: Dieses Tool nutzt die RegExp-Engine von JavaScript zum Testen von Mustern</li>
    <li>Test per Klick: Klicken Sie auf „Muster testen“ oder drücken Sie Enter (Strg+Enter im Testtext), dann werden die Treffer hervorgehoben</li>
    <li>Datenschutz: Alle Tests erfolgen lokal in Ihrem Browser – es werden keine Daten an Server gesendet</li>
</ul>
HTML;


$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/Regul%C3%A4rer_Ausdruck',
        'title' => 'Wikipedia: Regulärer Ausdruck',
        'description' => 'Einsteigerfreundliche Einführung in reguläre Ausdrücke'
    ],
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN: Leitfaden zu regulären Ausdrücken',
        'description' => 'Umfassender Leitfaden zu regulären Ausdrücken in JavaScript von Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Ausführliches Tutorial und Referenz für Regex-Muster und Syntax'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr – Community-Muster',
        'description' => 'Regex lernen mit Tausenden von Mustern aus der Community'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 – Tester & Debugger',
        'description' => 'Fortgeschrittenes Regex-Testing mit Erklärung und Visualisierung'
    ]
];


include __DIR__ . '/../../partials/tool-base.php';
