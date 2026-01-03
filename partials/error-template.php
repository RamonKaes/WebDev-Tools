<?php
if (!isset($errorCode)) {
    http_response_code(400);
    exit('Bad Request: Error code not specified');
}

$lang ??= $_COOKIE['lang'] ?? 'en';
$lang = in_array($lang, ['en', 'de'], true) ? $lang : 'en';

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/security-headers.php';
require_once __DIR__ . '/../config/helpers.php';

http_response_code($errorCode);

$errorPages = [
  404 => [
    'en' => [
      'title' => 'Page Not Found',
      'heading' => '404 - Page Not Found',
      'message' => 'The page you are looking for does not exist or has been moved.',
      'icon' => 'exclamation-triangle',
      'suggestion' => 'Please check the URL or return to the homepage.'
    ],
    'de' => [
      'title' => 'Seite nicht gefunden',
      'heading' => '404 - Seite nicht gefunden',
      'message' => 'Die von Ihnen gesuchte Seite existiert nicht oder wurde verschoben.',
      'icon' => 'exclamation-triangle',
      'suggestion' => 'Bitte überprüfen Sie die URL oder kehren Sie zur Startseite zurück.'
    ]
  ],
  403 => [
    'en' => [
      'title' => 'Access Forbidden',
      'heading' => '403 - Access Forbidden',
      'message' => 'You do not have permission to access this resource.',
      'icon' => 'shield-lock',
      'suggestion' => 'If you believe this is an error, please contact the administrator.'
    ],
    'de' => [
      'title' => 'Zugriff verweigert',
      'heading' => '403 - Zugriff verweigert',
      'message' => 'Sie haben keine Berechtigung, auf diese Ressource zuzugreifen.',
      'icon' => 'shield-lock',
      'suggestion' => 'Wenn Sie glauben, dass dies ein Fehler ist, kontaktieren Sie bitte den Administrator.'
    ]
  ],
  500 => [
    'en' => [
      'title' => 'Internal Server Error',
      'heading' => '500 - Internal Server Error',
      'message' => 'An unexpected error occurred on the server.',
      'icon' => 'exclamation-triangle-fill',
      'suggestion' => 'Please try again later or contact support if the problem persists.'
    ],
    'de' => [
      'title' => 'Interner Serverfehler',
      'heading' => '500 - Interner Serverfehler',
      'message' => 'Auf dem Server ist ein unerwarteter Fehler aufgetreten.',
      'icon' => 'exclamation-triangle-fill',
      'suggestion' => 'Bitte versuchen Sie es später erneut oder kontaktieren Sie den Support, wenn das Problem weiterhin besteht.'
    ]
  ]
];

$errorContent = $errorPages[$errorCode][$lang] ?? $errorPages[404][$lang];

$pageTitle = $errorContent['title'] . ' | WebDev-Tools';
$assetPrefix = BASE_PATH . '/';

$i18nData = loadI18n($lang);
$navigationStructure = getNavigationStructure();

// Error pages don't use tools, set to 'home' for SEO schema
$currentTool = 'home';

// Extract head.php logic for SEO metadata
$seoData = [];
$pageDescription = $errorContent['message'];
$keywords = '';
$ogImage = 'og-default.png';
$htmlLang = $lang;
$ogLocales = ['en' => 'en_US', 'de' => 'de_DE', 'es' => 'es_ES', 'pt' => 'pt_PT', 'fr' => 'fr_FR', 'it' => 'it_IT'];
$ogLocale = $ogLocales[$lang] ?? 'en_US';
$langPrefix = getLangPrefix($lang);

// Build hash for cache busting
$manifest = getManifest();
$buildHash = '1.0.0';
if ($manifest && isset($manifest['generatedAt'])) {
    $buildHash = preg_replace('/[^0-9]/', '', substr($manifest['generatedAt'], 0, 19));
}

