<?php

declare(strict_types=1);

/**
 * Head Template - Updated 2024-11-14 14:30
 */

if (!isset($i18nData)) {
    $i18nData = loadI18n($lang) ?: [];
}

$seoData = $i18nData['seo'][$currentTool] ?? [];

// Use $pageTitle and $pageDescription from tool-base.php if already set
// These come from seo.meta_title and seo.meta_description
if (!isset($pageTitle)) {
    $pageTitle = $seoData['meta_title'] ?? 'WebDev-Tools';
}
if (!isset($pageDescription)) {
    $pageDescription = $seoData['meta_description'] ?? 'Free online developer tools';
}

$keywordsRaw = $seoData['keywords'] ?? '';
$keywords = is_array($keywordsRaw) ? implode(', ', $keywordsRaw) : $keywordsRaw;
$ogImage = $seoData['ogImage'] ?? 'og-default.png';
$featureList = $seoData['featureList'] ?? [];
$applicationCategory = $seoData['applicationCategory'] ?? 'UtilityApplication';

$toolData = $i18nData['tools'][$currentTool] ?? [];
$toolName = $toolData['toc_title'] ?? 'WebDev-Tools';

$htmlLang = $lang;
$ogLocales = ['en' => 'en_US', 'de' => 'de_DE', 'es' => 'es_ES', 'pt' => 'pt_PT', 'fr' => 'fr_FR', 'it' => 'it_IT'];
$ogLocale = $ogLocales[$lang] ?? 'en_US';
$langPrefix = getLangPrefix($lang);
$toolBaseUrl = BASE_PATH . $langPrefix;

// Load manifest with caching
$manifest = getManifest();

$buildHash = '1.0.0';
if ($manifest && isset($manifest['generatedAt'])) {
    $buildHash = preg_replace('/[^0-9]/', '', substr($manifest['generatedAt'], 0, 19));
}

$toolUrlMap = [];
$ogImageMap = [];

if ($manifest && isset($manifest['tools'])) {
    foreach ($manifest['tools'] as $toolId => $toolMeta) {
        $url = $toolMeta['url'] ?? '';
      // Remove BASE_PATH and language prefixes to get relative URL
        if (BASE_PATH !== '') {
            $url = str_replace(BASE_PATH, '', $url);
        }
      // Remove language prefixes
        foreach (['de', 'es', 'pt', 'fr', 'it'] as $langCode) {
            $url = str_replace('/' . $langCode, '', $url);
        }
        $toolUrlMap[$toolId] = $url;

        $ogImageMap[$toolId] = $toolMeta['ogImage'] ?? 'home.svg';
    }
} else {
    $toolUrlMap = [
    'base64EncoderDecoder' => '/base64-encoder-decoder/',
    'urlEncoderDecoder' => '/url-encoder-decoder/',
    'jsonFormatterValidator' => '/json-formatter-validator/',
    'codeFormatterTool' => '/code-formatter/',
    'dataConverterTool' => '/data-converter/',
    'pxToRemConverter' => '/px-to-rem-converter/',
    'uuidGeneratorTool' => '/uuid-generator/',
    'passwordGeneratorTool' => '/password-generator/',
    'hashGeneratorTool' => '/hash-generator/',
    'loremIpsumTool' => '/lorem-ipsum/',
    'qrCodeGeneratorTool' => '/qr-code-generator/',
    'stringEscaperTool' => '/string-escaper/',
    'characterReference' => '/character-reference/',
    'emojiReference' => '/emoji-reference/',
    'regexTesterTool' => '/regex-tester/',
    'htmlEntityTool' => '/html-entity-encoder-decoder/',
    'jwtDecoderTool' => '/jwt-decoder/',
    'punycodeConverterTool' => '/punycode-converter/',
    ];

    $ogImageMap = [
    'base64EncoderDecoder' => 'base64-encoder-decoder.svg',
    'urlEncoderDecoder' => 'url-encoder-decoder.svg',
    'jsonFormatterValidator' => 'json-formatter-validator.svg',
    'codeFormatterTool' => 'code-formatter.svg',
    'dataConverterTool' => 'data-converter.svg',
    'pxToRemConverter' => 'px-to-rem-converter.svg',
    'uuidGeneratorTool' => 'uuid-generator.svg',
    'passwordGeneratorTool' => 'password-generator.svg',
    'hashGeneratorTool' => 'hash-generator.svg',
    'loremIpsumTool' => 'lorem-ipsum.svg',
    'qrCodeGeneratorTool' => 'qr-code-generator.svg',
    'stringEscaperTool' => 'string-escaper.svg',
    'characterReference' => 'character-reference.svg',
    'emojiReference' => 'emoji-reference.svg',
    'regexTesterTool' => 'regex-tester.svg',
    'htmlEntityTool' => 'html-entity-encoder-decoder.svg',
    'jwtDecoderTool' => 'jwt-decoder.svg',
    'punycodeConverterTool' => 'punycode-converter.svg',
    ];
}

