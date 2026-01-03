<?php

declare(strict_types=1);

$toolId = 'qrCodeGeneratorTool';
$lang = 'it';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera codici QR istantaneamente per URL, testo, informazioni di contatto e altro.
    Personalizza colori, dimensione e livello di correzione errori.
</p>
<p class="mb-0">
    I codici QR (Quick Response) sono codici a barre bidimensionali capaci di memorizzare vari tipi di dati
    e possono essere scansionati da smartphone e lettori dedicati. La generazione avviene interamente nel browser,
    senza inviare dati a server esterni.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Genera QR code per URL, testo, numeri di telefono, email e altro</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Dimensione e qualità personalizzabili</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Colori personalizzati per sfondo e primo piano</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Livelli di correzione errori (L, M, Q, H)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Download come PNG o SVG</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anteprima in tempo reale</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generazione 100% lato client</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Livelli di correzione errori</h2>
    <ul class="mb-0">
        <li>L (Low): ~7% di recupero – indicato per ambienti controllati</li>
        <li>M (Medium): ~15% di recupero – raccomandato per la maggior parte dei casi</li>
        <li>Q (Quartile): ~25% di recupero – maggiore tolleranza ai danni</li>
        <li>H (High): ~30% di recupero – massima affidabilità</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>URL di siti web: accesso rapido a siti da materiali stampati</li>
    <li>Informazioni di contatto: vCard per condivisione facile</li>
    <li>Credenziali Wi-Fi: condividi reti senza digitare password</li>
    <li>Informazioni prodotto: link a manuali o dettagli tecnici</li>
    <li>Biglietti per eventi: check-in digitale</li>
    <li>Link di pagamento: facilitare pagamenti istantanei</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015',
        'description' => 'Standard internazionale ufficiale per la simbologia QR code'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - informazioni ufficiali',
        'description' => 'Contenuto da DENSO WAVE, creatore del QR code'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'QRCode.js',
        'description' => 'Libreria JavaScript per generare QR code nel browser'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/QR_code',
        'title' => 'QR Code - Wikipedia',
        'description' => 'Panoramica completa su tecnologia e applicazioni QR code'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
