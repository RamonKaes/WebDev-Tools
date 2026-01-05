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
$pageTitle = 'Política de Privacidad – WebDev-Tools';
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
            <p>Una parte de los datos se recopila para garantizar el correcto funcionamiento del sitio web. Otros datos pueden utilizarse para analizar su comportamiento como usuario. Además, utilizamos Google AdSense para financiar este sitio web gratuito mediante anuncios publicitarios.</p>
            
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
            <p><strong>Nota importante:</strong> esto se refiere exclusivamente al procesamiento de sus datos <em>dentro de las herramientas</em>. Sin embargo, cuando visita el sitio web, se recopilan automáticamente datos técnicos (véase la sección 4) y Google AdSense establece cookies con fines publicitarios (véanse las secciones 6 y 7).</p>

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
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Los hashes SRI completos se pueden verificar en nuestro <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">código fuente</a>.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Política de Seguridad de Contenido (CSP)</h3>
            <p>Implementamos políticas de seguridad de contenido estrictas para prevenir ataques XSS y ejecución de código no autorizado:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Ejecución de scripts basada en nonce (previene inyección de scripts en línea)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Carga restringida de recursos externos (solo desde CDN de confianza)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incrustación de marcos completamente deshabilitada (protección contra clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Ejecución de objetos y plugins bloqueada</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 Encabezados de Seguridad Adicionales</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previene ataques de incrustación de iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previene el rastreo de tipo MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita la fuga de información del referente</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Fuerza conexiones HTTPS con precarga</li>
              <li><strong>Permissions-Policy</strong> - Deshabilita funciones innecesarias del navegador (geolocalización, cámara, micrófono, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Cero Dependencias Externas para Procesamiento de Datos</h3>
            <p>Todas las funciones principales de procesamiento de datos utilizan únicamente APIs nativas del navegador. Las bibliotecas externas se usan solo para componentes de UI (renderizado de código QR) y se cargan con verificación SRI.</p>

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
            <p>Utilizamos cookies cuando visita nuestro sitio web. Las cookies son pequeños archivos de texto que su navegador de Internet almacena en su ordenador. Cuando vuelve a visitar nuestro sitio web, estas cookies proporcionan información para reconocerle automáticamente. Las cookies también incluyen los denominados "ID de usuario", donde la información del usuario se almacena mediante perfiles seudonimizados. Cuando visita nuestro sitio web, le informamos sobre el uso de cookies para los fines mencionados anteriormente y cómo puede oponerse a esto o evitar su almacenamiento ("opt-out") mediante una referencia a nuestra política de privacidad.</p>
            
            <p>Se distinguen los siguientes tipos de cookies:</p>
            <ul>
              <li><strong>Cookies necesarias y esenciales:</strong> las cookies esenciales son cookies que son absolutamente necesarias para el funcionamiento del sitio web con el fin de almacenar determinadas funciones del sitio web, como inicios de sesión, carritos de compra o entradas de usuario, por ejemplo, con respecto al idioma del sitio web.</li>
              <li><strong>Cookies de sesión:</strong> las cookies de sesión son necesarias para reconocer el uso múltiple de una oferta por el mismo usuario (por ejemplo, cuando ha iniciado sesión para determinar su estado de inicio de sesión). Cuando vuelve a visitar nuestro sitio, estas cookies proporcionan información para reconocerle automáticamente. La información obtenida de esta manera se utiliza para optimizar nuestras ofertas y facilitarle el acceso a nuestro sitio. Cuando cierra su navegador o cierra sesión, las cookies de sesión se eliminan.</li>
              <li><strong>Cookies persistentes:</strong> estas cookies permanecen almacenadas incluso después de cerrar el navegador. Se utilizan para almacenar su inicio de sesión, medir el alcance y con fines de marketing. Se eliminan automáticamente después de un período especificado, que puede variar según la cookie. Puede eliminar las cookies en cualquier momento en la configuración de seguridad de su navegador.</li>
              <li><strong>Cookies de terceros (especialmente de anunciantes):</strong> puede configurar los ajustes de su navegador según sus preferencias y, por ejemplo, rechazar las cookies de terceros o todas las cookies. Sin embargo, nos gustaría señalar que es posible que no pueda utilizar todas las funciones de este sitio web si lo hace. Para obtener más información sobre estas cookies, consulte las respectivas políticas de privacidad de los proveedores externos.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Categorías de datos</h3>
            <p>Datos de usuario, cookies, ID de usuario (incluidas las páginas visitadas, información del dispositivo, tiempos de acceso y direcciones IP).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Finalidades del tratamiento</h3>
            <p>La información obtenida de esta manera sirve para optimizar nuestras ofertas web técnica y económicamente y permitirle un acceso más fácil y seguro a nuestro sitio web.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Base jurídica</h3>
            <p>Si procesamos sus datos personales con la ayuda de cookies sobre la base de su consentimiento ("opt-in"), entonces el art. 6, apartado 1, letra a) del RGPD es la base jurídica. De lo contrario, tenemos un interés legítimo en la funcionalidad efectiva, la mejora y el funcionamiento económico del sitio web, en cuyo caso el art. 6, apartado 1, letra f) del RGPD es la base jurídica. La base jurídica también es el art. 6, apartado 1, letra b) del RGPD si las cookies se establecen con el fin de iniciar un contrato, por ejemplo, para pedidos.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Período de conservación / Eliminación</h3>
            <p>Los datos se eliminarán tan pronto como ya no sean necesarios para el fin para el que se recopilaron. En el caso de la recopilación de datos para la provisión del sitio web, este es el caso cuando finaliza la sesión respectiva.</p>
            <p>De lo contrario, las cookies se almacenan en su ordenador y se transmiten a nuestro sitio. Como usuario, por lo tanto, tiene control total sobre el uso de cookies. Puede desactivar o restringir la transmisión de cookies cambiando la configuración en su navegador de Internet. Las cookies que ya se han almacenado se pueden eliminar en cualquier momento. Esto también se puede hacer automáticamente. Si las cookies están desactivadas para nuestro sitio web, es posible que ya no sea posible utilizar todas las funciones del sitio web en su totalidad.</p>
            <p>Aquí encontrará información sobre la eliminación de cookies para diferentes navegadores:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Oposición y "opt-out"</h3>
            <p>Generalmente puede evitar que las cookies se almacenen en su disco duro, independientemente del consentimiento o permiso legal, seleccionando "no aceptar cookies" en la configuración de su navegador. Sin embargo, esto puede resultar en restricciones funcionales de nuestras ofertas. Puede oponerse al uso de cookies de terceros con fines publicitarios a través de un llamado "opt-out" en este sitio web americano (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) o este sitio web europeo (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>).</p>

            <h3 class="h6 mb-2 mt-3">Cookie de preferencia de idioma (técnicamente necesaria)</h3>
            <p>Utilizamos una única cookie para almacenar su preferencia de idioma:</p>
            <ul>
              <li><strong>Nombre de la cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Finalidad:</strong> almacena el idioma de interfaz seleccionado (por ejemplo, "en", "de", "pt")</li>
              <li><strong>Validez:</strong> 30 días</li>
              <li><strong>Datos almacenados:</strong> solo un código de idioma de dos letras</li>
              <li><strong>Tipo:</strong> técnicamente necesaria (habilita la funcionalidad básica de preferencia de idioma)</li>
            </ul>
            <p>Esta cookie no contiene ninguna información personal y se utiliza exclusivamente para proporcionarle contenido en su idioma preferido. Puede eliminar esta cookie en cualquier momento a través de la configuración de su navegador.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Introducción</h3>
            <p>Hemos integrado anuncios del servicio de Google "Adsense" (proveedor de servicios: Google Ireland Limited, n.º de registro: 368047, Gordon House, Barrow Street, Dublín 4, Irlanda) en nuestro sitio web. Los anuncios están marcados con la nota (i) "Anuncios de Google" en cada anuncio.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Categorías de datos y descripción del tratamiento de datos</h3>
            <p>Datos de uso/datos de comunicación; cuando visita nuestro sitio web, Google recibe información de que ha accedido a nuestro sitio web. Para ello, Google coloca un web beacon o cookie en su ordenador. Los datos también se transfieren a los EE. UU. y se analizan allí. Si ha iniciado sesión con una cuenta de Google, Adsense puede asignar los datos a su cuenta. Si no desea que esto suceda, debe cerrar sesión antes de visitar nuestro sitio web. Sin embargo, Google también puede utilizar otra información para este propósito:</p>
            <ul>
              <li>el tipo de sitios web que visita y las aplicaciones móviles instaladas en su dispositivo;</li>
              <li>cookies en su navegador y configuración en su cuenta de Google;</li>
              <li>sitios web y aplicaciones que ha visitado;</li>
              <li>sus actividades en otros dispositivos;</li>
              <li>interacciones previas con anuncios o servicios publicitarios de Google;</li>
              <li>las actividades e información de su cuenta de Google.</li>
            </ul>
            <p>Cuando hace clic en un anuncio de Adsense, Google procesa la dirección IP del usuario (datos de uso), por lo que el procesamiento se seudonimiza (denominado "ID de publicidad") truncando los últimos dos dígitos de la dirección IP. En el caso de la publicidad personalizada, Google no vincula identificadores de cookies o tecnologías similares con categorías especiales de datos personales de conformidad con el art. 9 del RGPD, como el origen étnico, la religión, la orientación sexual o la salud.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Finalidad del tratamiento</h3>
            <p>Hemos activado los anuncios personalizados para mostrarle publicidad más interesante que apoye el uso comercial de nuestro sitio web, aumente su valor para nosotros y mejore su experiencia de usuario. Con la ayuda de la publicidad personalizada, podemos llegar a los usuarios a través de Adsense en función de sus intereses y características demográficas (por ejemplo, "entusiastas del deporte"). Además, el procesamiento se utiliza para el seguimiento, el remarketing y la medición de conversiones, así como para financiar nuestro sitio web.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Base jurídica</h3>
            <p>Si ha dado su consentimiento ("opt-in") para el procesamiento de sus datos personales mediante "Google Adsense con anuncios personalizados", entonces el art. 6, apartado 1, letra a) del RGPD es la base jurídica. De lo contrario, la base jurídica para el procesamiento de sus datos es el art. 6, apartado 1, letra f) del RGPD en función de nuestros intereses legítimos en el análisis, la optimización y el funcionamiento económico eficiente de nuestra publicidad y sitio web.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Transferencia de datos/categoría de destinatarios</h3>
            <p>Google Irlanda, EE. UU.; este sitio web también ha habilitado anuncios de Google AdSense de terceros. Los datos mencionados anteriormente también pueden transferirse a estos proveedores externos, conocidos como "Proveedores externos certificados", que figuran en <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a>.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Período de conservación</h3>
            <p>Los datos se almacenan hasta 24 meses después de la última visita.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Opciones de oposición y eliminación ("opt-out")</h3>
            <p>Puede oponerse o evitar la instalación de cookies por parte de Google Adsense de varias maneras:</p>
            <ul>
              <li>Puede evitar las cookies en su navegador seleccionando la configuración "no aceptar cookies", que también incluye cookies de terceros;</li>
              <li>Puede desactivar los anuncios personalizados en Google directamente a través del enlace <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a>, aunque esta configuración solo permanecerá vigente hasta que elimine sus cookies. Aquí encontrará instrucciones para desactivar la publicidad personalizada en dispositivos móviles: <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a>;</li>
              <li>Puede desactivar los anuncios personalizados de proveedores externos que participan en la iniciativa de autorregulación publicitaria "About Ads" a través del enlace <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> para sitios de EE. UU. o <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> para sitios de la UE. Esta configuración solo permanecerá vigente hasta que elimine todas sus cookies.</li>
              <li>Puede desactivar permanentemente las cookies mediante un complemento del navegador para Chrome, Firefox o Internet Explorer en <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a>. La desactivación de cookies puede significar que ya no podrá utilizar todas las funciones de nuestro sitio web en su totalidad.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Más información</h3>
            <p>En la política de privacidad de Google para publicidad en <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a>, encontrará más información sobre el uso de cookies de Google en anuncios y sus tecnologías publicitarias, duración del almacenamiento, anonimización, datos de ubicación, funcionalidad y sus derechos.</p>

            <h2 class="h5 mb-3 mt-4">7. Contacto por correo electrónico/postal</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Descripción y alcance del tratamiento de datos</h3>
            <p>Cuando se pone en contacto con nosotros por correo postal o correo electrónico, sus datos se procesan con el fin de tramitar su solicitud de contacto.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Base jurídica</h3>
            <p>La base jurídica para el tratamiento de los datos es el art. 6, apartado 1, letra a) del RGPD si ha dado su consentimiento. La base jurídica para el tratamiento de datos transmitidos en el curso de una solicitud de contacto o correo electrónico o carta es el art. 6, apartado 1, letra f) del RGPD. El responsable tiene un interés legítimo en procesar y almacenar los datos para poder responder a las consultas de los usuarios, para preservar pruebas por razones de responsabilidad y para poder cumplir con sus obligaciones legales de retención de cartas comerciales, si corresponde. Si el propósito del contacto es celebrar un contrato, la base jurídica adicional para el procesamiento es el art. 6, apartado 1, letra b) del RGPD.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Almacenamiento en el sistema CRM</h3>
            <p>Podemos almacenar sus datos y solicitud de contacto en nuestro sistema de gestión de relaciones con clientes ("sistema CRM") o un sistema comparable.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Duración del almacenamiento</h3>
            <p>Los datos se eliminarán tan pronto como ya no sean necesarios para el fin para el que se recopilaron. Para los datos personales enviados por correo electrónico, este es el caso cuando la conversación respectiva con usted ha finalizado. La conversación finaliza cuando se puede inferir de las circunstancias que el asunto en cuestión se ha aclarado de manera concluyente. Almacenamos consultas de usuarios que tienen una cuenta o contrato con nosotros durante hasta dos años después del final del contrato. En el caso de obligaciones legales de archivo, la eliminación se lleva a cabo después de su vencimiento de conformidad con las directivas de la UE y las regulaciones nacionales de retención.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Derecho de oposición y derecho de supresión</h3>
            <p>Tiene derecho a retirar su consentimiento para el procesamiento de datos personales en cualquier momento de conformidad con el art. 6, apartado 1, letra a) del RGPD. Si se pone en contacto con nosotros por correo electrónico, puede oponerse al almacenamiento de sus datos personales en cualquier momento.</p>

            <h2 class="h5 mb-3 mt-4">8. Uso de las herramientas bajo su propia responsabilidad</h2>
            <p><strong>Utiliza todas las herramientas de este sitio web bajo su propia responsabilidad.</strong> Aunque nos esforzamos por proporcionar herramientas precisas y confiables, no podemos garantizar que estén libres de errores o sean adecuadas para todos los propósitos.</p>
            <p>No aceptamos ninguna responsabilidad por:</p>
            <ul>
              <li>Errores, inexactitudes o fallos de funcionamiento de las herramientas</li>
              <li>Pérdida de datos o daños resultantes del uso de las herramientas</li>
              <li>Decisiones tomadas en base a los resultados generados por nuestras herramientas</li>
            </ul>
            <p>Verifique de forma independiente los resultados críticos antes de utilizarlos en entornos de producción.</p>

            <h2 class="h5 mb-3 mt-4">9. Sus derechos</h2>
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
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
