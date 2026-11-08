<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/config/security-headers.php';

$lang = 'en';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH;
$homeUrl = BASE_PATH;
$pageTitle = 'Privacy Policy – Data Protection WebDev-Tools Developer Tools';
$pageDescription = 'Privacy policy and data protection information for WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
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

<?php include __DIR__ . '/partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main id="main-content" class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Privacy Policy</h1>
          <p class="lead text-secondary">Your Privacy Matters</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Data Protection at a Glance</h2>
            
            <h3 class="h6 mb-2">General Information</h3>
            <p>The following information provides a simple overview of what happens to your personal data when you visit this website. Personal data is any data that can be used to identify you personally.</p>

            <h3 class="h6 mb-2 mt-3">Data Collection on This Website</h3>
            <p><strong>Who is responsible for data collection on this website?</strong></p>
            <p>Data processing on this website is carried out by the website operator. Their contact details can be found in the legal notice on this website.</p>
            
            <p><strong>How do we collect your data?</strong></p>
            <p>On the one hand, your data is collected when you provide it to us. This may be data that you send us by email, for example.</p>
            <p>Other data is collected automatically or with your consent when you visit the website by our IT systems. This is mainly technical data (e.g., Internet browser, operating system, or time of page view). This data is collected automatically as soon as you enter this website.</p>
            
            <p><strong>What do we use your data for?</strong></p>
            <p>Some of the data is collected to ensure that the website is provided without errors (server log files, see section 4). In addition, two tools load one JavaScript library each from a content delivery network (see section 3.3). We do not use any analytics, tracking or advertising services.</p>
            
            <p><strong>What rights do you have regarding your data?</strong></p>
            <p>You have the right to receive information about the origin, recipient, and purpose of your stored personal data free of charge at any time. You also have the right to request the correction or deletion of this data. If you have given your consent to data processing, you can revoke this consent at any time for the future. You also have the right to request the restriction of the processing of your personal data under certain circumstances. Furthermore, you have the right to lodge a complaint with the competent supervisory authority.</p>

            <h2 class="h5 mb-3 mt-4">2. Privacy-First Approach for Tools</h2>
            <p><strong>All tools on this website process your input data exclusively in your browser.</strong> When you use our tools (e.g., Base64 encoder, JSON formatter, etc.), the following applies:</p>
            <ul>
              <li>All conversions, validations, and generations are performed on the client side in your browser</li>
              <li>Your input data in the tools never leaves your device</li>
              <li>We do not store, log, or have access to data that you process with our tools</li>
              <li>We cannot provide any information about tool input data that we do not have, because we do not collect it</li>
            </ul>
            <p><strong>Important note:</strong> This applies exclusively to the processing of your data <em>within the tools</em>. However, when you visit the website in general, technical data is collected automatically in server log files (see section 4), and when you use the QR code generator or minify JavaScript in the code formatter, a library is loaded from a CDN (see section 3.3).</p>

            <h2 class="h5 mb-3 mt-4">3. Security & Transparency</h2>

            <p>We implement multiple layers of security to protect your privacy and ensure the integrity of our tools:</p>

            <h3 class="h6 mb-2 mt-3">3.1 Open Source & Auditability</h3>
            <p>The complete source code is publicly available on GitHub. You can review, audit, or fork the project at any time:</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="GitHub Repository of WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Subresource Integrity (SRI)</h3>
            <p>All external libraries are loaded with cryptographic SRI hashes to prevent tampering. This ensures that third-party code cannot be modified without detection:</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Library</th>
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
            <p><small class="text-muted">Full SRI hashes can be verified in our source code (<a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">config/tools.php</a> and <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/assets/js/tools/codeFormatterTool.js" target="_blank" rel="noopener noreferrer">codeFormatterTool.js</a>).</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Third-Party Content Delivery (CDN)</h3>
            <p>Bootstrap, the icon font and all other assets are hosted on our own server. Only two tools load a single JavaScript library from the content delivery network jsDelivr (cdn.jsdelivr.net), operated by Prospect One (jsDelivr) and delivered via several CDN providers, including Cloudflare and Fastly:</p>
            <ul>
              <li><strong>QR Code Generator:</strong> loads <code>qrcode-generator</code> when the tool page is opened.</li>
              <li><strong>Code Formatter:</strong> loads <code>terser</code> only when you minify JavaScript code.</li>
            </ul>
            <p>When one of these libraries is loaded, your browser connects directly to the CDN and transmits the technical data required for this, in particular your IP address, your user agent and the referring page (referrer). We ourselves receive no data from this process. The libraries are protected by SRI hashes (see 3.2) and can therefore not be modified unnoticed. Apart from this, this website does not make any requests to third-party servers; only the SRI generator retrieves the resource URL that you yourself enter.</p>
            <p>The legal basis is Art. 6 (1) (f) GDPR; our legitimate interest lies in providing these tools reliably and efficiently. Further information can be found in the jsDelivr privacy policy: <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener">https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net</a></p>

            <h3 class="h6 mb-2 mt-3">3.4 Content Security Policy (CSP)</h3>
            <p>We implement strict Content Security Policies to prevent XSS attacks and unauthorized code execution:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Nonce-based script execution (prevents inline script injection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Restricted external resource loading (scripts only from our own server and cdn.jsdelivr.net)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Frame embedding completely disabled (clickjacking protection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Object and plugin execution blocked</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Additional Security Headers</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Prevents iframe embedding attacks</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Prevents MIME-type sniffing</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limits referrer information leakage</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Enforces HTTPS connections with preload</li>
              <li><strong>Permissions-Policy</strong> - Disables unnecessary browser features (geolocation, camera, microphone, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.6 Zero External Dependencies for Data Processing</h3>
            <p>All core data processing functions use native browser APIs only. External libraries are used solely for two auxiliary functions (QR code rendering and JavaScript minification) and are loaded with SRI verification.</p>

            <h2 class="h5 mb-3 mt-4">4. Hosting & Server Log Files</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Description and Scope of Data Processing</h3>
            <p>This website is hosted by an external service provider. If you use our website for informational purposes only (i.e., without registering or otherwise transmitting information), we only collect the personal data that your browser transmits to our server. If you wish to view our website, we collect the following data:</p>
            <ul>
              <li>IP address</li>
              <li>User's internet service provider</li>
              <li>Date and time of access</li>
              <li>Browser type</li>
              <li>Language and browser version</li>
              <li>Content of the request</li>
              <li>Time zone</li>
              <li>Access status/HTTP status code</li>
              <li>Amount of data</li>
              <li>Websites from which the request originates (referrer URL)</li>
              <li>Operating system</li>
            </ul>
            <p>This data is not stored together with other personal data about you.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Purpose of Processing</h3>
            <p>This data is used for the purpose of providing you with a user-friendly, functional, and secure website with functions and content, as well as for optimization and statistical evaluation. The data is used exclusively for the technical operation and security of the website.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Legal Basis</h3>
            <p>The legal basis for this is our legitimate interest in data processing in accordance with Art. 6 (1) (f) GDPR, which is also reflected in the above purposes.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Storage Period</h3>
            <p>For security reasons, we store this data in server log files for a storage period of 60 days. After this period has expired, it is automatically deleted unless we need to retain it for evidence purposes in the event of attacks on the server infrastructure or other legal violations. The data is not merged with other data sources.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookies Used</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 General Information about Cookies</h3>
            <p>Cookies are small text files that your Internet browser stores on your device. This website uses <strong>exactly one cookie</strong>, which is technically necessary. We do not use any session, analytics, tracking or third-party cookies, and no user profiles are created. Since no cookies requiring consent are used, no cookie banner is displayed.</p>

            <h3 class="h6 mb-2 mt-3">5.2 Language Preference Cookie (Technically Necessary)</h3>
            <p>We use a single cookie to store your language preference:</p>
            <ul>
              <li><strong>Cookie name:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Purpose:</strong> Stores your selected interface language (e.g., "en," "de," "pt")</li>
              <li><strong>Validity:</strong> 30 days</li>
              <li><strong>Stored data:</strong> Only a two-letter language code</li>
              <li><strong>Type:</strong> Technically necessary (enables basic language preference functionality)</li>
            </ul>
            <p>This cookie does not contain any personal information and is used exclusively to provide you with content in your preferred language. You can delete this cookie at any time via your browser settings.</p>

            <h3 class="h6 mb-2 mt-3">5.3 Legal Basis</h3>
            <p>The legal basis is Art. 6 (1) (f) GDPR. Our legitimate interest lies in providing you with the website in the language you have selected without having to ask for it on every page view. The cookie is strictly necessary for this function, so no consent is required.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Storage Period / Deletion</h3>
            <p>The cookie is automatically deleted after 30 days or as soon as you remove it manually. You can prevent cookies from being stored at any time via your browser settings; in that case, your language selection will not be saved and the website falls back to automatic language detection (URL, browser language). Here you will find information on deleting cookies for different browsers:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h2 class="h5 mb-3 mt-4">6. Contacting Us by Email/Post</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Description and Scope of Data Processing</h3>
            <p>When you contact us by post or email, your details will be processed for the purpose of handling your contact request.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Legal Basis</h3>
            <p>The legal basis for the processing of the data is Art. 6 (1) (a) GDPR if you have given your consent. The legal basis for the processing of data transmitted in the course of a contact request or email or letter is Art. 6 (1) (f) GDPR. The controller has a legitimate interest in processing and storing the data in order to be able to respond to user inquiries, to preserve evidence for liability reasons, and to be able to comply with its legal retention obligations for business letters, if applicable. If the purpose of the contact is to conclude a contract, the additional legal basis for processing is Art. 6 (1) (b) GDPR.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Storage in CRM System</h3>
            <p>We may store your details and contact request in our customer relationship management system ("CRM system") or a comparable system.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Duration of Storage</h3>
            <p>The data will be deleted as soon as it is no longer necessary for the purpose for which it was collected. For personal data sent by email, this is the case when the respective conversation with you has ended. The conversation is ended when it can be inferred from the circumstances that the matter in question has been conclusively clarified. We store inquiries from users who have an account or contract with us for up to two years after the end of the contract. In the case of legal archiving obligations, deletion takes place after their expiry in accordance with EU directives and national retention regulations.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Right to Object and Right to Erasure</h3>
            <p>You have the right to withdraw your consent to the processing of personal data at any time in accordance with Art. 6 (1) (a) GDPR. If you contact us by email, you can object to the storage of your personal data at any time.</p>

            <h2 class="h5 mb-3 mt-4">7. Use of the Tools at Your Own Risk</h2>
            <p><strong>You use all tools on this website at your own risk.</strong> Although we strive to provide accurate and reliable tools, we cannot guarantee that they are error-free or suitable for all purposes.</p>
            <p>We accept no liability for:</p>
            <ul>
              <li>Errors, inaccuracies, or malfunctions of the tools</li>
              <li>Data loss or damage resulting from the use of the tools</li>
              <li>Decisions made based on the results generated by our tools</li>
            </ul>
            <p>Please independently verify critical results before using them in production environments.</p>

            <h2 class="h5 mb-3 mt-4">8. Your Rights</h2>
            <p>You have the following rights under the GDPR:</p>
            <ul>
              <li><strong>Right of access (Art. 15 GDPR):</strong> You have the right to request information about your personal data processed by us.</li>
              <li><strong>Right to rectification (Art. 16 GDPR):</strong> You have the right to request the immediate rectification of inaccurate personal data or the completion of incomplete personal data.</li>
              <li><strong>Right to erasure (Art. 17 GDPR):</strong> You have the right to request the erasure of your personal data.</li>
              <li><strong>Restriction of processing (Art. 18 GDPR):</strong> You have the right to request the restriction of the processing of your personal data.</li>
              <li><strong>Data portability (Art. 20 GDPR):</strong> You have the right to receive your personal data in a structured, commonly used, and machine-readable format.</li>
              <li><strong>Right to object (Art. 21 GDPR):</strong> You have the right to object to the processing of personal data concerning you at any time for reasons arising from your particular situation.</li>
              <li><strong>Withdrawal of consent (Art. 7 (3) GDPR):</strong> You have the right to withdraw your consent at any time.</li>
              <li><strong>Right to lodge a complaint (Art. 77 GDPR):</strong> You have the right to lodge a complaint with a supervisory authority.</li>
            </ul>
            <p>If you have any questions about data protection, please contact us using the contact details provided in the legal notice.</p>

          </div>
        </div>

    </div>
  </main>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
