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
          <h1 class="display-5 mb-3">À propos de WebDev Tools</h1>
          <p class="lead text-secondary">
            Du script local à la (oui, la 10 000e) collection d'outils : Une chronique du
            hasard
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
              Oui, je sais. La 10 000e collection d'outils sur Internet. Qui en a besoin ?
              Mais je peux vous rassurer : ce projet n'a jamais été prévu. C'est un accident,
              le fruit de la procrastination et une leçon sur l'utilisation de l'intelligence artificielle.

            </p>
            <p>
              Tout a commencé de manière tout à fait anodine sur mon bureau.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Au commencement était le script.
            </h2>
            <p>
              Comme beaucoup de développeurs, j'avais moi aussi enregistré quelques outils personnels sur mon hôte local.
              De petits scripts pour les tracas quotidiens : une conversion Em/Px
              ici, une petite aide là. Des choses pour lesquelles j'étais trop paresseux pour rechercher et consulter sans cesse les
              mêmes sites web. Je suis en effet en guerre ouverte avec les signets
              .
            </p>
            <p>
              Ces petits outils m'étaient utiles. Mais j'en ai ajouté deux autres.
              Et c'est là que mon instinct de développeur web s'est réveillé.
            </p>
            <p class="mb-5">
              J'ai instinctivement commencé à relier ces outils entre eux. Il fallait un menu.
              Et un peu de style. Et tout ce qui peut venir à l'esprit
              quand on veut se détourner avec succès de son travail. C'est ainsi qu'
              une simple collection de scripts s'est transformée en un projet à part entière. Je devais
              simplement « l'améliorer » jusqu'à obtenir un véritable petit site web avec tout ce qu'il faut.

            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              « IA, prends le relais ! » – Une idée farfelue ?
            </h2>
            <p>
              À un moment donné, je me suis dit : ce ne sont que des scripts simples. Pourquoi ne pas
              laisser l'IA s'en charger ? En tant qu'utilisateur fidèle de <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Éditeur de code gratuit">VS Code</a>, j'ai immédiatement lancé le projet avec
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI d'Anthropic">Claude Sonnet 4.5</a> (dans <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - Programmeur en binôme IA">GitHub CoPilot</a>).
            </p>
            <p>
              J'ai été surpris, car le résultat était une application web étonnamment bonne et modulable.

            </p>
            <p>
              Bien sûr, cela n'a pas été si simple. Il faut constamment empêcher l'IA d'
              en faire trop. Ma commande la plus importante est rapidement devenue : « Non, nous n'avons pas besoin d'un
              gestionnaire de paquets ! Et maintenant, arrête d'essayer de me proposer un autre framework ! »
            </p>
            <p class="mb-5">
              Mais au final, nous avons obtenu une structure de base réellement utilisable.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Les pièges du « vibe coding » avec l'IA
            </h2>
            <p>
              Le projet a pris de l'ampleur et j'ai rapidement appris quelques leçons difficiles sur la
              collaboration avec mes nouveaux collègues numériques.
            </p>
            <p>
              La question du framework : les IA préfèrent travailler avec <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Framework CSS utilitaire">Tailwind</a>. C'est ce qu'elles ont fait
              ici aussi. Après quelques ajustements manuels qui ont mis ma patience à rude épreuve,
              j'ai fini par craquer. Je suis rapidement passé à <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Framework front-end">Bootstrap</a>
              afin de mener à bien la collection de manière rapide et pragmatique. Parfois,
              « fini » vaut mieux que « parfait » (ou « Tailwind »).
            </p>
            <p>
              2. Sans <a href="https://git-scm.com/" target="_blank" rel="noopener noreferrer" title="Git - Système de contrôle de version distribué">Git</a> ? Sans moi ! Par pure habitude, j'ai directement créé un <a href="https://git-scm.com/book/fr/v2/Les-bases-de-Git-D%C3%A9marrer-un-d%C3%A9p%C3%B4t-Git" target="_blank" rel="noopener noreferrer" title="Dépôt Git - Bases du contrôle de version">dépôt Git</a>.
              Heureusement ! J'ai rapidement réalisé que ce que je faisais – ce
              « vibe coding » sans plan précis avec l'IA – sans Git entraînait une perte de temps considérable.

            </p>
            <p>
              3. Les pièges de la logique IA : le plus gros problème est que les IA aiment se faciliter la vie,
              mais de la mauvaise manière.
            </p>
            <ul>
              <li>
                Elles spéculent : au lieu d'analyser ce que l'on veut réellement faire, elles font souvent des suppositions hasardeuses.
                Il faut très vite mettre fin à ces spéculations et
                leur donner des instructions précises à chaque étape, sinon cela finit dans le chaos.
              <li>
                Elles aiment leurs propres scripts. Elles ont tendance à proposer leurs propres scripts ou solutions,
                qui conduisent souvent à des résultats désastreux. Dans de nombreux
                cas, cela aurait nécessité un redémarrage complet du projet,
                si un « git reset --hard » courageux n'avait pas été possible.
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. Ping-pong IA lors des revues de code
              J'ai également misé sur les IA pour l'assurance qualité, mais de manière systématique :
              j'ai d'abord fait effectuer les révisions de code par <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modèle d'IA avancé">GPT-5 Codex</a>, puis
              j'ai demandé l'avis de <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI d'Anthropic">Claude Sonnet 4.5</a> à ce sujet. Une révision IA pour
              la révision IA, en quelque sorte. C'est assez méta, mais extrêmement utile pour
              vérifier différentes « façons de penser ».
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonus : l'IA comme traductrice ?
            </h2>
            <p>
              Une fois la fonctionnalité mise en place, j'ai pensé aux traductions. J'ai d'abord essayé
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI d'Anthropic">Claude Sonnet 4.5</a>. Selon ses propres déclarations, l'IA maîtrise l'anglais et
              l'allemand à un niveau natif et offre une fiabilité de 98 % en espagnol, français,
              italien et portugais.
            </p>
            <p>
              Les choses sont devenues intéressantes lorsque j'ai demandé l'hindi, le chinois ou le japonais. L'IA
              a alors admis qu'elle avait besoin d'une aide externe, telle que <a href="https://www.deepl.com/fr/translator" target="_blank" rel="noopener noreferrer" title="DeepL - Service de traduction par IA">DeepL</a>. Plus important encore,
              elle a souligné de sa propre initiative qu'il ne s'agissait pas seulement d'une traduction grossière,
              mais qu'il fallait également tenir compte des particularités culturelles et
              des formes de politesse.
            </p>
            <p class="mb-5">
              Une dose rafraîchissante d'introspection. Pour la traduction par lots proprement dite
              de la partie statique et codée en dur des langues romanes, Claude m'a toutefois semblé
              trop intellectuel. J'ai donc préféré confier cette tâche à <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Modèle d'IA avancé">GPT-5-Codex</a>.
              Là encore, il s'agit de choisir le bon outil pour le bon travail !
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              De l'intranet au web sauvage
            </h2>
            <p>
              Une fois que la collection d'outils a atteint un certain niveau de maturité (et qu'elle était même disponible en plusieurs langues),
              elle est restée longtemps accessible uniquement sur le réseau de notre entreprise
              et nous a rendu de grands services.
            </p>
            <p>
              À un moment donné, je me suis dit : pourquoi pas ? Je l'ai donc mise en ordre
              et rendue publique.
            </p>
            <p>
              Et parce que tout cela est né d'un « accident », le code est entièrement ouvert.
              Si vous voulez bricoler vous-même ou trouver un bug : vous pouvez trouver
              le dépôt Git ici : <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Dépôt GitHub de WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Oui, désolé. Elle est maintenant ici. La 10 000e collection d'outils. Mais bon, après tout,
              elle a une histoire ! :D
            </p>
            <p>
              Amusez-vous bien !
            </p>
            <p class="mb-0">Ramon</p>
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