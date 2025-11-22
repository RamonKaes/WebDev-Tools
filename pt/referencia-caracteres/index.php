<?php

declare(strict_types=1);

$toolId = 'characterReferenceTool';
$lang = 'pt';

$customAboutContent = '
  <p class="mb-2">
    Explore e pesquise uma coleção completa de entidades HTML, caracteres Unicode e símbolos especiais.
    Encontre os códigos necessários para projetos web, desde símbolos comuns até operadores matemáticos e emoji.
  </p>
  <p class="mb-0">
    Cada caractere apresenta entidade HTML, códigos decimal e hexadecimal, além da representação Unicode.
    Clique em qualquer formato para copiar instantaneamente para a área de transferência.
  </p>
';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mais de 2 231 entidades HTML catalogadas</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Navegação por categorias</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Busca avançada por nome ou código</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Múltiplos formatos de cópia</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Códigos Unicode, decimal e hexadecimal lado a lado</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cópia com um único clique</li>
</ul>
HTML;

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
