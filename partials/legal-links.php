<?php

declare(strict_types=1);

/**
 * Feedback buttons + legal links
 *
 * Rendered twice: in the desktop sidebar ($legalVariant = 'sidebar', stacked
 * 2×2 above/below the divider) and as a page footer below the content on
 * screens without the sidebar ($legalVariant = 'footer', one centred row).
 *
 * Expects the variables set up by header-with-sidebar.php: $toolBaseUrl,
 * $currentTool, $nav, $lang and the *TitleLabels arrays.
 */

$legalVariant = $legalVariant ?? 'sidebar';
$isFooter = $legalVariant === 'footer';

// Defaults for the rare case the partial is rendered without the header
$lang = $lang ?? 'en';
$currentTool = $currentTool ?? 'home';
$nav = $nav ?? [];
$toolBaseUrl = $toolBaseUrl ?? BASE_PATH . getLangPrefix($lang);
$aboutTitleLabels = $aboutTitleLabels ?? [];
$imprintTitleLabels = $imprintTitleLabels ?? [];
$privacyTitleLabels = $privacyTitleLabels ?? [];

$esc = static fn(string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$feedbackButtons = [
    [
        'url' => 'https://github.com/RamonKaes/WebDev-Tools/issues',
        'icon' => 'bug',
        'label' => $nav['report_bug'] ?? 'Report a bug',
        'title' => $nav['report_bug_title'] ?? 'Report a bug on GitHub',
    ],
    [
        'url' => 'https://easyq.info/projects/ramonkaes-webdev-tools',
        'icon' => 'question-circle',
        'label' => $nav['help'] ?? 'Help',
        'title' => $nav['help_title'] ?? 'Questions and ideas on easyQ',
    ],
];

$legalLinks = [
    ['key' => 'about', 'href' => $toolBaseUrl . '/about.php', 'icon' => 'info-circle',
     'label' => $nav['about'] ?? 'About', 'title' => $aboutTitleLabels[$lang] ?? 'About WebDev-Tools'],
    ['key' => null, 'href' => 'https://github.com/RamonKaes/WebDev-Tools', 'icon' => 'github',
     'label' => 'GitHub', 'title' => 'GitHub Repository'],
    ['key' => 'imprint', 'href' => $toolBaseUrl . '/imprint.php', 'icon' => 'file-text',
     'label' => $nav['imprint'] ?? 'Imprint', 'title' => $imprintTitleLabels[$lang] ?? 'Legal Information'],
    ['key' => 'privacy', 'href' => $toolBaseUrl . '/privacy.php', 'icon' => 'shield-check',
     'label' => $nav['privacy'] ?? 'Privacy', 'title' => $privacyTitleLabels[$lang] ?? 'Privacy Policy'],
];

$buttonClass = 'btn btn-sm btn-outline-secondary feedback-btn d-inline-flex align-items-center justify-content-center'
    . ($isFooter ? '' : ' flex-fill');
$linkClass = 'd-flex align-items-center justify-content-center text-secondary text-decoration-none rounded tool-link'
    . ($isFooter ? '' : ' flex-fill');
?>
<?php if ($isFooter) : ?>
<footer class="d-lg-none border-top bg-body-tertiary px-3 py-3 mt-auto" aria-label="<?= $esc($nav['footer_label'] ?? 'Feedback and legal') ?>">
  <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
<?php else : ?>
<div class="px-3 pb-3">
  <div class="d-flex gap-2">
<?php endif; ?>
<?php foreach ($feedbackButtons as $btn) : ?>
    <a href="<?= $esc($btn['url']) ?>" target="_blank" rel="noopener noreferrer"
       class="<?= $buttonClass ?>" title="<?= $esc($btn['title']) ?>">
      <i class="bi bi-<?= $btn['icon'] ?> me-1"></i><span><?= $esc($btn['label']) ?></span>
    </a>
<?php endforeach; ?>
  </div>
<?php if ($isFooter) : ?>
  <div class="d-flex flex-wrap justify-content-center gap-1">
<?php foreach ($legalLinks as $link) : ?>
    <a href="<?= $esc($link['href']) ?>"<?= $link['key'] === null ? ' target="_blank" rel="noopener noreferrer"' : '' ?>
       class="<?= $linkClass ?><?= $link['key'] !== null && $currentTool === $link['key'] ? ' active' : '' ?>"
       <?= $link['key'] !== null ? 'data-tool="' . $link['key'] . '"' : '' ?> title="<?= $esc($link['title']) ?>">
      <i class="bi bi-<?= $link['icon'] ?> me-1"></i><span><?= $esc($link['label']) ?></span>
    </a>
<?php endforeach; ?>
  </div>
</footer>
<?php else : ?>
</div>
<div class="p-3 border-top">
  <ul class="list-unstyled ps-0 mb-0">
<?php foreach (array_chunk($legalLinks, 2) as $i => $row) : ?>
    <li class="d-flex gap-2<?= $i === 0 ? ' mb-2' : '' ?>">
<?php foreach ($row as $link) : ?>
      <a href="<?= $esc($link['href']) ?>"<?= $link['key'] === null ? ' target="_blank" rel="noopener noreferrer"' : '' ?>
         class="<?= $linkClass ?><?= $link['key'] !== null && $currentTool === $link['key'] ? ' active' : '' ?>"
         <?= $link['key'] !== null ? 'data-tool="' . $link['key'] . '"' : '' ?> title="<?= $esc($link['title']) ?>">
        <i class="bi bi-<?= $link['icon'] ?> me-1"></i><span><?= $esc($link['label']) ?></span>
      </a>
<?php endforeach; ?>
    </li>
<?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>
