<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'characterReferenceTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    Esplora e cerca una raccolta completa di entità HTML, caratteri Unicode e simboli speciali.
    Trova i codici necessari per lo sviluppo web, dai simboli comuni agli operatori matematici ed emoji.
</p>
<p class="mb-0">
    Ogni carattere mostra entità HTML, codici decimale ed esadecimale, oltre alla rappresentazione Unicode.
    Clicca su qualsiasi formato per copiarlo istantaneamente negli appunti.
</p>
HTML;

$features = [
    'Oltre 2 231 entità HTML catalogate',
    'Navigazione per categorie',
    'Ricerca avanzata per nome o codice',
    'Formati multipli di copia',
    'Codici Unicode, decimali ed esadecimali affiancati',
    'Copia istantanea negli appunti'
];
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia con un solo clic</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'WHATWG HTML: riferimenti caratteri nominati',
        'description' => 'Specifica ufficiale delle entità con nome'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: entità HTML',
        'description' => 'Guida completa di entità e simboli in HTML'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'W3C: nomi di entità XML',
        'description' => 'Definizioni ufficiali di entità e mappature Unicode'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Tabelle Unicode',
        'description' => 'Mappe ufficiali pubblicate dal Consorzio Unicode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
