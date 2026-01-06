<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'jwtDecoderTool';
$lang = 'de';

$customAboutContent = '
  <p class="mb-2">
    <strong>JSON Web Tokens (JWT)</strong> sind eine kompakte, URL-sichere Methode zur 
    Darstellung von Ansprüchen zwischen zwei Parteien. Sie werden häufig für Authentifizierung 
    und Informationsaustausch in modernen Webanwendungen und APIs verwendet.
  </p>
  <p class="mb-0">
    Dieser Decoder extrahiert und zeigt die Header-, Payload- und Signatur-Komponenten eines JWT an. 
    Hinweis: Die Signaturprüfung erfordert den geheimen Schlüssel und sollte 
    aus Sicherheitsgründen serverseitig erfolgen.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Header-Dekodierung: Anzeige von Algorithmus (alg) und Token-Typ (typ)</li>
    <li>Payload-Extraktion: Dekodierung von Claims und Benutzerdaten</li>
    <li>Ablaufprüfung: Automatische Überprüfung, ob Token abgelaufen ist</li>
    <li>Syntax-Hervorhebung: Farbcodiertes JSON für bessere Lesbarkeit</li>
    <li>Beispiel-Token: Beispiel-JWT zum Testen des Decoders laden</li>
    <li>Nur Client-seitig: Alle Dekodierung erfolgt in Ihrem Browser</li>
  </ul>
';

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Wichtige Sicherheitsinformationen</h2>
    <ul class="mb-2">
        <li>Dekodierung ≠ Verifizierung: Dieses Tool dekodiert nur das JWT. Es verifiziert NICHT die Signatur.</li>
        <li>Niemals unverifizierte Token verwenden: Verifizieren Sie Signaturen immer serverseitig, bevor Sie JWT-Daten verwenden.</li>
        <li>Sensible Daten: JWTs sind Base64-kodiert, nicht verschlüsselt. Jeder kann sie dekodieren.</li>
        <li>Geheime Schlüssel: Geben Sie niemals geheime Schlüssel in Online-Tools oder Client-Code ein.</li>
    </ul>
    <p class="mb-0 small">
        Verwenden Sie für Produktionsanwendungen geeignete JWT-Bibliotheken wie 
        <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python) oder 
        <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'JWT-Struktur',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>Ein JWT besteht aus drei Base64URL-kodierten Teilen, getrennt durch Punkte (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATUR</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Enthält Token-Metadaten:</p>
    <ul class="small">
      <li><code>alg</code>: Algorithmus (HS256, RS256...)</li>
      <li><code>typ</code>: Token-Typ (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Enthält die Claims:</p>
    <ul class="small">
      <li><code>sub</code>: Subject (Benutzer-ID)</li>
      <li><code>exp</code>: Ablaufzeit</li>
      <li><code>iat</code>: Ausgestellt am</li>
      <li>Benutzerdefinierte Claims</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signatur</h3>
    <p class="small">Überprüft Token-Integrität:</p>
    <ul class="small">
      <li>HMAC oder RSA Signatur</li>
      <li>Erfordert geheimen Schlüssel</li>
      <li>Verhindert Manipulation</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/JSON_Web_Token',
        'title' => 'Wikipedia: JSON Web Token',
        'description' => 'Einsteigerfreundliche Einführung in JWT-Konzepte und -Struktur'
    ],
    [
        'url' => 'https://jwt.io/',
        'title' => 'JWT.io',
        'description' => 'Offizielle JWT-Website mit Debugger und Bibliotheksinformationen'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519: JSON Web Token',
        'description' => 'Offizielle IETF-Spezifikation für JWT'
    ],
    [
        'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
        'title' => 'Auth0: Einführung in JSON Web Tokens',
        'description' => 'Umfassender Leitfaden zum Verständnis und zur Verwendung von JWTs'
    ],
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/API/SubtleCrypto',
        'title' => 'MDN: SubtleCrypto',
        'description' => 'Web Crypto API für kryptografische Operationen in JavaScript'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
