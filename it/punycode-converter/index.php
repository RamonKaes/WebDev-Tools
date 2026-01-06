<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Punycode</strong> è una codifica usata per rappresentare caratteri Unicode nei nomi di dominio
    utilizzando solo caratteri ASCII. Permette ai domini internazionalizzati (IDN) di funzionare con l'infrastruttura DNS esistente.
</p>
<p class="mb-0">
    Questo strumento implementa la RFC 3492 per convertire tra domini Unicode (münchen.de)
    e i loro equivalenti Punycode (xn--mnchen-3ya.de). Tutta la conversione avviene localmente nel browser.
</p>
HTML;

$features = [
    'Conversione bidirezionale: Unicode a Punycode e viceversa',
    'Rilevamento automatico: identifica il formato di input',
    'Conforme a RFC 3492: implementazione completa dello standard',
    'Elaborazione batch: converti più domini (una riga per dominio)',
    'Domini di esempio: carica casi reali per testare',
    'Conversione in tempo reale durante la digitazione'
];

$additionalSections = [
  [
    'title' => 'Come funziona Punycode',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode converte domini Unicode in ASCII usando una codifica speciale:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Dominio Unicode</h4>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Dominio Punycode</h4>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>Processo di codifica:</p>
<ol>
  <li>Estrae i caratteri ASCII (mnchen)</li>
  <li>Codifica posizioni e valori non-ASCII</li>
  <li>Aggiunge il prefisso <code>xn--</code> per indicare Punycode</li>
  <li>Appende le informazioni Unicode codificate (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  Tutti i domini Punycode iniziano con <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Domini internazionali comuni',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Lingua</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>Tedesco</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>Tedesco</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Russo</td></tr>
      <tr><td>东京.jp</td><td>xn--1lqs71d.jp</td><td>Giapponese</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Arabo</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Greco</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Casi d\'uso',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Registrazione domini</h3>
    <ul>
      <li>Convertire IDN per la registrazione DNS</li>
      <li>Verificare disponibilità</li>
      <li>Codificare domini in indirizzi email</li>
      <li>Generare certificati SSL</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Sviluppo web</h3>
    <ul>
      <li>Gestire URL in applicazioni</li>
      <li>Salvare domini in database</li>
      <li>Richieste API con IDN</li>
      <li>Internazionalizzazione (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3492',
        'title' => 'RFC 3492: Punycode',
        'description' => 'Specifica ufficiale IETF per la codifica Punycode'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN: nomi di dominio internazionalizzati',
        'description' => 'Panoramica sull\'implementazione e le politiche IDN'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Internationalized_domain_name',
        'title' => 'Wikipedia: domini internazionalizzati',
        'description' => 'Informazioni complete sui sistemi IDN'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org: convertitore Punycode',
        'description' => 'Esempi aggiuntivi e informazioni su Punycode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
