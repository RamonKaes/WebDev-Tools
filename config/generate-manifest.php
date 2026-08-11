#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Generate Tool Manifest
 *
 * Creates a unified manifest.json from tools.php configuration
 * This eliminates duplication across tool-loader.js, head.php, and index.php
 *
 * Usage: php generate-manifest.php
 */

// Security: Only allow CLI execution
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Access denied. This script can only be executed via command line.');
}

require_once __DIR__ . '/config.php';
$toolsConfig = require __DIR__ . '/tools.php';

// Use BASE_PATH from config.php or CLI argument
$baseUrl = $argv[1] ?? BASE_PATH ?? '';

// Validate BASE_PATH
if ($baseUrl && !str_starts_with($baseUrl, '/')) {
    echo "⚠️  Warning: BASE_PATH should start with / (got: {$baseUrl})\n";
    $baseUrl = '/' . $baseUrl;
}

echo "📦 Generating manifest with BASE_PATH: '{$baseUrl}'\n";

$manifest = [
  'version' => date('Ymd.His'),
  'generatedAt' => date('c'),
  'tools' => []
];

foreach ($toolsConfig as $toolId => $config) {
    $slug = $config['slug'] ?? strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $toolId));

    $manifest['tools'][$toolId] = [
    'id' => $toolId,
    'slug' => $slug,
    'url' => $baseUrl . '/' . $slug . '/',
    'category' => $config['category'] ?? 'utilities',
    'icon' => $config['icon'] ?? 'bi-tools',
    'jsPath' => $baseUrl . '/assets/js/' . ($config['jsModule'] ?? "tools/{$toolId}.js"),
    'externalLibraries' => $config['externalLibraries'] ?? [],
    'jsLibraries' => $config['jsLibraries'] ?? [],
    'features' => $config['features'] ?? [],
    'hasFeaturesSection' => $config['hasFeaturesSection'] ?? false,
    'hasAboutSection' => $config['hasAboutSection'] ?? false
    ];
}

$outputPath = __DIR__ . '/manifest.json';
$json = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

if (file_put_contents($outputPath, $json)) {
    echo "✅ Manifest generated successfully!\n";
    echo "   - Output: {$outputPath}\n";
    echo "   - Tools: " . count($manifest['tools']) . "\n";
    exit(0);
} else {
    echo "❌ Failed to write manifest.json\n";
    exit(1);
}
