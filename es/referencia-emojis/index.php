<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$features = [
    'Cientos de emojis disponibles',
    'Filtrado por categorías',
    'Búsqueda por palabras clave',
    'Información Unicode detallada',
    'Copiar en un clic',
    'Categorías enfocadas para desarrolladores'
];

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Tablas de emojis Unicode',
        'description' => 'Referencia y documentación oficial de emojis del Consorcio Unicode'
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
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
