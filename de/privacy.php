<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'de';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/de';
$homeUrl = BASE_PATH . '/de';
$pageTitle = 'Datenschutz – Datenschutzerklärung WebDev-Tools Online Tools';
$pageDescription = 'Datenschutzerklärung und Informationen zum Datenschutz für WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
?>
<!DOCTYPE html>
<html lang="de" data-bs-theme="auto">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="noindex, follow">
  <meta name="googlebot" content="noindex, follow">
  <meta name="theme-color" content="#066fd1">
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
  <meta name="apple-mobile-web-app-title" content="WebDev-Tools" />
  <link rel="manifest" href="<?= BASE_PATH . getLangPrefix($lang) ?>/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= assetSrc('css/style.css') ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>
<body class="d-flex flex-column bg-body">

<?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main id="main-content" class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Datenschutzerklärung</h1>
          <p class="lead text-secondary">Ihre Privatsphäre ist uns wichtig</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Datenschutz auf einen Blick</h2>
            
            <h3 class="h6 mb-2">Allgemeine Hinweise</h3>
            <p>Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können.</p>

            <h3 class="h6 mb-2 mt-3">Datenerfassung auf dieser Website</h3>
            <p><strong>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</strong></p>
            <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten können Sie dem Impressum dieser Website entnehmen.</p>
            
            <p><strong>Wie erfassen wir Ihre Daten?</strong></p>
            <p>Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es sich z.B. um Daten handeln, die Sie uns per E-Mail senden.</p>
            <p>Andere Daten werden automatisch oder nach Ihrer Einwilligung beim Besuch der Website durch unsere IT-Systeme erfasst. Das sind vor allem technische Daten (z.B. Internetbrowser, Betriebssystem oder Uhrzeit des Seitenaufrufs). Die Erfassung dieser Daten erfolgt automatisch, sobald Sie diese Website betreten.</p>
            
            <p><strong>Wofür nutzen wir Ihre Daten?</strong></p>
            <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gewährleisten (Server-Log-Dateien, siehe Abschnitt 4). Darüber hinaus laden zwei Tools jeweils eine JavaScript-Bibliothek von einem Content Delivery Network (siehe Abschnitt 3.3). Analyse-, Tracking- oder Werbedienste setzen wir nicht ein.</p>
            
            <p><strong>Welche Rechte haben Sie bezüglich Ihrer Daten?</strong></p>
            <p>Sie haben jederzeit das Recht, unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer gespeicherten personenbezogenen Daten zu erhalten. Sie haben außerdem ein Recht, die Berichtigung oder Löschung dieser Daten zu verlangen. Wenn Sie eine Einwilligung zur Datenverarbeitung erteilt haben, können Sie diese Einwilligung jederzeit für die Zukunft widerrufen. Außerdem haben Sie das Recht, unter bestimmten Umständen die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen. Des Weiteren steht Ihnen ein Beschwerderecht bei der zuständigen Aufsichtsbehörde zu.</p>

            <h2 class="h5 mb-3 mt-4">2. Privacy-First-Ansatz für Tools</h2>
            <p><strong>Alle Tools auf dieser Website verarbeiten Ihre Eingabedaten ausschließlich in Ihrem Browser.</strong> Wenn Sie unsere Tools verwenden (z.B. Base64-Encoder, JSON-Formatter, etc.), gilt folgendes:</p>
            <ul>
              <li>Alle Konvertierungen, Validierungen und Generierungen erfolgen clientseitig in Ihrem Browser</li>
              <li>Ihre Eingabedaten in den Tools verlassen niemals Ihr Gerät</li>
              <li>Wir speichern, protokollieren oder haben keinen Zugriff auf Daten, die Sie mit unseren Tools verarbeiten</li>
              <li>Wir können keine Auskunft über Tool-Eingabedaten erteilen, die wir nicht haben – denn wir sammeln diese nicht</li>
            </ul>
            <p><strong>Wichtiger Hinweis:</strong> Dies bezieht sich ausschließlich auf die Verarbeitung Ihrer Daten <em>innerhalb der Tools</em>. Beim allgemeinen Besuch der Website werden jedoch automatisch technische Daten in Server-Log-Dateien erhoben (siehe Abschnitt 4), und wenn Sie den QR-Code-Generator nutzen oder im Code-Formatter JavaScript minifizieren, wird eine Bibliothek von einem CDN geladen (siehe Abschnitt 3.3).</p>

            <h2 class="h5 mb-3 mt-4">3. Sicherheit & Transparenz</h2>

            <p>Wir implementieren mehrere Sicherheitsebenen, um Ihre Privatsphäre zu schützen und die Integrität unserer Tools zu gewährleisten:</p>

            <h3 class="h6 mb-2 mt-3">3.1 Open Source & Überprüfbarkeit</h3>
            <p>Der vollständige Quellcode ist öffentlich auf GitHub verfügbar. Sie können das Projekt jederzeit überprüfen, auditieren oder forken:</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository von WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Subresource Integrity (SRI)</h3>
            <p>Alle externen Bibliotheken werden mit kryptographischen SRI-Hashes geladen, um Manipulationen zu verhindern. Dies stellt sicher, dass Code von Drittanbietern nicht ohne Erkennung modifiziert werden kann:</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Bibliothek</th>
                    <th>Version</th>
                    <th>SRI Hash (SHA-384)</th>
                  </tr>
                </thead>
                <tbody class="font-monospace small">
                  <tr>
                    <td>qrcode-generator</td>
                    <td>1.4.4</td>
                    <td class="text-break">sha384-lQXOAyZwHXE55JFyr...TcIwz</td>
                  </tr>
                  <tr>
                    <td>terser</td>
                    <td>5.31.0</td>
                    <td class="text-break">sha384-Be6gQ8oRB6kvVWiyo...1v7dX</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Vollständige SRI-Hashes können in unserem Quellcode (<a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">config/tools.php</a> und <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/assets/js/tools/codeFormatterTool.js" target="_blank" rel="noopener noreferrer">codeFormatterTool.js</a>) überprüft werden.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Einbindung von Drittinhalten (CDN)</h3>
            <p>Bootstrap, die Icon-Schriftart und alle übrigen Assets werden auf unserem eigenen Server gehostet. Lediglich zwei Tools laden jeweils eine einzelne JavaScript-Bibliothek vom Content Delivery Network jsDelivr (cdn.jsdelivr.net), betrieben von Prospect One (jsDelivr) und ausgeliefert über mehrere CDN-Anbieter, darunter Cloudflare und Fastly:</p>
            <ul>
              <li><strong>QR-Code-Generator:</strong> lädt <code>qrcode-generator</code> beim Öffnen der Tool-Seite.</li>
              <li><strong>Code-Formatter:</strong> lädt <code>terser</code> nur dann, wenn Sie JavaScript-Code minifizieren.</li>
            </ul>
            <p>Beim Laden einer dieser Bibliotheken baut Ihr Browser eine direkte Verbindung zum CDN auf und übermittelt dabei die technisch erforderlichen Daten, insbesondere Ihre IP-Adresse, Ihren User-Agent und die aufrufende Seite (Referrer). Wir selbst erhalten aus diesem Vorgang keine Daten. Die Bibliotheken sind durch SRI-Hashes geschützt (siehe 3.2) und können daher nicht unbemerkt verändert werden. Darüber hinaus stellt diese Website keine Anfragen an Server Dritter; lediglich der SRI-Generator ruft die Ressourcen-URL ab, die Sie selbst eingeben.</p>
            <p>Rechtsgrundlage ist Art. 6 Abs. 1 S. 1 lit. f) DSGVO; unser berechtigtes Interesse liegt in der zuverlässigen und effizienten Bereitstellung dieser Tools. Weitere Informationen finden Sie in der Datenschutzerklärung von jsDelivr: <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener">https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net</a></p>

            <h3 class="h6 mb-2 mt-3">3.4 Content Security Policy (CSP)</h3>
            <p>Wir implementieren strenge Content Security Policies, um XSS-Angriffe und unbefugte Code-Ausführung zu verhindern:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Nonce-basierte Script-Ausführung (verhindert Inline-Script-Injection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Beschränktes Laden externer Ressourcen (Skripte nur von unserem eigenen Server und cdn.jsdelivr.net)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Frame-Einbettung komplett deaktiviert (Clickjacking-Schutz)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Object- und Plugin-Ausführung blockiert</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Zusätzliche Sicherheits-Header</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Verhindert Iframe-Einbettungsangriffe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Verhindert MIME-Type-Sniffing</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Begrenzt Referrer-Informationslecks</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Erzwingt HTTPS-Verbindungen mit Preload</li>
              <li><strong>Permissions-Policy</strong> - Deaktiviert unnötige Browser-Funktionen (Geolokation, Kamera, Mikrofon, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.6 Keine externen Abhängigkeiten für Datenverarbeitung</h3>
            <p>Alle Kern-Datenverarbeitungsfunktionen nutzen ausschließlich native Browser-APIs. Externe Bibliotheken werden nur für zwei Hilfsfunktionen verwendet (QR-Code-Rendering und JavaScript-Minifizierung) und mit SRI-Verifizierung geladen.</p>

            <h2 class="h5 mb-3 mt-4">4. Hosting & Server-Log-Dateien</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Beschreibung und Umfang der Datenverarbeitung</h3>
            <p>Diese Website wird bei einem externen Dienstleister gehostet. Wenn Sie unsere Webseite lediglich informatorisch nutzen (also keine Registrierung und auch keine anderweitige Übermittlung von Informationen), erheben wir nur die personenbezogenen Daten, die Ihr Browser an unseren Server übermittelt. Wenn Sie unsere Website betrachten möchten, erheben wir die folgenden Daten:</p>
            <ul>
              <li>IP-Adresse</li>
              <li>Internet-Service-Provider des Nutzers</li>
              <li>Datum und Uhrzeit des Zugriffs</li>
              <li>Browsertyp</li>
              <li>Sprache und Browser-Version</li>
              <li>Inhalt des Abrufs</li>
              <li>Zeitzone</li>
              <li>Zugriffsstatus/HTTP-Statuscode</li>
              <li>Datenmenge</li>
              <li>Websites, von denen die Anforderung kommt (Referrer-URL)</li>
              <li>Betriebssystem</li>
            </ul>
            <p>Eine Speicherung dieser Daten zusammen mit anderen personenbezogenen Daten von Ihnen findet nicht statt.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Zweck der Verarbeitung</h3>
            <p>Diese Daten dienen dem Zweck der nutzerfreundlichen, funktionsfähigen und sicheren Auslieferung unserer Website an Sie mit Funktionen und Inhalten sowie deren Optimierung und statistischen Auswertung. Die Daten dienen ausschließlich dem technischen Betrieb und der Sicherheit der Website.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Rechtsgrundlage</h3>
            <p>Rechtsgrundlage hierfür ist unser in den obigen Zwecken auch liegendes berechtigtes Interesse an der Datenverarbeitung nach Art. 6 Abs. 1 S. 1 lit. f) DSGVO.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Speicherdauer</h3>
            <p>Wir speichern aus Sicherheitsgründen diese Daten in Server-Logfiles für die Speicherdauer von 60 Tagen. Nach Ablauf dieser Frist werden diese automatisch gelöscht, es sei denn wir benötigen deren Aufbewahrung zu Beweiszwecken bei Angriffen auf die Serverinfrastruktur oder anderen Rechtsverletzungen. Die Daten werden nicht mit anderen Datenquellen zusammengeführt.</p>

            <h2 class="h5 mb-3 mt-4">5. Verwendete Cookies</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Allgemeine Informationen zu Cookies</h3>
            <p>Cookies sind kleine Textdateien, die Ihr Internet-Browser auf Ihrem Gerät ablegt. Diese Website verwendet <strong>genau ein Cookie</strong>, das technisch notwendig ist. Wir setzen keine Session-, Analyse-, Tracking- oder Drittanbieter-Cookies ein, und es werden keine Nutzerprofile erstellt. Da keine einwilligungsbedürftigen Cookies verwendet werden, wird kein Cookie-Banner angezeigt.</p>

            <h3 class="h6 mb-2 mt-3">5.2 Sprachpräferenz-Cookie (technisch notwendig)</h3>
            <p>Wir verwenden ein einzelnes Cookie, um Ihre Sprachpräferenz zu speichern:</p>
            <ul>
              <li><strong>Cookie-Name:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Zweck:</strong> Speichert Ihre ausgewählte Oberflächensprache (z.B. "en", "de", "pt")</li>
              <li><strong>Gültigkeit:</strong> 30 Tage</li>
              <li><strong>Gespeicherte Daten:</strong> Nur ein zweistelliger Sprachcode</li>
              <li><strong>Art:</strong> Technisch notwendig (ermöglicht grundlegende Sprachpräferenz-Funktionalität)</li>
            </ul>
            <p>Dieses Cookie enthält keine persönlichen Informationen und wird ausschließlich verwendet, um Ihnen Inhalte in Ihrer bevorzugten Sprache bereitzustellen. Sie können dieses Cookie jederzeit über Ihre Browsereinstellungen löschen.</p>

            <h3 class="h6 mb-2 mt-3">5.3 Rechtsgrundlage</h3>
            <p>Rechtsgrundlage ist Art. 6 Abs. 1 S. 1 lit. f) DSGVO. Unser berechtigtes Interesse liegt darin, Ihnen die Website in der von Ihnen gewählten Sprache bereitzustellen, ohne diese bei jedem Seitenaufruf erneut abzufragen. Das Cookie ist für diese Funktion unbedingt erforderlich, sodass keine Einwilligung erforderlich ist.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Speicherdauer / Löschung</h3>
            <p>Das Cookie wird nach 30 Tagen automatisch gelöscht oder sobald Sie es manuell entfernen. Sie können die Speicherung von Cookies jederzeit über die Einstellungen Ihres Browsers unterbinden; in diesem Fall wird Ihre Sprachauswahl nicht gespeichert, und die Website greift auf die automatische Spracherkennung (URL, Browsersprache) zurück. Hier finden Sie Informationen zur Löschung von Cookies nach Browsern:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h2 class="h5 mb-3 mt-4">6. Kontaktaufnahme per E-Mail/Post</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Beschreibung und Umfang der Datenverarbeitung</h3>
            <p>Bei der Kontaktaufnahme mit uns per Post oder E-Mail werden Ihre Angaben zum Zwecke der Abwicklung der Kontaktanfrage verarbeitet.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Rechtsgrundlage</h3>
            <p>Rechtsgrundlage für die Verarbeitung der Daten ist bei Vorliegen einer Einwilligung von Ihnen Art. 6 Abs. 1 S. 1 lit. a) DSGVO. Rechtsgrundlage für die Verarbeitung der Daten, die im Zuge einer Kontaktanfrage oder E-Mail bzw. eines Briefes übermittelt werden, ist Art. 6 Abs. 1 S. 1 lit. f) DSGVO. Der Verantwortliche hat ein berechtigtes Interesse an der Verarbeitung und Speicherung der Daten, um Anfragen der Nutzer beantworten zu können, zur Beweissicherung aus Haftungsgründen und um ggf. seiner gesetzlichen Aufbewahrungspflichten bei Geschäftsbriefen nachkommen zu können. Zielt der Kontakt auf den Abschluss eines Vertrages ab, so ist zusätzliche Rechtsgrundlage für die Verarbeitung Art. 6 Abs. 1 S. 1 lit. b) DSGVO.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Speicherung im CRM-System</h3>
            <p>Wir können Ihre Angaben und Kontaktanfrage in unserem Customer-Relationship-Management System ("CRM System") oder einem vergleichbaren System speichern.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Dauer der Speicherung</h3>
            <p>Die Daten werden gelöscht, sobald sie für die Erreichung des Zweckes ihrer Erhebung nicht mehr erforderlich sind. Für die personenbezogenen Daten, die per E-Mail übersandt wurden, ist dies dann der Fall, wenn die jeweilige Konversation mit Ihnen beendet ist. Beendet ist die Konversation dann, wenn sich aus den Umständen entnehmen lässt, dass der betroffene Sachverhalt abschließend geklärt ist. Anfragen von Nutzern, die über einen Account bzw. Vertrag mit uns verfügen, speichern wir bis zum Ablauf von zwei Jahren nach Vertragsbeendigung. Im Fall von gesetzlichen Archivierungspflichten erfolgt die Löschung nach deren Ablauf gemäß den EU-Richtlinien und nationalen Aufbewahrungsvorschriften.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Widerspruchs- und Beseitigungsmöglichkeit</h3>
            <p>Sie haben jederzeit die Möglichkeit, die Einwilligung nach Art. 6 Abs. 1 S. 1 lit. a) DSGVO zur Verarbeitung der personenbezogenen Daten zu widerrufen. Nehmen Sie per E-Mail Kontakt mit uns auf, so können Sie der Speicherung der personenbezogenen Daten jederzeit widersprechen.</p>

            <h2 class="h5 mb-3 mt-4">7. Nutzung der Tools auf eigene Verantwortung</h2>
            <p><strong>Sie nutzen alle Tools auf dieser Website auf eigene Verantwortung.</strong> Obwohl wir uns bemühen, genaue und zuverlässige Tools bereitzustellen, können wir nicht garantieren, dass diese fehlerfrei sind oder für alle Zwecke geeignet sind.</p>
            <p>Wir übernehmen keine Haftung für:</p>
            <ul>
              <li>Fehler, Ungenauigkeiten oder Fehlfunktionen der Tools</li>
              <li>Datenverluste oder Schäden, die durch die Nutzung der Tools entstehen</li>
              <li>Entscheidungen, die auf Grundlage der von unseren Tools generierten Ergebnisse getroffen werden</li>
            </ul>
            <p>Bitte überprüfen Sie kritische Ergebnisse unabhängig, bevor Sie diese in Produktivumgebungen verwenden.</p>

            <h2 class="h5 mb-3 mt-4">8. Ihre Rechte</h2>
            <p>Sie haben folgende Rechte gemäß DSGVO:</p>
            <ul>
              <li><strong>Auskunftsrecht (Art. 15 DSGVO):</strong> Sie haben das Recht, Auskunft über Ihre von uns verarbeiteten personenbezogenen Daten zu verlangen.</li>
              <li><strong>Berichtigungsrecht (Art. 16 DSGVO):</strong> Sie haben das Recht, unverzüglich die Berichtigung unrichtiger oder die Vervollständigung unvollständiger personenbezogener Daten zu verlangen.</li>
              <li><strong>Löschungsrecht (Art. 17 DSGVO):</strong> Sie haben das Recht, die Löschung Ihrer personenbezogenen Daten zu verlangen.</li>
              <li><strong>Einschränkung der Verarbeitung (Art. 18 DSGVO):</strong> Sie haben das Recht, die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen.</li>
              <li><strong>Datenübertragbarkeit (Art. 20 DSGVO):</strong> Sie haben das Recht, Ihre personenbezogenen Daten in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten.</li>
              <li><strong>Widerspruchsrecht (Art. 21 DSGVO):</strong> Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung Sie betreffender personenbezogener Daten Widerspruch einzulegen.</li>
              <li><strong>Widerruf der Einwilligung (Art. 7 Abs. 3 DSGVO):</strong> Sie haben das Recht, Ihre erteilte Einwilligung jederzeit zu widerrufen.</li>
              <li><strong>Beschwerderecht (Art. 77 DSGVO):</strong> Sie haben das Recht, sich bei einer Aufsichtsbehörde zu beschweren.</li>
            </ul>
            <p>Bei Fragen zum Datenschutz kontaktieren Sie uns bitte über die im Impressum angegebenen Kontaktdaten.</p>

          </div>
        </div>

    </div>
  </main>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
