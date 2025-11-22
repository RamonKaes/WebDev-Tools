<?php

declare(strict_types=1);

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
        'url' => 'https://unicode.org/emoji/charts/full-emoji-list.html',
        'title' => 'Liste complète des emojis Unicode',
        'description' => 'Référence complète des emojis publiée par le Consortium Unicode'
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
    ],
    [
        'url' => 'https://www.w3.org/TR/emoji/',
        'title' => 'Exigences W3C pour les emojis',
        'description' => 'Spécifications techniques pour l\'implémentation des emojis dans les standards web'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
