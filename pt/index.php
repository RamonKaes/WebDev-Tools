<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'pt';
$currentTool = 'home';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/pt';
$dashboardToolBaseUrl = './';
$homeUrl = BASE_PATH . '/pt';
$pageTitle = 'WebDev-Tools – Ferramentas de desenvolvimento e conversores online gratuitos';
$pageDescription = 'Ferramentas profissionais para desenvolvedores web: JSON Formatter, Base64 Encoder, URL Encoder, UUID Generator, Password Generator e mais. 100% gratuito, do lado do cliente e amigável à privacidade.';

$i18nData = loadI18n($lang) ?: [];
$t = $i18nData;
$tools = $i18nData['tools'] ?? [];

// Generate all language URLs
$langUrls = getAllLanguageUrls('/');
$currentUrl = getFullUrl('/', $lang);

// Extract individual language URLs for header partial
$enUrl = $langUrls['en'] ?? BASE_PATH . '/';
$deUrl = $langUrls['de'] ?? BASE_PATH . '/de/';
$esUrl = $langUrls['es'] ?? BASE_PATH . '/es/';
$ptUrl = $langUrls['pt'] ?? BASE_PATH . '/pt/';
$frUrl = $langUrls['fr'] ?? BASE_PATH . '/fr/';
$itUrl = $langUrls['it'] ?? BASE_PATH . '/it/';

// Load manifest with caching
$manifest = getManifest();
$buildHash = '1.0.0';
if ($manifest && isset($manifest['generatedAt'])) {
  $buildHash = preg_replace('/[^0-9]/', '', substr($manifest['generatedAt'], 0, 19));
}
?>
<!DOCTYPE html>
<html lang="pt" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="keywords" content="Formatador JSON, Codificador Base64, Codificador URL, Gerador UUID, Gerador de Senhas, Gerador Hash, Ferramentas para Desenvolvedores Web">
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="WebDev-Tools">

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"> 
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home-pt.svg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="pt_PT">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="fr_FR">
  <meta property="og:locale:alternate" content="it_IT">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home-pt.svg">
  <meta name="twitter:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />
  <link rel="alternate" hreflang="x-default" href="<?= $langUrls['en'] ?>" />
  <link rel="alternate" hreflang="en" href="<?= $langUrls['en'] ?>" />
  <link rel="alternate" hreflang="de" href="<?= $langUrls['de'] ?>" />
  <link rel="alternate" hreflang="es" href="<?= $langUrls['es'] ?>" />
  <link rel="alternate" hreflang="pt" href="<?= $langUrls['pt'] ?>" />
  <link rel="alternate" hreflang="fr" href="<?= $langUrls['fr'] ?>" />
  <link rel="alternate" hreflang="it" href="<?= $langUrls['it'] ?>" />
  
  <script type="application/ld+json" nonce="<?= htmlspecialchars(getCspNonce(), ENT_QUOTES, 'UTF-8') ?>">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "WebDev-Tools",
    "description": "<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>",
    "url": "<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>",
    "inLanguage": ["pt", "en", "de", "es", "fr", "it"],
    "potentialAction": {
      "@type": "SearchAction",
      "target": {
        "@type": "EntryPoint",
        "urlTemplate": "<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>?q={search_term_string}"
      },
      "query-input": "required name=search_term_string"
    }
  }
  </script>
  
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>
  <script src="<?= $assetPrefix ?>assets/js/helpers.js?v=<?= $buildHash ?>"></script>
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">
</head>

<body class="d-flex flex-column bg-body">

  <?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    
    <div class="left-sidebar-spacer"></div>

  <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">
      <div class="text-center mb-5">
        <h1 class="display-5 mb-3">Ferramentas gratuitas para desenvolvedores</h1>
        <p class="lead text-secondary">Utilitários para desenvolvedores web.</p>
      </div>

      <ul class="nav nav-tabs mb-4 d-none d-lg-flex" id="categoryTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="all-tab" data-category="all" type="button"
            role="tab" aria-selected="true">Todas as Ferramentas</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="encoders-tab" data-category="encoders" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['encoders'] ?? 'Mostrar ferramentas de codificação e decodificação', ENT_QUOTES, 'UTF-8') ?>">Codificadores</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="formatters-tab" data-category="formatters" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['formatters'] ?? 'Mostrar ferramentas de formatação e validação', ENT_QUOTES, 'UTF-8') ?>">Formatadores</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="converters-tab" data-category="converters" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['converters'] ?? 'Mostrar utilitários de conversão', ENT_QUOTES, 'UTF-8') ?>">Conversores</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="generators-tab" data-category="generators" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['generators'] ?? 'Mostrar ferramentas de geração', ENT_QUOTES, 'UTF-8') ?>">Geradores</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="stringtools-tab" data-category="stringtools" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['stringtools'] ?? 'Mostrar ferramentas de manipulação de strings', ENT_QUOTES, 'UTF-8') ?>">Ferramentas de Texto</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="references-tab" data-category="references" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['references'] ?? 'Mostrar ferramentas de referência e consulta', ENT_QUOTES, 'UTF-8') ?>">Referências</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="utilities-tab" data-category="utilities" type="button"
            role="tab" aria-selected="false"
            title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['utilities'] ?? 'Mostrar utilitários', ENT_QUOTES, 'UTF-8') ?>">Utilit

