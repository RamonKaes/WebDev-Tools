<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'pt';

$customAboutContent = <<<HTML
<p class="mb-2">
    Calcule dimensões ausentes, mantenha proporções de aspecto e gere CSS para mídia responsiva. 
    Essencial para imagens, vídeos e layouts responsivos.
</p>
<p class="mb-0">
    A proporção de aspecto descreve a relação proporcional entre largura e altura. Esta ferramenta ajuda você 
    a calcular dimensões, converter entre formatos de proporção e gerar código CSS para manter 
    proporções de aspecto em designs responsivos.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Calcular largura ou altura ausente a partir da proporção de aspecto</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Predefinições de proporções comuns (16:9, 4:3, 21:9, 1:1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Gerador do truque CSS padding-bottom</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Múltiplos formatos de proporção (proporção, decimal, porcentagem)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Calculadora de tamanhos de imagem responsivos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cálculo em tempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento 100% no lado do cliente</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Proporções de Aspecto Comuns</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Vídeo HD padrão, YouTube, telas modernas</li>
        <li><strong>4:3</strong> — TV clássica, monitores antigos</li>
        <li><strong>21:9</strong> — Monitores ultrawide, cinematográfico</li>
        <li><strong>1:1</strong> — Quadrado (posts do Instagram)</li>
        <li><strong>9:16</strong> — Vídeo vertical (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de Uso Comuns',
        'content' => <<<HTML
<ul>
    <li><strong>Imagens Responsivas:</strong> Manter proporção de aspecto ao escalar imagens</li>
    <li><strong>Incorporações de Vídeo:</strong> Calcular dimensões de iframe para YouTube, Vimeo</li>
    <li><strong>Proporção de Aspecto CSS:</strong> Gerar truque padding-bottom para navegadores antigos</li>
    <li><strong>Redimensionamento de Imagem:</strong> Calcular dimensões de corte ou redimensionamento</li>
    <li><strong>Design de Layout:</strong> Planejar layouts de grade responsivos</li>
</ul>
HTML
    ],
    [
        'title' => 'Técnicas CSS de Proporção de Aspecto',
        'content' => <<<HTML
<p><strong>Abordagem moderna (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Abordagem legada (truque padding-bottom):</strong></p>
<pre><code>.container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 = 9/16 = 56.25% */
}

.container > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}</code></pre>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/Propor%C3%A7%C3%A3o_de_aspecto',
        'title' => 'Wikipedia: Proporção de Aspecto',
        'description' => 'Introdução amigável para iniciantes sobre proporções de aspecto em imagens e vídeo'
    ],
    [
        'url' => 'https://developer.mozilla.org/pt-BR/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: Propriedade CSS aspect-ratio',
        'description' => 'Propriedade CSS moderna para manter proporções de aspecto'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2019/03/aspect-ratio-unit-css/',
        'title' => 'Smashing Magazine: Aspect Ratio em CSS',
        'description' => 'Guia completo para manter proporções de aspecto em CSS moderno'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Especificação oficial para CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'Nova Propriedade CSS Aspect-Ratio',
        'description' => 'Guia do Google web.dev sobre tratamento moderno de proporção de aspecto'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
