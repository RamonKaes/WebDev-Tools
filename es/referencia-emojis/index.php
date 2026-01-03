<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'es';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cientos de emojis disponibles</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Filtrado por categorías</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Búsqueda por palabras clave</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Información Unicode detallada</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copiar en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Categorías enfocadas para desarrolladores</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/full-emoji-list.html',
        'title' => 'Lista completa de emojis de Unicode',
        'description' => 'Referencia oficial de emojis publicada por el Consorcio Unicode'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Enciclopedia con significados y variaciones de cada emoji'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'Método de JavaScript para crear cadenas a partir de puntos de código Unicode'
    ],
    [
        'url' => 'https://www.w3.org/TR/emoji/',
        'title' => 'Requisitos W3C para emojis',
        'description' => 'Especificaciones técnicas para implementar emojis en la Web'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
