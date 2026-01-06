<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'hashGeneratorTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    Générez des empreintes cryptographiques pour du texte et des fichiers à l'aide de plusieurs algorithmes.
    Idéal pour vérifier l'intégrité des données, hacher des mots de passe et assurer la sécurité des applications.
</p>
<p class="mb-0">
    Cet outil prend en charge les principaux algorithmes de hachage, notamment MD5, SHA-1, SHA-256, SHA-512 et bien d'autres.
    Tous les calculs sont réalisés côté client pour une confidentialité et une sécurité maximales.
</p>
HTML;

$features = [
    'Multiples algorithmes : MD5, SHA-1, SHA-256, SHA-384, SHA-512',
    'Hachage de texte et de fichiers',
    'Comparaison des empreintes pour vérification',
    'Prise en charge HMAC avec clés personnalisées',
    'Sortie en majuscules ou minuscules',
    'Copie des empreintes en un clic',
    'Génération en temps réel',
    'Traitement 100 % côté client : vos données restent sur votre appareil'
];

$customNoticeType = 'warning';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-shield-exclamation me-2"></i>Points de vigilance en sécurité</h2>
    <ul class="mb-0">
        <li>Privilégiez SHA-256 ou supérieur&nbsp;: MD5 et SHA-1 sont compromis cryptographiquement</li>
        <li>N'utilisez pas de hachage simple pour les mots de passe&nbsp;: préférez bcrypt, scrypt ou PBKDF2</li>
        <li>Ajoutez un sel pour les mots de passe&nbsp;: empêche les attaques par tables arc-en-ciel</li>
        <li>Vérifiez l'intégrité des empreintes&nbsp;: comparez toujours l'intégralité de la valeur, pas une version tronquée</li>
        <li>Utilisez HMAC pour l'authentification&nbsp;: garantit intégrité et authenticité</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Vérification d'intégrité de fichiers&nbsp;: s'assurer qu'un téléchargement n'a pas été altéré</li>
    <li>Hachage de mots de passe&nbsp;: stocker des empreintes sécurisées (utilisez SHA-256 ou supérieur)</li>
    <li>Déduplication de données&nbsp;: identifier des fichiers ou contenus dupliqués</li>
    <li>Génération de checksums&nbsp;: créer des sommes de contrôle pour valider des données</li>
    <li>Signatures numériques&nbsp;: composant essentiel des systèmes de signature cryptographique</li>
    <li>Authentification API&nbsp;: générer des signatures HMAC pour les requêtes</li>
</ul>
HTML
    ],
    [
        'title' => 'Choisir son algorithme de hachage',
        'icon' => 'info-circle',
        'content' => <<<HTML
<ul>
    <li>MD5&nbsp;: rapide mais déconseillé (128 bits, collisions connues)</li>
    <li>SHA-1&nbsp;: obsolète pour la sécurité (160 bits, attaques par collision)</li>
    <li>SHA-256&nbsp;: standard industriel pour les usages sécurisés (256 bits, robuste)</li>
    <li>SHA-384&nbsp;: variante à sécurité renforcée (384 bits)</li>
    <li>SHA-512&nbsp;: sécurité maximale (512 bits)</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://csrc.nist.gov/projects/hash-functions',
        'title' => 'Fonctions de hachage du NIST',
        'description' => 'Documentation et normes officielles du NIST sur les algorithmes de hachage'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Secure_Hash_Algorithms',
        'title' => 'Algorithmes de hachage sécurisés (SHA)',
        'description' => 'Présentation complète de la famille SHA et de son niveau de sécurité'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/digest',
        'title' => 'MDN SubtleCrypto.digest()',
        'description' => 'Documentation de l\'API navigateur pour générer des condensats cryptographiques'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html',
        'title' => 'OWASP&nbsp;: Stockage des mots de passe',
        'description' => 'Bonnes pratiques de sécurité pour le hachage et le stockage des mots de passe'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
