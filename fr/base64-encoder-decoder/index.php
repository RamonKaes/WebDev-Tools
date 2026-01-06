<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'fr';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Encodage et décodage de texte et de fichiers</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Prise en charge du glisser-déposer de fichiers</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Encodage Base64 compatible URL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mode temps réel</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Traitement multi-lignes</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Traitement côté client&nbsp;: vos données ne quittent jamais votre navigateur</li>
</ul>
HTML;

$additionalSections = [
  [
    'title' => 'Cas d\'utilisation courants',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Développement</h3>
    <ul>
      <li>Authentification API (Basic Auth)</li>
      <li>Décodage de jetons JWT</li>
      <li>URIs de données pour images</li>
      <li>Pièces jointes d'e-mails</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Transfert de données</h3>
    <ul>
      <li>Données binaires dans JSON</li>
      <li>Encodage de paramètres d'URL</li>
      <li>Valeurs de cookies</li>
      <li>Données binaires dans XML</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [        'url' => 'https://fr.wikipedia.org/wiki/Base64',
        'title' => 'Base64 - Wikipédia',
        'description' => 'Introduction au concept et à l\'histoire de l\'encodage Base64'
    ],
    [        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648&nbsp;: Encodages Base16, Base32 et Base64',
        'description' => 'Spécification officielle de l\'IETF qui définit la norme d\'encodage Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'Guide d\'encodage Base64 MDN',
        'description' => 'Guide complet sur l\'encodage Base64 en développement web'
    ],
  [
    'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
    'title' => 'MDN btoa()',
    'description' => 'Fonction JavaScript pour encoder des chaînes en Base64'
  ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob()',
        'description' => 'Fonction JavaScript pour décoder du Base64 en chaînes'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
