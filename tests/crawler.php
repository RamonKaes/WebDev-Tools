#!/usr/bin/env php
<?php
/**
 * WebDev-Tools Link Crawler
 * 
 * Simulates a real browser that loads pages and follows navigation links.
 * Tests cross-language navigation, sidebar links, language switcher, and special pages.
 */

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

// Get base URL
$base = $argv[1] ?? getenv('BASE_URL') ?? 'http://localhost/WebDev-Tools';
$base = rtrim($base, '/');

// Colors for terminal output
function color($text, $code) {
    return "\033[{$code}m{$text}\033[0m";
}

function ok($msg) { echo "  " . color("✓", "32") . " $msg\n"; }
function fail($msg) { echo "  " . color("✗", "31") . " $msg\n"; }
function info($msg) { echo "  " . color("ℹ", "36") . " $msg\n"; }
function section($title) { 
    echo "\n" . color("→ $title", "1;34") . "\n";
    echo str_repeat("-", 60) . "\n";
}

// Statistics
$stats = [
    'total_requests' => 0,
    'successful' => 0,
    'failed' => 0,
    'pages_visited' => [],
    'broken_links' => [],
    'sidebar_links' => 0,
    'footer_links' => 0,
    'offcanvas_links' => 0,
    'language_switches' => 0,
    'menu_links_tested' => 0
];

/**
 * Fetch a page and return its content
 */
function fetchPage($url) {
    global $stats;
    $stats['total_requests']++;
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'WebDev-Tools-Crawler/1.0'
        ]
    ]);
    
    $content = @file_get_contents($url, false, $context);
    
    if ($content === false) {
        $stats['failed']++;
        return false;
    }
    
    $stats['successful']++;
    return $content;
}

/**
 * Normalize a URL relative to the current page and base URL
 */
function normalizeUrl($href, $currentUrl) {
    global $base;
    
    // Trim whitespace
    $href = trim($href);
    
    // Skip empty, external links, anchors, and javascript
    if (empty($href) || preg_match('/^(https?:\/\/|mailto:|tel:|#|javascript:)/i', $href)) {
        return null;
    }
    
    // Parse the base URL
    $baseParsed = parse_url($base);
    $baseHost = $baseParsed['scheme'] . '://' . $baseParsed['host'];
    $basePath = $baseParsed['path'] ?? '';
    
    // Absolute URL starting with /
    if (strpos($href, '/') === 0) {
        // If href already contains the base path, use as-is
        if (strpos($href, $basePath) === 0) {
            return $baseHost . $href;
        }
        // Otherwise prepend base path
        return $baseHost . $basePath . $href;
    }
    
    // Relative URL - build from current directory
    $currentPath = parse_url($currentUrl, PHP_URL_PATH);
    $currentDir = dirname($currentPath);
    $fullPath = $currentDir . '/' . $href;
    
    // Normalize path (resolve .. and .)
    $parts = array_filter(explode('/', $fullPath), 'strlen');
    $absolutes = [];
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    
    $normalized = $baseHost . '/' . implode('/', $absolutes);
    
    // Ensure it's valid and not just the homepage
    return !empty($normalized) && $normalized !== $base . '/' && $normalized !== $baseHost . '/' ? $normalized : null;
}

/**
 * Extract all navigation links from HTML content (like a browser would)
 */
function extractNavigationLinks($html, $currentUrl) {
    global $stats;
    $links = [];
    
    // Extract sidebar navigation links (desktop-sidebar)
    if (preg_match('/<aside[^>]*id=["\']desktop-sidebar["\'][^>]*>(.*?)<\/aside>/s', $html, $match)) {
        // Find all tool links with data-tool attribute
        preg_match_all('/<a[^>]*href=["\']([^"\']+)["\'][^>]*data-tool=["\']([^"\']+)["\'][^>]*>/s', $match[1], $matches);
        foreach ($matches[1] as $idx => $href) {
            $normalized = normalizeUrl($href, $currentUrl);
            if ($normalized) {
                $toolName = $matches[2][$idx];
                $links[] = [
                    'url' => $normalized,
                    'text' => ucfirst($toolName),
                    'type' => 'sidebar'
                ];
                $stats['sidebar_links']++;
            }
        }
    }
    
    // Extract offcanvas navigation links (mobile) - use mobile-nav-link class
    if (preg_match('/<div[^>]*id=["\']mobileSidebar["\'][^>]*>(.*?)<\/div>/s', $html, $match)) {
        // Find all tool links with data-tool attribute in mobile navigation
        preg_match_all('/<a[^>]*href=["\']([^"\']+)["\'][^>]*data-tool=["\']([^"\']+)["\'][^>]*mobile-nav-link[^>]*>/s', $match[1], $matches);
        foreach ($matches[1] as $idx => $href) {
            $normalized = normalizeUrl($href, $currentUrl);
            if ($normalized) {
                $toolName = $matches[2][$idx];
                $links[] = [
                    'url' => $normalized,
                    'text' => ucfirst($toolName) . ' (Mobile)',
                    'type' => 'offcanvas'
                ];
                $stats['offcanvas_links']++;
            }
        }
    }
    
    // Extract language switcher links (dropdown with data-lang attribute)
    preg_match_all('/<a[^>]*href=["\']([^"\']+)["\'][^>]*data-lang=["\']([^"\']+)["\'][^>]*>/s', $html, $matches);
    foreach ($matches[1] as $idx => $href) {
        $normalized = normalizeUrl($href, $currentUrl);
        if ($normalized) {
            $lang = strtoupper($matches[2][$idx]);
            $links[] = [
                'url' => $normalized,
                'text' => "Language: {$lang}",
                'type' => 'language-switcher'
            ];
            $stats['language_switches']++;
        }
    }
    
    // Extract footer links (about, imprint, privacy)
    if (preg_match('/<footer[^>]*>(.*?)<\/footer>/s', $html, $match)) {
        preg_match_all('/<a[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/s', $match[1], $matches);
        foreach ($matches[1] as $idx => $href) {
            if (preg_match('/\/(about|imprint|privacy)\.php/', $href)) {
                $normalized = normalizeUrl($href, $currentUrl);
                if ($normalized) {
                    $links[] = [
                        'url' => $normalized,
                        'text' => trim(strip_tags($matches[2][$idx])),
                        'type' => 'footer'
                    ];
                    $stats['footer_links']++;
                }
            }
        }
    }
    
    // Remove duplicates by URL
    $unique = [];
    foreach ($links as $link) {
        $unique[$link['url']] = $link;
    }
    
    return array_values($unique);
}

