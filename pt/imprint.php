<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';
$lang = 'pt';
$currentTool = 'imprint';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/pt';
$homeUrl = BASE_PATH . '/pt';
$pageTitle = 'Impressum – Informações Legais | WebDev-Tools';
$pageDescription = 'Informações legais e dados de contacto para WebDev-Tools.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/imprint.php');
$currentUrl = getFullUrl('/imprint.php', $lang);
?>
<!DOCTYPE html>
<html lang="pt" data-bs-theme="auto">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="noindex, follow">
  <meta name="googlebot" content="noindex, follow">
  <meta name="theme-color" content="#0d6efd">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">
  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/imprint.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
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
          <h1 class="display-5 mb-3">Impressão</h1>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <p>
              <strong>Ramon Kaes</strong><br>
              Sitio dos Caliços<br>
              8700-069 Moncarapacho<br>
              Telefone: +351 921 173 235<br>
              E-mail: ramon.kaes@webdev-tools.info
            </p>

            <h2 class="h5 card-title mb-3 mt-4">Isenção de responsabilidade – avisos legais</h2>
            
            <h3 class="h6 mt-4">§ 1 Aviso sobre conteúdos</h3>
            <p>Os conteúdos gratuitos e de acesso livre deste site foram criados com o maior cuidado possível. No entanto, o fornecedor deste site não se responsabiliza pela exatidão e atualidade dos guias jornalísticos e notícias gratuitos e de acesso livre disponibilizados. As contribuições identificadas nominalmente refletem a opinião do respetivo autor e nem sempre a opinião do fornecedor. O simples acesso aos conteúdos gratuitos e de livre acesso não implica qualquer relação contratual entre o utilizador e o fornecedor, na medida em que não existe vontade de vinculação jurídica por parte do fornecedor.</p>

            <h3 class="h6 mt-4">§ 2 Links externos</h3>
            <p>Este site contém links para sites de terceiros ("links externos"). Estes sites estão sujeitos à responsabilidade dos respetivos operadores. Ao criar os links externos pela primeira vez, o fornecedor verificou os conteúdos externos para verificar se existiam eventuais violações legais. Na altura, não foram detetadas quaisquer violações legais. O fornecedor não tem qualquer influência sobre a configuração atual e futura e sobre os conteúdos das páginas ligadas. A inclusão de links externos não significa que o fornecedor se apropria dos conteúdos por trás da referência ou do link. Não é razoável esperar que o fornecedor controle constantemente os links externos sem indícios concretos de violações legais. No entanto, se tomar conhecimento de violações legais, esses links externos serão imediatamente excluídos.</p>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
