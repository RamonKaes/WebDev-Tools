<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$features = [
    'Centinaia di emoji catalogati',
    'Filtro per categorie',
    'Ricerca per parole chiave',
    'Informazioni Unicode dettagliate',
    'Copia con un clic',
    'Categorie orientate agli sviluppatori'
];

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Tabelle emoji Unicode',
        'description' => 'Riferimento e documentazione ufficiali del Consorzio Unicode'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Enciclopedia completa con significati e variazioni'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'Metodo JavaScript per creare stringhe da code point Unicode'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
