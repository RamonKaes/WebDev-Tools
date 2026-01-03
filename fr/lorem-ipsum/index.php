<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'fr';

$customAboutContent = <<<HTML
<p class="mb-2">
    Générez du texte factice (Lorem Ipsum) pour vos maquettes, prototypes et mises en page.
    Personnalisez le nombre de paragraphes, de phrases ou de mots selon vos besoins.
</p>
<p class="mb-0">
    Lorem Ipsum est le standard de l'industrie utilisé par les designers et développeurs depuis les années 1500.
    Cet outil vous aide à générer la quantité idéale de texte de remplissage afin de vous concentrer sur la conception sans vous soucier du contenu.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Générer des paragraphes, phrases ou mots</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quantité personnalisable (1 à 100 unités)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Démarrer par «&nbsp;Lorem ipsum dolor sit amet...&nbsp;»</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Option d'encapsulation dans des balises HTML &lt;p&gt;</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Sortie en texte brut</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Compteur de mots et de caractères en temps réel</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
    <h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>À propos de Lorem Ipsum</h2>
    <p class="mb-2">
        Lorem Ipsum provient des sections 1.10.32 et 1.10.33 de «&nbsp;de Finibus Bonorum et Malorum&nbsp;» (Des extrêmes du bien et du mal) de Cicéron, écrit en 45 av. J.-C.
        Il est utilisé comme texte de remplissage standard depuis les années 1500.
    </p>
    <p class="mb-0">
        <strong>Pourquoi utiliser Lorem Ipsum&nbsp;?</strong> Sa répartition des lettres le fait ressembler à de l'anglais lisible,
        ce qui permet de visualiser l'apparence du contenu réel sans être distrait par le texte.
    </p>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Maquettes web&nbsp;: remplir les mises en page avec un texte réaliste</li>
    <li>Design imprimé&nbsp;: prévisualiser la mise en page dans des brochures, magazines, etc.</li>
    <li>Prototypage UI/UX&nbsp;: tester les interfaces avec du contenu de remplacement</li>
    <li>Tests de typographie&nbsp;: évaluer les polices et les espacements</li>
    <li>Systèmes de gestion de contenu&nbsp;: alimenter les gabarits pendant le développement</li>
    <li>Présentations clients&nbsp;: montrer des concepts avant la rédaction du contenu final</li>
</ul>
HTML
    ],
    [
        'title' => 'Conseils d\'utilisation du texte factice',
        'content' => <<<HTML
<ul>
    <li>Adaptez la longueur du contenu&nbsp;: utilisez une quantité similaire à celle du texte final</li>
    <li>N'oubliez pas de remplacer&nbsp;: remplacez toujours le Lorem Ipsum avant la mise en production</li>
    <li>Testez les cas limites&nbsp;: essayez du texte très long et très court pour vérifier la réactivité</li>
    <li>Pensez à la lisibilité&nbsp;: même fictif, le texte doit refléter une bonne typographie</li>
    <li>Utilisez les balises HTML&nbsp;: ajoutez des balises &lt;p&gt; si vous avez besoin d'une sortie formatée</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/Lorem_ipsum',
        'title' => 'Lorem Ipsum - Wikipédia',
        'description' => 'Histoire et origine du texte de remplissage Lorem Ipsum'
    ],
    [
        'url' => 'https://www.lipsum.com/',
        'title' => 'Lipsum.com - Générateur Lorem Ipsum',
        'description' => 'Ressource historique pour générer et comprendre le Lorem Ipsum'
    ],
    [
        'url' => 'https://www.nngroup.com/articles/lorem-ipsum/',
        'title' => 'Nielsen Norman Group&nbsp;: Lorem Ipsum et UX',
        'description' => 'Recherche sur l\'impact du texte factice dans l\'expérience utilisateur'
    ],
    [
        'url' => 'https://alistapart.com/article/ux-content-first/',
        'title' => 'A List Apart&nbsp;: le contenu d\'abord',
        'description' => 'Pourquoi concevoir avec du contenu réel est crucial pour une meilleure UX'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
