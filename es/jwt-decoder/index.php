<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jwtDecoderTool';
$lang = 'es';

$customAboutContent = '
  <p class="mb-2">
    <strong>JSON Web Tokens (JWT)</strong> son un medio compacto y seguro para representar
    afirmaciones entre dos partes. Se utilizan ampliamente para autenticación e intercambio de información
    en aplicaciones web modernas y APIs.
  </p>
  <p class="mb-0">
    Este decodificador extrae y muestra el encabezado, la carga útil y la firma de un JWT.
    Nota: la verificación de la firma requiere la clave secreta y debe realizarse en el servidor para mantener la seguridad.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Decodifica el encabezado: muestra algoritmo (alg) y tipo de token (typ)</li>
    <li>Extrae la carga útil: visualiza las reclamaciones y datos de usuario</li>
    <li>Comprueba la caducidad: detecta automáticamente si el token expiró</li>
    <li>Resaltado de sintaxis: JSON coloreado para mejorar la lectura</li>
    <li>Visualiza la firma: muestra la firma codificada en Base64URL</li>
    <li>Procesamiento local: toda la lógica se ejecuta en tu navegador</li>
  </ul>
';

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Información de seguridad importante</h2>
    <ul class="mb-2">
        <li>Decodificar ≠ verificar: esta herramienta solo decodifica el JWT. No verifica la firma.</li>
        <li>No confíes en tokens sin verificar: valida siempre la firma en el servidor antes de usar los datos.</li>
        <li>Datos sensibles: los JWT están codificados en Base64, no cifrados. Cualquiera puede leerlos.</li>
        <li>Claves secretas: nunca pegues claves secretas en herramientas online ni en código del lado cliente.</li>
    </ul>
    <p class="mb-0 small">
        Para entornos de producción, utiliza bibliotecas especializadas como
        <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python) o
        <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'Estructura de un JWT',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>Un JWT consta de tres partes codificadas en Base64URL separadas por puntos (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATURE</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Contiene metadatos del token:</p>
    <ul class="small">
      <li><code>alg</code>: algoritmo (HS256, RS256...)</li>
      <li><code>typ</code>: tipo de token (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Incluye las reclamaciones:</p>
    <ul class="small">
      <li><code>sub</code>: sujeto (ID de usuario)</li>
      <li><code>exp</code>: fecha de expiración</li>
      <li><code>iat</code>: fecha de emisión</li>
      <li>Reclamaciones personalizadas</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signature</h3>
    <p class="small">Verifica la integridad del token:</p>
    <ul class="small">
      <li>Firma HMAC o RSA</li>
      <li>Requiere la clave secreta para verificar</li>
      <li>Impide la manipulación</li>
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
        'description' => 'Sitio oficial con depurador y listado de bibliotecas JWT'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519: JSON Web Token',
        'description' => 'Especificación oficial del IETF para JWT'
    ],
    [
        'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
        'title' => 'Auth0: introducción a los JWT',
        'description' => 'Guía completa para comprender y utilizar JSON Web Tokens'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto',
        'title' => 'MDN: SubtleCrypto',
        'description' => 'API Web Crypto para operaciones criptográficas en JavaScript'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
