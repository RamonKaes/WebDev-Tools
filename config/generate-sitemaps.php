<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$toolsConfig = require __DIR__ . '/tools.php';

$staticPages = [
  '/' => 'weekly',
  '/about.php' => 'monthly',
  '/imprint.php' => 'monthly',
  '/privacy.php' => 'monthly'
];

$defaultChangefreqTools = 'weekly';
$defaultLastmod = date('Y-m-d');
$langs = SUPPORTED_LANGS;

function decodeUrl(string $url): string
{
    return html_entity_decode($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function buildStaticEntries(array $staticPages, string $lang, string $lastmod): array
{
    $entries = [];
    foreach ($staticPages as $path => $changefreq) {
        $entries[] = [
        'loc' => decodeUrl(getFullUrl($path, $lang)),
        'lastmod' => $lastmod,
        'changefreq' => $changefreq
        ];
    }
    return $entries;
}

function buildToolEntries(array $toolsConfig, string $lang, string $lastmod, string $changefreq): array
{
    $entries = [];
    foreach ($toolsConfig as $toolId => $config) {
        $entries[] = [
        'loc' => decodeUrl(getToolUrl($toolId, $lang)),
        'lastmod' => $lastmod,
        'changefreq' => $changefreq
        ];
    }
    return $entries;
}

function writeSitemap(string $outputPath, array $entries): void
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $urlset = $dom->createElement('urlset');
    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    foreach ($entries as $entry) {
        $url = $dom->createElement('url');

        $loc = $dom->createElement('loc');
        $loc->appendChild($dom->createTextNode($entry['loc']));
        $url->appendChild($loc);

        if (!empty($entry['lastmod'])) {
            $lastmod = $dom->createElement('lastmod', $entry['lastmod']);
            $url->appendChild($lastmod);
        }

        if (!empty($entry['changefreq'])) {
            $changefreq = $dom->createElement('changefreq', $entry['changefreq']);
            $url->appendChild($changefreq);
        }

        $urlset->appendChild($url);
    }

    $dom->appendChild($urlset);

    if (!is_dir(dirname($outputPath))) {
        mkdir(dirname($outputPath), 0775, true);
    }

    file_put_contents($outputPath, $dom->saveXML());
}

function writeSitemapIndex(string $outputPath, array $sitemaps, string $lastmod): void
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $index = $dom->createElement('sitemapindex');
    $index->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    foreach ($sitemaps as $loc) {
        $sitemap = $dom->createElement('sitemap');
        $locElement = $dom->createElement('loc');
        $locElement->appendChild($dom->createTextNode($loc));
        $sitemap->appendChild($locElement);

        if (!empty($lastmod)) {
            $lastmodElement = $dom->createElement('lastmod', $lastmod);
            $sitemap->appendChild($lastmodElement);
        }

        $index->appendChild($sitemap);
    }

    $dom->appendChild($index);
    file_put_contents($outputPath, $dom->saveXML());
}

$siteBase = rtrim($baseUrl, '/') . BASE_PATH;
$outputDir = realpath(__DIR__ . '/..');
$sitemapLocations = [];

foreach ($langs as $lang) {
    $entries = array_merge(
        buildStaticEntries($staticPages, $lang, $defaultLastmod),
        buildToolEntries($toolsConfig, $lang, $defaultLastmod, $defaultChangefreqTools)
    );

    usort($entries, fn($a, $b) => strcmp($a['loc'], $b['loc']));

    if ($lang === 'en') {
        $relativePath = '/sitemap-en.xml';
    } else {
        $relativePath = '/' . $lang . '/sitemap.xml';
    }

    $outputPath = $outputDir . $relativePath;
    writeSitemap($outputPath, $entries);
    $sitemapLocations[] = $siteBase . $relativePath;
}

writeSitemapIndex($outputDir . '/sitemap.xml', $sitemapLocations, $defaultLastmod);

echo "Generated " . count($sitemapLocations) . " language sitemaps plus index.\n";
