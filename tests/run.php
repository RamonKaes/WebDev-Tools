#!/usr/bin/env php
<?php
// Minimal CLI runner for server-side checks
// Use: php tests/run.php

function ok($msg){ echo "  ✓ " . $msg . "\n"; }
function fail($msg){ echo "  ✗ " . $msg . "\n"; }
function section($title){ echo "\n" . str_repeat('=', 60) . "\n" . $title . "\n" . str_repeat('=', 60) . "\n"; }
function subsection($title){ echo "\n→ " . $title . "\n" . str_repeat('-', 60) . "\n"; }

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║          WebDev-Tools — Server-Side Test Suite            ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";

section("Environment Checks");

// PHP version
if (PHP_VERSION_ID < 70100) { 
    fail('PHP version too old: ' . PHP_VERSION); 
    exit(1); 
} else { 
    ok('PHP version ' . PHP_VERSION); 
}

// JSON support
if (function_exists('json_encode')) { 
    ok('JSON functions available'); 
} else { 
    fail('Missing JSON functions'); 
}

// Optional: check config/config.php exists (do not expose contents)
$cfg = __DIR__ . '/../config/config.php';
if (file_exists($cfg)) { 
    ok('Server config present (config.php)'); 
} else { 
    fail('Server config (config.php) not found'); 
}

// Load checks list
$checks_file = __DIR__ . '/checks.json';
$checks = [];
if (file_exists($checks_file)) {
	$json = file_get_contents($checks_file);
	$checks = json_decode($json, true) ?: [];
}

// Base URL for server checks — use env BASE_URL or default to localhost path
$base = $argv[1] ?? getenv('BASE_URL') ?: 'http://localhost/WebDev-Tools';

section("HTTP Endpoint Checks");
echo "Base URL: " . $base . "\n";

$results = [];
$passed = 0;
$failed = 0;

// Group checks by language/category
$groups = [
    'Core' => [],
    'English Tools' => [],
    'German (de)' => [],
    'Spanish (es)' => [],
    'French (fr)' => [],
    'Italian (it)' => [],
    'Portuguese (pt)' => []
];

foreach ($checks as $p) {
    if (in_array($p, ['index.php', 'sitemap.xml', 'robots.txt'])) {
        $groups['Core'][] = $p;
    } elseif (strpos($p, 'de/') === 0) {
        $groups['German (de)'][] = $p;
    } elseif (strpos($p, 'es/') === 0) {
        $groups['Spanish (es)'][] = $p;
    } elseif (strpos($p, 'fr/') === 0) {
        $groups['French (fr)'][] = $p;
    } elseif (strpos($p, 'it/') === 0) {
        $groups['Italian (it)'][] = $p;
    } elseif (strpos($p, 'pt/') === 0) {
        $groups['Portuguese (pt)'][] = $p;
    } else {
        $groups['English Tools'][] = $p;
    }
}

foreach ($groups as $groupName => $paths) {
    if (empty($paths)) continue;
    
    subsection($groupName);
    
    foreach ($paths as $p) {
        if (substr($p,0,1) === '/') $url = rtrim($base, '/') . $p; 
        else $url = rtrim($base, '/') . '/' . $p;
        
        $h = @get_headers($url);
        $isOk = false;
        $status = 0;
        
        if ($h && is_array($h)) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $h[0], $m)) {
                $status = (int)$m[1];
                $isOk = ($status >= 200 && $status < 300);
            }
        }
        
        $shortPath = strlen($p) > 45 ? '...' . substr($p, -42) : $p;
        $displayPath = str_pad($shortPath, 45);
        
        if ($isOk) { 
            ok($displayPath . " [" . $status . "]");
            $passed++;
        } else { 
            fail($displayPath . " [" . $status . "]");
            $failed++;
        }
        
        $results[] = ['check' => $p, 'ok' => $isOk, 'status' => $status];
    }
}

// Save summary
$out_dir = __DIR__ . '/reports';
if (!is_dir($out_dir)) mkdir($out_dir, 0755, true);
$summary = ['timestamp' => date(DATE_ATOM), 'results' => $results];
file_put_contents($out_dir . '/run-summary.json', json_encode($summary, JSON_PRETTY_PRINT));

echo "\n";

// ============================================================
// ADDITIONAL VALIDATION TESTS
// ============================================================

section("Homepage Localized Links");
subsection("German (de) Tool Slugs");

$de_homepage = @file_get_contents("$base/de/");
$de_localized_tools = [
    'code-formatierer' => 'Code Formatter',
    'html-entity-kodierer-dekodierer' => 'HTML Entity Tool',
    'json-formatierer-validator' => 'JSON Formatter',
    'jwt-dekodierer' => 'JWT Decoder',
    'punycode-konverter' => 'Punycode Converter',
    'string-maskierer' => 'String Escaper',
    'url-kodierer-dekodierer' => 'URL Encoder'
];

foreach ($de_localized_tools as $slug => $name) {
    if ($de_homepage && strpos($de_homepage, "/de/$slug/") !== false) {
        ok("$name → /de/$slug/");
        $passed++;
    } else {
        fail("$name → /de/$slug/ NOT FOUND");
        $failed++;
    }
}

