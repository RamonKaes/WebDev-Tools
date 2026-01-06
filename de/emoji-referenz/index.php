<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'emojiReferenceTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$features = [
    'Hunderte von Emojis',
    'Kategoriefilterung',
    'Stichwortsuche',
    'Unicode-Informationen',
    'Ein-Klick-Kopie',
    'Entwicklerfokussierte Kategorien'
];

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
