<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'qrCodeGeneratorTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';
$customAboutContent = <<<HTML
<p class="mb-2">Generieren Sie sofort QR-Codes für URLs, Text, Kontaktinformationen und mehr. Passen Sie Farben, Größe und Fehlerkorrekturlevel an.</p>
<p>QR (Quick Response) Codes sind zweidimensionale Barcodes, die verschiedene Datentypen speichern und von Smartphones und QR-Lesern gescannt werden können. Alle QR-Code-Generierung erfolgt in Ihrem Browser - keine Daten werden an externe Server gesendet.</p>
HTML;
$features = [
    'QR-Codes für URLs, Text, Telefonnummern, E-Mails und mehr generieren',
    'Anpassbare Größe und Qualität',
    'Benutzerdefinierte Vorder- und Hintergrundfarben',
    'Fehlerkorrekturlevel (L, M, Q, H)',
    'Als PNG oder SVG herunterladen',
    'Echtzeit-Vorschau',
    '100% clientseitige Generierung'
];
$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Fehlerkorrekturlevel</h2>
    <ul class="mb-0">
        <li>L (Niedrig): ~7% Fehlerkorrektur - für saubere Umgebungen verwenden</li>
        <li>M (Mittel): ~15% Fehlerkorrektur - für die meisten Anwendungsfälle empfohlen</li>
        <li>Q (Viertel): ~25% Fehlerkorrektur - bessere Schadenstoleranz</li>
        <li>H (Hoch): ~30% Fehlerkorrektur - maximale Zuverlässigkeit</li>
    </ul>
HTML;
$additionalSections = [[
    'title' => 'Häufige Anwendungsfälle',
    'content' => <<<HTML
<ul>
    <li>Website-URLs: Schneller Zugriff auf Websites von gedruckten Materialien</li>
    <li>Kontaktinformationen: vCards zum einfachen Austausch von Kontakten</li>
    <li>WLAN-Zugangsdaten: Netzwerkzugang ohne Tippen teilen</li>
    <li>Produktinformationen: Link zu Handbüchern oder Produktdetails</li>
    <li>Veranstaltungstickets: Digitale Tickets und Check-in-Systeme</li>
    <li>Zahlungslinks: Schnelle Zahlungsabwicklung</li>
</ul>
HTML
]];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015 QR-Code-Standard',
        'description' => 'Offizieller internationaler Standard für QR-Code-Symbologie'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - Offizielle QR-Code-Informationen',
        'description' => 'Informationen von DENSO WAVE, dem ursprünglichen Entwickler von QR-Codes'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'QRCode.js Bibliotheks-Dokumentation',
        'description' => 'JavaScript-Bibliothek zur Generierung von QR-Codes im Browser'
    ],
    [
        'url' => 'https://de.wikipedia.org/wiki/QR-Code',
        'title' => 'QR-Code - Wikipedia',
        'description' => 'Umfassender Überblick über QR-Code-Technologie und Anwendungen'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
