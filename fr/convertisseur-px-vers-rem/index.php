<?php

declare(strict_types=1);

$toolId = 'pxToRemConverter';
$lang = 'fr';

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

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversion px → rem et rem → px</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Taille de police de base personnalisable (par défaut&nbsp;: 16&nbsp;px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversion en série&nbsp;: convertissez plusieurs valeurs en une fois</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversion en temps réel pendant la saisie</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie rapide des valeurs converties</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Préréglages pour les points de rupture courants</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Traitement 100&nbsp;% côté client</li>
</ul>
HTML;

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
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN&nbsp;: valeurs et unités CSS',
        'description' => 'Guide complet des unités CSS dont px, rem et em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Level&nbsp;3',
        'description' => 'Spécification officielle du W3C pour l\'unité rem'
    ],
    [
        'url' => 'https://css-tricks.com/rems-ems/',
        'title' => 'CSS-Tricks&nbsp;: idée de taille de police',
        'description' => 'Bonnes pratiques pour utiliser rem dans un design responsive'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixels vs unités relatives en CSS',
        'description' => 'Bénéfices en accessibilité de l\'utilisation des rem plutôt que des px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
