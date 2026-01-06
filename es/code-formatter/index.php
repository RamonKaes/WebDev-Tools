<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'codeFormatterTool';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$features = [
    'Formato para HTML, CSS, JavaScript, XML y SQL',
    'Modos de embellecer y minificar',
    'Indentación personalizable (2/4 espacios o tabulaciones)',
    'Autoformato en tiempo real',
    'Validación de sintaxis',
    'Copiar y descargar con un clic'
];

$customNoticeContent = <<<HTML
<div class="alert alert-info" role="alert">
  <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Opciones de formateo</h2>
  <ul class="mb-0">
    <li>Embellecer: hace el código más legible mediante sangría y saltos de línea correctos</li>
    <li>Minificar: elimina espacios innecesarios para reducir el tamaño del archivo</li>
    <li>Indentación: elige entre 2 espacios, 4 espacios o tabulaciones</li>
  </ul>
</div>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desarrollo</h3>
    <ul>
      <li>Embellecer código minificado para facilitar la lectura y depuración</li>
      <li>Estandarizar el formato dentro del equipo</li>
      <li>Limpiar código desordenado o generado automáticamente</li>
      <li>Formatear antes de hacer commit en control de versiones</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Producción</h3>
    <ul>
      <li>Minificar para reducir el tamaño y mejorar los tiempos de carga</li>
      <li>Preparar el código para el despliegue</li>
      <li>Optimizar el uso de ancho de banda</li>
      <li>Mejorar el rendimiento del sitio web</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/Common_questions/Tools_and_setup/What_are_browser_developer_tools',
        'title' => 'MDN: Herramientas de desarrollo',
        'description' => 'Introducción accesible al formato y depuración de código'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
        'title' => 'Referencia de JavaScript en MDN',
        'description' => 'Guía completa de sintaxis y buenas prácticas de JavaScript'
    ],
    [
        'url' => 'https://www.w3.org/Style/CSS/',
        'title' => 'Especificaciones CSS del W3C',
        'description' => 'Estándares oficiales de CSS y recomendaciones de formato'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/',
        'title' => 'HTML Living Standard',
        'description' => 'Especificación actual de HTML y reglas de sintaxis'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Especificación XML del W3C',
        'description' => 'Estándar oficial del lenguaje XML (Extensible Markup Language)'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
