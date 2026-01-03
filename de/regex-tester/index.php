<?php

declare(strict_types=1);

$toolId = 'regexTesterTool';
$lang = 'de';



$toolId = 'regexTesterTool';
$lang = 'de';


$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Reguläre Ausdrücke testen</h2>
<ul class="mb-0">
    <li>JavaScript Engine: Dieses Tool nutzt JavaScripts RegExp-Engine zum Testen von Mustern</li>
    <li>Live-Testing: Teste deine Muster gegen echten Text mit sofortigem visuellem Feedback</li>
    <li>Datenschutz: Alle Tests erfolgen lokal in deinem Browser - keine Daten werden an Server gesendet</li>
</ul>
HTML;


$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/de/docs/Web/JavaScript/Guide/Regular_expressions',
        'title' => 'MDN Reguläre Ausdrücke Leitfaden',
        'description' => 'Umfassender Leitfaden zu regulären Ausdrücken in JavaScript von Mozilla'
    ],
    [
        'url' => 'https://www.regular-expressions.info/',
        'title' => 'Regular-Expressions.info',
        'description' => 'Ausführliches Tutorial und Referenz für Regex-Muster und Syntax'
    ],
    [
        'url' => 'https://regexr.com/',
        'title' => 'RegExr - Community-Muster',
        'description' => 'Lerne Regex mit Tausenden von Community-beigesteuerten Mustern'
    ],
    [
        'url' => 'https://regex101.com/',
        'title' => 'Regex101 - Testing & Debugger',
        'description' => 'Fortgeschrittenes Regex-Testing mit Erklärung und Visualisierung'
    ]
];


include __DIR__ . '/../../partials/tool-base.php';
