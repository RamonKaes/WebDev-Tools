<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'it';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Centinaia di emoji catalogati</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Filtro per categorie</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Ricerca per parole chiave</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Informazioni Unicode dettagliate</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Categorie orientate agli sviluppatori</li>
</ul>
HTML;

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
