<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'es';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera contraseñas fuertes y seguras con longitud y conjuntos de caracteres personalizables.
    Perfecto para cumplir con requisitos de seguridad exigentes.
</p>
<p class="mb-0">
    Esta herramienta utiliza el generador de números aleatorios seguro del navegador para crear contraseñas criptográficamente sólidas.
    Todo ocurre localmente: las contraseñas nunca se envían a ningún servidor.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Longitud configurable (4-128 caracteres)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Incluye mayúsculas, minúsculas, números y símbolos</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Excluye caracteres ambiguos (0, O, l, 1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Genera varias contraseñas a la vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indicador de fortaleza de la contraseña</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copiar al portapapeles con un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Procesamiento 100 % local: ninguna contraseña abandona tu dispositivo</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Consejos de seguridad para contraseñas</h2>
    <ul class="mb-0">
        <li>La longitud importa: cuanto más larga, más difícil de descifrar</li>
        <li>Mezcla todos los tipos de caracteres: mayúsculas, minúsculas, números y símbolos</li>
        <li>Evita patrones: no uses palabras de diccionario ni datos personales</li>
        <li>Una contraseña única por servicio: no reutilices contraseñas</li>
        <li>Utiliza un gestor de contraseñas: almacena las contraseñas generadas de forma segura</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Cuentas de usuario: crear contraseñas seguras para nuevos registros</li>
    <li>Claves API: generar cadenas aleatorias para autenticación</li>
    <li>Credenciales de bases de datos: proteger el acceso a la infraestructura</li>
    <li>Redes Wi-Fi: establecer contraseñas WPA2/WPA3 robustas</li>
    <li>Claves de cifrado: crear frases secretas seguras</li>
    <li>Administración de sistemas: asegurar accesos root y administrativos</li>
</ul>
HTML
    ],
    [
        'title' => 'Guía de fortaleza',
        'content' => <<<HTML
<ul>
    <li>Débil (&lt; 8 caracteres): fácil de vulnerar, evita este rango</li>
    <li>Aceptable (8-11 caracteres): mínimo para muchos servicios</li>
    <li>Buena (12-15 caracteres): recomendada para cuentas importantes</li>
    <li>Fuerte (16+ caracteres): excelente seguridad, muy difícil de romper</li>
    <li>Muy fuerte (20+ caracteres): máximo nivel para sistemas críticos</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://es.wikipedia.org/wiki/Contrase%C3%B1a',
        'title' => 'Wikipedia: Contraseña',
        'description' => 'Introducción accesible a los conceptos de seguridad de contraseñas'
    ],
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B: directrices de identidad digital',
        'description' => 'Recomendaciones oficiales para creación de contraseñas y autenticación'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP: guía de autenticación',
        'description' => 'Buenas prácticas de seguridad para autenticación basada en contraseñas'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'API para generar números aleatorios criptográficamente seguros'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'Generador de passphrases Diceware',
        'description' => 'Método alternativo para crear frases secretas fuertes y memorizables'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
