<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'es';

$customAboutContent = <<<HTML
<p class="mb-2">
    Convierte rápidamente entre píxeles (px) y unidades rem.
    Esencial para el diseño web responsive y una tipografía accesible.
</p>
<p class="mb-0">
    La unidad rem (root em) es relativa al tamaño de fuente del elemento raíz, lo que la hace ideal
    para crear interfaces escalables y accesibles. Esta herramienta te ayuda a convertir valores de px a rem y viceversa
    según el tamaño de fuente base que elijas.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversión px → rem y rem → px</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Tamaño de fuente base personalizable (por defecto: 16 px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversión en lote: múltiples valores a la vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Resultados en tiempo real mientras escribes</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copiar valores convertidos con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Preajustes de puntos de ruptura comunes</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Procesamiento 100 % en el navegador</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>¿Por qué usar unidades rem?</h2>
    <ul class="mb-0">
        <li>Accesibilidad: los usuarios pueden ajustar el tamaño de fuente de su navegador</li>
        <li>Consistencia: todas las dimensiones escalan proporcionalmente</li>
        <li>Diseño responsive: mantenimiento más sencillo en distintos dispositivos</li>
        <li>Buena práctica: estándar recomendado en desarrollo moderno</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Tipografía: convertir tamaños de fuente de px a rem</li>
    <li>Espaciado: transformar márgenes y rellenos a rem</li>
    <li>Puntos de ruptura: definir media queries en rem</li>
    <li>Tamaño de componentes: escalar elementos de UI de forma uniforme</li>
    <li>Accesibilidad: cumplir con las pautas WCAG</li>
</ul>
HTML
    ],
    [
        'title' => 'rem vs em vs px',
        'content' => <<<HTML
<ul>
    <li>px: unidad absoluta con tamaño fijo</li>
    <li>em: relativo al tamaño de fuente del elemento padre (puede acumularse)</li>
    <li>rem: relativo al tamaño de fuente raíz (consistente)</li>
    <li>Recomendación: usa rem para escalas globales y em para ajustes locales</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://es.wikipedia.org/wiki/Cuadrat%C3%ADn',
        'title' => 'Wikipedia: Cuadratín',
        'description' => 'Introducción accesible a las unidades tipográficas em y rem'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN: valores y unidades CSS',
        'description' => 'Guía completa sobre unidades CSS, incluidas px, rem y em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Level 3',
        'description' => 'Especificación oficial del W3C para la unidad rem'
    ],
    [
        'url' => 'https://moderncss.dev/generating-font-size-css-rules-and-creating-a-fluid-type-scale/',
        'title' => 'Modern CSS: Reglas de tamaño de fuente y escalado fluido',
        'description' => 'Guía completa sobre unidades rem y tipografía fluida en CSS moderno'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Píxeles vs unidades relativas',
        'description' => 'Beneficios de accesibilidad al preferir rem sobre px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
