<?php
// Simple PHP CLI checks for WebDev-Tools hosting environments (no Node required)
// Usage: php tests/run.php

$results = [];
function ok($msg){ global $results; $results[] = ['ok'=>true,'msg'=>$msg]; echo "[OK] $msg\n"; }
function fail($msg){ global $results; $results[] = ['ok'=>false,'msg'=>$msg]; echo "[FAIL] $msg\n"; }

echo "WebDev-Tools Server Checks\n";
// Optional runtime base URL to validate runtime headers and responses
$baseUrl = getenv('BASE_URL') ?: ($argv[1] ?? null);
if ($baseUrl) {
  // Normalize: ensure a scheme is present
  if (!preg_match('#^https?://#i', $baseUrl)) {
    $baseUrl = 'https://' . $baseUrl;
  }
  echo "Using BASE_URL: $baseUrl\n";
}
// Implementation using minimal test registry
$registryPath = __DIR__ . '/test-registry.json';
$enabledTests = [];
if (file_exists($registryPath)) {
  $registryJson = file_get_contents($registryPath);
  $registry = json_decode($registryJson, true);
  if (json_last_error() === JSON_ERROR_NONE && is_array($registry)) {
    foreach ($registry as $item) {
      if (!empty($item['enabled'])) { $enabledTests[] = $item['id']; }
    }
  }
}

function checkEnabled($id) { global $enabledTests; return in_array($id, $enabledTests, true); }

function test_php_version() { $v = phpversion(); if (version_compare($v, '7.4.0', '>=')) ok("PHP version $v"); else fail("PHP version $v — 7.4+ recommended"); }
function test_manifest_parse() { $p='config/manifest.json'; if (file_exists($p)) { $j=file_get_contents($p); $a=json_decode($j,true); if (json_last_error()===JSON_ERROR_NONE) ok('manifest.json parsed successfully'); else fail('manifest.json JSON error: ' . json_last_error_msg()); } else { fail('Missing: config/manifest.json'); } }
function test_i18n_en() { $p='config/i18n/en.json'; if (file_exists($p)) { $j=file_get_contents($p); $a=json_decode($j,true); if (json_last_error()===JSON_ERROR_NONE) ok('i18n/en.json parsed'); else fail('i18n/en.json parse error'); } else { fail('Missing: config/i18n/en.json'); } }
function test_security_headers_config() { $p='config/security-headers.php'; if (file_exists($p)) { $t=file_get_contents($p); if (strpos($t,'Content-Security-Policy')!==false) ok('security-headers.php includes CSP'); else fail('security-headers.php missing CSP'); if (strpos($t,'Strict-Transport-Security')!==false) ok('security-headers.php contains HSTS (Conditional)'); else fail('security-headers.php HSTS not found'); } else { fail('security-headers.php missing'); } }
function test_crypto_random() { if (function_exists('random_bytes')) { try {$r1=random_bytes(16); $r2=random_bytes(16); if ($r1 && $r2 && $r1 !== $r2) ok('random_bytes produces unique values'); else fail('random_bytes returned repeated values'); } catch(Exception $e) { fail('random_bytes threw exception: ' . $e->getMessage()); } } else { fail('random_bytes not available'); } if (function_exists('openssl_random_pseudo_bytes')) { $o1=openssl_random_pseudo_bytes(16); $o2=openssl_random_pseudo_bytes(16); if ($o1 && $o2 && $o1 !== $o2) ok('openssl_random_pseudo_bytes produces unique values'); else fail('openssl_random_pseudo_bytes repeated values'); } else { fail('openssl_random_pseudo_bytes not available (optional)'); } }
function test_sha256() { $k = hash('sha256','hello'); if ($k==='2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824') ok('hash(sha256) produces expected value'); else fail('hash(sha256) did not produce expected value'); }
function test_uuid_v4() { if (function_exists('random_bytes')) { $b=random_bytes(16); $b[6]=chr((ord($b[6]) & 0x0f) | 0x40); $b[8]=chr((ord($b[8]) & 0x3f) | 0x80); $uuid = vsprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x', array_map('ord', str_split($b))); if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid)) ok('Generated UUIDv4 format OK: ' . $uuid); else fail('Generated UUIDv4 did not match RFC format: ' . $uuid); } else { fail('Cannot generate UUIDv4: random_bytes missing'); } }
function test_assets() { $assets=['assets/js/lib/clipboard-utils.js']; foreach($assets as $a){ if (file_exists($a)) ok("Asset found: $a"); else fail("Asset missing: $a"); } }

// Execute enabled tests (order decided deliberately — core + security primitives)
if (checkEnabled('php_version')) test_php_version();
if (checkEnabled('manifest_parse')) test_manifest_parse();
if (checkEnabled('i18n_en')) test_i18n_en();
if (checkEnabled('security_headers')) test_security_headers_config();
if (checkEnabled('crypto_random')) test_crypto_random();
if (checkEnabled('sha256')) test_sha256();
if (checkEnabled('uuid_v4')) test_uuid_v4();
if (checkEnabled('assets')) test_assets();

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