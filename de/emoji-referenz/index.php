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
        'url' => 'https://de.wikipedia.org/wiki/Emoji',
        'title' => 'Wikipedia: Emoji',
        'description' => 'Einsteigerfreundliche Einführung in die Geschichte und Verwendung von Emojis'
    ],
    [
        'url' => 'https://unicode.org/emoji/charts/',
        'title' => 'Unicode Emoji Charts',
        'description' => 'Offizielle Unicode Consortium Emoji-Referenz und Dokumentation'
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
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
