<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'pt';

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Teste de expressões regulares</h2>
<ul class="mb-0">
    <li>Engine JavaScript: o teste utiliza o motor RegExp do navegador</li>
    <li>Feedback em tempo real: valide padrões contra textos e veja o resultado imediatamente</li>
    <li>Privacidade: todo o processamento acontece localmente, sem envio a servidores</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN: guia de expressões regulares',
        'description' => 'Referência completa sobre regex em JavaScript pela Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Tutorial aprofundado e referência de padrões e sintaxe'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - padrões da comunidade',
        'description' => 'Aprenda regex com milhares de exemplos compartilhados'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - testes e depuração',
        'description' => 'Ferramenta avançada com explicações e visualização de regex'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
