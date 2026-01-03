<?php
// Simple router script for PHP built-in server.
// Serves existing files directly; falls back to index.php for app routing.
$url  = parse_url($_SERVER['REQUEST_URI']);
$file = __DIR__ . '/../' . ltrim($url['path'], '/');

if ($url['path'] !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // serve the requested resource as-is
}

// Fallback to index.php
require_once __DIR__ . '/../index.php';
