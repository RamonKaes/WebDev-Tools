<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'it';
$customAboutContent = <<<HTML
<p class="mb-2">
    Genera testo segnaposto (Lorem Ipsum) per mockup, prototipi e layout.
    Personalizza paragrafi, frasi o parole in base alle tue esigenze.
</p>
<p class="mb-0">
    Lorem Ipsum è il testo fittizio standard usato da designer e sviluppatori fin dal XVI secolo.
    Questo strumento ti aiuta a generare la quantità ideale di testo per concentrarti sul design senza preoccuparti del contenuto.
HTML;
$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Genera paragrafi, frasi o parole</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quantità personalizzabile (1-100 unità)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Opzione per iniziare con "Lorem ipsum dolor sit amet..."</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Output con tag HTML di paragrafo</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Output in testo semplice</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia negli appunti con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Contatore di caratteri e parole in tempo reale</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Informazioni su Lorem Ipsum</h2>
    <p class="mb-2">
        Il testo Lorem Ipsum deriva dalle sezioni 1.10.32 e 1.10.33 del "de Finibus Bonorum et Malorum",
        opera di Cicerone scritta nel 45 a.C. È lo standard del settore fin dal XVI secolo.
    </p>
    <p class="mb-0">
        <strong>Perché usare Lorem Ipsum?</strong> Ha una distribuzione naturale di lettere che simula testo reale,
        permettendo di visualizzare il layout senza la distrazione di contenuti definitivi.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'content' => <<<HTML
<ul>
    <li>Mockup web: riempire layout con testo realistico</li>
    <li>Design editoriale: prevedere il flusso del testo in brochure e riviste</li>
    <li>Prototipazione UI/UX: testare interfacce con contenuto fittizio</li>
    <li>Test tipografici: valutare font e spaziatura</li>
    <li>CMS: popolare template durante lo sviluppo</li>
    <li>Presentazioni: mostrare concept prima dei contenuti finali</li>
</ul>
HTML
    ],
    [
        'title' => 'Consigli per l\'uso',
        'content' => <<<HTML
<ul>
    <li>Simula la realtà: usa volumi simili al contenuto finale</li>
    <li>Ricorda di sostituire: rimpiazza il Lorem Ipsum prima della pubblicazione</li>
    <li>Testa gli estremi: verifica con testi molto lunghi o corti</li>
    <li>Pensa alla leggibilità: dimostra buona tipografia anche con testo fittizio</li>
    <li>Usa tag HTML: includi &lt;p&gt; se necessiti formattazione</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipedia',
        'description' => 'Storia e origine del testo Lorem Ipsum'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - generatore originale',
        'description' => 'Risorsa storica per generare e comprendere Lorem Ipsum'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2010/01/lorem-ipsum-killing-designs/',
        'title' => 'Smashing Magazine: Lorem Ipsum danneggia i tuoi design',
        'description' => 'Perché il testo segnaposto può danneggiare il processo di progettazione e l\'esperienza utente'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
