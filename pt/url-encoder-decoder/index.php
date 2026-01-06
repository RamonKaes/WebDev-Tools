<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Codificação de URL</strong> (percent-encoding) converte caracteres em um formato seguro para transmissão na web.
    Caracteres especiais são substituídos por "%" seguido de dois dígitos hexadecimais.
</p>
<p class="mb-0">
    Todo o processo ocorre localmente no navegador, sem envio de dados a servidores externos.
</p>
HTML;

$features = [
    'Codificar URLs: encode de URLs completas e parâmetros de consulta',
    'Decodificar URLs: converta percent-encoding de volta ao texto original',
    'Componentes: codifique partes específicas da URL',
    'Lotes: processe múltiplas linhas de uma vez',
    'Análise: extraia protocolo, host, caminho e query string',
    'Detecção automática: identifica quando codificar ou decodificar'
];

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>encodeURI() vs encodeURIComponent()
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> codifica a URL inteira, preservando caracteres especiais como <code>:</code>, <code>/</code>, <code>?</code> e <code>&</code>.<br>
    <strong>encodeURIComponent()</strong> codifica todos os caracteres especiais, ideal para parâmetros individuais.
  </p>
';

$additionalSections = [
  [
    'title' => 'Casos de uso comuns',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Codificação</h3>
    <ul>
      <li>Valores de parâmetros em URLs</li>
      <li>Envio de dados de formulários</li>
      <li>Parâmetros em requisições de API</li>
      <li>Compartilhar links com caracteres especiais</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Decodificação</h3>
    <ul>
      <li>Ler URLs codificadas</li>
      <li>Depurar respostas de API</li>
      <li>Interpretar query strings</li>
      <li>Extrair componentes de URLs</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://web.dev/articles/url-parts',
        'title' => 'Web.dev: Partes da URL',
        'description' => 'Guia acessível sobre componentes e codificação de URL'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986: sintaxe de URI',
        'description' => 'Especificação oficial de sintaxe e codificação de URIs'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'Função JavaScript para codificar componentes de URL'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'Função JavaScript para decodificar componentes de URL'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738: URLs',
        'description' => 'Especificação original para sintaxe e regras de codificação'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
