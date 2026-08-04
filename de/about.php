<?php

/**
 * About Page (German)
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

$lang = 'de';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/de';
$homeUrl = BASE_PATH . '/de';
$pageTitle = 'Über WebDev-Tools – Datenschutzfreundliche Entwickler-Utilities';
$pageDescription = 'Erfahren Sie mehr über WebDev-Tools, eine Sammlung kostenloser, datenschutzfreundlicher Entwickler-Utilities, entwickelt mit Leidenschaft von Ramon Kaes.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="de" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="keywords" content="WebDev-Tools, Über, Ramon Kaes, Entwickler-Tools, Datenschutzfreundlich">
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
  <meta property="og:locale" content="de_DE">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="pt_PT">
  <meta property="og:locale:alternate" content="fr_FR">
  <meta property="og:locale:alternate" content="it_IT">

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
          <h1 class="display-5 mb-3">Über WebDev Tools</h1>
          <p class="lead text-secondary">
            Die 10.000ste Toolsammlung – ein Unfallbericht
          </p>
          
          <!-- Standards-Konformitäts-Badges -->
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
              <i class="bi bi-lock-fill me-1"></i>Nur Client-seitig
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Ja, ich weiß. Die zehntausendste Toolsammlung im Internet. Wer braucht die schon?<br>
              Aber ich kann euch beruhigen. Dieses Projekt war nie geplant. Es ist ein Unfall, ein Produkt purer Prokrastination, aber auch aus einer echten Notwendigkeit heraus entstanden. Alles begann ganz harmlos auf meinem Desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              Am Anfang war das Skript.
            </h2>
            <p>
              Wie viele Entwickler hatte auch ich diverse Eigenbau-Tools auf meinem Localhost gespeichert. Kleine Skripte für alltägliche Ärgernisse: eine Em/Px-Umrechnung hier, ein kleiner Helfer dort. Dinge, für die ich zu faul war, um jedes Mal die gleichen Websites zu suchen. Mit Lesezeichen stehe ich nämlich auf absolutem Kriegsfuß.
            </p>
            <p class="mb-3">
              Diese Helferlein taten brav ihren Dienst. Doch dann fügte ich zwei weitere hinzu und mein Webentwickler-Instinkt schlug gnadenlos zu: Ich begann, die Dinger zu verknüpfen. Ein Menü musste her. Ein bisschen Styling. Und plötzlich war ich mittendrin in allem, was einem so einfällt, wenn man sich erfolgreich von der eigentlichen Arbeit ablenken möchte. Aus der simplen Sammlung wurde ein ausgewachsenes Projekt. Ich musste es einfach „pimpen”, bis eine richtige kleine Website mit allem Drum und Dran vor mir stand.
            </p>

            <h2 class="h5 card-title mb-3">
              Vom Skript-Chaos zur echten Web-App.
            </h2>
            <p>
              Aus den verstreuten Skripten sollte eine verlässliche Plattform entstehen. Um den Entwicklungsprozess zu beschleunigen und die Code-Strukturierung effizienter zu gestalten, habe ich <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Claude Code KI-Assistent">Claude Code</a> direkt in meinen Arbeitsablauf integriert. Dabei lag der Fokus aber immer auf Pragmatismus: Die Tools sollten schnell laden, intuitiv zu bedienen sein und genau das tun, was sie sollen, ohne unnötigen Schnickschnack. Jeder Webentwickler kennt die Versuchung, sich in endlosen Diskussionen über das perfekte Framework oder die eleganteste Architektur zu verlieren. Ich habe mich stattdessen für den direkten Weg entschieden: ein solides <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap CSS-Framework">Bootstrap</a>-Gewand, eine saubere Code-Basis und die eiserne Regel, dass „fertig und funktionierend“ wertvoller ist als theoretische Perfektion.
            </p>

            <h2 class="h5 card-title mb-3">
              Vom Intranet ins wilde Web
            </h2>
            <p class="mb-3">
              Nachdem die Toolsammlung fertiggestellt war, leistete sie zunächst eine ganze Weile gute Dienste in unserem Firmennetzwerk. Irgendwann dachte ich mir: Warum eigentlich nicht mit der ganzen Welt teilen?
            </p>
            <p>
              Wenn man ein Projekt für das Internet freigibt, sollte es allerdings nicht an Sprachbarrieren scheitern. Also packte mich noch einmal der Ehrgeiz, und ich habe das System vor der Veröffentlichung um Mehrsprachigkeit erweitert, um es für ein internationales Publikum nutzbar zu machen. Um das Ganze pragmatisch und effizient umzusetzen, habe ich für die Übersetzungen der Texte vollständig auf <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="DeepL Übersetzungswerkzeug">DeepL</a> gesetzt.
            </p>
            <p>
              Anschließend habe ich den Code aufgeräumt und die Seite öffentlich geschaltet. Weil das Ganze ja ohnehin aus einem „Unfall“ entstanden ist und vom Open-Source-Gedanken lebt, liegt der Code komplett offen. Wer mitbasteln will, eine Idee für ein neues Tool hat oder einen Fehler findet, ist herzlich eingeladen, sich zu beteiligen. Das Git-Repo findet ihr hier: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository von WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Ja, sorry. Jetzt ist sie also da, die 10.000ste Toolsammlung. Aber hey, immerhin hat sie eine gute Entstehungsgeschichte, und wer weiß, vielleicht erspart sie euch im Alltag genauso viel Sucherei wie mir!
            </p>

            <p>Viel Spaß damit!</p>
            <p>Ramon</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Kostenloser Online-Übersetzungsdienst" class="text-decoration-none text-muted">Übersetzt mit deepl.com (kostenlose Version)</a>
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