/**
 * Crawl a page and follow its links (like a browser would)
 */
function crawlPage($url, $depth = 0, $maxDepth = 2, $visitedUrls = []) {
    global $base, $stats;
    
    // Skip if already visited
    if (isset($visitedUrls[$url])) {
        return $visitedUrls;
    }
    
    // Mark as visited
    $visitedUrls[$url] = true;
    $stats['pages_visited'][] = $url;
    
    // Show what we're crawling
    $indent = str_repeat("  ", $depth);
    $shortUrl = str_replace($base, '', $url) ?: '/';
    echo "{$indent}🌐 Loading: {$shortUrl}\n";
    
    // Fetch the page
    $html = fetchPage($url);
    if ($html === false) {
        fail("{$indent}Failed to load");
        $stats['broken_links'][] = $url;
        return $visitedUrls;
    }
    
    ok("{$indent}Page loaded (200 OK)");
    
    // Extract navigation links (simulating browser parsing DOM)
    $links = extractNavigationLinks($html, $url);
    
    if (!empty($links)) {
        info("{$indent}Found " . count($links) . " navigation links");
    }
    
    // Stop if we've reached max depth
    if ($depth >= $maxDepth) {
        return $visitedUrls;
    }
    
    // Follow each link (like clicking in a browser)
    foreach ($links as $link) {
        $stats['menu_links_tested']++;
        
        $linkShort = str_replace($base, '', $link['url']) ?: '/';
        echo "{$indent}  → Following [{$link['type']}]: {$link['text']}\n";
        
        // Recursively crawl the linked page
        $visitedUrls = crawlPage($link['url'], $depth + 1, $maxDepth, $visitedUrls);
    }
    
    return $visitedUrls;
}

/**
 * Main crawler execution
 */
section("WebDev-Tools Browser-Like Link Crawler");
echo "Base URL: {$base}\n";
echo "Strategy: Simulate real browser behavior - load page, parse links, follow them\n";
echo "Max Depth: 2 levels per starting point\n";

$visitedUrls = [];

// Start crawling from a tool page (not homepage, since homepage uses JS)
// This better simulates a user navigating through the site
$startPages = [
    ['url' => $base . '/uuid-generator/', 'lang' => 'English (UUID Tool)'],
    ['url' => $base . '/de/uuid-generator/', 'lang' => 'German (UUID Tool)'],
    ['url' => $base . '/base64-encoder-decoder/', 'lang' => 'English (Base64 Tool)'],
    ['url' => $base . '/de/base64-kodierer-dekodierer/', 'lang' => 'German (Base64 Tool)'],
    ['url' => $base . '/es/generador-contrasenas/', 'lang' => 'Spanish (Password Tool)'],
    ['url' => $base . '/pt/conversor-dados/', 'lang' => 'Portuguese (Data Converter)'],
];

foreach ($startPages as $page) {
    section("Crawling {$page['lang']}");
    $visitedUrls = crawlPage($page['url'], 0, 2, $visitedUrls);
}

// Statistics
section("Crawl Statistics");
echo "Total HTTP Requests:      " . $stats['total_requests'] . "\n";
echo "Successful Responses:     " . color($stats['successful'], "32") . "\n";
echo "Failed Responses:         " . color($stats['failed'], ($stats['failed'] > 0 ? "31" : "32")) . "\n";
echo "Unique Pages Visited:     " . count($stats['pages_visited']) . "\n";
echo "\n";
echo "Links Followed by Type:\n";
echo "  Sidebar Links:          " . $stats['sidebar_links'] . "\n";
echo "  OffCanvas Links:        " . $stats['offcanvas_links'] . "\n";
echo "  Language Switcher:      " . $stats['language_switches'] . "\n";
echo "  Footer Links:           " . $stats['footer_links'] . "\n";
echo "  Total Links Tested:     " . $stats['menu_links_tested'] . "\n";

if (!empty($stats['broken_links'])) {
    section("Broken Links Found");
    foreach ($stats['broken_links'] as $url) {
        $shortUrl = str_replace($base, '', $url) ?: '/';
        fail($shortUrl);
    }
    echo "\n";
} else {
    echo "\n";
    ok("All links working! ✨");
}

echo "\n";

// Exit with appropriate code
exit($stats['failed'] > 0 ? 1 : 0);
