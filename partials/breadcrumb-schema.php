<?php

declare(strict_types=1);

/**
 * Breadcrumb Schema.org JSON-LD
 * Generates breadcrumb structured data for better SEO
 */

if (!isset($currentTool) || $currentTool === 'home') {
    return; // No breadcrumbs on homepage
}

$breadcrumbItems = [
  [
    'name' => 'Home',
    'url' => $baseUrl . BASE_PATH . ($lang !== 'en' ? '/' . $lang : '') . '/'
  ],
  [
    'name' => htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'),
    'url' => $canonicalUrl
  ]
];

$breadcrumbSchema = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => []
];

foreach ($breadcrumbItems as $index => $item) {
    $breadcrumbSchema['itemListElement'][] = [
    '@type' => 'ListItem',
    'position' => $index + 1,
    'name' => $item['name'],
    'item' => $item['url']
    ];
}
?>

<script type="application/ld+json" nonce="<?= htmlspecialchars(getCspNonce(), ENT_QUOTES, 'UTF-8') ?>">
<?= json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
