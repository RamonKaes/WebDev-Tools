<?php

/**
 * About Page (French)
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

$lang = 'fr';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/fr';
$homeUrl = BASE_PATH . '/fr';
$pageTitle = 'À propos de WebDev-Tools – Utilitaires gratuits pour développeurs';
$pageDescription = 'Découvrez WebDev-Tools, une collection d\'utilitaires gratuits et respectueux de la vie privée pour développeurs, créée avec passion par Ramon Kaes.';
$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';
$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">

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
  <meta property="og:locale" content="fr_FR">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="de_DE">
  <meta property="og:locale:alternate" content="es_ES">
  <meta property="og:locale:alternate" content="pt_PT">
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
          <h1 class="display-5 mb-3">À propos de WebDev Tools</h1>
          <p class="lead text-secondary">
            La 10 000e collection d'outils - un rapport d'accident
          </p>
          
          <!-- Badges de Conformité aux Normes -->
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
              <i class="bi bi-lock-fill me-1"></i>Côté client uniquement
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Oui, je sais. La dix millième collection d’outils sur Internet. Qui en a vraiment besoin ?<br>
              Mais je peux vous rassurer. Ce projet n’a jamais été prévu. C’est un accident, le fruit d’une pure procrastination, mais il est aussi né d’un réel besoin. Tout a commencé tout simplement sur mon bureau.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              Au commencement, il y avait le script.
            </h2>
            <p>
              Comme beaucoup de développeurs, j’avais moi aussi enregistré divers outils faits maison sur mon serveur local. De petits scripts pour les tracas du quotidien : une conversion em/px par-ci, une petite aide par-là. Des choses pour lesquelles j’étais trop paresseux pour rechercher à chaque fois les mêmes sites web. Car je suis en guerre ouverte contre les signets.
            </p>
            <p class="mb-3">
              Ces petits outils faisaient bien leur travail. Mais j’en ai ensuite ajouté deux autres et mon instinct de développeur web a frappé sans pitié : j’ai commencé à les relier entre eux. Il fallait un menu. Un peu de mise en page. Et tout à coup, je me suis retrouvé plongé dans tout ce qui peut bien passer par la tête quand on veut réussir à se distraire de son travail proprement dit. La simple collection s’est transformée en un projet à part entière. Il fallait absolument que je le « peaufine » jusqu’à ce que je me retrouve face à un véritable petit site web avec tout ce qu’il faut.
            </p>

            <h2 class="h5 card-title mb-3">
              Du chaos des scripts à une véritable application web.
            </h2>
            <p class="mb-3">
              Il fallait transformer ces scripts éparpillés en une plateforme fiable. Pour accélérer le processus de développement et rendre la structuration du code plus efficace, j’ai intégré <a href="https://code.claude.com" target="_blank" rel="noopener noreferrer" title="Assistant IA Claude Code">Claude Code</a> directement dans mon flux de travail. Mais j’ai toujours privilégié le pragmatisme : les outils devaient se charger rapidement, être intuitifs à utiliser et faire exactement ce qu’ils sont censés faire, sans fioritures inutiles. Tout développeur web connaît la tentation de se perdre dans des discussions interminables sur le framework parfait ou l’architecture la plus élégante. J’ai plutôt opté pour la voie directe : une base solide avec <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Framework CSS Bootstrap">Bootstrap</a>, un code propre et la règle d’or selon laquelle « terminé et fonctionnel » vaut mieux que la perfection théorique.
            </p>

            <h2 class="h5 card-title mb-3">
              De l’intranet au Web sauvage
            </h2>
            <p>
              Une fois la suite d’outils finalisée, elle a d’abord rendu de bons services pendant un bon moment sur notre réseau d’entreprise. À un moment donné, je me suis dit : pourquoi ne pas la partager avec le monde entier ?
            </p>
            <p>
              Lorsqu'on publie un projet sur Internet, il ne faut toutefois pas qu'il soit freiné par des barrières linguistiques. J'ai donc décidé de relever un nouveau défi et j'ai ajouté la fonctionnalité multilingue au système avant sa publication, afin de le rendre accessible à un public international. Pour mettre cela en œuvre de manière pragmatique et efficace, j'ai entièrement fait appel à <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Outil de traduction DeepL">DeepL</a> pour la traduction des textes.
            </p>
            <p>
              J’ai ensuite nettoyé le code et mis le site en ligne. Comme tout cela est né d’un « accident » et s’inscrit dans l’esprit de l’open source, le code est entièrement accessible. Ceux qui souhaitent y contribuer, qui ont une idée pour un nouvel outil ou qui trouvent une erreur sont cordialement invités à participer. Vous trouverez le dépôt Git ici : <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Dépôt GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Oui, désolé. La 10 000e collection d’outils est donc désormais disponible. Mais bon, elle a au moins une belle histoire derrière elle, et qui sait, peut-être vous épargnera-t-elle autant de recherches au quotidien qu’à moi !
            </p>

            <p>Amusez-vous bien !</p>
            <p>Ramon</p>
            <div class="text-center">
              <a href="https://kaes-websysteme.de/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand"></a>            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Service de traduction en ligne gratuit" class="text-decoration-none text-muted">Traduit avec deepl.com (version gratuite)</a>
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
