<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'it';

$featuresSectionTitle = 'Funzionalità';
$features = [
    'Genera hash SRI da URL, file caricato o testo incollato',
    'Supporta SHA-256, SHA-384 (consigliato) e SHA-512 contemporaneamente',
    'Genera tag HTML &lt;script&gt; e &lt;link&gt; pronti all\'uso',
    'Copia l\'attributo integrity e il tag HTML completo con un clic',
    'Privacy: tutto l\'hashing viene eseguito nel browser lato client',
    'Esempi rapidi per Bootstrap, jQuery e Alpine.js',
    'Rileva automaticamente il tipo di risorsa (JS o CSS)',
];

$resourcesSectionTitle = 'Risorse utili';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/it/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN: Subresource Integrity',
        'description' => 'Documentazione MDN ufficiale su SRI, compatibilità dei browser e come funziona la verifica dell\'integrità.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'Specifica W3C SRI',
        'description' => 'La specifica ufficiale del W3C che definisce lo standard Subresource Integrity.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Tabella di compatibilità dei browser per l\'attributo integrity.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/it/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN: SubtleCrypto.digest()',
        'description' => 'Documentazione dell\'API Web Crypto utilizzata da questo strumento per l\'hashing sicuro.',
    ],
];

include __DIR__ . '/../../partials/tool-base.php';
