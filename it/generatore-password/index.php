<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'it';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera password robuste e sicure con lunghezza e set di caratteri personalizzabili.
    Perfetto per soddisfare requisiti di sicurezza stringenti.
</p>
<p class="mb-0">
    Lo strumento utilizza il generatore di numeri casuali crittograficamente sicuro del browser.
    Tutto avviene in locale: le password non lasciano mai il tuo dispositivo.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Lunghezza configurabile (4-128 caratteri)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Includi lettere maiuscole, minuscole, numeri e simboli</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escludi caratteri ambigui (0, O, l, 1, ...)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Genera più password contemporaneamente</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indicatore di robustezza</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia negli appunti con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% lato client: nessun dato inviato al server</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Consigli di sicurezza</h2>
    <ul class="mb-0">
        <li>La lunghezza conta: password più lunghe sono esponenzialmente più sicure</li>
        <li>Mescola i caratteri: combina maiuscole, minuscole, numeri e simboli</li>
        <li>Evita schemi prevedibili: niente parole comuni o dati personali</li>
        <li>Password uniche: non riutilizzare la stessa password su più servizi</li>
        <li>Usa un password manager: conserva in modo sicuro le credenziali generate</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Account utente: creare password sicure per nuovi accessi</li>
    <li>Chiavi API: generare stringhe casuali per l\'autenticazione</li>
    <li>Credenziali database: proteggere l\'accesso ai sistemi</li>
    <li>Reti Wi-Fi: impostare password WPA2/WPA3 resistenti</li>
    <li>Chiavi di cifratura: creare passphrase sicure</li>
    <li>Amministrazione di sistema: mettere al sicuro account root e admin</li>
</ul>
HTML
    ],
    [
        'title' => 'Scala di robustezza',
        'content' => <<<HTML
<ul>
    <li>Debole (&lt; 8 caratteri): facile da violare, da evitare</li>
    <li>Discreta (8-11 caratteri): minima accettabile per molti servizi</li>
    <li>Buona (12-15 caratteri): consigliata per account importanti</li>
    <li>Forte (16+ caratteri): sicurezza elevata, molto difficile da forzare</li>
    <li>Molto forte (20+ caratteri): livello massimo per sistemi critici</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://it.wikipedia.org/wiki/Password',
        'title' => 'Wikipedia: Password',
        'description' => 'Introduzione accessibile ai concetti di sicurezza delle password'
    ],
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B: linee guida per l\'identità digitale',
        'description' => 'Raccomandazioni ufficiali per gestione password e autenticazione'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP: promemoria autenticazione',
        'description' => 'Best practice per l\'autenticazione basata su password'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'API per generare numeri casuali crittograficamente sicuri'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'EFF Diceware',
        'description' => 'Metodo alternativo per creare passphrase robuste e memorizzabili'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
