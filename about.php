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
$pageTitle = 'About WebDev-Tools – Free Developer Utilities';
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

  <?php include __DIR__ . '/partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

    <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
      <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">About WebDev Tools</h1>
          <p class="lead text-secondary">
            From local script to (yes, the 10,000th) tool collection: A chronicle of
            chance
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
              Yes, I know. The 10,000th tool collection on the internet. Who needs it?
              But I can reassure you: this project was never planned. It is an accident,
              a product of procrastination, and a lesson in dealing with artificial
              intelligence.
            </p>
            <p>
              It all started innocently enough on my desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              In the beginning was the script.
            </h2>
            <p>
              Like many developers, I had stored a few of my own tools on my localhost.
              Small scripts for everyday annoyances – an Em/Px conversion
              here, a little helper there. Things I was too lazy to keep searching for and opening on the
              same websites. I'm on absolute war footing with bookmarks.
            </p>
            </p>
            <p>
              These little helpers did their job. But then I added two more.
              And then it happened: my web developer instinct kicked in.
            </p>
            <p class="mb-5">
              Instinctively, I started linking them together. I needed a menu.
              And a little styling. And everything else that comes to mind
              when you want to successfully distract yourself from your actual work. So
              a simple collection of scripts turned into a full-fledged project. I just had to
              “pimp” it until I had a real little website with all the bells and
              whistles.
            </p>


            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              “AI, take over!” – A crazy idea?
            </h2>
            <p>
              At some point, it occurred to me: these are just simple scripts. Why not let
              AI do it? As a loyal user of <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Free code editor">VS Code</a>, I set up the project directly with
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI by Anthropic">Claude Sonnet 4.5</a> (in <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - AI pair programmer">GitHub CoPilot</a>).
            </p>
            <p>
              I was surprised because the result was an amazingly good, modularly
              expandable web application.
            </p>
            <p>
              Of course, it wasn't that easy. You have to constantly keep the AI from
              overdoing it. My most important command quickly became: "No, we don't need a
              package manager! And now stop trying to suggest another framework to me!"
            </p>
            <p class="mb-5">
              In the end, however, a usable basic framework did indeed emerge.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              The pitfalls of “vibe coding” with AI
            </h2>
            <p>
              The project picked up speed and I quickly learned a few hard lessons about
              working with my new digital colleagues.
            </p>
            <p>
              The framework question: AIs prefer to work with <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Utility-first CSS framework">Tailwind</a>. They did so
              here as well. After a few manual adjustments, during which my patience was wearing
              thin, I finally snapped. I quickly switched to <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Front-end framework">Bootstrap</a>
              to bring the collection to a swift and pragmatic conclusion. Sometimes
              "done" is simply better than 'perfect' (or "Tailwind").
            </p>
            <p>
              2. Without <a href="https://git-scm.com/" target="_blank" rel="noopener noreferrer" title="Git - Distributed version control system">Git</a>? No way! Out of pure habit, I created a <a href="https://git-scm.com/book/en/v2/Git-Basics-Getting-a-Git-Repository" target="_blank" rel="noopener noreferrer" title="Git Repository - Version control basics">Git repository</a> right away.
              Luckily! I quickly realized that what I was doing—this
              haphazard "vibe coding" with AI—was a huge
              waste of time without Git.
            </p>
            <p>
              3. The pitfalls of AI logic: The biggest problem is that AIs like to make life
              easy for themselves, but in the wrong way.
            </p>
            <ul>
              <li>
                They speculate: Instead of analyzing what you actually want to do, they often
                just guess wildly. You have to stop this speculation very quickly and give them
                precise instructions for each step, otherwise it ends in chaos.
              <li>
                They love their own scripts. They tend to suggest their own scripts or solutions,
                which often lead to disastrous results. In quite a few
                cases, this would have required a complete restart of the project,
                had it not been for a courageous “git reset --hard.”
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. AI ping-pong during code reviews
              I also relied on AIs for quality assurance, but with a system:
              First, I had <a href="https://openai.com/o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Advanced reasoning model">GPT-5 Codex</a> perform the code reviews and
              then sought the opinion of <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - AI safety and research">Claude Sonnet 4.5</a>. An AI review for
              the AI review, so to speak. It's pretty meta, but extremely useful for
              cross-checking different "ways of thinking."
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonus round: AI as a translator?
            </h2>
            <p>
              Once the functionality was in place, I thought about translations. First, I tried
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - AI safety and research">Claude Sonnet 4.5</a>. According to its own statement, the AI has native-level proficiency in English and
              German and delivers 98% accuracy in Spanish, French,
              Italian, and Portuguese.
            </p>
            <p>
              Things got interesting when I asked about Hindi, Chinese, or Japanese. Here,
              the AI admitted that it needs external help, such as <a href="https://www.deepl.com/" target="_blank" rel="noopener noreferrer" title="DeepL - AI translation service">DeepL</a>. More importantly,
              it pointed out on its own that it's not just a matter of crude
              translation, but that cultural idiosyncrasies and
              forms of politeness must also be taken into account.
            </p>
            <p class="mb-5">
              A refreshing degree of self-reflection. However, Claude was too cerebral for the actual batch translation
              of the static, hard-coded part of the Romance languages.
              I had <a href="https://openai.com/o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Advanced reasoning model">GPT-5 Codex</a> do it instead. The same applies here: the right tool for the right job!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              From the intranet to the wild web
            </h2>
            <p>
              Once the tool collection had grown to a certain size (and even spoke several languages),
              it was only available on our company network for quite some time
              and served us well.
            </p>
            <p>
              At some point, I thought to myself: Why not? So I tidied it up
              and made it public.
            </p>
            <p>
              And because the whole thing came about as an "accident" anyway, the code is completely open. If you want to tinker yourself or find a bug: You can find the Git repo here: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository of WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Yes, sorry. Now it's here. The 10,000th tool collection. But hey, at least
              it has a story behind it! :D
            </p>
            <p>
              Enjoy!
            </p>
            <p class="mb-0">Ramon</p>
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
