<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'de';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generieren Sie starke, sichere Passwörter mit anpassbarer Länge und Zeichensätzen. 
    Perfekt zum Erstellen von Passwörtern, die spezifische Sicherheitsanforderungen erfüllen.
</p>
<p class="mb-0">
    Dieses Tool erstellt kryptografisch sichere Zufallspasswörter mithilfe des integrierten 
    Zufallszahlengenerators Ihres Browsers. Alle Passwortgenerierung erfolgt lokal - 
    Ihre Passwörter verlassen niemals Ihr Gerät.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anpassbare Passwortlänge (4-128 Zeichen)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Großbuchstaben, Kleinbuchstaben, Zahlen und Symbole einschließen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mehrdeutige Zeichen ausschließen (0,O,l,1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mehrere Passwörter auf einmal generieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Passwortstärke-Indikator</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mit einem Klick in die Zwischenablage kopieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% clientseitig - Passwörter werden nie an Server gesendet</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Passwort-Sicherheitstipps</h2>
    <ul class="mb-0">
        <li>Länge zählt: Längere Passwörter sind exponentiell sicherer</li>
        <li>Alle Zeichentypen verwenden: Mischen Sie Groß-, Kleinbuchstaben, Zahlen und Symbole</li>
        <li>Muster vermeiden: Verwenden Sie keine Wörter oder persönliche Informationen</li>
        <li>Eindeutige Passwörter: Verwenden Sie niemals Passwörter für verschiedene Konten wieder</li>
        <li>Passwort-Manager verwenden: Speichern Sie generierte Passwörter sicher</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'content' => <<<HTML
<ul>
    <li>Benutzerkonten: Sichere Passwörter für neue Konten erstellen</li>
    <li>API-Schlüssel: Zufällige Strings für API-Authentifizierung generieren</li>
    <li>Datenbank-Zugangsdaten: Datenbankzugriff mit starken Passwörtern sichern</li>
    <li>WLAN-Netzwerke: Starke WPA2/WPA3-Passwörter erstellen</li>
    <li>Verschlüsselungsschlüssel: Passphrasen für Verschlüsselung generieren</li>
    <li>Systemadministration: Admin- und Root-Kontozugriff sichern</li>
</ul>
HTML
    ],
    [
        'title' => 'Passwortstärke-Leitfaden',
        'content' => <<<HTML
<ul>
    <li><strong>Schwach (< 8 Zeichen):</strong> Leicht zu knacken, wenn möglich vermeiden</li>
    <li>Ausreichend (8-11 Zeichen): Minimum für die meisten Systeme</li>
    <li>Gut (12-15 Zeichen): Empfohlen für wichtige Konten</li>
    <li>Stark (16+ Zeichen): Ausgezeichnete Sicherheit, schwer zu knacken</li>
    <li>Sehr stark (20+ Zeichen): Maximale Sicherheit für kritische Systeme</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B: Richtlinien für digitale Identität',
        'description' => 'Offizielle Richtlinien für Passworterstellung und Authentifizierung'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP Authentifizierungs-Checkliste',
        'description' => 'Sicherheits-Best-Practices für passwortbasierte Authentifizierung'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'Kryptografisch sichere Zufallszahlengenerierungs-API'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'EFF Diceware Passphrasen-Generator',
        'description' => 'Alternative Methode für starke, merkbare Passphrasen'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
