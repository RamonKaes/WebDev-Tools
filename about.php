<?php

/**
 * About Page
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

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/config/security-headers.php';

$lang = 'en';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH;
$homeUrl = BASE_PATH;
$pageTitle = 'About WebDev-Tools – Privacy-First Developer Utilities Free';
$pageDescription = 'Learn about WebDev-Tools, a collection of free, privacy-friendly developer utilities built with passion by Ramon Kaes.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="keywords" content="WebDev-Tools, About, Ramon Kaes, Developer Tools, Privacy-Friendly">
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
  <meta property="og:locale" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
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
  <link rel="stylesheet" href="<?= assetSrc('css/style.css') ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>

<body class="d-flex flex-column bg-body">

  <?php include __DIR__ . '/partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

    <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
      <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">About WebDev Tools</h1>
          <p class="lead text-secondary">
            The 10,000th Tool Collection – An Accident Report
          </p>
          
          <!-- Standards Compliance Badges -->
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
              <i class="bi bi-lock-fill me-1"></i>Client-Side Only
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Yeah, I know. The ten-thousandth collection of tools on the internet. Who even needs that?<br>
              But I can put your minds at ease. This project was never planned. It’s an accident, a product of pure procrastination, but it also arose out of a genuine need. It all started quite innocently on my desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              In the beginning, there was the script.
            </h2>
            <p>
              Like many developers, I had various homemade tools saved on my localhost. Little scripts for everyday annoyances: an em/px conversion here, a little helper there. Things I was too lazy to look up on the same websites every time. I’m absolutely at war with bookmarks, after all.
            </p>
            <p class="mb-3">
              These little helpers did their job well. But then I added two more, and my web developer’s instinct struck mercilessly: I started linking them together. I needed a menu. A little styling. And suddenly I was right in the middle of everything that comes to mind when you’re trying to successfully distract yourself from your actual work. The simple collection turned into a full-fledged project. I just had to “pimp” it until I had a proper little website with all the bells and whistles right in front of me.
            </p>

            <h2 class="h5 card-title mb-3">
              From script chaos to a real web app.
            </h2>
            <p class="mb-3">
              I wanted to turn those scattered scripts into a reliable platform. To speed up the development process and make code structuring more efficient, I integrated <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Claude Code AI assistant">Claude Code</a> directly into my workflow. But the focus was always on pragmatism: the tools should load quickly, be intuitive to use, and do exactly what they’re supposed to do, without unnecessary bells and whistles. Every web developer knows the temptation to get lost in endless discussions about the perfect framework or the most elegant architecture. Instead, I opted for the direct approach: a solid <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap CSS framework">Bootstrap</a> foundation, a clean codebase, and the ironclad rule that “finished and working” is more valuable than theoretical perfection.
            </p>

            <h2 class="h5 card-title mb-3">
              From the Intranet to the Wild Web
            </h2>
            <p>
              Once the toolset was complete, it served us well for quite some time on our company network. At some point, I thought to myself: Why not share it with the whole world?
            </p>
            <p>
              However, when releasing a project for the internet, it shouldn’t be held back by language barriers. So I was once again driven by ambition and added multilingual support to the system before its release, to make it accessible to an international audience. To implement this in a pragmatic and efficient way, I relied entirely on <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="DeepL translation tool">DeepL</a> for the text translations.
            </p>
            <p>
              Afterward, I cleaned up the code and made the site public. Since the whole thing arose from an “accident” anyway and thrives on the open-source philosophy, the code is completely open. Anyone who wants to tinker with it, has an idea for a new tool, or finds a bug is warmly invited to get involved. You can find the Git repo here: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository of WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Yeah, sorry. So here it is, the 10,000th tool collection. But hey, at least it has a good backstory, and who knows—maybe it’ll save you just as much time searching in your daily life as it did for me!
            </p>

            <p>Have fun with it!</p>
            <p>Ramon</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <?php include __DIR__ . '/partials/footer.php'; ?>

</body>

</html>
<?php
// Output minified HTML
echo minify_html_output(ob_get_clean());
?>
