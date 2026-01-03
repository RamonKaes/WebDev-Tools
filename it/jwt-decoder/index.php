<?php

declare(strict_types=1);

$toolId = 'jwtDecoderTool';
$lang = 'it';

$customAboutContent = '
  <p class="mb-2">
    I <strong>JSON Web Token (JWT)</strong> sono un formato compatto e sicuro per trasferire informazioni tra due parti.
    Sono ampiamente utilizzati per autenticazione e scambio dati in applicazioni web moderne e API.
  </p>
  <p class="mb-0">
    Questo decodificatore estrae e visualizza header, payload e firma di un JWT.
    Nota: la verifica della firma richiede la chiave segreta e deve essere eseguita lato server.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Decodifica header: visualizza algoritmo (alg) e tipo (typ)</li>
    <li>Estrazione payload: decodifica claim e dati utente</li>
    <li>Controllo scadenza: verifica automatica se il token è scaduto</li>
    <li>Evidenziazione sintassi: JSON colorato per leggibilità</li>
    <li>Firma: mostra la firma codificata in Base64URL</li>
    <li>Lato client: tutto il processo avviene nel browser</li>
  </ul>
';

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Informazioni di sicurezza importanti</h2>
    <ul class="mb-2">
        <li>Decodificare ≠ verificare: questo strumento decodifica solo il JWT, non ne verifica la firma.</li>
        <li>Mai fidarsi senza verifica: verifica sempre le firme lato server prima di usare i dati del JWT.</li>
        <li>Dati sensibili: i JWT sono codificati in Base64, non cifrati. Chiunque può decodificarli.</li>
        <li>Chiavi segrete: non incollare mai chiavi segrete in strumenti online o codice client.</li>
    </ul>
    <p class="mb-0 small">
        Per applicazioni di produzione, usa librerie dedicate come
        <code>jsonwebtoken</code> (Node.js), <code>PyJWT</code> (Python) o
        <code>firebase/php-jwt</code> (PHP).
    </p>
HTML;

$additionalSections = [
  [
    'title' => 'Struttura del JWT',
    'icon' => 'diagram-3',
    'content' => <<<HTML
<p>Un JWT è composto da tre parti codificate in Base64URL separate da punti (.):</p>
<div class="bg-body-secondary p-3 rounded mb-3 font-monospace small">
  <span class="text-danger">HEADER</span>.<span class="text-success">PAYLOAD</span>.<span class="text-warning">SIGNATURE</span>
</div>

<div class="row">
  <div class="col-md-4">
    <h3 class="h6 text-danger">Header</h3>
    <p class="small">Metadati del token:</p>
    <ul class="small">
      <li><code>alg</code>: algoritmo (HS256, RS256...)</li>
      <li><code>typ</code>: tipo di token (JWT)</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-success">Payload</h3>
    <p class="small">Contiene le claim:</p>
    <ul class="small">
      <li><code>sub</code>: soggetto (ID utente)</li>
      <li><code>exp</code>: data di scadenza</li>
      <li><code>iat</code>: data di emissione</li>
      <li>Claim personalizzate</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h3 class="h6 text-warning">Signature</h3>
    <p class="small">Garantisce l'integrità:</p>
    <ul class="small">
      <li>Firma HMAC o RSA</li>
      <li>Richiede la chiave segreta per verificare</li>
      <li>Previene manomissioni</li>
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
        'description' => 'Sito ufficiale con debugger e informazioni sulle librerie'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc7519',
        'title' => 'RFC 7519: JSON Web Token',
        'description' => 'Specifica ufficiale IETF per JWT'
    ],
    [
        'url' => 'https://auth0.com/docs/secure/tokens/json-web-tokens',
        'title' => 'Auth0: Introduzione a JWT',
        'description' => 'Guida completa per comprendere e utilizzare JWT'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto',
        'title' => 'MDN: SubtleCrypto',
        'description' => 'Web Crypto API per operazioni crittografiche in JavaScript'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
