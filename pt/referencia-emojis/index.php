<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'pt';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Centenas de emojis catalogados</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Filtro por categorias</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Busca por palavras-chave</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Informações Unicode detalhadas</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cópia com um clique</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Categorias voltadas para desenvolvedores</li>
</ul>
HTML;

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
