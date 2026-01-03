<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/config/security-headers.php';

$lang = 'en';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH;
$homeUrl = BASE_PATH;
$pageTitle = 'Privacy Policy – WebDev-Tools';
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

<?php include __DIR__ . '/partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
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
            <p>Some of the data is collected to ensure that the website is provided without errors. Other data may be used to analyze your user behavior. We also use Google AdSense to finance this free website through advertisements.</p>
            
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
            <p><strong>Important note:</strong> This applies exclusively to the processing of your data <em>within the tools</em>. However, when you visit the website in general, technical data is collected automatically (see section 4) and Google AdSense sets cookies for advertising purposes (see sections 6 and 7).</p>

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
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Full SRI hashes can be verified in our <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">source code</a>.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Content Security Policy (CSP)</h3>
            <p>We implement strict Content Security Policies to prevent XSS attacks and unauthorized code execution:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Nonce-based script execution (prevents inline script injection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Restricted external resource loading (only from trusted CDNs)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Frame embedding completely disabled (clickjacking protection)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Object and plugin execution blocked</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 Additional Security Headers</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Prevents iframe embedding attacks</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Prevents MIME-type sniffing</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limits referrer information leakage</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Enforces HTTPS connections with preload</li>
              <li><strong>Permissions-Policy</strong> - Disables unnecessary browser features (geolocation, camera, microphone, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Zero External Dependencies for Data Processing</h3>
            <p>All core data processing functions use native browser APIs only. External libraries are used solely for UI components (QR code rendering) and are loaded with SRI verification.</p>

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
            <p>We use cookies when you visit our website. Cookies are small text files that your Internet browser stores on your computer. When you visit our website again, these cookies provide information to automatically recognize you. Cookies also include so-called "user IDs," where user information is stored using pseudonymized profiles. When you visit our website, we inform you about the use of cookies for the aforementioned purposes and how you can object to this or prevent their storage ("opt-out") by referring you to our privacy policy.</p>
            
            <p>A distinction is made between the following types of cookies:</p>
            <ul>
              <li><strong>Necessary, essential cookies:</strong> Essential cookies are cookies that are absolutely necessary for the operation of the website in order to store certain functions of the website, such as logins, shopping carts, or user entries, e.g., regarding the language of the website.</li>
              <li><strong>Session cookies:</strong> Session cookies are required to recognize multiple uses of an offer by the same user (e.g., when you have logged in to determine your login status). When you visit our site again, these cookies provide information to automatically recognize you. The information obtained in this way is used to optimize our offers and to make it easier for you to access our site. When you close your browser or log out, the session cookies are deleted.</li>
              <li><strong>Persistent cookies:</strong> These cookies remain stored even after you close your browser. They are used to store your login, measure reach, and for marketing purposes. They are automatically deleted after a specified period, which may vary depending on the cookie. You can delete cookies at any time in your browser's security settings.</li>
              <li><strong>Third-party cookies (especially from advertisers):</strong> You can configure your browser settings according to your preferences and, for example, refuse to accept third-party cookies or all cookies. However, we would like to point out that you may not be able to use all the functions of this website if you do so. For more information about these cookies, please refer to the respective privacy policies of the third-party providers.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Data Categories</h3>
            <p>User data, cookies, user ID (including the pages visited, device information, access times, and IP addresses).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Purposes of Processing</h3>
            <p>The information obtained in this way serves the purpose of optimizing our web offerings technically and economically and enabling you to access our website more easily and securely.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Legal Basis</h3>
            <p>If we process your personal data with the help of cookies on the basis of your consent ("opt-in"), then Art. 6 (1) (a) GDPR is the legal basis. Otherwise, we have a legitimate interest in the effective functionality, improvement, and economic operation of the website, in which case Art. 6 (1) (f) GDPR is the legal basis. The legal basis is also Art. 6 (1) (b) GDPR if the cookies are set for the purpose of initiating a contract, e.g., for orders.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Storage Period / Deletion</h3>
            <p>The data will be deleted as soon as it is no longer necessary for the purpose for which it was collected. In the case of data collection for the provision of the website, this is the case when the respective session has ended.</p>
            <p>Otherwise, cookies are stored on your computer and transmitted to our site. As a user, you therefore have full control over the use of cookies. You can deactivate or restrict the transmission of cookies by changing the settings in your Internet browser. Cookies that have already been stored can be deleted at any time. This can also be done automatically. If cookies are deactivated for our website, it may no longer be possible to use all the functions of the website to their full extent.</p>
            <p>Here you will find information on deleting cookies for different browsers:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Objection and "Opt-Out"</h3>
            <p>You can generally prevent cookies from being stored on your hard drive, regardless of consent or legal permission, by selecting "do not accept cookies" in your browser settings. However, this may result in functional restrictions to our offers. You can object to the use of third-party cookies for advertising purposes via a so-called "opt-out" on this American website (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) or this European website (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>).</p>

            <h3 class="h6 mb-2 mt-3">Language Preference Cookie (Technically Necessary)</h3>
            <p>We use a single cookie to store your language preference:</p>
            <ul>
              <li><strong>Cookie name:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Purpose:</strong> Stores your selected interface language (e.g., "en," "de," "pt")</li>
              <li><strong>Validity:</strong> 30 days</li>
              <li><strong>Stored data:</strong> Only a two-letter language code</li>
              <li><strong>Type:</strong> Technically necessary (enables basic language preference functionality)</li>
            </ul>
            <p>This cookie does not contain any personal information and is used exclusively to provide you with content in your preferred language. You can delete this cookie at any time via your browser settings.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Introduction</h3>
            <p>We have integrated advertisements from the Google service "Adsense" (service provider: Google Ireland Limited, registration no.: 368047, Gordon House, Barrow Street, Dublin 4, Ireland) into our website. The advertisements are marked with the (i) note "Google Ads" in each advertisement.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Data Categories and Description of Data Processing</h3>
            <p>Usage data/communication data; when you visit our website, Google receives information that you have accessed our website. To do this, Google places a web beacon or cookie on your computer. The data is also transferred to the USA and analyzed there. If you are logged in with a Google account, Adsense can assign the data to your account. If you do not want this to happen, you must log out before visiting our website. However, Google may also use other information for this purpose:</p>
            <ul>
              <li>the type of websites you visit and the mobile apps installed on your device;</li>
              <li>cookies in your browser and settings in your Google account;</li>
              <li>websites and apps you have visited;</li>
              <li>your activities on other devices;</li>
              <li>previous interactions with Google ads or advertising services;</li>
              <li>your Google account activities and information.</li>
            </ul>
            <p>When you click on an Adsense ad, Google processes the user's IP address (usage data), whereby the processing is pseudonymized (so-called "advertising ID") by truncating the last two digits of the IP address. In the case of personalized advertising, Google does not link identifiers from cookies or similar technologies to special categories of personal data pursuant to Art. 9 GDPR, such as ethnic origin, religion, sexual orientation, or health.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Purpose of Processing</h3>
            <p>We have activated personalized ads in order to show you more interesting advertising that supports the commercial use of our website, increases its value for us, and improves your user experience. With the help of personalized advertising, we can reach users via Adsense based on their interests and demographic characteristics (e.g., "sports enthusiasts"). In addition, processing is used for tracking, remarketing, and conversion measurement, as well as to finance our website.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Legal Basis</h3>
            <p>If you have given your consent ("opt-in") to the processing of your personal data using "Google Adsense with personalized ads," then Art. 6 (1) (a) GDPR is the legal basis. Otherwise, the legal basis for the processing of your data is Art. 6 (1) (f) GDPR based on our legitimate interests in the analysis, optimization, and efficient economic operation of our advertising and website.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Data Transfer/Recipient Category</h3>
            <p>Google Ireland, USA; This website has also enabled third-party Google AdSense ads. The aforementioned data may also be transferred to these third-party providers, known as "Certified External Vendors," listed at <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a>.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Storage Period</h3>
            <p>The data is stored for up to 24 months after the last visit.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Opt-Out Options</h3>
            <p>You can object to or prevent the installation of cookies by Google Adsense in various ways:</p>
            <ul>
              <li>You can prevent cookies in your browser by selecting the "do not accept cookies" setting, which also includes third-party cookies;</li>
              <li>You can deactivate personalized ads on Google directly via the link <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a>, although this setting will only remain in effect until you delete your cookies. Instructions for deactivating personalized advertising on mobile devices can be found here: <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a>;</li>
              <li>You can disable personalized ads from third-party providers participating in the "About Ads" advertising self-regulation initiative via the link <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> for US sites or <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> for EU sites. This setting will only remain in effect until you delete all your cookies.</li>
              <li>You can permanently disable cookies by using a browser plug-in for Chrome, Firefox, or Internet Explorer at <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a>. Disabling cookies may mean that you will no longer be able to use all the features of our website to their full extent.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Further Information</h3>
            <p>In Google's privacy policy for advertising at <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a>, you will find further information on the use of Google cookies in ads and their advertising technologies, storage duration, anonymization, location data, functionality, and your rights.</p>

            <h2 class="h5 mb-3 mt-4">7. Contacting Us by Email/Post</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Description and Scope of Data Processing</h3>
            <p>When you contact us by post or email, your details will be processed for the purpose of handling your contact request.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Legal Basis</h3>
            <p>The legal basis for the processing of the data is Art. 6 (1) (a) GDPR if you have given your consent. The legal basis for the processing of data transmitted in the course of a contact request or email or letter is Art. 6 (1) (f) GDPR. The controller has a legitimate interest in processing and storing the data in order to be able to respond to user inquiries, to preserve evidence for liability reasons, and to be able to comply with its legal retention obligations for business letters, if applicable. If the purpose of the contact is to conclude a contract, the additional legal basis for processing is Art. 6 (1) (b) GDPR.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Storage in CRM System</h3>
            <p>We may store your details and contact request in our customer relationship management system ("CRM system") or a comparable system.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Duration of Storage</h3>
            <p>The data will be deleted as soon as it is no longer necessary for the purpose for which it was collected. For personal data sent by email, this is the case when the respective conversation with you has ended. The conversation is ended when it can be inferred from the circumstances that the matter in question has been conclusively clarified. We store inquiries from users who have an account or contract with us for up to two years after the end of the contract. In the case of legal archiving obligations, deletion takes place after their expiry in accordance with EU directives and national retention regulations.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Right to Object and Right to Erasure</h3>
            <p>You have the right to withdraw your consent to the processing of personal data at any time in accordance with Art. 6 (1) (a) GDPR. If you contact us by email, you can object to the storage of your personal data at any time.</p>

            <h2 class="h5 mb-3 mt-4">8. Use of the Tools at Your Own Risk</h2>
            <p><strong>You use all tools on this website at your own risk.</strong> Although we strive to provide accurate and reliable tools, we cannot guarantee that they are error-free or suitable for all purposes.</p>
            <p>We accept no liability for:</p>
            <ul>
              <li>Errors, inaccuracies, or malfunctions of the tools</li>
              <li>Data loss or damage resulting from the use of the tools</li>
              <li>Decisions made based on the results generated by our tools</li>
            </ul>
            <p>Please independently verify critical results before using them in production environments.</p>

            <h2 class="h5 mb-3 mt-4">9. Your Rights</h2>
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
  </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
