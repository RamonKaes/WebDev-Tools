<?php

declare(strict_types=1);

/**
 * Language Switch Handler
 *
 * Handles language switching with secure server-side cookie management.
 * Called via AJAX from i18n.js
 *
 * @created 4. November 2025
 */

// Prevent direct access
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    exit('Direct access not permitted');
}

// Get language from request
$lang = $_POST['lang'] ?? $_GET['lang'] ?? null;

// Validate language
$allowedLanguages = ['en', 'de', 'es', 'pt', 'fr', 'it'];
if (!in_array($lang, $allowedLanguages, true)) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid language']);
    exit;
}

// Set secure cookie
$cookieOptions = [
    'expires' => time() + (30 * 24 * 60 * 60), // 30 days
    'path' => '/',
    'domain' => '', // Current domain
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', // Secure flag if HTTPS
    'httponly' => false, // Allow JavaScript access for i18n.js
    'samesite' => 'Strict' // CSRF protection
];

setcookie('webdev-tools-lang', $lang, $cookieOptions);

// Return success response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'lang' => $lang,
    'cookie_set' => true
]);
