<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    Calcola le dimensioni mancanti, mantieni i rapporti d'aspetto e genera CSS per media responsive. 
    Essenziale per immagini, video e layout responsive.
</p>
<p class="mb-0">
    Il rapporto d'aspetto descrive la relazione proporzionale tra larghezza e altezza. Questo strumento ti aiuta 
    a calcolare le dimensioni, convertire tra formati di rapporto e generare codice CSS per mantenere 
    i rapporti d'aspetto nei design responsive.
</p>
HTML;

$features = [
    'Calcolare larghezza o altezza mancante dal rapporto d\'aspetto',
    'Preset di rapporti comuni (16:9, 4:3, 21:9, 1:1, ecc.)',
    'Generatore del trucco CSS padding-bottom',
    'Formati di rapporto multipli (rapporto, decimale, percentuale)',
    'Calcolatore di dimensioni per immagini responsive',
    'Calcolo in tempo reale',
    'Elaborazione 100% lato client'
];
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Calcolatore di dimensioni immagine responsive</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Calcolo in tempo reale</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Elaborazione 100% lato client</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Rapporti d'Aspetto Comuni</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Video HD standard, YouTube, schermi moderni</li>
        <li><strong>4:3</strong> — TV classica, monitor più vecchi</li>
        <li><strong>21:9</strong> — Monitor ultrawide, cinematografico</li>
        <li><strong>1:1</strong> — Quadrato (post Instagram)</li>
        <li><strong>9:16</strong> — Video verticale (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'Uso Comuni',
        'content' => <<<HTML
<ul>
    <li><strong>Immagini Responsive:</strong> Mantenere il rapporto d'aspetto durante il ridimensionamento delle immagini</li>
    <li><strong>Incorporamenti Video:</strong> Calcolare le dimensioni iframe per YouTube, Vimeo</li>
    <li><strong>Rapporto d'Aspetto CSS:</strong> Generare il trucco padding-bottom per browser più vecchi</li>
    <li><strong>Ridimensionamento Immagine:</strong> Calcolare le dimensioni di ritaglio o ridimensionamento</li>
    <li><strong>Design di Layout:</strong> Pianificare layout a griglia responsive</li>
</ul>
HTML
    ],
    [
        'title' => 'Tecniche CSS di Rapporto d\'Aspetto',
        'content' => <<<HTML
<p><strong>Approccio moderno (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Approccio legacy (trucco padding-bottom):</strong></p>
<pre><code>.container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 = 9/16 = 56.25% */
}

.container > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}</code></pre>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://it.wikipedia.org/wiki/Aspect_ratio',
        'title' => 'Wikipedia: Aspect Ratio',
        'description' => 'Introduzione accessibile per principianti sui rapporti d\'aspetto in immagini e video'
    ],
    [
        'url' => 'https://developer.mozilla.org/it/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: Proprietà CSS aspect-ratio',
        'description' => 'Proprietà CSS moderna per mantenere i rapporti d\'aspetto'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2019/03/aspect-ratio-unit-css/',
        'title' => 'Smashing Magazine: Aspect Ratio in CSS',
        'description' => 'Guida completa per mantenere i rapporti d\'aspetto in CSS moderno'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Specifica ufficiale per CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'Nuova Proprietà CSS Aspect-Ratio',
        'description' => 'Guida Google web.dev sul trattamento moderno del rapporto d\'aspetto'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
