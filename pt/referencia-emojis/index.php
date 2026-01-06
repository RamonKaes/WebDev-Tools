<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$features = [
    'Centenas de emojis catalogados',
    'Filtro por categorias',
    'Busca por palavras-chave',
    'Informações Unicode detalhadas',
    'Cópia com um clique',
    'Categorias voltadas para desenvolvedores'
];

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Tabelas de emojis Unicode',
        'description' => 'Referência e documentação oficial do Consórcio Unicode'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Enciclopédia abrangente com significados e variações'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'Método JavaScript para criar strings a partir de code points Unicode'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
