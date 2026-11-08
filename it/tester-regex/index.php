<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$features = [
    'Ricerca di pattern con risultati evidenziati',
    'Flag regex g, i, m, s, u e y',
    'Evidenziazione delle corrispondenze con gruppi di cattura',
    'Informazioni dettagliate e statistiche',
    'Copia e scarica i risultati',
    'Elaborazione 100% lato client'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h2 class="h6 fw-semibold alert-heading mb-3"><i class="bi bi-info-circle me-2"></i>Test di espressioni regolari</h2>
<ul class="mb-0">
    <li>Motore JavaScript: il test utilizza il motore RegExp del browser</li>
    <li>Feedback immediato: prova i pattern su un testo e vedi i risultati con un clic</li>
    <li>Privacy: tutta l'elaborazione avviene localmente, senza alcun invio a server</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://it.wikipedia.org/wiki/Espressione_regolare',
        'title' => 'Wikipedia: Espressione regolare',
        'description' => 'Introduzione accessibile alle espressioni regolari'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN: guida alle espressioni regolari',
        'description' => 'Riferimento completo di Mozilla sulle regex in JavaScript'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Tutorial approfonditi e riferimenti su pattern e sintassi'
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
