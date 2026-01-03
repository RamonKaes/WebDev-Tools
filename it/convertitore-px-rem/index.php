<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'pxToRemConverter';
$lang = 'it';

$customAboutContent = <<<HTML
<p class="mb-2">
    Converti rapidamente tra pixel (px) e unità rem.
    Essenziale per il design responsive e una tipografia accessibile.
</p>
<p class="mb-0">
    L'unità rem (root em) è relativa alla dimensione del font dell'elemento radice, rendendola ideale
    per creare interfacce scalabili e accessibili. Questo strumento ti aiuta a convertire valori px in rem e viceversa
    in base alla dimensione del font impostata.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversione px → rem e rem → px</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Dimensione font base personalizzabile (predefinito: 16 px)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conversione batch: più valori contemporaneamente</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Risultati in tempo reale mentre digiti</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia i valori convertiti con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Preset dei breakpoint più comuni</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Elaborazione 100% nel browser</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Perché usare le unità rem?</h2>
    <ul class="mb-0">
        <li>Accessibilità: gli utenti possono regolare la dimensione del font nel browser</li>
        <li>Coerenza: tutte le misure scalano proporzionalmente</li>
        <li>Design responsive: manutenzione più semplice su dispositivi diversi</li>
        <li>Best practice: standard raccomandato nello sviluppo moderno</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Tipografia: convertire dimensioni font da px a rem</li>
    <li>Spaziatura: trasformare margini e padding in rem</li>
    <li>Breakpoint: definire media query in rem</li>
    <li>Dimensione componenti: scalare elementi UI in modo uniforme</li>
    <li>Accessibilità: rispettare le linee guida WCAG</li>
</ul>
HTML
    ],
    [
        'title' => 'rem vs em vs px',
        'content' => <<<HTML
<ul>
    <li>px: unità assoluta, dimensione fissa indipendentemente dal contesto</li>
    <li>em: relativo alla dimensione del font dell'elemento genitore (può accumularsi)</li>
    <li>rem: relativo alla dimensione del font radice (coerente)</li>
    <li>Raccomandazione: usa rem per scale globali ed em per regolazioni locali</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Values_and_units',
        'title' => 'MDN: valori e unità CSS',
        'description' => 'Guida completa sulle unità CSS inclusi px, rem ed em'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-values-3/#rem',
        'title' => 'W3C CSS Values and Units Level 3',
        'description' => 'Specifica ufficiale W3C per l\'unità rem'
    ],
    [
        'url' => 'https://css-tricks.com/rems-ems/',
        'title' => 'CSS-Tricks: rems ed ems',
        'description' => 'Best practice per usare rem nel design responsive'
    ],
    [
        'url' => 'https://www.24a11y.com/2019/pixels-vs-relative-units-in-css-why-its-still-a-big-deal/',
        'title' => 'Pixel vs. unità relative in CSS',
        'description' => 'Vantaggi di accessibilità preferendo rem rispetto a px'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
