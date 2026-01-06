<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'pt';

$customAboutContent = <<<HTML
<p class="mb-2">
    Converta rapidamente entre pixels (px) e unidades rem.
    Essencial para design web responsivo e tipografia acessível.
</p>
<p class="mb-0">
    A unidade rem (root em) é relativa ao tamanho da fonte do elemento raiz, tornando-a ideal
    para criar interfaces escaláveis e acessíveis. Esta ferramenta ajuda você a converter valores de px em rem e vice-versa
    com base no tamanho de fonte definido.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversão px → rem e rem → px</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Tamanho de fonte base personalizável (padrão: 16 px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversão em lote: vários valores de uma vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Resultados em tempo real enquanto digita</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie os valores convertidos com um clique</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Predefinições de breakpoints mais comuns</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento 100% no navegador</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Por que usar unidades rem?</h2>
    <ul class="mb-0">
        <li>Acessibilidade: pessoas usuárias podem ajustar o tamanho da fonte no navegador</li>
        <li>Consistência: todas as medidas escalam proporcionalmente</li>
        <li>Design responsivo: facilita a manutenção em diferentes dispositivos</li>
        <li>Boa prática: padrão recomendado no desenvolvimento moderno</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Tipografia: converter tamanhos de fonte de px para rem</li>
    <li>Espaçamento: transformar margens e padding em rem</li>
    <li>Breakpoints: definir media queries em rem</li>
    <li>Tamanho de componentes: escalar itens de interface de forma uniforme</li>
    <li>Acessibilidade: cumprir diretrizes WCAG</li>
</ul>
HTML
    ],
    [
        'title' => 'rem vs em vs px',
        'content' => <<<HTML
<ul>
    <li>px: unidade absoluta, tamanho fixo independente do contexto</li>
    <li>em: relativo ao tamanho da fonte do elemento pai (pode se acumular)</li>
    <li>rem: relativo ao tamanho da fonte raiz (consistente)</li>
    <li>Recomendação: use rem para escalas globais e em para ajustes locais</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/Em_%28tipografia%29',
        'title' => 'Wikipedia: Em (tipografia)',
        'description' => 'Introdução acessível às unidades tipográficas em e rem'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN: valores e unidades CSS',
        'description' => 'Guia completo sobre unidades CSS, incluindo px, rem e em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Level 3',
        'description' => 'Especificação oficial do W3C para a unidade rem'
    ],
    [
        'url' => 'https://moderncss.dev/generating-font-size-css-rules-and-creating-a-fluid-type-scale/',
        'title' => 'Modern CSS: Regras de tamanho de fonte e escala fluida',
        'description' => 'Guia completo sobre unidades rem e tipografia fluida em CSS moderno'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixels vs. unidades relativas em CSS',
        'description' => 'Benefícios de acessibilidade ao preferir rem em vez de px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
