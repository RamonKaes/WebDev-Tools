#!/usr/bin/env php
<?php
// Minimal CLI runner for server-side checks
// Use: php tests/run.php

function ok($msg){ echo "[OK] $msg\n"; }
function fail($msg){ echo "[FAIL] $msg\n"; }

echo "WebDev-Tools Server checks\n";

// PHP version
if (PHP_VERSION_ID < 70100) { fail('PHP version too old: ' . PHP_VERSION); exit(1); } else { ok('PHP version ' . PHP_VERSION); }

// JSON support
if (function_exists('json_encode')) { ok('JSON functions available'); } else { fail('Missing JSON functions'); }

// Optional: check config/config.php exists (do not expose contents)
$cfg = __DIR__ . '/../config/config.php';
if (file_exists($cfg)) { ok('Server config present (config.php)'); } else { fail('Server config (config.php) not found'); }

echo "Done.\n";

// Load checks list
$checks_file = __DIR__ . '/checks.json';
$checks = [];
if (file_exists($checks_file)) {
	$json = file_get_contents($checks_file);
	$checks = json_decode($json, true) ?: [];
}

// Base URL for server checks — use env BASE_URL or default to localhost path
$base = $argv[1] ?? getenv('BASE_URL') ?: 'http://localhost/WebDev-Tools';

$results = [];
foreach ($checks as $p) {
	if (substr($p,0,1) === '/') $url = rtrim($base, '/') . $p; else $url = rtrim($base, '/') . '/' . $p;
	$h = @get_headers($url);
	$ok = false;
	$status = 0;
	if ($h && is_array($h)) {
		// Example: HTTP/1.1 200 OK
		if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $h[0], $m)) {
			$status = (int)$m[1];
			$ok = ($status >= 200 && $status < 300);
		}
	}
	if ($ok) { ok("{$p} — {$status}"); } else { fail("{$p} — {$status}"); }
	$results[] = ['check' => $p, 'ok' => $ok, 'status' => $status];
}

// Save summary
$out_dir = __DIR__ . '/reports';
if (!is_dir($out_dir)) mkdir($out_dir, 0755, true);
$summary = ['timestamp' => date(DATE_ATOM), 'results' => $results];
file_put_contents($out_dir . '/run-summary.json', json_encode($summary, JSON_PRETTY_PRINT));

echo "Server checks finished — summary written to tests/reports/run-summary.json\n";
