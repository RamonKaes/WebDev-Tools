<?php

declare(strict_types=1);

/**
 * Related Tools Block
 *
 * Links up to four other tools: same category first, then the rest of the
 * registry in its declared order, so the selection is stable across builds.
 *
 * Expects from tool-base.php: $toolId, $toolConfig, $lang, $i18nData
 */

$relatedToolsLimit = 4;
$allTools = getAllTools();
$relatedCategory = $toolConfig['category'] ?? '';
$sameCategoryIds = [];
$otherCategoryIds = [];

// Walk the registry starting right after the current tool and wrap around, so the
// fill-up from other categories differs per tool instead of always hitting the first entries
$registryIds = array_keys($allTools);
$currentIndex = (int) array_search($toolId, $registryIds, true);
$rotatedIds = array_merge(array_slice($registryIds, $currentIndex + 1), array_slice($registryIds, 0, $currentIndex));

foreach ($rotatedIds as $candidateId) {
    $candidateConfig = $allTools[$candidateId];
    if (($candidateConfig['category'] ?? '') === $relatedCategory) {
        $sameCategoryIds[] = $candidateId;
    } else {
        $otherCategoryIds[] = $candidateId;
    }
}

$relatedToolIds = array_slice(array_merge($sameCategoryIds, $otherCategoryIds), 0, $relatedToolsLimit);
$relatedHeading = $i18nData['common']['related_tools'] ?? 'Related tools';

if ($relatedToolIds) :
    ?>
    <section class="tool-container-inner mx-auto mt-3" aria-labelledby="related-tools">
      <div class="card">
        <div class="card-body">
          <h2 class="h6 fw-semibold card-title mb-3" id="related-tools">
            <i class="bi bi-grid me-2" aria-hidden="true"></i><?= htmlspecialchars($relatedHeading, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
          </h2>
          <ul class="row g-3 list-unstyled mb-0">
            <?php foreach ($relatedToolIds as $relatedId) :
                $relatedData = $i18nData['tools'][$relatedId] ?? [];
                $relatedName = $relatedData['toc_title'] ?? $relatedData['linkTitle']['nav'] ?? $relatedId;
                $relatedText = $relatedData['card_description'] ?? '';
                $relatedIcon = $allTools[$relatedId]['icon'] ?? 'bi-tools';
                ?>
            <li class="col-12 col-sm-6 col-xl-3">
              <a href="<?= getToolUrl($relatedId, $lang) ?>" class="card h-100 tool-card text-decoration-none">
                <span class="card-body d-flex flex-column">
                  <span class="fw-semibold mb-1">
                    <i class="bi <?= htmlspecialchars($relatedIcon, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> me-2" aria-hidden="true"></i><?= htmlspecialchars($relatedName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                  </span>
                    <?php if ($relatedText) : ?>
                  <span class="small text-secondary"><?= htmlspecialchars($relatedText, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                    <?php endif; ?>
                </span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </section>
    <?php
endif;
