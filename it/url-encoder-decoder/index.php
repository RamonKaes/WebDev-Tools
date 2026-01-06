<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'it';
$featuresSectionTitle = 'Funzionalità';
$resourcesSectionTitle = 'Risorse Utili';

$customAboutContent = <<<HTML
<p class="mb-2">
    La <strong>codifica URL</strong> (percent-encoding) converte i caratteri in un formato sicuro per la trasmissione sul web.
    I caratteri speciali sono sostituiti da "%" seguito da due cifre esadecimali.
</p>
<p class="mb-0">
    Tutto il processo avviene localmente nel browser, senza invio di dati a server esterni.
</p>
HTML;

$features = [
    'Codifica URL: encoding di URL complete e parametri di query',
    'Decodifica URL: converti percent-encoding in testo originale',
    'Componenti: codifica parti specifiche dell\'URL',
    'Batch: elabora più righe contemporaneamente',
    'Analisi: estrai protocollo, host, percorso e query string',
    'Rilevamento automatico: identifica quando codificare o decodificare'
];

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>encodeURI() vs encodeURIComponent()
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> codifica l\'intera URL, preservando caratteri speciali come <code>:</code>, <code>/</code>, <code>?</code> e <code>&</code>.<br>
    <strong>encodeURIComponent()</strong> codifica tutti i caratteri speciali, ideale per parametri individuali.
  </p>
';

$additionalSections = [
  [
    'title' => 'Casi d\'uso comuni',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Codifica</h3>
    <ul>
      <li>Valori di parametri in URL</li>
      <li>Invio dati da moduli</li>
      <li>Parametri in richieste API</li>
      <li>Condividere link con caratteri speciali</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Decodifica</h3>
    <ul>
      <li>Leggere URL codificate</li>
      <li>Debug di risposte API</li>
      <li>Interpretare query string</li>
      <li>Estrarre componenti di URL</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://web.dev/articles/url-parts',
        'title' => 'Web.dev: Parti dell\'URL',
        'description' => 'Guida accessibile sui componenti e sulla codifica degli URL'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986: sintassi URI',
        'description' => 'Specifica ufficiale per sintassi e codifica degli URI'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'Funzione JavaScript per codificare componenti URL'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'Funzione JavaScript per decodificare componenti URL'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738: URL',
        'description' => 'Specifica originale per sintassi e regole di codifica'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
