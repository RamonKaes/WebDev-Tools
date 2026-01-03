<?php

/**
 * 500 Internal Server Error Page
 *
 * Displays a user-friendly error page when the server encounters an internal error.
 * Supports multi-language detection via URL parameters and cookies.
 *
 * PHP version 7.4+
 *
 * @category  ErrorPage
 * @package   WebDevTools
 * @license   MIT License
 */

declare(strict_types=1);

$errorCode = 500;

// Detect language from URL parameter or cookie, fallback to English
$lang = $_GET['lang'] ?? $_COOKIE['webdev-tools-lang'] ?? 'en';
$lang = in_array($lang, ['en', 'de', 'es', 'pt', 'fr', 'it'], true) ? $lang : 'en';

require_once __DIR__ . '/partials/error-template.php';
