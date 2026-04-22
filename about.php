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
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">

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
            ﻿The 10,000th Tool Collection – An Accident Report
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
              Yeah, I know. The ten-thousandth tool collection on the internet. Who
              needs that? But I can reassure you: This project was never planned.
              It's an accident, a product of pure procrastination, but also a lesson
              in working with artificial intelligence.
            </p>
            <p>
              It all started quite innocently on my desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              In the Beginning Was the Script
            </h2>
            <p>
              Like many developers, I had stockpiled various homemade tools on my
              localhost. Little scripts for everyday annoyances: an em/px conversion
              here, a little helper there. Things I was too lazy to look up on the
              same websites every time. I'm absolutely at war with bookmarks, you see.
            </p>
            <p class="mb-5">
              These little helpers did their job well. But then I added two more,
              and my web developer instinct struck mercilessly: I started linking
              them together. I needed a menu. A little styling. And suddenly I was
              right in the middle of everything that comes to mind when you want to
              successfully distract yourself from your actual work. The simple
              collection turned into a full-fledged project. I just had to "pimp" it
              until I had a proper little website with all the bells and whistles in
              front of me.
            </p>


            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              "AI, Take Over!" - Was That a Crazy Idea?
            </h2>
            <p>
              At some point, it occurred to me: They're just simple scripts. Why not
              let the AI handle it? As a loyal user of
              <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Free code editor">VS Code</a>,
              I set up the project directly with
              <a href="https://www.anthropic.com/claude-code" target="_blank" rel="noopener noreferrer" title="Claude Code by Anthropic">Claude Code (Sonnet)</a>.
            </p>
            <p>
              But before giving the AI free rein, I needed clear guidelines. So first
              and foremost, I defined a fixed tech stack. From this, I derived a
              <code>CLAUDE.md</code> (strictly limited to a maximum of 60 lines - short
              command paths are essential for AI) as well as a <code>.claude/comments/review.md</code>.
              Just as vital for your wallet are a consistent .claudeignore file and a
              specifically tailored <code>.claude/settings.local.json</code> to save a
              massive amount of tokens while coding.
            </p>
            <p class="mb-5">
              The result was surprising: an amazingly good, modularly expandable web
              application. But of course, not everything went smoothly. You have to
              constantly stop an AI from overdoing it. My most important command
              quickly became: "No, we don't need a package manager! And now stop
              trying to suggest another framework to me!"
              In the end, though, a usable foundation actually emerged.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              The Pitfalls of "Vibe Coding"
            </h2>
            <p>
              The project picked up steam, and I quickly learned some hard lessons
              about collaborating with my digital colleagues.
            </p>
            <ul class="mb-5">
              <li>
                The framework question: AIs love
                <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Utility-first CSS framework">Tailwind</a>.
                After a few manual tweaks that stretched my patience to the limit, it
                finally snapped. I switched to
                <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Front-end framework">Bootstrap</a>
                to pragmatically wrap things up. Sometimes "done" is simply better than
                "perfect" (or Tailwind).
              </li><br>
              <li>
                No Git? No way! Out of habit, I created a
                <a href="https://git-scm.com/book/en/v2/Git-Basics-Getting-a-Git-Repository" target="_blank" rel="noopener noreferrer" title="Git Repository - Version control basics">repo</a>
                right away. Thank goodness! I quickly realized that this haphazard
                "vibe coding" without version control ends up being a massive waste of
                time.
              </li><br>
              <li>
                AI logic vs. reality: AIs sometimes make life too easy - or too
                complicated. Claude has improved massively in this regard and now
                analyzes code much more thoroughly instead of speculating blindly.
                However, if you don't specify precisely where the journey should lead,
                AIs still tend toward idiosyncratic script solutions that end in a dead
                end. Without a bold "git reset --hard," I would likely have had to
                completely restart the project more than once anyway.
              </li><br>
              <li>
                AI Ping-Pong During Code Review: For quality assurance, I relied on a
                system of "checks and balances." Using the /review command, I trigger
                Claude's internal review, which operates strictly according to the
                guidelines in my review.md. In addition, I had external reviews
                conducted by ChatGPT and Gemini and then discussed the results with
                Claude Opus. This "AI review for the AI review" is pretty meta, but
                extremely useful for cross-checking different ways of thinking and
                closing logical gaps.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonus Round: AI as a Translator?
            </h2>
            <p>
              Once the functionality was in place, it was time for the translations.
              Here, the AI showed its philosophical side:
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - AI safety and research">Claude Sonnet 4.5</a>
              pointed out to me, without being asked, that languages like Hindi,
              Chinese, or Japanese aren't just about vocabulary, but also about
              cultural idiosyncrasies and forms of politeness. That was a refreshing
              level of self-reflection.
            </p>
            <p class="mb-5">
              In practice, however, things took a pragmatic turn: For the actual
              batch translation of the static content, Claude was too "intellectual"
              and too complicated for me. With Gemini and ChatGPT, the quality of the
              output fluctuated too much. In the end, I had everything translated by
              <a href="https://www.deepl.com/" target="_blank" rel="noopener noreferrer" title="DeepL - AI translation service">DeepL</a>.
              Here, too, the rule applies: The right tool for the right job!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              From the Intranet to the Wild Web
            </h2>
            <p>
              Once the toolkit was finished and even supported multiple languages, it
              served us well on our company network for quite some time. At some
              point, I thought to myself: Why not share it?
            </p>
            <p>
              So I cleaned things up and made the site public. And since the whole
              thing came about by accident anyway, the code is completely open-source.
              If you want to tinker with it or find a bug: You can find the Git repo
              here:
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository of WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Yeah, sorry. So here it is, the 10,000th tool collection. The 10,000th
              tool collection. But hey, at least it has a good origin story!
            </p>
            <p>Have fun with it!</p>
            <p>Ramon</p>
            <div class="text-center">
              <img src="assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Free online translation service" class="text-decoration-none text-muted">Translated with deepl.com (free version)</a>
          </small>
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
