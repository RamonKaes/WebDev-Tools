<?php
/**
 * Shared crawler functions for navigation testing
 */

/**
 * Fetch a page and return its content
 */
function fetchPage($url) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'WebDev-Tools-Crawler/1.0',
            'follow_location' => 0, // Don't follow redirects automatically
            'max_redirects' => 0
        ]
    ]);
    
    $content = @file_get_contents($url, false, $context);
    
    // Check for redirect loops
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('/^HTTP\/\d\.\d\s+3\d\d/', $header)) {
                // This is a redirect - might be a loop
                return false;
            }
        }
    }
    
    return $content;
}

/**
 * Normalize a URL relative to the current page and base URL
 */
function normalizeUrl($href, $currentUrl, $base) {
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
        if ($basePath && strpos($href, $basePath) === 0) {
            return $baseHost . $href;
        }
        // Otherwise prepend base path
        return $baseHost . $basePath . $href;
    }
    
    // Relative URL - build from current directory
    $currentPath = parse_url($currentUrl, PHP_URL_PATH);
    $currentDir = dirname($currentPath);
    
    // Resolve relative path
    $fullPath = $currentDir . '/' . $href;
    
    // Clean up the path (resolve ../ and ./)
    $parts = explode('/', $fullPath);
    $resolved = [];
    foreach ($parts as $part) {
        if ($part === '' || $part === '.') continue;
        if ($part === '..') {
            array_pop($resolved);
        } else {
            $resolved[] = $part;
        }
    }
    
    return $baseHost . '/' . implode('/', $resolved);
}

/**
 * Extract navigation links from HTML
 */
function extractNavigationLinks($html, $currentUrl, $base) {
    global $stats;
    
    $links = [];
    $dom = new DOMDocument();
    @$dom->loadHTML($html, LIBXML_NOERROR);
    
    // Find sidebar navigation
    $xpath = new DOMXPath($dom);
    
    // Sidebar links
    $sidebarLinks = $xpath->query('//aside[@id="sidebar"]//a[@href]');
    foreach ($sidebarLinks as $link) {
        $href = $link->getAttribute('href');
        $normalized = normalizeUrl($href, $currentUrl, $base);
        if ($normalized) {
            $links[] = ['type' => 'sidebar', 'url' => $normalized];
            $stats['sidebar_links']++;
        }
    }
    
    // Language switcher links
    $langLinks = $xpath->query('//div[contains(@class, "language-switcher")]//a[@href]');
    foreach ($langLinks as $link) {
        $href = $link->getAttribute('href');
        $normalized = normalizeUrl($href, $currentUrl, $base);
        if ($normalized) {
            $links[] = ['type' => 'language', 'url' => $normalized];
            $stats['language_links']++;
        }
    }
    
    // Mobile offcanvas links
    $offcanvasLinks = $xpath->query('//div[@id="mobileSidebar"]//a[@href]');
    foreach ($offcanvasLinks as $link) {
        $href = $link->getAttribute('href');
        $normalized = normalizeUrl($href, $currentUrl, $base);
        if ($normalized) {
            $links[] = ['type' => 'offcanvas', 'url' => $normalized];
        }
    }
    
    return $links;
}

/**
 * Crawl a page recursively
 */
function crawlPage($url, $depth, $maxDepth, $visitedUrls, &$stats, $base) {
    // Check if already visited
    if (isset($visitedUrls[$url])) {
        return $visitedUrls;
    }
    
    // Mark as visited
    $visitedUrls[$url] = true;
    $stats['pages_visited'][] = $url;
    
    // Fetch the page
    $html = fetchPage($url);
    
    if ($html === false) {
        $stats['broken_links'][] = $url;
        return $visitedUrls;
    }
    
    // Extract links
    $links = extractNavigationLinks($html, $url, $base);
    
    // Don't recurse if max depth reached
    if ($depth >= $maxDepth) {
        return $visitedUrls;
    }
    
    // Follow links
    foreach ($links as $link) {
        $visitedUrls = crawlPage($link['url'], $depth + 1, $maxDepth, $visitedUrls, $stats, $base);
    }
    
    return $visitedUrls;
}
