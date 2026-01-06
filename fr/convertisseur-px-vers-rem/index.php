<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Convertissez rapidement et avec précision entre pixels (px) et unités rem.
    Indispensable pour le design web responsive et une typographie accessible.
</p>
<p class="mb-0">
    L'unité rem (root em) est relative à la taille de police de l'élément racine, ce qui la rend idéale
    pour créer des interfaces évolutives et accessibles. Cet outil vous aide à convertir des valeurs px en rem et inversement
    en fonction de votre taille de police de base.
</p>
HTML;

$features = [
    'Conversion px → rem et rem → px',
    'Taille de police de base personnalisable (par défaut : 16 px)',
    'Conversion en série : convertissez plusieurs valeurs en une fois',
    'Conversion en temps réel pendant la saisie',
    'Copie rapide des valeurs converties',
    'Préréglages pour les points de rupture courants',
    'Traitement 100 % côté client'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Pourquoi utiliser des unités rem&nbsp;?</h2>
    <ul class="mb-0">
        <li>Accessibilité&nbsp;: les utilisateurs peuvent ajuster la taille de police du navigateur</li>
        <li>Consistance&nbsp;: toutes les tailles évoluent proportionnellement</li>
        <li>Design responsive&nbsp;: maintenance facilitée pour différents écrans</li>
        <li>Bonne pratique&nbsp;: standard de l'industrie pour le développement moderne</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Typographie&nbsp;: convertir des tailles de police de px vers rem</li>
    <li>Espacements&nbsp;: transformer marges et paddings en rem</li>
    <li>Points de rupture responsive&nbsp;: définir des media queries en rem</li>
    <li>Taille des composants&nbsp;: faire évoluer les éléments d'interface proportionnellement</li>
    <li>Conformité accessibilité&nbsp;: respecter les recommandations WCAG</li>
</ul>
HTML
    ],
    [
        'title' => 'rem vs em vs px',
        'content' => <<<HTML
<ul>
    <li>px&nbsp;: unité absolue, taille fixe quel que soit le contexte</li>
    <li>em&nbsp;: relative à la taille de police du parent (peut se cumuler)</li>
    <li>rem&nbsp;: relative à la taille de police racine (cohérente)</li>
    <li>Recommandation&nbsp;: utilisez rem pour le dimensionnement global, em pour l'échelle locale</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [        'url' => 'https://fr.wikipedia.org/wiki/Cadratin',
        'title' => 'Wikipedia : Cadratin',
        'description' => 'Introduction accessible aux unités typographiques em et rem'
    ],
    [        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN&nbsp;: valeurs et unités CSS',
        'description' => 'Guide complet des unités CSS dont px, rem et em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Level&nbsp;3',
        'description' => 'Spécification officielle du W3C pour l\'unité rem'
    ],
    [
        'url' => 'https://moderncss.dev/generating-font-size-css-rules-and-creating-a-fluid-type-scale/',
        'title' => 'Modern CSS&nbsp;: règles de taille de police et échelle fluide',
        'description' => 'Guide complet sur les unités rem et la typographie fluide en CSS moderne'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixels vs unités relatives en CSS',
        'description' => 'Bénéfices en accessibilité de l\'utilisation des rem plutôt que des px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
