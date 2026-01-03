<?php

declare(strict_types=1);

/**
 * Security Headers Configuration
 *
 * Sets HTTP security headers to protect against XSS, clickjacking, MIME-sniffing.
 * Include after config.php in all pages.
 */

// Prevent direct access
if (!defined('BASE_URL_DEFINED')) {
    http_response_code(403);
    exit('Direct access not permitted');
}

/**
 * Content Security Policy (CSP)
 * Nonce-based policy to prevent XSS and code injection attacks
 */

// Generate cryptographic nonce for this request
if (!isset($GLOBALS['csp_nonce'])) {
    $GLOBALS['csp_nonce'] = base64_encode(random_bytes(16));
}
$cspNonce = $GLOBALS['csp_nonce'];

$cspDirectives = [
    "default-src 'self'",
    "script-src 'self' 'nonce-{$cspNonce}' https://cdn.jsdelivr.net https://www.googletagmanager.com",
    "style-src 'self' https://cdn.jsdelivr.net",
    "font-src 'self' https://cdn.jsdelivr.net",
    "img-src 'self' data: blob: https:",
    "object-src 'none'",
    "media-src 'none'",
    "worker-src 'self'",
    "manifest-src 'self'"
];

// Detect HTTPS: check direct connection and proxy headers
$isHttps = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
    (!empty($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false)
);

// Add HTTPS-only directive when behind HTTPS
if ($isHttps) {
    $cspDirectives[] = "upgrade-insecure-requests";
}

$cspDirectives[] = "frame-ancestors 'none'";
$cspDirectives[] = "base-uri 'self'";
$cspDirectives[] = "form-action 'self'";

header("Content-Security-Policy: " . implode('; ', $cspDirectives));

/**
 * X-Frame-Options
 * Prevents iframe embedding (clickjacking protection)
 */
header("X-Frame-Options: DENY");

/**
 * X-Content-Type-Options
 * Prevents MIME-sniffing
 */
header("X-Content-Type-Options: nosniff");

/**
 * X-XSS-Protection
 * Legacy XSS protection for older browsers
 */
header("X-XSS-Protection: 1; mode=block");

/**
 * Referrer-Policy
 * Controls referrer information sent with requests
 */
header("Referrer-Policy: strict-origin-when-cross-origin");

/**
 * Permissions-Policy
 * Disables unnecessary browser features
 */
$permissionsPolicies = [
    "geolocation=()",
    "microphone=()",
    "camera=()",
    "payment=()",
    "usb=()",
    "magnetometer=()",
    "gyroscope=()",
    "accelerometer=()"
];

header("Permissions-Policy: " . implode(', ', $permissionsPolicies));

/**
 * Strict-Transport-Security (HSTS)
 * Forces HTTPS connections
 * Respects X-Forwarded-Proto for proxy/CDN deployments
 */
if ($isHttps) {
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
}

/**
 * Cache-Control
 * Prevents caching of HTML pages
 */
header("Cache-Control: no-cache, no-store, must-revalidate, private");
header("Pragma: no-cache");
header("Expires: 0");
