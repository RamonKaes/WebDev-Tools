<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'en';
$customAboutContent = <<<HTML
<p class="mb-2">
    Generate placeholder text (Lorem Ipsum) for your design mockups, prototypes, and layouts. 
    Customize paragraphs, words, or characters to fit your specific needs.
</p>
<p class="mb-0">
    Lorem Ipsum is the industry standard dummy text used by designers and developers since the 1500s. 
    This tool helps you generate the perfect amount of placeholder text for your projects, 
    allowing you to focus on design without worrying about content.
HTML;
$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generate paragraphs, sentences, or words</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Customizable quantity (1-100 units)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Start with "Lorem ipsum dolor sit amet..."</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HTML paragraph tags option</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Plain text output</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copy to clipboard with one click</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time character and word count</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>About Lorem Ipsum</h3>
    <p class="mb-2">
        Lorem Ipsum is derived from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" 
        (The Extremes of Good and Evil) by Cicero, written in 45 BC. It has been the industry's 
        standard dummy text ever since the 1500s.
    </p>
    <p class="mb-0">
        <strong>Why use Lorem Ipsum?</strong> It has a more-or-less normal distribution of letters, 
        making it look like readable English, which helps visualize how actual content will appear 
        in your design without the distraction of meaningful text.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Common Use Cases',
        'content' => <<<HTML
<ul>
    <li>Web Design Mockups: Fill layouts with realistic-looking text</li>
    <li>Print Design: Preview how text will flow in brochures, magazines, etc.</li>
    <li>UI/UX Prototyping: Test interface designs with placeholder content</li>
    <li>Typography Testing: Evaluate font choices and spacing</li>
    <li>Content Management Systems: Populate templates during development</li>
    <li>Client Presentations: Show design concepts before final content is ready</li>
</ul>
HTML
    ],
    [
        'title' => 'Tips for Using Placeholder Text',
        'content' => <<<HTML
<ul>
    <li>Match content length: Use similar amounts of text as your final content will have</li>
    <li>Don't forget to replace: Always replace Lorem Ipsum with real content before launch</li>
    <li>Test edge cases: Try very long and very short text to ensure responsive design</li>
    <li>Consider readability: Even placeholder text should demonstrate good typography</li>
    <li>Use HTML tags: Include paragraph tags if you need formatted output</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipedia',
        'description' => 'History and origins of the Lorem Ipsum placeholder text'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - The Original Lorem Ipsum Generator',
        'description' => 'Long-standing resource for Lorem Ipsum text generation and information'
    ],
    [
        'url' => 'https://www.nngroup.com/articles/lorem-ipsum/',
        'title' => 'Nielsen Norman Group: Lorem Ipsum in UX',
        'description' => 'Research on the impact of placeholder text in user experience design'
    ],
    [
        'url' => 'https://alistapart.com/article/ux-content-first/',
        'title' => 'A List Apart: Content-First Design',
        'description' => 'Why designing with real content is crucial for better UX'
    ]
];

include __DIR__ . '/../partials/tool-base.php';
