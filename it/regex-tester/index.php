<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'it';

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Test di espressioni regolari</h2>
<ul class="mb-0">
    <li>Motore JavaScript: il test utilizza il motore RegExp del browser</li>
    <li>Feedback in tempo reale: valida pattern su testi e vedi i risultati istantaneamente</li>
    <li>Privacy: tutto il processamento avviene localmente, senza invio a server</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN: guida alle espressioni regolari',
        'description' => 'Riferimento completo su regex in JavaScript da Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Tutorial approfondito e riferimenti per pattern e sintassi'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - pattern della community',
        'description' => 'Impara regex con migliaia di esempi condivisi'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - test e debug',
        'description' => 'Strumento avanzato con spiegazioni e visualizzazione di regex'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