// URLs for canonical and hreflang
$baseUrlEscaped = htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$canonicalUrl = $baseUrlEscaped . BASE_PATH . $langPrefix . '/';
$enUrl = $baseUrlEscaped . BASE_PATH . '/';
$deUrl = $baseUrlEscaped . BASE_PATH . '/de/';
$esUrl = $baseUrlEscaped . BASE_PATH . '/es/';
$ptUrl = $baseUrlEscaped . BASE_PATH . '/pt/';
$frUrl = $baseUrlEscaped . BASE_PATH . '/fr/';
$itUrl = $baseUrlEscaped . BASE_PATH . '/it/';
$ogImageUrl = $baseUrlEscaped . BASE_PATH . '/assets/img/og/home.svg';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>" data-bs-theme="auto">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="WebDev-Tools">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
  <meta name="robots" content="noindex, nofollow">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= $canonicalUrl ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= $ogImageUrl ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="<?= $ogLocale ?>">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= $canonicalUrl ?>">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= $ogImageUrl ?>">

  <!-- Canonical & hreflang -->
  <link rel="canonical" href="<?= $canonicalUrl ?>" />
  <link rel="alternate" hreflang="en" href="<?= $enUrl ?>" />
  <link rel="alternate" hreflang="de" href="<?= $deUrl ?>" />
  <link rel="alternate" hreflang="es" href="<?= $esUrl ?>" />
  <link rel="alternate" hreflang="pt" href="<?= $ptUrl ?>" />
  <link rel="alternate" hreflang="fr" href="<?= $frUrl ?>" />
  <link rel="alternate" hreflang="it" href="<?= $itUrl ?>" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <!-- Preconnect -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

  <!-- Theme initialization (must load before body) -->
  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  
  <!-- Custom styles -->
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">
  
  <!-- i18n data and globals -->
  <script nonce="<?= getCspNonce() ?>">
    window.__I18N__ = {
      '<?= $lang ?>': <?= json_encode($i18nData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>
    };
    window.BUILD_HASH = '<?= $buildHash ?>';
    window.APP_BASE_PATH = '<?= BASE_PATH ?>';
  </script>
</head>
<body class="error-page">
  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <?php include __DIR__ . '/header-with-sidebar.php'; ?>

  <main class="flex-grow-1 min-vh-75">
    <div class="container-fluid">

      <div class="d-flex justify-content-center align-items-center error-container-min-height">
        <div class="text-center">
          <div class="mb-4">
            <i class="bi bi-<?= htmlspecialchars($errorContent['icon']) ?> text-danger error-icon-large"></i>
          </div>
          
          <h1 class="display-5 mb-3"><?= htmlspecialchars($errorContent['heading']) ?></h1>
          
          <p class="lead text-muted mb-2"><?= htmlspecialchars($errorContent['message']) ?></p>
          <p class="text-muted mb-4"><?= htmlspecialchars($errorContent['suggestion']) ?></p>
          
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?= BASE_PATH . ($lang === 'de' ? '/de/' : '/') ?>" class="btn btn-primary">
              <i class="bi bi-house-door me-2"></i>
              <?= $lang === 'de' ? 'Zur Startseite' : 'Go to Homepage' ?>
            </a>
            <button type="button" class="btn btn-outline-secondary" id="goBackBtn">
              <i class="bi bi-arrow-left me-2"></i>
              <?= $lang === 'de' ? 'Zurück' : 'Go Back' ?>
            </button>
          </div>
        </div>
      </div>

    </div>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>
  <?php include __DIR__ . '/common-scripts.php'; ?>
  
  <script nonce="<?= getCspNonce() ?>">
    document.addEventListener('DOMContentLoaded', function() {
      const goBackBtn = document.getElementById('goBackBtn');
      if (goBackBtn) {
        goBackBtn.addEventListener('click', function() {
          history.back();
        });
      }
    });
  </script>

</body>
</html>
