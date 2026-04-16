<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'pt';

$featuresSectionTitle = 'Funcionalidades';
$features = [
    'Gera hashes SRI a partir de URL, upload de arquivo ou texto colado',
    'Suporta SHA-256, SHA-384 (recomendado) e SHA-512 simultaneamente',
    'Gera tags HTML <script> e <link> prontas para uso',
    'Copia o atributo integrity e a tag HTML completa com um clique',
    'Privacidade: todo o hashing é executado no navegador (client-side)',
    'Exemplos rápidos para Bootstrap, jQuery e Alpine.js',
    'Detecta automaticamente o tipo de recurso (JS ou CSS)',
];

$resourcesSectionTitle = 'Recursos úteis';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/pt-BR/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN: Subresource Integrity',
        'description' => 'Documentação oficial do MDN sobre SRI, suporte de navegadores e como funciona a verificação de integridade.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'Especificação W3C SRI',
        'description' => 'A especificação oficial do W3C que define o padrão Subresource Integrity.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Tabela de compatibilidade de navegadores para o atributo integrity.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/pt-BR/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN: SubtleCrypto.digest()',
        'description' => 'Documentação da API Web Crypto usada por esta ferramenta para hashing seguro.',
    ],
];

include __DIR__ . '/../../partials/tool-base.php';
