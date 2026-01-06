<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'base64EncoderDecoder';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$features = [
    'Codificação e decodificação de texto e arquivos',
    'Suporte a arrastar e soltar arquivos',
    'Codificação Base64 compatível com URLs',
    'Modo em tempo real',
    'Processamento multilinha',
    'Processamento no navegador: seus dados nunca saem do dispositivo'
];

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
        'url' => 'https://pt.wikipedia.org/wiki/Base64',
        'title' => 'Wikipedia: Base64',
        'description' => 'Introdução compreensível ao Base64 - ideal para iniciantes'
    ],
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
