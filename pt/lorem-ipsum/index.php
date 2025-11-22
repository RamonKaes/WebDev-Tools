<?php

declare(strict_types=1);

$toolId = 'loremIpsumTool';
$lang = 'pt';
$customAboutContent = <<<HTML
<p class="mb-2">
    Gere texto de preenchimento (Lorem Ipsum) para maquetes, protótipos e layouts.
    Personalize parágrafos, frases ou palavras conforme a necessidade.
</p>
<p class="mb-0">
    Lorem Ipsum é o texto padrão usado por designers e desenvolvedores desde o século XVI.
    Esta ferramenta ajuda você a gerar a quantidade ideal de texto fictício para focar no design sem se preocupar com o conteúdo.
HTML;
$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Gere parágrafos, frases ou palavras</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quantidade ajustável (1-100 unidades)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Opção para iniciar com "Lorem ipsum dolor sit amet..."</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Saída com tags HTML de parágrafo</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Saída em texto simples</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cópia para a área de transferência com um clique</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Contador de caracteres e palavras em tempo real</li>
</ul>
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
        'url' => 'https://www.nngroup.com/articles/lorem-ipsum/',
        'title' => 'Nielsen Norman Group: Lorem Ipsum em UX',
        'description' => 'Pesquisa sobre o impacto do texto fictício na experiência do usuário'
    ],
    [
        'url' => 'https://alistapart.com/article/ux-content-first/',
        'title' => 'A List Apart: Content-First Design',
        'description' => 'Por que projetar com conteúdo real gera melhor UX'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
