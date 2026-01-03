#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Validate OG Images Script
 *
 * Checks that all tools defined in tools.php have corresponding OG images
 * and that all OG images in assets/img/og/ are referenced
 *
 * Usage: php validate-og-images.php
 */

// Security: Only allow CLI execution
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Access denied. This script can only be executed via command line.');
}

require_once __DIR__ . '/tools.php';

$toolsConfig = include __DIR__ . '/tools.php';
$ogImageDir = __DIR__ . '/../assets/img/og/';

// Load OG Image mapping from manifest (single source of truth)
$manifestPath = __DIR__ . '/manifest.json';

if (!file_exists($manifestPath)) {
    echo "❌ manifest.json not found. Run generate-manifest.php first.\n";
    exit(1);
}

try {
    $manifest = json_decode(file_get_contents($manifestPath), true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    echo "❌ Error: Failed to parse manifest.json: " . $e->getMessage() . "\n";
    exit(1);
}

// Extract OG image map from manifest
$ogImageMap = [];
foreach ($manifest['tools'] as $toolId => $toolData) {
    $ogImageMap[$toolId] = $toolData['ogImage'] ?? null;
}

echo "🔍 Validating OG Images...\n\n";

$errors = [];
$warnings = [];

// Check 1: All tools have OG image mapping
foreach ($toolsConfig as $toolId => $config) {
    if (!isset($ogImageMap[$toolId])) {
        $errors[] = "❌ Tool '{$toolId}' missing in \$ogImageMap";
    }
}

// Check 2: All mapped OG images exist
foreach ($ogImageMap as $toolId => $filename) {
    $filepath = $ogImageDir . $filename;
    if (!file_exists($filepath)) {
        $errors[] = "❌ OG image missing: {$filename} (for tool '{$toolId}')";
    }
}

// Check 3: All OG images in directory are mapped
$ogImages = glob($ogImageDir . '*.svg');
foreach ($ogImages as $filepath) {
    $filename = basename($filepath);
    if ($filename === 'home.svg' || $filename === 'default.svg') {
        continue; // Skip special images
    }

    if (!in_array($filename, $ogImageMap)) {
        $warnings[] = "⚠️  Orphaned OG image (not mapped): {$filename}";
    }
}

// Output results
if (empty($errors) && empty($warnings)) {
    echo "✅ All OG images validated successfully!\n";
    echo "   - " . count($toolsConfig) . " tools checked\n";
    echo "   - " . count($ogImageMap) . " OG images mapped\n";
    exit(0);
}

if (!empty($errors)) {
    echo "ERRORS:\n";
    foreach ($errors as $error) {
        echo "  $error\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "WARNINGS:\n";
    foreach ($warnings as $warning) {
        echo "  $warning\n";
    }
    echo "\n";
}

exit(count($errors) > 0 ? 1 : 0);
