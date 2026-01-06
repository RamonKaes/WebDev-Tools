<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jsonFormatterValidator';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$customAboutContent = <<<HTML
<p class="mb-2">
    Formate, valide e embeleze dados JSON com um conjunto completo de ferramentas.
    Ideal para quem trabalha com APIs, arquivos de configuração e estruturas de dados complexas.</p>
<p class="mb-0">
    O analisador verifica a sintaxe, aplica indentação consistente e destaca erros com mensagens claras.
    Tudo acontece no seu navegador para manter os dados privados.</p>
HTML;

$features = [
    'Formatação e prettify com indentação de 2 ou 4 espaços',
    'Validação sintática com mensagens detalhadas',
    'Minificação de JSON para reduzir tamanho',
    'Validação em tempo real',
    'Detecção de erros linha a linha',
    'Cópia do resultado com um clique',
    'Destaque visual dos erros',
    'Processamento 100% local'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Modos de formatação JSON</h2>
<ul class="mb-0">
    <li>Beautify (2 espaços): formato compacto e padronizado</li>
    <li>Beautify (4 espaços): foco em leitura e revisão</li>
    <li>Minify: remove espaçamentos para obter JSON enxuto</li>
    <li>Validate: verifica apenas a sintaxe sem alterar o formato</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Desenvolvimento de APIs: formatar respostas para leitura rápida</li>
    <li>Configurações: validar arquivos JSON antes de publicar</li>
    <li>Inspeção de dados: examinar estruturas complexas</li>
    <li>Depuração: identificar erros de sintaxe</li>
    <li>Code review: manter um estilo consistente</li>
    <li>Migração de dados: garantir JSON válido antes de importar</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/JSON',
        'title' => 'Wikipedia: JSON',
        'description' => 'Introdução acessível aos conceitos e uso do JSON'
    ],
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404: JSON Data Interchange Syntax',
        'description' => 'Especificação oficial do formato JSON publicada pela ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259: JSON (JavaScript Object Notation)',
        'description' => 'Padrão IETF que define a notação JSON'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'MDN: referência do objeto JSON',
        'description' => 'Guia completo sobre JSON.parse() e JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'Especificação JSON Schema',
        'description' => 'Documentação oficial para validar estrutura e tipos usando JSON Schema'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
