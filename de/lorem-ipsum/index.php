<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'de';

$customAboutContent = <<<HTML
<p class="mb-2">
    Generieren Sie Lorem Ipsum Platzhaltertext für Ihre Design-Mockups, Prototypen 
    und Layouts. Anpassbare Absätze, Wörter und Zeichen.
</p>
<p class="mb-0">
    Lorem Ipsum ist der Standard-Platzhaltertext der Druck- und Satzindustrie seit den 1500er Jahren. 
    Dieses Tool hilft Ihnen, schnell realistisch aussehenden Text für Ihre Projekte zu generieren.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generieren Sie Absätze, Wörter oder Zeichen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anpassbare Menge (1-50 Absätze)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Beginnen Sie mit "Lorem ipsum dolor sit amet"</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>HTML-Absatz-Tags einschließen</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mit einem Klick in die Zwischenablage kopieren</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Zeichenanzahl und Statistiken</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% clientseitig - funktioniert offline</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Über Lorem Ipsum</h2>
    <p class="mb-2">
        Lorem Ipsum stammt aus den Abschnitten 1.10.32 und 1.10.33 von "de Finibus Bonorum et Malorum" 
        (Die Extreme von Gut und Böse) von Cicero, geschrieben 45 v. Chr. Es ist seit den 1500er Jahren 
        der Standard-Dummy-Text der Industrie.
    </p>
    <p class="mb-0">
        <strong>Warum Lorem Ipsum verwenden?</strong> Es hat eine mehr oder weniger normale Buchstabenverteilung, 
        wodurch es wie lesbares Englisch aussieht, was hilft zu visualisieren, wie echter Inhalt in Ihrem 
        Design erscheinen wird, ohne die Ablenkung durch bedeutungsvollen Text.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Häufige Anwendungsfälle',
        'content' => <<<HTML
<ul>
    <li>Webdesign-Mockups: Füllen Sie Layouts mit realistisch aussehendem Text</li>
    <li>Printdesign: Vorschau, wie Text in Broschüren, Magazinen usw. fließt</li>
    <li>UI/UX-Prototyping: Testen Sie Interface-Designs mit Platzhalterinhalt</li>
    <li>Typografie-Tests: Bewerten Sie Schriftartwahlen und Abstände</li>
    <li>Content-Management-Systeme: Füllen Sie Vorlagen während der Entwicklung</li>
    <li>Kundenpräsentationen: Zeigen Sie Designkonzepte, bevor der finale Inhalt bereit ist</li>
</ul>
HTML
    ],
    [
        'title' => 'Tipps zur Verwendung von Platzhaltertext',
        'content' => <<<HTML
<ul>
    <li>Inhaltslänge anpassen: Verwenden Sie ähnliche Textmengen wie Ihr finaler Inhalt haben wird</li>
    <li>Nicht vergessen zu ersetzen: Ersetzen Sie Lorem Ipsum immer durch echten Inhalt vor dem Launch</li>
    <li>Grenzfälle testen: Probieren Sie sehr langen und sehr kurzen Text aus, um responsives Design zu gewährleisten</li>
    <li>Lesbarkeit berücksichtigen: Selbst Platzhaltertext sollte gute Typografie demonstrieren</li>
    <li>HTML-Tags verwenden: Fügen Sie Absatz-Tags hinzu, wenn Sie formatierten Output benötigen</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://de.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipedia',
        'description' => 'Geschichte und Ursprung des Lorem-Ipsum-Platzhaltertextes'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - Der Original Lorem Ipsum Generator',
        'description' => 'Langjährige Ressource für Lorem-Ipsum-Textgenerierung und Informationen'
    ],
    [
        'url' => 'https://www.nngroup.com/articles/lorem-ipsum/',
        'title' => 'Nielsen Norman Group: Lorem Ipsum in UX',
        'description' => 'Forschung über den Einfluss von Platzhaltertext im User Experience Design'
    ],
    [
        'url' => 'https://alistapart.com/article/ux-content-first/',
        'title' => 'A List Apart: Content-First Design',
        'description' => 'Warum Design mit echten Inhalten für bessere UX entscheidend ist'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
