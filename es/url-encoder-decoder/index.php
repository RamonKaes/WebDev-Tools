<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'urlEncoderDecoder';
$lang = 'es';
$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>La codificación de URL</strong> (o codificación porcentual) convierte caracteres a un formato adecuado para transmitirse en Internet.
    Los caracteres especiales se reemplazan por "%" seguido de dos dígitos hexadecimales.
</p>
<p class="mb-0">
    Todo el proceso de codificar y decodificar se realiza localmente en tu navegador. No se envían datos a servidores,
    garantizando privacidad y seguridad completas.
</p>
HTML;

$features = [
    'Codificación: transforma URLs y parámetros de consulta',
    'Decodificación: interpreta URLs codificadas',
    'Componentes: codifica segmentos individuales de URLs',
    'Procesamiento masivo: codifica/decodifica múltiples líneas a la vez',
    'Análisis: extrae protocolo, host, ruta y query string',
    'Detección automática: reconoce el formato apropiado para cada entrada'
];

$customNoticeContent = '
  <h3 class="h6 mb-2">
    <i class="bi bi-info-circle me-2"></i>encodeURI() vs encodeURIComponent()
  </h3>
  <p class="mb-0">
    <strong>encodeURI()</strong> codifica la URL completa manteniendo caracteres especiales como <code>:</code>, <code>/</code>, <code>?</code> y <code>&amp;</code>.<br>
    <strong>encodeURIComponent()</strong> codifica todos los caracteres especiales, ideal para parámetros de consulta.
  </p>
';

$additionalSections = [
  [
    'title' => 'Casos de uso comunes',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Codificación</h3>
    <ul>
      <li>Valores de parámetros en consultas</li>
      <li>Datos de formularios</li>
      <li>Parámetros en peticiones API</li>
      <li>URLs compartibles con caracteres especiales</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Decodificación</h3>
    <ul>
      <li>Leer URLs codificadas</li>
      <li>Depurar respuestas de APIs</li>
      <li>Analizar cadenas de consulta</li>
      <li>Extraer componentes de una URL</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://web.dev/articles/url-parts',
        'title' => 'Web.dev: Partes de la URL',
        'description' => 'Guía accesible sobre componentes y codificación de URL'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3986',
        'title' => 'RFC 3986: sintaxis de URI',
        'description' => 'Especificación oficial de sintaxis y codificación de URI'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent',
        'title' => 'MDN encodeURIComponent()',
        'description' => 'Función de JavaScript para codificar componentes de URL'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/decodeURIComponent',
        'title' => 'MDN decodeURIComponent()',
        'description' => 'Función de JavaScript para decodificar componentes de URL'
    ],
    [
        'url' => 'https://www.ietf.org/rfc/rfc1738.txt',
        'title' => 'RFC 1738: Localizadores de recursos uniformes (URL)',
        'description' => 'Especificación original de la sintaxis y reglas de codificación de URL'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
