<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jwtDecoderTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>JSON Web Tokens (JWT)</strong> sont un moyen compact et compatible avec les URL pour représenter
    des revendications entre deux parties. Ils sont largement utilisés pour l'authentification et l'échange
    d'informations dans les applications web modernes et les API.
</p>
<p class="mb-0">
    Ce décodeur extrait et affiche les composants en-tête, charge utile et signature d'un JWT.
    Remarque&nbsp;: la vérification de la signature nécessite la clé secrète et doit être effectuée côté serveur pour rester sécurisée.
</p>
HTML;

$features = [
    'Décodage de l\'en-tête : affiche l\'algorithme (alg) et le type de jeton (typ)',
    'Extraction de la charge utile : décode les revendications et données utilisateur',
    'Vérification d\'expiration : détecte automatiquement si le jeton a expiré',
    'Mise en évidence syntaxique : JSON coloré pour une meilleure lisibilité',
    'Affichage de la signature : montre la signature encodée en Base64URL',
    'Côté client : tout le traitement se fait localement dans votre navigateur'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Informations de sécurité importantes</h2>
    <ul class="mb-2">
        <li>Décoder ≠ vérifier&nbsp;: cet outil ne fait que décoder le JWT. Il ne vérifie PAS la signature.</li>
        <li>Ne faites jamais confiance à un jeton non vérifié&nbsp;: validez toujours les signatures côté serveur avant d'utiliser les données.</li>
        <li>Données sensibles&nbsp;: les JWT sont encodés en Base64, pas chiffrés. N'importe qui peut les décoder.</li>
        <li>Clés secrètes&nbsp;: ne collez jamais de clés secrètes dans des outils en ligne ou du code côté client.</li>
    </ul>
    <p class="mb-0 small">
        Pour les applications en production, utilisez des bibliothèques dédiées comme
        <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python) ou
        <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'Structure d\'un JWT',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>Un JWT se compose de trois parties encodées en Base64URL et séparées par des points (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATURE</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Contient les métadonnées du jeton&nbsp;:</p>
    <ul class="small">
      <li><code>alg</code>&nbsp;: algorithme (HS256, RS256...)</li>
      <li><code>typ</code>&nbsp;: type de jeton (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Contient les revendications&nbsp;:</p>
    <ul class="small">
      <li><code>sub</code>&nbsp;: sujet (ID utilisateur)</li>
      <li><code>exp</code>&nbsp;: date d\'expiration</li>
      <li><code>iat</code>&nbsp;: date d\'émission</li>
      <li>Revendications personnalisées</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signature</h3>
    <p class="small">Vérifie l\'intégrité du jeton&nbsp;:</p>
    <ul class="small">
      <li>Signature HMAC ou RSA</li>
      <li>Nécessite la clé secrète pour vérification</li>
      <li>Empêche toute altération</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/JSON_Web_Token',
        'title' => 'Wikipedia&nbsp;: JSON Web Token',
        'description' => 'Introduction accessible aux concepts et à la structure des JWT'
    ],
    [
        'url' => 'https://jwt.io/',
        'title' => 'JWT.io',
        'description' => 'Site officiel des JWT avec débogueur et informations sur les bibliothèques'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519&nbsp;: JSON Web Token',
        'description' => 'Spécification officielle IETF des JWT'
    ],
    [
        'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
        'title' => 'Auth0&nbsp;: introduction aux JSON Web Tokens',
        'description' => 'Guide complet pour comprendre et utiliser les JWT'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto',
        'title' => 'MDN&nbsp;: SubtleCrypto',
        'description' => 'API Web Crypto pour les opérations cryptographiques en JavaScript'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