ários</button>
        </li>
      </ul>

      <div class="dropdown mb-4 d-lg-none">
        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-funnel me-2"></i><span id="selectedCategory">Todas as Ferramentas</span>
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="categoryDropdown">
          <li><a class="dropdown-item active" href="#" data-category="all">Todas as Ferramentas</a></li>
          <li><a class="dropdown-item" href="#" data-category="encoders" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['encoders'] ?? 'Mostrar ferramentas de codificação e decodificação', ENT_QUOTES, 'UTF-8') ?>">Codificadores</a></li>
          <li><a class="dropdown-item" href="#" data-category="formatters" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['formatters'] ?? 'Mostrar ferramentas de formatação e validação', ENT_QUOTES, 'UTF-8') ?>">Formatadores</a></li>
          <li><a class="dropdown-item" href="#" data-category="converters" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['converters'] ?? 'Mostrar utilitários de conversão', ENT_QUOTES, 'UTF-8') ?>">Conversores</a></li>
          <li><a class="dropdown-item" href="#" data-category="generators" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['generators'] ?? 'Mostrar ferramentas de geração', ENT_QUOTES, 'UTF-8') ?>">Geradores</a></li>
          <li><a class="dropdown-item" href="#" data-category="stringtools" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['stringtools'] ?? 'Mostrar ferramentas de manipulação de strings', ENT_QUOTES, 'UTF-8') ?>">Ferramentas de Texto</a></li>
          <li><a class="dropdown-item" href="#" data-category="references" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['references'] ?? 'Mostrar ferramentas de referência e consulta', ENT_QUOTES, 'UTF-8') ?>">Referências</a></li>
          <li><a class="dropdown-item" href="#" data-category="utilities" 
              title="<?= htmlspecialchars($t['navigation']['categories']['filterTitle']['utilities'] ?? 'Mostrar utilitários', ENT_QUOTES, 'UTF-8') ?>">Utilitários</a></li>
        </ul>
      </div>
      
      <div class="row g-4" id="toolsGrid">
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="encoders">
          <a href="<?= getToolUrl('base64EncoderDecoder', 'pt') ?>" data-tool-id="base64EncoderDecoder" class="text-decoration-none">
            <div class="card h-100 tool-card">
                <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-file-binary me-2"></i>
                  <?= htmlspecialchars($tools['base64EncoderDecoder']['toc_title'] ?? 'Base64 Encoder/Decoder', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['base64EncoderDecoder']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="encoders">
          <a href="<?= getToolUrl('urlEncoderDecoder', 'pt') ?>" data-tool-id="urlEncoderDecoder" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-link-45deg me-2"></i>
                  <?= htmlspecialchars($tools['urlEncoderDecoder']['toc_title'] ?? 'URL Encoder/Decoder', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['urlEncoderDecoder']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="encoders">
          <a href="<?= getToolUrl('htmlEntityTool', 'pt') ?>" data-tool-id="htmlEntityTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-code-square me-2"></i>
                  <?= htmlspecialchars($tools['htmlEntityTool']['toc_title'] ?? 'HTML Entity Encoder/Decoder', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['htmlEntityTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="encoders">
          <a href="<?= getToolUrl('jwtDecoderTool', 'pt') ?>" data-tool-id="jwtDecoderTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-shield-lock me-2"></i>
                  <?= htmlspecialchars($tools['jwtDecoderTool']['toc_title'] ?? 'JWT Decoder', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['jwtDecoderTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="encoders">
          <a href="<?= getToolUrl('punycodeConverterTool', 'pt') ?>" data-tool-id="punycodeConverterTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-globe me-2"></i>
                  <?= htmlspecialchars($tools['punycodeConverterTool']['toc_title'] ?? 'Punycode Converter', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['punycodeConverterTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="formatters">
          <a href="<?= getToolUrl('jsonFormatterValidator', 'pt') ?>" data-tool-id="jsonFormatterValidator" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-filetype-json me-2"></i>
                  <?= htmlspecialchars($tools['jsonFormatterValidator']['toc_title'] ?? 'JSON Formatter/Validator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['jsonFormatterValidator']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="formatters">
          <a href="<?= getToolUrl('codeFormatterTool', 'pt') ?>" data-tool-id="codeFormatterTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-code-square me-2"></i>
                  <?= htmlspecialchars($tools['codeFormatterTool']['toc_title'] ?? 'Code Formatter & Beautifier', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['codeFormatterTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="converters">
          <a href="<?= getToolUrl('dataConverterTool', 'pt') ?>" data-tool-id="dataConverterTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-arrow-left-right me-2"></i>
                  <?= htmlspecialchars($tools['dataConverterTool']['toc_title'] ?? 'Daten-Konverter', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['dataConverterTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="converters">
          <a href="<?= getToolUrl('pxToRemConverter', 'pt') ?>" data-tool-id="pxToRemConverter" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-arrows-angle-expand me-2"></i>
                  <?= htmlspecialchars($tools['pxToRemConverter']['toc_title'] ?? 'PX ⇄ REM Konverter', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['pxToRemConverter']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="converters">
          <a href="<?= getToolUrl('aspectRatioCalculator', 'pt') ?>" data-tool-id="aspectRatioCalculator" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-aspect-ratio me-2"></i>
                  <?= htmlspecialchars($tools['aspectRatioCalculator']['toc_title'] ?? 'Proporção de Aspecto', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['aspectRatioCalculator']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="generators">
          <a href="<?= getToolUrl('uuidGeneratorTool', 'pt') ?>" data-tool-id="uuidGeneratorTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-fingerprint me-2"></i>
                  <?= htmlspecialchars($tools['uuidGeneratorTool']['toc_title'] ?? 'UUID Generator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['uuidGeneratorTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="generators">
          <a href="<?= getToolUrl('passwordGeneratorTool', 'pt') ?>" data-tool-id="passwordGeneratorTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-shield-lock me-2"></i>
                  <?= htmlspecialchars($tools['passwordGeneratorTool']['toc_title'] ?? 'Passwort Generator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['passwordGeneratorTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="generators">
          <a href="<?= getToolUrl('hashGeneratorTool', 'pt') ?>" data-tool-id="hashGeneratorTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-hash me-2"></i>
                  <?= htmlspecialchars($tools['hashGeneratorTool']['toc_title'] ?? 'Hash Generator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['hashGeneratorTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="generators">
          <a href="<?= getToolUrl('loremIpsumTool', 'pt') ?>" data-tool-id="loremIpsumTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-file-text me-2"></i>
                  <?= htmlspecialchars($tools['loremIpsumTool']['toc_title'] ?? 'Lorem Ipsum Generator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['loremIpsumTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="generators">
          <a href="<?= getToolUrl('qrCodeGeneratorTool', 'pt') ?>" data-tool-id="qrCodeGeneratorTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-qr-code me-2"></i>
                  <?= htmlspecialchars($tools['qrCodeGeneratorTool']['toc_title'] ?? 'QR Code Generator', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['qrCodeGeneratorTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <!-- String Escaper -->
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="stringtools">
          <a href="<?= getToolUrl('stringEscaperTool', 'pt') ?>" data-tool-id="stringEscaperTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-code-slash me-2"></i>
                  <?= htmlspecialchars($tools['stringEscaperTool']['toc_title'] ?? 'String Escaper', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['stringEscaperTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <!-- Referência de Caracteres HTML -->
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="references">
          <a href="<?= getToolUrl('characterReferenceTool', 'pt') ?>" data-tool-id="characterReferenceTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-table me-2"></i>
                  <?= htmlspecialchars($tools['characterReference']['toc_title'] ?? 'Referência de Caracteres HTML', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['characterReference']['card_description'] ?? 'Explorar entidades HTML, caracteres Unicode e símbolos especiais', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <!-- Referência de Emojis -->
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="references">
          <a href="<?= getToolUrl('emojiReferenceTool', 'pt') ?>" data-tool-id="emojiReferenceTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                  <i class="bi bi-emoji-smile me-2"></i>
                  <?= htmlspecialchars($tools['emojiReference']['toc_title'] ?? 'Referência de Emojis', ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['emojiReference']['card_description'] ?? 'Explorar e copiar emojis com códigos Unicode', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>

        <!-- Dienstprogramme Kategorie -->
        <div class="col-12 col-md-6 col-lg-4 tool-item" data-category="utilities">
          <a href="<?= getToolUrl('regexTesterTool', 'pt') ?>" data-tool-id="regexTesterTool" class="text-decoration-none">
            <div class="card h-100 tool-card">
              <div class="card-body d-flex flex-column">
                  <h3 class="card-title fs-5 mb-2">
                    <i class="bi bi-regex me-2"></i>
                    <?= htmlspecialchars($tools['regexTesterTool']['toc_title'] ?? 'Regex Tester', ENT_QUOTES, 'UTF-8') ?>
                  </h3>
                <p class="card-text text-secondary flex-grow-1">
                  <?= htmlspecialchars($tools['regexTesterTool']['card_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </main>
  
  </div> <!-- Close d-flex wrapper -->

<?php include __DIR__ . '/../partials/common-scripts.php'; ?>

  <script src="../assets/js/category-filter.js?v=<?= $buildHash ?>"></script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
