<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'uuidGeneratorTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera identificatori univoci (UUID/GUID) istantaneamente per applicazioni, database e API.
    Supporta più versioni di UUID con generazione crittograficamente sicura.
</p>
<p class="mb-0">
    Gli UUID (Universally Unique Identifier) sono valori a 128 bit usati per identificare informazioni senza collisioni.
    Questo strumento genera UUID conformi agli standard, garantendo unicità su scala globale.
</p>
HTML;

$features = [
    'Generazione UUID v4 (casuale) con sicurezza crittografica',
    'Generazione batch: crea più UUID contemporaneamente',
    'Formati: standard, maiuscolo, senza trattini',
    'Copia UUID individualmente o tutti insieme',
    'Conformità RFC 4122',
    'Nessuna chiamata al server: 100% lato client',
    'Generazione istantanea senza latenza'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Informazioni su UUID versione 4</h2>
    <p class="mb-2">
        UUID v4 utilizza numeri casuali. Il formato è:
    </p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">
        Dove <code>x</code> è qualsiasi cifra esadecimale e <code>y</code> è 8, 9, A o B.
        La cifra 4 indica la versione dell'UUID e i bit variant garantiscono conformità RFC.
        Con 122 bit casuali, la probabilità di collisione è estremamente bassa.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Chiavi primarie: identificatori univoci in database</li>
    <li>ID di richiesta: tracciare chiamate API</li>
    <li>Token di sessione: generare identificatori sicuri</li>
    <li>Nomi di file: evitare conflitti nel salvataggio file</li>
    <li>Sistemi distribuiti: generare ID senza coordinamento centrale</li>
    <li>Transazioni: identificare operazioni finanziarie o di business</li>
</ul>
HTML
    ],
    [
        'title' => 'Formato UUID',
        'content' => <<<HTML
<p>Un UUID è rappresentato da 32 caratteri esadecimali in 5 gruppi:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Esempio: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Formato standard: minuscole con trattini (più comune)</li>
    <li>Formato maiuscolo: maiuscole con trattini (alcune API lo richiedono)</li>
    <li>Formato compatto: 32 caratteri senza trattini</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122: UUID',
        'description' => 'Specifica ufficiale per formato e generazione UUID'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562: UUID v6, v7 e v8',
        'description' => 'Standard recenti per nuove versioni di UUID'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'API del browser per generare UUID sicuri'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Universally_unique_identifier',
        'title' => 'UUID - Wikipedia',
        'description' => 'Panoramica e applicazioni delle diverse versioni UUID'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
