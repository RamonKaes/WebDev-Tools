<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'dataConverterTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$features = [
    'Conversão entre JSON, XML, YAML e CSV',
    'Conversões bidirecionais',
    'Conversão de timestamp Unix em datas legíveis',
    'Formatação personalizável da saída',
    'Modo de conversão automática em tempo real',
    'Opções de delimitador para CSV'
];

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desenvolvimento de APIs</h3>
    <ul>
      <li>Converter respostas de API entre diferentes formatos</li>
      <li>Transformar arquivos de configuração</li>
      <li>Interpretar valores de timestamp</li>
      <li>Exportar dados para outros sistemas</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Migração de dados</h3>
    <ul>
      <li>Converter exportações de banco de dados</li>
      <li>Transformar formatos legados</li>
      <li>Preparar dados para importação e exportação</li>
      <li>Normalizar formatos de tempo</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/Serializa%C3%A7%C3%A3o',
        'title' => 'Wikipedia: Serialização',
        'description' => 'Introdução acessível aos formatos de serialização de dados'
    ],
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - introdução ao JSON',
        'description' => 'Especificação oficial e documentação do formato JSON'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'Especificação YAML',
        'description' => 'Documentação oficial do formato YAML com exemplos'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Especificação XML do W3C',
        'description' => 'Padrão oficial para a linguagem XML'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: especificação do formato CSV',
        'description' => 'Definição oficial para o formato Comma-Separated Values'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
