<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Calculez les dimensions manquantes, maintenez les rapports d'aspect et générez du CSS pour les médias responsive. 
    Essentiel pour les images, vidéos et mises en page responsive.
</p>
<p class="mb-0">
    Le rapport d'aspect décrit la relation proportionnelle entre la largeur et la hauteur. Cet outil vous aide 
    à calculer les dimensions, convertir entre les formats de rapport et générer du code CSS pour maintenir 
    les rapports d'aspect dans les designs responsive.
</p>
HTML;

$features = [
    'Calculer la largeur ou hauteur manquante à partir du rapport d\'aspect',
    'Préréglages de rapports courants (16:9, 4:3, 21:9, 1:1, etc.)',
    'Générateur de l\'astuce CSS padding-bottom',
    'Formats de rapport multiples (rapport, décimal, pourcentage)',
    'Calculateur de tailles d\'image responsive',
    'Calcul en temps réel',
    'Traitement 100% côté client'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Rapports d'Aspect Courants</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Vidéo HD standard, YouTube, écrans modernes</li>
        <li><strong>4:3</strong> — TV classique, anciens moniteurs</li>
        <li><strong>21:9</strong> — Moniteurs ultra-larges, cinématographique</li>
        <li><strong>1:1</strong> — Carré (publications Instagram)</li>
        <li><strong>9:16</strong> — Vidéo verticale (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'Utilisation Courants',
        'content' => <<<HTML
<ul>
    <li><strong>Images Responsive:</strong> Maintenir le rapport d'aspect lors du redimensionnement des images</li>
    <li><strong>Intégrations Vidéo:</strong> Calculer les dimensions d'iframe pour YouTube, Vimeo</li>
    <li><strong>Rapport d'Aspect CSS:</strong> Générer l'astuce padding-bottom pour les anciens navigateurs</li>
    <li><strong>Redimensionnement d'Image:</strong> Calculer les dimensions de recadrage ou redimensionnement</li>
    <li><strong>Conception de Mise en Page:</strong> Planifier des mises en page de grille responsive</li>
</ul>
HTML
    ],
    [
        'title' => 'Techniques CSS de Rapport d\'Aspect',
        'content' => <<<HTML
<p><strong>Approche moderne (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Approche legacy (astuce padding-bottom):</strong></p>
<pre><code>.container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 = 9/16 = 56.25% */
}

.container > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}</code></pre>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/Format_d%27image',
        'title' => 'Wikipedia: Format d\'image',
        'description' => 'Introduction accessible pour débutants sur les rapports d\'aspect dans les images et vidéos'
    ],
    [
        'url' => 'https://developer.mozilla.org/fr/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: Propriété CSS aspect-ratio',
        'description' => 'Propriété CSS moderne pour maintenir les rapports d\'aspect'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2019/03/aspect-ratio-unit-css/',
        'title' => 'Smashing Magazine: Aspect Ratio en CSS',
        'description' => 'Guide complet pour maintenir les rapports d\'aspect en CSS moderne'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Spécification officielle pour CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'Nouvelle Propriété CSS Aspect-Ratio',
        'description' => 'Guide Google web.dev sur le traitement moderne du rapport d\'aspect'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
