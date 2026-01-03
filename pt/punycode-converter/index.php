<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'pt';

$customAboutContent = '
  <p class="mb-2">
    <strong>Punycode</strong> é uma codificação usada para representar caracteres Unicode em nomes de domínio
    utilizando apenas ASCII. Isso permite que domínios internacionalizados (IDN) funcionem na infraestrutura DNS atual.
  </p>
  <p class="mb-0">
    Esta ferramenta implementa a RFC 3492 para converter entre domínios Unicode (münchen.de)
    e seus equivalentes Punycode (xn--mnchen-3ya.de). Toda conversão ocorre localmente no navegador.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Conversão bidirecional: Unicode para Punycode e vice-versa</li>
    <li>Detecção automática: identifica o formato de entrada</li>
    <li>Compatível com RFC 3492: implementação completa do padrão</li>
    <li>Processamento em lote: converta vários domínios (uma linha por domínio)</li>
    <li>Domínios de exemplo: carregue casos reais para testar</li>
    <li>Conversão em tempo real: resultados enquanto você digita</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Como o Punycode funciona',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode converte domínios Unicode em ASCII usando uma codificação especial:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Domínio Unicode</h4>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Domínio Punycode</h4>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>Processo de codificação:</p>
<ol>
  <li>Extrai caracteres ASCII (mnchen)</li>
  <li>Codifica posições e valores não ASCII</li>
  <li>Adiciona o prefixo <code>xn--</code> indicando Punycode</li>
  <li>Anexa as informações codificadas do Unicode (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  Todo domínio Punycode começa com <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Domínios internacionais comuns',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Idioma</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>Alemão</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>Alemão</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Russo</td></tr>
      <tr><td>东京.jp</td><td>xn--1lqs71d.jp</td><td>Japonês</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Árabe</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Grego</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Casos de uso',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Registro de domínios</h3>
    <ul>
      <li>Converter IDNs para cadastro no DNS</li>
      <li>Verificar disponibilidade</li>
      <li>Codificar domínios em endereços de e-mail</li>
      <li>Gerar certificados SSL</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Desenvolvimento web</h3>
    <ul>
      <li>Tratar URLs em aplicações</li>
      <li>Armazenar domínios em banco de dados</li>
      <li>Fazer requisições a APIs com IDNs</li>
      <li>Internacionalização (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3492',
        'title' => 'RFC 3492: Punycode',
        'description' => 'Especificação oficial do IETF para Punycode'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN: Domínios internacionalizados',
        'description' => 'Visão geral da implementação e políticas de IDN'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Internationalized_domain_name',
        'title' => 'Wikipedia: Domínios internacionalizados',
        'description' => 'Informações completas sobre sistemas IDN'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org: Conversor Punycode',
        'description' => 'Exemplos adicionais e informações sobre Punycode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
