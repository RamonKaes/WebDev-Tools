<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'it';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/it';
$homeUrl = BASE_PATH . '/it';
$pageTitle = 'Informativa sulla privacy – WebDev-Tools';
$pageDescription = 'Informativa sulla privacy e informazioni sulla protezione dei dati per WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
?>
<!DOCTYPE html>
<html lang="it" data-bs-theme="auto">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="noindex, follow">
  <meta name="googlebot" content="noindex, follow">
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/privacy.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php foreach ($langUrls as $hreflang => $url): ?>
    <link rel="alternate" hreflang="<?= $hreflang ?>" href="<?= htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php endforeach; ?>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>
<body class="d-flex flex-column bg-body">

<?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Informativa sulla privacy</h1>
          <p class="lead text-secondary">La tua privacy è importante</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Protezione dei dati in sintesi</h2>
            
            <h3 class="h6 mb-2">Informazioni generali</h3>
            <p>Le seguenti informazioni forniscono una semplice panoramica di ciò che accade ai vostri dati personali quando visitate questo sito web. I dati personali sono tutti i dati con cui potete essere identificati personalmente.</p>

            <h3 class="h6 mb-2 mt-3">Raccolta dei dati su questo sito web</h3>
            <p><strong>Chi è responsabile della raccolta dei dati su questo sito web?</strong></p>
            <p>Il trattamento dei dati su questo sito web è effettuato dal gestore del sito web. I suoi dati di contatto sono disponibili nell'impressum di questo sito web.</p>
            
            <p><strong>Come raccogliamo i vostri dati?</strong></p>
            <p>I vostri dati vengono raccolti, da un lato, quando ce li comunicate. Si può trattare, ad esempio, di dati che ci inviate via e-mail.</p>
            <p>Altri dati vengono raccolti automaticamente o dopo il vostro consenso durante la visita del sito web dai nostri sistemi informatici. Si tratta principalmente di dati tecnici (ad es. browser Internet, sistema operativo o ora di accesso alla pagina). La raccolta di questi dati avviene automaticamente non appena accedete a questo sito web.</p>
            
            <p><strong>Per cosa utilizziamo i vostri dati?</strong></p>
            <p>Una parte dei dati viene raccolta per garantire il corretto funzionamento del sito web. Altri dati possono essere utilizzati per analizzare il comportamento degli utenti. Inoltre, utilizziamo Google AdSense per finanziare questo sito web gratuito attraverso la pubblicità.</p>
            
            <p><strong>Quali sono i vostri diritti in merito ai vostri dati?</strong></p>
            <p>Avete il diritto di ottenere in qualsiasi momento e gratuitamente informazioni sull'origine, i destinatari e lo scopo dei vostri dati personali memorizzati. Avete inoltre il diritto di richiedere la correzione o la cancellazione di questi dati. Se avete dato il vostro consenso al trattamento dei dati, potete revocarlo in qualsiasi momento per il futuro. Inoltre, in determinate circostanze, avete il diritto di richiedere la limitazione del trattamento dei vostri dati personali. Avete inoltre il diritto di presentare reclamo all'autorità di controllo competente.</p>

            <h2 class="h5 mb-3 mt-4">2. Approccio "privacy first" per gli strumenti</h2>
            <p><strong>Tutti gli strumenti presenti su questo sito web elaborano i dati inseriti esclusivamente nel vostro browser.</strong> Quando utilizzate i nostri strumenti (ad es. Base64 Encoder, JSON Formatter, ecc.), vale quanto segue:</p>
            <ul>
              <li>Tutte le conversioni, le convalide e le generazioni avvengono sul lato client nel tuo browser</li>
              <li>I dati inseriti negli strumenti non lasciano mai il tuo dispositivo</li>
              <li>Non memorizziamo, registriamo né abbiamo accesso ai dati che elabori con i nostri strumenti</li>
              <li>Non possiamo fornire informazioni sui dati inseriti negli strumenti che non possediamo, poiché non li raccogliamo</li>
            </ul>
            <p><strong>Nota importante:</strong> ciò si riferisce esclusivamente al trattamento dei vostri dati <em>all'interno degli strumenti</em>. Tuttavia, quando visitate il sito web, vengono raccolti automaticamente dati tecnici (vedere la sezione 4) e Google AdSense imposta cookie per scopi pubblicitari (vedere le sezioni 6 e 7).</p>

            <h2 class="h5 mb-3 mt-4">3. Sicurezza e Trasparenza</h2>

            <p>Implementiamo più livelli di sicurezza per proteggere la tua privacy e garantire l'integrità dei nostri strumenti:</p>

            <h3 class="h6 mb-2 mt-3">3.1 Open Source e Verificabilità</h3>
            <p>Il codice sorgente completo è disponibile pubblicamente su GitHub. Puoi esaminare, verificare o bifurcare il progetto in qualsiasi momento:</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repository GitHub di WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Integrità delle Sottorisorse (SRI)</h3>
            <p>Tutte le librerie esterne vengono caricate con hash crittografici SRI per prevenire manomissioni. Ciò garantisce che il codice di terze parti non possa essere modificato senza rilevamento:</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Libreria</th>
                    <th>Versione</th>
                    <th>Hash SRI (SHA-384)</th>
                  </tr>
                </thead>
                <tbody class="font-monospace small">
                  <tr>
                    <td>qrcode-generator</td>
                    <td>1.4.4</td>
                    <td class="text-break">sha384-lQXOAyZwHXE55JFyr...TcIwz</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Gli hash SRI completi possono essere verificati nel nostro <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">codice sorgente</a>.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Politica di Sicurezza dei Contenuti (CSP)</h3>
            <p>Implementiamo politiche di sicurezza dei contenuti rigorose per prevenire attacchi XSS ed esecuzione di codice non autorizzato:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Esecuzione di script basata su nonce (previene l'iniezione di script inline)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Caricamento limitato di risorse esterne (solo da CDN affidabili)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incorporamento di frame completamente disabilitato (protezione contro clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Esecuzione di oggetti e plugin bloccata</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 Intestazioni di Sicurezza Aggiuntive</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previene attacchi di incorporamento iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previene il rilevamento del tipo MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita la perdita di informazioni sul referrer</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Forza connessioni HTTPS con precaricamento</li>
              <li><strong>Permissions-Policy</strong> - Disabilita funzionalità non necessarie del browser (geolocalizzazione, fotocamera, microfono, ecc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Zero Dipendenze Esterne per l'Elaborazione dei Dati</h3>
            <p>Tutte le funzioni principali di elaborazione dati utilizzano solo API native del browser. Le librerie esterne vengono utilizzate solo per componenti UI (rendering codice QR) e vengono caricate con verifica SRI.</p>

            <h2 class="h5 mb-3 mt-4">4. Hosting e file di log del server</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Descrizione e ambito del trattamento dei dati</h3>
            <p>Questo sito web è ospitato da un fornitore di servizi esterno. Se utilizzate il nostro sito web solo a scopo informativo (cioè senza registrazione né trasmissione di informazioni), raccogliamo solo i dati personali che il vostro browser trasmette al nostro server. Se desiderate visualizzare il nostro sito web, raccogliamo i seguenti dati:</p>
            <ul>
              <li>Indirizzo IP</li>
              <li>Internet Service Provider dell'utente</li>
              <li>Data e ora dell'accesso</li>
              <li>Tipo di browser</li>
              <li>Lingua e versione del browser</li>
              <li>Contenuto della richiesta</li>
              <li>Fuso orario</li>
              <li>Stato di accesso/codice di stato HTTP</li>
              <li>Quantità di dati</li>
              <li>Siti web da cui proviene la richiesta (URL di riferimento)</li>
              <li>Sistema operativo</li>
            </ul>
            <p>Questi dati non vengono memorizzati insieme ad altri dati personali dell'utente.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Finalità del trattamento</h3>
            <p>Questi dati sono utilizzati allo scopo di fornirvi un sito web user-friendly, funzionale e sicuro con funzioni e contenuti, nonché per la loro ottimizzazione e valutazione statistica. I dati sono utilizzati esclusivamente per il funzionamento tecnico e la sicurezza del sito web.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Base giuridica</h3>
            <p>La base giuridica è il nostro legittimo interesse al trattamento dei dati ai sensi dell'art. 6, comma 1, lettera f) del GDPR, che si riflette anche nelle finalità di cui sopra.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Periodo di conservazione</h3>
            <p>Per motivi di sicurezza, conserviamo questi dati nei file di log del server per un periodo di conservazione di 60 giorni. Dopo la scadenza di questo periodo, vengono automaticamente cancellati, a meno che non abbiamo bisogno di conservarli a scopo probatorio in caso di attacchi all'infrastruttura del server o altre violazioni legali. I dati non vengono uniti ad altre fonti di dati.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookie utilizzati</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Informazioni generali sui cookie</h3>
            <p>Utilizziamo i cookie quando visitate il nostro sito web. I cookie sono piccoli file di testo che il vostro browser Internet memorizza sul vostro computer. Quando visitate nuovamente il nostro sito web, questi cookie forniscono informazioni per riconoscervi automaticamente. I cookie includono anche i cosiddetti "ID utente", dove le informazioni degli utenti vengono memorizzate utilizzando profili pseudonimizzati. Quando visitate il nostro sito web, vi informiamo sull'uso dei cookie per le finalità sopra menzionate e su come potete opporvi o impedirne la memorizzazione ("opt-out") facendo riferimento alla nostra informativa sulla privacy.</p>
            
            <p>Si distinguono i seguenti tipi di cookie:</p>
            <ul>
              <li><strong>Cookie necessari ed essenziali:</strong> i cookie essenziali sono cookie assolutamente necessari per il funzionamento del sito web al fine di memorizzare determinate funzioni del sito web come login, carrello della spesa o input dell'utente, ad esempio per quanto riguarda la lingua del sito web.</li>
              <li><strong>Cookie di sessione:</strong> i cookie di sessione sono necessari per riconoscere l'uso multiplo di un'offerta da parte dello stesso utente (ad esempio, quando avete effettuato il login per determinare il vostro stato di login). Quando visitate nuovamente il nostro sito, questi cookie forniscono informazioni per riconoscervi automaticamente. Le informazioni ottenute in questo modo vengono utilizzate per ottimizzare le nostre offerte e facilitarvi l'accesso al nostro sito. Quando chiudete il browser o effettuate il logout, i cookie di sessione vengono eliminati.</li>
              <li><strong>Cookie persistenti:</strong> questi cookie rimangono memorizzati anche dopo la chiusura del browser. Vengono utilizzati per memorizzare il vostro login, misurare la portata e per scopi di marketing. Vengono eliminati automaticamente dopo un periodo specificato, che può variare a seconda del cookie. Potete eliminare i cookie in qualsiasi momento nelle impostazioni di sicurezza del vostro browser.</li>
              <li><strong>Cookie di terze parti (in particolare degli inserzionisti):</strong> potete configurare le impostazioni del vostro browser secondo le vostre preferenze e, ad esempio, rifiutare i cookie di terze parti o tutti i cookie. Tuttavia, vorremmo sottolineare che potreste non essere in grado di utilizzare tutte le funzioni di questo sito web se lo fate. Per ulteriori informazioni su questi cookie, consultare le rispettive informative sulla privacy dei fornitori terzi.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Categorie di dati</h3>
            <p>Dati utente, cookie, ID utente (comprese le pagine visitate, informazioni sul dispositivo, orari di accesso e indirizzi IP).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Finalità del trattamento</h3>
            <p>Le informazioni ottenute in questo modo servono allo scopo di ottimizzare le nostre offerte web tecnicamente ed economicamente e di consentirvi un accesso più facile e sicuro al nostro sito web.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Base giuridica</h3>
            <p>Se trattiamo i vostri dati personali con l'aiuto dei cookie sulla base del vostro consenso ("opt-in"), allora l'art. 6, comma 1, lettera a) del GDPR è la base giuridica. Altrimenti, abbiamo un legittimo interesse nella funzionalità efficace, nel miglioramento e nel funzionamento economico del sito web, nel qual caso l'art. 6, comma 1, lettera f) del GDPR è la base giuridica. La base giuridica è anche l'art. 6, comma 1, lettera b) del GDPR se i cookie vengono impostati allo scopo di avviare un contratto, ad esempio per ordini.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Periodo di conservazione / Cancellazione</h3>
            <p>I dati verranno cancellati non appena non saranno più necessari per lo scopo per cui sono stati raccolti. Nel caso della raccolta di dati per la fornitura del sito web, questo è il caso quando la rispettiva sessione è terminata.</p>
            <p>Altrimenti, i cookie vengono memorizzati sul vostro computer e trasmessi al nostro sito. Come utente, avete quindi il controllo completo sull'uso dei cookie. Potete disattivare o limitare la trasmissione dei cookie modificando le impostazioni nel vostro browser Internet. I cookie già memorizzati possono essere eliminati in qualsiasi momento. Questo può anche essere fatto automaticamente. Se i cookie vengono disattivati per il nostro sito web, potrebbe non essere più possibile utilizzare tutte le funzioni del sito web nella loro interezza.</p>
            <p>Qui troverete informazioni sulla cancellazione dei cookie per diversi browser:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Opposizione e "opt-out"</h3>
            <p>Potete generalmente impedire la memorizzazione dei cookie sul vostro disco rigido, indipendentemente dal consenso o dall'autorizzazione legale, selezionando "non accettare cookie" nelle impostazioni del vostro browser. Tuttavia, ciò può comportare restrizioni funzionali delle nostre offerte. Potete opporvi all'uso di cookie di terze parti per scopi pubblicitari tramite un cosiddetto "opt-out" su questo sito web americano (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) o questo sito web europeo (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>).</p>

            <h3 class="h6 mb-2 mt-3">Cookie di preferenza lingua (tecnicamente necessario)</h3>
            <p>Utilizziamo un singolo cookie per memorizzare la vostra preferenza linguistica:</p>
            <ul>
              <li><strong>Nome del cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Scopo:</strong> memorizza la lingua dell'interfaccia selezionata (ad es. "en", "de", "pt")</li>
              <li><strong>Validità:</strong> 30 giorni</li>
              <li><strong>Dati memorizzati:</strong> solo un codice lingua di due lettere</li>
              <li><strong>Tipo:</strong> tecnicamente necessario (abilita la funzionalità di base della preferenza linguistica)</li>
            </ul>
            <p>Questo cookie non contiene alcuna informazione personale ed è utilizzato esclusivamente per fornirvi contenuti nella vostra lingua preferita. Potete eliminare questo cookie in qualsiasi momento tramite le impostazioni del vostro browser.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Introduzione</h3>
            <p>Abbiamo integrato annunci pubblicitari del servizio Google "Adsense" (fornitore di servizi: Google Ireland Limited, numero di registrazione: 368047, Gordon House, Barrow Street, Dublino 4, Irlanda) sul nostro sito web. Gli annunci sono contrassegnati dalla nota (i) "Annunci Google" in ogni annuncio.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Categorie di dati e descrizione del trattamento dei dati</h3>
            <p>Dati di utilizzo/dati di comunicazione; quando visitate il nostro sito web, Google riceve l'informazione che avete visitato il nostro sito web. Per fare ciò, Google inserisce un web beacon o un cookie sul vostro computer. I dati vengono anche trasferiti negli USA e lì analizzati. Se siete loggati con un account Google, Adsense può assegnare i dati al vostro account. Se non desiderate che ciò accada, dovete effettuare il logout prima di visitare il nostro sito web. Tuttavia, Google può anche utilizzare altre informazioni per questo scopo:</p>
            <ul>
              <li>il tipo di siti web che visitate e le app mobili installate sul vostro dispositivo;</li>
              <li>cookie nel vostro browser e impostazioni nel vostro account Google;</li>
              <li>siti web e app che avete visitato;</li>
              <li>le vostre attività su altri dispositivi;</li>
              <li>interazioni precedenti con annunci o servizi pubblicitari di Google;</li>
              <li>le attività e le informazioni del vostro account Google.</li>
            </ul>
            <p>Quando fate clic su un annuncio Adsense, Google elabora l'indirizzo IP dell'utente (dati di utilizzo), per cui l'elaborazione viene pseudonimizzata (cosiddetto "ID pubblicitario") troncando gli ultimi due cifre dell'indirizzo IP. Nel caso della pubblicità personalizzata, Google non collega identificatori da cookie o tecnologie simili a categorie speciali di dati personali ai sensi dell'art. 9 del GDPR come origine etnica, religione, orientamento sessuale o salute.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Finalità del trattamento</h3>
            <p>Abbiamo attivato gli annunci personalizzati al fine di mostrarvi pubblicità più interessante che supporta l'uso commerciale del nostro sito web, ne aumenta il valore per noi e migliora la vostra esperienza utente. Con l'aiuto della pubblicità personalizzata, possiamo raggiungere gli utenti tramite Adsense in base ai loro interessi e caratteristiche demografiche (ad es. "appassionati di sport"). Inoltre, l'elaborazione viene utilizzata per il tracciamento, il remarketing e la misurazione delle conversioni, nonché per finanziare il nostro sito web.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Base giuridica</h3>
            <p>Se avete dato il vostro consenso ("opt-in") all'elaborazione dei vostri dati personali tramite "Google Adsense con annunci personalizzati", allora l'art. 6, comma 1, lettera a) del GDPR è la base giuridica. Altrimenti, la base giuridica per l'elaborazione dei vostri dati è l'art. 6, comma 1, lettera f) del GDPR sulla base dei nostri legittimi interessi nell'analisi, nell'ottimizzazione e nel funzionamento economico efficiente della nostra pubblicità e del nostro sito web.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Trasferimento dati/categoria destinatari</h3>
            <p>Google Irlanda, USA; questo sito web ha anche abilitato annunci Google AdSense di terze parti. I dati sopra menzionati possono anche essere trasferiti a questi fornitori terzi, noti come "Fornitori esterni certificati", elencati su <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a>.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Periodo di conservazione</h3>
            <p>I dati vengono conservati fino a 24 mesi dopo l'ultima visita.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Opzioni di opposizione ed eliminazione ("opt-out")</h3>
            <p>Potete opporvi o impedire l'installazione di cookie da parte di Google Adsense in vari modi:</p>
            <ul>
              <li>Potete impedire i cookie nel vostro browser selezionando l'impostazione "non accettare cookie", che include anche i cookie di terze parti;</li>
              <li>Potete disattivare gli annunci personalizzati su Google direttamente tramite il link <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a>, sebbene questa impostazione rimarrà in vigore solo fino a quando non eliminerete i vostri cookie. Le istruzioni per disattivare la pubblicità personalizzata sui dispositivi mobili si trovano qui: <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a>;</li>
              <li>Potete disattivare gli annunci personalizzati di fornitori terzi che partecipano all'iniziativa di autoregolamentazione pubblicitaria "About Ads" tramite il link <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> per i siti USA o <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> per i siti UE. Questa impostazione rimarrà in vigore solo fino a quando non eliminerete tutti i vostri cookie.</li>
              <li>Potete disattivare permanentemente i cookie tramite un plugin del browser per Chrome, Firefox o Internet Explorer su <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a>. La disattivazione dei cookie può significare che non sarete più in grado di utilizzare tutte le funzioni del nostro sito web nella loro interezza.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Ulteriori informazioni</h3>
            <p>Nell'informativa sulla privacy di Google per la pubblicità su <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a>, troverete ulteriori informazioni sull'uso dei cookie di Google negli annunci e le loro tecnologie pubblicitarie, durata della conservazione, anonimizzazione, dati sulla posizione, funzionalità e i vostri diritti.</p>

            <h2 class="h5 mb-3 mt-4">7. Contatto via e-mail/posta</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Descrizione e ambito del trattamento dei dati</h3>
            <p>Quando ci contattate via posta o e-mail, i vostri dati vengono elaborati allo scopo di gestire la vostra richiesta di contatto.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Base giuridica</h3>
            <p>La base giuridica per l'elaborazione dei dati è l'art. 6, comma 1, lettera a) del GDPR se avete dato il vostro consenso. La base giuridica per l'elaborazione dei dati trasmessi nel corso di una richiesta di contatto o e-mail o lettera è l'art. 6, comma 1, lettera f) del GDPR. Il responsabile ha un legittimo interesse nell'elaborazione e nella conservazione dei dati al fine di poter rispondere alle richieste degli utenti, per preservare le prove per motivi di responsabilità e per poter adempiere ai suoi obblighi legali di conservazione per le lettere commerciali, se applicabile. Se lo scopo del contatto è la conclusione di un contratto, la base giuridica aggiuntiva per l'elaborazione è l'art. 6, comma 1, lettera b) del GDPR.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Conservazione nel sistema CRM</h3>
            <p>Potremmo conservare i vostri dati e la richiesta di contatto nel nostro sistema di gestione delle relazioni con i clienti ("sistema CRM") o in un sistema comparabile.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Durata della conservazione</h3>
            <p>I dati verranno cancellati non appena non saranno più necessari per lo scopo per cui sono stati raccolti. Per i dati personali inviati via e-mail, questo è il caso quando la rispettiva conversazione con voi è terminata. La conversazione è terminata quando si può dedurre dalle circostanze che la questione in oggetto è stata chiarita in modo definitivo. Conserviamo le richieste degli utenti che hanno un account o un contratto con noi per un massimo di due anni dopo la fine del contratto. In caso di obblighi legali di archiviazione, la cancellazione avviene dopo la loro scadenza in conformità con le direttive UE e le normative nazionali di conservazione.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Diritto di opposizione e diritto di cancellazione</h3>
            <p>Avete il diritto di revocare il vostro consenso all'elaborazione dei dati personali in qualsiasi momento ai sensi dell'art. 6, comma 1, lettera a) del GDPR. Se ci contattate via e-mail, potete opporvi alla conservazione dei vostri dati personali in qualsiasi momento.</p>

            <h2 class="h5 mb-3 mt-4">8. Utilizzo degli strumenti a proprio rischio</h2>
            <p><strong>Utilizzate tutti gli strumenti su questo sito web a vostro rischio.</strong> Sebbene ci sforziamo di fornire strumenti accurati e affidabili, non possiamo garantire che siano privi di errori o adatti a tutti gli scopi.</p>
            <p>Non ci assumiamo alcuna responsabilità per:</p>
            <ul>
              <li>Errori, inesattezze o malfunzionamenti degli strumenti</li>
              <li>Perdita di dati o danni derivanti dall'uso degli strumenti</li>
              <li>Decisioni prese sulla base dei risultati generati dai nostri strumenti</li>
            </ul>
            <p>Verificate indipendentemente i risultati critici prima di utilizzarli in ambienti di produzione.</p>

            <h2 class="h5 mb-3 mt-4">9. I vostri diritti</h2>
            <p>Avete i seguenti diritti ai sensi del GDPR:</p>
            <ul>
              <li><strong>Diritto di accesso (art. 15 GDPR):</strong> avete il diritto di richiedere informazioni sui vostri dati personali elaborati da noi.</li>
              <li><strong>Diritto di rettifica (art. 16 GDPR):</strong> avete il diritto di richiedere la rettifica immediata di dati personali inesatti o il completamento di dati personali incompleti.</li>
              <li><strong>Diritto alla cancellazione (art. 17 GDPR):</strong> avete il diritto di richiedere la cancellazione dei vostri dati personali.</li>
              <li><strong>Limitazione del trattamento (art. 18 GDPR):</strong> avete il diritto di richiedere la limitazione del trattamento dei vostri dati personali.</li>
              <li><strong>Portabilità dei dati (art. 20 GDPR):</strong> avete il diritto di ricevere i vostri dati personali in un formato strutturato, di uso comune e leggibile da dispositivo automatico.</li>
              <li><strong>Diritto di opposizione (art. 21 GDPR):</strong> avete il diritto di opporvi in qualsiasi momento al trattamento dei dati personali che vi riguardano per motivi derivanti dalla vostra situazione particolare.</li>
              <li><strong>Revoca del consenso (art. 7, comma 3 GDPR):</strong> avete il diritto di revocare il vostro consenso in qualsiasi momento.</li>
              <li><strong>Diritto di presentare un reclamo (art. 77 GDPR):</strong> avete il diritto di presentare un reclamo a un'autorità di controllo.</li>
            </ul>
            <p>In caso di domande sulla protezione dei dati, contattateci utilizzando i dati di contatto forniti nell'impressum.</p>

          </div>
        </div>

    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
