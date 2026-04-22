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
              Sí, lo sé. La colección de herramientas número 10 000 en Internet. ¿Quién la
              necesita? Pero puedo tranquilizaros: este proyecto nunca estuvo planeado.
              Es un accidente, fruto de la pura procrastinación, pero también una lección
              sobre cómo lidiar con la inteligencia artificial.
            </p>
            <p>
              Todo empezó de forma muy inocente en mi escritorio.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Al principio fue el script
            </h2>
            <p>
              Como muchos desarrolladores, yo también tenía varias herramientas de
              creación propia almacenadas en mi localhost. Pequeños scripts para las
              molestias cotidianas: una conversión de em/px por aquí, una pequeña ayuda
              por allá. Cosas para las que me daba pereza buscar siempre en los mismos
              sitios web. Y es que estoy en guerra abierta con los marcadores.
            </p>
            <p class="mb-5">
              Esas pequeñas ayudas cumplían diligentemente su función. Pero entonces
              añadí dos más y mi instinto de desarrollador web se impuso sin piedad:
              empecé a enlazarlas. Hacía falta un menú. Un poco de diseño. Y de repente
              me vi metido de lleno en todo lo que se te ocurre cuando quieres
              distraerte con éxito de tu trabajo real. La simple colección se convirtió
              en un proyecto en toda regla. Tenía que «tunearlo» hasta que tuviera ante
              mí una pequeña página web en toda regla con todos los detalles.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              «IA, ¡toma el relevo!»: ¿fue una idea descabellada?
            </h2>
            <p>
              En algún momento se me ocurrió: al fin y al cabo, solo son scripts
              sencillos. ¡Deja que la IA se encargue de ello! Como fiel usuario de
              <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Editor de código gratuito">VS Code</a>,
              monté el proyecto directamente con
              <a href="https://www.anthropic.com/claude-code" target="_blank" rel="noopener noreferrer" title="Claude Code de Anthropic">Claude Code (Sonnet)</a>.
            </p>
            <p>
              Pero antes de darle rienda suelta a la IA, tenía que establecer unas
              pautas claras. Así que, en primer lugar, definí una pila tecnológica fija.
              A partir de ahí, derivé un <code>CLAUDE.md</code> (estrictamente limitado a un máximo
              de 60 líneas; las rutas de comandos cortas son fundamentales en la IA) y
              un <code>.claude/comments/review.md</code>. Igualmente vitales para el bolsillo son un
              archivo <code>.claudeignore</code> coherente y un <code>.claude/settings.local.json</code> adaptado
              específicamente para ahorrar tokens de forma masiva al programar.
            </p>
            <p class="mb-5">
              El resultado fue sorprendente: una aplicación web increíblemente buena y
              ampliable de forma modular. Pero, por supuesto, no todo salió a la
              perfección. Hay que evitar constantemente que una IA se exceda. Mi comando
              más importante se convirtió rápidamente en: «¡No, no necesitamos un gestor
              de paquetes! ¡Y ahora deja de intentar sugerirme otro framework!»
              Al final, sin embargo, salió un esqueleto básico realmente útil.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Las trampas del «Vibe Coding»
            </h2>
            <p>
              El proyecto cobró impulso y aprendí rápidamente algunas lecciones duras
              sobre la colaboración con mis colegas digitales.
            </p>
            <ul class="mb-5">
              <li>
                La cuestión del framework: a las IA les encanta
                <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utility-first">Tailwind</a>.
                Tras algunos ajustes manuales, durante los cuales mi paciencia se fue
                agotando peligrosamente, finalmente se rompió. A raíz de ello, me pasé a
                <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>
                para terminar el asunto de forma pragmática. A veces, «terminado» es
                simplemente mejor que «perfecto» (o Tailwind).
              </li><br>
              <li>
                ¿Sin Git? ¡Sin mí! Por costumbre, creé directamente un repositorio.
                ¡Menos mal! Rápidamente me di cuenta de que este «Vibe Coding» sin
                planificación y sin control de versiones acababa siendo una enorme
                pérdida de tiempo.
              </li><br>
              <li>
                Lógica de la IA frente a la realidad: a veces, las IA se lo ponen
                demasiado fácil... o demasiado complicado. Es cierto que Claude ha
                mejorado enormemente en este aspecto y ahora analiza el código de forma
                mucho más fundamentada en lugar de especular a ciegas. Sin embargo, si
                no se especifica con precisión hacia dónde debe ir el proyecto, las IA
                siguen tendiendo a soluciones de script arbitrarias que acaban en un
                callejón sin salida. Sin un valiente «git reset --hard», probablemente
                habría tenido que reiniciar el proyecto por completo más de una vez.
              </li><br>
              <li>
                Ping-pong de IA en la revisión de código: para el control de calidad, he
                apostado por un sistema de «checks and balances». Mediante el comando
                /review, activo la revisión interna de Claude, que funciona estrictamente
                según las especificaciones de mi review.md. Como complemento, encargué
                revisiones externas a ChatGPT y Gemini y, finalmente, discutí los
                resultados con Claude Opus. Esta «revisión de IA para la revisión de IA»
                es bastante meta, pero extremadamente útil para contrastar diferentes
                formas de pensar y cerrar lagunas lógicas.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Ronda extra: ¿IA como traductor?
            </h2>
            <p>
              Una vez que la funcionalidad estuvo lista, llegó el turno de las
              traducciones. Aquí la IA mostró su lado filosófico:
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Seguridad e investigación en IA">Claude Sonnet 4.5</a>
              me señaló, sin que yo se lo pidiera, que en idiomas como el hindi, el
              chino o el japonés no solo se trata de vocabulario, sino también de
              peculiaridades culturales y formas de cortesía. Fue un nivel refrescante de
              autorreflexión.
            </p>
            <p class="mb-5">
              En la práctica, sin embargo, la decisión fue pragmática: para la
              traducción por lotes del contenido estático, Claude me resultaba demasiado
              «intelectual» y complicado. En el caso de Gemini y ChatGPT, la calidad de
              la ejecución fluctuaba demasiado. Al final, lo traduje todo con
              <a href="https://www.deepl.com/es/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Servicio de traducción por IA">DeepL</a>.
              También en este caso se aplica lo siguiente: ¡la herramienta adecuada para
              cada trabajo!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              De la intranet a la web
            </h2>
            <p>
              Una vez que terminé la colección de herramientas, que incluso admitía
              varios idiomas, nos prestó un buen servicio durante bastante tiempo en
              nuestra red corporativa. En algún momento pensé: ¿por qué no compartirla?
            </p>
            <p>
              Así que la puse a punto y la hice pública. Y como todo esto surgió de un
              «accidente», el código es totalmente abierto. Si alguien quiere echar una
              mano o encuentra algún error: el repositorio de Git lo encontraréis aquí:
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositorio GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Sí, lo siento. Así que ya está aquí, la colección de herramientas número
              10 000. La colección de herramientas número 10 000. Pero bueno, ¡al menos
              tiene una bonita historia detrás!
            </p>
            <p>¡Que la disfrutéis!</p>
            <p>Ramon</p>
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
