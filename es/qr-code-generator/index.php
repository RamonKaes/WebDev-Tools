<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'qrCodeGeneratorTool';
$lang = 'es';$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';
$customAboutContent = <<<HTML
<p class="mb-2">
    Genera códigos QR al instante para URLs, texto, información de contacto y más.
    Personaliza colores, tamaño y nivel de corrección de errores.
</p>
<p class="mb-0">
    Los códigos QR (Quick Response) son códigos bidimensionales capaces de almacenar distintos tipos de datos
    y pueden ser escaneados por smartphones o lectores QR. Toda la generación ocurre en tu navegador:
    no se envían datos a servidores externos.
</p>
HTML;

$features = [
    'Genera códigos QR para URLs, texto, teléfonos, correos y más',
    'Tamaño y calidad configurables',
    'Colores de primer plano y fondo personalizables',
    'Niveles de corrección de error (L, M, Q, H)',
    'Descarga en PNG o SVG',
    'Vista previa en tiempo real',
    'Generación 100 % local'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Niveles de corrección de errores</h2>
    <ul class="mb-0">
        <li>L (Bajo): ~7 % de corrección; útil en entornos controlados</li>
        <li>M (Medio): ~15 % de corrección; recomendado para la mayoría de casos</li>
        <li>Q (Cuartil): ~25 % de corrección; mayor tolerancia a daños</li>
        <li>H (Alto): ~30 % de corrección; máxima fiabilidad</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>URLs de sitios web: acceso rápido desde materiales impresos</li>
    <li>Información de contacto: vCards para compartir datos fácilmente</li>
    <li>Credenciales Wi-Fi: compartir acceso sin teclear</li>
    <li>Información de producto: enlazar a manuales o fichas técnicas</li>
    <li>Entradas y eventos: tickets digitales y sistemas de check-in</li>
    <li>Pagos: enlaces para pagos rápidos</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015 - estándar QR Code',
        'description' => 'Norma internacional que define la simbología del código QR'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - Información oficial',
        'description' => 'Información proporcionada por DENSO WAVE, creador del código QR'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'Documentación de la librería QRCode.js',
        'description' => 'Biblioteca JavaScript para generar códigos QR en el navegador'
    ],
    [
        'url' => 'https://es.wikipedia.org/wiki/C%C3%B3digo_QR',
        'title' => 'Código QR - Wikipedia',
        'description' => 'Descripción general de la tecnología QR y sus aplicaciones'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
