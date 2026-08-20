<?php

declare(strict_types=1);

$nonce = getCspNonce();

if (!isset($buildHash)) {
    $buildHash = '1.0.0';
}
?>

  <script nonce="<?= $nonce ?>">
    window.APP_BASE_PATH = '<?= BASE_PATH ?>';
    <?php $manifest = getManifest(); ?>
    window.MANIFEST_VERSION = '<?= htmlspecialchars($manifest['version'] ?? '', ENT_QUOTES, 'UTF-8') ?>';
  </script>

  <!-- DOMPurify: XSS sanitization library for safe innerHTML operations -->
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.9/dist/purify.min.js" 
          integrity="sha384-3HPB1XT51W3gGRxAmZ+qbZwRpRlFQL632y8x+adAqCr4Wp3TaWwCLSTAJJKbyWEK" 
          crossorigin="anonymous" 
          nonce="<?= $nonce ?>"></script>

  <script src="<?= assetSrc('js/tool-registry.js') ?>"></script>

  <script src="<?= assetSrc('js/lib/clipboard-utils.js') ?>"></script>

  <script src="<?= assetSrc('js/lib/a11y-utils.js') ?>"></script>

  <script src="<?= assetSrc('js/sidebar-persistence.js') ?>"></script>

  <script src="<?= assetSrc('js/sidebar-navigation.js') ?>"></script>

  <script src="<?= assetSrc('js/toc-generator.js') ?>"></script>

  <?php if (isset($currentTool)) : ?>
        <?php
        $toolConfig = getToolConfig($currentTool);
        if ($toolConfig && isset($toolConfig['externalLibraries'])) :
            foreach ($toolConfig['externalLibraries'] as $extLib) :
                if (is_array($extLib)) :
                    $url = htmlspecialchars($extLib['url'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    $integrity = isset($extLib['integrity']) ? ' integrity="' . htmlspecialchars($extLib['integrity'], ENT_QUOTES, 'UTF-8') . '"' : '';
                    $crossorigin = isset($extLib['crossorigin']) ? ' crossorigin="' . htmlspecialchars($extLib['crossorigin'], ENT_QUOTES, 'UTF-8') . '"' : '';
                    echo "<script src=\"{$url}\"{$integrity}{$crossorigin}></script>\n";
                else :
                    $url = htmlspecialchars($extLib, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    echo "<script src=\"{$url}\"></script>\n";
                endif;
            endforeach;
        endif;
        ?>
  <script nonce="<?= $nonce ?>">
    (function() {
      const container = document.querySelector('#tool-container');
      if (container) {
        container.dataset.toolId = '<?= $currentTool ?>';
        container.dataset.lang = '<?= $lang ?>';
      }
    })();
  </script>
  <script src="<?= assetSrc('js/tool-loader.js') ?>"></script>
  <?php endif; ?>
