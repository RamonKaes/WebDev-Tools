<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'aspectRatioCalculator';
$lang = 'en';

$customAboutContent = <<<HTML
<p class="mb-2">
    Calculate missing dimensions, maintain aspect ratios, and generate CSS for responsive media. 
    Essential for responsive images, videos, and layouts.
</p>
<p class="mb-0">
    Aspect ratio describes the proportional relationship between width and height. This tool helps 
    you calculate dimensions, convert between ratio formats, and generate CSS code for maintaining 
    aspect ratios in responsive designs.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Calculate missing width or height from aspect ratio</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Common ratio presets (16:9, 4:3, 21:9, 1:1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>CSS padding-bottom trick generator</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multiple ratio formats (ratio, decimal, percentage)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Responsive image size calculator</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time calculation</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% client-side processing</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Common Aspect Ratios</h3>
    <ul class="mb-0">
        <li><strong>16:9</strong> — Standard HD video, YouTube, modern displays</li>
        <li><strong>4:3</strong> — Classic TV, older monitors</li>
        <li><strong>21:9</strong> — Ultrawide monitors, cinematic</li>
        <li><strong>1:1</strong> — Square (Instagram posts)</li>
        <li><strong>9:16</strong> — Vertical video (Instagram Stories, TikTok)</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li><strong>Responsive Images:</strong> Maintain aspect ratio while scaling images</li>
    <li><strong>Video Embeds:</strong> Calculate iframe dimensions for YouTube, Vimeo</li>
    <li><strong>CSS Aspect Ratio:</strong> Generate padding-bottom trick for older browsers</li>
    <li><strong>Image Resizing:</strong> Calculate crop or resize dimensions</li>
    <li><strong>Layout Design:</strong> Plan responsive grid layouts</li>
</ul>
HTML
    ],
    [
        'title' => 'CSS Aspect Ratio Techniques',
        'content' => <<<HTML
<p><strong>Modern approach (CSS aspect-ratio):</strong></p>
<pre><code>.container {
  aspect-ratio: 16 / 9;
  width: 100%;
}</code></pre>

<p><strong>Legacy approach (padding-bottom trick):</strong></p>
<pre><code>.container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 = 9/16 = 56.25% */
}

.container > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}</code></pre>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/aspect-ratio',
        'title' => 'MDN: CSS aspect-ratio Property',
        'description' => 'Modern CSS property for maintaining aspect ratios'
    ],
    [
        'url' => 'https://css-tricks.com/aspect-ratio-boxes/',
        'title' => 'CSS-Tricks: Aspect Ratio Boxes',
        'description' => 'Complete guide to creating aspect ratio boxes in CSS'
    ],
    [
        'url' => 'https://www.w3.org/TR/css-sizing-4/#aspect-ratio',
        'title' => 'W3C CSS Box Sizing Module',
        'description' => 'Official specification for CSS aspect-ratio'
    ],
    [
        'url' => 'https://web.dev/aspect-ratio/',
        'title' => 'New Aspect-Ratio CSS Property',
        'description' => 'Google web.dev guide to modern aspect ratio handling'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
