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

// 5. Cryptographic primitives
if (function_exists('random_bytes')){
  try {
    $r1 = random_bytes(16);
    $r2 = random_bytes(16);
    if ($r1 && $r2 && $r1 !== $r2) ok('random_bytes produces unique values'); else fail('random_bytes returned repeated values');
  } catch (Exception $e) { fail('random_bytes threw exception: ' . $e->getMessage()); }
} else {
  fail('random_bytes not available');
}

if (function_exists('openssl_random_pseudo_bytes')){
  $o1 = openssl_random_pseudo_bytes(16);
  $o2 = openssl_random_pseudo_bytes(16);
  if ($o1 && $o2 && $o1 !== $o2) ok('openssl_random_pseudo_bytes produces unique values'); else fail('openssl_random_pseudo_bytes repeated values');
} else {
  fail('openssl_random_pseudo_bytes not available (optional)');
}

// 6. Validate security headers config file exists and contains common directives
$secHeaders = 'config/security-headers.php';
if (file_exists($secHeaders)){
  $txt = file_get_contents($secHeaders);
  if (strpos($txt, 'Content-Security-Policy') !== false) ok('security-headers.php includes CSP'); else fail('security-headers.php missing CSP directive');
  if (strpos($txt, 'Strict-Transport-Security') !== false) ok('security-headers.php contains HSTS (Conditional)'); else fail('security-headers.php HSTS not found');
} else {
  fail('security-headers.php missing');
}

// 7. Hashing check (SHA-256 known value)
$known = hash('sha256', 'hello');
if ($known === '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824'){
  ok('hash(sha256) produces expected value');
} else { fail('hash(sha256) did not produce expected value'); }

// 8. UUIDv4 generation & format check
function uuid_v4_from_bytes($b){
  $b[6] = chr((ord($b[6]) & 0x0f) | 0x40);
  $b[8] = chr((ord($b[8]) & 0x3f) | 0x80);
  return vsprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x', array_map('ord', str_split($b)));
}
if (function_exists('random_bytes')){
  $uuid = uuid_v4_from_bytes(random_bytes(16));
  if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid)) ok('Generated UUIDv4 format OK: ' . $uuid); else fail('Generated UUIDv4 did not match RFC format: ' . $uuid);
} else {
  fail('Cannot generate UUIDv4: random_bytes missing');
}

// 9. Collect and write JSON report
$reportsDir = __DIR__ . '/reports';
if (!is_dir($reportsDir)) { @mkdir($reportsDir, 0755, true); }
$reportData = ['timestamp'=>date(DATE_ATOM), 'results'=>$results];
file_put_contents($reportsDir . '/run-summary.json', json_encode($reportData, JSON_PRETTY_PRINT));
ok('Wrote JSON report: tests/reports/run-summary.json');

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