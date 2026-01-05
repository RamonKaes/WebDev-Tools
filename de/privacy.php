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
$pageTitle = 'Datenschutzerklärung – WebDev-Tools';
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
            <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gewährleisten. Andere Daten können zur Analyse Ihres Nutzerverhaltens verwendet werden. Zudem verwenden wir Google AdSense zur Finanzierung dieser kostenlosen Website durch Werbeanzeigen.</p>
            
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
            <p><strong>Wichtiger Hinweis:</strong> Dies bezieht sich ausschließlich auf die Verarbeitung Ihrer Daten <em>innerhalb der Tools</em>. Beim allgemeinen Besuch der Website werden jedoch automatisch technische Daten erhoben (siehe Abschnitt 4) und Google AdSense setzt Cookies für Werbezwecke (siehe Abschnitte 6 und 7).</p>

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
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Vollständige SRI-Hashes können in unserem <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">Quellcode</a> überprüft werden.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Content Security Policy (CSP)</h3>
            <p>Wir implementieren strenge Content Security Policies, um XSS-Angriffe und unbefugte Code-Ausführung zu verhindern:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Nonce-basierte Script-Ausführung (verhindert Inline-Script-Injection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Beschränktes Laden externer Ressourcen (nur von vertrauenswürdigen CDNs)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Frame-Einbettung komplett deaktiviert (Clickjacking-Schutz)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Object- und Plugin-Ausführung blockiert</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 Zusätzliche Sicherheits-Header</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Verhindert Iframe-Einbettungsangriffe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Verhindert MIME-Type-Sniffing</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Begrenzt Referrer-Informationslecks</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Erzwingt HTTPS-Verbindungen mit Preload</li>
              <li><strong>Permissions-Policy</strong> - Deaktiviert unnötige Browser-Funktionen (Geolokation, Kamera, Mikrofon, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Keine externen Abhängigkeiten für Datenverarbeitung</h3>
            <p>Alle Kern-Datenverarbeitungsfunktionen nutzen ausschließlich native Browser-APIs. Externe Bibliotheken werden nur für UI-Komponenten verwendet (QR-Code-Rendering) und mit SRI-Verifizierung geladen.</p>

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
            <p>Wir verwenden sog. Cookies bei Ihrem Besuch unserer Website. Cookies sind kleine Textdateien, die Ihr Internet-Browser auf Ihrem Rechner ablegt und speichert. Wenn Sie unsere Website erneut aufrufen, geben diese Cookies Informationen ab, um Sie automatisch wiederzuerkennen. Zu den Cookies zählen auch die sog. „Nutzer-IDs", wo Angaben der Nutzer mittels pseudonymisierter Profile gespeichert werden. Wir informieren Sie dazu beim Aufruf unserer Website mittels eines Hinweises auf unsere Datenschutzerklärung über die Verwendung von Cookies zu den zuvor genannten Zwecken und wie Sie dieser widersprechen bzw. deren Speicherung verhindern können („Opt-out").</p>
            
            <p>Es werden folgende Cookie-Arten unterschieden:</p>
            <ul>
              <li><strong>Notwendige, essentielle Cookies:</strong> Essentielle Cookies sind Cookies, die zum Betrieb der Webseite unbedingt erforderlich sind, um bestimmte Funktionen der Webseite wie Logins, Warenkorb oder Nutzereingaben z.B. bzgl. Sprache der Webseite zu speichern.</li>
              <li><strong>Session-Cookies:</strong> Session-Cookies werden zum Wiedererkennen mehrfacher Nutzung eines Angebots durch denselben Nutzer (z.B. wenn Sie sich eingeloggt haben zur Feststellung Ihres Login-Status) benötigt. Wenn Sie unsere Seite erneut aufrufen, geben diese Cookies Informationen ab, um Sie automatisch wiederzuerkennen. Die so erlangten Informationen dienen dazu, unsere Angebote zu optimieren und Ihnen einen leichteren Zugang auf unsere Seite zu ermöglichen. Wenn Sie den Browser schließen oder Sie sich ausloggen, werden die Session-Cookies gelöscht.</li>
              <li><strong>Persistente Cookies:</strong> Diese Cookies bleiben auch nach dem Schließen des Browsers gespeichert. Sie dienen zur Speicherung des Logins, der Reichweitenmessung und zu Marketingzwecken. Diese werden automatisiert nach einer vorgegebenen Dauer gelöscht, die sich je nach Cookie unterscheiden kann. In den Sicherheitseinstellungen Ihres Browsers können Sie die Cookies jederzeit löschen.</li>
              <li><strong>Cookies von Drittanbietern (Third-Party-Cookies insb. von Werbetreibenden):</strong> Entsprechend Ihren Wünschen können Sie Ihre Browser-Einstellung konfigurieren und z. B. Die Annahme von Third-Party-Cookies oder allen Cookies ablehnen. Wir weisen Sie jedoch an dieser Stelle darauf hin, dass Sie dann eventuell nicht alle Funktionen dieser Website nutzen können. Lesen Sie Näheres zu diesen Cookies bei den jeweiligen Datenschutzerklärungen zu den Drittanbietern.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Datenkategorien</h3>
            <p>Nutzerdaten, Cookie, Nutzer-ID (inb. die besuchten Seiten, Geräteinformationen, Zugriffszeiten und IP-Adressen).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Zwecke der Verarbeitung</h3>
            <p>Die so erlangten Informationen dienen dem Zweck, unsere Webangebote technisch und wirtschaftlich zu optimieren und Ihnen einen leichteren und sicheren Zugang auf unsere Website zu ermöglichen.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Rechtsgrundlage</h3>
            <p>Wenn wir Ihre personenbezogenen Daten mit Hilfe von Cookies aufgrund Ihrer Einwilligung verarbeiten („Opt-in"), dann ist Art. 6 Abs. 1 S. 1 lit. a) DSGVO die Rechtsgrundlage. Ansonsten haben wir ein berechtigtes Interesse an der effektiven Funktionalität, Verbesserung und wirtschaftlichen Betrieb der Website, so dass in dem Falle Art. 6 Abs. 1 S. 1 lit. f) DSGVO Rechtsgrundlage ist. Rechtsgrundlage ist zudem Art. 6 Abs. 1 S. 1 lit. b) DSGVO, wenn die Cookies zur Vertragsanbahnung z.B. bei Bestellungen gesetzt werden.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Speicherdauer / Löschung</h3>
            <p>Die Daten werden gelöscht, sobald sie für die Erreichung des Zweckes ihrer Erhebung nicht mehr erforderlich sind. Im Falle der Erfassung der Daten zur Bereitstellung der Website ist dies der Fall, wenn die jeweilige Session beendet ist.</p>
            <p>Cookies werden ansonsten auf Ihrem Computer gespeichert und von diesem an unsere Seite übermittelt. Daher haben Sie als Nutzer auch die volle Kontrolle über die Verwendung von Cookies. Durch eine Änderung der Einstellungen in Ihrem Internetbrowser können Sie die Übertragung von Cookies deaktivieren oder einschränken. Bereits gespeicherte Cookies können jederzeit gelöscht werden. Dies kann auch automatisiert erfolgen. Werden Cookies für unsere Website deaktiviert, können möglicherweise nicht mehr alle Funktionen der Website vollumfänglich genutzt werden.</p>
            <p>Hier finden Sie Informationen zur Löschung von Cookies nach Browsern:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Widerspruch und „Opt-Out“</h3>
            <p>Das Speichern von Cookies auf Ihrer Festplatte können Sie unabhängig von einer Einwilligung oder gesetzlichen Erlaubnis allgemein verhindern, indem Sie in Ihren Browser-Einstellungen „keine Cookies akzeptieren" wählen. Dies kann aber eine Funktionseinschränkung unserer Angebote zur Folge haben. Sie können dem Einsatz von Cookies von Drittanbietern zu Werbezwecken über ein sog. „Opt-out" über diese amerikanische Website (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) oder diese europäische Website (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>) widersprechen.</p>

            <h3 class="h6 mb-2 mt-3">Sprachpräferenz-Cookie (technisch notwendig)</h3>
            <p>Wir verwenden ein einzelnes Cookie, um Ihre Sprachpräferenz zu speichern:</p>
            <ul>
              <li><strong>Cookie-Name:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Zweck:</strong> Speichert Ihre ausgewählte Oberflächensprache (z.B. "en", "de", "pt")</li>
              <li><strong>Gültigkeit:</strong> 30 Tage</li>
              <li><strong>Gespeicherte Daten:</strong> Nur ein zweistelliger Sprachcode</li>
              <li><strong>Art:</strong> Technisch notwendig (ermöglicht grundlegende Sprachpräferenz-Funktionalität)</li>
            </ul>
            <p>Dieses Cookie enthält keine persönlichen Informationen und wird ausschließlich verwendet, um Ihnen Inhalte in Ihrer bevorzugten Sprache bereitzustellen. Sie können dieses Cookie jederzeit über Ihre Browsereinstellungen löschen.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Einleitung</h3>
            <p>Wir haben Werbeanzeigen des Google Dienstes „Adsense" (Dienstanbieter: Google Ireland Limited, Registernr.: 368047, Gordon House, Barrow Street, Dublin 4, Irland) auf unserer Webseite integriert. Die Werbeanzeigen sind über den (i)-Hinweis „Google-Anzeigen" in jeder Anzeige gekennzeichnet.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Datenkategorien und Beschreibung der Datenverarbeitung</h3>
            <p>Nutzungsdaten/ Kommunikationsdaten; Google erhält beim Besuch unserer Website die Information, dass Sie unsere Website aufgerufen haben. Dazu setzt Google einen Web-Beacon bzw. Cookie auf Ihren Computer. Die Daten werden auch in die USA übertragen und dort analysiert. Wenn Sie mit einem Google-Account eingeloggt sind, können durch Adsense die Daten Ihrem Account zugeordnet werden. Wenn Sie dies nicht wünschen, müssen Sie sich vor dem Besuch unserer Website ausloggen. Aber auch andere Informationen können hierfür durch Google herangezogen werden:</p>
            <ul>
              <li>die Art der von Ihnen besuchten Websites sowie der auf Ihrem Gerät installierten mobilen Apps;</li>
              <li>Cookies in Ihrem Browser und Einstellungen in Ihrem Google-Konto;</li>
              <li>Websites und Apps, die Sie besucht haben;</li>
              <li>Ihre Aktivitäten auf anderen Geräten;</li>
              <li>vorherige Interaktionen mit Anzeigen oder Werbediensten von Google;</li>
              <li>Ihre Google-Kontoaktivitäten und -informationen.</li>
            </ul>
            <p>Bei einem Klick auf eine Adsense-Anzeige wird die IP der Nutzer durch Google verarbeitet (Nutzungsdaten), wobei die Verarbeitung pseudonymisiert (sog. „Werbe-ID") erfolgt, indem die IP um die letzten beiden Stellen gekürzt wird. Google verknüpft bei personalisierter Werbung Kennungen aus Cookies oder ähnlichen Technologien nicht mit besonderen Kategorien personenbezogener Daten nach Art. 9 DSGVO wie ethnischer Herkunft, Religion, sexueller Orientierung oder Gesundheit.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Zweck der Verarbeitung</h3>
            <p>Wir haben dabei die personalisierten Anzeigen aktiviert, um Ihnen interessantere Werbung anzuzeigen, die die kommerzielle Nutzung unserer Website unterstützt, den Wert für uns steigert und für Sie die Nutzererfahrung verbessert. Mithilfe personalisierter Werbung können wir über Adsense Nutzer auf Grundlage ihrer Interessen und demografischen Merkmale (z.B. "Sportbegeisterte") erreichen. Zudem dient die Verarbeitung dem Tracking, Remarketing und der Conversion-Messung sowie zur Finanzierung unseres Webangebots.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Rechtsgrundlage</h3>
            <p>Haben Sie für Verarbeitung Ihrer personenbezogenen Daten mittels „Google Adsense mit personalisierten Anzeigen" Ihre Einwilligung erteilt („Opt-in"), dann ist Art. 6 Abs. 1 S. 1 lit. a) DSGVO die Rechtsgrundlage. Rechtsgrundlage für die Verarbeitung Ihrer Daten ist ansonsten Art. 6 Abs. 1 S. 1 lit. f) DSGVO aufgrund unserer berechtigten Interessen an der Analyse, Optimierung und dem effizienten wirtschaftlichen Betrieb unserer Werbung und Website.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Datenübermittlung/Empfängerkategorie</h3>
            <p>Google Irland, USA; Diese Website hat auch Google AdSense-Anzeigen von Drittanbietern aktiviert. Die vorgenannten Daten können auch an diese Drittanbieter „Certified External Vendors" benannt unter <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a> übertragen werden.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Speicherdauer</h3>
            <p>Die Daten werden bis zu 24 Monate nach dem letzten Besuch gespeichert.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Widerspruchs- und Beseitigungsmöglichkeiten („Opt-Out“)</h3>
            <p>Sie können der Installation von Cookies durch Google Adsense auf verschiedene Arten widersprechen bzw. diese verhindern:</p>
            <ul>
              <li>Sie können die Cookies in Ihrem Browser durch die Einstellung "keine Cookies akzeptieren" unterbinden, was auch die Cookies von Drittanbietern beinhaltet;</li>
              <li>Sie können direkt bei Google über den Link <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a> die personenbezogenen Anzeigen bei Google deaktivieren, wobei diese Einstellung nur solange Bestand hat bis Sie Ihre Cookies löschen. Zur Deaktivierung der personalisierten Werbung auf Mobilgeräten finden Sie hier eine Anleitung: <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a>;</li>
              <li>Sie können die personalisierten Anzeigen der Drittanbieter, die an der Werbeselbstregulierungsinitiaive "About Ads" teilnehmen über den Link <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> für US-Seiten oder für EU-Seiten unter <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> deaktivieren, wobei diese Einstellung nur solange Bestand hat, bis Sie all Ihre Cookies löschen;</li>
              <li>Sie können durch ein Browser-Plug-in für Chrome, Firefox oder Internet-Explorer unter dem Link <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a> dauerhaft Cookies deaktivieren. Diese Deaktivierung kann zur Folge haben, dass Sie nicht alle Funktionen unserer Website mehr vollumfänglich nutzen können.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Weitere Informationen</h3>
            <p>In der Datenschutzerklärung für Werbung von Google unter <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a> finden Sie weitere Informationen zur Verwendung von Google Cookies in Anzeigen und deren Werbetechnologien, Speicherdauer, Anonymisierung, Standortdaten, Funktionsweise und Ihre Rechte.</p>

            <h2 class="h5 mb-3 mt-4">7. Kontaktaufnahme per E-Mail/Post</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Beschreibung und Umfang der Datenverarbeitung</h3>
            <p>Bei der Kontaktaufnahme mit uns per Post oder E-Mail werden Ihre Angaben zum Zwecke der Abwicklung der Kontaktanfrage verarbeitet.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Rechtsgrundlage</h3>
            <p>Rechtsgrundlage für die Verarbeitung der Daten ist bei Vorliegen einer Einwilligung von Ihnen Art. 6 Abs. 1 S. 1 lit. a) DSGVO. Rechtsgrundlage für die Verarbeitung der Daten, die im Zuge einer Kontaktanfrage oder E-Mail bzw. eines Briefes übermittelt werden, ist Art. 6 Abs. 1 S. 1 lit. f) DSGVO. Der Verantwortliche hat ein berechtigtes Interesse an der Verarbeitung und Speicherung der Daten, um Anfragen der Nutzer beantworten zu können, zur Beweissicherung aus Haftungsgründen und um ggf. seiner gesetzlichen Aufbewahrungspflichten bei Geschäftsbriefen nachkommen zu können. Zielt der Kontakt auf den Abschluss eines Vertrages ab, so ist zusätzliche Rechtsgrundlage für die Verarbeitung Art. 6 Abs. 1 S. 1 lit. b) DSGVO.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Speicherung im CRM-System</h3>
            <p>Wir können Ihre Angaben und Kontaktanfrage in unserem Customer-Relationship-Management System ("CRM System") oder einem vergleichbaren System speichern.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Dauer der Speicherung</h3>
            <p>Die Daten werden gelöscht, sobald sie für die Erreichung des Zweckes ihrer Erhebung nicht mehr erforderlich sind. Für die personenbezogenen Daten, die per E-Mail übersandt wurden, ist dies dann der Fall, wenn die jeweilige Konversation mit Ihnen beendet ist. Beendet ist die Konversation dann, wenn sich aus den Umständen entnehmen lässt, dass der betroffene Sachverhalt abschließend geklärt ist. Anfragen von Nutzern, die über einen Account bzw. Vertrag mit uns verfügen, speichern wir bis zum Ablauf von zwei Jahren nach Vertragsbeendigung. Im Fall von gesetzlichen Archivierungspflichten erfolgt die Löschung nach deren Ablauf gemäß den EU-Richtlinien und nationalen Aufbewahrungsvorschriften.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Widerspruchs- und Beseitigungsmöglichkeit</h3>
            <p>Sie haben jederzeit die Möglichkeit, die Einwilligung nach Art. 6 Abs. 1 S. 1 lit. a) DSGVO zur Verarbeitung der personenbezogenen Daten zu widerrufen. Nehmen Sie per E-Mail Kontakt mit uns auf, so können Sie der Speicherung der personenbezogenen Daten jederzeit widersprechen.</p>

            <h2 class="h5 mb-3 mt-4">8. Nutzung der Tools auf eigene Verantwortung</h2>
            <p><strong>Sie nutzen alle Tools auf dieser Website auf eigene Verantwortung.</strong> Obwohl wir uns bemühen, genaue und zuverlässige Tools bereitzustellen, können wir nicht garantieren, dass diese fehlerfrei sind oder für alle Zwecke geeignet sind.</p>
            <p>Wir übernehmen keine Haftung für:</p>
            <ul>
              <li>Fehler, Ungenauigkeiten oder Fehlfunktionen der Tools</li>
              <li>Datenverluste oder Schäden, die durch die Nutzung der Tools entstehen</li>
              <li>Entscheidungen, die auf Grundlage der von unseren Tools generierten Ergebnisse getroffen werden</li>
            </ul>
            <p>Bitte überprüfen Sie kritische Ergebnisse unabhängig, bevor Sie diese in Produktivumgebungen verwenden.</p>

            <h2 class="h5 mb-3 mt-4">9. Ihre Rechte</h2>
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
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
