<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    L'<strong>Échappement de Chaînes</strong> vous aide à échapper et déséchapper des chaînes pour divers formats, notamment HTML, XML, JavaScript, JSON, SQL et CSV.
    Idéal pour les développeurs qui manipulent des chaînes devant être correctement échappées selon le contexte.
</p>
<p class="mb-0">
    Tout le traitement s'effectue côté client dans votre navigateur&nbsp;: vos données ne quittent pas votre appareil.
</p>
HTML;

$features = [
    'Échappement HTML/XML : encode les caractères spéciaux comme <, >, &',
    'Échappement JavaScript : gère guillemets, retours à la ligne et caractères spéciaux',
    'Échappement JSON : respect des chaînes JSON valides',
    'Échappement SQL : prévention des injections SQL',
    'Échappement CSV : gestion des guillemets et délimiteurs',
    'Traitement côté client (privacy-first)',
    'Copie en un clic'
];

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sécurité</h3>
    <ul>
      <li>Prévenir les attaques XSS via l'échappement HTML</li>
      <li>Prévention des injections SQL</li>
      <li>Sorties JavaScript sécurisées</li>
      <li>Protection des données dans les API JSON</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Traitement de données</h3>
    <ul>
      <li>Export CSV correctement échappé</li>
      <li>Sanitisation de contenu HTML/XML</li>
      <li>Littéraux de chaînes JavaScript</li>
      <li>Préparation des requêtes base de données</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/Caract%C3%A8re_d%27%C3%A9chappement',
        'title' => 'Wikipedia&nbsp;: Caractère d\'&eacute;chappement',
        'description' => 'Introduction accessible aux caractères et séquences d\'&eacute;chappement'
    ],
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP&nbsp;: prévention des attaques XSS',
        'description' => 'Guide complet pour prévenir les attaques Cross-Site Scripting'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'MDN&nbsp;: référence des chaînes JavaScript',
        'description' => 'Documentation complète sur les méthodes de chaînes et l\'échappement en JavaScript'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP&nbsp;: prévention des injections SQL',
        'description' => 'Bonnes pratiques pour éviter les vulnérabilités d\'injection SQL'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5&nbsp;: échappement des chaînes',
        'description' => 'Spécification officielle pour l\'échappement des chaînes en HTML'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
