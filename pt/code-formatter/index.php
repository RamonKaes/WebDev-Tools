<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'codeFormatterTool';
$lang = 'pt';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formatação para HTML, CSS, JavaScript, XML e SQL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modos beautify e minify</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indentação personalizável (2/4 espaços ou tabulações)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formatação automática em tempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Validação de sintaxe</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Suporte para copiar e baixar</li>
</ul>
HTML;

/*
$customNoticeContent = <<<HTML
<div class="alert alert-info" role="alert">
  <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Opções de formatação</h2>
  <ul class="mb-0">
    <li>Beautify: deixa o código mais legível com indentação e quebras de linha adequadas</li>
    <li>Minify: remove espaços desnecessários para reduzir o tamanho do arquivo</li>
    <li>Indentação: escolha entre 2 espaços, 4 espaços ou tabulações</li>
  </ul>
</div>
HTML;
*/

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desenvolvimento</h3>
    <ul>
      <li>Tornar código minificado legível para depuração</li>
      <li>Padronizar a formatação entre membros da equipe</li>
      <li>Limpar código desorganizado ou gerado automaticamente</li>
      <li>Formatar antes de enviar ao controle de versão</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Produção</h3>
    <ul>
      <li>Minificar para reduzir o tamanho dos arquivos e melhorar o carregamento</li>
      <li>Preparar o código para deployment</li>
      <li>Otimizar o uso de banda</li>
      <li>Melhorar o desempenho do site</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/Common_questions/Tools_and_setup/What_are_browser_developer_tools',
        'title' => 'MDN: Ferramentas de desenvolvimento',
        'description' => 'Introdução acessível à formatação e depuração de código'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
        'title' => 'Referência JavaScript da MDN',
        'description' => 'Guia completo sobre sintaxe JavaScript e boas práticas'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'Especificações CSS do W3C',
        'description' => 'Padrões oficiais de CSS e diretrizes de formatação'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Especificação HTML atual e regras de sintaxe'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Especificação XML do W3C',
        'description' => 'Padrão oficial para o formato XML'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
