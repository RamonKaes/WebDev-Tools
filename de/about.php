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

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'de';
$currentTool = 'about';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/de';
$homeUrl = BASE_PATH . '/de';
$pageTitle = 'Über WebDev-Tools – Kostenlose Entwickler-Utilities';
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
          <h1 class="display-5 mb-3">Über WebDev Tools</h1>
          <p class="lead text-secondary">
            Vom lokalen Script zur (ja, der 10.000sten) Tool-Sammlung: Eine Chronik des
            Zufalls
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
              Ja, ich weiß. Die 10.000ste Toolsammlung im Internet. Wer braucht die schon?
              Aber ich kann euch beruhigen: Dieses Projekt war nie geplant. Es ist ein Unfall,
              ein Produkt der Prokrastination und eine Lektion im Umgang mit künstlicher
              Intelligenz.
            </p>
            <p>
              Alles begann ganz harmlos auf meinem Desktop.
            </p>

            <h2 class="h5 card-title mb-3 mt-4">
              <i class="bi bi-laptop text-primary me-2"></i>
              Am Anfang war das Skript.
            </h2>
            <p>
              Wie viele Entwickler hatte auch ich einige eigene Tools auf meinem Localhost
              gespeichert. Kleine Skripte für alltägliche Ärgernisse – eine Em/Px-Umrechnung
              hier, ein kleiner Helfer dort. Dinge, für die ich zu faul war, immer wieder die
              gleichen Websites zu suchen und aufzurufen. Mit Lesezeichen stehe ich nämlich
              auf absolutem Kriegsfuß.
            </p>
            <p>
              Diese kleinen Helferlein taten ihren Dienst. Doch dann fügte ich zwei weitere
              hinzu. Und dann passierte es: Mein Webentwickler-Instinkt schlug zu.
            </p>
            <p class="mb-5">
              Instinktiv begann ich, die Dinger miteinander zu verknüpfen. Ein Menü musste
              her. Und ein bisschen Styling. Und alles, was einem sonst noch so in den Sinn
              kommt, wenn man sich erfolgreich von der eigentlichen Arbeit ablenken möchte. So
              wurde aus einer einfachen Scriptsammlung ein ausgewachsenes Projekt. Ich musste
              es einfach „pimpen”, bis ich eine richtige kleine Website mit allem Drum und
              Dran fertig hatte.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-robot text-primary me-2"></i>
              „KI, übernimm mal!” – Eine Schnapsidee?
            </h2>
            <p>
              Irgendwann kam mir der Gedanke: Es sind ja nur einfache Skripte. Lass das doch
              mal die KI machen! Als treuer Nutzer von <a href="https://code.visualstudio.com/" target="_blank" rel="noopener noreferrer" title="Visual Studio Code - Kostenloser Code-Editor">VS Code</a> habe ich das Projekt direkt mit
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI von Anthropic">Claude Sonnet 4.5</a> (im <a href="https://github.com/features/copilot" target="_blank" rel="noopener noreferrer" title="GitHub Copilot - KI-Programmierhilfe">GitHub CoPilot</a>) aufgesetzt.
            </p>
            <p>
              Ich war überrascht, denn das Ergebnis war eine erstaunlich gute, modular
              erweiterbare Webanwendung.
            </p>
            <p>
              Natürlich war es nicht so einfach. Man muss die KI permanent davon abhalten, zu
              übertreiben. Mein wichtigstes Kommando wurde schnell: „Nein, wir brauchen keinen
              Paketmanager! Und jetzt hör auf, mir noch ein Framework vorschlagen zu wollen!”
            </p>
            <p class="mb-5">
              Am Ende kam aber tatsächlich ein brauchbares Grundgerüst heraus.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-tools text-primary me-2"></i>
              Die Tücken des „Vibe Coding” mit KI
            </h2>
            <p>
              Das Projekt nahm Fahrt auf und ich lernte schnell ein paar harte Lektionen über
              die Zusammenarbeit mit meinen neuen digitalen Kollegen.
            </p>
            <p>
              Die Framework-Frage: KIs arbeiten vorzugsweise mit <a href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer" title="Tailwind CSS - Utility-First CSS-Framework">Tailwind</a>. Das taten sie auch
              hier. Nach einigen manuellen Anpassungen, bei denen mein Geduldsfaden immer
              dünner wurde, riss er schließlich. Ich bin kurzerhand auf <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" title="Bootstrap - Front-End-Framework">Bootstrap</a> umgestiegen,
              um die Sammlung schnell und pragmatisch zu einem Ende zu führen. Manchmal ist
              „fertig" einfach besser als „perfekt" (oder „Tailwind").
            </p>
            <p>
              2. Ohne <a href="https://git-scm.com/book/de/v2" target="_blank" rel="noopener noreferrer" title="Git - Verteilte Versionsverwaltung">Git</a>? Ohne mich! Aus reiner Gewohnheit habe ich direkt ein <a href="https://git-scm.com/book/de/v2/Git-Grundlagen-Ein-Git-Repository-anlegen" target="_blank" rel="noopener noreferrer" title="Git-Repository - Grundlagen der Versionsverwaltung">Git-Repository</a>
              angelegt. Zum Glück! Ich habe schnell gemerkt, dass das, was ich da tat – dieses
              planlose „Vibe Coding" mit der KI – ohne Git zu einer erheblichen
              Zeitverschwendung führt.
            </p>
            <p>
              3. Die Tücken der KI-Logik: Das größte Problem ist, dass KIs sich das Leben
              gerne leicht machen, aber auf die falsche Art.
            </p>
            <ul>
              <li>
                Sie spekulieren: Anstatt zu analysieren, was man eigentlich vorhat, raten sie
                oft wild drauf los. Dieses Spekulieren muss man ganz schnell unterbinden und
                ihnen jeden Schritt präzise vorgeben, sonst endet es im Chaos.
              <li>
                Sie lieben eigene Scripts. Sie neigen dazu, eigene Skripte oder Lösungen
                vorzuschlagen, die oft zu verheerenden Ergebnissen führen. In nicht wenigen
                Fällen wäre dadurch ein kompletter Neustart des Projekts erforderlich gewesen,
                wäre da nicht ein beherztes „git reset --hard” möglich gewesen.
              </li>
            </ul>
            </p>
            <p class="mb-5">
              4. KI-Ping-Pong bei Code-Reviews
              Auch bei der Qualitätssicherung habe ich auf die KIs gesetzt, aber mit System:
              Zunächst habe ich die Code-Reviews von <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Fortgeschrittenes KI-Modell">GPT-5 Codex</a> durchführen lassen und
              anschließend die Meinung von <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI von Anthropic">Claude Sonnet 4.5</a> dazu eingeholt. Ein KI-Review für
              das KI-Review sozusagen. Das ist ziemlich meta, aber extrem nützlich, um
              verschiedene „Denkweisen" gegenzuprüfen.
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-globe-europe-africa text-primary me-2"></i>
              Bonusrunde: KI als Übersetzer?
            </h2>
            <p>
              Nachdem die Funktionalität stand, dachte ich an Übersetzungen. Zuerst durfte
              <a href="https://www.anthropic.com/claude" target="_blank" rel="noopener noreferrer" title="Claude AI von Anthropic">Claude Sonnet 4.5</a> ran. Laut eigener Aussage beherrscht die KI Englisch und
              Deutsch auf Muttersprachniveau und liefert bei Spanisch, Französisch,
              Italienisch und Portugiesisch eine Sicherheit von 98 %.
            </p>
            <p>
              Es wurde interessant, als ich nach Hindi, Chinesisch oder Japanisch fragte. Hier
              gab die KI zu, dass sie hierfür externe Hilfe wie <a href="https://www.deepl.com/de/translator" target="_blank" rel="noopener noreferrer" title="DeepL - KI-Übersetzungsdienst">DeepL</a> benötigt. Noch wichtiger
              ist, dass sie von sich aus darauf hinwies, dass es nicht nur um eine plumpe
              Übersetzung geht, sondern dass auch kulturelle Eigenheiten und
              Höflichkeitsformen beachtet werden müssen.
            </p>
            <p class="mb-5">
              Ein erfrischendes Maß an Selbstreflexion. Für die eigentliche Batch-Übersetzung
              des statischen, hardcodierten Teils der romanischen Sprachen war mir Claude dann
              aber doch zu verkopft. Ich habe das stattdessen von <a href="https://openai.com/index/openai-o1/" target="_blank" rel="noopener noreferrer" title="OpenAI o1 - Fortgeschrittenes KI-Modell">GPT-5-Codex</a> erledigen
              lassen. Auch hier gilt: Das richtige Tool für den richtigen Job!
            </p>

            <h2 class="h5 card-title mb-3">
              <i class="bi bi-rocket-takeoff text-primary me-2"></i>
              Vom Intranet ins wilde Web
            </h2>
            <p>
              Nachdem die Toolsammlung so weit gediehen war (und sogar mehrere Sprachen
              sprach), stand sie eine ganze Weile nur bei uns im Firmennetzwerk zur Verfügung
              und leistete gute Dienste.
            </p>
            <p>
              Irgendwann dachte ich mir: Warum eigentlich nicht? Also habe ich sie aufgeräumt
              und öffentlich gemacht.
            </p>
            <p>
              Und weil das Ganze ja eh aus einem „Unfall” entstanden ist, liegt der Code komplett offen. Wer selbst mitbasteln will oder einen Fehler findet: Das Git-Repo findet ihr hier: <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository von WebDev-Tools">https://github.com/RamonKaes/WebDev-Tools</a>.
            </p>
            <p>
              Ja, sorry. Jetzt ist sie hier. Die 10.000ste Toolsammlung. Aber hey, immerhin
              hat sie eine Entstehungsgeschichte! :D
            </p>
            <p>
              Viel Spaß damit!
            </p>
            <p class="mb-0">Ramon</p>
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