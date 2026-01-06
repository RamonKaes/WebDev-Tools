<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jsonFormatterValidator';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Da formato, valida y embellece datos JSON con nuestra herramienta integral.
    Ideal para desarrolladores que trabajan con APIs, archivos de configuración y estructuras de datos.
</p>
<p class="mb-0">
    Esta herramienta analiza el JSON, valida la sintaxis, aplica sangría adecuada y proporciona mensajes de error detallados.
    Todo el procesamiento se realiza en tu navegador para garantizar la privacidad.
</p>
HTML;

$features = [
    'Formatea y embellece JSON con indentación configurable (2 o 4 espacios)',
    'Valida la sintaxis con mensajes de error detallados',
    'Minifica JSON para reducir el tamaño',
    'Validación en tiempo real',
    'Detección de errores línea por línea',
    'Copiar el resultado formateado con un clic',
    'Resaltado claro de errores y mensajes comprensibles',
    'Privacidad: todo sucede en tu navegador'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Opciones de formateo JSON</h2>
<ul class="mb-0">
    <li>Embellecer (2 espacios): formato estándar con indentación reducida</li>
    <li>Embellecer (4 espacios): formato con mayor legibilidad</li>
    <li>Minificar: elimina espacios para obtener JSON compacto</li>
    <li>Validar: comprueba la sintaxis sin modificar la estructura</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Desarrollo de APIs: formatear respuestas para facilitar la lectura</li>
    <li>Archivos de configuración: validar y ajustar JSON de configuración</li>
    <li>Inspección de datos: revisar rápidamente estructuras JSON complejas</li>
    <li>Depuración: localizar errores de sintaxis en datos JSON</li>
    <li>Revisión de código: garantizar un formato JSON consistente</li>
    <li>Migración de datos: validar JSON antes de importarlo</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://es.wikipedia.org/wiki/JSON',
        'title' => 'Wikipedia: JSON',
        'description' => 'Introducción accesible a los conceptos y uso de JSON'
    ],
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404: sintaxis de intercambio de datos JSON',
        'description' => 'Especificación oficial del JSON publicada por ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259: JSON (JavaScript Object Notation)',
        'description' => 'Estándar del IETF que define el formato JSON'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'Referencia del objeto JSON en MDN',
        'description' => 'Guía completa de JSON.parse() y JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'Especificación JSON Schema',
        'description' => 'Documentación oficial para validar la estructura y tipos en JSON'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
