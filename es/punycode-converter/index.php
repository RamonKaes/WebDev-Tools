<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Punycode</strong> es una sintaxis de codificación que representa caracteres Unicode
    en nombres de dominio usando únicamente caracteres ASCII. Permite que los dominios internacionalizados (IDN)
    funcionen con la infraestructura DNS existente.
</p>
<p class="mb-0">
    Esta herramienta implementa la RFC 3492 para convertir dominios Unicode (münchen.de)
    y sus equivalentes Punycode (xn--mnchen-3ya.de). Todas las conversiones ocurren en tu navegador.
</p>
HTML;

$features = [
    'Conversión bidireccional: de Unicode a Punycode y viceversa',
    'Detección automática: identifica el formato de entrada',
    'Cumple con la RFC 3492: implementación completa del estándar Punycode',
    'Procesamiento por lotes: convierte múltiples dominios (una línea por dominio)',
    'Dominios de ejemplo: carga dominios internacionales para probar',
    'Conversión en tiempo real: actualiza mientras escribes'
];

$additionalSections = [
  [
    'title' => 'Cómo funciona Punycode',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode convierte nombres de dominio Unicode a ASCII mediante un proceso específico:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Dominio Unicode</h4>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Dominio Punycode</h4>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>Proceso de codificación:</p>
<ol>
  <li>Extraer los caracteres ASCII (mnchen)</li>
  <li>Codificar la posición y el valor de los caracteres no ASCII</li>
  <li>Añadir el prefijo <code>xn--</code> para indicar Punycode</li>
  <li>Adjuntar la información Unicode codificada (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  Todos los dominios Punycode comienzan con <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Dominios internacionales frecuentes',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Idioma</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>Alemán</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>Alemán</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Ruso</td></tr>
      <tr><td>东京.jp</td><td>xn--1lqs71d.jp</td><td>Japonés</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Árabe</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Griego</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Casos de uso',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Registro de dominios</h3>
    <ul>
      <li>Convertir IDN para registros DNS</li>
      <li>Comprobar disponibilidad de dominios</li>
      <li>Codificar direcciones de correo</li>
      <li>Generar certificados SSL</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Desarrollo web</h3>
    <ul>
      <li>Gestionar URLs en aplicaciones</li>
      <li>Almacenar dominios en bases de datos</li>
      <li>Realizar peticiones API con IDN</li>
      <li>Internacionalización (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3492',
        'title' => 'RFC 3492: Punycode',
        'description' => 'Especificación oficial del IETF para el codificado Punycode'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN: dominios internacionalizados',
        'description' => 'Resumen de implementación y políticas IDN'
    ],
    [
        'url' => 'https://es.wikipedia.org/wiki/Nombre_de_dominio_internacionalizado',
        'title' => 'Wikipedia: dominios internacionalizados',
        'description' => 'Información detallada sobre los sistemas IDN'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org: convertidor Punycode',
        'description' => 'Ejemplos adicionales y documentación sobre Punycode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
