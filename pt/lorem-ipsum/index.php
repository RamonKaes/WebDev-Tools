<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'pt';
$featuresSectionTitle = 'Recursos';
$resourcesSectionTitle = 'Recursos Úteis';
$customAboutContent = <<<HTML
<p class="mb-2">
    Gere texto de preenchimento (Lorem Ipsum) para maquetes, protótipos e layouts.
    Personalize parágrafos, frases ou palavras conforme a necessidade.
</p>
<p class="mb-0">
    Lorem Ipsum é o texto padrão usado por designers e desenvolvedores desde o século XVI.
    Esta ferramenta ajuda você a gerar a quantidade ideal de texto fictício para focar no design sem se preocupar com o conteúdo.
HTML;
$features = [
    'Gere parágrafos, frases ou palavras',
    'Quantidade ajustável (1-100 unidades)',
    'Opção para iniciar com "Lorem ipsum dolor sit amet..."',
    'Saída com tags HTML de parágrafo',
    'Saída em texto simples',
    'Cópia para a área de transferência com um clique',
    'Contador de caracteres e palavras em tempo real'
];
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Sobre o Lorem Ipsum</h2>
    <p class="mb-2">
        O texto Lorem Ipsum deriva das seções 1.10.32 e 1.10.33 de "de Finibus Bonorum et Malorum",
        obra de Cícero escrita em 45 a.C. Desde os anos 1500 é o padrão do setor.
    </p>
    <p class="mb-0">
        <strong>Por que usar Lorem Ipsum?</strong> Ele possui distribuição natural de letras, simulando um texto real.
        Assim é possível visualizar o layout sem a distração de conteúdo definitivo.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comuns',
        'content' => <<<HTML
<ul>
    <li>Mockups web: preencher layouts com texto realista</li>
    <li>Design editorial: prever o fluxo de texto em brochuras e revistas</li>
    <li>Prototipagem UI/UX: testar interfaces com conteúdo fictício</li>
    <li>Testes de tipografia: avaliar fontes e espaçamento</li>
    <li>CMS: popular templates durante o desenvolvimento</li>
    <li>Apresentações: mostrar conceitos antes do conteúdo final</li>
</ul>
HTML
    ],
    [
        'title' => 'Dicas de uso',
        'content' => <<<HTML
<ul>
    <li>Combine com o real: use volumes semelhantes ao conteúdo final</li>
    <li>Lembre-se de substituir: troque o Lorem Ipsum antes da publicação</li>
    <li>Teste extremos: verifique textos muito longos ou curtos</li>
    <li>Pense na leitura: demonstre boa tipografia, mesmo com texto fictício</li>
    <li>Use tags HTML: inclua &lt;p&gt; se precisar de formatação</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://en.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipedia',
        'description' => 'História e origem do texto Lorem Ipsum'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - gerador original',
        'description' => 'Recurso tradicional para gerar e entender Lorem Ipsum'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2010/01/lorem-ipsum-killing-designs/',
        'title' => 'Smashing Magazine: Lorem Ipsum prejudica seu design',
        'description' => 'Por que o texto de preenchimento pode prejudicar seu processo de design e a experiência do usuário'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
