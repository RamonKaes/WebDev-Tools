<?php

declare(strict_types=1);

$toolId = 'stringEscaperTool';
$lang = 'es';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Escape de Cadenas</strong> te ayuda a escapar y desescapar cadenas para distintos formatos como HTML, XML, JavaScript, JSON, SQL y CSV.
    Perfecto para desarrolladores que necesitan manejar texto de forma segura en contextos variados.
</p>
<p class="mb-0">
    Todo el procesamiento ocurre en tu navegador: tus datos nunca abandonan tu dispositivo.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape HTML/XML: codifica caracteres como &lt;, &gt; y &amp;</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JavaScript: gestiona comillas, saltos de línea y caracteres especiales</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JSON: garantiza cadenas válidas en objetos JSON</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape SQL: ayuda a prevenir inyecciones SQL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape CSV: maneja comillas y separadores correctamente</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Procesamiento local centrado en la privacidad</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copiar al portapapeles con un clic</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Seguridad</h3>
    <ul>
      <li>Prevenir ataques XSS mediante escape HTML</li>
      <li>Mitigar inyecciones SQL</li>
      <li>Emitir cadenas JavaScript de forma segura</li>
      <li>Proteger datos en APIs JSON</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Procesamiento de datos</h3>
    <ul>
      <li>Exportaciones CSV correctamente escapadas</li>
      <li>Sanitizar contenido HTML/XML</li>
      <li>Literales de cadenas en JavaScript</li>
      <li>Preparar consultas para bases de datos</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP: prevención de XSS',
        'description' => 'Guía completa para evitar ataques Cross-Site Scripting'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'MDN: referencia de String en JavaScript',
        'description' => 'Documentación sobre métodos de cadenas y escape en JavaScript'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP: prevención de inyección SQL',
        'description' => 'Buenas prácticas para protegerse contra inyecciones SQL'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5: escape de cadenas',
        'description' => 'Especificación oficial sobre cómo escapar cadenas en HTML'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
