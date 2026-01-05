<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';
$lang = 'fr';
$currentTool = 'imprint';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/fr';
$homeUrl = BASE_PATH . '/fr';
$pageTitle = 'Mentions légales – Informations juridiques | WebDev-Tools';
$pageDescription = 'Informations légales et coordonnées pour WebDev-Tools.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/imprint.php');
$currentUrl = getFullUrl('/imprint.php', $lang);
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
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
          <h1 class="display-5 mb-3">Mentions légales</h1>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <p>
              <strong>Ramon Kaes</strong><br>
              Sitio dos Caliços<br>
              8700-069 Moncarapacho<br>
              Téléphone : +351 921 173 235<br>
              E-mail : ramon.kaes@webdev-tools.info
            </p>

            <h2 class="h5 card-title mb-3 mt-4">Clause de non-responsabilité – mentions légales</h2>
            
            <h3 class="h6 mt-4">§ 1 Avertissement concernant les contenus</h3>
            <p>Les contenus gratuits et librement accessibles de ce site web ont été créés avec le plus grand soin. Le fournisseur de ce site web ne garantit toutefois pas l'exactitude et l'actualité des conseils journalistiques et des informations fournis gratuitement et librement accessibles. Les contributions identifiées par leur nom reflètent l'opinion de leur auteur respectif et pas toujours celle du fournisseur. Le simple fait de consulter les contenus gratuits et librement accessibles ne crée aucun rapport contractuel entre l'utilisateur et le fournisseur, dans la mesure où il n'y a pas de volonté juridiquement contraignante de la part du fournisseur.</p>

            <h3 class="h6 mt-4">§ 2 Liens externes</h3>
            <p>Ce site web contient des liens vers des sites web tiers (« liens externes »). Ces sites web sont soumis à la responsabilité de leurs exploitants respectifs. Lors de la première mise en place des liens externes, le fournisseur a vérifié les contenus tiers afin de détecter d'éventuelles violations de la loi. À ce moment-là, aucune violation de la loi n'était apparente. Le fournisseur n'a aucune influence sur la conception actuelle et future ni sur les contenus des pages liées. La mise en place de liens externes ne signifie pas que le fournisseur s'approprie les contenus derrière la référence ou le lien. Un contrôle permanent des liens externes n'est pas raisonnable pour le fournisseur sans indications concrètes d'infractions. Toutefois, si des infractions sont connues, ces liens externes seront immédiatement supprimés.</p>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
<?php
// Output minified HTML
echo minify_html_output(ob_get_clean());
?>
