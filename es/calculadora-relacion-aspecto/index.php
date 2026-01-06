<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Calcula dimensiones faltantes, mantén relaciones de aspecto y genera CSS para medios responsivos. 
    Esencial para imágenes, videos y diseños responsivos.
</p>
<p class="mb-0">
    La relación de aspecto describe la relación proporcional entre ancho y alto. Esta herramienta te ayuda 
    a calcular dimensiones, convertir entre formatos de relación y generar código CSS para mantener 
    relaciones de aspecto en diseños responsivos.
</p>
HTML;

$features = [
    'Calcular ancho o alto faltante desde relación de aspecto',
    'Plantillas de relaciones comunes (16:9, 4:3, 21:9, 1:1, etc.)',
    'Generador del truco CSS padding-bottom',
    'Múltiples formatos de relación (relación, decimal, porcentaje)',
    'Calculadora de tamaños de imagen responsivos',
    'Cálculo en tiempo real',
    'Procesamiento 100% del lado del cliente'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Relaciones de Aspecto Comunes</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Video HD estándar, YouTube, pantallas modernas</li>
        <li><strong>4:3</strong> — TV clásica, monitores antiguos</li>
        <li><strong>21:9</strong> — Monitores ultraanchos, cinematográfico</li>
        <li><strong>1:1</strong> — Cuadrado (publicaciones de Instagram)</li>
        <li><strong>9:16</strong> — Video vertical (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de Uso Comunes',
        'content' => <<<HTML
<ul>
    <li><strong>Imágenes Responsivas:</strong> Mantener relación de aspecto al escalar imágenes</li>
    <li><strong>Incrustaciones de Video:</strong> Calcular dimensiones de iframe para YouTube, Vimeo</li>
    <li><strong>Relación de Aspecto CSS:</strong> Generar truco padding-bottom para navegadores antiguos</li>
    <li><strong>Redimensionamiento de Imagen:</strong> Calcular dimensiones de recorte o redimensionamiento</li>
    <li><strong>Diseño de Layout:</strong> Planificar layouts de cuadrícula responsivos</li>
</ul>
HTML
    ],
    [
        'title' => 'Técnicas CSS de Relación de Aspecto',
        'content' => <<<HTML
<p><strong>Enfoque moderno (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Enfoque legacy (truco padding-bottom):</strong></p>
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
        'url' => 'https://es.wikipedia.org/wiki/Relaci%C3%B3n_de_aspecto',
        'title' => 'Wikipedia: Relación de Aspecto',
        'description' => 'Introducción amigable para principiantes sobre relaciones de aspecto en imágenes y video'
    ],
    [
        'url' => 'https://developer.mozilla.org/es/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: Propiedad CSS aspect-ratio',
        'description' => 'Propiedad CSS moderna para mantener relaciones de aspecto'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2019/03/aspect-ratio-unit-css/',
        'title' => 'Smashing Magazine: Aspect Ratio en CSS',
        'description' => 'Guía completa para mantener relaciones de aspecto en CSS moderno'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Especificación oficial para CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'Nueva Propiedad CSS Aspect-Ratio',
        'description' => 'Guía de Google web.dev sobre manejo moderno de relación de aspecto'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
