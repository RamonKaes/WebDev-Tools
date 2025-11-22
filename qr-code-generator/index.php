<?php

declare(strict_types=1);

$toolId = 'qrCodeGeneratorTool';
$lang = 'en';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generate QR codes instantly for URLs, text, contact information, and more. 
    Customize colors, size, and error correction level.
</p>
<p class="mb-0">
    QR (Quick Response) codes are two-dimensional barcodes that can store various types 
    of data and be scanned by smartphones and QR readers. All QR code generation happens 
    in your browser - no data is sent to external servers.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generate QR codes for URLs, text, phone numbers, emails, and more</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Customizable size and quality</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Custom foreground and background colors</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Error correction levels (L, M, Q, H)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Download as PNG or SVG</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time preview</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% client-side generation</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Error Correction Levels</h3>
    <ul class="mb-0">
        <li>L (Low): ~7% error correction - use for clean environments</li>
        <li>M (Medium): ~15% error correction - recommended for most use cases</li>
        <li>Q (Quartile): ~25% error correction - better damage tolerance</li>
        <li>H (High): ~30% error correction - maximum reliability</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>Website URLs: Quick access to websites from printed materials</li>
    <li>Contact Information: vCards for easy contact sharing</li>
    <li>Wi-Fi Credentials: Share network access without typing</li>
    <li>Product Information: Link to manuals or product details</li>
    <li>Event Tickets: Digital tickets and check-in systems</li>
    <li>Payment Links: Quick payment processing</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015 QR Code Standard',
        'description' => 'Official international standard for QR code symbology'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - Official QR Code Information',
        'description' => 'Information from DENSO WAVE, the original developer of QR codes'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'QRCode.js Library Documentation',
        'description' => 'JavaScript library for generating QR codes in the browser'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/QR_code',
        'title' => 'QR Code - Wikipedia',
        'description' => 'Comprehensive overview of QR code technology and applications'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
