<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jwtDecoderTool';
$lang = 'pt';

$customAboutContent = '
  <p class="mb-2">
    <strong>JSON Web Tokens (JWT)</strong> são uma forma compacta e segura para transportar afirmações entre duas partes.
    Muito usados em autenticação e troca de informações em aplicações web modernas e APIs.
  </p>
  <p class="mb-0">
    Este decodificador separa e exibe o cabeçalho, o payload e a assinatura de um JWT.
    Atenção: verificar a assinatura exige a chave secreta e deve ser feito no servidor.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Decodificação do header: veja algoritmo (alg) e tipo (typ)</li>
    <li>Extração do payload: decode de claims e dados de usuário</li>
    <li>Checagem de expiração: valida automaticamente se o token expirou</li>
    <li>Destaque de sintaxe: JSON colorido para leitura fácil</li>
    <li>Assinatura: exibe a assinatura codificada em Base64URL</li>
    <li>Processamento local: tudo ocorre no navegador</li>
  </ul>
';

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Informações importantes</h2>
    <ul class="mb-2">
        <li>Decodificar ≠ verificar: a ferramenta apenas decodifica o JWT, não valida a assinatura.</li>
        <li>Não confie sem validar: sempre confirme a assinatura no backend antes de usar os dados.</li>
        <li>Dados sensíveis: JWT é Base64, não criptografado. Qualquer pessoa pode ver o conteúdo.</li>
        <li>Chaves secretas: nunca cole segredos em ferramentas online ou código cliente.</li>
    </ul>
    <p class="mb-0 small">
        Em produção, utilize bibliotecas dedicadas como <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python)
        ou <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'Estrutura do JWT',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>Um JWT possui três partes codificadas em Base64URL separadas por pontos (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATURE</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Metadados do token:</p>
    <ul class="small">
      <li><code>alg</code>: algoritmo (HS256, RS256...)</li>
      <li><code>typ</code>: tipo do token (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Contém as claims:</p>
    <ul class="small">
      <li><code>sub</code>: sujeito (ID do usuário)</li>
      <li><code>exp</code>: data de expiração</li>
      <li><code>iat</code>: data de emissão</li>
      <li>Claims personalizadas</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signature</h3>
    <p class="small">Garante integridade:</p>
    <ul class="small">
      <li>Assinatura HMAC ou RSA</li>
      <li>Requer a chave secreta para validar</li>
      <li>Impede adulteração</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://jwt.io/',
        'title' => 'JWT.io',
        'description' => 'Site oficial com debugger e bibliotecas recomendadas'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519: JSON Web Token',
        'description' => 'Especificação oficial do IETF para JWT'
    ],
  [
    'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
    'title' => 'Auth0: Introdução a JWT',
    'description' => 'Guia completo sobre uso e boas práticas com JWT'
  ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto',
        'title' => 'MDN: SubtleCrypto',
        'description' => 'API Web Crypto para operações criptográficas em JavaScript'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
