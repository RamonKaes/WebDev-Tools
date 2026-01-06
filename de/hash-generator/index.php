<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'hashGeneratorTool';
$lang = 'de';
$featuresSectionTitle = 'Funktionen';
$resourcesSectionTitle = 'Nützliche Ressourcen';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generieren Sie kryptografische Hashes für Text und Dateien mit mehreren Algorithmen. 
    Perfekt für Datenintegritätsprüfung, Passwort-Hashing und Sicherheitsanwendungen.
</p>
<p class="mb-0">
    Dieses Tool unterstützt gängige Hashing-Algorithmen wie MD5, SHA-1, SHA-256, SHA-512 
    und mehr. Alle Hashing-Vorgänge werden clientseitig für maximale Privatsphäre und Sicherheit durchgeführt.
</p>
HTML;

$features = [
    'Mehrere Hash-Algorithmen: MD5, SHA-1, SHA-256, SHA-384, SHA-512',
    'Text und Dateien hashen',
    'Hashes zur Verifikation vergleichen',
    'HMAC-Unterstützung mit benutzerdefinierten Schlüsseln',
    'Groß- und Kleinschreibung Ausgabeoptionen',
    'Hashes mit einem Klick kopieren',
    'Echtzeit Hash-Generierung',
    '100% clientseitige Verarbeitung - Ihre Daten verlassen niemals Ihren Browser'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Sicherheitsüberlegungen</h2>
    <ul class="mb-0">
        <li>SHA-256 oder höher verwenden: MD5 und SHA-1 sind kryptografisch gebrochen</li>
        <li>Keine einfachen Hashes für Passwörter: Verwenden Sie stattdessen bcrypt, scrypt oder PBKDF2</li>
        <li>Salts für Passwort-Hashing hinzufügen: Verhindert Rainbow-Table-Angriffe</li>
        <li>Hash-Integrität überprüfen: Vergleichen Sie immer vollständige Hash-Werte, nicht gekürzte Versionen</li>
        <li>HMAC für Authentifizierung verwenden: Bietet sowohl Integrität als auch Authentizität</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'content' => <<<HTML
<ul>
    <li>Dateiintegritätsprüfung: Überprüfen Sie, ob Downloads nicht manipuliert wurden</li>
    <li>Passwort-Hashing: Speichern Sie sichere Passwort-Hashes (SHA-256 oder höher verwenden)</li>
    <li>Datendeduplizierung: Identifizieren Sie doppelte Dateien oder Inhalte</li>
    <li>Prüfsummengenerierung: Erstellen Sie Prüfsummen zur Datenvalidierung</li>
    <li>Digitale Signaturen: Komponente kryptografischer Signatursysteme</li>
    <li>API-Authentifizierung: Generieren Sie HMAC-Signaturen für API-Anfragen</li>
</ul>
HTML
    ],
    [
        'title' => 'Hash-Algorithmus Auswahl',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5: Schnell, aber nicht für Sicherheit empfohlen (128-Bit, anfällig für Kollisionen)</li>
    <li>SHA-1: Veraltet für Sicherheitsanwendungen (160-Bit, Kollisionsangriffe existieren)</li>
    <li>SHA-256: Industriestandard für Sicherheitsanwendungen (256-Bit, sicher)</li>
    <li>SHA-384: Hochsicherheitsvariante (384-Bit, sehr sicher)</li>
    <li>SHA-512: Maximale Sicherheitsvariante (512-Bit, sehr sicher)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'NIST Kryptografische Hash-Funktionen',
        'description' => 'Offizielle NIST-Dokumentation und Standards für Hash-Algorithmen'
    ],
    [
        'url' => 'https://de.wikipedia.org/wiki/Secure_Hash_Algorithm',
        'title' => 'Secure Hash Algorithm (SHA) - Wikipedia',
        'description' => 'Umfassender Überblick über SHA-Algorithmen und ihre Sicherheit'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'Browser-API-Dokumentation für kryptografische Hash-Generierung'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP Passwort-Speicherung Best Practices',
        'description' => 'Sicherheitsrichtlinien für Passwort-Hashing und -Speicherung'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
