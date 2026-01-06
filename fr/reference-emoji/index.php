<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'fr';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Des centaines d'emojis</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Filtrage par catégorie</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Recherche par mots-clés</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Informations Unicode</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Catégories pensées pour les développeurs</li>
</ul>
HTML;

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
