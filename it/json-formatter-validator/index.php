<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jsonFormatterValidator';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    Formattta, valida e abbellisce dati JSON con uno strumento completo.
    Perfetto per sviluppatori che lavorano con API, file di configurazione e strutture dati.</p>
<p class="mb-0">
    Lo strumento analizza il JSON, verifica la sintassi, applica un'indentazione pulita e fornisce messaggi di errore dettagliati.
    Tutto il processo avviene nel tuo browser per garantire la massima riservatezza.</p>
HTML;

$features = [
    'Formattazione e beautify con indentazione a 2 o 4 spazi',
    'Validazione sintattica con messaggi chiari',
    'Minificazione del JSON per ridurre la dimensione',
    'Validazione in tempo reale',
    'Rilevamento errori riga per riga',
    'Copia del risultato con un clic',
    'Evidenziazione chiara degli errori',
    'Elaborazione lato client: privacy garantita'
];
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Privacy garantita: tutto resta nel browser</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Opzioni di formattazione JSON</h2>
<ul class="mb-0">
    <li>Beautify (2 spazi): formato standard compatto</li>
    <li>Beautify (4 spazi): formato più leggibile</li>
    <li>Minify: rimuove tutti gli spazi per ottenere JSON compatto</li>
    <li>Validate: verifica la sintassi senza modificare il formato</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Sviluppo API: formattare le risposte per una lettura più chiara</li>
    <li>Configurazioni: validare e sistemare file JSON di configurazione</li>
    <li>Ispezione dati: esaminare rapidamente strutture complesse</li>
    <li>Debug: individuare errori di sintassi</li>
    <li>Code review: mantenere uno stile JSON coerente</li>
    <li>Migrazione dati: convalidare il JSON prima di importarlo</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://it.wikipedia.org/wiki/JSON',
        'title' => 'Wikipedia: JSON',
        'description' => 'Introduzione accessibile ai concetti e all\'uso del JSON'
    ],
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404: JSON Data Interchange Syntax',
        'description' => 'Specifiche ufficiali JSON pubblicate da ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259: JSON (JavaScript Object Notation)',
        'description' => 'Standard IETF che definisce il formato JSON'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'MDN JSON object reference',
        'description' => 'Guida completa su JSON.parse() e JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'JSON Schema Specification',
        'description' => 'Documentazione ufficiale per validare struttura e tipi dei dati JSON'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
