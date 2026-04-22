<?php

/**
 * About Page (Italian)
 *
 * Provides information about the WebDev-Tools project, its origin story,
 * development process with AI assistance, and the motivation behind making
 * it publicly available.
 *
 * PHP version 7.4+
 *
 * @category  InformationPage
 * @package   WebDevTools
 * @license   MIT License
 */

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'it';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/it';
$homeUrl = BASE_PATH . '/it';
$pageTitle = 'Informazioni su WebDev-Tools – Utilità gratuite per sviluppatori';
$pageDescription = 'Scopri WebDev-Tools, una raccolta di utilità gratuite e rispettose della privacy per sviluppatori, creata con passione da Ramon Kaes.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="it" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="theme-color" content="#066fd1">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/webdev-tools.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="it_IT">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="pt_PT">
  <meta property="og:locale:alternate" content="fr_FR">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/webdev-tools.png">
  <meta name="twitter:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/about.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
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
          <h1 class="display-5 mb-3">Informazioni su WebDev Tools</h1>
          <p class="lead text-secondary">
            La decimilionesima raccolta di strumenti – un resoconto di un incidente
          </p>
          
          <!-- Badge di Conformità agli Standard -->
          <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 4648 Base64
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 8259 JSON
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 4122/9562 UUID
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 7519 JWT
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>ISO/IEC 18004 QR
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>NIST SP 800-63B
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>WCAG A11y
            </span>
            <span class="badge bg-primary px-3 py-2">
              <i class="bi bi-lock-fill me-1"></i>Solo lato client
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Sì, lo so. La decimilionesima raccolta di strumenti su Internet. A chi
              serve? Ma vi posso rassicurare: questo progetto non era mai stato
              pianificato. È un incidente, il frutto di pura procrastinazione, ma anche
              una lezione su come gestire l'intelligenza artificiale.
            </p>
            <p>
              Tutto è iniziato in modo del tutto innocuo sul mio desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              All'inizio c'era lo script.
            </h2>
            <p>
              Come molti sviluppatori, anch'io avevo accumulato diversi strumenti fatti
              in casa sul mio localhost. Piccoli script per le seccature quotidiane:
              una conversione Em/Px qui, un piccolo aiutante là. Cose per le quali ero
              troppo pigro per cercare ogni volta gli stessi siti web. Con i
              segnalibri, infatti, sono in guerra aperta.
            </p>
            <p class="mb-5">
              Questi piccoli aiutanti facevano diligentemente il loro dovere. Ma poi ne
              ho aggiunti altri due e il mio istinto di sviluppatore web ha colpito
              senza pietà: ho iniziato a collegarli tra loro. Ci voleva un menu. Un po'
              di styling. E all'improvviso mi sono ritrovato nel bel mezzo di tutto ciò
              che viene in mente quando si vuole distrarsi con successo dal lavoro vero
              e proprio. La semplice raccolta si è trasformata in un progetto a tutti
              gli effetti. Dovevo semplicemente “pimparlo” fino a quando non mi sono
              ritrovato davanti un vero e proprio piccolo sito web con tutto il
              necessario.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              “IA, prendi il comando!” – era un'idea folle?
            </h2>
            <p>
              A un certo punto mi è venuto in mente: sono solo semplici script. Lascia
              che se ne occupi l'IA! Da fedele utente di
              <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor di codice gratuito">VS Code</a>,
              ho avviato il progetto direttamente con
              <a href="https://www.anthropic.com/claude-code" target="_blank" rel="noopener noreferrer" title="Claude Code di Anthropic">Claude Code (Sonnet)</a>.
            </p>
            <p>
              Ma prima di dare carta bianca all'IA, dovevo stabilire delle linee guida
              chiare. Quindi, per prima cosa ho definito uno stack tecnologico fisso.
              Da questo ho ricavato un <code>CLAUDE.md</code> (rigorosamente limitato a un massimo
              di 60 righe – i percorsi di comando brevi sono fondamentali per le IA) e
              un <code>.claude/comments/review.md</code>. Altrettanto fondamentali per il proprio
              portafoglio sono un <code>.claudeignore</code> coerente e un
              <code>.claude/settings.local.json</code> specificamente adattato, per risparmiare un
              sacco di token durante la codifica.
            </p>
            <p class="mb-5">
              Il risultato è stato sorprendente: un'applicazione web incredibilmente
              valida ed espandibile in modo modulare. Ma naturalmente non è andato
              tutto liscio. Bisogna impedire costantemente a un'IA di esagerare. Il mio
              comando più importante è diventato subito: «No, non abbiamo bisogno di un
              gestore di pacchetti! E ora smettila di volermi proporre di nuovo un
              framework!»
              Alla fine, però, ne è effettivamente uscito un framework di base
              utilizzabile.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Le insidie del “Vibe Coding”
            </h2>
            <p>
              Il progetto ha preso slancio e ho imparato rapidamente alcune dure
              lezioni sulla collaborazione con i miei colleghi digitali.
            </p>
            <ul class="mb-5">
              <li>
                La questione del framework: le IA adorano
                <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utility-first">Tailwind</a>.
                Dopo alcune modifiche manuali, durante le quali la mia pazienza si è
                assottigliata pericolosamente, alla fine si è spezzata. Sono quindi
                passato a
                <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>
                per portare a termine la cosa in modo pragmatico. A volte “finito” è
                semplicemente meglio di “perfetto” (o Tailwind).
              </li><br>
              <li>
                Senza Git? Senza di me! Per abitudine ho creato subito un repository.
                Per fortuna! Mi sono reso conto rapidamente che questo “Vibe Coding”
                senza un piano e senza controllo delle versioni finisce per essere un
                enorme spreco di tempo.
              </li><br>
              <li>
                Logica IA vs. realtà: a volte le IA si semplificano troppo la vita – o
                la complicano troppo. È vero che Claude è migliorato enormemente in
                questo senso e ora analizza il codice in modo molto più approfondito
                invece di speculare alla cieca. Tuttavia, se non si specifica con
                precisione dove si vuole arrivare, le IA tendono ancora a proporre
                soluzioni di script arbitrarie che finiscono in un vicolo cieco. Senza
                un coraggioso “git reset --hard” avrei comunque dovuto ricominciare il
                progetto da zero più di una volta.
              </li><br>
              <li>
                Ping-pong dell'IA nella revisione del codice: per il controllo qualità
                ho puntato su un sistema di “checks and balances”. Con il comando
                /review attivo la verifica interna di Claude, che opera rigorosamente
                secondo le specifiche del mio file review.md. In aggiunta a ciò, ho
                fatto eseguire revisioni esterne da ChatGPT e Gemini e ho infine
                discusso i risultati con Claude Opus. Questa “revisione AI per la
                revisione AI” è piuttosto meta, ma estremamente utile per verificare
                diversi modi di pensare e colmare le lacune logiche.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Round bonus: l'IA come traduttore?
            </h2>
            <p>
              Una volta definita la funzionalità, è stata la volta delle traduzioni.
              Qui l'IA ha mostrato il suo lato filosofico:
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Sicurezza e ricerca IA">Claude Sonnet 4.5</a>
              mi ha fatto notare spontaneamente che lingue come l'hindi, il cinese o il
              giapponese non riguardano solo il vocabolario, ma anche peculiarità
              culturali e forme di cortesia. È stato un livello di autoriflessione
              davvero rinfrescante.
            </p>
            <p class="mb-5">
              Nella pratica, però, si è finito per optare per un approccio pragmatico:
              per la traduzione in batch dei contenuti statici, Claude mi sembrava
              troppo “intellettuale” e complicato. Con Gemini e ChatGPT, la qualità
              dell'esecuzione era troppo incostante. Alla fine ho fatto tradurre tutto
              da <a href="https://www.deepl.com/it/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Servizio di traduzione IA">DeepL</a>.
              Anche in questo caso vale il principio: lo strumento giusto per il lavoro
              giusto!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Dall'intranet al web selvaggio
            </h2>
            <p>
              Una volta completata la raccolta di strumenti, che supportava addirittura
              diverse lingue, ha funzionato bene per un bel po' di tempo sulla nostra
              rete aziendale. A un certo punto mi sono detto: perché non condividerla?
            </p>
            <p>
              Così ho fatto un po' di ordine e ho reso pubblico il sito. E dato che il
              tutto è nato comunque da un “incidente”, il codice è completamente
              aperto. Chi vuole contribuire o trova un errore: il repository Git si
              trova qui:
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repository GitHub di WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sì, scusate. Eccola qui, la 10.000esima raccolta di strumenti. La
              10.000esima raccolta di strumenti. Ma ehi, almeno ha una bella storia
              alle spalle!
            </p>
            <p>Buon divertimento!</p>
            <p>Ramon</p>
            <div class="text-center">
              <img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Servizio di traduzione online gratuito" class="text-decoration-none text-muted">Tradotto con deepl.com (versione gratuita)</a>
          </small>
        </div>

      </div>
    </main>
  </div>

  <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
<?php
// Output minified HTML
echo minify_html_output(ob_get_clean());
?>
