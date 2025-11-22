<?php

/**
 * 403 Forbidden Error Page
 *
 * Displays a user-friendly error page when access to a resource is denied.
 * Supports multi-language detection via URL parameters and cookies.
 *
 * PHP version 7.4+
 *
 * @category  ErrorPage
 * @package   WebDevTools
 * @license   MIT License
 */

declare(strict_types=1);

$errorCode = 403;

// Detect language from URL parameter or cookie, fallback to English
$lang = $_GET['lang'] ?? $_COOKIE['lang'] ?? 'en';
$lang = in_array($lang, ['en', 'de'], true) ? $lang : 'en';

require_once __DIR__ . '/partials/error-template.php';
