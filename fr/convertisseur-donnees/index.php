<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'dataConverterTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$features = [
    'Conversion JSON, XML, YAML, CSV',
    'Conversion bidirectionnelle entre formats',
    'Conversion d\'horodatages Unix en dates',
    'Formatage de sortie personnalisable',
    'Mode de conversion automatique en direct',
    'Options de délimiteur CSV'
];

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Développement d'API</h3>
    <ul>
      <li>Convertir les réponses d'API entre formats</li>
      <li>Transformer des fichiers de configuration</li>
      <li>Analyser des valeurs d'horodatage</li>
      <li>Exporter des données pour différents systèmes</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Migration de données</h3>
    <ul>
      <li>Convertir des exports de bases de données</li>
      <li>Transformer des formats hérités</li>
      <li>Préparer des données pour l'import/export</li>
      <li>Normaliser les formats d'horodatage</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/S%C3%A9rialisation',
        'title' => 'Wikipedia&nbsp;: Sérialisation',
        'description' => 'Introduction accessible aux formats de sérialisation de données'
    ],
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - Présentation de JSON',
        'description' => 'Spécification officielle et documentation du format JSON'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'Spécification YAML',
        'description' => 'Spécification officielle du format YAML et exemples'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Spécification XML du W3C',
        'description' => 'Standard officiel du langage XML (Extensible Markup Language)'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180&nbsp;: Spécification du format CSV',
        'description' => 'Spécification officielle pour le format Comma-Separated Values (CSV)'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
