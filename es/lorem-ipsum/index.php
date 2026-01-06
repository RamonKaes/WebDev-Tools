<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'es';$featuresSectionTitle = 'Características';
$resourcesSectionTitle = 'Recursos Útiles';
$customAboutContent = <<<HTML
<p class="mb-2">
    Genera texto de relleno (Lorem Ipsum) para tus maquetas, prototipos y diseños.
    Personaliza párrafos, frases o palabras según lo necesites.
</p>
<p class="mb-0">
    Lorem Ipsum es el texto estándar utilizado por diseñadores y desarrolladores desde el siglo XVI.
    Esta herramienta te ayuda a producir la cantidad ideal de contenido ficticio para tus proyectos y centrarte en el diseño.
</p>
HTML;

$features = [
    'Genera párrafos, frases o palabras',
    'Cantidad personalizable (1-100 unidades)',
    'Opcionalmente comienza con «Lorem ipsum dolor sit amet...»',
    'Salida en texto plano o con etiquetas HTML <p>',
    'Copiar al portapapeles con un clic',
    'Conteo de palabras y caracteres en tiempo real'
];

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Sobre Lorem Ipsum</h2>
    <p class="mb-2">
        Lorem Ipsum proviene de las secciones 1.10.32 y 1.10.33 de «De Finibus Bonorum et Malorum» de Cicerón, escrito en el año 45 a.C.
        Se ha utilizado como texto de relleno estándar desde el siglo XVI.
    </p>
    <p class="mb-0">
        <strong>¿Por qué usar Lorem Ipsum?</strong> Presenta una distribución de letras similar al español o inglés,
        lo que ayuda a simular texto real sin distraer con contenido significativo.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Casos de uso comunes',
        'content' => <<<HTML
<ul>
    <li>Maquetas web: rellenar diseños con texto realista</li>
    <li>Diseño impreso: previsualizar revistas, folletos, etc.</li>
    <li>Prototipos UI/UX: probar interfaces con contenido ficticio</li>
    <li>Pruebas de tipografía: evaluar tipografías y espaciado</li>
    <li>Sistemas de contenidos: poblar plantillas en desarrollo</li>
    <li>Presentaciones a clientes: mostrar propuestas antes del contenido definitivo</li>
</ul>
HTML
    ],
    [
        'title' => 'Consejos para usar texto de relleno',
        'content' => <<<HTML
<ul>
    <li>Ajusta la longitud: usa una cantidad similar al contenido final</li>
    <li>Recuerda reemplazarlo: sustituye el Lorem Ipsum antes de publicar</li>
    <li>Prueba casos extremos: utiliza texto muy largo y muy corto para comprobar la respuesta del diseño</li>
    <li>Cuida la legibilidad: incluso el texto ficticio debe reflejar buena tipografía</li>
    <li>Emplea etiquetas HTML: incluye &lt;p&gt; si necesitas formato estructurado</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://es.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipedia',
        'description' => 'Historia y origen del texto de relleno Lorem Ipsum'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - Generador Lorem Ipsum',
        'description' => 'Recurso clásico para generar y conocer Lorem Ipsum'
    ],
    [
        'url' => 'https://www.smashingmagazine.com/2010/01/lorem-ipsum-killing-designs/',
        'title' => 'Smashing Magazine: Lorem Ipsum daña tu diseño',
        'description' => 'Por qué el texto de relleno puede perjudicar tu proceso de diseño y la experiencia de usuario'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
