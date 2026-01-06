<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'regexTesterTool';
$lang = 'es';

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Pruebas de expresiones regulares</h2>
<ul class="mb-0">
    <li>Motor JavaScript: la herramienta usa el motor RegExp de JavaScript para evaluar patrones</li>
    <li>Pruebas en vivo: valida tus patrones con texto real y retroalimentación instantánea</li>
    <li>Privacidad: todas las pruebas se ejecutan localmente, sin enviar datos a servidores</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://es.wikipedia.org/wiki/Expresi%C3%B3n_regular',
        'title' => 'Wikipedia: Expresión regular',
        'description' => 'Introducción accesible a las expresiones regulares'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'Guía MDN de expresiones regulares',
        'description' => 'Tutorial completo sobre expresiones regulares en JavaScript'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Referencia detallada de sintaxis y patrones regex'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - Patrones de la comunidad',
        'description' => 'Aprende regex con ejemplos compartidos por la comunidad'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - Probador y depurador',
        'description' => 'Herramienta avanzada para probar expresiones regulares y ver explicaciones'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
