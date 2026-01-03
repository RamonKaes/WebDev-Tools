<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';
$lang = 'it';
$currentTool = 'imprint';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/it';
$homeUrl = BASE_PATH . '/it';
$pageTitle = 'Impronta – Informazioni legali | WebDev-Tools';
$pageDescription = 'Informazioni legali e dati di contatto per WebDev-Tools.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/imprint.php');
$currentUrl = getFullUrl('/imprint.php', $lang);
?>
<!DOCTYPE html>
<html lang="it" data-bs-theme="auto">
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
          <h1 class="display-5 mb-3">Impressum</h1>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <p>
              <strong>Ramon Kaes</strong><br>
              Sitio dos Caliços<br>
              8700-069 Moncarapacho<br>
              Telefono: +351 921 173 235<br>
              E-mail: ramon.kaes@webdev-tools.info
            </p>

            <h2 class="h5 card-title mb-3 mt-4">Disclaimer – Note legali</h2>
            
            <h3 class="h6 mt-4">§ 1 Avviso sui contenuti</h3>
            <p>I contenuti gratuiti e liberamente accessibili di questo sito web sono stati redatti con la massima cura. Il fornitore di questo sito web non si assume tuttavia alcuna responsabilità per la correttezza e l'attualità delle guide giornalistiche e delle notizie fornite gratuitamente e liberamente accessibili. I contributi contrassegnati con il nome riflettono l'opinione del rispettivo autore e non sempre l'opinione del fornitore. La semplice consultazione dei contenuti gratuiti e liberamente accessibili non comporta alcun rapporto contrattuale tra l'utente e il fornitore, in quanto manca la volontà giuridicamente vincolante del fornitore.</p>

            <h3 class="h6 mt-4">§ 2 Link esterni</h3>
            <p>Questo sito web contiene collegamenti a siti web di terzi ("link esterni"). Questi siti web sono soggetti alla responsabilità dei rispettivi gestori. Al momento della prima creazione dei link esterni, il fornitore ha verificato i contenuti esterni per verificare l'eventuale presenza di violazioni della legge. A quel momento non erano evidenti violazioni della legge. Il fornitore non ha alcuna influenza sulla struttura attuale e futura e sui contenuti delle pagine collegate. L'inserimento di link esterni non significa che il fornitore si appropri dei contenuti a cui rimandano i riferimenti o i link. Non è ragionevole pretendere che il fornitore controlli costantemente i link esterni senza indicazioni concrete di violazioni della legge. Tuttavia, qualora venisse a conoscenza di violazioni della legge, tali link esterni verrebbero immediatamente cancellati.</p>

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
