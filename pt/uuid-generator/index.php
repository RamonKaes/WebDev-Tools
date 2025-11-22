<?php

declare(strict_types=1);

$toolId = 'uuidGeneratorTool';
$lang = 'pt';

$customAboutContent = <<<HTML
<p class="mb-2">
    Gere identificadores exclusivos (UUID/GUID) instantaneamente para aplicações, bancos de dados e APIs.
    Suporta múltiplas versões de UUID com geração criptograficamente segura.
</p>
<p class="mb-0">
    UUIDs (Universally Unique Identifiers) são valores de 128 bits usados para identificar informações sem colisões.
    Esta ferramenta gera UUIDs compatíveis com os padrões, garantindo unicidade em escala global.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Geração de UUID v4 (aleatório) com segurança criptográfica</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Geração em lote: crie vários UUIDs de uma vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formatos: padrão, maiúsculo, sem hífens</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie UUIDs individualmente ou todos de uma vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conformidade com RFC 4122</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Processamento 100% no navegador</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Geração instantânea sem atrasos</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Sobre UUID versão 4</h2>
    <p class="mb-2">
        UUID v4 utiliza números aleatórios. O formato é:
    </p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">
        Onde <code>x</code> é qualquer dígito hexadecimal e <code>y</code> é 8, 9, A ou B.
        O dígito 4 indica a versão do UUID e os bits de variante garantem conformidade com a RFC.
        Com 122 bits aleatórios, a probabilidade de colisão é extremamente baixa.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Chaves primárias: identificadores únicos em bancos de dados</li>
    <li>IDs de requisição: rastrear chamadas de API</li>
    <li>Tokens de sessão: gerar identificadores seguros</li>
    <li>Nomes de arquivo: evitar conflitos ao salvar arquivos</li>
    <li>Sistemas distribuídos: gerar IDs sem coordenação central</li>
    <li>Transações: identificar operações financeiras ou de negócio</li>
</ul>
HTML
    ],
    [
        'title' => 'Formato do UUID',
        'content' => <<<HTML
<p>Um UUID é representado por 32 caracteres hexadecimais em 5 grupos:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Exemplo: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Formato padrão: minúsculas com hífens (mais comum)</li>
    <li>Formato maiúsculo: maiúsculas com hífens (algumas APIs exigem)</li>
    <li>Formato compacto: 32 caracteres sem hífens</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122: UUID',
        'description' => 'Especificação oficial para formato e geração de UUIDs'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562: UUID v6, v7 e v8',
        'description' => 'Padrões recentes para novas versões de UUID'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'API do navegador para gerar UUIDs seguros'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Universally_unique_identifier',
        'title' => 'UUID - Wikipedia',
        'description' => 'Visão geral e aplicações das diferentes versões de UUID'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
