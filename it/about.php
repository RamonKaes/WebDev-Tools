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
  <meta name="keywords" content="WebDev-Tools, Informazioni, Ramon Kaes, Strumenti per sviluppatori, Rispettoso della privacy">
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
            La diecimillesima raccolta di strumenti – un resoconto di un incidente
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
              Sì, lo so. La diecimillesima raccolta di strumenti su Internet. A chi serve?<br>
              Ma posso rassicurarvi. Questo progetto non era mai stato pianificato. È nato per caso, frutto di pura procrastinazione, ma anche da una reale necessità. Tutto è iniziato in modo del tutto innocuo sul mio desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              All’inizio c’era lo script.
            </h2>
            <p>
              Come molti sviluppatori, anch’io avevo salvato diversi strumenti fatti in casa sul mio localhost. Piccoli script per le seccature quotidiane: una conversione da em a px qui, un piccolo aiutante là. Cose per le quali ero troppo pigro per cercare ogni volta gli stessi siti web. Con i segnalibri, infatti, sono in guerra aperta.
            </p>
            <p class="mb-3">
              Questi piccoli aiutanti facevano diligentemente il loro dovere. Ma poi ne ho aggiunti altri due e il mio istinto di sviluppatore web ha colpito senza pietà: ho iniziato a collegarli tra loro. Ci voleva un menu. Un po’ di styling. E all’improvviso mi sono ritrovato immerso in tutto ciò che viene in mente quando si vuole distrarsi con successo dal lavoro vero e proprio. La semplice raccolta si è trasformata in un progetto a tutti gli effetti. Non ho potuto fare a meno di “pimparlo” fino a quando non mi sono ritrovato davanti un vero e proprio piccolo sito web con tutto ciò che serve.
            </p>

            <h2 class="h5 card-title mb-3">
              Dal caos degli script a una vera e propria app web.
            </h2>
            <p class="mb-3">
              Da quegli script sparsi doveva nascere una piattaforma affidabile. Per accelerare il processo di sviluppo e rendere più efficiente la strutturazione del codice, ho integrato <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Assistente IA Claude Code">Claude Code</a> direttamente nel mio flusso di lavoro. L’attenzione, però, è sempre rimasta sul pragmatismo: gli strumenti dovevano caricarsi velocemente, essere intuitivi da usare e fare esattamente ciò che dovevano, senza fronzoli inutili. Ogni sviluppatore web conosce la tentazione di perdersi in discussioni infinite sul framework perfetto o sull’architettura più elegante. Ho invece optato per la via più diretta: una base solida con <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Framework CSS Bootstrap">Bootstrap</a>, un codice pulito e la regola ferrea secondo cui «finito e funzionante» è più prezioso della perfezione teorica.
            </p>

            <h2 class="h5 card-title mb-3">
              Dall’intranet al web selvaggio
            </h2>
            <p>
              Una volta completata, la raccolta di strumenti ha inizialmente funzionato bene per un bel po’ di tempo nella nostra rete aziendale. A un certo punto mi sono detto: perché non condividerlo con il mondo intero?
            </p>
            <p>
              Quando si pubblica un progetto su Internet, però, è importante che non fallisca a causa delle barriere linguistiche. Così, spinto ancora una volta dall’ambizione, prima della pubblicazione ho aggiunto al sistema la funzionalità multilingue, per renderlo accessibile a un pubblico internazionale. Per realizzare il tutto in modo pragmatico ed efficiente, mi sono affidato interamente a <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Strumento di traduzione DeepL">DeepL</a> per la traduzione dei testi.
            </p>
            <p>
              Successivamente ho ripulito il codice e ho reso pubblico il sito. Dato che il tutto è nato comunque da un “incidente” e si basa sulla filosofia open source, il codice è completamente aperto. Chiunque voglia contribuire, abbia un’idea per un nuovo strumento o trovi un errore è cordialmente invitato a partecipare. Il repository Git lo trovate qui: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repository GitHub di WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sì, scusate. Eccola qui, la 10.000esima raccolta di strumenti. Ma ehi, almeno ha una bella storia alle spalle e, chissà, forse vi risparmierà nella vita di tutti i giorni tante ricerche quanto ne ha risparmiate a me!
            </p>

            <p>Buon divertimento!</p>
            <p>Ramon</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
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
