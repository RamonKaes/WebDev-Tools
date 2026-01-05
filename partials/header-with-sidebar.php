<?php

declare(strict_types=1);

/**
 * Reusable Header + Sidebar Template
 * Used across all tool pages for consistent navigation
 */

// English-only site configuration
if (!isset($currentTool)) {
    $currentTool = 'home';
}
if (!isset($lang)) {
    $lang = 'en';
}
// $baseUrl is loaded from config.php in the calling file

// Calculate asset path based on location: root pages use 'assets', tool pages in subfolders use '../assets'
// Use absolute asset URL derived from configured $baseUrl to avoid fragile relative paths
// $baseUrl comes from config.php in the caller. Normalize and escape it for safe output.
// BASE_PATH is already included in links, so just use it directly for assets
$assetUrl = htmlspecialchars(BASE_PATH . '/assets', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Load i18n translations (using cached function)
$i18nData = loadI18n($lang) ?: [];
$nav = $i18nData['navigation'] ?? [];
$categories = $nav['categories'] ?? [];

// Extract complete tool data from tools section (including linkTitle)
$toolTitles = $i18nData['tools'] ?? [];

// Language-specific URL prefix
$langPrefix = getLangPrefix($lang);

// Set default values only if not already defined (e.g., by dashboard pages)
if (!isset($toolBaseUrl)) {
    $toolBaseUrl = BASE_PATH . $langPrefix;
}
if (!isset($homeUrl)) {
    $homeUrl = BASE_PATH . $langPrefix;
}

// Navigation structure - generated from tools.php (Single Source of Truth)
$navigationStructure = getNavigationStructure($lang);

// Generate language switch URLs based on current tool
if ($currentTool !== 'home') {
  // Check if it's a special page (about, imprint, privacy)
    if (in_array($currentTool, ['about', 'imprint', 'privacy'])) {
        $currentToolUrl = '/' . $currentTool . '.php';
      // Special pages use same URL across languages
        $enUrl = BASE_PATH . $currentToolUrl;
        $deUrl = BASE_PATH . '/de' . $currentToolUrl;
        $esUrl = BASE_PATH . '/es' . $currentToolUrl;
        $ptUrl = BASE_PATH . '/pt' . $currentToolUrl;
        $frUrl = BASE_PATH . '/fr' . $currentToolUrl;
        $itUrl = BASE_PATH . '/it' . $currentToolUrl;
    } else {
      // Tools use localized slugs - get URLs for all languages
        $toolUrls = getAllToolLanguageUrls($currentTool);
        $enUrl = $toolUrls['en'];
        $deUrl = $toolUrls['de'];
        $esUrl = $toolUrls['es'];
        $ptUrl = $toolUrls['pt'];
        $frUrl = $toolUrls['fr'];
        $itUrl = $toolUrls['it'];
    }
} else {
  // Homepage URLs
    $enUrl = BASE_PATH . '/';
    $deUrl = BASE_PATH . '/de/';
    $esUrl = BASE_PATH . '/es/';
    $ptUrl = BASE_PATH . '/pt/';
    $frUrl = BASE_PATH . '/fr/';
    $itUrl = BASE_PATH . '/it/';
}

// Current language display
$langNames = ['en' => 'English', 'de' => 'Deutsch', 'es' => 'Español', 'pt' => 'Português', 'fr' => 'Français', 'it' => 'Italiano'];
$currentLangName = $langNames[$lang] ?? 'English';

// Skip to main content translations
$skipToMainLabels = [
  'en' => 'Skip to main content',
  'de' => 'Zum Hauptinhalt springen',
  'es' => 'Saltar al contenido principal',
  'pt' => 'Pular para o conteúdo principal',
  'fr' => 'Aller au contenu principal',
  'it' => 'Salta al contenuto principale'
];
$skipToMainLabel = $skipToMainLabels[$lang] ?? 'Skip to main content';

// Main navigation labels
$mainNavLabels = [
  'en' => 'Main navigation',
  'de' => 'Hauptnavigation',
  'es' => 'Navegación principal',
  'pt' => 'Navegação principal',
  'fr' => 'Navigation principale',
  'it' => 'Navigazione principale'
];
$mainNavLabel = $mainNavLabels[$lang] ?? 'Main navigation';

// Open menu labels
$openMenuLabels = [
  'en' => 'Open menu',
  'de' => 'Menü öffnen',
  'es' => 'Abrir menú',
  'pt' => 'Abrir menu',
  'fr' => 'Ouvrir le menu',
  'it' => 'Apri menu'
];
$openMenuLabel = $openMenuLabels[$lang] ?? 'Open menu';
?>

<!-- Skip to main content link for keyboard users -->
<a href="#main-content" class="visually-hidden-focusable"><?= $skipToMainLabel ?></a>

<!-- 1. MOBILE NAV BAR (xs/sm/md) -->
<nav class="navbar d-lg-none bg-body-tertiary border-bottom sticky-top shadow-sm">
  <div class="container-fluid">
    <a href="<?= $homeUrl ?>/" class="navbar-brand d-flex align-items-center mb-0">
      <img src="<?= $assetUrl ?>/img/logo.svg" alt="WebDev-Tools Logo"
        class="me-2">
      <span>WebDev-Tools</span>
    </a>
    <button class="navbar-toggler" type="button" 
      data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"
      aria-label="<?= $openMenuLabel ?>"
      aria-controls="mobileSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Main App Container -->
<div id="app" class="app-wrapper flex-row w-100">

  <!-- 2. DESKTOP SIDEBAR (lg+) -->
  <aside id="desktop-sidebar" class="d-none d-lg-flex flex-column flex-shrink-0 bg-body-tertiary border-end">
    <div class="px-3 py-4 border-bottom flex-shrink-0">
      <a href="<?= $homeUrl ?>/" class="navbar-brand d-flex align-items-center mb-0">
        <img src="<?= $assetUrl ?>/img/logo.svg" alt="WebDev-Tools" class="me-2">
        <span>WebDev-Tools</span>
      </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-grow-1 p-3" aria-label="<?= $mainNavLabel ?>">
      <ul class="list-unstyled ps-0">

        <!-- Home -->
        <li class="mb-1">
          <a href="<?= $homeUrl ?>/"
            class="btn-toggle d-inline-flex align-items-center rounded border-0 text-decoration-none <?php echo $currentTool === 'home' ? 'active' : ''; ?>"
            data-tool="home">
            <i class="bi bi-house-door me-2 keep-bi"></i><span><?php echo htmlspecialchars($nav['home'] ?? 'Home', ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
        </li>

        <!-- Encoders -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#encoders-collapse"
            aria-expanded="false" aria-controls="encoders-collapse" aria-label="<?= $lang === 'de' ? 'Encoder Kategorie' : 'Encoders category' ?>">
            <i class="bi bi-file-binary me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['encoders'] ?? 'Encoders', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="encoders-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['encoders'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Formatters -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#formatters-collapse"
            aria-expanded="false" aria-controls="formatters-collapse" aria-label="<?= $lang === 'de' ? 'Formatierer Kategorie' : 'Formatters category' ?>">
            <i class="bi bi-code-square me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['formatters'] ?? 'Formatters', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="formatters-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['formatters'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Converters -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#converter-collapse"
            aria-expanded="false" aria-controls="converter-collapse" aria-label="<?= $lang === 'de' ? 'Konverter Kategorie' : 'Converters category' ?>">
            <i class="bi bi-arrow-left-right me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['converters'] ?? 'Converters', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div
            class="collapse mt-1"
            id="converter-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['converters'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Generators -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#generator-collapse"
            aria-expanded="false" aria-controls="generator-collapse" aria-label="<?= $lang === 'de' ? 'Generatoren Kategorie' : 'Generators category' ?>">
            <i class="bi bi-stars me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['generators'] ?? 'Generators', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div
            class="collapse mt-1"
            id="generator-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['generators'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- References -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#references-collapse"
            aria-expanded="false" aria-controls="references-collapse" aria-label="<?= $lang === 'de' ? 'Referenzen Kategorie' : 'References category' ?>">
            <i class="bi bi-book me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['references'] ?? 'References', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div
            class="collapse mt-1"
            id="references-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['references'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- String Tools -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#stringtools-collapse"
            aria-expanded="false" aria-controls="stringtools-collapse" aria-label="<?= $lang === 'de' ? 'String-Tools Kategorie' : 'String Tools category' ?>">
            <i class="bi bi-code-slash me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['stringtools'] ?? 'String Tools', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div
            class="collapse mt-1"
            id="stringtools-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['stringtools'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Utilities -->
        <li class="mb-1">
          <button
            class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#utilities-collapse"
            aria-expanded="false" aria-controls="utilities-collapse" aria-label="<?= $lang === 'de' ? 'Hilfsmittel Kategorie' : 'Utilities category' ?>">
            <i class="bi bi-tools me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['utilities'] ?? 'Utilities', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div
            class="collapse mt-1"
            id="utilities-collapse">
            <ul class="btn-toggle-nav list-unstyled space-y-1">
              <?php foreach ($navigationStructure['utilities'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

      </ul>
    </nav>

    <!-- Legal Links (Desktop) -->
    <div class="p-3 border-top">
      <ul class="list-unstyled ps-0 mb-0">
        <li class="mb-2 d-flex gap-2">
          <a href="<?= $toolBaseUrl ?>/about.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link <?php echo $currentTool === 'about' ? 'active' : ''; ?>" data-tool="about">
            <i class="bi bi-info-circle me-1"></i><span><?php echo htmlspecialchars($nav['about'] ?? 'About', ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
          <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link" title="GitHub Repository">
            <i class="bi bi-github me-1"></i><span>GitHub</span>
          </a>
        </li>
        <li class="d-flex gap-2">
          <a href="<?= $toolBaseUrl ?>/imprint.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link <?php echo $currentTool === 'imprint' ? 'active' : ''; ?>" data-tool="imprint">
            <i class="bi bi-file-text me-1"></i><span><?php echo htmlspecialchars($nav['imprint'] ?? 'Imprint', ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
          <a href="<?= $toolBaseUrl ?>/privacy.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link <?php echo $currentTool === 'privacy' ? 'active' : ''; ?>" data-tool="privacy">
            <i class="bi bi-shield-check me-1"></i><span><?php echo htmlspecialchars($nav['privacy'] ?? 'Privacy', ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
        </li>
      </ul>
    </div>


  </aside>

  <!-- 4. OFF-CANVAS SIDEBAR (Mobile & Tablet) -->
  <div class="offcanvas offcanvas-start bg-body-tertiary" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header border-bottom py-3">
      <a href="<?= $homeUrl ?>/"
        class="navbar-brand offcanvas-title d-flex align-items-center mb-0" id="mobileSidebarLabel">
        <img src="<?= $assetUrl ?>/img/logo.svg" alt="WebDev-Tools" class="me-2">
        <span>WebDev-Tools</span>
      </a>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3 d-flex flex-column overflow-y-auto">
      <nav aria-label="<?= $mainNavLabel ?>">
      <ul class="list-unstyled ps-0 flex-grow-1">
        <!-- Home (Mobile) -->
        <li class="mb-1">
          <a href="<?= $homeUrl ?>/"
            class="btn-toggle d-inline-flex align-items-center rounded border-0 text-decoration-none mobile-nav-link <?php echo $currentTool === 'home' ? 'active' : ''; ?>"
            data-tool="home">
            <i class="bi bi-house-door me-2 keep-bi"></i><span><?php echo htmlspecialchars($nav['home'] ?? 'Home', ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
        </li>

        <!-- Encoders (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-encoders-collapse"
            aria-expanded="false" aria-controls="mobile-encoders-collapse" aria-label="<?= $lang === 'de' ? 'Encoder Kategorie' : 'Encoders category' ?>">
            <i class="bi bi-file-binary me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['encoders'] ?? 'Encoders', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-encoders-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['encoders'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Formatters (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-formatters-collapse"
            aria-expanded="false" aria-controls="mobile-formatters-collapse" aria-label="<?= $lang === 'de' ? 'Formatierer Kategorie' : 'Formatters category' ?>">
            <i class="bi bi-code-square me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['formatters'] ?? 'Formatters', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-formatters-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['formatters'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Converters (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-converter-collapse"
            aria-expanded="false" aria-controls="mobile-converter-collapse" aria-label="<?= $lang === 'de' ? 'Konverter Kategorie' : 'Converters category' ?>">
            <i class="bi bi-arrow-left-right me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['converters'] ?? 'Converters', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-converter-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['converters'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Generators (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-generator-collapse"
            aria-expanded="false" aria-controls="mobile-generator-collapse" aria-label="<?= $lang === 'de' ? 'Generatoren Kategorie' : 'Generators category' ?>">
            <i class="bi bi-stars me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['generators'] ?? 'Generators', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-generator-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['generators'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- References (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-references-collapse"
            aria-expanded="false" aria-controls="mobile-references-collapse" aria-label="<?= $lang === 'de' ? 'Referenzen Kategorie' : 'References category' ?>">
            <i class="bi bi-book me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['references'] ?? 'References', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-references-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['references'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- String Tools (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-stringtools-collapse"
            aria-expanded="false" aria-controls="mobile-stringtools-collapse" aria-label="<?= $lang === 'de' ? 'String-Tools Kategorie' : 'String Tools category' ?>">
            <i class="bi bi-code-slash me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['stringtools'] ?? 'String Tools', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-stringtools-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['stringtools'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <!-- Utilities (Mobile) -->
        <li class="mb-1">
          <button class="btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            data-bs-toggle="collapse" data-bs-target="#mobile-utilities-collapse"
            aria-expanded="false" aria-controls="mobile-utilities-collapse" aria-label="<?= $lang === 'de' ? 'Hilfsmittel Kategorie' : 'Utilities category' ?>">
            <i class="bi bi-tools me-2" aria-hidden="true"></i><span><?php echo htmlspecialchars($categories['utilities'] ?? 'Utilities', ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <div class="collapse mt-1" id="mobile-utilities-collapse">
            <ul class="btn-toggle-nav list-unstyled">
              <?php foreach ($navigationStructure['utilities'] as $tool) : ?>
              <li><a href="<?= $toolBaseUrl . $tool['url'] ?>"
                  class="text-secondary text-decoration-none rounded tool-link mobile-nav-link <?= $currentTool === $tool['key'] ? 'active' : '' ?>"
                  title="<?= htmlspecialchars($toolTitles[$tool['key']]['linkTitle']['nav'] ?? $toolTitles[$tool['key']]['toc_title'] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?>"
                  aria-label="<?= htmlspecialchars(($toolTitles[$tool['key']]['toc_title'] ?? $tool['key']) . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($toolTitles[$tool['key']]['toc_title'] ?? $toolTitles[$tool['key']] ?? $tool['key'], ENT_QUOTES, 'UTF-8') ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

      </ul>
      </nav>

      <!-- Legal Links (Mobile) -->
      <div class="p-3 border-top mt-auto">
        <ul class="list-unstyled ps-0 mb-0">
          <li class="mb-2 d-flex gap-2">
            <a href="<?= $toolBaseUrl ?>/about.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link mobile-nav-link <?php echo $currentTool === 'about' ? 'active' : ''; ?>" data-tool="about" aria-label="<?php echo htmlspecialchars(($nav['about'] ?? 'About') . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8'); ?>">
              <i class="bi bi-info-circle me-1"></i><span><?php echo htmlspecialchars($nav['about'] ?? 'About', ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
            <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link mobile-nav-link" title="GitHub Repository" aria-label="GitHub Repository - Mobile Navigation">
              <i class="bi bi-github me-1"></i><span>GitHub</span>
            </a>
          </li>
          <li class="d-flex gap-2">
            <a href="<?= $toolBaseUrl ?>/imprint.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link mobile-nav-link <?php echo $currentTool === 'imprint' ? 'active' : ''; ?>" data-tool="imprint" aria-label="<?php echo htmlspecialchars(($nav['imprint'] ?? 'Imprint') . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8'); ?>">
              <i class="bi bi-file-text me-1"></i><span><?php echo htmlspecialchars($nav['imprint'] ?? 'Imprint', ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
            <a href="<?= $toolBaseUrl ?>/privacy.php" class="flex-fill d-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link mobile-nav-link <?php echo $currentTool === 'privacy' ? 'active' : ''; ?>" data-tool="privacy" aria-label="<?php echo htmlspecialchars(($nav['privacy'] ?? 'Privacy') . ' - Mobile Navigation', ENT_QUOTES, 'UTF-8'); ?>">
              <i class="bi bi-shield-check me-1"></i><span><?php echo htmlspecialchars($nav['privacy'] ?? 'Privacy', ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
          </li>
        </ul>
      </div>


    </div>
  </div>

  <!-- SVG Icons (must be defined before buttons) -->
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="translate" viewBox="0 0 16 16">
      <path
        d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z" />
      <path
        d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z" />
    </symbol>
    <symbol id="check2" viewBox="0 0 16 16">
      <path
        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path
        d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path
        d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path
        d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

  <!-- Floating Theme Switcher Button (Bottom Right) -->
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button"
      aria-expanded="false" data-bs-toggle="dropdown" data-i18n-aria="common.toggle_theme" aria-label="<?= $lang === 'de' ? 'Design-Modus wählen' : 'Toggle theme' ?>">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em" aria-hidden="true">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text" data-i18n="common.toggle_theme"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
          aria-pressed="false" data-i18n="theme.light" data-i18n-aria="theme.light">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          <span data-i18n="theme.light">Light</span>
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
          aria-pressed="false" data-i18n="theme.dark" data-i18n-aria="theme.dark">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          <span data-i18n="theme.dark">Dark</span>
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
          aria-pressed="true" data-i18n="theme.auto" data-i18n-aria="theme.auto">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          <span data-i18n="theme.auto">Auto</span>
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>

  <!-- Floating Language Switcher Button (Bottom Right, above Theme Switcher) -->
  <div class="dropdown position-fixed end-0 me-3 bd-language-toggle">
    <button class="btn btn-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-language" type="button"
      aria-expanded="false" data-bs-toggle="dropdown" 
      aria-label="<?= $lang === 'de' ? 'Sprache ändern' : ($lang === 'es' ? 'Cambiar idioma' : ($lang === 'fr' ? 'Changer de langue' : ($lang === 'it' ? 'Cambia lingua' : ($lang === 'pt' ? 'Mudar idioma' : 'Change language')))) ?>">
      <svg class="bi my-1" width="1em" height="1em" aria-hidden="true">
        <use href="#translate"></use>
      </svg>
      <span class="visually-hidden"><?= $lang === 'de' ? 'Sprache ändern' : ($lang === 'es' ? 'Cambiar idioma' : ($lang === 'fr' ? 'Changer de langue' : ($lang === 'it' ? 'Cambia lingua' : ($lang === 'pt' ? 'Mudar idioma' : 'Change language')))) ?></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-language">
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'en' ? ' active' : '' ?>" href="<?= $enUrl ?>" data-lang="en">
          <span>English</span>
          <?php if ($lang === 'en') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'de' ? ' active' : '' ?>" href="<?= $deUrl ?>" data-lang="de">
          <span>Deutsch</span>
          <?php if ($lang === 'de') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'es' ? ' active' : '' ?>" href="<?= $esUrl ?>" data-lang="es">
          <span>Español</span>
          <?php if ($lang === 'es') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'pt' ? ' active' : '' ?>" href="<?= $ptUrl ?>" data-lang="pt">
          <span>Português</span>
          <?php if ($lang === 'pt') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'fr' ? ' active' : '' ?>" href="<?= $frUrl ?>" data-lang="fr">
          <span>Français</span>
          <?php if ($lang === 'fr') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center<?= $lang === 'it' ? ' active' : '' ?>" href="<?= $itUrl ?>" data-lang="it">
          <span>Italiano</span>
          <?php if ($lang === 'it') : ?>
          <svg class="bi ms-auto" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
          <?php endif; ?>
        </a>
      </li>
    </ul>
  </div>