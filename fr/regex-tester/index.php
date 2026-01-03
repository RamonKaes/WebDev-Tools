<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'fr';

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Test des expressions régulières</h2>
<ul class="mb-0">
    <li>Moteur JavaScript&nbsp;: cet outil utilise le moteur RegExp de JavaScript pour tester les motifs</li>
    <li>Tests en direct&nbsp;: évaluez vos motifs sur du texte réel avec un retour visuel instantané</li>
    <li>Confidentialité&nbsp;: tous les tests se déroulent localement dans votre navigateur, aucune donnée n'est envoyée</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'Guide MDN sur les expressions régulières',
        'description' => 'Guide complet des expressions régulières en JavaScript par Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Tutoriel approfondi et référence pour la syntaxe et les motifs regex'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - motifs de la communauté',
        'description' => 'Apprenez les regex avec des milliers d\'exemples partagés'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - testeur et débogueur',
        'description' => 'Tests avancés d\'expressions régulières avec explications et visualisations'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
