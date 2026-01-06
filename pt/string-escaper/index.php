<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'pt';

$customAboutContent = <<<HTML
<p class="mb-2">
    O <strong>Escape de Strings</strong> ajuda a escapar e reverter strings para formatos como HTML, XML, JavaScript, JSON, SQL e CSV.
    Ideal para desenvolvedores que precisam adaptar dados de texto a diferentes contextos com segurança.
</p>
<p class="mb-0">
    Todo o processamento acontece localmente no navegador – nenhum dado é enviado para servidores externos.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape HTML/XML – codifica caracteres especiais como &lt;, &gt;, &amp;</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JavaScript – trata aspas, quebras de linha e caracteres especiais</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JSON – aplica a sintaxe correta para strings JSON</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape SQL – ajuda a prevenir injeção de SQL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape CSV – lida com aspas e delimitadores</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento 100% local (foco em privacidade)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie o resultado com um clique</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Segurança</h3>
    <ul>
      <li>Prevenir XSS com escape HTML</li>
      <li>Reduzir risco de injeção SQL</li>
      <li>Saída segura de strings em JavaScript</li>
      <li>Proteger dados em APIs JSON</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Processamento de dados</h3>
    <ul>
      <li>Exportar CSV com escape adequado</li>
      <li>Sanitizar conteúdo HTML/XML</li>
      <li>Criar literais de string em JavaScript</li>
      <li>Preparar consultas para banco de dados</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/Caractere_de_escape',
        'title' => 'Wikipedia: Caractere de escape',
        'description' => 'Introdução acessível a caracteres e sequências de escape'
    ],
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP XSS Prevention Cheat Sheet',
        'description' => 'Guia completo para prevenir ataques de Cross-Site Scripting'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'Referência de String da MDN',
        'description' => 'Documentação completa sobre strings e escape em JavaScript'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP SQL Injection Prevention',
        'description' => 'Boas práticas para evitar injeção SQL'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5 String Escaping',
        'description' => 'Especificação oficial para escape de strings em HTML'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
