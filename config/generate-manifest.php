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

// The version is a hash of everything the browser caches under "?v=<version>":
// tool scripts, shared scripts and translations. It changes only when one of
// them changes, so build.sh and CI can regenerate the manifest and compare.
$versionedFiles = array_merge(
    glob(__DIR__ . '/../assets/js/*.js') ?: [],
    glob(__DIR__ . '/../assets/js/lib/*.js') ?: [],
    glob(__DIR__ . '/../assets/js/tools/*.js') ?: [],
    glob(__DIR__ . '/i18n/*.json') ?: [],
    [__DIR__ . '/tools.php']
);
sort($versionedFiles);
$hashContext = hash_init('xxh128');
foreach ($versionedFiles as $file) {
    hash_update($hashContext, basename($file) . ':' . hash_file('xxh128', $file) . "\n");
}
$version = substr(hash_final($hashContext), 0, 16);

$manifest = [
  'version' => $version,
  'tools' => []
];

foreach ($toolsConfig as $toolId => $config) {
    $slug = $config['slug'] ?? strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $toolId));

    $manifest['tools'][$toolId] = [
    'id' => $toolId,
    'slug' => $slug,
    'slugs' => $config['slugs'] ?? [],
    'url' => $baseUrl . '/' . $slug . '/',
    'category' => $config['category'] ?? 'utilities',
    'icon' => $config['icon'] ?? 'bi-tools',
    'jsPath' => $baseUrl . '/assets/js/' . ($config['jsModule'] ?? "tools/{$toolId}.js"),
    'externalLibraries' => $config['externalLibraries'] ?? [],
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
    echo "   - Version: {$version}\n";
    exit(0);
} else {
    echo "❌ Failed to write manifest.json\n";
    exit(1);
}
