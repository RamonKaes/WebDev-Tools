<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'it';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codifica e decodifica di testo e file</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Supporto drag & drop per i file</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codifica Base64 compatibile con gli URL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modalità in tempo reale</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Elaborazione multi-linea</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Elaborazione lato client: i dati non lasciano mai il browser</li>
</ul>
HTML;

$additionalSections = [
  [
    'title' => 'Casi d\'uso comuni',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sviluppo</h3>
    <ul>
      <li>Autenticazione API (Basic Auth)</li>
      <li>Decodifica di token JWT</li>
      <li>Data URI per immagini</li>
      <li>Allegati email</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Trasferimento dati</h3>
    <ul>
      <li>Dati binari in JSON</li>
      <li>Codifica dei parametri URL</li>
      <li>Valori di cookie</li>
      <li>Dati binari XML</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [        'url' => 'https://it.wikipedia.org/wiki/Base64',
        'title' => 'Base64 - Wikipedia',
        'description' => 'Introduzione al concetto e alla storia della codifica Base64'
    ],
    [        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648: codifiche Base16, Base32 e Base64',
        'description' => 'Specifiche ufficiali IETF che definiscono lo standard Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'Guida MDN alla codifica Base64',
        'description' => 'Panoramica completa sull\'uso di Base64 nello sviluppo web'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
        'title' => 'MDN btoa()',
        'description' => 'Funzione JavaScript per codificare stringhe in Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob()',
        'description' => 'Funzione JavaScript per decodificare stringhe Base64'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
