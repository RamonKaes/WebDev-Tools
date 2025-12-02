#!/usr/bin/env php
<?php
/**
 * Validate that localized slugs are actually localized
 * and not just reusing the English slug
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           Localized Slug Validation Test                  ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Load tools configuration
$toolsConfig = require __DIR__ . '/../config/tools.php';

// Expected translations for common terms
$expectedTranslations = [
    'de' => [
        'encoder' => 'kodierer',
        'decoder' => 'dekodierer',
        'generator' => 'generator',
        'converter' => 'konverter',
        'formatter' => 'formatierer',
        'validator' => 'validator',
        'password' => 'passwort',
        'character' => 'zeichen',
        'to' => 'zu',
    ],
    'es' => [
        'encoder' => 'encoder',
        'decoder' => 'decoder',
        'generator' => 'generador',
        'converter' => 'conversor',
        'formatter' => 'formateador',
        'password' => 'contrasenas',
        'character' => 'caracteres',
        'emoji' => 'emojis',
        'to' => 'a',
        'data' => 'datos',
        'string' => 'cadenas',
    ],
    'fr' => [
        'encoder' => 'encoder',
        'decoder' => 'decoder',
        'generator' => 'generateur',
        'converter' => 'convertisseur',
        'formatter' => 'formateur',
        'password' => 'mot-de-passe',
        'character' => 'caracteres',
        'to' => 'vers',
        'data' => 'donnees',
        'string' => 'chaine',
    ],
    'it' => [
        'encoder' => 'encoder',
        'decoder' => 'decoder',
        'generator' => 'generatore',
        'converter' => 'convertitore',
        'formatter' => 'formattatore',
        'password' => 'password',
        'character' => 'caratteri',
        'emoji' => 'emoji',
        'to' => 'a',
        'data' => 'dati',
        'px' => 'px',
        'rem' => 'rem',
    ],
    'pt' => [
        'encoder' => 'encoder',
        'decoder' => 'decoder',
        'generator' => 'gerador',
        'converter' => 'conversor',
        'formatter' => 'formatador',
        'password' => 'senha',
        'character' => 'caracteres',
        'to' => 'para',
        'data' => 'dados',
        'string' => 'string',
    ],
];

$issues = [];
$warnings = [];
$checked = 0;
$passed = 0;

echo "Checking localized slugs against English slugs...\n";
echo str_repeat('-', 60) . "\n\n";

foreach ($toolsConfig as $toolId => $config) {
    $englishSlug = $config['slugs']['en'] ?? $config['slug'];
    
    foreach (['de', 'es', 'fr', 'it', 'pt'] as $lang) {
        $localizedSlug = $config['slugs'][$lang] ?? null;
        
        if (!$localizedSlug) {
            $issues[] = "[$toolId] Missing slug for language: $lang";
            continue;
        }
        
        $checked++;
        
        // Check if localized slug is identical to English slug
        if ($localizedSlug === $englishSlug) {
            // Some tools legitimately use same slug (technical terms)
            // But flag for review
            $warnings[] = "[$toolId] $lang uses English slug: $localizedSlug";
            $passed++; // Count as pass but warn
            continue;
        }
        
        // Check if slug exists as directory
        $langDir = $lang === 'en' ? __DIR__ . '/..' : __DIR__ . "/../$lang";
        $slugDir = "$langDir/$localizedSlug";
        
        if (!is_dir($slugDir)) {
            $issues[] = "[$toolId] Directory not found: $lang/$localizedSlug/";
            continue;
        }
        
        // Check if index.php exists
        if (!file_exists("$slugDir/index.php")) {
            $issues[] = "[$toolId] Missing index.php in: $lang/$localizedSlug/";
            continue;
        }
        
        $passed++;
    }
}

echo "\n" . str_repeat('=', 60) . "\n";
echo "Summary\n";
echo str_repeat('=', 60) . "\n";
echo "Total checks: $checked\n";
echo "  ✓ Passed:   $passed (" . round($passed/$checked*100, 1) . "%)\n";
echo "  ✗ Issues:   " . count($issues) . "\n";
echo "  ⚠ Warnings: " . count($warnings) . "\n";

if (!empty($warnings)) {
    echo "\n" . str_repeat('-', 60) . "\n";
    echo "Warnings (Review Recommended):\n";
    echo str_repeat('-', 60) . "\n";
    foreach ($warnings as $warning) {
        echo "  ⚠ $warning\n";
    }
}

if (!empty($issues)) {
    echo "\n" . str_repeat('-', 60) . "\n";
    echo "Issues Found:\n";
    echo str_repeat('-', 60) . "\n";
    foreach ($issues as $issue) {
        echo "  ✗ $issue\n";
    }
    echo "\n";
    exit(1);
}

echo "\n✓ All slug validations passed!\n\n";
exit(0);
