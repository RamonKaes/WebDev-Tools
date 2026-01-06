<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'hashGeneratorTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera hash crittografici per testo e file utilizzando molteplici algoritmi.
    Ideale per verificare l'integrità dei dati, gestire password e applicazioni di sicurezza.
</p>
<p class="mb-0">
    Lo strumento supporta algoritmi popolari come MD5, SHA-1, SHA-256, SHA-512 e altri.
    Tutti i calcoli vengono eseguiti localmente per garantire la massima privacy.
</p>
HTML;

$features = [
    'Più algoritmi: MD5, SHA-1, SHA-256, SHA-384, SHA-512',
    'Hash di testo e file',
    'Confronto di hash per la verifica',
    'Supporto HMAC con chiavi personalizzate',
    'Output maiuscolo o minuscolo',
    'Copia hash con un clic',
    'Generazione in tempo reale',
    'Elaborazione 100% lato client: i dati rimangono sul dispositivo'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Considerazioni sulla sicurezza</h2>
    <ul class="mb-0">
        <li>Preferisci SHA-256 o superiori: MD5 e SHA-1 non sono più sicuri</li>
        <li>Non usare hash semplici per le password: adotta bcrypt, scrypt o PBKDF2</li>
        <li>Aggiungi un salt: evita attacchi tramite rainbow table</li>
        <li>Confronta l'hash completo: non limitarti a porzioni della stringa</li>
        <li>Usa HMAC per l'autenticazione: garantisce integrità e autenticità dei dati</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Verifica integrità file: controllare che i download non siano stati alterati</li>
    <li>Gestione password: archiviare hash sicuri (usa almeno SHA-256)</li>
    <li>Deduplicazione dati: individuare file o contenuti duplicati</li>
    <li>Generazione checksum: creare somme di controllo per i dati</li>
    <li>Firme digitali: componente essenziale nei sistemi di firma</li>
    <li>Autenticazione API: generare firme HMAC per le richieste</li>
</ul>
HTML
    ],
    [
        'title' => 'Scelta dell\'algoritmo',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5: veloce ma vulnerabile (128 bit, collisioni note)</li>
    <li>SHA-1: deprecato per uso crittografico (160 bit)</li>
    <li>SHA-256: standard di settore per applicazioni sicure</li>
    <li>SHA-384: variante ad alta sicurezza</li>
    <li>SHA-512: massima robustezza (512 bit)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'Funzioni hash NIST',
        'description' => 'Documentazione ufficiale NIST sugli algoritmi di hash'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Secure_Hash_Algorithms',
        'title' => 'Secure Hash Algorithms (SHA)',
        'description' => 'Panoramica completa della famiglia SHA e del loro stato di sicurezza'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'Documentazione dell\'API browser per calcolare digest crittografici'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP: storage delle password',
        'description' => 'Linee guida per l\'hashing e la conservazione sicura delle password'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
