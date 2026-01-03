<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'de';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Hunderte von Emojis</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Kategoriefilterung</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Stichwortsuche</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unicode-Informationen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Ein-Klick-Kopie</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Entwicklerfokussierte Kategorien</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://unicode.org/emoji/charts/full-emoji-list.html',
        'title' => 'Unicode Full Emoji List',
        'description' => 'Offizielle Unicode Consortium vollständige Emoji-Referenz'
    ],
    [
        'url' => 'https://emojipedia.org/',
        'title' => 'Emojipedia',
        'description' => 'Umfassende Emoji-Enzyklopädie mit Bedeutungen und Plattformvariationen'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCodePoint',
        'title' => 'MDN String.fromCodePoint()',
        'description' => 'JavaScript-Methode zum Erstellen von Strings aus Unicode-Codepunkten'
    ],
    [
        'url' => 'https://www.w3.org/TR/emoji/',
        'title' => 'W3C Emoji Requirements',
        'description' => 'Technische Spezifikationen für Emoji-Implementierung in Webstandards'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
