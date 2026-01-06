<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'characterReferenceTool';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Explora y busca una colección completa de entidades HTML, caracteres Unicode y símbolos especiales.
    Encuentra los códigos necesarios para desarrollo web, desde símbolos comunes hasta operadores matemáticos y emoji.
</p>
<p class="mb-0">
    Cada carácter muestra su entidad HTML, código decimal, código hexadecimal y representación Unicode.
    Haz clic en cualquier formato para copiarlo al instante al portapapeles.
</p>
HTML;

$features = [
    'Más de 2 231 entidades HTML',
    'Navegación por categorías',
    'Búsqueda avanzada',
    'Múltiples formatos de copia',
    'Códigos Unicode, decimales y hexadecimales',
    'Copiar con un solo clic'
];

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'WHATWG HTML: referencias de caracteres con nombre',
        'description' => 'Especificación oficial de las entidades de caracteres con nombre'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: referencia de entidades HTML',
        'description' => 'Guía completa de entidades y símbolos en HTML'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'W3C: definiciones de entidades XML',
        'description' => 'Definiciones oficiales de entidades y correspondencias Unicode'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Tablas de código Unicode',
        'description' => 'Tablas oficiales del Consorcio Unicode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
