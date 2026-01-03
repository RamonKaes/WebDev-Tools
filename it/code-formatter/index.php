<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'codeFormatterTool';
$lang = 'it';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formattazione per HTML, CSS, JavaScript, XML e SQL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modalità beautify e minify</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indentazione personalizzabile (2/4 spazi o tabulazioni)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formattazione automatica in tempo reale</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Validazione della sintassi</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Supporto per copia e download</li>
</ul>
HTML;

/*
$customNoticeContent = <<<HTML
<div class="alert alert-info" role="alert">
  <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Opzioni di formattazione</h2>
  <ul class="mb-0">
    <li>Beautify: rende il codice più leggibile con rientri e interruzioni di riga</li>
    <li>Minify: rimuove gli spazi inutili per ridurre la dimensione del file</li>
    <li>Indentazione: scegli tra 2 spazi, 4 spazi o tabulazioni</li>
  </ul>
</div>
HTML;
*/

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sviluppo</h3>
    <ul>
      <li>Rendere leggibile codice minificato per debug e revisione</li>
      <li>Uniformare lo stile di formattazione nel team</li>
      <li>Pulire codice disordinato o generato automaticamente</li>
      <li>Formattare prima del commit nel controllo versione</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Produzione</h3>
    <ul>
      <li>Minificare per ridurre la dimensione dei file e migliorare i tempi di caricamento</li>
      <li>Preparare il codice per il deploy</li>
      <li>Ottimizzare l\'uso della banda</li>
      <li>Migliorare le prestazioni del sito</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
        'title' => 'Riferimento JavaScript MDN',
        'description' => 'Guida completa alla sintassi JavaScript e alle best practice'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'Specifiche CSS W3C',
        'description' => 'Standard ufficiali CSS e linee guida di formattazione'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Specifica HTML corrente e regole sintattiche'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Specifiche XML W3C',
        'description' => 'Standard ufficiale per il linguaggio XML'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
