<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'dataConverterTool';
$lang = 'it';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversione tra JSON, XML, YAML e CSV</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversioni bidirezionali</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversione di timestamp Unix in date leggibili</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formattazione personalizzabile dell\'output</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modalità di conversione automatica in tempo reale</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Opzioni per il delimitatore CSV</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sviluppo API</h3>
    <ul>
      <li>Convertire risposte API tra diversi formati</li>
      <li>Trasformare file di configurazione</li>
      <li>Analizzare valori di timestamp</li>
      <li>Esportare dati per altri sistemi</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Migrazione dati</h3>
    <ul>
      <li>Convertire esportazioni di database</li>
      <li>Trasformare formati legacy</li>
      <li>Preparare dati per import/export</li>
      <li>Normalizzare formati temporali</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - introduzione a JSON',
        'description' => 'Specifiche ufficiali e documentazione del formato JSON'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'Specifiche YAML',
        'description' => 'Documentazione ufficiale del formato YAML con esempi'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Specifiche XML W3C',
        'description' => 'Standard ufficiale per il linguaggio XML'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: specifica del formato CSV',
        'description' => 'Definizione ufficiale del formato Comma-Separated Values'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
