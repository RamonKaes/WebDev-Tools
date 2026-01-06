<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';

$customAboutContent = <<<HTML
<p class="mb-2">
    Gere senhas fortes e seguras com comprimento e conjuntos de caracteres personalizáveis.
    Ideal para atender a requisitos rigorosos de segurança.
</p>
<p class="mb-0">
    A ferramenta usa o gerador de números aleatórios criptograficamente seguro do navegador.
    Todo o processo ocorre localmente: as senhas nunca deixam o seu dispositivo.
</p>
HTML;

$features = [
    'Comprimento configurável (4-128 caracteres)',
    'Inclua letras maiúsculas, minúsculas, números e símbolos',
    'Exclua caracteres ambíguos (0, O, l, 1, ...)',
    'Gere várias senhas de uma vez',
    'Indicador de força da senha',
    'Copie para a área de transferência com um clique',
    '100% no lado do cliente: nenhuma senha é enviada ao servidor'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Dicas de segurança</h2>
    <ul class="mb-0">
        <li>Comprimento importa: senhas mais longas são exponencialmente mais seguras</li>
        <li>Varie os caracteres: combine maiúsculas, minúsculas, números e símbolos</li>
        <li>Evite padrões previsíveis: não use palavras comuns ou dados pessoais</li>
        <li>Senhas exclusivas: nunca reutilize a mesma senha em serviços diferentes</li>
        <li>Use um gerenciador de senhas: armazene as credenciais geradas com segurança</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Contas de usuário: criar senhas seguras para novos acessos</li>
    <li>Chaves de API: gerar strings aleatórias para autenticação</li>
    <li>Credenciais de banco de dados: proteger o acesso a sistemas</li>
    <li>Redes Wi-Fi: definir senhas WPA2/WPA3 robustas</li>
    <li>Chaves de criptografia: criar passphrases seguras</li>
    <li>Administração de sistemas: proteger contas root e administrativas</li>
</ul>
HTML
    ],
    [
        'title' => 'Guia de força',
        'content' => <<<HTML
<ul>
    <li>Fraca (&lt; 8 caracteres): fácil de quebrar, evite</li>
    <li>Razoável (8-11 caracteres): mínimo aceitável para muitos serviços</li>
    <li>Boa (12-15 caracteres): recomendada para contas importantes</li>
    <li>Forte (16+ caracteres): segurança elevada, difícil de comprometer</li>
    <li>Muito forte (20+ caracteres): ideal para sistemas críticos</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pt.wikipedia.org/wiki/Senha',
        'title' => 'Wikipedia: Senha',
        'description' => 'Introdução acessível aos conceitos de segurança de senhas'
    ],
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B: diretrizes de identidade digital',
        'description' => 'Recomendações oficiais para criação de senhas e autenticação'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP Authentication Cheat Sheet',
        'description' => 'Boas práticas de segurança para autenticação baseada em senhas'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'API para gerar números aleatórios criptograficamente seguros'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'EFF Diceware',
        'description' => 'Método alternativo para criar passphrases fortes e memoráveis'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
