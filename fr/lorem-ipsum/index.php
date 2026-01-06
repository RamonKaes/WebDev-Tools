<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'loremIpsumTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

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

$features = [
    'Générer des paragraphes, phrases ou mots',
    'Quantité personnalisable (1 à 100 unités)',
    'Démarrer par « Lorem ipsum dolor sit amet... »',
    'Option d\'encapsulation dans des balises HTML <p>',
    'Sortie en texte brut',
    'Copie en un clic',
    'Compteur de mots et de caractères en temps réel'
];

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
        'url' => 'https://www.smashingmagazine.com/2010/01/lorem-ipsum-killing-designs/',
        'title' => 'Smashing Magazine&nbsp;: Lorem Ipsum nuit à vos designs',
        'description' => 'Pourquoi le texte de substitution peut nuire à votre processus de conception et à l\'expérience utilisateur'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
