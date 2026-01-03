<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'uuidGeneratorTool';
$lang = 'fr';

$customAboutContent = <<<HTML
<p class="mb-2">
    Générez instantanément des identifiants uniques (UUID/GUID) pour vos applications, bases de données et API.
    Prise en charge de plusieurs versions d'UUID avec une génération cryptographiquement sécurisée.
</p>
<p class="mb-0">
    Les UUID (Identifiants Universellement Uniques) sont des valeurs de 128 bits utilisées pour identifier de manière unique
    des informations dans les systèmes informatiques. Cet outil crée des UUID conformes aux standards, garantissant leur unicité dans le temps et l'espace.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Génération d'UUID v4 (aléatoires) avec sécurité cryptographique</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Génération en lot&nbsp;: créez plusieurs UUID d'un coup</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Plusieurs formats de sortie&nbsp;: standard, majuscules, sans tirets</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie individuelle ou globale en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Conforme à la RFC 4122</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Aucun appel serveur&nbsp;: 100&nbsp;% côté client</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Génération instantanée sans latence</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>À propos de l'UUID version 4</h2>
    <p class="mb-2">
        Le format UUID v4 repose sur des nombres aléatoires. La forme est&nbsp;:
    </p>
    <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>
    <p class="mt-2 mb-0">
        Où <code>x</code> représente n'importe quel chiffre hexadécimal et <code>y</code> vaut 8, 9, A ou B.
        Le 4 indique la version de l'UUID, et les bits de variante assurent la conformité à la RFC.
        Avec 122 bits aléatoires, la probabilité de collision est infinitésimale.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Clés primaires de base de données&nbsp;: identifiants uniques pour les enregistrements</li>
    <li>Identifiants de requêtes API&nbsp;: suivre et corréler les requêtes</li>
    <li>Jetons de session&nbsp;: générer des identifiants de session sécurisés</li>
    <li>Noms de fichiers&nbsp;: éviter les collisions lors de l'upload</li>
    <li>Systèmes distribués&nbsp;: créer des IDs sans coordination centrale</li>
    <li>Identifiants de transaction&nbsp;: distinguer chaque opération commerciale</li>
</ul>
HTML
    ],
    [
        'title' => 'Format d\'un UUID',
        'content' => <<<HTML
<p>Un UUID s'écrit généralement sur 32 chiffres hexadécimaux répartis en 5 groupes&nbsp;:</p>
<code>8-4-4-4-12</code>
<p class="mt-2">Exemple&nbsp;: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
<ul class="mt-2">
    <li>Format standard&nbsp;: minuscules avec tirets (le plus courant)</li>
    <li>Format majuscule&nbsp;: majuscules avec tirets (préféré par certaines API)</li>
    <li>Format compact&nbsp;: sans tirets, 32 caractères hexadécimaux</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc4122',
        'title' => 'RFC 4122&nbsp;: espace de noms UUID',
        'description' => 'Spécification officielle du format et de la génération des UUID'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc9562',
        'title' => 'RFC 9562&nbsp;: UUID versions 6, 7 et 8',
        'description' => 'Dernières spécifications des nouvelles versions d\'UUID basés sur l\'horodatage'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/randomUUID',
        'title' => 'MDN Crypto.randomUUID()',
        'description' => 'API navigateur pour générer des UUID sécurisés'
    ],
    [
        'url' => 'https://fr.wikipedia.org/wiki/Universally_unique_identifier',
        'title' => 'UUID - Wikipédia',
        'description' => 'Présentation complète des versions et usages des UUID'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