subsection("Spanish (es) Tool Slugs");

$es_homepage = @file_get_contents("$base/es/");
$es_localized_tools = [
    'escapador-cadenas' => 'String Escaper',
    'generador-contrasenas' => 'Password Generator',
    'conversor-datos' => 'Data Converter'
];

foreach ($es_localized_tools as $slug => $name) {
    if ($es_homepage && strpos($es_homepage, "/es/$slug/") !== false) {
        ok("$name → /es/$slug/");
        $passed++;
    } else {
        fail("$name → /es/$slug/ NOT FOUND");
        $failed++;
    }
}

section("Navigation & Language Switcher");
subsection("Sidebar Navigation (German)");

$de_sidebar_tools = [
    'code-formatierer' => 'Code Formatter',
    'jwt-dekodierer' => 'JWT Decoder',
    'string-maskierer' => 'String Escaper'
];

foreach ($de_sidebar_tools as $slug => $name) {
    if ($de_homepage && strpos($de_homepage, "/de/$slug/") !== false) {
        ok("Sidebar: $name → /de/$slug/");
        $passed++;
    } else {
        fail("Sidebar: $name missing");
        $failed++;
    }
}

subsection("Language Switcher URLs");

$de_tool_page = @file_get_contents("$base/de/code-formatierer/");
if ($de_tool_page && strpos($de_tool_page, "/code-formatter/") !== false) {
    ok("DE→EN: /de/code-formatierer/ → /code-formatter/");
    $passed++;
} else {
    fail("Language switcher DE→EN missing");
    $failed++;
}

$en_tool_page = @file_get_contents("$base/code-formatter/");
if ($en_tool_page && strpos($en_tool_page, "/de/code-formatierer/") !== false) {
    ok("EN→DE: /code-formatter/ → /de/code-formatierer/");
    $passed++;
} else {
    fail("Language switcher EN→DE missing");
    $failed++;
}

// Check special pages in sidebar
if ($de_homepage) {
    $special_pages = ['about.php', 'imprint.php', 'privacy.php'];
    foreach ($special_pages as $page) {
        if (strpos($de_homepage, "/$page") !== false) {
            ok("Special page: $page found");
            $passed++;
        } else {
            fail("Special page: $page missing");
            $failed++;
        }
    }
}

// Check mobile OffCanvas navigation
if ($de_homepage && strpos($de_homepage, 'id="mobileSidebar"') !== false) {
    ok("Mobile OffCanvas present");
    $passed++;
    
    if (strpos($de_homepage, '/de/code-formatierer/') !== false) {
        ok("Mobile nav uses localized URLs");
        $passed++;
    } else {
        fail("Mobile nav not using localized URLs");
        $failed++;
    }
} else {
    fail("Mobile OffCanvas missing");
    $failed += 2;
}

echo "\n";

// ============================================================
// CRAWLER-BASED NAVIGATION VALIDATION
// ============================================================

section("Cross-Language Navigation Crawler");
echo "Running browser-like link crawler...\n\n";

// Include crawler functions
require_once __DIR__ . '/crawler-functions.php';

$crawlerStats = [
    'pages_visited' => [],
    'broken_links' => [],
    'redirect_loops' => [],
    'sidebar_links' => 0,
    'language_links' => 0,
];

// Start crawling from a few key pages
$startUrls = [
    "$base/de/code-formatierer/",
    "$base/es/generador-contrasenas/",
    "$base/fr/generateur-mots-de-passe/",
];

foreach ($startUrls as $startUrl) {
    crawlPage($startUrl, 0, 1, [], $crawlerStats, $base);
}

$crawlerPassed = count($crawlerStats['pages_visited']);
$crawlerFailed = count($crawlerStats['broken_links']) + count($crawlerStats['redirect_loops']);

echo "Pages visited: " . $crawlerPassed . "\n";
echo "Sidebar links tested: " . $crawlerStats['sidebar_links'] . "\n";
echo "Language switcher links tested: " . $crawlerStats['language_links'] . "\n";
echo "Broken links: " . $crawlerFailed . "\n";

if ($crawlerFailed > 0) {
    echo "\n⚠ Broken Links Found:\n";
    foreach ($crawlerStats['broken_links'] as $broken) {
        echo "  ✗ $broken\n";
        fail("Broken link: $broken");
    }
    foreach ($crawlerStats['redirect_loops'] as $loop) {
        echo "  ✗ Redirect loop: $loop\n";
        fail("Redirect loop: $loop");
    }
    $failed += $crawlerFailed;
} else {
    ok("All navigation links working (" . $crawlerPassed . " pages)");
    $passed++;
}

echo "\n";

section("Summary");
$total = $passed + $failed;
echo "Total checks: " . $total . "\n";
echo "  ✓ Passed:   " . $passed . " (" . round(($passed / $total) * 100, 1) . "%)\n";
if ($failed > 0) {
    echo "  ✗ Failed:   " . $failed . " (" . round(($failed / $total) * 100, 1) . "%)\n";
}
echo "\nReport saved: tests/reports/run-summary.json\n";
echo "\n";

exit($failed > 0 ? 1 : 0);