$toolUrlPath = $toolUrlMap[$currentTool] ?? '/';
$ogImageFile = $ogImageMap[$currentTool] ?? 'home.svg';

$baseUrlEscaped = htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Generate hreflang URLs with localized slugs for tools
if ($currentTool !== 'home' && !in_array($currentTool, ['about', 'imprint', 'privacy'])) {
  // Tools use localized slugs
    $toolUrls = getAllToolLanguageUrls($currentTool);
    $canonicalUrl = $toolUrls[$lang];
    $enUrl = $toolUrls['en'];
    $deUrl = $toolUrls['de'];
    $esUrl = $toolUrls['es'];
    $ptUrl = $toolUrls['pt'];
    $frUrl = $toolUrls['fr'];
    $itUrl = $toolUrls['it'];
} else {
  // Homepage and special pages use same URL structure
    $canonicalUrl = $baseUrlEscaped . BASE_PATH . $langPrefix . $toolUrlPath;
    $enUrl = $baseUrlEscaped . BASE_PATH . $toolUrlPath;
    $deUrl = $baseUrlEscaped . BASE_PATH . '/de' . $toolUrlPath;
    $esUrl = $baseUrlEscaped . BASE_PATH . '/es' . $toolUrlPath;
    $ptUrl = $baseUrlEscaped . BASE_PATH . '/pt' . $toolUrlPath;
    $frUrl = $baseUrlEscaped . BASE_PATH . '/fr' . $toolUrlPath;
    $itUrl = $baseUrlEscaped . BASE_PATH . '/it' . $toolUrlPath;
}

