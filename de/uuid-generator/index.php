<?php

declare(strict_types=1);

$toolId = 'uuidGeneratorTool';
$lang = 'de';
$customAboutContent = <<<HTML
<p class="mb-2">Generieren Sie sofort eindeutige Kennungen (UUIDs/GUIDs) für Ihre Anwendungen, Datenbanken und APIs. Unterstützt mehrere UUID-Versionen mit kryptografisch sicherer Generierung.</p>
<p>UUIDs (Universally Unique Identifiers) sind 128-Bit-Werte, die zur eindeutigen Identifizierung von Informationen in Computersystemen verwendet werden. Dieses Tool generiert standardkonforme UUIDs, die garantiert über Raum und Zeit einzigartig sind.</p>
HTML;
$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>UUID v4 (zufällig) mit kryptografischer Sicherheit generieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Massengenerierung: mehrere UUIDs auf einmal erstellen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mehrere Ausgabeformate: Standard, Großbuchstaben, ohne Bindestriche</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Einzelne UUIDs oder alle auf einmal kopieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>RFC 4122 konform</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Keine Serverkommunikation - 100% clientseitig</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Sofortige Generierung ohne Verzögerungen</li>
</ul>
HTML;
$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Über UUID Version 4</h2>
    <p class="mb-2">UUID v4 verwendet Zufalls- oder Pseudozufallszahlen. Das Format ist:</p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">Wobei <code>x</code> eine beliebige hexadezimale Ziffer und <code>y</code> eine von 8, 9, A oder B ist. Die 4 zeigt die UUID-Version an, und die Varianten-Bits gewährleisten RFC-Konformität. Mit 122 Zufallsbits ist die Kollisionswahrscheinlichkeit astronomisch gering.</p>
HTML;
$additionalSections = [[
    'title' => 'Häufige Anwendungsfälle',
    'content' => <<<HTML
<ul>
    <li>Datenbank-Primärschlüssel: Eindeutige Kennungen für Datenbankdatensätze</li>
    <li>API-Anfrage-IDs: API-Anfragen verfolgen und korrelieren</li>
    <li>Session-Tokens: Sichere Session-Kennungen generieren</li>
    <li>Dateinamen: Eindeutige Dateinamen erstellen, um Konflikte zu vermeiden</li>
    <li>Verteilte Systeme: IDs ohne zentrale Koordination generieren</li>
    <li>Transaktions-IDs: Finanz- oder Geschäftstransaktionen eindeutig identifizieren</li>
</ul>
HTML
], [
    'title' => 'UUID-Format erklärt',
    'content' => <<<HTML
<p>Eine UUID wird typischerweise als 32 hexadezimale Ziffern in 5 Gruppen dargestellt:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Beispiel: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Standardformat: Kleinbuchstaben mit Bindestrichen (am häufigsten)</li>
    <li>Großbuchstabenformat: Großbuchstaben mit Bindestrichen (einige APIs bevorzugen dies)</li>
    <li>Kompaktes Format: Keine Bindestriche, nur 32 Hex-Zeichen</li>
</ul>
HTML
]];
$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122: Universally Unique IDentifier (UUID) URN Namespace',
        'description' => 'Offizielle Spezifikation für UUID-Format und -Generierung'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562: UUID Version 6, 7 und 8',
        'description' => 'Neueste UUID-Spezifikation mit neuen Versionen und zeitbasierten UUIDs'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'Browser-API zur Generierung kryptografisch sicherer UUIDs'
    ],
    [
        'url' => 'https://de.wikipedia.org/wiki/Universally_Unique_Identifier',
        'title' => 'UUID Übersicht - Wikipedia',
        'description' => 'Umfassende Erklärung zu UUID-Versionen und Anwendungsfällen'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
