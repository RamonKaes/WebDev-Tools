<?php

declare(strict_types=1);

$toolId = 'uuidGeneratorTool';
$lang = 'es';

$customAboutContent = <<<HTML
<p class="mb-2">
    Genera identificadores únicos (UUID/GUID) al instante para aplicaciones, bases de datos y APIs.
    Soporta varias versiones de UUID con generación criptográficamente segura.
</p>
<p class="mb-0">
    Los UUID (Identificadores Únicos Universales) son valores de 128 bits utilizados para identificar de forma inequívoca
    información en sistemas informáticos. Esta herramienta crea UUID conformes a los estándares y garantiza su unicidad.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Genera UUID v4 (aleatorios) con seguridad criptográfica</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generación masiva: crea múltiples UUID de un golpe</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formatos alternativos: estándar, mayúsculas, sin guiones</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copiar UUID individual o todos a la vez</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cumple la RFC 4122</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Sin comunicación con el servidor: 100 % local</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Generación inmediata sin esperas</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Sobre los UUID versión 4</h2>
    <p class="mb-2">
        Los UUID v4 se basan en números aleatorios. Su formato es:
    </p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">
        Donde <code>x</code> es cualquier dígito hexadecimal y <code>y</code> es 8, 9, A o B.
        El 4 indica la versión, y los bits de variante aseguran la conformidad con la RFC.
        Con 122 bits aleatorios, la probabilidad de colisión es prácticamente nula.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Claves primarias: identificar registros en bases de datos distribuidas</li>
    <li>IDs de peticiones API: rastrear y correlacionar solicitudes</li>
    <li>Tokens de sesión: generar identificadores seguros para sesiones</li>
    <li>Nombres de archivos: evitar conflictos al almacenar archivos</li>
    <li>Sistemas distribuidos: crear IDs sin coordinación central</li>
    <li>Transacciones: identificar operaciones financieras o de negocio</li>
</ul>
HTML
    ],
    [
        'title' => 'Formato de un UUID',
        'content' => <<<HTML
<p>Un UUID suele representarse con 32 dígitos hexadecimales en 5 grupos:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Ejemplo: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Formato estándar: minúsculas con guiones</li>
    <li>Formato mayúsculas: mayúsculas con guiones</li>
    <li>Formato compacto: sin guiones, solo 32 caracteres hexadecimales</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122: espacio de nombres UUID',
        'description' => 'Especificación oficial para el formato y generación de UUID'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562: UUID versiones 6, 7 y 8',
        'description' => 'Últimas especificaciones para nuevas variantes de UUID basadas en tiempo'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'API del navegador para generar UUID criptográficamente seguros'
    ],
    [
        'url' => 'https://es.wikipedia.org/wiki/Identificador_%C3%BAnico_universal',
        'title' => 'UUID - Wikipedia',
        'description' => 'Descripción general de las versiones y usos de los UUID'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
