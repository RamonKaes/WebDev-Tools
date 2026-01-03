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
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home.svg">
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
  <meta name="twitter:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/og/home.svg">
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
            Do script local para a (sim, a 10.000ª) coleção de ferramentas: Uma crônica do
            acaso
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
              Sim, eu sei. A 10.000ª coleção de ferramentas na Internet. Quem precisa disso?
              Mas posso tranquilizá-los: este projeto nunca foi planeado. É um acidente,
              um produto da procrastinação e uma lição sobre como lidar com a inteligência artificial.

            </p>
            <p>
              Tudo começou de forma inofensiva na minha área de trabalho.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              No início era o script.
            </h2>
            <p>
              Como muitos programadores, eu também tinha algumas ferramentas próprias guardadas no meu localhost.
              Pequenos scripts para aborrecimentos do dia a dia – uma conversão Em/Px
              aqui, uma pequena ajuda ali. Coisas para as quais eu era preguiçoso demais para procurar e abrir sempre os
              mesmos sites. Eu não gosto nada de marcadores
            </p>
            <p>
              Esses pequenos auxiliares cumpriam a sua função. Mas então adicionei mais dois.
              E então aconteceu: o meu instinto de programador web entrou em ação.
            </p>
            <p class="mb-5">
              Instintivamente, comecei a ligar as coisas entre si. Era preciso criar um menu.
              E um pouco de estilo. E tudo o que mais vem à cabeça
              quando se quer distrair com sucesso do trabalho propriamente dito. Assim,
              uma simples coleção de scripts transformou-se num projeto completo. Eu precisava
              apenas de «aprimorá-lo» até ter um pequeno site completo com tudo o que era necessário.

            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              «IA, assume o comando!» – Uma ideia maluca?
            </h2>
            <p>
              A certa altura, ocorreu-me: são apenas scripts simples. Porque não deixar
              a IA fazer isso? Como utilizador fiel do <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor de código gratuito">VS Code</a>, criei o projeto diretamente com o
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI da Anthropic">Claude Sonnet 4.5</a> (no <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - Programador de pares de IA">GitHub CoPilot</a>).
            </p>
            <p>
              Fiquei surpreendido, porque o resultado foi uma aplicação web modular
              expansível incrivelmente boa.
            </p>
            <p>
              Claro que não foi assim tão fácil. É preciso impedir constantemente a IA de
              exagerar. O meu comando mais importante rapidamente se tornou: «Não, não precisamos de nenhum
              gestor de pacotes! E agora pare de tentar sugerir-me mais um framework!»
            </p>
            <p class="mb-5">
              No final, acabou por surgir uma estrutura básica realmente útil.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              As armadilhas da «programação vibrante» com IA
            </h2>
            <p>
              O projeto ganhou velocidade e eu aprendi rapidamente algumas lições difíceis sobre
              a colaboração com os meus novos colegas digitais.
            </p>
            <p>
              A questão da estrutura: as IAs preferem trabalhar com <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utilitário">Tailwind</a>. Foi o que fizeram
              aqui também. Depois de alguns ajustes manuais, durante os quais a minha paciência foi
              esgotando-se, acabei por perder a cabeça. Mudei rapidamente para <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>,
              para concluir a coleção de forma rápida e pragmática. Por vezes,
              «pronto» é simplesmente melhor do que «perfeito» (ou «Tailwind»).
            </p>
            <p>
              2. Sem <a href="https://git-scm.com/" target="_blank" rel="noopener noreferrer" title="Git - Sistema de controle de versão distribuído">Git</a>? Sem mim! Por puro hábito, criei diretamente um <a href="https://git-scm.com/book/pt-br/v2/Git-Basics-Getting-a-Git-Repository" target="_blank" rel="noopener noreferrer" title="Repositório Git - Fundamentos do controle de versão">repositório Git</a>.
              Felizmente! Rapidamente percebi que o que estava a fazer – essa
              «programação intuitiva» sem plano com a IA – sem o Git levava a uma
              perda de tempo considerável.
            </p>
            <p>
              3. As armadilhas da lógica da IA: o maior problema é que as IAs gostam de facilitar a vida,
              mas da maneira errada.
            </p>
            <ul>
              <li>
                Elas especulam: em vez de analisar o que realmente se pretende, elas
                muitas vezes adivinham aleatoriamente. É preciso impedir rapidamente essa especulação e
                dar-lhes instruções precisas a cada passo, caso contrário, o resultado será o caos.
              <li>
                Elas adoram os seus próprios scripts. Tendem a propor os seus próprios scripts ou soluções,
                que muitas vezes levam a resultados desastrosos. Em muitos
                casos, isso teria exigido um reinício completo do projeto,
                se não fosse possível um corajoso «git reset --hard».
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. Ping-pong de IA nas revisões de código
              Também apostei nas IAs para a garantia de qualidade, mas de forma sistemática:
              primeiro, realizei as revisões de código com o <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modelo de IA avançado">GPT-5 Codex</a> e,
              em seguida, solicitei a opinião do <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI da Anthropic">Claude Sonnet 4.5</a> sobre o assunto. Uma revisão de IA para
              a revisão de IA, por assim dizer. Isso é bastante meta, mas extremamente útil para
              verificar diferentes «formas de pensar».
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Rodada bónus: IA como tradutor?
            </h2>
            <p>
              Depois de definir a funcionalidade, pensei em traduções. Primeiro, foi a vez do
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI da Anthropic">Claude Sonnet 4.5</a>. Segundo a própria declaração, a IA domina o inglês e o
              alemão ao nível de língua materna e oferece uma precisão de 98 % em espanhol, francês,
              italiano e português.
            </p>
            <p>
              Ficou interessante quando perguntei sobre hindi, chinês ou japonês. Aqui,
              a IA admitiu que precisa de ajuda externa, como o <a href="https://www.deepl.com/pt-BR/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Serviço de tradução por IA">DeepL</a>. Mais importante ainda,
              ela mesma salientou que não se trata apenas de uma tradução grosseira,
              mas que também é necessário ter em conta as peculiaridades culturais e
              as formas de cortesia.
            </p>
            <p class="mb-5">
              Um nível refrescante de autorreflexão. Para a tradução em lote propriamente dita
              da parte estática e codificada das línguas românicas, Claude acabou por ser
              demasiado intelectual para mim. Em vez disso, deixei que o <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modelo de IA avançado">GPT-5-Codex</a> fizesse o trabalho.
              Mais uma vez, a ferramenta certa para o trabalho certo!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Da intranet para a web selvagem
            </h2>
            <p>
              Depois que a coleção de ferramentas estava pronta (e até mesmo em vários idiomas),
              ela ficou disponível apenas na nossa rede corporativa por um bom tempo
              e prestou bons serviços.
            </p>
            <p>
              Em algum momento, pensei: por que não? Então, eu a organizei
              e a tornei pública.
            </p>
            <p>
              E porque tudo isso surgiu de um «acidente», o código está completamente aberto.
              Se você quiser mexer por conta própria ou encontrar um bug: você pode encontrar
              o repositório Git aqui: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositório GitHub do WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            <p>
              Sim, desculpem. Agora está aqui. A 10 000.ª coleção de ferramentas. Mas, afinal,
              tem uma história por trás! :D
            </p>
            <p>
              Divirtam-se!
            </p>
            <p class="mb-0">Ramon</p>
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
