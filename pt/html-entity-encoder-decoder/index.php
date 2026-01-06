<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'pt';

$customAboutContent = '
  <p class="mb-2">
    <strong>Entidades HTML</strong> são representações especiais usadas para exibir caracteres reservados e símbolos
    sem causar problemas de interpretação no navegador.
    Elas garantem renderização correta em diferentes sistemas e codificações.
  </p>
  <p class="mb-0">
    A ferramenta oferece suporte a entidades nomeadas (&amp;nbsp;), numéricas decimais (&amp;#160;)
    e hexadecimais (&amp;#xA0;). Todas as conversões acontecem localmente no seu navegador.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Entidades nomeadas: converta para &amp;nbsp;, &amp;lt;, &amp;gt; e outras</li>
    <li>Entidades numéricas: formato decimal (&amp;#160;) ou hexadecimal (&amp;#xA0;)</li>
    <li>Bidirecional: codifique texto ou decodifique entidades</li>
    <li>Auto conversão: atualização em tempo real enquanto digita</li>
    <li>Referência de caracteres: acesso rápido à lista completa</li>
    <li>Download: salve o resultado em arquivo de texto</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Casos de uso comuns',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desenvolvimento HTML</h3>
    <ul>
      <li>Exibir código na página (&lt;, &gt;, &amp;)</li>
      <li>Caracteres especiais em atributos</li>
      <li>Símbolos de copyright e marca registrada</li>
      <li>Espaços não separáveis</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Processamento de dados</h3>
    <ul>
      <li>Conteúdo para feeds XML/RSS</li>
      <li>Criação de templates de e-mail</li>
      <li>Escape de dados salvos em banco</li>
      <li>Internacionalização (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Entidades importantes',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Caractere</th>
        <th>Entidade</th>
        <th>Decimal</th>
        <th>Hex</th>
        <th>Descrição</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Menor que</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Maior que</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>E comercial</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Aspas duplas</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Espaço não separável</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Marca registrada</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  Veja a lista completa na nossa <a href="../referencia-caracteres/">referência de caracteres</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: Entidades HTML',
        'description' => 'Guia acessível sobre entidades de caracteres HTML'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'HTML Standard: entidades nomeadas',
        'description' => 'Especificação WHATWG para entidades com nome'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: entidades HTML',
        'description' => 'Guia completo sobre uso de entidades em HTML'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C: uso de sequências de escape',
        'description' => 'Boas práticas para escapes em markup e CSS'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
