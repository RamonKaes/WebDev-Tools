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
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home.svg">
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
  <meta name="twitter:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home.svg">
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
            Da script locale alla (sì, la 10.000ª) raccolta di strumenti: Una cronaca del
            caso
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
              Sì, lo so. La decimillesima raccolta di strumenti su Internet. A chi serve?
              Ma vi posso rassicurare: questo progetto non è mai stato pianificato. È un incidente,
              un prodotto della procrastinazione e una lezione sull'uso dell'intelligenza artificiale.

            </p>
            <p>
              Tutto è iniziato in modo innocuo sul mio desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              All'inizio c'era lo script.
            </h2>
            <p>
              Come molti sviluppatori, anch'io avevo salvato alcuni strumenti personali sul mio localhost.
              Piccoli script per le seccature quotidiane: una conversione Em/Px
              qui, un piccolo aiuto là. Cose per le quali ero troppo pigro per cercare e aprire sempre gli
              stessi siti web. Infatti, sono in guerra aperta con i segnalibri
              .
            </p>
            <p>
              Questi piccoli aiutanti facevano il loro dovere. Ma poi ne ho aggiunti altri due.
              E allora è successo: il mio istinto di sviluppatore web ha avuto la meglio.
            </p>
            <p class="mb-5">
              Istintivamente ho iniziato a collegarli tra loro. Ci voleva un menu.
              E un po' di styling. E tutto ciò che viene in mente
              quando si vuole distrarsi con successo dal lavoro vero e proprio. Così
              una semplice raccolta di script si è trasformata in un progetto completo. Ho dovuto
              semplicemente “pimpare” il tutto fino a quando non ho avuto un vero e proprio piccolo sito web con tutto ciò che serve.

            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              “AI, ci pensi tu!” – Un'idea folle?
            </h2>
            <p>
              A un certo punto mi è venuta un'idea: si tratta solo di semplici script. Perché non lasciare che sia l'IA a occuparsene?
              Da fedele utente di <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor di codice gratuito">VS Code</a>, ho avviato il progetto direttamente con
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI di Anthropic">Claude Sonnet 4.5</a> (in <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - Programmatore di coppia IA">GitHub CoPilot</a>).
            </p>
            <p>
              Sono rimasto sorpreso, perché il risultato è stata un'applicazione web sorprendentemente buona e modulare
              espandibile.
            </p>
            <p>
              Naturalmente non è stato così facile. Bisogna impedire costantemente all'IA di
              esagerare. Il mio comando più importante è diventato rapidamente: "No, non abbiamo bisogno di un
              gestore di pacchetti! E ora smettila di propormi un altro framework!"
            </p>
            <p class="mb-5">
              Alla fine, però, ne è venuta fuori una struttura di base davvero utilizzabile.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Le insidie del “vibe coding” con l'IA
            </h2>
            <p>
              Il progetto ha preso slancio e ho imparato rapidamente alcune dure lezioni sulla
              collaborazione con i miei nuovi colleghi digitali.
            </p>
            <p>
              La questione del framework: le IA preferiscono lavorare con <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utility-first">Tailwind</a>. E così hanno fatto anche
              in questo caso. Dopo alcune modifiche manuali, durante le quali la mia pazienza si è sempre più
              esaurita, alla fine ho perso la calma. Sono passato senza esitazione a <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>,
              per portare a termine il lavoro in modo rapido e pragmatico. A volte
              "finito" è semplicemente meglio di 'perfetto' (o "Tailwind").
            </p>
            <p>
              2. Senza <a href="https://git-scm.com/" target="_blank" rel="noopener noreferrer" title="Git - Sistema di controllo versione distribuito">Git</a>? Senza di me! Per pura abitudine ho creato direttamente un <a href="https://git-scm.com/book/it/v2/Git-Basics-Getting-a-Git-Repository" target="_blank" rel="noopener noreferrer" title="Repository Git - Fondamenti del controllo versione">repository Git</a>.
              Per fortuna! Ho capito subito che quello che stavo facendo, ovvero questo
              "vibe coding" senza un piano preciso con l'IA, senza Git comportava un notevole
              spreco di tempo.
            </p>
            <p>
              3. Le insidie della logica dell'IA: il problema più grande è che le IA amano semplificarsi la vita,
              ma nel modo sbagliato.
            </p>
            <ul>
              <li>
                Speculano: invece di analizzare ciò che si intende realmente fare, spesso tirano a indovinare
                a caso. Bisogna porre fine rapidamente a queste speculazioni e
                indicare loro ogni passo con precisione, altrimenti si finisce nel caos.
              <li>
                Amano i propri script. Tendono a proporre script o soluzioni propri
                che spesso portano a risultati disastrosi. In non pochi
                casi ciò avrebbe richiesto un completo riavvio del progetto,
                se non fosse stato possibile un coraggioso “git reset --hard”.
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. Ping-pong di IA nelle revisioni del codice
              Anche per il controllo qualità ho puntato sulle IA, ma in modo sistematico:
              innanzitutto ho fatto eseguire le revisioni del codice da <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modello IA avanzato">GPT-5 Codex</a> e
              poi ho chiesto il parere di <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI di Anthropic">Claude Sonnet 4.5</a>. Una revisione AI per
              la revisione AI, per così dire. È piuttosto meta, ma estremamente utile per
              verificare diversi “modi di pensare”.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonus: l'IA come traduttore?
            </h2>
            <p>
              Una volta definita la funzionalità, ho pensato alle traduzioni. Per prima cosa ho provato
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI di Anthropic">Claude Sonnet 4.5</a>. Secondo quanto dichiarato, l'IA padroneggia l'inglese e il
              tedesco a livello madrelingua e offre una sicurezza del 98% per lo spagnolo, il francese, l'
              italiano e il portoghese.
            </p>
            <p>
              La cosa si è fatta interessante quando ho chiesto l'hindi, il cinese o il giapponese. In questo caso
              l'IA ha ammesso di aver bisogno di un aiuto esterno come <a href="https://www.deepl.com/it/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Servizio di traduzione IA">DeepL</a>. Ancora più importante
              è il fatto che abbia sottolineato di propria iniziativa che non si tratta solo di una traduzione approssimativa,
              ma che occorre tenere conto anche delle peculiarità culturali e delle
              forme di cortesia.
            </p>
            <p class="mb-5">
              Un livello di autoriflessione davvero stimolante. Per la traduzione batch vera e propria
              della parte statica e hardcoded delle lingue romanze, Claude mi è sembrato
              tuttavia troppo cerebrale. Ho quindi deciso di affidare il compito a <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modello IA avanzato">GPT-5-Codex</a>.
              Anche in questo caso vale il principio: lo strumento giusto per il lavoro giusto!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Dall'intranet al web selvaggio
            </h2>
            <p>
              Dopo che la raccolta di strumenti era cresciuta a tal punto (e parlava addirittura diverse lingue),
              è rimasta disponibile solo nella nostra rete aziendale per un bel po' di tempo,
              rendendoci ottimi servizi.
            </p>
            <p>
              A un certo punto ho pensato: perché no? Così l'ho riordinata
              e resa pubblica.
            </p>
            <p>
              E perché tutto ciò è nato da un «incidente», il codice è completamente aperto.
              Se volete smanettare da soli o trovare un bug: potete trovare
              il repository Git qui: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repository GitHub di WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sì, scusate. Ora è qui. La 10.000esima raccolta di strumenti. Ma ehi, almeno
              ha una storia alle spalle! :D
            </p>
            <p>
              Buon divertimento!
            </p>
            <p class="mb-0">Ramon</p>
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
