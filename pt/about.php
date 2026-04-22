<?php

/**
 * About Page (Portuguese)
 *
 * Provides information about the WebDev-Tools project, its origin story,
 * development process with AI assistance, and the motivation behind making
 * it publicly available.
 *
 * PHP version 7.4+
 *
 * @category  InformationPage
 * @package   WebDevTools
 * @license   MIT License
 */

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'pt';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/pt';
$homeUrl = BASE_PATH . '/pt';
$pageTitle = 'Sobre WebDev-Tools – Utilitários gratuitos para desenvolvedores';
$pageDescription = 'Conheça WebDev-Tools, uma coleção de utilitários gratuitos e que respeitam a privacidade para desenvolvedores, criada com paixão por Ramon Kaes.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="pt" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="theme-color" content="#066fd1">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/webdev-tools.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="pt_PT">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="fr_FR">
  <meta property="og:locale:alternate" content="it_IT">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/webdev-tools.png">
  <meta name="twitter:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/about.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php foreach ($langUrls as $hreflang => $url): ?>
    <link rel="alternate" hreflang="<?= $hreflang ?>" href="<?= htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php endforeach; ?>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">
  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>

<body class="d-flex flex-column bg-body">
  <?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>
  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>
    <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
      <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Sobre WebDev Tools</h1>
          <p class="lead text-secondary">
            A 10.000.ª coleção de ferramentas – um relato de um acidente
          </p>
          
          <!-- Distintivos de Conformidade com Padrões -->
          <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 4648 Base64
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 8259 JSON
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 4122/9562 UUID
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>RFC 7519 JWT
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>ISO/IEC 18004 QR
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>NIST SP 800-63B
            </span>
            <span class="badge bg-success px-3 py-2">
              <i class="bi bi-shield-check me-1"></i>WCAG A11y
            </span>
            <span class="badge bg-primary px-3 py-2">
              <i class="bi bi-lock-fill me-1"></i>Apenas do lado do cliente
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Sim, eu sei. A 10.000.ª coleção de ferramentas na Internet. Quem é que
              precisa disso? Mas posso tranquilizá-los: este projeto nunca foi
              planeado. É um acidente, um produto da pura procrastinação, mas também
              uma lição sobre como lidar com a inteligência artificial.
            </p>
            <p>
              Tudo começou de forma bastante inofensiva no meu ambiente de trabalho.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              No início era o script.
            </h2>
            <p>
              Tal como muitos programadores, eu também tinha várias ferramentas
              caseiras guardadas no meu localhost. Pequenos scripts para os
              aborrecimentos do dia-a-dia: uma conversão de Em/Px aqui, um pequeno
              ajudante ali. Coisas para as quais eu tinha preguiça de procurar sempre os
              mesmos sites. É que eu estou em guerra total com os favoritos.
            </p>
            <p class="mb-5">
              Esses ajudantes cumpriam bem o seu papel. Mas depois acrescentei mais dois
              e o meu instinto de programador web atacou impiedosamente: comecei a
              ligar as coisas. Era preciso um menu. Um pouco de estilo. E, de repente,
              estava no meio de tudo aquilo que nos ocorre quando se quer distrair-se
              com sucesso do trabalho propriamente dito. Da simples coleção, tornou-se
              um projeto em grande escala. Tive de o «enfeitar» até ter diante de mim
              um verdadeiro site com tudo o que é necessário.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              «IA, toma conta!» – terá sido uma ideia maluca?
            </h2>
            <p>
              A certa altura, ocorreu-me: afinal, são apenas scripts simples. Deixa que
              seja a IA a tratar disso! Como utilizador fiel do
              <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor de código gratuito">VS Code</a>,
              criei o projeto diretamente com o
              <a href="https://www.anthropic.com/claude-code" target="_blank" rel="noopener noreferrer" title="Claude Code da Anthropic">Claude Code (Sonnet)</a>.
            </p>
            <p>
              Mas antes de dar carta branca à IA, era preciso estabelecer limites
              claros. Assim, em primeiro lugar, defini uma pilha de tecnologias fixa. A
              partir daí, criei um <code>CLAUDE.md</code> (estritamente limitado a um máximo de 60
              linhas – comandos curtos são essenciais para as IAs) e um
              <code>.claude/comments/review.md</code>. Igualmente essenciais para a própria carteira
              são um ficheiro <code>.claudeignore</code> consistente e um ficheiro
              <code>.claude/settings.local.json</code> especificamente adaptado, para poupar tokens
              em grande quantidade durante a codificação.
            </p>
            <p class="mb-5">
              O resultado foi surpreendente: uma aplicação web incrivelmente boa e
              modularmente expansível. Mas, claro, nem tudo correu na perfeição. É
              preciso impedir constantemente uma IA de exagerar. O meu comando mais
              importante tornou-se rapidamente: «Não, não precisamos de um gestor de
              pacotes! E agora pára de me sugerir outra vez um framework!» No final,
              porém, saiu realmente uma estrutura básica utilizável.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              As armadilhas do «Vibe Coding»
            </h2>
            <p>
              O projeto ganhou impulso e aprendi rapidamente algumas lições difíceis
              sobre a colaboração com os meus colegas digitais.
            </p>
            <ul class="mb-5">
              <li>
                A questão do framework: as IAs adoram o
                <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utilitário">Tailwind</a>.
                Após alguns ajustes manuais, durante os quais a minha paciência ficou
                perigosamente a esgotar-se, ela acabou por se esgotar de vez. Mudei
                então para o
                <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>,
                para concluir o projeto de forma pragmática. Às vezes, «pronto» é
                simplesmente melhor do que «perfeito» (ou Tailwind).
              </li><br>
              <li>
                Sem Git? Sem mim! Por hábito, criei logo um repositório. Ainda bem!
                Percebi rapidamente que este «Vibe Coding» desorganizado, sem controlo
                de versões, acabava por ser uma enorme perda de tempo.
              </li><br>
              <li>
                Lógica da IA vs. realidade: as IAs, por vezes, tornam a vida demasiado
                fácil – ou demasiado complicada. É verdade que o Claude melhorou imenso
                neste aspeto e, entretanto, analisa o código de forma significativamente
                mais fundamentada, em vez de especular cegamente. No entanto, se não se
                especificar com precisão o rumo a seguir, as IAs continuam a tender para
                soluções de script arbitrárias que acabam num beco sem saída. Sem um
                corajoso «git reset --hard», provavelmente teria mesmo assim de
                reiniciar o projeto do zero mais do que uma vez.
              </li><br>
              <li>
                Ping-pong de IA na revisão de código: Na garantia de qualidade, apostei
                num sistema de «checks and balances». Através do comando /review,
                aciono a verificação interna do Claude, que funciona estritamente de
                acordo com as especificações no meu review.md. Em complemento, solicitei
                revisões externas ao ChatGPT e ao Gemini e, por fim, discuti os
                resultados com o Claude Opus. Esta «revisão de IA para a revisão de IA»
                é, de facto, bastante meta, mas extremamente útil para contrastar
                diferentes formas de pensar e colmatar lacunas lógicas.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Ronda bónus: IA como tradutor?
            </h2>
            <p>
              Depois de a funcionalidade estar pronta, chegou a vez das traduções.
              Aqui, a IA mostrou o seu lado filosófico: o
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Segurança e pesquisa em IA">Claude Sonnet 4.5</a>
              chamou-me a atenção, sem que eu lhe tivesse pedido, para o facto de que,
              em línguas como o hindi, o chinês ou o japonês, não se trata apenas de
              vocabulário, mas também de peculiaridades culturais e formas de cortesia.
              Foi um nível refrescante de autorreflexão.
            </p>
            <p class="mb-5">
              Na prática, porém, a abordagem acabou por ser pragmática: para a
              tradução em lote do conteúdo estático, o Claude era demasiado
              «intelectual» e complicado para mim. No caso do Gemini e do ChatGPT, a
              qualidade da execução variava demasiado. No final, traduzi tudo com o
              <a href="https://www.deepl.com/pt-BR/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Serviço de tradução por IA">DeepL</a>.
              Também aqui se aplica: a ferramenta certa para o trabalho certo!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Da intranet para a web
            </h2>
            <p>
              Depois de a coleção de ferramentas ter ficado pronta e de já suportar
              vários idiomas, prestou bons serviços durante bastante tempo na nossa
              rede da empresa. A certa altura, pensei: por que não partilhar?
            </p>
            <p>
              Então, organizei tudo e tornei o site público. E como tudo isto surgiu de
              um «acidente», o código está totalmente aberto. Quem quiser dar uma ajuda
              ou encontrar um erro: o repositório Git encontra-se aqui:
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositório GitHub do WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sim, desculpem. Então, aqui está ela, a 10.000.ª coleção de ferramentas.
              A 10.000.ª coleção de ferramentas. Mas, afinal, tem uma boa história por
              trás!
            </p>
            <p>Divirtam-se com ela!</p>
            <p>Ramon</p>
            <div class="text-center">
              <img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Serviço de tradução online gratuito" class="text-decoration-none text-muted">Traduzido com deepl.com (versão gratuita)</a>
          </small>
        </div>

      </div>
    </main>
  </div>

  <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
<?php
// Output minified HTML
echo minify_html_output(ob_get_clean());
?>