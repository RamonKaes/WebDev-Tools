<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'de';

$customAboutContent = <<<HTML
<p class="mb-2">
    Berechnen Sie fehlende Dimensionen, bewahren Sie Seitenverhältnisse und generieren Sie CSS für responsive Medien. 
    Unverzichtbar für responsive Bilder, Videos und Layouts.
</p>
<p class="mb-0">
    Das Seitenverhältnis beschreibt das proportionale Verhältnis zwischen Breite und Höhe. Dieses Tool hilft Ihnen, 
    Dimensionen zu berechnen, zwischen Verhältnis-Formaten umzuwandeln und CSS-Code zu generieren, um 
    Seitenverhältnisse in responsiven Designs beizubehalten.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Berechnung fehlender Breite oder Höhe aus Seitenverhältnis</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Gängige Verhältnis-Vorlagen (16:9, 4:3, 21:9, 1:1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>CSS padding-bottom-Trick Generator</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mehrere Verhältnis-Formate (Verhältnis, Dezimal, Prozent)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Responsive Bildgrößen-Rechner</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Echtzeit-Berechnung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% clientseitige Verarbeitung</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Häufige Seitenverhältnisse</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Standard HD-Video, YouTube, moderne Displays</li>
        <li><strong>4:3</strong> — Klassisches TV, ältere Monitore</li>
        <li><strong>21:9</strong> — Ultrawide-Monitore, Kinoleinwand</li>
        <li><strong>1:1</strong> — Quadratisch (Instagram-Posts)</li>
        <li><strong>9:16</strong> — Vertikales Video (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'content' => <<<HTML
<ul>
    <li><strong>Responsive Bilder:</strong> Seitenverhältnis beim Skalieren von Bildern beibehalten</li>
    <li><strong>Video-Einbettungen:</strong> Iframe-Dimensionen für YouTube, Vimeo berechnen</li>
    <li><strong>CSS-Seitenverhältnis:</strong> Padding-bottom-Trick für ältere Browser generieren</li>
    <li><strong>Bildgrößen-Anpassung:</strong> Zuschneide- oder Skalierungs-Dimensionen berechnen</li>
    <li><strong>Layout-Design:</strong> Responsive Grid-Layouts planen</li>
</ul>
HTML
    ],
    [
        'title' => 'CSS-Seitenverhältnis-Techniken',
        'content' => <<<HTML
<p><strong>Moderner Ansatz (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Legacy-Ansatz (padding-bottom-Trick):</strong></p>
<pre><code>.container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 = 9/16 = 56,25% */
}

.container > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}</code></pre>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/Seitenverh%C3%A4ltnis',
        'title' => 'Wikipedia: Seitenverhältnis',
        'description' => 'Einsteigerfreundliche Einführung in Seitenverhältnisse bei Bildern und Videos'
    ],
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: CSS aspect-ratio Eigenschaft',
        'description' => 'Moderne CSS-Eigenschaft zur Beibehaltung von Seitenverhältnissen'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2019/03/aspect-ratio-unit-css/',
        'title' => 'Smashing Magazine: Aspect Ratio in CSS',
        'description' => 'Umfassende Anleitung zur Beibehaltung von Seitenverhältnissen in modernem CSS'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Offizielle Spezifikation für CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'Neue CSS Aspect-Ratio Eigenschaft',
        'description' => 'Google web.dev Anleitung zur modernen Seitenverhältnis-Behandlung'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
