<?php
declare(strict_types=1);
ob_start();

$toolId = 'sriGeneratorTool';
$lang   = 'fr';

$featuresSectionTitle = 'Fonctionnalités';
$features = [
    'Générez des hashes SRI depuis une URL, un fichier ou un texte collé',
    'Prend en charge SHA-256, SHA-384 (recommandé) et SHA-512 simultanément',
    'Génère des balises HTML &lt;script&gt; et &lt;link&gt; prêtes à l\'emploi',
    'Copiez l\'attribut integrity et la balise HTML complète en un clic',
    'Confidentialité : tout le hachage s\'exécute côté client dans le navigateur',
    'Exemples rapides pour Bootstrap, jQuery et Alpine.js',
    'Détecte automatiquement le type de ressource (JS ou CSS)',
];

$resourcesSectionTitle = 'Ressources utiles';
$usefulResources = [
    [
        'url'         => 'https://developer.mozilla.org/fr/docs/Web/Security/Subresource_Integrity',
        'title'       => 'MDN : Subresource Integrity',
        'description' => 'Documentation MDN officielle sur le SRI, la compatibilité des navigateurs et le fonctionnement de la vérification d\'intégrité.',
    ],
    [
        'url'         => 'https://www.w3.org/TR/SRI/',
        'title'       => 'Spécification W3C SRI',
        'description' => 'La spécification officielle du W3C définissant le standard Subresource Integrity.',
    ],
    [
        'url'         => 'https://caniuse.com/subresource-integrity',
        'title'       => 'Can I Use — Subresource Integrity',
        'description' => 'Tableau de compatibilité des navigateurs pour l\'attribut integrity.',
    ],
    [
        'url'         => 'https://developer.mozilla.org/fr/docs/Web/API/SubtleCrypto/digest',
        'title'       => 'MDN : SubtleCrypto.digest()',
        'description' => 'Documentation de l\'API Web Crypto utilisée par cet outil pour le hachage sécurisé.',
    ],
];

include __DIR__ . '/../../partials/tool-base.php';
