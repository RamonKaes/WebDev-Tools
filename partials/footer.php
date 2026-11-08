<?php declare(strict_types=1); ?>
  </div>

  <!-- Feedback buttons + legal links below the page on screens without the sidebar -->
  <?php $legalVariant = 'footer'; include __DIR__ . '/legal-links.php'; ?>

  <script src="<?= $assetPrefix ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="<?= assetSrc('js/color-modes.js') ?>"></script>

  <script src="<?= assetSrc('js/mobile-navigation.js') ?>"></script>

  <?php
  // Pages that do not use head.php (start, about, imprint, privacy) get the same
  // preloaded translations and build hash, so i18n.js never falls back to an
  // unversioned localStorage cache or an unversioned fetch
  $footerLang = $lang ?? 'en';
  $footerI18nData = (isset($i18nData) && is_array($i18nData) && $i18nData) ? $i18nData : loadI18n($footerLang);
  $footerBuildHash = getManifest()['version'] ?? '1.0.0';
  ?>
  <script nonce="<?= getCspNonce() ?>">
    /* Global configuration for i18n.js (head.php sets the same on tool pages) */
    if (!window.__I18N__) {
      window.__BASE_PATH__ = '<?= BASE_PATH ?>';
      window.__I18N__ = {
        '<?= $footerLang ?>': <?= json_encode($footerI18nData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>
      };
      window.BUILD_HASH = '<?= htmlspecialchars($footerBuildHash, ENT_QUOTES, 'UTF-8') ?>';
    }
  </script>
  <script src="<?= assetSrc('js/i18n.js') ?>"></script>
