<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'passwordGeneratorTool';
$lang = 'fr';

$customAboutContent = <<<HTML
<p class="mb-2">
    Générez des mots de passe forts et sécurisés avec une longueur et des jeux de caractères personnalisables.
    Idéal pour créer des mots de passe conformes aux exigences de sécurité.
</p>
<p class="mb-0">
    Cet outil utilise le générateur de nombres aléatoires sécurisé de votre navigateur pour créer des mots de passe cryptographiquement sûrs.
    Toute la génération se fait localement&nbsp;: vos mots de passe ne quittent jamais votre appareil.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Longueur personnalisable (4 à 128 caractères)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Inclure majuscules, minuscules, chiffres et symboles</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Exclure les caractères ambigus (0, O, l, 1, etc.)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Générer plusieurs mots de passe en une fois</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Indicateur de robustesse du mot de passe</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>100&nbsp;% côté client&nbsp;: aucune donnée envoyée au serveur</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Conseils de sécurité</h2>
    <ul class="mb-0">
        <li>La longueur compte&nbsp;: plus un mot de passe est long, plus il est difficile à casser</li>
        <li>Mélangez les types de caractères&nbsp;: combinez majuscules, minuscules, chiffres et symboles</li>
        <li>Évitez les schémas prévisibles&nbsp;: bannissez mots du dictionnaire et informations personnelles</li>
        <li>Un mot de passe unique par service&nbsp;: ne réutilisez jamais le même mot de passe</li>
        <li>Utilisez un gestionnaire de mots de passe&nbsp;: stockez vos identifiants en toute sécurité</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Comptes utilisateurs&nbsp;: créer des mots de passe sécurisés pour de nouveaux comptes</li>
    <li>Clés API&nbsp;: générer des chaînes aléatoires pour l'authentification</li>
    <li>Identifiants de base de données&nbsp;: protéger l'accès aux bases de données</li>
    <li>Réseaux Wi-Fi&nbsp;: définir des mots de passe WPA2/WPA3 robustes</li>
    <li>Clés de chiffrement&nbsp;: créer des phrases secrètes pour le chiffrement</li>
    <li>Administration système&nbsp;: sécuriser les accès administrateur et root</li>
</ul>
HTML
    ],
    [
        'title' => 'Guide de robustesse',
        'content' => <<<HTML
<ul>
    <li>Faible (&lt; 8 caractères)&nbsp;: facilement cassable, à éviter</li>
    <li>Moyen (8-11 caractères)&nbsp;: minimum requis pour la plupart des systèmes</li>
    <li>Bon (12-15 caractères)&nbsp;: recommandé pour les comptes importants</li>
    <li>Fort (16+ caractères)&nbsp;: excellente sécurité, très difficile à casser</li>
    <li>Très fort (20+ caractères)&nbsp;: sécurité maximale pour les systèmes critiques</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://pages.nist.gov/800-63-3/sp800-63b.html',
        'title' => 'NIST SP 800-63B&nbsp;: recommandations d\'identité numérique',
        'description' => 'Directives officielles pour la création de mots de passe et l\'authentification'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
        'title' => 'OWASP&nbsp;: aide-mémoire sur l\'authentification',
        'description' => 'Bonnes pratiques de sécurité pour l\'authentification par mot de passe'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
        'title' => 'MDN Crypto.getRandomValues()',
        'description' => 'API de génération de nombres aléatoires cryptographiquement sûrs'
    ],
    [
        'url' => 'https://www.eff.org/dice',
        'title' => 'EFF Diceware',
        'description' => 'Méthode alternative pour créer des phrases secrètes fortes et mémorisables'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
