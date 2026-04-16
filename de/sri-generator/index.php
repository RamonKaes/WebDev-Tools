<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'de';

$featuresSectionTitle = 'Funktionen';
$features = [
    'SRI-Hashes aus URL, Datei-Upload oder eingefügtem Text generieren',
    'Unterstützt SHA-256, SHA-384 (empfohlen) und SHA-512 gleichzeitig',
    'Erzeugt fertige <script>- und <link>-HTML-Tags',
    'Integrity-Attribut und vollständigen HTML-Tag mit einem Klick kopieren',
    'Datenschutz: Alle Hash-Berechnungen laufen client-seitig im Browser',
    'Schnellbeispiele für Bootstrap, jQuery und Alpine.js',
    'Erkennt Ressourcentyp (JS vs. CSS) automatisch aus URL oder Dateiname',
];

$resourcesSectionTitle = 'Nützliche Ressourcen';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/de/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN: Subresource Integrity',
        'description' => 'Offizielle MDN-Dokumentation zu SRI, Browser-Unterstützung und wie die Integritätsprüfung funktioniert.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'W3C SRI-Spezifikation',
        'description' => 'Die offizielle W3C-Spezifikation, die den Subresource Integrity Standard definiert.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Browser-Kompatibilitätstabelle für das integrity-Attribut.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/de/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN: SubtleCrypto.digest()',
        'description' => 'Web Crypto API Dokumentation — die Browser-API, die dieses Tool für sicheres Hashing verwendet.',
    ],
];

$additionalSections = [
    [
        'title'   => 'Was ist Subresource Integrity?',
        'icon'    => 'info-circle',
        'content' => <<<HTML
<p>
  <strong>Subresource Integrity (SRI)</strong> ist eine Sicherheitsfunktion, die es Browsern ermöglicht,
  zu überprüfen, ob von einem CDN oder Drittanbieter geladene Ressourcen nicht manipuliert wurden.
  Beim Einbinden eines externen Skripts oder Stylesheets berechnet der Browser dessen Hash und vergleicht
  ihn mit dem im <code>integrity</code>-Attribut angegebenen Wert — bei Abweichung wird die Ressource geblockt.
</p>
<p>
  SRI ist besonders wichtig für CDN-Ressourcen, bei denen kein Zugriff auf den Server besteht.
  Selbst bei einem kompromittierten CDN verhindert SRI die Ausführung schadhafter Dateien.
</p>
<pre class="bg-body-secondary p-3 rounded"><code>&lt;script src="https://cdn.example.com/lib.min.js"
        integrity="sha384-abc123..."
        crossorigin="anonymous"&gt;&lt;/script&gt;</code></pre>
HTML,
    ],
    [
        'title'   => 'Welchen Algorithmus sollte ich verwenden?',
        'icon'    => 'shield-check',
        'content' => <<<HTML
<ul>
  <li><strong>SHA-384</strong> — Empfohlen. Starke Sicherheit, weit verbreitet, Standardwahl für CDN-Ressourcen.</li>
  <li><strong>SHA-512</strong> — Maximale Sicherheit. Für höchste Integritätsanforderungen.</li>
  <li><strong>SHA-256</strong> — Unterstützt, aber SHA-384+ wird für neue Projekte bevorzugt.</li>
</ul>
<p>
  Mehrere Hashes können durch Leerzeichen getrennt in einem einzigen <code>integrity</code>-Attribut
  angegeben werden. Der Browser wählt den stärksten unterstützten Algorithmus.
</p>
HTML,
    ],
];

include __DIR__ . '/../../partials/tool-base.php';
