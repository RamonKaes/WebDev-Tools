<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'fr';

$customAboutContent = '
  <p class="mb-2">
    <strong>L\'encodage d\'URL</strong> (ou encodage pourcentage) convertit des caractères en un format transmissible sur Internet.
    Les caractères spéciaux sont remplacés par "%" suivi de deux chiffres hexadécimaux.
  </p>
  <p class="mb-0">
    Tous les encodages et décodages s\'effectuent localement dans votre navigateur. Aucune donnée n\'est envoyée à un serveur,
    garantissant une confidentialité et une sécurité totales.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Encodage d\'URL&nbsp;: encodez des URL et paramètres de requête</li>
    <li>Décodage d\'URL&nbsp;: décodez des URL encodées en pourcentage</li>
    <li>Encodage de composants&nbsp;: encodez des segments individuels d\'URL</li>
    <li>Traitement en masse&nbsp;: encodez/décodez plusieurs lignes en une fois</li>
    <li>Analyse d\'URL&nbsp;: extrayez protocole, hôte, chemin et chaîne de requête</li>
    <li>Détection automatique&nbsp;: reconnaît automatiquement les besoins d\'encodage</li>
  </ul>
';

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>Encodage d\'URL vs encodage de composant
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> encode l\'URL complète tout en préservant des caractères spéciaux comme <code>:</code>, <code>/</code>, <code>?</code> et <code>&amp;</code>.<br>
    <strong>encodeURIComponent()</strong> encode tous les caractères spéciaux, idéal pour les paramètres de requête.
  </p>
';

$additionalSections = [
  [
    'title' => 'Cas d\'utilisation courants',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Encodage d'URL</h3>
    <ul>
      <li>Valeurs de paramètres de requête</li>
      <li>Soumission de formulaires</li>
      <li>Paramètres de requêtes API</li>
      <li>URLs partageables avec caractères spéciaux</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Décodage d'URL</h3>
    <ul>
      <li>Lecture d'URL encodées</li>
      <li>Débogage de réponses API</li>
      <li>Analyse des chaînes de requête</li>
      <li>Extraction des composants d'URL</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986&nbsp;: syntaxe des URI',
        'description' => 'Spécification officielle de la syntaxe et de l\'encodage des URI'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'Fonction JavaScript pour encoder des composants d\'URL'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'Fonction JavaScript pour décoder des composants d\'URL'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738&nbsp;: Localisateurs de ressources uniformes (URL)',
        'description' => 'Spécification originelle de la syntaxe et des règles d\'encodage des URL'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
