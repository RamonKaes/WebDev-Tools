<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'htmlEntityTool';
$lang = 'fr';

$customAboutContent = '
  <p class="mb-2">
    <strong>Les entités HTML</strong> sont des représentations spéciales utilisées en HTML pour afficher
    des caractères réservés et des symboles. Elles évitent les problèmes d\'interprétation par le navigateur
    et garantissent un rendu correct sur différents systèmes et encodages.
  </p>
  <p class="mb-0">
    Cet outil gère les entités nommées (&amp;nbsp;), les entités numériques décimales (&amp;#160;)
    et hexadécimales (&amp;#xA0;). Toutes les conversions s\'effectuent localement dans votre navigateur
    pour une confidentialité totale.
  </p>
';

$customFeaturesContent = '
  <ul class="mb-0">
    <li>Entités nommées&nbsp;: convertit vers les entités standard comme &amp;nbsp;, &amp;lt;, &amp;gt;</li>
    <li>Entités numériques&nbsp;: formats décimal (&amp;#160;) ou hexadécimal (&amp;#xA0;)</li>
    <li>Bidirectionnel&nbsp;: encode du texte en entités ou décode des entités en texte</li>
    <li>Conversion automatique&nbsp;: transformation en temps réel pendant la saisie</li>
    <li>Référence de caractères&nbsp;: lien rapide vers la liste complète des entités HTML</li>
    <li>Téléchargement&nbsp;: enregistrez les résultats dans un fichier texte</li>
  </ul>
';

$additionalSections = [
  [
    'title' => 'Cas d\'utilisation courants',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Développement HTML</h3>
    <ul>
      <li>Afficher du code dans HTML (&lt;, &gt;, &amp;)</li>
      <li>Caractères spéciaux dans les attributs</li>
      <li>Symboles de copyright et de marque</li>
      <li>Espaces insécables</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Traitement de données</h3>
    <ul>
      <li>Contenu de flux XML/RSS</li>
      <li>Génération de modèles d'e-mails</li>
      <li>Échappement de contenu en base de données</li>
      <li>Internationalisation (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ],
  [
    'title' => 'Entités essentielles',
    'icon' => 'info-circle',
    'content' => '<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Caractère</th>
        <th>Entité nommée</th>
        <th>Décimal</th>
        <th>Hexadécimal</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>&lt;</td><td>&amp;lt;</td><td>&amp;#60;</td><td>&amp;#x3C;</td><td>Inférieur à</td></tr>
      <tr><td>&gt;</td><td>&amp;gt;</td><td>&amp;#62;</td><td>&amp;#x3E;</td><td>Supérieur à</td></tr>
      <tr><td>&amp;</td><td>&amp;amp;</td><td>&amp;#38;</td><td>&amp;#x26;</td><td>Esperluette</td></tr>
      <tr><td>"</td><td>&amp;quot;</td><td>&amp;#34;</td><td>&amp;#x22;</td><td>Guillemet double</td></tr>
      <tr><td>&nbsp;</td><td>&amp;nbsp;</td><td>&amp;#160;</td><td>&amp;#xA0;</td><td>Espace insécable</td></tr>
      <tr><td>©</td><td>&amp;copy;</td><td>&amp;#169;</td><td>&amp;#xA9;</td><td>Copyright</td></tr>
      <tr><td>®</td><td>&amp;reg;</td><td>&amp;#174;</td><td>&amp;#xAE;</td><td>Marque déposée</td></tr>
    </tbody>
  </table>
</div>
<p class="text-muted small mb-0">
  <i class="bi bi-info-circle me-1"></i>
  Consultez la liste complète dans notre <a href="../reference-caracteres/">référence des caractères</a>
</p>'
  ]
];

$usefulResources = [
    [
        'url' => 'https://fr.wikipedia.org/wiki/Liste_des_entit%C3%A9s_de_caract%C3%A8res_de_XML_et_HTML',
        'title' => 'Wikipedia&nbsp;: Entités de caractères HTML',
        'description' => 'Introduction accessible aux entités de caractères HTML'
    ],
    [
        'url' => 'https://html.spec.whatwg.org/multipage/named-characters.html',
        'title' => 'Standard HTML&nbsp;: références de caractères nommés',
        'description' => 'Spécification officielle WHATWG des entités nommées'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Entity',
        'title' => 'MDN&nbsp;: entités HTML',
        'description' => 'Guide complet des entités de caractères HTML'
    ],
    [
        'url' => 'https://www.w3.org/International/questions/qa-escapes',
        'title' => 'W3C&nbsp;: utilisation des échappements',
        'description' => 'Bonnes pratiques pour utiliser les séquences d\'échappement en markup et CSS'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
