<?php

declare(strict_types=1);

$toolId = 'jsonFormatterValidator';
$lang = 'fr';

$customAboutContent = <<<HTML
<p class="mb-2">
    Formatez, validez et embellissez des données JSON avec notre outil complet.
    Idéal pour les développeurs qui travaillent avec des API, des fichiers de configuration et des structures de données.
</p>
<p class="mb-0">
    Cet outil analyse le JSON, valide la syntaxe, applique une indentation propre et fournit des messages d'erreur détaillés.
    Tout le traitement s'effectue côté client pour garantir une confidentialité maximale.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Formater et embellir le JSON avec une indentation personnalisable (2 ou 4 espaces)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Valider la syntaxe JSON avec des messages d'erreur détaillés</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Minifier le JSON pour réduire la taille des fichiers</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Validation de la syntaxe en temps réel</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Détection des erreurs ligne par ligne</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie du résultat formaté en un clic</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mise en évidence claire des erreurs et messages explicites</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Respect de la vie privée&nbsp;: tout se passe dans votre navigateur</li>
</ul>
HTML;

$customNoticeType = 'info';
$customNoticeContent = <<<HTML
<h3 class="h5 alert-heading"><i class="bi bi-info-circle me-2"></i>Options de formatage JSON</h2>
<ul class="mb-0">
    <li>Embellir (2 espaces)&nbsp;: format standard avec indentation à 2 espaces</li>
    <li>Embellir (4 espaces)&nbsp;: format plus aéré avec indentation à 4 espaces</li>
    <li>Minifier&nbsp;: supprime tout espace inutile pour obtenir un JSON compact</li>
    <li>Valider&nbsp;: vérifie la syntaxe sans modifier le format</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Cas d\'utilisation courants',
        'content' => <<<HTML
<ul>
    <li>Développement d'API&nbsp;: formater les réponses pour une lecture facile</li>
    <li>Fichiers de configuration&nbsp;: valider et mettre en forme les fichiers JSON</li>
    <li>Inspection de données&nbsp;: examiner rapidement la structure d'un JSON</li>
    <li>Débogage&nbsp;: identifier les erreurs de syntaxe dans des données JSON</li>
    <li>Revue de code&nbsp;: garantir un formatage JSON cohérent</li>
    <li>Migration de données&nbsp;: valider un JSON avant importation</li>
</ul>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://www.ecma-international.org/publications-and-standards/standards/ecma-404/',
        'title' => 'ECMA-404&nbsp;: syntaxe d\'échange de données JSON',
        'description' => 'Spécification officielle du JSON publiée par ECMA International'
    ],
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc8259',
        'title' => 'RFC 8259&nbsp;: JavaScript Object Notation (JSON)',
        'description' => 'Norme IETF décrivant le format JSON'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON',
        'title' => 'Référence de l\'objet JSON sur MDN',
        'description' => 'Guide complet sur JSON.parse() et JSON.stringify()'
    ],
    [
        'url' => 'https://json-schema.org/',
        'title' => 'Spécification JSON Schema',
        'description' => 'Documentation officielle pour valider la structure et les types de données JSON'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
