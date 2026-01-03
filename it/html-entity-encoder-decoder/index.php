<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'it';

$customAboutContent = '
  <p class="mb-2">
    <strong>Le entità HTML</strong> sono rappresentazioni speciali utilizzate per mostrare caratteri riservati e simboli
    senza causare problemi di parsing nel browser. Garantiscono un rendering corretto in diversi ambienti e codifiche.
  </p>
  <p class="mb-0">
    Questo strumento supporta entità nominali (&amp;nbsp;), numeriche decimali (&amp;#160;) ed esadecimali (&amp;#xA0;).
    Tutte le conversioni avvengono localmente nel tuo browser.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Entità nominali: converti in entità standard come &amp;nbsp;, &amp;lt;, &amp;gt;</li>
    <li>Entità numeriche: formato decimale (&amp;#160;) o esadecimale (&amp;#xA0;)</li>
    <li>Bidirezionale: codifica testo o decodifica entità</li>
    <li>Conversione automatica: trasformazione in tempo reale durante la digitazione</li>
    <li>Riferimento caratteri: collegamento rapido all\'intera lista di entità HTML</li>
    <li>Download: salva il risultato in un file di testo</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Casi d\'uso comuni',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sviluppo HTML</h3>
    <ul>
      <li>Mostrare codice in pagina (&lt;, &gt;, &amp;)</li>
      <li>Gestire caratteri speciali negli attributi</li>
      <li>Inserire simboli di copyright e trademark</li>
      <li>Utilizzare spazi non separabili</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Elaborazione dati</h3>
    <ul>
      <li>Contenuti per feed XML/RSS</li>
      <li>Creazione di template email</li>
      <li>Escape di contenuti salvati in database</li>
      <li>Internazionalizzazione (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Entità più comuni',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Carattere</th>
        <th>Entità nominativa</th>
        <th>Decimale</th>
        <th>Esa</th>
        <th>Descrizione</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Minore</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Maggiore</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>Ampersand</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Virgolette doppie</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Spazio non separabile</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Marchio registrato</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  Consulta l\'elenco completo nella nostra <a href="../riferimento-caratteri/">riferimento caratteri</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'Standard HTML: entità di caratteri nominali',
        'description' => 'Specifiche ufficiali WHATWG per le entità con nome'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: entità HTML',
        'description' => 'Guida completa all\'uso delle entità HTML'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C: utilizzo delle sequenze di escape',
        'description' => 'Best practice per l\'escape in markup e CSS'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
