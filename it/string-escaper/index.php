<?php

declare(strict_types=1);

// Start output buffering for HTML minification
ob_start();

$toolId = 'stringEscaperTool';
$lang = 'it';

$customAboutContent = <<<HTML
<p class="mb-2">
    L'<strong>Escape di Stringhe</strong> aiuta a fare l'escape e il reverse di stringhe per formati come HTML, XML, JavaScript, JSON, SQL e CSV.
    Ideale per sviluppatori che lavorano con dati testuali che richiedono escape appropriato per diversi contesti.
</p>
<p class="mb-0">
    Tutta l'elaborazione avviene lato client nel browser – i dati non lasciano mai il dispositivo.
</p>
HTML;

$customFeaturesContent = <<<HTML
<ul class="list-unstyled">
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape HTML/XML – codifica caratteri speciali come &lt;, &gt;, &amp;</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JavaScript – gestisce virgolette, newline e caratteri speciali</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape JSON – applica la sintassi corretta per stringhe JSON</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape SQL – aiuta a prevenire SQL injection</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Escape CSV – gestisce virgolette e delimitatori</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Elaborazione 100% locale (focus sulla privacy)</li>
    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Copia il risultato con un clic</li>
</ul>
HTML;

$additionalSections = [
    [
        'title' => 'Casi d\'uso comuni',
        'icon' => 'lightbulb',
        'content' => <<<HTML
<div class="row">
  <div class="col-md-6">
    <h3 class="h6">Sicurezza</h3>
    <ul>
      <li>Prevenire XSS con escape HTML</li>
      <li>Ridurre il rischio di SQL injection</li>
      <li>Output sicuro di stringhe in JavaScript</li>
      <li>Proteggere dati in API JSON</li>
    </ul>
  </div>
  <div class="col-md-6">
    <h3 class="h6">Elaborazione dati</h3>
    <ul>
      <li>Esportare CSV con escape appropriato</li>
      <li>Sanitizzare contenuto HTML/XML</li>
      <li>Creare letterali stringa in JavaScript</li>
      <li>Preparare query per database</li>
    </ul>
  </div>
</div>
HTML
    ]
];

$usefulResources = [
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Escape_sequence',
        'title' => 'MDN: Sequenze di escape',
        'description' => 'Introduzione accessibile ai caratteri e sequenze di escape'
    ],
    [
        'url' => 'https://owasp.org/www-community/attacks/xss/',
        'title' => 'OWASP XSS Prevention Cheat Sheet',
        'description' => 'Guida completa per prevenire attacchi Cross-Site Scripting'
    ],
    [
        'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String',
        'title' => 'Riferimento String MDN',
        'description' => 'Documentazione completa su stringhe e escape in JavaScript'
    ],
    [
        'url' => 'https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html',
        'title' => 'OWASP SQL Injection Prevention',
        'description' => 'Best practice per evitare SQL injection'
    ],
    [
        'url' => 'https://www.w3.org/TR/html5/syntax.html#escaping-a-string',
        'title' => 'W3C HTML5 String Escaping',
        'description' => 'Specifica ufficiale per l\'escape di stringhe in HTML'
    ]
];

include __DIR__ . '/../../partials/tool-base.php';
