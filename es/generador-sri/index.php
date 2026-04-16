<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'es';

$featuresSectionTitle = 'Funciones';
$features = [
    'Genera hashes SRI a partir de una URL, archivo subido o texto pegado',
    'Compatible con SHA-256, SHA-384 (recomendado) y SHA-512 simultáneamente',
    'Genera etiquetas HTML &lt;script&gt; y &lt;link&gt; listas para usar',
    'Copia el atributo integrity y la etiqueta HTML completa con un clic',
    'Privacidad primero: todo el hashing se ejecuta en el navegador',
    'Ejemplos rápidos para Bootstrap, jQuery y Alpine.js',
    'Detecta automáticamente el tipo de recurso (JS vs. CSS)',
];

$resourcesSectionTitle = 'Recursos útiles';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/es/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN: Subresource Integrity',
        'description' => 'Documentación oficial de MDN sobre SRI, soporte de navegadores y cómo funciona la verificación de integridad.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'Especificación W3C SRI',
        'description' => 'La especificación oficial del W3C que define el estándar Subresource Integrity.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Tabla de compatibilidad de navegadores para el atributo integrity.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/es/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN: SubtleCrypto.digest()',
        'description' => 'Documentación de la API Web Crypto utilizada por esta herramienta para el hash seguro.',
    ],
];

include __DIR__ . '/../../partials/tool-base.php';
