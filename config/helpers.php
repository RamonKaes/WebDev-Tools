<?php

declare(strict_types=1);

/**
 * Get JSON encoding flags optimized for environment
 * In development: includes JSON_PRETTY_PRINT for debugging
 * In production: omits JSON_PRETTY_PRINT to reduce payload size (~30% smaller)
 *
 * @return int JSON encoding flags
 */
function getJsonEncodeFlags()
{
    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

  // Add pretty print only in development (localhost or 127.0.0.1)
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
        $flags |= JSON_PRETTY_PRINT;
    }

    return $flags;
}

function getAssetUrl($path, $baseUrlOverride = null)
{
    global $baseUrl;
    $base = $baseUrlOverride ?? $baseUrl ?? 'http://localhost';
    $base = rtrim($base, '/');
    $path = ltrim($path, '/');

    return htmlspecialchars("{$base}" . BASE_PATH . "/assets/{$path}", ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function getCspNonce()
{
    return $GLOBALS['csp_nonce'] ?? '';
}

function getVersionedAssetUrl($path, $baseUrl = null)
{
    $fullPath = __DIR__ . '/../assets/' . ltrim($path, '/');
    $version = file_exists($fullPath) ? filemtime($fullPath) : time();

    return getAssetUrl($path, $baseUrl) . '?v=' . $version;
}

/**
 * Get language prefix for URL construction
 *
 * @param string $lang Language code (en, de, es, pt, fr, it)
 * @return string Language prefix (e.g., '/de', '/es') or empty string for English
 */
function getLangPrefix($lang)
{
    return ($lang !== 'en') ? "/{$lang}" : '';
}

function getToolUrl($toolIdOrSlug, $lang = 'en', $baseUrlOverride = null)
{
    global $baseUrl;
    $base = $baseUrlOverride ?? $baseUrl ?? 'http://localhost';
    $base = rtrim($base, '/');

  // Try to get tool config to check for localized slugs
    $toolConfig = getToolConfig($toolIdOrSlug);

  // Security: Handle case when tool is not found
    if ($toolConfig === null) {
        error_log("[getToolUrl] Tool not found: {$toolIdOrSlug}");
      // Return homepage as fallback
        $langPrefix = getLangPrefix($lang);
        return htmlspecialchars("{$base}" . BASE_PATH . "{$langPrefix}/", ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

  // Use localized slug if available, otherwise use the provided slug
    $slug = $toolConfig['slugs'][$lang] ?? $toolConfig['slug'] ?? $toolIdOrSlug;

    $langPrefix = getLangPrefix($lang);

    return htmlspecialchars("{$base}" . BASE_PATH . "{$langPrefix}/{$slug}/", ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Generate a full URL for a given path with language prefix
 *
 * @param string $path The path (e.g., '/', '/base64-encoder-decoder/')
 * @param string $lang The language code
 * @return string The complete URL with BASE_PATH and language prefix
 */
function getFullUrl($path, $lang = 'en')
{
    global $baseUrl;
    $langPrefix = getLangPrefix($lang);
    $base = rtrim($baseUrl ?? 'http://localhost', '/');
    return htmlspecialchars($base, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH . $langPrefix . $path;
}

/**
 * Get all language URLs for a specific path
 *
 * @param string $path The path (e.g., '/', '/base64-encoder-decoder/')
 * @return array Associative array with language codes as keys and URLs as values
 */
function getAllLanguageUrls($path)
{
    return [
    'en' => getFullUrl($path, 'en'),
    'de' => getFullUrl($path, 'de'),
    'es' => getFullUrl($path, 'es'),
    'pt' => getFullUrl($path, 'pt'),
    'fr' => getFullUrl($path, 'fr'),
    'it' => getFullUrl($path, 'it')
    ];
}

/**
 * Get all language URLs for a specific tool (with localized slugs)
 *
 * @param string $toolId The tool ID (e.g., 'base64EncoderDecoder')
 * @return array Associative array with language codes as keys and URLs as values
 */
function getAllToolLanguageUrls($toolId)
{
    return [
    'en' => getToolUrl($toolId, 'en'),
    'de' => getToolUrl($toolId, 'de'),
    'es' => getToolUrl($toolId, 'es'),
    'pt' => getToolUrl($toolId, 'pt'),
    'fr' => getToolUrl($toolId, 'fr'),
    'it' => getToolUrl($toolId, 'it')
    ];
}

function getToolConfig($identifier)
{
    static $toolsConfig = null;

    if ($toolsConfig === null) {
        $toolsConfig = require __DIR__ . '/tools.php';
    }

  // Try ID match first (fastest)
    if (isset($toolsConfig[$identifier])) {
        return $toolsConfig[$identifier];
    }

  // Try standard slug search
    foreach ($toolsConfig as $config) {
        if ($config['slug'] === $identifier) {
            return $config;
        }
    }

  // Try localized slugs search (e.g., 'base64-kodierer-dekodierer')
  // This allows finding tools by their translated URLs
    foreach ($toolsConfig as $config) {
        if (isset($config['slugs']) && is_array($config['slugs'])) {
            if (in_array($identifier, $config['slugs'], true)) {
                return $config;
            }
        }
    }

    return null;
}

/**
 * Load and decode i18n JSON file with error handling
 *
 * @deprecated Use loadI18n() instead - this function lacks caching
 * @param string $lang Language code (e.g., 'en', 'de', 'es', 'pt', 'fr', 'it')
 * @return array Decoded JSON data or empty array on error (for backward compatibility)
 */
function loadI18nData($lang)
{
  // Deprecation notice in development mode
    if (defined('BASE_PATH') && strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false) {
        error_log("[Deprecated] loadI18nData() is deprecated. Use loadI18n() instead for better performance.");
    }

  // Delegate to cached function
    return loadI18n($lang);
}

/**
 * Load and decode manifest.json with static caching
 * Reduces redundant file I/O operations across multiple page renders
 *
 * @return array|null Decoded manifest data or null on error
 */
function getManifest()
{
    static $manifest = null;
    static $loaded = false;

    if (!$loaded) {
        $manifestPath = __DIR__ . '/manifest.json';

        if (file_exists($manifestPath)) {
            $json = @file_get_contents($manifestPath);
            if ($json !== false) {
                $manifest = json_decode($json, true);

                // Log errors in development mode
                if ($manifest === null && json_last_error() !== JSON_ERROR_NONE) {
                    if (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false) {
                        error_log("[getManifest] JSON decode error: " . json_last_error_msg());
                    }
                }
            }
        }

        $loaded = true;
    }

    return $manifest;
}

function getToolsByCategory($category)
{
    static $toolsConfig = null;

    if ($toolsConfig === null) {
        $toolsConfig = require __DIR__ . '/tools.php';
    }

    return array_filter($toolsConfig, function ($tool) use ($category) {
        return $tool['category'] === $category;
    });
}

function generateToolPreloads($toolId)
{
    $config = getToolConfig($toolId);
    if (!$config) {
        return '';
    }

    $preloads = [];

    $jsUrl = getAssetUrl('js/' . $config['jsModule']);
    $preloads[] = "<link rel=\"modulepreload\" href=\"{$jsUrl}\">";

    foreach ($config['jsLibraries'] ?? [] as $lib) {
        $libUrl = getAssetUrl("js/lib/{$lib}.js");
        $preloads[] = "<link rel=\"modulepreload\" href=\"{$libUrl}\">";
    }

    foreach ($config['externalLibraries'] ?? [] as $extLib) {
        $url = $extLib['url'] ?? $extLib;
        $integrity = isset($extLib['integrity']) ? " integrity=\"{$extLib['integrity']}\"" : '';
        $crossorigin = isset($extLib['crossorigin']) ? " crossorigin=\"{$extLib['crossorigin']}\"" : '';
        $preloads[] = "<link rel=\"preload\" as=\"script\" href=\"{$url}\"{$integrity}{$crossorigin}>";
    }

    return implode("\n  ", $preloads);
}

function getRelativePrefix($currentFile)
{
    $rootDir = __DIR__ . '/..';
    $currentDir = dirname($currentFile);

    $relativePath = str_replace($rootDir, '', $currentDir);
    $depth = substr_count($relativePath, '/');

    return str_repeat('../', $depth);
}

function t($i18nData, $key, $default = '')
{
    $keys = explode('.', $key);
    $value = $i18nData;

    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            return htmlspecialchars($default, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
        $value = $value[$k];
    }

    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function loadI18n(string $lang): array
{
    static $cache = [];

    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $i18nFile = __DIR__ . "/i18n/{$lang}.json";

    if (!file_exists($i18nFile)) {
        error_log("[i18n] Translation file not found: {$i18nFile}");
        $cache[$lang] = [];
        return $cache[$lang];
    }

    $handleFailure = function (string $message) use (&$cache, $lang) {
        error_log($message);

        if ($lang !== 'en') {
            $fallback = loadI18n('en');
            $cache[$lang] = $fallback;
            return $cache[$lang];
        }

        $cache[$lang] = [];
        return $cache[$lang];
    };

    $jsonContent = file_get_contents($i18nFile);
    if ($jsonContent === false) {
        return $handleFailure("[i18n] Failed to read translation file: {$i18nFile}");
    }

    try {
        $decoded = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
    } catch (\Throwable $error) {
        return $handleFailure("[i18n] JSON decode error in {$i18nFile}: " . $error->getMessage());
    }

    if (!is_array($decoded)) {
        return $handleFailure("[i18n] Invalid JSON structure in: {$i18nFile}");
    }

    $cache[$lang] = $decoded;
    return $cache[$lang];
}

function generateToolSchema($toolId, $lang, $seoData)
{
    global $baseUrl;

    $config = getToolConfig($toolId);
    if (!$config) {
        return '';
    }

    $toolUrl = htmlspecialchars_decode(getToolUrl($config['slug'], $lang), ENT_QUOTES);
    $toolName = $seoData['meta_title'] ?? 'WebDev-Tools';
    $description = $seoData['meta_description'] ?? '';
    $category = $seoData['applicationCategory'] ?? 'UtilityApplication';
    $features = $seoData['featureList'] ?? [];

    $schema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => $toolName,
    'description' => $description,
    'url' => $toolUrl,
    'applicationCategory' => $category,
    'operatingSystem' => 'Any',
    'browserRequirements' => 'Requires JavaScript',
    'inLanguage' => array_values(array_unique([$lang, 'en', 'de', 'es', 'pt', 'fr', 'it'])),
    'softwareVersion' => '1.0.0',
    'datePublished' => '2025-11-01',
    'author' => [
      '@type' => 'Organization',
      'name' => 'WebDev-Tools'
    ],
    'offers' => [
      '@type' => 'Offer',
      'price' => '0',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock'
    ],
    'permissions' => 'browser',
    'isAccessibleForFree' => true
    ];

    if (!empty($features)) {
        $schema['featureList'] = $features;
    }

    if (!empty($seoData['ogImage']) && $seoData['ogImage'] !== 'og-default.png') {
        $schema['screenshot'] = htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH . '/assets/img/og/' . $seoData['ogImage'];
    }

    $json = json_encode($schema, getJsonEncodeFlags());

    $nonce = getCspNonce();
    $nonceAttr = '';
    if (!empty($nonce)) {
        $nonceAttr = ' nonce="' . htmlspecialchars($nonce, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
    }

    return "<script type=\"application/ld+json\"{$nonceAttr}>\n{$json}\n</script>";
}

function generateBreadcrumbSchema($currentTool, $lang)
{
    global $baseUrl;

    $i18nData = loadI18n($lang) ?: [];

    $homeNames = [
    'en' => 'Home',
    'de' => 'Startseite',
    'es' => 'Inicio',
    'pt' => 'Início',
    'fr' => 'Accueil',
    'it' => 'Home'
    ];

    $homeName = $i18nData['navigation']['home'] ?? ($homeNames[$lang] ?? 'Home');

    $langPrefix = getLangPrefix($lang);

    $homeUrl = htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH . $langPrefix . '/';

    $items = [
    [
      '@type' => 'ListItem',
      'position' => 1,
      'name' => $homeName,
      'item' => $homeUrl
    ]
    ];

    if ($currentTool !== 'home') {
        $config = getToolConfig($currentTool);
        if ($config) {
            $toolData = $i18nData['tools'][$currentTool] ?? [];
            $seoData = $i18nData['seo'][$currentTool] ?? [];
            $toolName = $toolData['h1_title']
            ?? $seoData['meta_title']
            ?? $toolData['toc_title']
            ?? ($config['slug'] ?? $currentTool);
            $toolUrl = htmlspecialchars_decode(getToolUrl($currentTool, $lang), ENT_QUOTES);

            $items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $toolName,
            'item' => $toolUrl
            ];
        }
    }

    $schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $items
    ];

    $json = json_encode($schema, getJsonEncodeFlags());

    $nonce = getCspNonce();
    $nonceAttr = '';
    if (!empty($nonce)) {
        $nonceAttr = ' nonce="' . htmlspecialchars($nonce, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
    }

    return "<script type=\"application/ld+json\"{$nonceAttr}>\n{$json}\n</script>";
}

function getNavigationStructure(string $lang = 'en'): array
{
    static $cache = [];

    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    static $toolsConfig = null;

    $toolsConfig ??= require __DIR__ . '/tools.php';

    $navigation = [
    'encoders' => [],
    'formatters' => [],
    'converters' => [],
    'generators' => [],
    'stringtools' => [],
    'references' => [],
    'utilities' => []
    ];

    foreach ($toolsConfig as $toolId => $config) {
        $category = $config['category'] ?? 'utilities';
        if (isset($navigation[$category])) {
          // Use localized slug if available, otherwise use default slug
            $slug = $config['slugs'][$lang] ?? $config['slug'];

            $navigation[$category][] = [
            'key' => $toolId,
            'icon' => $config['icon'] ?? 'bi-tool',
            'url' => '/' . $slug . '/',
            'slug' => $slug
            ];
        }
    }

    $cache[$lang] = $navigation;
    return $navigation;
}

function getToolScripts(): array
{
    static $toolsConfig = null;

    $toolsConfig ??= require __DIR__ . '/tools.php';

    $scripts = [];

    foreach ($toolsConfig as $toolId => $config) {
        if (isset($config['jsModule'])) {
            $scripts[$toolId] = basename($config['jsModule']);
        }
    }

    return $scripts;
}

function getAllTools(): array
{
    static $toolsConfig = null;

    $toolsConfig ??= require __DIR__ . '/tools.php';

    return $toolsConfig;
}

/**
 * Minify HTML output for production
 * Removes unnecessary whitespace, line breaks, and comments
 * while preserving functionality and inline scripts/styles.
 *
 * Only active in production (non-localhost environments)
 *
 * @param string $html Raw HTML output
 * @return string Minified HTML
 */
function minify_html_output(string $html): string
{
    // Only minify in production (not on localhost/127.0.0.1)
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
        return $html;
    }

    // Minification rules
    $search = [
        '/\>[^\S ]+/s',                    // Strip whitespace after tags, except space
        '/[^\S ]+\</s',                    // Strip whitespace before tags, except space
        '/(\s)+/s',                        // Shorten multiple whitespace sequences
        '/<!--(?!\[if\s)(.|\s)*?-->/s',   // Remove HTML comments (except IE conditionals)
    ];

    $replace = [
        '>',
        '<',
        '\\1',
        '',
    ];

    $html = preg_replace($search, $replace, $html);

    return $html;
}
