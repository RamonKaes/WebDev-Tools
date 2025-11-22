<?php

declare(strict_types=1);

$toolId = 'characterReferenceTool';
$lang = 'fr';

$customAboutContent = '
  <p class="mb-2">
    Parcourez et recherchez une vaste collection d\'entités HTML, de caractères Unicode et de symboles spéciaux.
    Trouvez les codes dont vous avez besoin pour le développement web, des symboles courants aux opérateurs mathématiques et emoji.
  </p>
  <p class="mb-0">
    Chaque caractère affiche son entité HTML, son code décimal, son code hexadécimal et sa représentation Unicode.
    Cliquez sur n\'importe quel format pour le copier instantanément dans le presse-papiers.
  </p>
';

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Plus de 2&nbsp;231 entités HTML</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Navigation par catégories</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Recherche puissante</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multiples formats de copie</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Codes Unicode, décimaux et hexadécimaux</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copie en un clic</li>
</ul>
HTML;

$usefulResources = [
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'Références de caractères nommés WHATWG HTML',
        'description' => 'Spécification HTML officielle des entités de caractères nommées'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'Référence des entités HTML sur MDN',
        'description' => 'Guide complet des entités de caractères et symboles HTML'
    ],
    [
        'url' => 'https://www.w3.org/TR/xml-entity-names/',
        'title' => 'Définitions d\'entités XML du W3C',
        'description' => 'Définitions officielles du W3C des entités et correspondances Unicode'
    ],
    [
        'url' => 'https://unicode.org/charts/',
        'title' => 'Tableaux de codes Unicode',
        'description' => 'Tableaux de référence officiels du Consortium Unicode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
