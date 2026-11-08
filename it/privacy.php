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
$pageTitle = 'Informativa Privacy – Protezione Dati WebDev-Tools Online';
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
  <meta name="theme-color" content="#066fd1">
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
  <meta name="apple-mobile-web-app-title" content="WebDev-Tools" />
  <link rel="manifest" href="<?= BASE_PATH . getLangPrefix($lang) ?>/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= assetSrc('css/style.css') ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>
<body class="d-flex flex-column bg-body">

<?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main id="main-content" class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
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
            <p>Una parte dei dati viene raccolta per garantire il corretto funzionamento del sito web (file di log del server, vedere la sezione 4). Inoltre, due strumenti caricano ciascuno una libreria JavaScript da una rete di distribuzione dei contenuti (vedere la sezione 3.3). Non utilizziamo servizi di analisi, tracciamento o pubblicità.</p>
            
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
            <p><strong>Nota importante:</strong> ciò si riferisce esclusivamente al trattamento dei vostri dati <em>all'interno degli strumenti</em>. Tuttavia, quando visitate il sito web, vengono raccolti automaticamente dati tecnici nei file di log del server (vedere la sezione 4) e, quando utilizzate il generatore di codici QR o minificate JavaScript nel formattatore di codice, viene caricata una libreria da una CDN (vedere la sezione 3.3).</p>

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
                  <tr>
                    <td>terser</td>
                    <td>5.31.0</td>
                    <td class="text-break">sha384-Be6gQ8oRB6kvVWiyo...1v7dX</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Gli hash SRI completi possono essere verificati nel nostro codice sorgente (<a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">config/tools.php</a> e <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/assets/js/tools/codeFormatterTool.js" target="_blank" rel="noopener noreferrer">codeFormatterTool.js</a>).</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Distribuzione di contenuti di terze parti (CDN)</h3>
            <p>Bootstrap, il font delle icone e tutte le altre risorse sono ospitati sul nostro server. Solo due strumenti caricano una singola libreria JavaScript dalla rete di distribuzione dei contenuti jsDelivr (cdn.jsdelivr.net), gestita da Prospect One (jsDelivr) e distribuita tramite diversi fornitori CDN, tra cui Cloudflare e Fastly:</p>
            <ul>
              <li><strong>Generatore di codici QR:</strong> carica <code>qrcode-generator</code> all'apertura della pagina dello strumento.</li>
              <li><strong>Formattatore di codice:</strong> carica <code>terser</code> solo quando minificate codice JavaScript.</li>
            </ul>
            <p>Al caricamento di una di queste librerie, il vostro browser si collega direttamente alla CDN e trasmette i dati tecnicamente necessari, in particolare il vostro indirizzo IP, il vostro user agent e la pagina di provenienza (referrer). Noi non riceviamo alcun dato da questo processo. Le librerie sono protette da hash SRI (vedere 3.2) e non possono quindi essere modificate senza che ciò venga rilevato. Al di fuori di questo, il sito web non effettua alcuna richiesta a server di terze parti; solo il generatore SRI recupera l'URL della risorsa che inserite voi stessi.</p>
            <p>La base giuridica è l'art. 6, comma 1, lettera f) del GDPR; il nostro legittimo interesse consiste nel fornire questi strumenti in modo affidabile ed efficiente. Ulteriori informazioni sono disponibili nell'informativa sulla privacy di jsDelivr: <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener">https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net</a></p>

            <h3 class="h6 mb-2 mt-3">3.4 Politica di Sicurezza dei Contenuti (CSP)</h3>
            <p>Implementiamo politiche di sicurezza dei contenuti rigorose per prevenire attacchi XSS ed esecuzione di codice non autorizzato:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Esecuzione di script basata su nonce (previene l'iniezione di script inline)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Caricamento limitato di risorse esterne (script solo dal nostro server e da cdn.jsdelivr.net)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incorporamento di frame completamente disabilitato (protezione contro clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Esecuzione di oggetti e plugin bloccata</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Intestazioni di Sicurezza Aggiuntive</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previene attacchi di incorporamento iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previene il rilevamento del tipo MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita la perdita di informazioni sul referrer</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Forza connessioni HTTPS con precaricamento</li>
              <li><strong>Permissions-Policy</strong> - Disabilita funzionalità non necessarie del browser (geolocalizzazione, fotocamera, microfono, ecc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.6 Zero Dipendenze Esterne per l'Elaborazione dei Dati</h3>
            <p>Tutte le funzioni principali di elaborazione dati utilizzano solo API native del browser. Le librerie esterne vengono utilizzate solo per due funzioni ausiliarie (rendering di codici QR e minificazione di JavaScript) e vengono caricate con verifica SRI.</p>

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
            <p>I cookie sono piccoli file di testo che il vostro browser Internet memorizza sul vostro dispositivo. Questo sito web utilizza <strong>esattamente un cookie</strong>, tecnicamente necessario. Non utilizziamo cookie di sessione, di analisi, di tracciamento o di terze parti e non vengono creati profili utente. Poiché non vengono utilizzati cookie soggetti a consenso, non viene mostrato alcun banner per i cookie.</p>

            <h3 class="h6 mb-2 mt-3">5.2 Cookie di preferenza lingua (tecnicamente necessario)</h3>
            <p>Utilizziamo un singolo cookie per memorizzare la vostra preferenza linguistica:</p>
            <ul>
              <li><strong>Nome del cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Scopo:</strong> memorizza la lingua dell'interfaccia selezionata (ad es. "en", "de", "pt")</li>
              <li><strong>Validità:</strong> 30 giorni</li>
              <li><strong>Dati memorizzati:</strong> solo un codice lingua di due lettere</li>
              <li><strong>Tipo:</strong> tecnicamente necessario (abilita la funzionalità di base della preferenza linguistica)</li>
            </ul>
            <p>Questo cookie non contiene alcuna informazione personale ed è utilizzato esclusivamente per fornirvi contenuti nella vostra lingua preferita. Potete eliminare questo cookie in qualsiasi momento tramite le impostazioni del vostro browser.</p>

            <h3 class="h6 mb-2 mt-3">5.3 Base giuridica</h3>
            <p>La base giuridica è l'art. 6, comma 1, lettera f) del GDPR. Il nostro legittimo interesse consiste nel fornirvi il sito web nella lingua da voi selezionata senza doverla richiedere a ogni visualizzazione di pagina. Il cookie è strettamente necessario per questa funzione, pertanto non è richiesto alcun consenso.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Periodo di conservazione / Cancellazione</h3>
            <p>Il cookie viene cancellato automaticamente dopo 30 giorni o non appena lo eliminate manualmente. Potete impedire in qualsiasi momento la memorizzazione dei cookie tramite le impostazioni del vostro browser; in tal caso la vostra scelta della lingua non verrà salvata e il sito web ricorrerà al rilevamento automatico della lingua (URL, lingua del browser). Qui troverete informazioni sulla cancellazione dei cookie per diversi browser:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h2 class="h5 mb-3 mt-4">6. Contatto via e-mail/posta</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Descrizione e ambito del trattamento dei dati</h3>
            <p>Quando ci contattate via posta o e-mail, i vostri dati vengono elaborati allo scopo di gestire la vostra richiesta di contatto.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Base giuridica</h3>
            <p>La base giuridica per l'elaborazione dei dati è l'art. 6, comma 1, lettera a) del GDPR se avete dato il vostro consenso. La base giuridica per l'elaborazione dei dati trasmessi nel corso di una richiesta di contatto o e-mail o lettera è l'art. 6, comma 1, lettera f) del GDPR. Il responsabile ha un legittimo interesse nell'elaborazione e nella conservazione dei dati al fine di poter rispondere alle richieste degli utenti, per preservare le prove per motivi di responsabilità e per poter adempiere ai suoi obblighi legali di conservazione per le lettere commerciali, se applicabile. Se lo scopo del contatto è la conclusione di un contratto, la base giuridica aggiuntiva per l'elaborazione è l'art. 6, comma 1, lettera b) del GDPR.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Conservazione nel sistema CRM</h3>
            <p>Potremmo conservare i vostri dati e la richiesta di contatto nel nostro sistema di gestione delle relazioni con i clienti ("sistema CRM") o in un sistema comparabile.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Durata della conservazione</h3>
            <p>I dati verranno cancellati non appena non saranno più necessari per lo scopo per cui sono stati raccolti. Per i dati personali inviati via e-mail, questo è il caso quando la rispettiva conversazione con voi è terminata. La conversazione è terminata quando si può dedurre dalle circostanze che la questione in oggetto è stata chiarita in modo definitivo. Conserviamo le richieste degli utenti che hanno un account o un contratto con noi per un massimo di due anni dopo la fine del contratto. In caso di obblighi legali di archiviazione, la cancellazione avviene dopo la loro scadenza in conformità con le direttive UE e le normative nazionali di conservazione.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Diritto di opposizione e diritto di cancellazione</h3>
            <p>Avete il diritto di revocare il vostro consenso all'elaborazione dei dati personali in qualsiasi momento ai sensi dell'art. 6, comma 1, lettera a) del GDPR. Se ci contattate via e-mail, potete opporvi alla conservazione dei vostri dati personali in qualsiasi momento.</p>

            <h2 class="h5 mb-3 mt-4">7. Utilizzo degli strumenti a proprio rischio</h2>
            <p><strong>Utilizzate tutti gli strumenti su questo sito web a vostro rischio.</strong> Sebbene ci sforziamo di fornire strumenti accurati e affidabili, non possiamo garantire che siano privi di errori o adatti a tutti gli scopi.</p>
            <p>Non ci assumiamo alcuna responsabilità per:</p>
            <ul>
              <li>Errori, inesattezze o malfunzionamenti degli strumenti</li>
              <li>Perdita di dati o danni derivanti dall'uso degli strumenti</li>
              <li>Decisioni prese sulla base dei risultati generati dai nostri strumenti</li>
            </ul>
            <p>Verificate indipendentemente i risultati critici prima di utilizzarli in ambienti di produzione.</p>

            <h2 class="h5 mb-3 mt-4">8. I vostri diritti</h2>
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
  </main>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
