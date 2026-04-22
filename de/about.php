<?php

/**
 * About Page (German)
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

$lang = 'de';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/de';
$homeUrl = BASE_PATH . '/de';
$pageTitle = 'Über WebDev-Tools – Datenschutzfreundliche Entwickler-Utilities';
$pageDescription = 'Erfahren Sie mehr über WebDev-Tools, eine Sammlung kostenloser, datenschutzfreundlicher Entwickler-Utilities, entwickelt mit Leidenschaft von Ramon Kaes.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/about.php');
$currentUrl = getFullUrl('/about.php', $lang);
?>
<!DOCTYPE html>
<html lang="de" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="keywords" content="WebDev-Tools, Über, Ramon Kaes, Entwickler-Tools, Datenschutzfreundlich">
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
  <meta property="og:locale" content="de_DE">
  <meta property="og:locale:alternate" content="en_US">
  <meta property="og:locale:alternate" content="es_ES">
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
          <h1 class="display-5 mb-3">Über WebDev Tools</h1>
          <p class="lead text-secondary">
            Die 10.000ste Toolsammlung – ein Unfallbericht
          </p>
          
          <!-- Standards-Konformitäts-Badges -->
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
              <i class="bi bi-lock-fill me-1"></i>Nur Client-seitig
            </span>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4 fs-6">
            <p>
              Ja, ich weiß. Die zehntausendste Toolsammlung im Internet. Wer braucht die
              schon? Aber ich kann euch beruhigen: Dieses Projekt war nie geplant. Es ist
              ein Unfall, ein Produkt purer Prokrastination, aber auch eine Lektion im
              Umgang mit künstlicher Intelligenz.
            </p>
            <p>
              Alles begann ganz harmlos auf meinem Desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Am Anfang war das Skript.
            </h2>
            <p>
              Wie viele Entwickler hatte auch ich diverse Eigenbau-Tools auf meinem
              Localhost gebunkert. Kleine Skripte für alltägliche Ärgernisse: eine
              Em/Px-Umrechnung hier, ein kleiner Helfer dort. Dinge, für die ich zu faul
              war, um jedes Mal die gleichen Websites zu suchen. Mit Lesezeichen stehe
              ich nämlich auf absolutem Kriegsfuß.
            </p>
            <p class="mb-5">
              Diese Helferlein taten brav ihren Dienst. Doch dann fügte ich zwei weitere
              hinzu und mein Webentwickler-Instinkt schlug gnadenlos zu: Ich begann, die
              Dinger zu verknüpfen. Ein Menü musste her. Ein bisschen Styling. Und
              plötzlich war ich mittendrin in allem, was einem so einfällt, wenn man
              sich erfolgreich von der eigentlichen Arbeit ablenken möchte. Aus der
              simplen Sammlung wurde ein ausgewachsenes Projekt. Ich musste es einfach
              "pimpen", bis eine richtige kleine Website mit allem Drum und Dran vor mir
              stand.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              „KI, übernimm mal!“ – war das eine Schnapsidee?
            </h2>
            <p>
              Irgendwann kam mir der Gedanke: Es sind ja nur einfache Skripte. Lass das
              doch mal die KI erledigen! Als treuer Nutzer von VS Code habe ich das
              Projekt direkt mit Claude Code (Sonnet) aufgesetzt.
            </p>
            <p>
              Doch bevor die KI freie Hand bekam, mussten klare Leitplanken her. Ich
              definierte also zuallererst einen festen Techstack. Aus diesem leitete ich
              eine <code>CLAUDE.md</code> (strikt limitiert auf maximal 60 Zeilen – kurze
              Befehlswege sind bei KIs das A und O) sowie eine <code>.claude/comments/review.md</code>
              ab. Genauso überlebenswichtig für den eigenen Geldbeutel sind eine
              konsequente <code>.claudeignore</code> und eine gezielt angepasste
              <code>.claude/settings.local.json</code>, um beim Coden massiv Tokens zu sparen.
            </p>
            <p class="mb-5">
              Das Ergebnis war überraschend: eine erstaunlich gute, modular erweiterbare
              Webanwendung. Aber natürlich lief nicht alles reibungslos. Man muss eine
              KI permanent davon abhalten, zu übertreiben. Mein wichtigstes Kommando
              wurde schnell: „Nein, wir brauchen keinen Paketmanager! Und jetzt hör auf,
              mir schon wieder ein Framework vorschlagen zu wollen!” Am Ende kam aber
              tatsächlich ein brauchbares Grundgerüst heraus.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Die Tücken des „Vibe Coding“
            </h2>
            <p>
              Das Projekt nahm Fahrt auf und ich lernte schnell einige harte Lektionen
              über die Zusammenarbeit mit meinen digitalen Kollegen.
            </p>
            <ul class="mb-5">
              <li>
                Die Framework-Frage: KIs lieben Tailwind. Nach einigen manuellen
                Anpassungen, bei denen mein Geduldsfaden gefährlich dünn wurde, riss er
                schließlich. Ich bin daraufhin auf Bootstrap umgestiegen, um die Sache
                pragmatisch zu Ende zu bringen. Manchmal ist „fertig“ einfach besser als
                „perfekt“ (oder Tailwind).
              </li><br>
              <li>
                Ohne Git? Ohne mich! Aus Gewohnheit habe ich direkt ein Repo angelegt.
                Zum Glück! Ich merkte schnell, dass dieses planlose „Vibe Coding“ ohne
                Versionskontrolle in einer massiven Zeitverschwendung endet.
              </li><br>
              <li>
                KI-Logik vs. Realität: KIs machen sich das Leben manchmal zu leicht –
                oder zu kompliziert. Zwar hat sich Claude hier massiv verbessert und
                analysiert Code mittlerweile deutlich fundierter statt blind zu
                spekulieren. Wenn man jedoch nicht präzise vorgibt, wohin die Reise gehen
                soll, neigen KIs immer noch zu eigenwilligen Skript-Lösungen, die in
                einer Sackgasse enden. Ohne ein beherztes „git reset --hard” hätte ich
                das Projekt wohl trotzdem mehr als einmal komplett neu starten müssen.
              </li><br>
              <li>
                KI-Ping-Pong beim Code-Review: Bei der Qualitätssicherung habe ich auf
                ein System aus „Checks and Balances” gesetzt. Über den Befehl /review
                triggere ich Claudes interne Prüfung, die strikt nach den Vorgaben in
                meiner review.md arbeitet. Ergänzend dazu habe ich externe Reviews von
                ChatGPT und Gemini durchführen lassen und die Ergebnisse abschließend mit
                Claude Opus diskutiert. Dieses „KI-Review für das KI-Review“ ist zwar
                ziemlich meta, aber extrem nützlich, um verschiedene Denkweisen
                gegenzuprüfen und logische Lücken zu schließen.
              </li>
            </ul>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonusrunde: KI als Übersetzer?
            </h2>
            <p>
              Nachdem die Funktionalität stand, waren die Übersetzungen an der Reihe.
              Hier zeigte die KI ihre philosophische Seite: Claude Sonnet 4.5 wies mich
              ungefragt darauf hin, dass es bei Sprachen wie Hindi, Chinesisch oder
              Japanisch nicht nur um Vokabeln, sondern auch um kulturelle Eigenheiten
              und Höflichkeitsformen geht. Das war ein erfrischendes Maß an
              Selbstreflexion.
            </p>
            <p class="mb-5">
              In der Praxis wurde es dann aber doch pragmatisch: Für die eigentliche
              Batch-Übersetzung der statischen Inhalte war mir Claude zu „verkopft” und
              zu kompliziert. Bei Gemini und ChatGPT schwankte die Ausführungsqualität
              zu stark. Am Ende habe ich alles von DeepL übersetzen lassen. Auch hier
              gilt: Das richtige Tool für den richtigen Job!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Vom Intranet ins wilde Web
            </h2>
            <p>
              Nachdem die Toolsammlung fertiggestellt war und sogar mehrere Sprachen
              unterstützte, leistete sie eine ganze Weile gute Dienste in unserem
              Firmennetzwerk. Irgendwann dachte ich mir: Warum eigentlich nicht teilen?
            </p>
            <p>
              Also habe ich aufgeräumt und die Seite öffentlich gemacht. Und weil das
              Ganze ja ohnehin aus einem „Unfall“ entstanden ist, liegt der Code komplett
              offen. Wer mitbasteln will oder einen Fehler findet: Das Git-Repo findet
              ihr hier:
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository von WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Ja, sorry. Jetzt ist sie also da, die 10.000ste Toolsammlung. Die
              10.000ste Toolsammlung. Aber hey, immerhin hat sie eine gute
              Entstehungsgeschichte!
            </p>
            <p>Viel Spaß damit!</p>
            <p>Ramon</p>
            <div class="text-center">
              <img src="../assets/img/Ramon-Kaes-Logo.svg" alt="Ramon Kaes Logo" title="Ramon Kaes" width="36" height="36" class="mb-0 navbar-brand">
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <small class="text-muted">
            <a href="https://www.deepl.com" target="_blank" rel="noopener noreferrer" title="Kostenloser Online-Übersetzungsdienst" class="text-decoration-none text-muted">Übersetzt mit deepl.com (kostenlose Version)</a>
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
