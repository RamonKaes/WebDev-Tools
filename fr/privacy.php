<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'fr';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/fr';
$homeUrl = BASE_PATH . '/fr';
$pageTitle = 'Politique de confidentialité – WebDev-Tools';
$pageDescription = 'Politique de confidentialité et informations sur la protection des données pour WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
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

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/privacy.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
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
          <h1 class="display-5 mb-3">Politique de confidentialité</h1>
          <p class="lead text-secondary">Votre vie privée nous tient à cœur</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Protection des données en bref</h2>
            
            <h3 class="h6 mb-2">Remarques générales</h3>
            <p>Les remarques suivantes vous donnent un aperçu simple de ce qu'il advient de vos données à caractère personnel lorsque vous visitez ce site web. Les données à caractère personnel sont toutes les données qui permettent de vous identifier personnellement.</p>

            <h3 class="h6 mb-2 mt-3">Collecte des données sur ce site web</h3>
            <p><strong>Qui est responsable de la collecte des données sur ce site web ?</strong></p>
            <p>Le traitement des données sur ce site web est effectué par l'exploitant du site web. Vous trouverez ses coordonnées dans les mentions légales de ce site web.</p>
            
            <p><strong>Comment collectons-nous vos données ?</strong></p>
            <p>Vos données sont collectées d'une part lorsque vous nous les communiquez. Il peut s'agir, par exemple, de données que vous nous envoyez par e-mail.</p>
            <p>D'autres données sont collectées automatiquement ou avec votre consentement lorsque vous visitez le site web par nos systèmes informatiques. Il s'agit principalement de données techniques (par exemple, navigateur internet, système d'exploitation ou heure de consultation de la page). La collecte de ces données s'effectue automatiquement dès que vous accédez à ce site web.</p>
            
            <p><strong>À quoi servent vos données ?</strong></p>
            <p>Une partie des données est collectée afin de garantir le bon fonctionnement du site web. D'autres données peuvent être utilisées pour analyser votre comportement d'utilisateur. Nous utilisons également Google AdSense pour financer ce site web gratuit par le biais de publicités.</p>
            
            <p><strong>Quels sont vos droits concernant vos données ?</strong></p>
            <p>Vous avez à tout moment le droit d'obtenir gratuitement des informations sur l'origine, le destinataire et la finalité de vos données personnelles enregistrées. Vous avez également le droit d'exiger la rectification ou la suppression de ces données. Si vous avez donné votre consentement au traitement des données, vous pouvez le révoquer à tout moment pour l'avenir. Vous avez également le droit, dans certaines circonstances, d'exiger la limitation du traitement de vos données personnelles. Vous disposez également d'un droit de recours auprès de l'autorité de contrôle compétente.</p>

            <h2 class="h5 mb-3 mt-4">2. Approche « Privacy First » pour les outils</h2>
            <p><strong>Tous les outils de ce site web traitent vos données saisies exclusivement dans votre navigateur.</strong> Lorsque vous utilisez nos outils (par exemple, l'encodeur Base64, le formateur JSON, etc.), les conditions suivantes s'appliquent :</p>
            <ul>
              <li>Toutes les conversions, validations et générations sont effectuées côté client dans votre navigateur</li>
              <li>Les données que vous saisissez dans les outils ne quittent jamais votre appareil</li>
              <li>Nous ne stockons, n'enregistrons ni n'avons accès aux données que vous traitez avec nos outils</li>
              <li>Nous ne pouvons fournir aucune information sur les données saisies dans les outils, car nous ne les collectons pas</li>
            </ul>
            <p><strong>Remarque importante :</strong> cela concerne exclusivement le traitement de vos données <em>dans les outils</em>. Cependant, lorsque vous visitez le site web, des données techniques sont automatiquement collectées (voir section 4) et Google AdSense utilise des cookies à des fins publicitaires (voir sections 6 et 7).</p>

            <h2 class="h5 mb-3 mt-4">3. Sécurité et Transparence</h2>

            <p>Nous mettons en œuvre plusieurs niveaux de sécurité pour protéger votre vie privée et garantir l'intégrité de nos outils :</p>

            <h3 class="h6 mb-2 mt-3">3.1 Open Source et Auditabilité</h3>
            <p>Le code source complet est disponible publiquement sur GitHub. Vous pouvez examiner, auditer ou bifurquer le projet à tout moment :</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Dépôt GitHub de WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Intégrité des Sous-ressources (SRI)</h3>
            <p>Toutes les bibliothèques externes sont chargées avec des hashes cryptographiques SRI pour empêcher toute falsification. Cela garantit que le code tiers ne peut pas être modifié sans détection :</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Bibliothèque</th>
                    <th>Version</th>
                    <th>Hash SRI (SHA-384)</th>
                  </tr>
                </thead>
                <tbody class="font-monospace small">
                  <tr>
                    <td>qrcode-generator</td>
                    <td>1.4.4</td>
                    <td class="text-break">sha384-lQXOAyZwHXE55JFyr...TcIwz</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Les hashes SRI complets peuvent être vérifiés dans notre <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">code source</a>.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Politique de Sécurité du Contenu (CSP)</h3>
            <p>Nous mettons en œuvre des politiques de sécurité du contenu strictes pour prévenir les attaques XSS et l'exécution de code non autorisée :</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Exécution de scripts basée sur nonce (empêche l'injection de scripts inline)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Chargement restreint des ressources externes (uniquement depuis des CDN de confiance)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Intégration de frames complètement désactivée (protection contre le clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Exécution d'objets et de plugins bloquée</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 En-têtes de Sécurité Supplémentaires</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Empêche les attaques par intégration d'iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Empêche le reniflage de type MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limite les fuites d'informations de référent</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Force les connexions HTTPS avec préchargement</li>
              <li><strong>Permissions-Policy</strong> - Désactive les fonctionnalités inutiles du navigateur (géolocalisation, caméra, microphone, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Zéro Dépendance Externe pour le Traitement des Données</h3>
            <p>Toutes les fonctions principales de traitement des données utilisent uniquement les API natives du navigateur. Les bibliothèques externes ne sont utilisées que pour les composants d'interface utilisateur (rendu de code QR) et sont chargées avec vérification SRI.</p>

            <h2 class="h5 mb-3 mt-4">4. Hébergement et fichiers journaux du serveur</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Description et étendue du traitement des données</h3>
            <p>Ce site web est hébergé par un prestataire de services externe. Si vous utilisez notre site web à des fins purement informatives (c'est-à-dire sans inscription ni autre transmission d'informations), nous ne collectons que les données personnelles que votre navigateur transmet à notre serveur. Si vous souhaitez consulter notre site web, nous collectons les données suivantes :</p>
            <ul>
              <li>Adresse IP</li>
              <li>Fournisseur d'accès Internet de l'utilisateur</li>
              <li>Date et heure de l'accès</li>
              <li>Type de navigateur</li>
              <li>Langue et version du navigateur</li>
              <li>Contenu de la consultation</li>
              <li>Fuseau horaire</li>
              <li>Statut d'accès/code de statut HTTP</li>
              <li>Volume de données</li>
              <li>Sites Web d'où provient la demande (URL de référence)</li>
              <li>Système d'exploitation</li>
            </ul>
            <p>Ces données ne sont pas enregistrées avec d'autres données à caractère personnel vous concernant.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Finalité du traitement</h3>
            <p>Ces données sont utilisées dans le but de vous fournir un site web convivial, fonctionnel et sécurisé, avec des fonctionnalités et des contenus, ainsi que pour leur optimisation et leur évaluation statistique. Les données sont utilisées exclusivement pour le fonctionnement technique et la sécurité du site web.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Base juridique</h3>
            <p>La base juridique est notre intérêt légitime au traitement des données conformément à l'art. 6, al. 1, phrase 1, let. f) du RGPD, qui correspond également aux finalités susmentionnées.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Durée de conservation</h3>
            <p>Pour des raisons de sécurité, nous conservons ces données dans des fichiers journaux du serveur pendant une durée de 60 jours. Passé ce délai, elles sont automatiquement supprimées, sauf si nous devons les conserver à des fins de preuve en cas d'attaques contre l'infrastructure du serveur ou d'autres violations de la loi. Les données ne sont pas fusionnées avec d'autres sources de données.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookies utilisés</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Informations générales sur les cookies</h3>
            <p>Nous utilisons des cookies lorsque vous visitez notre site Web. Les cookies sont de petits fichiers texte que votre navigateur Internet enregistre et stocke sur votre ordinateur. Lorsque vous consultez à nouveau notre site Web, ces cookies transmettent des informations afin de vous reconnaître automatiquement. Les cookies comprennent également les « identifiants utilisateur », qui permettent d'enregistrer les informations des utilisateurs à l'aide de profils pseudonymisés. Lorsque vous consultez notre site Web, nous vous informons de l'utilisation des cookies aux fins susmentionnées et de la manière dont vous pouvez vous y opposer ou empêcher leur enregistrement (« opt-out ») au moyen d'une référence à notre politique de confidentialité.</p>
            
            <p>On distingue les types de cookies suivants :</p>
            <ul>
              <li><strong>Cookies nécessaires et essentiels :</strong> les cookies essentiels sont des cookies qui sont absolument nécessaires au fonctionnement du site web afin d'enregistrer certaines fonctions du site web telles que les connexions, le panier d'achat ou les saisies de l'utilisateur, par exemple en ce qui concerne la langue du site web.</li>
              <li><strong>Cookies de session :</strong> les cookies de session sont nécessaires pour reconnaître l'utilisation multiple d'une offre par le même utilisateur (par exemple, lorsque vous vous êtes connecté pour déterminer votre statut de connexion). Lorsque vous consultez à nouveau notre site, ces cookies fournissent des informations permettant de vous reconnaître automatiquement. Les informations ainsi obtenues servent à optimiser nos offres et à vous faciliter l'accès à notre site. Lorsque vous fermez votre navigateur ou que vous vous déconnectez, les cookies de session sont supprimés.</li>
              <li><strong>Cookies persistants :</strong> ces cookies restent enregistrés même après la fermeture du navigateur. Ils servent à enregistrer la connexion, à mesurer l'audience et à des fins de marketing. Ils sont automatiquement supprimés après une durée prédéfinie, qui peut varier en fonction du cookie. Vous pouvez supprimer les cookies à tout moment dans les paramètres de sécurité de votre navigateur.</li>
              <li><strong>Cookies tiers (cookies tiers, en particulier ceux des annonceurs) :</strong> vous pouvez configurer les paramètres de votre navigateur selon vos préférences et, par exemple, refuser les cookies tiers ou tous les cookies. Nous attirons toutefois votre attention sur le fait que vous ne pourrez alors peut-être pas utiliser toutes les fonctionnalités de ce site web. Pour plus d'informations sur ces cookies, veuillez consulter les déclarations de confidentialité des fournisseurs tiers concernés.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Catégories de données</h3>
            <p>Données utilisateur, cookies, identifiant utilisateur (notamment les pages visitées, les informations sur l'appareil, les heures d'accès et les adresses IP).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Finalités du traitement</h3>
            <p>Les informations ainsi obtenues servent à optimiser nos offres web sur le plan technique et économique et à vous permettre un accès plus facile et plus sûr à notre site web.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Bases juridiques</h3>
            <p>Si nous traitons vos données à caractère personnel à l'aide de cookies sur la base de votre consentement (« opt-in »), la base juridique est l'art. 6, al. 1, phrase 1, let. a) du RGPD. Dans le cas contraire, nous avons un intérêt légitime à garantir le bon fonctionnement, l'amélioration et l'exploitation économique du site web, de sorte que l'article 6, paragraphe 1, phrase 1, point f) du RGPD constitue la base juridique. L'article 6, paragraphe 1, phrase 1, point b) du RGPD constitue également la base juridique lorsque les cookies sont utilisés pour la préparation d'un contrat, par exemple dans le cas de commandes.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Durée de conservation / suppression</h3>
            <p>Les données sont supprimées dès qu'elles ne sont plus nécessaires à la réalisation de l'objectif pour lequel elles ont été collectées. Dans le cas de la collecte de données pour la mise à disposition du site web, c'est le cas lorsque la session correspondante est terminée.</p>
            <p>Sinon, les cookies sont stockés sur votre ordinateur et transmis à notre site. En tant qu'utilisateur, vous avez donc un contrôle total sur l'utilisation des cookies. Vous pouvez désactiver ou limiter la transmission de cookies en modifiant les paramètres de votre navigateur Internet. Les cookies déjà enregistrés peuvent être supprimés à tout moment. Cela peut également se faire de manière automatisée. Si les cookies sont désactivés pour notre site web, il est possible que toutes les fonctions du site web ne puissent plus être utilisées dans leur intégralité.</p>
            <p>Vous trouverez ici des informations sur la suppression des cookies selon les navigateurs :</p>
            <ul>
              <li>Chrome : <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari : <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox : <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer : <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge : <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Opposition et « opt-out »</h3>
            <p>Vous pouvez empêcher de manière générale l'enregistrement de cookies sur votre disque dur, indépendamment de votre consentement ou de l'autorisation légale, en sélectionnant « ne pas accepter les cookies » dans les paramètres de votre navigateur. Cela peut toutefois entraîner une restriction des fonctionnalités de nos offres. Vous pouvez vous opposer à l'utilisation de cookies tiers à des fins publicitaires via un « opt-out » sur ce site web américain (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) ou ce site web européen (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>).</p>

            <h3 class="h6 mb-2 mt-3">Cookie de préférence linguistique (nécessaire d'un point de vue technique)</h3>
            <p>Nous utilisons un seul cookie pour enregistrer votre préférence linguistique :</p>
            <ul>
              <li><strong>Nom du cookie :</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Objectif :</strong> enregistre la langue que vous avez sélectionnée pour l'interface (par exemple « en », « de », « pt »)</li>
              <li><strong>Validité :</strong> 30 jours</li>
              <li><strong>Données enregistrées :</strong> uniquement un code de langue à deux lettres</li>
              <li><strong>Type :</strong> techniquement nécessaire (permet la fonctionnalité de base de préférence linguistique)</li>
            </ul>
            <p>Ce cookie ne contient aucune information personnelle et est utilisé exclusivement pour vous fournir du contenu dans votre langue préférée. Vous pouvez supprimer ce cookie à tout moment via les paramètres de votre navigateur.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Introduction</h3>
            <p>Nous avons intégré des publicités du service Google « Adsense » (prestataire de services : Google Ireland Limited, n° d'enregistrement : 368047, Gordon House, Barrow Street, Dublin 4, Irlande) sur notre site web. Les publicités sont identifiées par la mention « Annonces Google » dans chaque annonce.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Catégories de données et description du traitement des données</h3>
            <p>Données d'utilisation/données de communication ; lorsque vous visitez notre site web, Google reçoit l'information que vous avez consulté notre site web. Pour ce faire, Google place une balise web ou un cookie sur votre ordinateur. Les données sont également transférées aux États-Unis et y sont analysées. Si vous êtes connecté à un compte Google, Adsense peut attribuer les données à votre compte. Si vous ne le souhaitez pas, vous devez vous déconnecter avant de visiter notre site web. Mais d'autres informations peuvent également être utilisées à cette fin par Google :</p>
            <ul>
              <li>le type de sites web que vous visitez et les applications mobiles installées sur votre appareil ;</li>
              <li>les cookies dans votre navigateur et les paramètres de votre compte Google ;</li>
              <li>les sites web et les applications que vous avez visités ;</li>
              <li>vos activités sur d'autres appareils ;</li>
              <li>les interactions précédentes avec les annonces ou les services publicitaires de Google ;</li>
              <li>les activités et informations de votre compte Google.</li>
            </ul>
            <p>Lorsque vous cliquez sur une annonce Adsense, l'adresse IP de l'utilisateur est traitée par Google (données d'utilisation), le traitement étant pseudonymisé (ce que l'on appelle « identifiant publicitaire ») en raccourcissant l'adresse IP des deux derniers chiffres. Dans le cadre de la publicité personnalisée, Google ne relie pas les identifiants provenant de cookies ou de technologies similaires à des catégories particulières de données à caractère personnel au sens de l'article 9 du RGPD, telles que l'origine ethnique, la religion, l'orientation sexuelle ou la santé.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Finalité du traitement</h3>
            <p>Nous avons activé les annonces personnalisées afin de vous proposer des publicités plus intéressantes qui favorisent l'utilisation commerciale de notre site web, augmentent sa valeur pour nous et améliorent votre expérience utilisateur. Grâce à la publicité personnalisée, nous pouvons atteindre les utilisateurs via Adsense en fonction de leurs intérêts et de leurs caractéristiques démographiques (par exemple, les « amateurs de sport »). En outre, le traitement sert au suivi, au remarketing et à la mesure de la conversion, ainsi qu'au financement de notre offre web.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Bases juridiques</h3>
            <p>Si vous avez donné votre consentement (« opt-in ») au traitement de vos données à caractère personnel au moyen de « Google Adsense avec annonces personnalisées », la base juridique est l'art. 6, al. 1, phrase 1, let. a) du RGPD. Sinon, la base juridique pour le traitement de vos données est l'art. 6, al. 1, phrase 1, let. f) du RGPD en raison de nos intérêts légitimes dans l'analyse, l'optimisation et l'exploitation économique efficace de notre publicité et de notre site web.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Transfert de données/catégorie de destinataires</h3>
            <p>Google Irlande, États-Unis ; ce site web a également activé les annonces Google AdSense de fournisseurs tiers. Les données susmentionnées peuvent également être transmises à ces fournisseurs tiers « Certified External Vendors » désignés sur <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a>.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Durée de conservation</h3>
            <p>Les données sont conservées jusqu'à 24 mois après la dernière visite.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Possibilités d'opposition et de suppression (« opt-out »)</h3>
            <p>Vous pouvez vous opposer à l'installation de cookies par Google Adsense de différentes manières ou l'empêcher :</p>
            <ul>
              <li>Vous pouvez empêcher les cookies dans votre navigateur en sélectionnant le paramètre « ne pas accepter les cookies », ce qui inclut également les cookies de tiers ;</li>
              <li>Vous pouvez désactiver les annonces personnalisées sur Google directement via le lien <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a>, mais ce paramètre ne restera actif que jusqu'à ce que vous supprimiez vos cookies. Pour désactiver la publicité personnalisée sur les appareils mobiles, vous trouverez des instructions ici : <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a> ;</li>
              <li>Vous pouvez désactiver les publicités personnalisées des fournisseurs tiers qui participent à l'initiative d'autorégulation publicitaire « About Ads » via le lien <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> pour les sites américains ou via le lien <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> pour les sites européens. Ce paramètre ne restera toutefois actif que jusqu'à ce que vous supprimiez tous vos cookies ;</li>
              <li>Vous pouvez désactiver définitivement les cookies à l'aide d'un plug-in de navigateur pour Chrome, Firefox ou Internet Explorer via le lien <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a>. Cette désactivation peut avoir pour conséquence que vous ne puissiez plus utiliser toutes les fonctionnalités de notre site web dans leur intégralité.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Informations complémentaires</h3>
            <p>Vous trouverez de plus amples informations sur l'utilisation des cookies Google dans les annonces et leurs technologies publicitaires, la durée de conservation, l'anonymisation, les données de localisation, le fonctionnement et vos droits dans la déclaration de confidentialité relative à la publicité de Google à l'adresse <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a>.</p>

            <h2 class="h5 mb-3 mt-4">7. Prise de contact par e-mail / courrier postal</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Description et étendue du traitement des données</h3>
            <p>Lorsque vous nous contactez par courrier postal ou par e-mail, vos données sont traitées dans le but de traiter votre demande de contact.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Base juridique</h3>
            <p>La base juridique du traitement des données est l'article 6, paragraphe 1, phrase 1, point a) du RGPD, si vous avez donné votre consentement. La base juridique du traitement des données transmises dans le cadre d'une demande de contact, d'un e-mail ou d'une lettre est l'article 6, paragraphe 1, phrase 1, point f) du RGPD. Le responsable du traitement a un intérêt légitime à traiter et à stocker les données afin de pouvoir répondre aux demandes des utilisateurs, de conserver des preuves pour des raisons de responsabilité et, le cas échéant, de pouvoir respecter ses obligations légales de conservation des lettres commerciales. Si le contact vise à la conclusion d'un contrat, la base juridique supplémentaire pour le traitement est l'art. 6, al. 1, phrase 1, let. b) du RGPD.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Stockage dans le système CRM</h3>
            <p>Nous pouvons stocker vos informations et votre demande de contact dans notre système de gestion de la relation client (« système CRM ») ou dans un système similaire.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Durée de conservation</h3>
            <p>Les données sont supprimées dès qu'elles ne sont plus nécessaires à la réalisation de l'objectif pour lequel elles ont été collectées. Pour les données à caractère personnel envoyées par e-mail, c'est le cas lorsque la conversation avec vous est terminée. La conversation est terminée lorsqu'il ressort des circonstances que le sujet concerné a été définitivement clarifié. Nous conservons les demandes des utilisateurs qui disposent d'un compte ou d'un contrat avec nous pendant deux ans après la fin du contrat. En cas d'obligations légales d'archivage, la suppression intervient après leur expiration, conformément aux directives européennes et aux réglementations nationales en matière de conservation.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Possibilité d'opposition et de suppression</h3>
            <p>Vous avez à tout moment la possibilité de révoquer votre consentement au traitement des données à caractère personnel conformément à l'art. 6, al. 1, phrase 1, let. a) du RGPD. Si vous nous contactez par e-mail, vous pouvez à tout moment vous opposer à l'enregistrement de vos données à caractère personnel.</p>

            <h2 class="h5 mb-3 mt-4">8. Utilisation des outils sous votre propre responsabilité</h2>
            <p><strong>Vous utilisez tous les outils de ce site web sous votre propre responsabilité.</strong> Bien que nous nous efforcions de fournir des outils précis et fiables, nous ne pouvons garantir qu'ils soient exempts d'erreurs ou adaptés à tous les usages.</p>
            <p>Nous déclinons toute responsabilité pour :</p>
            <ul>
              <li>les erreurs, inexactitudes ou dysfonctionnements des outils</li>
              <li>les pertes de données ou dommages résultant de l'utilisation des outils</li>
              <li>les décisions prises sur la base des résultats générés par nos outils</li>
            </ul>
            <p>Veuillez vérifier de manière indépendante les résultats critiques avant de les utiliser dans des environnements de production.</p>

            <h2 class="h5 mb-3 mt-4">9. Vos droits</h2>
            <p>Vous disposez des droits suivants conformément au RGPD :</p>
            <ul>
              <li><strong>Droit d'accès (art. 15 du RGPD) :</strong> vous avez le droit de demander des informations sur vos données à caractère personnel que nous traitons.</li>
              <li><strong>Droit de rectification (art. 16 du RGPD) :</strong> vous avez le droit d'exiger la rectification immédiate des données à caractère personnel inexactes ou l'intégration des données à caractère personnel incomplètes.</li>
              <li><strong>Droit à l'effacement (art. 17 du RGPD) :</strong> vous avez le droit d'exiger l'effacement de vos données à caractère personnel.</li>
              <li><strong>Limitation du traitement (art. 18 RGPD) :</strong> vous avez le droit d'exiger la limitation du traitement de vos données à caractère personnel.</li>
              <li><strong>Portabilité des données (art. 20 RGPD) :</strong> vous avez le droit de recevoir vos données à caractère personnel dans un format structuré, couramment utilisé et lisible par machine.</li>
              <li><strong>Droit d'opposition (art. 21 du RGPD) :</strong> vous avez le droit de vous opposer à tout moment au traitement des données à caractère personnel vous concernant pour des raisons liées à votre situation particulière.</li>
              <li><strong>Retrait du consentement (art. 7, al. 3 du RGPD) :</strong> vous avez le droit de retirer à tout moment le consentement que vous avez donné.</li>
              <li><strong>Droit de recours (art. 77 du RGPD) :</strong> vous avez le droit d'introduire une réclamation auprès d'une autorité de contrôle.</li>
            </ul>
            <p>Pour toute question relative à la protection des données, veuillez nous contacter aux coordonnées indiquées dans les mentions légales.</p>

          </div>
        </div>

    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
