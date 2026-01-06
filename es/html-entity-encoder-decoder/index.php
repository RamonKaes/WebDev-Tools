<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'es';

$customAboutContent = '
  <p class="mb-2">
    <strong>Las entidades HTML</strong> son representaciones especiales para mostrar caracteres reservados y símbolos en HTML.
    Evitan problemas de interpretación del navegador y garantizan un renderizado correcto en distintos sistemas y codificaciones.
  </p>
  <p class="mb-0">
    Esta herramienta admite entidades con nombre (&amp;nbsp;), entidades decimales (&amp;#160;) y hexadecimales (&amp;#xA0;).
    Todas las conversiones se realizan localmente en tu navegador para mantener la privacidad.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Entidades con nombre: convierte a referentes estándar como &amp;nbsp;, &amp;lt;, &amp;gt;</li>
    <li>Entidades numéricas: formato decimal (&amp;#160;) u hexadecimal (&amp;#xA0;)</li>
    <li>Bidireccional: codifica texto a entidades o decodifica entidades a texto</li>
    <li>Autoconversión: transformación en tiempo real mientras escribes</li>
    <li>Referencia de caracteres: enlace rápido para consultar todas las entidades HTML</li>
    <li>Descarga: guarda los resultados en un archivo de texto</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Casos de uso comunes',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desarrollo HTML</h3>
    <ul>
      <li>Mostrar código en HTML (&lt;, &gt;, &amp;)</li>
      <li>Caracteres especiales en atributos</li>
      <li>Uso de símbolos de copyright y marca registrada</li>
      <li>Espacios de no separación</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Procesamiento de datos</h3>
    <ul>
      <li>Contenido para feeds XML/RSS</li>
      <li>Generación de plantillas de correo</li>
      <li>Escapar contenido almacenado en base de datos</li>
      <li>Internacionalización (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Entidades importantes',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Carácter</th>
        <th>Entidad con nombre</th>
        <th>Decimal</th>
        <th>Hexadecimal</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Menor que</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Mayor que</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>Et (&amp;)</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Comillas dobles</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Espacio de no separación</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Marca registrada</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  Ver la lista completa en nuestra <a href="../referencia-caracteres/">Referencia de Caracteres</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: Entidades HTML',
        'description' => 'Guía accesible sobre entidades de caracteres HTML'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'Standard HTML: referencias de caracteres nombrados',
        'description' => 'Especificación oficial WHATWG de las entidades con nombre'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN: entidades HTML',
        'description' => 'Guía completa sobre entidades de caracteres en HTML'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C: uso de secuencias de escape',
        'description' => 'Buenas prácticas para usar secuencias de escape en marcado y CSS'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
