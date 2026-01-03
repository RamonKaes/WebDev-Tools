<?php

declare(strict_types=1);

define('BASE_URL_DEFINED', true);
define('SUPPORTED_LANGS', ['en', 'de', 'es', 'pt', 'fr', 'it']);

// Security: Strict host validation with whitelist
// Prevents Host header manipulation attacks (e.g., 'localhost.attacker.tld')
// Expanded to support common development ports (8000, 8080, 3000, etc.)
$currentHost = $_SERVER['HTTP_HOST'] ?? '';
$serverName = $_SERVER['SERVER_NAME'] ?? '';
$serverPort = $_SERVER['SERVER_PORT'] ?? '80';

// Check if host is localhost/127.0.0.1 (with or without port)
$isLocalhost = (
    preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/i', $currentHost) ||
    in_array($serverName, ['localhost', '127.0.0.1'], true)
);

// Determine scheme and construct base URL dynamically for localhost
if ($isLocalhost) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $port = ($serverPort != '80' && $serverPort != '443') ? ':' . $serverPort : '';
    $baseUrl = $scheme . '://' . $serverName . $port;
} else {
    $baseUrl = 'https://webdev-tools.info';
}

// Base path: '/WebDev-Tools' for localhost, empty for production
define('BASE_PATH', $isLocalhost ? '/WebDev-Tools' : '');

$supportedLanguages = [
  'en' => [
    'name' => 'English',
    'native' => 'English',
    'flag' => '🇬🇧'
  ],
  'de' => [
    'name' => 'German',
    'native' => 'Deutsch',
    'flag' => '🇩🇪'
  ],
  'es' => [
    'name' => 'Spanish',
    'native' => 'Español',
    'flag' => '🇪🇸'
  ],
  'pt' => [
    'name' => 'Portuguese',
    'native' => 'Português',
    'flag' => '🇵🇹'
  ],
  'fr' => [
    'name' => 'French',
    'native' => 'Français',
    'flag' => '🇫🇷'
  ],
  'it' => [
    'name' => 'Italian',
    'native' => 'Italiano',
    'flag' => '🇮🇹'
  ]
];

$defaultLang = 'en';

function detectUserLanguage($supportedLanguages, $defaultLang)
{
  // 1. Check URL parameter (?lang=de)
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if (preg_match('/^[a-z]{2}$/', $lang) && isset($supportedLanguages[$lang])) {
            return $lang;
        }
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            error_log("Warning: Invalid language code attempt: " . htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'));
        }
    }

  // 2. Check cookie (webdev-tools-lang)
    if (isset($_COOKIE['webdev-tools-lang'])) {
        $cookieLang = $_COOKIE['webdev-tools-lang'];
        if (preg_match('/^[a-z]{2}$/', $cookieLang) && isset($supportedLanguages[$cookieLang])) {
            return $cookieLang;
        }
    }

  // 3. Check browser language (Accept-Language header)
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLangs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($browserLangs as $browserLang) {
            $code = strtok(trim($browserLang), '-;');
            if (preg_match('/^[a-z]{2}$/i', $code)) {
                $code = strtolower($code);
                if (isset($supportedLanguages[$code])) {
                    return $code;
                }
            }
        }
    }

  // 4. Fallback to default
    return $defaultLang;
}

if (!isset($lang)) {
    $lang = detectUserLanguage($supportedLanguages, $defaultLang);
}

$i18nConfig = [
  'supportedLanguages' => $supportedLanguages,
  'defaultLang' => $defaultLang,
  'currentLang' => $lang
];
