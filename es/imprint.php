<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';
$lang = 'es';
$currentTool = 'imprint';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/es';
$homeUrl = BASE_PATH . '/es';
$pageTitle = 'Aviso Legal – Información Legal | WebDev-Tools';
$pageDescription = 'Información legal y datos de contacto para WebDev-Tools.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/imprint.php');
$currentUrl = getFullUrl('/imprint.php', $lang);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
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
          <h1 class="display-5 mb-3">Aviso legal</h1>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <p>
              <strong>Ramon Kaes</strong><br>
              Sitio dos Caliços<br>
              8700-069 Moncarapacho<br>
              Teléfono: +351 921 173 235<br>
              Correo electrónico: ramon.kaes@webdev-tools.info
            </p>

            <h2 class="h5 card-title mb-3 mt-4">Descargo de responsabilidad: avisos legales</h2>
            
            <h3 class="h6 mt-4">§ 1 Advertencia sobre los contenidos</h3>
            <p>Los contenidos gratuitos y de libre acceso de este sitio web se han elaborado con el mayor cuidado posible. Sin embargo, el proveedor de este sitio web no garantiza la exactitud y actualidad de los consejos periodísticos y noticias gratuitos y de libre acceso que se proporcionan. Las contribuciones identificadas con el nombre reflejan la opinión del autor correspondiente y no siempre la opinión del proveedor. El mero hecho de acceder a los contenidos gratuitos y de libre acceso no da lugar a ninguna relación contractual entre el usuario y el proveedor, ya que no existe voluntad vinculante por parte del proveedor.</p>

            <h3 class="h6 mt-4">§ 2 Enlaces externos</h3>
            <p>Este sitio web contiene enlaces a sitios web de terceros («enlaces externos»). Estos sitios web están sujetos a la responsabilidad de sus respectivos operadores. El proveedor ha comprobado los contenidos externos al establecer por primera vez los enlaces externos para detectar posibles infracciones legales. En ese momento no se detectó ninguna infracción legal. El proveedor no tiene ninguna influencia en el diseño actual y futuro ni en los contenidos de las páginas enlazadas. La inclusión de enlaces externos no significa que el proveedor se apropie de los contenidos a los que remiten dichos enlaces. No es razonable exigir al proveedor un control constante de los enlaces externos sin indicios concretos de infracciones legales. No obstante, si se tiene conocimiento de infracciones legales, dichos enlaces externos se eliminarán de inmediato.</p>

          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
