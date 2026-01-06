<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'hashGeneratorTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$customAboutContent = <<<HTML
<p class="mb-2">
    Gere hashes criptográficos para textos e arquivos usando diversos algoritmos.
    Útil para verificar integridade de dados, criar resumos e apoiar fluxos de segurança.
</p>
<p class="mb-0">
    Suporta algoritmos populares como MD5, SHA-1, SHA-256, SHA-512 e outros.
    Todo o processamento acontece no seu navegador, preservando a privacidade.
</p>
HTML;

$features = [
    'Algoritmos: MD5, SHA-1, SHA-256, SHA-384, SHA-512',
    'Hash para texto e arquivos',
    'Comparação de hashes para verificação',
    'Suporte a HMAC com chave personalizada',
    'Saída em maiúsculas ou minúsculas',
    'Cópia com um clique',
    'Geração em tempo real',
    'Processamento 100% local'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Considerações de segurança</h2>
    <ul class="mb-0">
        <li>Prefira SHA-256 ou superior: MD5 e SHA-1 estão comprometidos</li>
        <li>Não use hashes simples para senhas: utilize bcrypt, scrypt ou PBKDF2</li>
        <li>Adicione salt: previne ataques com tabelas rainbow</li>
        <li>Compare o hash completo: evite validar por trechos truncados</li>
        <li>Use HMAC para autenticação: garante integridade e autenticidade</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Integridade de arquivos: confirmar se downloads não foram alterados</li>
    <li>Armazenamento de senhas: guardar hashes fortes (SHA-256 ou superior)</li>
    <li>Deduplicação: identificar arquivos ou conteúdos duplicados</li>
    <li>Checksums: gerar resumos para validação de dados</li>
    <li>Assinaturas digitais: componente essencial de sistemas criptográficos</li>
    <li>Autenticação de APIs: gerar assinaturas HMAC para requisições</li>
</ul>
HTML
    ],
    [
        'title' => 'Escolha do algoritmo',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5: rápido, mas inseguro (128 bits, colisões conhecidas)</li>
    <li>SHA-1: desaconselhado (160 bits, ataques de colisão viáveis)</li>
    <li>SHA-256: padrão do mercado para segurança (256 bits)</li>
    <li>SHA-384: variante de alta segurança (384 bits)</li>
    <li>SHA-512: variante de segurança máxima (512 bits)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'NIST: funções hash criptográficas',
        'description' => 'Documentação oficial do NIST sobre algoritmos de hash'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Secure_Hash_Algorithms',
        'title' => 'SHA (Secure Hash Algorithms)',
        'description' => 'Visão geral da família SHA e estado da segurança'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'Documentação da API de digest criptográfico no navegador'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP Password Storage Cheat Sheet',
        'description' => 'Boas práticas para armazenamento seguro de senhas'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
