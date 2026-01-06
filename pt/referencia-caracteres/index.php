<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'characterReferenceTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$customAboutContent = <<<HTML
<p class="mb-2">
    Explore e pesquise uma coleção completa de entidades HTML, caracteres Unicode e símbolos especiais.
    Encontre os códigos necessários para projetos web, desde símbolos comuns até operadores matemáticos e emoji.
</p>
<p class="mb-0">
    Cada caractere apresenta entidade HTML, códigos decimal e hexadecimal, além da representação Unicode.
    Clique em qualquer formato para copiar instantaneamente para a área de transferência.
</p>
HTML;

$features = [
    'Mais de 2 231 entidades HTML catalogadas',
    'Navegação por categorias',
    'Busca avançada por nome ou código',
    'Múltiplos formatos de cópia',
    'Códigos Unicode, decimal e hexadecimal lado a lado',
    'Cópia com um único clique'
];

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'WHATWG HTML: referências de caracteres nomeados',
        'description' => 'Especificação oficial das entidades nomeadas'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: entidades HTML',
        'description' => 'Guia completo de entidades e símbolos em HTML'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'W3C: nomes de entidades XML',
        'description' => 'Definições oficiais de entidades e mapeamentos Unicode'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Tabelas Unicode',
        'description' => 'Mapas oficiais publicados pelo Consórcio Unicode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
