<?php

/**
 * About Page (Spanish)
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

$lang = 'es';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/es';
$homeUrl = BASE_PATH . '/es';
$pageTitle = 'Acerca de WebDev-Tools – Utilidades Gratis Desarrolladores';
$pageDescription = 'Conozca WebDev-Tools, una colección de utilidades gratuitas y respetuosas con la privacidad para desarrolladores, creada con pasión por Ramon Kaes.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="keywords" content="WebDev-Tools, Acerca de, Ramon Kaes, Herramientas para desarrolladores">
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="theme-color" content="#066fd1">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes" >

  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . BASE_PATH ?>/assets/img/webdev-tools.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta property="og:site_name" content="WebDev-Tools">
  <meta property="og:locale" content="es_ES">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="pt_PT">
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
          <h1 class="display-5 mb-3">Acerca de WebDev-Tools</h1>
          <p class="lead text-secondary">
            La colección de herramientas número 10 000: un informe de accidente
          </p>
          
          <!-- Insignias de Cumplimiento de Estándares -->
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
              <i class="bi bi-lock-fill me-1"></i>Solo del lado del cliente
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Sí, lo sé. La enésima colección de herramientas de Internet. ¿Quién la necesita?<br>
              Pero os puedo tranquilizar. Este proyecto nunca estuvo previsto. Es un accidente, fruto de la pura procrastinación, pero también surgió de una necesidad real. Todo empezó de forma muy inocente en mi escritorio.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              Al principio estaba el script.
            </h2>
            <p>
							Como muchos desarrolladores, yo también tenía guardadas varias herramientas de creación propia en mi servidor local. Pequeños scripts para las molestias cotidianas: una conversión de em a píxeles por aquí, una pequeña ayuda por allá. Cosas para las que me daba pereza buscar siempre en las mismas páginas web. Y es que estoy en guerra abierta con los marcadores.
            </p>
            <p class="mb-3">
							Estas pequeñas herramientas cumplían fielmente su función. Pero entonces añadí dos más y mi instinto de desarrollador web se impuso sin piedad: empecé a enlazarlas entre sí. Hacía falta un menú. Un poco de diseño. Y, de repente, me vi metido de lleno en todo lo que se te ocurre cuando quieres distraerte con éxito de tu trabajo real. La sencilla colección se convirtió en un proyecto en toda regla. Simplemente tenía que «tunearlo» hasta que tuviera ante mí una auténtica página web en toda regla, con todo lo que ello conlleva.
            </p>

            <h2 class="h5 card-title mb-3">
              Del caos de scripts a una auténtica aplicación web.
            </h2>
            <p>
              De esos scripts dispersos debía surgir una plataforma fiable. Para acelerar el proceso de desarrollo y hacer más eficiente la estructuración del código, integré <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Asistente de IA Claude Code">Claude Code</a> directamente en mi flujo de trabajo. Sin embargo, siempre me centré en el pragmatismo: las herramientas debían cargarse rápido, ser intuitivas y hacer exactamente lo que tenían que hacer, sin florituras innecesarias. Cualquier desarrollador web conoce la tentación de perderse en interminables discusiones sobre el framework perfecto o la arquitectura más elegante. En su lugar, opté por el camino más directo: una base sólida de <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Framework CSS Bootstrap">Bootstrap</a>, un código limpio y la regla de oro de que «listo y funcionando» es más valioso que la perfección teórica.
            </p>

            <h2 class="h5 card-title mb-3">
              De la intranet a la web salvaje
            </h2>
            <p class="mb-3">
              Una vez completado el conjunto de herramientas, este prestó un buen servicio durante bastante tiempo en nuestra red corporativa. En algún momento pensé: ¿por qué no compartirlo con todo el mundo?
            </p>
            <p>
              Sin embargo, cuando se publica un proyecto en Internet, no debería fracasar por las barreras lingüísticas. Así que me invadió de nuevo la ambición y, antes de publicarlo, amplié el sistema para que fuera multilingüe, con el fin de que pudiera ser utilizado por un público internacional. Para llevarlo a cabo de forma pragmática y eficiente, recurrí íntegramente a <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Herramienta de traducción DeepL">DeepL</a> para la traducción de los textos.
            </p>
            <p>
              A continuación, limpié el código y hice pública la página. Como todo esto surgió, al fin y al cabo, de un «accidente» y se nutre del espíritu del código abierto, el código está completamente a la vista de todos. Quien quiera echar una mano, tenga una idea para una nueva herramienta o encuentre un error, está cordialmente invitado a participar. Podéis encontrar el repositorio de Git aquí: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositorio GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sí, lo siento. Pues ya está aquí, la recopilación de herramientas número 10 000. Pero bueno, al menos tiene una bonita historia detrás y, quién sabe, ¡quizá os ahorre en el día a día tanto tiempo de búsqueda como a mí!
            </p>

            <p>¡Que la disfrutéis!</p>
            <p>Ramón</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Servicio de traducción en línea gratuito" class="text-decoration-none text-muted">Traducido con deepl.com (versión gratuita)</a>
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
