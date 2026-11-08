<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'es';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/es';
$homeUrl = BASE_PATH . '/es';
$pageTitle = 'Política Privacidad – Protección Datos WebDev-Tools Online';
$pageDescription = 'Política de privacidad e información sobre protección de datos para WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
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
          <h1 class="display-5 mb-3">Política de Privacidad</h1>
          <p class="lead text-secondary">Su privacidad es importante</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Protección de datos de un vistazo</h2>
            
            <h3 class="h6 mb-2">Información general</h3>
            <p>La siguiente información ofrece una visión general sencilla sobre lo que ocurre con sus datos personales cuando visita este sitio web. Los datos personales son todos aquellos datos con los que se le puede identificar personalmente.</p>

            <h3 class="h6 mb-2 mt-3">Recopilación de datos en este sitio web</h3>
            <p><strong>¿Quién es responsable de la recopilación de datos en este sitio web?</strong></p>
            <p>El tratamiento de los datos en este sitio web lo realiza el operador del mismo. Sus datos de contacto se encuentran en el aviso legal de este sitio web.</p>
            
            <p><strong>¿Cómo recopilamos sus datos?</strong></p>
            <p>Por un lado, sus datos se recopilan cuando usted nos los facilita. Por ejemplo, pueden ser datos que nos envía por correo electrónico.</p>
            <p>Otros datos son recopilados automáticamente o con su consentimiento cuando visita el sitio web a través de nuestros sistemas informáticos. Se trata principalmente de datos técnicos (por ejemplo, navegador de Internet, sistema operativo o hora de acceso a la página). La recopilación de estos datos se realiza automáticamente tan pronto como accede a este sitio web.</p>
            
            <p><strong>¿Para qué utilizamos sus datos?</strong></p>
            <p>Una parte de los datos se recopila para garantizar el correcto funcionamiento del sitio web (archivos de registro del servidor, véase la sección 4). Además, dos herramientas cargan cada una una biblioteca JavaScript desde una red de distribución de contenidos (véase la sección 3.3). No utilizamos servicios de análisis, seguimiento ni publicidad.</p>
            
            <p><strong>¿Qué derechos tiene con respecto a sus datos?</strong></p>
            <p>Tiene derecho a obtener en cualquier momento y de forma gratuita información sobre el origen, los destinatarios y la finalidad de sus datos personales almacenados. También tiene derecho a solicitar la rectificación o supresión de estos datos. Si ha dado su consentimiento para el tratamiento de datos, puede revocarlo en cualquier momento con efecto futuro. Además, en determinadas circunstancias, tiene derecho a solicitar la limitación del tratamiento de sus datos personales. Además, tiene derecho a presentar una reclamación ante la autoridad de control competente.</p>

            <h2 class="h5 mb-3 mt-4">2. Enfoque de «privacidad primero» para las herramientas</h2>
            <p><strong>Todas las herramientas de este sitio web procesan los datos que usted introduce exclusivamente en su navegador.</strong> Si utiliza nuestras herramientas (por ejemplo, el codificador Base64, el formateador JSON, etc.), se aplica lo siguiente:</p>
            <ul>
              <li>Todas las conversiones, validaciones y generaciones se realizan en el lado del cliente, en su navegador</li>
              <li>Los datos que introduce en las herramientas nunca salen de su dispositivo</li>
              <li>No almacenamos, registramos ni tenemos acceso a los datos que procesa con nuestras herramientas</li>
              <li>No podemos proporcionar información sobre los datos introducidos en las herramientas que no tenemos, ya que no los recopilamos</li>
            </ul>
            <p><strong>Nota importante:</strong> esto se refiere exclusivamente al procesamiento de sus datos <em>dentro de las herramientas</em>. Sin embargo, cuando visita el sitio web, se recopilan automáticamente datos técnicos en los archivos de registro del servidor (véase la sección 4) y, cuando utiliza el generador de códigos QR o minifica JavaScript en el formateador de código, se carga una biblioteca desde una CDN (véase la sección 3.3).</p>

            <h2 class="h5 mb-3 mt-4">3. Seguridad y Transparencia</h2>

            <p>Implementamos múltiples capas de seguridad para proteger su privacidad y garantizar la integridad de nuestras herramientas:</p>

            <h3 class="h6 mb-2 mt-3">3.1 Código Abierto y Auditabilidad</h3>
            <p>El código fuente completo está disponible públicamente en GitHub. Puede revisar, auditar o bifurcar el proyecto en cualquier momento:</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositorio GitHub de WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Integridad de Subrecursos (SRI)</h3>
            <p>Todas las bibliotecas externas se cargan con hashes criptográficos SRI para prevenir manipulaciones. Esto asegura que el código de terceros no pueda ser modificado sin detección:</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Biblioteca</th>
                    <th>Versión</th>
                    <th>Hash SRI (SHA-384)</th>
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
            <p><small class="text-muted">Los hashes SRI completos se pueden verificar en nuestro código fuente (<a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">config/tools.php</a> y <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/assets/js/tools/codeFormatterTool.js" target="_blank" rel="noopener noreferrer">codeFormatterTool.js</a>).</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Entrega de contenido de terceros (CDN)</h3>
            <p>Bootstrap, la fuente de iconos y todos los demás recursos se alojan en nuestro propio servidor. Solo dos herramientas cargan una única biblioteca JavaScript desde la red de distribución de contenidos jsDelivr (cdn.jsdelivr.net), operada por Prospect One (jsDelivr) y distribuida a través de varios proveedores de CDN, entre ellos Cloudflare y Fastly:</p>
            <ul>
              <li><strong>Generador de códigos QR:</strong> carga <code>qrcode-generator</code> al abrir la página de la herramienta.</li>
              <li><strong>Formateador de código:</strong> carga <code>terser</code> únicamente cuando usted minifica código JavaScript.</li>
            </ul>
            <p>Al cargar una de estas bibliotecas, su navegador se conecta directamente a la CDN y transmite los datos técnicamente necesarios para ello, en particular su dirección IP, su agente de usuario (user agent) y la página de origen (referrer). Nosotros no recibimos ningún dato de este proceso. Las bibliotecas están protegidas mediante hashes SRI (véase 3.2), por lo que no pueden modificarse sin que se detecte. Aparte de esto, este sitio web no realiza ninguna solicitud a servidores de terceros; únicamente el generador SRI recupera la URL del recurso que usted mismo introduce.</p>
            <p>La base jurídica es el art. 6, apartado 1, letra f) del RGPD; nuestro interés legítimo reside en ofrecer estas herramientas de forma fiable y eficiente. Encontrará más información en la política de privacidad de jsDelivr: <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener">https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net</a></p>

            <h3 class="h6 mb-2 mt-3">3.4 Política de Seguridad de Contenido (CSP)</h3>
            <p>Implementamos políticas de seguridad de contenido estrictas para prevenir ataques XSS y ejecución de código no autorizado:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Ejecución de scripts basada en nonce (previene inyección de scripts en línea)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Carga restringida de recursos externos (scripts solo desde nuestro propio servidor y cdn.jsdelivr.net)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incrustación de marcos completamente deshabilitada (protección contra clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Ejecución de objetos y plugins bloqueada</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Encabezados de Seguridad Adicionales</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previene ataques de incrustación de iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previene el rastreo de tipo MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita la fuga de información del referente</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Fuerza conexiones HTTPS con precarga</li>
              <li><strong>Permissions-Policy</strong> - Deshabilita funciones innecesarias del navegador (geolocalización, cámara, micrófono, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.6 Cero Dependencias Externas para Procesamiento de Datos</h3>
            <p>Todas las funciones principales de procesamiento de datos utilizan únicamente APIs nativas del navegador. Las bibliotecas externas se usan solo para dos funciones auxiliares (renderizado de códigos QR y minificación de JavaScript) y se cargan con verificación SRI.</p>

            <h2 class="h5 mb-3 mt-4">4. Alojamiento y archivos de registro del servidor</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Descripción y alcance del tratamiento de datos</h3>
            <p>Este sitio web está alojado en un proveedor de servicios externo. Si utiliza nuestro sitio web únicamente con fines informativos (es decir, sin registrarse ni transmitir información de ningún otro modo), solo recopilamos los datos personales que su navegador transmite a nuestro servidor. Si desea ver nuestro sitio web, recopilamos los siguientes datos:</p>
            <ul>
              <li>Dirección IP</li>
              <li>Proveedor de servicios de Internet del usuario</li>
              <li>Fecha y hora del acceso</li>
              <li>Tipo de navegador</li>
              <li>Idioma y versión del navegador</li>
              <li>Contenido de la solicitud</li>
              <li>Zona horaria</li>
              <li>Estado de acceso/código de estado HTTP</li>
              <li>Volumen de datos</li>
              <li>Sitios web de los que procede la solicitud (URL de referencia)</li>
              <li>Sistema operativo</li>
            </ul>
            <p>Estos datos no se almacenan junto con otros datos personales suyos.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Finalidad del tratamiento</h3>
            <p>Estos datos se utilizan con el fin de proporcionarle un sitio web fácil de usar, funcional y seguro, con funciones y contenidos, así como para su optimización y evaluación estadística. Los datos se utilizan exclusivamente para el funcionamiento técnico y la seguridad del sitio web.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Base jurídica</h3>
            <p>La base jurídica es nuestro interés legítimo en el tratamiento de datos de conformidad con el art. 6, apartado 1, letra f) del RGPD, que también se refleja en los fines mencionados anteriormente.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Período de conservación</h3>
            <p>Por razones de seguridad, almacenamos estos datos en archivos de registro del servidor durante un período de conservación de 60 días. Una vez transcurrido este plazo, se eliminan automáticamente, a menos que necesitemos conservarlos con fines probatorios en caso de ataques a la infraestructura del servidor u otras infracciones legales. Los datos no se fusionan con otras fuentes de datos.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookies utilizadas</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Información general sobre las cookies</h3>
            <p>Las cookies son pequeños archivos de texto que su navegador de Internet almacena en su dispositivo. Este sitio web utiliza <strong>exactamente una cookie</strong>, que es técnicamente necesaria. No utilizamos cookies de sesión, de análisis, de seguimiento ni de terceros, y no se crean perfiles de usuario. Dado que no se utilizan cookies que requieran consentimiento, no se muestra ningún banner de cookies.</p>

            <h3 class="h6 mb-2 mt-3">5.2 Cookie de preferencia de idioma (técnicamente necesaria)</h3>
            <p>Utilizamos una única cookie para almacenar su preferencia de idioma:</p>
            <ul>
              <li><strong>Nombre de la cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Finalidad:</strong> almacena el idioma de interfaz seleccionado (por ejemplo, "en", "de", "pt")</li>
              <li><strong>Validez:</strong> 30 días</li>
              <li><strong>Datos almacenados:</strong> solo un código de idioma de dos letras</li>
              <li><strong>Tipo:</strong> técnicamente necesaria (habilita la funcionalidad básica de preferencia de idioma)</li>
            </ul>
            <p>Esta cookie no contiene ninguna información personal y se utiliza exclusivamente para proporcionarle contenido en su idioma preferido. Puede eliminar esta cookie en cualquier momento a través de la configuración de su navegador.</p>

            <h3 class="h6 mb-2 mt-3">5.3 Base jurídica</h3>
            <p>La base jurídica es el art. 6, apartado 1, letra f) del RGPD. Nuestro interés legítimo reside en ofrecerle el sitio web en el idioma que ha seleccionado sin tener que preguntárselo en cada visita a una página. La cookie es estrictamente necesaria para esta función, por lo que no se requiere consentimiento.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Período de conservación / Eliminación</h3>
            <p>La cookie se elimina automáticamente después de 30 días o en cuanto usted la elimina manualmente. Puede impedir el almacenamiento de cookies en cualquier momento a través de la configuración de su navegador; en ese caso, su selección de idioma no se guardará y el sitio web recurrirá a la detección automática del idioma (URL, idioma del navegador). Aquí encontrará información sobre la eliminación de cookies para diferentes navegadores:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h2 class="h5 mb-3 mt-4">6. Contacto por correo electrónico/postal</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Descripción y alcance del tratamiento de datos</h3>
            <p>Cuando se pone en contacto con nosotros por correo postal o correo electrónico, sus datos se procesan con el fin de tramitar su solicitud de contacto.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Base jurídica</h3>
            <p>La base jurídica para el tratamiento de los datos es el art. 6, apartado 1, letra a) del RGPD si ha dado su consentimiento. La base jurídica para el tratamiento de datos transmitidos en el curso de una solicitud de contacto o correo electrónico o carta es el art. 6, apartado 1, letra f) del RGPD. El responsable tiene un interés legítimo en procesar y almacenar los datos para poder responder a las consultas de los usuarios, para preservar pruebas por razones de responsabilidad y para poder cumplir con sus obligaciones legales de retención de cartas comerciales, si corresponde. Si el propósito del contacto es celebrar un contrato, la base jurídica adicional para el procesamiento es el art. 6, apartado 1, letra b) del RGPD.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Almacenamiento en el sistema CRM</h3>
            <p>Podemos almacenar sus datos y solicitud de contacto en nuestro sistema de gestión de relaciones con clientes ("sistema CRM") o un sistema comparable.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Duración del almacenamiento</h3>
            <p>Los datos se eliminarán tan pronto como ya no sean necesarios para el fin para el que se recopilaron. Para los datos personales enviados por correo electrónico, este es el caso cuando la conversación respectiva con usted ha finalizado. La conversación finaliza cuando se puede inferir de las circunstancias que el asunto en cuestión se ha aclarado de manera concluyente. Almacenamos consultas de usuarios que tienen una cuenta o contrato con nosotros durante hasta dos años después del final del contrato. En el caso de obligaciones legales de archivo, la eliminación se lleva a cabo después de su vencimiento de conformidad con las directivas de la UE y las regulaciones nacionales de retención.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Derecho de oposición y derecho de supresión</h3>
            <p>Tiene derecho a retirar su consentimiento para el procesamiento de datos personales en cualquier momento de conformidad con el art. 6, apartado 1, letra a) del RGPD. Si se pone en contacto con nosotros por correo electrónico, puede oponerse al almacenamiento de sus datos personales en cualquier momento.</p>

            <h2 class="h5 mb-3 mt-4">7. Uso de las herramientas bajo su propia responsabilidad</h2>
            <p><strong>Utiliza todas las herramientas de este sitio web bajo su propia responsabilidad.</strong> Aunque nos esforzamos por proporcionar herramientas precisas y confiables, no podemos garantizar que estén libres de errores o sean adecuadas para todos los propósitos.</p>
            <p>No aceptamos ninguna responsabilidad por:</p>
            <ul>
              <li>Errores, inexactitudes o fallos de funcionamiento de las herramientas</li>
              <li>Pérdida de datos o daños resultantes del uso de las herramientas</li>
              <li>Decisiones tomadas en base a los resultados generados por nuestras herramientas</li>
            </ul>
            <p>Verifique de forma independiente los resultados críticos antes de utilizarlos en entornos de producción.</p>

            <h2 class="h5 mb-3 mt-4">8. Sus derechos</h2>
            <p>Tiene los siguientes derechos según el RGPD:</p>
            <ul>
              <li><strong>Derecho de acceso (art. 15 RGPD):</strong> tiene derecho a solicitar información sobre sus datos personales procesados por nosotros.</li>
              <li><strong>Derecho de rectificación (art. 16 RGPD):</strong> tiene derecho a solicitar la rectificación inmediata de datos personales inexactos o la completación de datos personales incompletos.</li>
              <li><strong>Derecho de supresión (art. 17 RGPD):</strong> tiene derecho a solicitar la supresión de sus datos personales.</li>
              <li><strong>Limitación del tratamiento (art. 18 RGPD):</strong> tiene derecho a solicitar la limitación del tratamiento de sus datos personales.</li>
              <li><strong>Portabilidad de datos (art. 20 RGPD):</strong> tiene derecho a recibir sus datos personales en un formato estructurado, de uso común y legible por máquina.</li>
              <li><strong>Derecho de oposición (art. 21 RGPD):</strong> tiene derecho a oponerse al tratamiento de datos personales que le conciernen en cualquier momento por razones derivadas de su situación particular.</li>
              <li><strong>Retirada del consentimiento (art. 7, apartado 3 RGPD):</strong> tiene derecho a retirar su consentimiento en cualquier momento.</li>
              <li><strong>Derecho a presentar una reclamación (art. 77 RGPD):</strong> tiene derecho a presentar una reclamación ante una autoridad de control.</li>
            </ul>
            <p>Si tiene alguna pregunta sobre la protección de datos, póngase en contacto con nosotros utilizando los datos de contacto que figuran en el aviso legal.</p>

          </div>
        </div>

    </div>
  </main>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
