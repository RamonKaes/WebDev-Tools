<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'codeFormatterTool';
$lang = 'fr';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formatage HTML, CSS, JavaScript, XML, SQL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modes d'embellissement et de minification</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indentation personnalisable (2/4 espaces, tabulations)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Auto-formatage en temps réel</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Validation de la syntaxe</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Prise en charge de la copie et du téléchargement</li>
</ul>
HTML;

/*
$customNoticeContent = <<<HTML
<div class="alert alert-info" role="alert">
  <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Options de formatage</h2>
  <ul class="mb-0">
    <li>Embellir&nbsp;: rend le code plus lisible grâce à une indentation et des retours à la ligne corrects</li>
    <li>Minifier&nbsp;: supprime les espaces inutiles pour réduire la taille des fichiers</li>
    <li>Indentation&nbsp;: choisissez entre 2 espaces, 4 espaces ou des tabulations</li>
  </ul>
</div>
HTML;
*/

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Développement</h3>
    <ul>
      <li>Embellir du code minifié pour faciliter la lecture et le débogage</li>
      <li>Standardiser le formatage du code dans votre équipe</li>
      <li>Nettoyer du code désordonné ou généré automatiquement</li>
      <li>Formater le code avant de le valider dans le contrôle de version</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Production</h3>
    <ul>
      <li>Minifier le code pour réduire la taille des fichiers et améliorer le temps de chargement</li>
      <li>Préparer le code pour le déploiement</li>
      <li>Optimiser l'utilisation de la bande passante</li>
      <li>Améliorer les performances du site web</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/Common_questions/Tools_and_setup/What_are_browser_developer_tools',
        'title' => 'MDN : Outils de développement',
        'description' => 'Introduction accessible au formatage et au débogage de code'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
        'title' => 'Référence JavaScript MDN',
        'description' => 'Guide complet de la syntaxe JavaScript et des bonnes pratiques'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'Spécifications CSS du W3C',
        'description' => 'Standards CSS officiels et recommandations de formatage'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Spécification HTML actuelle et règles de syntaxe'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Spécification XML du W3C',
        'description' => 'Standard XML (Extensible Markup Language) officiel'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
