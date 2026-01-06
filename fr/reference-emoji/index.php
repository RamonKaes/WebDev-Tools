<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$features = [
    'Des centaines d\'emojis',
    'Filtrage par catégorie',
    'Recherche par mots-clés',
    'Informations Unicode',
    'Copie en un clic',
    'Catégories pensées pour les développeurs'
];

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Tableaux d\'emojis Unicode',
        'description' => 'Référence et documentation officielles du Consortium Unicode'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Encyclopédie exhaustive des emojis avec significations et variations selon les plateformes'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'Méthode JavaScript pour créer des chaînes à partir de points de code Unicode'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
