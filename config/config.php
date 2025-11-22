<?php
define('BASE_URL_DEFINED', true);
define('SUPPORTED_LANGS', ['en', 'de', 'es', 'pt', 'fr', 'it']);

// Security: Strict host validation with whitelist
// Prevents Host header manipulation attacks (e.g., 'localhost.attacker.tld')
$allowedLocalHosts = ['localhost', '127.0.0.1', 'localhost:80', '127.0.0.1:80'];
$currentHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocalhost = in_array($currentHost, $allowedLocalHosts, true);

$baseUrl = $isLocalhost
    ? 'http://localhost' 
    : 'https://webdev-tools.info';

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

function detectUserLanguage($supportedLanguages, $defaultLang) {
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

