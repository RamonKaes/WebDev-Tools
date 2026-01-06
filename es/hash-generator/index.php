<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'hashGeneratorTool';
$lang = 'es';$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';
$customAboutContent = <<<HTML
<p class="mb-2">
    Genera hashes criptográficos para texto y archivos con múltiples algoritmos.
    Ideal para verificar integridad de datos, almacenar contraseñas y aplicaciones de seguridad.
</p>
<p class="mb-0">
    Esta herramienta admite los algoritmos más populares, como MD5, SHA-1, SHA-256, SHA-512 y más.
    Todos los cálculos se ejecutan en tu navegador para garantizar máxima privacidad y seguridad.
</p>
HTML;

$features = [
    'Varios algoritmos: MD5, SHA-1, SHA-256, SHA-384, SHA-512',
    'Hashea texto y archivos',
    'Compara hashes para verificación',
    'Soporte HMAC con claves personalizadas',
    'Salida en mayúsculas o minúsculas',
    'Copiar resultados con un clic',
    'Generación en tiempo real',
    'Procesamiento 100 % local: tus datos nunca salen del navegador'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Consideraciones de seguridad</h2>
    <ul class="mb-0">
        <li>Usa SHA-256 o superior: MD5 y SHA-1 están rotos criptográficamente</li>
        <li>No almacenes contraseñas con hashes simples: utiliza bcrypt, scrypt o PBKDF2</li>
        <li>Añade salt a las contraseñas: evita ataques con tablas rainbow</li>
        <li>Verifica el hash completo: compara siempre toda la cadena, no solo una parte</li>
        <li>Emplea HMAC para autenticación: proporciona integridad y autenticidad</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Verificación de integridad: asegurarse de que una descarga no fue alterada</li>
    <li>Almacenamiento de contraseñas: guardar hashes seguros (usa SHA-256 o superior)</li>
    <li>Deduplicación de datos: identificar archivos o contenidos duplicados</li>
    <li>Generación de checksums: crear sumas de verificación para validar datos</li>
    <li>Firmas digitales: componente clave en sistemas de firma criptográfica</li>
    <li>Autenticación API: generar firmas HMAC para peticiones</li>
</ul>
HTML
    ],
    [
        'title' => 'Elegir el algoritmo adecuado',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5: rápido pero no recomendado (128 bits, colisiones conocidas)</li>
    <li>SHA-1: obsoleto para seguridad (160 bits, ataques de colisión)</li>
    <li>SHA-256: estándar en la industria (256 bits, muy seguro)</li>
    <li>SHA-384: variante con mayor seguridad (384 bits)</li>
    <li>SHA-512: máxima seguridad (512 bits)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'Funciones hash del NIST',
        'description' => 'Documentación y estándares oficiales sobre algoritmos de hash'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Secure_Hash_Algorithms',
        'title' => 'Algoritmos hash seguros (SHA)',
        'description' => 'Resumen completo de la familia SHA y su seguridad'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'API del navegador para generar resúmenes criptográficos'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP: almacenamiento de contraseñas',
        'description' => 'Mejores prácticas para hash y almacenamiento de contraseñas'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