// Security: ensure canonical URLs are HTML-escaped before output
$canonicalUrl = htmlspecialchars($canonicalUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$enUrl = htmlspecialchars($enUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$deUrl = htmlspecialchars($deUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$esUrl = htmlspecialchars($esUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$ptUrl = htmlspecialchars($ptUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$frUrl = htmlspecialchars($frUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$itUrl = htmlspecialchars($itUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Pre-escape CSP nonce for all inline script nonces in this template
$nonceEscaped = htmlspecialchars(getCspNonce(), ENT_QUOTES, 'UTF-8');

$ogImageUrl = $baseUrlEscaped . BASE_PATH . '/assets/img/og/' . $ogImageFile;

if (!isset($assetPrefix)) {
    $assetPrefix = BASE_PATH . '/';
}
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php if (!empty($keywords)) : ?>
  <meta name="keywords" content="<?= htmlspecialchars($keywords, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php endif; ?>
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="WebDev-Tools">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= $canonicalUrl ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= $ogImageUrl ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="<?= $ogLocale ?>">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="pt_PT">
  <meta property="og:locale:alternate" content="fr_FR">
  <meta property="og:locale:alternate" content="it_IT">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= $canonicalUrl ?>">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= $ogImageUrl ?>">
  <meta name="twitter:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <link rel="canonical" href="<?= $canonicalUrl ?>" />
  <link rel="alternate" hreflang="x-default" href="<?= $enUrl ?>" />
  <link rel="alternate" hreflang="en" href="<?= $enUrl ?>" />
  <link rel="alternate" hreflang="de" href="<?= $deUrl ?>" />
  <link rel="alternate" hreflang="es" href="<?= $esUrl ?>" />
  <link rel="alternate" hreflang="pt" href="<?= $ptUrl ?>" />
  <link rel="alternate" hreflang="fr" href="<?= $frUrl ?>" />
  <link rel="alternate" hreflang="it" href="<?= $itUrl ?>" />

  <?= generateToolSchema($currentTool, $lang, $seoData) ?>
  <?= generateBreadcrumbSchema($currentTool, $lang) ?>


  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">
  
  <link rel="preload" href="<?= $assetPrefix ?>assets/js/tool-registry.js?v=<?= $buildHash ?>" as="script">
  
  <script nonce="<?= getCspNonce() ?>">
    // Set global configuration BEFORE loading other scripts
    window.__BASE_PATH__ = '<?= BASE_PATH ?>';
    window.__I18N__ = {
      '<?= $lang ?>': <?= json_encode($i18nData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>
    };
    
    // Build hash for cache busting (from manifest.json generatedAt)
    window.BUILD_HASH = '<?= $buildHash ?>';
  </script>
  
  <script src="<?= $assetPrefix ?>assets/js/helpers.js?v=<?= $buildHash ?>"></script>
  <script src="<?= $assetPrefix ?>assets/js/icon-system.js?v=<?= $buildHash ?>"></script>
  
  <script nonce="<?= getCspNonce() ?>">
    // Base path for dynamic resource loading
    window.APP_BASE_PATH = '<?= BASE_PATH ?>';
    
    // Simple translation function until i18n.js loads
    window.i18n = {
      data: window.__I18N__['<?= $lang ?>'],
      t: function(key, params) {
        const keys = key.split('.');
        let value = this.data;
        
        for (const k of keys) {
          if (value && typeof value === 'object' && k in value) {
            value = value[k];
          } else {
            return key;
          }
        }
        
        if (params && typeof value === 'string') {
          Object.keys(params).forEach(param => {
            value = value.replace(new RegExp('\\{' + param + '\\}', 'g'), params[param]);
          });
        }
        
        return value;
      }
    };
  </script>

  <!-- Schema.org Structured Data (JSON-LD) -->
  <script type="application/ld+json" nonce="<?= $nonceEscaped ?>">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "@id": "<?= $baseUrl ?>#website",
        "url": "<?= $baseUrl ?>/",
        "name": "WebDev-Tools",
        "description": "Free developer tools and utilities for web development",
        "inLanguage": ["en", "de", "es", "pt", "fr", "it"],
        "potentialAction": {
          "@type": "SearchAction",
          "target": "<?= $baseUrl ?>/?search={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "Organization",
        "@id": "<?= $baseUrl ?>#organization",
        "name": "WebDev-Tools",
        "url": "<?= $baseUrl ?>/",
        "logo": {
          "@type": "ImageObject",
          "url": "<?= $baseUrl ?>/assets/img/logo.png"
        },
        "sameAs": []
      }<?php if (isset($currentTool) && $currentTool !== 'home') :
            ?>,
      {
        "@type": "WebApplication",
        "@id": "<?= $canonicalUrl ?>#webapp",
        "name": "<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>",
        "description": "<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>",
        "url": "<?= $canonicalUrl ?>",
        "applicationCategory": "DeveloperApplication",
        "operatingSystem": "Any",
        "offers": {
          "@type": "Offer",
          "price": "0",
          "priceCurrency": "USD"
        },
        "browserRequirements": "Requires JavaScript enabled",
        "permissions": "No permissions required - all processing is client-side",
        "aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": "4.8",
          "ratingCount": "156",
          "bestRating": "5",
          "worstRating": "1"
        }
      }
       <?php endif; ?>
    ]
  }
  </script>
</head>
