<?php

declare(strict_types=1);

$toolId = 'qrCodeGeneratorTool';
$lang = 'fr';

$customAboutContent = <<<HTML
<p class="mb-2">
    Générez instantanément des codes QR pour des URL, du texte, des coordonnées de contact et bien plus.
    Personnalisez les couleurs, la taille et le niveau de correction d'erreur.
</p>
<p class="mb-0">
    Les codes QR (Quick Response) sont des codes-barres bidimensionnels capables de stocker de nombreux types de données
    et peuvent être scannés par des smartphones ou lecteurs QR. Toute la génération se fait dans votre navigateur&nbsp;:
    aucune donnée n'est envoyée à des serveurs externes.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Générer des codes QR pour les URL, textes, numéros de téléphone, e-mails, etc.</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Taille et qualité personnalisables</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Couleurs de premier plan et d'arrière-plan personnalisées</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Niveaux de correction d'erreur (L, M, Q, H)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Téléchargement en PNG ou SVG</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Aperçu en temps réel</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Génération 100&nbsp;% côté client</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Niveaux de correction d'erreur</h2>
    <ul class="mb-0">
        <li>L (Low)&nbsp;: ~7&nbsp;% de correction, adapté aux environnements propres</li>
        <li>M (Medium)&nbsp;: ~15&nbsp;% de correction, recommandé pour la plupart des cas</li>
        <li>Q (Quartile)&nbsp;: ~25&nbsp;% de correction, meilleure tolérance aux dommages</li>
        <li>H (High)&nbsp;: ~30&nbsp;% de correction, fiabilité maximale</li>
    </ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>URL de sites web&nbsp;: accès rapide depuis des supports imprimés</li>
    <li>Coordonnées&nbsp;: vCards pour partager des contacts facilement</li>
    <li>Identifiants Wi-Fi&nbsp;: partager un réseau sans saisie manuelle</li>
    <li>Informations produit&nbsp;: lier vers des manuels ou fiches produits</li>
    <li>Billetterie&nbsp;: tickets numériques et systèmes d'enregistrement</li>
    <li>Paiements&nbsp;: liens de paiement rapides</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.iso.org/standard/62021.html',
        'title' => 'ISO/IEC 18004:2015 - norme QR Code',
        'description' => 'Norme internationale officielle décrivant la symbologie des codes QR'
    ],
    [
        'url' => 'https://www.qrcode.com/en/about/',
        'title' => 'QR Code.com - Informations officielles',
        'description' => 'Informations fournies par DENSO WAVE, créateur du QR Code'
    ],
    [
        'url' => 'https://github.com/davidshimjs/qrcodejs',
        'title' => 'Documentation de la bibliothèque QRCode.js',
        'description' => 'Bibliothèque JavaScript pour générer des codes QR dans le navigateur'
    ],
    [
        'url' => 'https://fr.wikipedia.org/wiki/Code_QR',
        'title' => 'Code QR - Wikipédia',
        'description' => 'Présentation complète de la technologie et des usages des codes QR'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
