<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'punycodeConverterTool';
$lang = 'fr';
$featuresSectionTitle = 'Fonctionnalités';
$resourcesSectionTitle = 'Ressources Utiles';

$customAboutContent = <<<HTML
<p class="mb-2">
    <strong>Punycode</strong> est une syntaxe d'encodage qui permet de représenter des caractères Unicode
    dans des noms de domaine en utilisant uniquement des caractères ASCII. Il rend possibles les noms de domaine internationalisés (IDN)
    tout en restant compatible avec l'infrastructure DNS existante.
</p>
<p class="mb-0">
    Cet outil implémente la RFC 3492 pour convertir des domaines Unicode (münchen.de) en leurs équivalents Punycode (xn--mnchen-3ya.de) et inversement.
    Toutes les conversions s'effectuent localement dans votre navigateur.
</p>
HTML;

$features = [
    'Conversion bidirectionnelle : Unicode vers Punycode et inversement',
    'Détection automatique : identifie automatiquement le format d\'entrée',
    'Conformité RFC 3492 : implémentation complète de la norme Punycode',
    'Traitement par lot : convertissez plusieurs domaines en même temps (ligne par ligne)',
    'Domaines d\'exemple : chargez des domaines internationaux à tester',
    'Conversion en temps réel : transformation automatique pendant la saisie'
];

$additionalSections = [
  [
    'title' => 'Comment fonctionne Punycode',
    'icon' => 'lightbulb',
    'content' => <<<HTML
<p>Punycode convertit les noms de domaine Unicode en ASCII à l'aide d'un encodage spécifique&nbsp;:</p>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Domaine Unicode</h4>
      <code class="text-primary">münchen.de</code>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-body-secondary p-3 rounded">
      <h3 class="h6">Domaine Punycode</h4>
      <code class="text-success">xn--mnchen-3ya.de</code>
    </div>
  </div>
</div>

<p>Processus d'encodage&nbsp;:</p>
<ol>
  <li>Extraire les caractères ASCII (mnchen)</li>
  <li>Encoder la position et la valeur des caractères non ASCII</li>
  <li>Ajouter le préfixe <code>xn--</code> indiquant le Punycode</li>
  <li>Ajouter les informations Unicode encodées (-3ya)</li>
</ol>

<p class="mb-0 text-muted small">
  <i class="bi bi-info-circle me-1"></i>
  Tous les domaines Punycode commencent par <code>xn--</code>
</p>
HTML
  ],
  [
    'title' => 'Domaines internationaux courants',
    'icon' => 'globe',
    'content' => <<<HTML
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Unicode</th>
        <th>Punycode</th>
        <th>Langue</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>münchen.de</td><td>xn--mnchen-3ya.de</td><td>Allemand</td></tr>
      <tr><td>zürich.ch</td><td>xn--zrich-kva.ch</td><td>Allemand</td></tr>
      <tr><td>москва.рф</td><td>xn--80adxhks.xn--p1ai</td><td>Russe</td></tr>
      <tr><td>东京.jp</td><td>xn--1lqs71d.jp</td><td>Japonais</td></tr>
      <tr><td>مصر.eg</td><td>xn--wgbh1c.eg</td><td>Arabe</td></tr>
      <tr><td>ελλάδα.gr</td><td>xn--qxam.gr</td><td>Grec</td></tr>
    </tbody>
  </table>
</div>
HTML
  ],
  [
    'title' => 'Cas d\'utilisation',
    'icon' => 'card-checklist',
    'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Enregistrement de domaines</h3>
    <ul>
      <li>Convertir des IDN pour l'enregistrement DNS</li>
      <li>Vérifier la disponibilité d'un domaine</li>
      <li>Encodage d'adresses e-mail</li>
      <li>Génération de certificats SSL</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Développement web</h3>
    <ul>
      <li>Gestion des URL dans les applications</li>
      <li>Stockage de domaines dans une base de données</li>
      <li>Requêtes API avec IDN</li>
      <li>Internationalisation (i18n)</li>
    </ul>
  </div>
</div>
HTML
  ]
];

$usefulResources = [
    [
        'url' => 'https://datatracker.ietf.org/doc/html/rfc3492',
        'title' => 'RFC 3492&nbsp;: Punycode',
        'description' => 'Spécification officielle IETF pour l\'encodage Punycode'
    ],
    [
        'url' => 'https://www.icann.org/resources/pages/idn-2012-02-25-en',
        'title' => 'ICANN&nbsp;: noms de domaine internationalisés',
        'description' => 'Vue d\'ensemble de la mise en œuvre des IDN et des politiques associées'
    ],
    [
        'url' => 'https://en.wikipedia.org/wiki/Internationalized_domain_name',
        'title' => 'Wikipédia&nbsp;: noms de domaine internationalisés',
        'description' => 'Informations complètes sur les systèmes IDN'
    ],
    [
        'url' => 'https://www.charset.org/punycode',
        'title' => 'Charset.org&nbsp;: convertisseur Punycode',
        'description' => 'Exemples supplémentaires et informations sur la conversion Punycode'
    ]
];

require_once __DIR__ . '/../../partials/tool-base.php';
