#!/usr/bin/env php
<?php
/**
 * Master Test Runner
 * Executes all test suites and reports results
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║        WebDev-Tools — Complete Test Suite                 ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";

$baseUrl = $argv[1] ?? getenv('BASE_URL') ?? 'http://localhost/WebDev-Tools';

$tests = [
    [
        'name' => 'Slug Validation',
        'command' => 'php tests/validate-slugs.php',
        'critical' => true
    ],
    [
        'name' => 'HTTP Endpoints & Navigation',
        'command' => "php tests/run.php $baseUrl",
        'critical' => true
    ],
    [
        'name' => 'Deep Link Crawler',
        'command' => "php tests/crawler.php $baseUrl",
        'critical' => false
    ]
];

$results = [];
$totalPassed = 0;
$totalFailed = 0;

foreach ($tests as $test) {
    echo "\n" . str_repeat('=', 60) . "\n";
    echo "Running: {$test['name']}\n";
    echo str_repeat('=', 60) . "\n";
    
    $output = [];
    $returnCode = 0;
    exec($test['command'] . ' 2>&1', $output, $returnCode);
    
    $passed = $returnCode === 0;
    $results[] = [
        'name' => $test['name'],
        'passed' => $passed,
        'critical' => $test['critical'],
        'output' => implode("\n", $output)
    ];
    
    // Print last 10 lines of output
    $lines = array_slice($output, -15);
    foreach ($lines as $line) {
        echo $line . "\n";
    }
    
    if ($passed) {
        echo "\n✓ {$test['name']} PASSED\n";
        $totalPassed++;
    } else {
        echo "\n✗ {$test['name']} FAILED\n";
        $totalFailed++;
        
        if ($test['critical']) {
            echo "\n⚠ Critical test failed! See full output above.\n";
        }
    }
}

// Final summary
echo "\n";
echo str_repeat('=', 60) . "\n";
echo "FINAL SUMMARY\n";
echo str_repeat('=', 60) . "\n";

foreach ($results as $result) {
    $status = $result['passed'] ? '✓' : '✗';
    $critical = $result['critical'] ? '[CRITICAL]' : '';
    echo sprintf("  %s %s %s\n", $status, $result['name'], $critical);
}

echo "\n";
echo "Total Test Suites: " . count($tests) . "\n";
echo "  ✓ Passed: $totalPassed\n";
echo "  ✗ Failed: $totalFailed\n";

if ($totalFailed > 0) {
    echo "\n⚠ Some tests failed. Review output above.\n\n";
    exit(1);
}

echo "\n✓ All test suites passed!\n\n";
exit(0);
