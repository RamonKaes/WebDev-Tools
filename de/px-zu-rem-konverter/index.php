<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'de';
$customAboutContent = <<<HTML
<p class="mb-2">Konvertieren Sie schnell und präzise zwischen Pixeln (px) und rem-Einheiten. Unverzichtbar für responsives Webdesign und barrierefreie Typografie.</p>
<p>Die rem (root em) Einheit ist relativ zur Schriftgröße des Root-Elements, was sie ideal für die Erstellung skalierbarer und barrierefreier Interfaces macht. Dieses Tool hilft Ihnen, px-Werte basierend auf Ihrer Basis-Schriftgröße in rem zu konvertieren und umgekehrt.</p>
HTML;
$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>px zu rem und rem zu px konvertieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anpassbare Basis-Schriftgröße (Standard: 16px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Batch-Konvertierung: mehrere Werte auf einmal konvertieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Echtzeit-Konvertierung während der Eingabe</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Konvertierte Werte mit einem Klick kopieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Gängige Breakpoint-Vorlagen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% clientseitige Verarbeitung</li>
</ul>
HTML;
$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Warum rem-Einheiten verwenden?</h2>
    <ul class="mb-0">
        <li>Barrierefreiheit: Benutzer können die Schriftgröße ihres Browsers anpassen</li>
        <li>Konsistenz: Alle Größen skalieren proportional</li>
        <li>Responsives Design: Einfacher über verschiedene Bildschirmgrößen zu warten</li>
        <li>Best Practice: Industriestandard für moderne Webentwicklung</li>
    </ul>
HTML;
$additionalSections = [[
    'title' => 'Häufige Anwendungsfälle',
    'content' => <<<HTML
<ul>
    <li>Typografie: Schriftgrößen von px zu rem konvertieren</li>
    <li>Abstände: Ränder und Abstände in rem-Einheiten konvertieren</li>
    <li>Responsive Breakpoints: Media Queries in rem definieren</li>
    <li>Komponenten-Skalierung: UI-Komponenten proportional skalieren</li>
    <li>Barrierefreiheits-Konformität: WCAG-Richtlinien erfüllen</li>
</ul>
HTML
], [
    'title' => 'rem vs em vs px',
    'content' => <<<HTML
<ul>
    <li>px: Absolute Einheit, feste Größe unabhängig vom Kontext</li>
    <li>em: Relativ zur Schriftgröße des Elternelements (kann sich vervielfachen)</li>
    <li>rem: Relativ zur Schriftgröße des Root-Elements (konsistent)</li>
    <li>Empfehlung: rem für globale Größen, em für komponentenspezifische Skalierung verwenden</li>
</ul>
HTML
]];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN CSS-Werte und -Einheiten',
        'description' => 'Vollständiger Leitfaden zu CSS-Einheiten inkl. px, rem und em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Module Level 3',
        'description' => 'Offizielle Spezifikation für CSS-rem-Einheiten'
    ],
    [
        'url' => 'https://css-tricks.com/rems-ems/',
        'title' => 'CSS-Tricks: px am Root, rem für Komponenten',
        'description' => 'Best Practices für die Verwendung von rem im responsiven Design'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixels vs. relative Einheiten in CSS',
        'description' => 'Barrierefreiheits-Vorteile von rem gegenüber px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
