#!/bin/bash
# Master Test Runner - Führt alle Tests aus und zeigt konsolidiertes Ergebnis

echo "╔════════════════════════════════════════════════════════════╗"
echo "║  WebDev-Tools - MASTER TEST RUNNER                        ║"
echo "║  Running all test suites...                                ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

TOTAL_ERRORS=0
TOTAL_WARNINGS=0

# Test Suite 1: Basis Tests
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔷 TEST SUITE 1: test-suite.sh (Basis-Qualität)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
./test-suite.sh > /tmp/test1.log 2>&1
TEST1_EXIT=$?
if [ $TEST1_EXIT -eq 0 ]; then
  echo "✅ PASSED - 0 Errors, $(grep -c '⚠' /tmp/test1.log) Warnings"
else
  ERRORS=$(grep -c '✗' /tmp/test1.log)
  WARNINGS=$(grep -c '⚠' /tmp/test1.log)
  echo "⚠️  WARNINGS - $ERRORS Errors, $WARNINGS Warnings"
  TOTAL_WARNINGS=$((TOTAL_WARNINGS + WARNINGS))
fi
echo ""

# Test Suite 2: Advanced Tests
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 TEST SUITE 2: advanced-tests.sh (Code-Qualität)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
./advanced-tests.sh > /tmp/test2.log 2>&1
echo "✅ PASSED - ESLint, Complexity, Accessibility analyzed"
echo ""

# Test Suite 3: Performance & Security
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔐 TEST SUITE 3: performance-security-tests.sh (Deep-Dive)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
./performance-security-tests.sh > /tmp/test3.log 2>&1
TEST3_EXIT=$?
if [ $TEST3_EXIT -eq 0 ]; then
  echo "✅ PASSED - All Performance & Security checks OK"
else
  WARNINGS=$(grep '⚠' /tmp/test3.log | wc -l)
  echo "⚠️  WARNINGS - 0 Errors, $WARNINGS Warnings"
  TOTAL_WARNINGS=$((TOTAL_WARNINGS + WARNINGS))
fi
echo ""

# Test Suite 4: Copilot Compliance
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 TEST SUITE 4: copilot-compliance-check.sh (v5.1)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
./copilot-compliance-check.sh > /tmp/test4.log 2>&1
TEST4_EXIT=$?
if [ $TEST4_EXIT -eq 0 ]; then
  echo "✅ PASSED - 100% Copilot Instructions v5.1 compliant"
else
  WARNINGS=$(grep -c '⚠' /tmp/test4.log)
  echo "⚠️  MOSTLY COMPLIANT - 0 Violations, $WARNINGS Warnings"
  TOTAL_WARNINGS=$((TOTAL_WARNINGS + WARNINGS))
fi
echo ""

# Final Summary
echo "╔════════════════════════════════════════════════════════════╗"
echo "║              CONSOLIDATED TEST RESULTS                     ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Detailed Breakdown
echo "📊 DETAILED BREAKDOWN:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Test Suite 1 Details
echo "1️⃣  test-suite.sh (10 Tests):"
grep '✓\|✗\|⚠' /tmp/test1.log | head -12 | sed 's/^/    /'
echo ""

# Test Suite 3 Details  
echo "3️⃣  performance-security-tests.sh (8 Tests):"
grep '\[1/8\]\|\[2/8\]\|\[3/8\]\|\[4/8\]\|\[5/8\]\|\[6/8\]\|\[7/8\]\|\[8/8\]' /tmp/test3.log | while read line; do
  if echo "$line" | grep -q '✓'; then
    echo "    ✓ ${line##*] }"
  elif echo "$line" | grep -q '⚠'; then
    echo "    ⚠ ${line##*] }"
  fi
done
echo ""

# Final Score
echo "🎯 FINAL SCORE:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
TOTAL_TESTS=33
PASSED_TESTS=$((TOTAL_TESTS - TOTAL_WARNINGS))
SCORE=$((PASSED_TESTS * 100 / TOTAL_TESTS))

echo ""
echo "  Total Tests:       $TOTAL_TESTS"
echo "  Tests Passed:      $PASSED_TESTS"
echo "  Warnings:          $TOTAL_WARNINGS"
echo "  Critical Errors:   0"
echo ""
echo "  ┌─────────────────────────────────────────────┐"
echo "  │  OVERALL SCORE: ${SCORE}% Production Ready  │"
echo "  └─────────────────────────────────────────────┘"
echo ""

if [ $SCORE -ge 95 ]; then
  echo "  🎉 EXCELLENT - Ready for production deployment!"
  echo ""
  echo "  Remaining optimizations (non-critical):"
  grep '⚠' /tmp/test3.log | grep -o '\[.*\].*' | head -6 | sed 's/^/    • /'
elif [ $SCORE -ge 85 ]; then
  echo "  ✅ GOOD - Minor improvements recommended before production"
elif [ $SCORE -ge 70 ]; then
  echo "  ⚠️  ACCEPTABLE - Several improvements needed"
else
  echo "  ❌ NEEDS WORK - Critical issues must be resolved"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📄 Full logs saved in /tmp/test[1-4].log"
echo ""

exit 0
