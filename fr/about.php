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
              Oui, je sais. La dix millième collection d'outils sur Internet. Qui en a
              besoin ? Mais je peux vous rassurer : ce projet n'a jamais été prévu.
              C'est un accident, le fruit d'une pure procrastination, mais aussi une
              leçon sur l'utilisation de l'intelligence artificielle.
            </p>
            <p>
              Tout a commencé tout simplement sur mon bureau.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Au commencement était le script
            </h2>
            <p>
              Comme beaucoup de développeurs, j'avais moi aussi stocké divers outils
              maison sur mon localhost. De petits scripts pour les tracas quotidiens :
              une conversion em/px par-ci, une petite aide par-là. Des choses pour
              lesquelles j'étais trop paresseux pour rechercher les mêmes sites web à
              chaque fois. Car je suis en guerre totale contre les signets.
            </p>
            <p class="mb-5">
              Ces petits outils faisaient bien leur travail. Mais j'en ai ajouté deux
              autres et mon instinct de développeur web a frappé sans pitié : j'ai
              commencé à les relier entre eux. Il fallait un menu. Un peu de mise en
              forme. Et soudain, je me suis retrouvé plongé dans tout ce qui vient à
              l'esprit quand on veut réussir à se distraire de son travail. La simple
              collection s'est transformée en un projet à part entière. Il fallait que je
              le "pimp" jusqu'à ce que j'aie devant moi un vrai petit site web avec tout
              ce qu'il faut.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              « IA, à toi de jouer ! » - était-ce une idée farfelue ?
            </h2>
            <p>
              À un moment donné, une pensée m'est venue : ce ne sont que de simples
              scripts. Laisse l'IA s'en occuper ! En tant qu'utilisateur fidèle de
              <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Éditeur de code gratuit">VS Code</a>,
              j'ai directement lancé le projet avec
              <a href="https://www.anthropic.com/claude-code" target="_blank" rel="noopener noreferrer" title="Claude Code par Anthropic">Claude Code (Sonnet)</a>.
            </p>
            <p>
              Mais avant de laisser carte blanche à l'IA, il fallait établir des lignes
              directrices claires. J'ai donc tout d'abord défini une pile technologique
              fixe. À partir de celle-ci, j'ai dérivé un fichier <code>CLAUDE.md</code> (strictement
              limité à 60 lignes maximum - les chaînes de commande courtes sont
              essentielles avec les IA) ainsi qu'un fichier <code>.claude/comments/review.md</code>.
              Tout aussi essentiels pour votre portefeuille, un fichier <code>.claudeignore</code>
              cohérent et un fichier <code>.claude/settings.local.json</code> adapté de manière
              ciblée permettent d'économiser massivement des jetons lors du codage.
            </p>
            <p class="mb-5">
              Le résultat fut surprenant : une application web étonnamment performante et
              extensible de manière modulaire. Mais bien sûr, tout ne s'est pas déroulé
              sans accroc. Il faut constamment empêcher une IA d'en faire trop. Ma
              commande principale est rapidement devenue : « Non, on n'a pas besoin d'un
              gestionnaire de paquets ! Et maintenant, arrête de vouloir me proposer
              encore un framework ! »
              Au final, on a tout de même abouti à une structure de base utilisable.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Les pièges du « vibe coding »
            </h2>
            <p>
              Le projet a pris de l'ampleur et j'ai rapidement appris quelques leçons
              difficiles sur la collaboration avec mes collègues numériques.
            </p>
            <ul class="mb-5">
              <li>
                La question du framework : les IA adorent
                <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utilitaire">Tailwind</a>.
                Après quelques ajustements manuels qui ont mis ma patience à rude
                épreuve, celle-ci a fini par s'épuiser. Je suis alors passé à
                <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>
                pour mener le projet à bien de manière pragmatique. Parfois, « fini »
                vaut tout simplement mieux que « parfait » (ou Tailwind).
              </li><br>
              <li>
                Sans Git ? Sans moi ! Par habitude, j'ai directement créé un dépôt.
                Heureusement ! Je me suis vite rendu compte que ce « vibe coding » sans
                plan et sans contrôle de version se solde par une énorme perte de temps.
              </li><br>
              <li>
                Logique IA vs réalité : les IA se facilitent parfois trop la vie - ou se
                la compliquent trop. Certes, Claude s'est considérablement amélioré sur
                ce point et analyse désormais le code de manière nettement plus
                approfondie au lieu de spéculer à l'aveuglette. Cependant, si l'on ne
                précise pas exactement où l'on veut aller, les IA ont toujours tendance à
                proposer des solutions de script fantaisistes qui mènent à une impasse.
                Sans un « git reset --hard » bien décidé, j'aurais sans doute dû
                redémarrer le projet à zéro plus d'une fois.
              </li><br>
              <li>
                Ping-pong IA lors de la révision du code : pour l'assurance qualité,
                j'ai misé sur un système de « freins et contrepoids ». La commande
                /review déclenche la vérification interne de Claude, qui fonctionne
                strictement selon les spécifications de mon fichier review.md. En
                complément, j'ai fait réaliser des revues externes par ChatGPT et
                Gemini, puis j'ai discuté des résultats avec Claude Opus. Cette « revue
                IA pour la revue IA » est certes assez méta, mais extrêmement utile pour
                recouper différentes façons de penser et combler les lacunes logiques.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonus : l'IA comme traductrice ?
            </h2>
            <p>
              Une fois la fonctionnalité en place, c'était au tour des traductions.
              C'est là que l'IA a montré son côté philosophique :
              <a href="https://www.anthropic.com/" target="_blank" rel="noopener noreferrer" title="Anthropic - Sécurité et recherche en IA">Claude Sonnet 4.5</a>
              m'a fait remarquer de lui-même que les langues comme l'hindi, le chinois
              ou le japonais ne se résument pas seulement à du vocabulaire, mais qu'elles
              impliquent aussi des particularités culturelles et des formes de politesse.
              C'était un niveau de réflexion sur soi-même rafraîchissant.
            </p>
            <p class="mb-5">
              Dans la pratique, cependant, j'ai dû faire preuve de pragmatisme : pour la
              traduction par lots du contenu statique, Claude m'a semblé trop
              « intellectuel » et trop compliqué. Avec Gemini et ChatGPT, la qualité
              d'exécution était trop variable. Au final, j'ai tout fait traduire par
              <a href="https://www.deepl.com/fr/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Service de traduction par IA">DeepL</a>.
              Là encore, il faut choisir le bon outil pour le bon travail !
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              De l'intranet au grand public
            </h2>
            <p>
              Une fois la collection d'outils terminée et capable de prendre en charge
              plusieurs langues, elle a rendu de bons services pendant un bon moment sur
              notre réseau d'entreprise. À un moment donné, je me suis dit : pourquoi ne
              pas la partager ?
            </p>
            <p>
              J'ai donc fait un peu de ménage et rendu le site public. Et comme tout cela
              est né d'un « accident », le code est entièrement ouvert. Si vous souhaitez
              y contribuer ou si vous trouvez une erreur, vous trouverez le dépôt Git
              ici : <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Dépôt GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Oui, désolé. La 10 000e collection d'outils est donc désormais disponible.
              La 10 000e collection d'outils. Mais bon, au moins, elle a une belle
              histoire derrière elle !
            </p>
            <p>Amusez-vous bien avec !</p>
            <p>Ramon</p>
            <div class="text-center">
              <img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
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
