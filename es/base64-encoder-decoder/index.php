<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'es';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codificación y decodificación de texto y archivos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Compatibilidad con arrastrar y soltar archivos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codificación Base64 segura para URL</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modo en tiempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Procesamiento multilínea</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Procesamiento en el navegador: tus datos nunca salen de tu dispositivo</li>
</ul>
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
      <li>Autenticación API (Basic Auth)</li>
      <li>Decodificación de tokens JWT</li>
      <li>URIs de datos para imágenes</li>
      <li>Adjuntos de correo electrónico</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Transferencia de datos</h3>
    <ul>
      <li>Datos binarios en JSON</li>
      <li>Codificación de parámetros de URL</li>
      <li>Valores de cookies</li>
      <li>Datos binarios en XML</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648: codificaciones Base16, Base32 y Base64',
        'description' => 'Especificación oficial del IETF que define el estándar Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'Guía de codificación Base64 de MDN',
        'description' => 'Guía completa sobre Base64 en desarrollo web'
    ],
  [
    'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
    'title' => 'MDN btoa()',
    'description' => 'Función de JavaScript para codificar cadenas en Base64'
  ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob()',
        'description' => 'Función de JavaScript para decodificar Base64 a texto plano'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
