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
  <meta name="keywords" content="WebDev-Tools, Sobre, Ramon Kaes, Ferramentas para desenvolvedores, Privacidade">
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
  <meta property="og:locale" content="pt_BR">
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
  <meta name="apple-mobile-web-app-title" content="WebDev-Tools" />
  <link rel="manifest" href="<?= BASE_PATH . getLangPrefix($lang) ?>/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= assetSrc('css/style.css') ?>">
  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>

<body class="d-flex flex-column bg-body">
  <?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>
  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>
    <main id="main-content" class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
      <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Sobre WebDev Tools</h1>
          <p class="lead text-secondary">
            A 10.000ª coleção de ferramentas – o relato de um acidente
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
              <i class="bi bi-lock-fill me-1"></i>Somente no navegador
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Sim, eu sei. A décima milésima coleção de ferramentas na internet. Quem é que precisa disso?<br>
              Mas posso tranquilizar você: este projeto nunca foi planejado. É um acidente, um produto da pura procrastinação, mas também surgiu de uma necessidade real. Tudo começou de forma bem inofensiva no meu ambiente de trabalho.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              No início, havia o script.
            </h2>
            <p>
              Como muitos desenvolvedores, eu também tinha várias ferramentas feitas por mim guardadas no meu localhost. Pequenos scripts para as chateações do dia a dia: uma conversão de em/px aqui, um pequeno auxiliar ali. Coisas para as quais eu tinha preguiça de procurar sempre os mesmos sites. É que estou em guerra aberta com os favoritos.
            </p>
            <p class="mb-3">
              Essas pequenas ferramentas cumpriam bem o seu papel. Mas depois acrescentei mais duas, e meu instinto de desenvolvedor web entrou em ação sem piedade: comecei a interligá-las. Era preciso um menu. Um pouco de estilo. E, de repente, me vi no meio de tudo aquilo que nos ocorre quando queremos nos distrair com sucesso do trabalho de verdade. Da simples coleção surgiu um projeto em grande escala. Eu simplesmente tive que “melhorar” tudo até ter diante de mim um verdadeiro pequeno site com tudo o que é necessário.
            </p>

            <h2 class="h5 card-title mb-3">
              Do caos dos scripts a uma verdadeira aplicação web.
            </h2>
            <p class="mb-3">
              A partir dos scripts dispersos, deveria surgir uma plataforma confiável. Para acelerar o processo de desenvolvimento e tornar a estruturação do código mais eficiente, integrei o <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Assistente de IA Claude Code">Claude Code</a> diretamente no meu fluxo de trabalho. No entanto, o foco esteve sempre no pragmatismo: as ferramentas deviam carregar rápido, ser intuitivas de usar e fazer exatamente o que deviam, sem frescuras desnecessárias. Qualquer desenvolvedor web conhece a tentação de se perder em discussões intermináveis sobre o framework perfeito ou a arquitetura mais elegante. Em vez disso, optei pelo caminho mais direto: uma base sólida em <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Framework CSS Bootstrap">Bootstrap</a>, um código limpo e a regra de ferro de que “pronto e funcionando” vale mais do que a perfeição teórica.
            </p>

            <h2 class="h5 card-title mb-3">
              Da intranet para a web selvagem
            </h2>
            <p>
              Depois de concluída, a coleção de ferramentas prestou bons serviços durante bastante tempo em nossa rede corporativa. Em algum momento, pensei: “Por que não compartilhar isso com o mundo inteiro?”
            </p>
            <p>
              No entanto, quando se lança um projeto na internet, ele não deve fracassar por causa de barreiras linguísticas. Por isso, a ambição voltou a tomar conta de mim e, antes do lançamento, ampliei o sistema para que fosse multilíngue, de modo a torná-lo acessível a um público internacional. Para implementar tudo isso de forma pragmática e eficiente, recorri inteiramente ao <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Ferramenta de tradução DeepL">DeepL</a> para as traduções dos textos.
            </p>
            <p>
              Depois, organizei o código e tornei o site público. Como tudo isso surgiu, afinal, de um “acidente” e se baseia na filosofia do código aberto, o código está totalmente disponível. Quem quiser dar uma ajuda, tiver uma ideia para uma nova ferramenta ou encontrar um erro está cordialmente convidado a participar. Você encontra o repositório Git aqui: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositório GitHub do WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Encontrou um erro? Reporte nas <a href="https://github.com/RamonKaes/WebDev-Tools/issues" target="_blank" rel="noopener noreferrer" title="Reportar um erro no GitHub">issues do GitHub</a>. Perguntas, ideias e outros comentários são bem-vindos no <a href="https://easyq.info/projects/ramonkaes-webdev-tools" target="_blank" rel="noopener noreferrer" title="Perguntas e ideias no easyQ">easyQ</a>.
            </p>
            <p>
              Sim, desculpe. Então aqui está ela, a 10.000ª coleção de ferramentas. Mas, afinal, tem uma boa história por trás e, quem sabe, talvez economize para você tanto tempo de pesquisa no dia a dia quanto economizou para mim!
            </p>

            <p>Divirta-se com ela!</p>
            <p>Ramon</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
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