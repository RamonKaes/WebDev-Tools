<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'pt';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codificação e decodificação de texto e arquivos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Suporte a arrastar e soltar arquivos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codificação Base64 compatível com URLs</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Modo em tempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento multilinha</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento no navegador: seus dados nunca saem do dispositivo</li>
</ul>
HTML;

$additionalSections = [
  [
    'title' => 'Casos de uso comuns',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Desenvolvimento</h3>
    <ul>
      <li>Autenticação de API (Basic Auth)</li>
      <li>Decodificação de tokens JWT</li>
      <li>Data URIs para imagens</li>
      <li>Anexos de e-mail</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Transferência de dados</h3>
    <ul>
      <li>Dados binários em JSON</li>
      <li>Codificação de parâmetros de URL</li>
      <li>Valores de cookies</li>
      <li>Dados binários em XML</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4648',
        'title' => 'RFC 4648: codificações Base16, Base32 e Base64',
        'description' => 'Especificação oficial do IETF que define o padrão Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Base64',
        'title' => 'Guia de codificação Base64 da MDN',
        'description' => 'Visão geral completa do uso de Base64 no desenvolvimento web'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/btoa',
        'title' => 'MDN btoa()',
        'description' => 'Função JavaScript para codificar strings em Base64'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/atob',
        'title' => 'MDN atob()',
        'description' => 'Função JavaScript para decodificar strings Base64'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
