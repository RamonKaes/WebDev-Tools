<?php

declare(strict_types=1);

$toolId = 'qrCodeGeneratorTool';
$lang = 'pt';

$customAboutContent = <<<HTML
<p class="mb-2">
    Gere códigos QR instantaneamente para URLs, textos, contatos e muito mais.
    Personalize cores, tamanho e nível de correção de erro.
</p>
<p class="mb-0">
    QR (Quick Response) é um código bidimensional capaz de armazenar diferentes tipos de dados
    e pode ser lido por smartphones e scanners dedicados. Toda a geração acontece no navegador,
    sem enviar dados para servidores externos.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Crie QR codes para URLs, textos, telefones, e-mails e muito mais</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Tamanho e qualidade configuráveis</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cores personalizadas de fundo e primeiro plano</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Níveis de correção de erro (L, M, Q, H)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Download como PNG ou SVG</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pré-visualização em tempo real</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Geração 100% local</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Níveis de correção de erro</h2>
    <ul class="mb-0">
        <li>L (Low): ~7% de recuperação – indicado para ambientes controlados</li>
        <li>M (Medium): ~15% de recuperação – recomendado para a maioria dos casos</li>
        <li>Q (Quartile): ~25% de recuperação – maior tolerância a danos</li>
        <li>H (High): ~30% de recuperação – máxima confiabilidade</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>URLs: acesso rápido a sites em materiais impressos</li>
    <li>Informações de contato: vCards para compartilhamento fácil</li>
    <li>Credenciais Wi-Fi: compartilhe redes sem digitar senhas</li>
    <li>Dados de produtos: link para manuais ou detalhes técnicos</li>
    <li>Ingressos: check-in digital para eventos</li>
    <li>Pagamentos: facilitar links de pagamento instantâneo</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015',
        'description' => 'Padrão internacional oficial para simbologia de QR code'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - Informações oficiais',
        'description' => 'Conteúdo da DENSO WAVE, criadora do QR code'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'QRCode.js',
        'description' => 'Biblioteca JavaScript para gerar QR codes no navegador'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/QR_code',
        'title' => 'QR Code - Wikipedia',
        'description' => 'Visão geral da tecnologia e aplicações de QR code'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
