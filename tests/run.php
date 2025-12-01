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
