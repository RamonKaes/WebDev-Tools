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
$pageTitle = 'Acerca de WebDev-Tools – Utilidades gratuitas para desarrolladores';
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
          <h1 class="display-5 mb-3">Acerca de WebDev-Tools</h1>
          <p class="lead text-secondary">
            De un script local a la (sí, la número 10 000) colección de herramientas: una crónica de la
            casualidad
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
              Sí, lo sé. La colección de herramientas número 10 000 en Internet. ¿Quién la necesita?
              Pero puedo tranquilizaros: este proyecto nunca fue planeado. Es un accidente,
              un producto de la procrastinación y una lección sobre el manejo de la inteligencia artificial.

            </p>
            <p>
              Todo comenzó de forma inocente en mi escritorio.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Al principio fue el script.
            </h2>
            <p>
              Como muchos desarrolladores, yo también tenía algunas herramientas propias guardadas en mi localhost.
              Pequeños scripts para las molestias cotidianas: una conversión de Em/Px
              aquí, una pequeña ayuda allá. Cosas para las que era demasiado vago como para buscar y abrir siempre
              los mismos sitios web. Y es que estoy
              en guerra absoluta con los marcadores.
            </p>
            <p>
              Estas pequeñas ayudas cumplían su función. Pero entonces añadí dos más.
              Y entonces sucedió: mi instinto de desarrollador web se activó.
            </p>
            <p class="mb-5">
              Instintivamente, empecé a vincularlas entre sí. Necesitaba un menú.
              Y un poco de estilo. Y todo lo que se te ocurre
              cuando quieres distraerte del trabajo real. Así,
              una simple colección de scripts se convirtió en un proyecto en toda regla. Tenía que
              «tunearlo» hasta tener una pequeña página web con todo lo necesario.

            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              «¡IA, hazlo tú!» ¿Una idea descabellada?
            </h2>
            <p>
              En algún momento se me ocurrió la idea: solo son scripts sencillos. ¡Deja que
              lo haga la IA! Como fiel usuario de <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor de código gratuito">VS Code</a>, puse en marcha el proyecto directamente con
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI de Anthropic">Claude Sonnet 4.5</a> (en <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - Programador de pares de IA">GitHub CoPilot</a>).
            </p>
            <p>
              Me sorprendió, porque el resultado fue una aplicación web modular
              ampliable sorprendentemente buena.
            </p>
            <p>
              Por supuesto, no fue tan fácil. Hay que evitar constantemente que la IA se
              exceda. Mi comando más importante se convirtió rápidamente en: «¡No, no necesitamos ningún
              gestor de paquetes! ¡Y ahora deja de intentar sugerirme otro marco de trabajo!».
            </p>
            <p class="mb-5">
              Al final, sin embargo, se obtuvo una estructura básica realmente útil.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Las dificultades del «vibe coding» con IA
            </h2>
            <p>
              El proyecto cobró impulso y rápidamente aprendí algunas lecciones difíciles sobre
              la colaboración con mis nuevos compañeros digitales.
            </p>
            <p>
              La cuestión del marco: las IA prefieren trabajar con <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Marco CSS de utilidad primero">Tailwind</a>. Y así lo hicieron
              aquí. Tras algunos ajustes manuales, en los que mi paciencia se fue agotando
              poco a poco, finalmente se agotó. Sin pensarlo dos veces, me pasé a <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Marco front-end">Bootstrap</a>
              para terminar la colección de forma rápida y pragmática. A veces,
              «terminado» es simplemente mejor que «perfecto» (o «Tailwind»).
            </p>
            <p>
              2. ¿Sin <a href="https://git-scm.com/" target="_blank" rel="noopener noreferrer" title="Git - Sistema de control de versiones distribuido">Git</a>? ¡Sin mí! Por pura costumbre, creé directamente un <a href="https://git-scm.com/book/es/v2/Fundamentos-de-Git-Obteniendo-un-repositorio-Git" target="_blank" rel="noopener noreferrer" title="Repositorio Git - Fundamentos del control de versiones">repositorio Git</a>.
              ¡Por suerte! Rápidamente me di cuenta de que lo que estaba haciendo, ese
              «vibe coding» sin planificar con la IA, sin Git suponía una considerable
              pérdida de tiempo.
            </p>
            <p>
              3. Las trampas de la lógica de la IA: el mayor problema es que a las IA les gusta
              facilitarse la vida, pero de la manera equivocada.
            </p>
            <ul>
              <li>
                Especulan: en lugar de analizar lo que realmente se pretende, a menudo
                adivinan al azar. Hay que poner fin rápidamente a esta especulación y
                darles instrucciones precisas en cada paso, de lo contrario se acaba en el caos.
              <li>
                Les encantan sus propios scripts. Tienden a proponer sus propios scripts o soluciones,
                lo que a menudo conduce a resultados desastrosos. En no pocos
                casos, esto habría requerido un reinicio completo del proyecto,
                si no hubiera sido posible un valiente «git reset --hard».
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. Ping-pong de IA en las revisiones de código
              También he apostado por la IA en el control de calidad, pero de forma sistemática:
              primero dejé que <a href="https://openai.com/o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modelo de razonamiento avanzado">GPT-5 Codex</a> realizara las revisiones de código y
              luego pedí la opinión de <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Seguridad e investigación en IA">Claude Sonnet 4.5</a> al respecto. Una revisión de IA para
              la revisión de IA, por así decirlo. Es bastante meta, pero extremadamente útil para
              contrastar diferentes «formas de pensar».
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Ronda extra: ¿la IA como traductora?
            </h2>
            <p>
              Una vez que la funcionalidad estuvo lista, pensé en las traducciones. Primero le tocó el turno a
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Seguridad e investigación en IA">Claude Sonnet 4.5</a>. Según sus propias declaraciones, la IA domina el inglés y el
              alemán a nivel nativo y ofrece una seguridad del 98 % en español, francés,
              italiano y portugués.
            </p>
            <p>
              La cosa se puso interesante cuando pregunté por el hindi, el chino o el japonés. En este caso,
              la IA admitió que necesitaba ayuda externa, como <a href="https://www.deepl.com/es/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Servicio de traducción por IA">DeepL</a>. Y lo que es más importante,
              señaló por sí misma que no se trata solo de una traducción burda,
              sino que también hay que tener en cuenta las peculiaridades culturales y
              las formas de cortesía.
            </p>
            <p class="mb-5">
              Un refrescante grado de autorreflexión. Sin embargo, para la traducción por lotes propiamente dicha
              de la parte estática y codificada de las lenguas románicas, Claude me pareció
              demasiado intelectual. En su lugar, dejé que <a href="https://openai.com/o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modelo de razonamiento avanzado">GPT-5-Codex</a> se encargara de ello.
              Una vez más, la herramienta adecuada para el trabajo adecuado.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              De la intranet a la web salvaje
            </h2>
            <p>
              Una vez que la colección de herramientas estuvo lista (e incluso disponible en varios idiomas),
              estuvo disponible durante bastante tiempo solo en nuestra red corporativa
              y nos prestó un buen servicio.
            </p>
            <p>
              En algún momento pensé: ¿por qué no? Así que la ordené
              y la hice pública.
            </p>
            <p>
              Y como todo esto surgió a raíz de un «accidente», el código es completamente abierto. Si quieres participar en su desarrollo o encuentras algún error, aquí tienes el repositorio Git: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositorio GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sí, lo siento. Ahora está aquí. La colección de herramientas número 10 000. Pero bueno, al menos
              tiene una historia detrás. :D
            </p>
            <p>
              ¡Que lo disfrutes!
            </p>
            <p class="mb-0">Ramon</p>
            <div class="text-center">
              <img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
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
