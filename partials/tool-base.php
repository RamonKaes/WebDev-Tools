<?php

/**
 * Tool Base Template
 * Last updated: 2024-11-14 14:30:00
 * Cache buster to force reload
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/security-headers.php';
require_once __DIR__ . '/../config/helpers.php';

if (!isset($toolId)) {
    $errorCode = 500;
    $lang = 'en';
    require_once __DIR__ . '/error-template.php';
    exit;
}
if (!isset($lang)) {
    $lang = 'en';
}

$toolConfig = getToolConfig($toolId);
if (!$toolConfig) {
    $errorCode = 404;
    require_once __DIR__ . '/error-template.php';
    exit;
}

$i18nData = loadI18n($lang);
$toolData = $i18nData['tools'][$toolId] ?? [];
$seoData = $i18nData['seo'][$toolId] ?? [];
$t = $i18nData; // Make full i18n data available as $t for templates

// Set page metadata from SEO section
// meta_title → <title> tag (Meta-Title)
// meta_description → <meta description> tag
$pageTitle = $seoData['meta_title'] ?? 'WebDev-Tools';
$pageDescription = $seoData['meta_description'] ?? 'Free developer tools';
$keywords = $seoData['keywords'] ?? '';

$currentTool = $toolId;
$assetPrefix = BASE_PATH . '/';
$nonce = getCspNonce();

include __DIR__ . '/head.php';
?>

<body class="d-flex flex-column bg-body">

  <div id="top"></div>

  <?php include __DIR__ . '/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>
    
    <main class="flex-grow-1 p-4 p-md-5 bg-body" id="main-content">
    
    <?php
    // Use page_title for H1 heading (SEO-optimized), title is for navigation only
    $toolH1Title = $toolData['h1_title'] ?? $toolData['toc_title'] ?? '';
    $toolNavTitle = $toolData['toc_title'] ?? '';
    $toolDescription = $toolData['tool_description'] ?? $toolData['card_description'] ?? '';
    $toolIcon = $toolConfig['icon'] ?? 'tools';

    if ($toolH1Title) :
        ?>
    <div class="tool-container-inner mx-auto" id="tool-header">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3 mb-0 d-flex align-items-center" data-toc-title="<?= htmlspecialchars($toolNavTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
          <i class="bi <?= htmlspecialchars($toolIcon, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> me-2"></i><span><?= htmlspecialchars($toolH1Title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
        </h1>
      </div>
        <?php if ($toolDescription) : ?>
        <p class="text-muted mb-3"><?= htmlspecialchars($toolDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endif; ?>
      
        <?php
      // Standards Compliance Badges - show relevant standards for each tool
        $toolStandards = [
        'base64EncoderDecoder' => [
          ['label' => 'RFC 4648', 'tooltip' => 'Base64 Data Encoding Standard'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'uuidGeneratorTool' => [
          ['label' => 'RFC 4122', 'tooltip' => 'UUID Specification'],
          ['label' => 'RFC 9562', 'tooltip' => 'UUID v6/v7/v8'],
          ['label' => 'CSPRNG', 'tooltip' => 'Cryptographically Secure Random Number Generator'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'passwordGeneratorTool' => [
          ['label' => 'NIST SP 800-63B', 'tooltip' => 'Digital Identity Guidelines'],
          ['label' => 'CSPRNG', 'tooltip' => 'Cryptographically Secure Random Number Generator'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'jwtDecoderTool' => [
          ['label' => 'RFC 7519', 'tooltip' => 'JSON Web Token Standard'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'jsonFormatterValidator' => [
          ['label' => 'RFC 8259', 'tooltip' => 'JSON Data Interchange Format'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'hashGeneratorTool' => [
          ['label' => 'Web Crypto API', 'tooltip' => 'Browser Cryptography Standard'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'qrCodeGeneratorTool' => [
          ['label' => 'ISO/IEC 18004', 'tooltip' => 'QR Code Standard'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'pxToRemConverter' => [
          ['label' => 'WCAG A11y', 'tooltip' => 'Web Accessibility Guidelines']
        ],
        'urlEncoderDecoder' => [
          ['label' => 'RFC 3986', 'tooltip' => 'URI Generic Syntax'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'regexTesterTool' => [
          ['label' => 'ECMAScript', 'tooltip' => 'JavaScript Regex Engine'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'htmlEntityTool' => [
          ['label' => 'HTML5', 'tooltip' => 'HTML Entity Reference'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'punycodeConverterTool' => [
          ['label' => 'RFC 3492', 'tooltip' => 'Punycode: Internationalized Domain Names'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'dataConverterTool' => [
          ['label' => 'RFC 8259', 'tooltip' => 'JSON Standard'],
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'stringEscaperTool' => [
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'loremIpsumTool' => [
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'codeFormatterTool' => [
          ['label' => 'Client-Side Only', 'type' => 'security']
        ],
        'characterReferenceTool' => [
          ['label' => 'HTML5', 'tooltip' => 'HTML Character Entities'],
          ['label' => 'Unicode', 'tooltip' => 'Unicode Character Database']
        ],
        'emojiReferenceTool' => [
          ['label' => 'Unicode', 'tooltip' => 'Unicode Emoji Standard'],
          ['label' => 'HTML5', 'tooltip' => 'HTML Entity Support']
        ]
        ];

        if (isset($toolStandards[$toolId]) && !empty($toolStandards[$toolId])) :
            ?>
      <!-- Standards Badges -->
      <div class="d-flex flex-wrap gap-2 mb-3">
            <?php foreach ($toolStandards[$toolId] as $standard) :
                $badgeType = ($standard['type'] ?? 'standard') === 'security' ? 'primary' : 'success';
                $icon = ($standard['type'] ?? 'standard') === 'security' ? 'lock-fill' : 'shield-check';
                $tooltip = isset($standard['tooltip']) ? ' title="' . htmlspecialchars($standard['tooltip'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"' : '';
                ?>
        <span class="badge bg-<?= $badgeType ?> px-3 py-2"<?= $tooltip ?>>
          <i class="bi bi-<?= $icon ?> me-1 keep-bi"></i><?= htmlspecialchars($standard['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
        </span>
            <?php endforeach; ?>
      </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <div id="tool-container" class="tool-container-inner mx-auto"></div>

    <?php
    if ($toolConfig['hasFeaturesSection'] ?? false) :
        $featuresTitle = t($i18nData, "tools.{$toolId}.features_title", 'Features');
        $featuresContent = $customFeaturesContent ?? null;

        if (!$featuresContent) {
            $features = $seoData['featureList'] ?? [];
            if (!empty($features)) {
                $featuresContent = '<ul class="mb-0">';
                foreach ($features as $feature) {
                    $featuresContent .= '<li>' . htmlspecialchars($feature, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</li>';
                }
                $featuresContent .= '</ul>';
            }
        }

        if ($featuresContent) :
            ?>
    <div class="tool-container-inner mx-auto mt-3">
      <div class="card">
        <div class="card-body">
          <h2 class="h5 card-title mb-3">
            <i class="bi bi-list-check me-2"></i><?= $featuresTitle ?>
          </h2>
            <?= $featuresContent ?>
        </div>
      </div>
    </div>
            <?php
        endif;
    endif;
    ?>

    <?php
    if (isset($customNoticeContent) && $customNoticeContent) :
        $noticeType = $customNoticeType ?? 'info';
        ?>
    <div class="tool-container-inner mx-auto mt-3">
      <div class="alert alert-<?= htmlspecialchars($noticeType, ENT_QUOTES, 'UTF-8') ?>" role="alert">
        <?= $customNoticeContent ?>
      </div>
    </div>
    <?php endif; ?>

    <?php
    if (isset($additionalSections) && is_array($additionalSections)) :
        foreach ($additionalSections as $section) :
            if (is_array($section) && isset($section['title'], $section['content'])) :
                $icon = $section['icon'] ?? null;
                if (!$icon) {
                    $titleLower = strtolower($section['title']);
                    if (strpos($titleLower, 'use case') !== false || strpos($titleLower, 'anwendung') !== false) {
                        $icon = 'lightbulb';
                    } elseif (strpos($titleLower, 'security') !== false || strpos($titleLower, 'sicherheit') !== false) {
                        $icon = 'shield-check';
                    } elseif (strpos($titleLower, 'best practice') !== false) {
                        $icon = 'star';
                    } elseif (strpos($titleLower, 'strength') !== false || strpos($titleLower, 'stärke') !== false) {
                        $icon = 'speedometer';
                    } elseif (strpos($titleLower, 'mistake') !== false || strpos($titleLower, 'fehler') !== false) {
                        $icon = 'exclamation-triangle';
                    } elseif (strpos($titleLower, 'tips') !== false || strpos($titleLower, 'tipps') !== false) {
                        $icon = 'info-circle';
                    } elseif (strpos($titleLower, 'format') !== false || strpos($titleLower, 'explained') !== false || strpos($titleLower, 'erklärt') !== false) {
                        $icon = 'diagram-3';
                    } elseif (strpos($titleLower, 'conversion') !== false || strpos($titleLower, 'konvertierung') !== false) {
                        $icon = 'calculator';
                    } else {
                        $icon = 'lightbulb';
                    }
                }
                ?>
    <div class="tool-container-inner mx-auto mt-3">
      <div class="card">
        <div class="card-body">
          <h2 class="h5 card-title mb-3">
            <i class="bi bi-<?= htmlspecialchars($icon, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> me-2"></i><?= htmlspecialchars($section['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
          </h2>
                <?= $section['content'] ?>
        </div>
      </div>
    </div>
                <?php
            else :
                ?>
    <div class="tool-container-inner mx-auto mt-3">
                <?= $section ?>
    </div>
                <?php
            endif;
        endforeach;
    endif;
    ?>

    <?php
    if (isset($usefulResources) && is_array($usefulResources) && !empty($usefulResources)) :
        ?>
    
    <!-- Useful Resources Card -->
    <div class="tool-container-inner mx-auto mt-3">
      <div class="card">
        <div class="card-body">
          <h2 class="h5 card-title mb-3">
            <i class="bi bi-link-45deg me-2"></i><?= htmlspecialchars($t['common']['usefulResources'] ?? 'Useful Resources', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
          </h2>
          <div class="row">
            <?php foreach ($usefulResources as $resource) : ?>
            <div class="col-md-6 mb-3">
              <a href="<?= htmlspecialchars($resource['url'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" 
                 target="_blank" 
                 rel="noopener noreferrer"
                 class="text-decoration-none d-block">
                <i class="bi bi-box-arrow-up-right me-2"></i>
                <strong><?= htmlspecialchars($resource['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
              </a>
                <?php if (isset($resource['description'])) : ?>
              <small class="text-muted d-block ms-4"><?= htmlspecialchars($resource['description'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></small>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

    </main>

    <!-- Right margin spacer for fixed TOC sidebar -->
    <div class="toc-sidebar-spacer"></div>

  </div>

  <!-- On This Page Sidebar - Visible on screens >= 1480px -->
  <aside class="bg-body toc-sidebar-fixed p-3 pt-5">
    <div id="toc-sidebar" class="pt-3">
      <h6 class="text-muted text-uppercase fw-bold mb-3 toc-heading small">
        <?= $lang === 'de' ? 'Auf dieser Seite' : 'On this page' ?>
      </h6>
      <nav class="nav flex-column" id="toc-nav">
        <!-- Will be populated by JavaScript -->
      </nav>
    </div>
  </aside>

  <?php include __DIR__ . '/common-scripts.php'; ?>
  <?php include __DIR__ . '/footer.php'; ?>
