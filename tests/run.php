<?php
// Simple PHP CLI checks for WebDev-Tools hosting environments (no Node required)
// Usage: php tests/run.php

$results = [];
function ok($msg){ global $results; $results[] = ['ok'=>true,'msg'=>$msg]; echo "[OK] $msg\n"; }
function fail($msg){ global $results; $results[] = ['ok'=>false,'msg'=>$msg]; echo "[FAIL] $msg\n"; }

echo "WebDev-Tools Server Checks\n";
// 1. PHP version
$phpVersion = phpversion();
if (version_compare($phpVersion, '7.4.0', '>=')){
  ok("PHP version $phpVersion");
} else {
  fail("PHP version $phpVersion — 7.4+ recommended");
}

// 2. Check that essential config file exists
$files = [
  'config/config.php',
  'config/manifest.json',
  'config/i18n/en.json'
];
foreach ($files as $f){
  if (file_exists($f)){
    ok("Found: $f");
  } else {
    fail("Missing: $f");
  }
}

// 3. Check that public assets exist (a couple of representative files)
$assets = [ 'assets/js/lib/clipboard-utils.js', 'assets/css/main.css' ];
foreach ($assets as $a){
  if (file_exists($a)) ok("Asset found: $a"); else fail("Asset missing: $a");
}

// 4. Try to parse JSON manifest if present
$manifestPath = 'config/manifest.json';
if (file_exists($manifestPath)){
  $json = file_get_contents($manifestPath);
  $parsed = json_decode($json, true);
  if (json_last_error() === JSON_ERROR_NONE) ok('manifest.json parsed successfully'); else fail('manifest.json JSON error: ' . json_last_error_msg());
}

// Summary
$fails = array_filter($results, function($r){ return !$r['ok']; });
if (count($fails) === 0) {
  echo "\nSummary: All checks OK.\n";
  exit(0);
} else {
  echo "\nSummary: " . count($fails) . " failures.\n";
  exit(2);
}
?>