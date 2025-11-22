<?php

declare(strict_types=1);

$toolId = 'dataConverterTool';
$lang = 'es';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversión entre JSON, XML, YAML y CSV</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversiones bidireccionales</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversión de timestamp Unix a fecha</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formato de salida personalizable</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modo de conversión automática en tiempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Opciones de delimitador para CSV</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desarrollo de APIs</h3>
    <ul>
      <li>Convertir respuestas entre diferentes formatos</li>
      <li>Transformar archivos de configuración</li>
      <li>Interpretar valores de timestamp</li>
      <li>Exportar datos para otros sistemas</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Migración de datos</h3>
    <ul>
      <li>Convertir exportaciones de bases de datos</li>
      <li>Transformar formatos heredados</li>
      <li>Preparar datos para importación y exportación</li>
      <li>Normalizar formatos de fecha y hora</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.json.org/',
        'title' => 'JSON.org - Introducción a JSON',
        'description' => 'Especificación oficial y documentación del formato JSON'
    ],
    [
        'url' => 'https://yaml.org/spec/',
        'title' => 'Especificación YAML',
        'description' => 'Documentación oficial del formato YAML con ejemplos'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml/',
        'title' => 'Especificación XML del W3C',
        'description' => 'Estándar oficial del lenguaje XML'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4180',
        'title' => 'RFC 4180: Especificación del formato CSV',
        'description' => 'Definición oficial del formato Comma-Separated Values (CSV)'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
