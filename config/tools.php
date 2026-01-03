<?php

declare(strict_types=1);

return [
  'base64EncoderDecoder' => [
    'id' => 'base64EncoderDecoder',
    'slug' => 'base64-encoder-decoder',
    'slugs' => [
      'en' => 'base64-encoder-decoder',
      'de' => 'base64-kodierer-dekodierer',
      'es' => 'base64-encoder-decoder',
      'pt' => 'base64-encoder-decoder',
      'fr' => 'base64-encoder-decoder',
      'it' => 'base64-encoder-decoder'
    ],
    'category' => 'encoders',
    'icon' => 'bi-file-binary',
    'jsModule' => 'tools/base64EncoderDecoderTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'dragdrop-utils', 'validators'],
    'features' => ['drag-drop', 'file-upload', 'live-mode'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'urlEncoderDecoder' => [
    'id' => 'urlEncoderDecoder',
    'slug' => 'url-encoder-decoder',
    'slugs' => [
      'en' => 'url-encoder-decoder',
      'de' => 'url-kodierer-dekodierer',
      'es' => 'url-encoder-decoder',
      'pt' => 'url-encoder-decoder',
      'fr' => 'url-encoder-decoder',
      'it' => 'url-encoder-decoder'
    ],
    'category' => 'encoders',
    'icon' => 'bi-link-45deg',
    'jsModule' => 'tools/urlEncoderDecoderTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'validators'],
    'features' => ['bulk-processing', 'url-parsing'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'htmlEntityTool' => [
    'id' => 'htmlEntityTool',
    'slug' => 'html-entity-encoder-decoder',
    'slugs' => [
      'en' => 'html-entity-encoder-decoder',
      'de' => 'html-entity-kodierer-dekodierer',
      'es' => 'html-entity-encoder-decoder',
      'pt' => 'html-entity-encoder-decoder',
      'fr' => 'html-entity-encoder-decoder',
      'it' => 'html-entity-encoder-decoder'
    ],
    'category' => 'encoders',
    'icon' => 'bi-code-square',
    'jsModule' => 'tools/htmlEntityTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => ['named-entities', 'numeric-entities', 'bidirectional'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'jsonFormatterValidator' => [
    'id' => 'jsonFormatterValidator',
    'slug' => 'json-formatter-validator',
    'slugs' => [
      'en' => 'json-formatter-validator',
      'de' => 'json-formatierer-validator',
      'es' => 'json-formatter-validator',
      'pt' => 'json-formatter-validator',
      'fr' => 'json-formatter-validator',
      'it' => 'json-formatter-validator'
    ],
    'category' => 'formatters',
    'icon' => 'bi-filetype-json',
    'jsModule' => 'tools/jsonFormatterValidatorTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'dragdrop-utils', 'formatters', 'validators'],
    'features' => ['syntax-highlighting', 'tree-view', 'minification', 'validation'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'codeFormatterTool' => [
    'id' => 'codeFormatterTool',
    'slug' => 'code-formatter',
    'slugs' => [
      'en' => 'code-formatter',
      'de' => 'code-formatierer',
      'es' => 'code-formatter',
      'pt' => 'code-formatter',
      'fr' => 'code-formatter',
      'it' => 'code-formatter'
    ],
    'category' => 'formatters',
    'icon' => 'bi-code-square',
    'jsModule' => 'tools/codeFormatterTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => [],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'pxToRemConverter' => [
    'id' => 'pxToRemConverter',
    'slug' => 'px-to-rem-converter',
    'slugs' => [
      'en' => 'px-to-rem-converter',
      'de' => 'px-zu-rem-konverter',
      'es' => 'conversor-px-a-rem',
      'pt' => 'conversor-px-para-rem',
      'fr' => 'convertisseur-px-vers-rem',
      'it' => 'convertitore-px-rem'
    ],
    'category' => 'converters',
    'icon' => 'bi-arrows-angle-expand',
    'jsModule' => 'tools/pxToRemConverterTool.js',
    'jsLibraries' => ['clipboard-utils'],
    'features' => ['live-calculation', 'conversion-tables', 'tailwind-support'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'dataConverterTool' => [
    'id' => 'dataConverterTool',
    'slug' => 'data-converter',
    'slugs' => [
      'en' => 'data-converter',
      'de' => 'daten-konverter',
      'es' => 'conversor-datos',
      'pt' => 'conversor-dados',
      'fr' => 'convertisseur-donnees',
      'it' => 'convertitore-dati'
    ],
    'category' => 'converters',
    'icon' => 'bi-arrow-left-right',
    'jsModule' => 'tools/dataConverterTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'validators', 'formatters'],
    'features' => ['bidirectional-conversion', 'multiple-formats', 'timestamp-conversion'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'jwtDecoderTool' => [
    'id' => 'jwtDecoderTool',
    'slug' => 'jwt-decoder',
    'slugs' => [
      'en' => 'jwt-decoder',
      'de' => 'jwt-dekodierer',
      'es' => 'jwt-decoder',
      'pt' => 'jwt-decoder',
      'fr' => 'jwt-decoder',
      'it' => 'jwt-decoder'
    ],
    'category' => 'encoders',
    'icon' => 'bi-shield-lock',
    'jsModule' => 'tools/jwtDecoderTool.js',
    'jsLibraries' => [],
    'features' => ['decode-jwt', 'verify-expiry', 'algorithm-detection'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'punycodeConverterTool' => [
    'id' => 'punycodeConverterTool',
    'slug' => 'punycode-converter',
    'slugs' => [
      'en' => 'punycode-converter',
      'de' => 'punycode-konverter',
      'es' => 'punycode-converter',
      'pt' => 'punycode-converter',
      'fr' => 'punycode-converter',
      'it' => 'punycode-converter'
    ],
    'category' => 'encoders',
    'icon' => 'bi-globe',
    'jsModule' => 'tools/punycodeConverterTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => ['idn-support', 'bidirectional', 'auto-detect'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'uuidGeneratorTool' => [
    'id' => 'uuidGeneratorTool',
    'slug' => 'uuid-generator',
    'slugs' => [
      'en' => 'uuid-generator',
      'de' => 'uuid-generator',
      'es' => 'uuid-generator',
      'pt' => 'uuid-generator',
      'fr' => 'uuid-generator',
      'it' => 'uuid-generator'
    ],
    'category' => 'generators',
    'icon' => 'bi-fingerprint',
    'jsModule' => 'tools/uuidGeneratorTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'validators'],
    'features' => ['bulk-generation', 'uuid-v4', 'rfc-4122'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'passwordGeneratorTool' => [
    'id' => 'passwordGeneratorTool',
    'slug' => 'password-generator',
    'slugs' => [
      'en' => 'password-generator',
      'de' => 'passwort-generator',
      'es' => 'generador-contrasenas',
      'pt' => 'gerador-senhas',
      'fr' => 'generateur-mots-de-passe',
      'it' => 'generatore-password'
    ],
    'category' => 'generators',
    'icon' => 'bi-shield-lock',
    'jsModule' => 'tools/passwordGeneratorTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils', 'wordlist'],
    'features' => ['random-password', 'passphrase', 'pattern-based', 'strength-meter'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'hashGeneratorTool' => [
    'id' => 'hashGeneratorTool',
    'slug' => 'hash-generator',
    'slugs' => [
      'en' => 'hash-generator',
      'de' => 'hash-generator',
      'es' => 'hash-generator',
      'pt' => 'hash-generator',
      'fr' => 'hash-generator',
      'it' => 'hash-generator'
    ],
    'category' => 'generators',
    'icon' => 'bi-hash',
    'jsModule' => 'tools/hashGeneratorTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => ['multiple-algorithms', 'file-hashing'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'loremIpsumTool' => [
    'id' => 'loremIpsumTool',
    'slug' => 'lorem-ipsum',
    'slugs' => [
      'en' => 'lorem-ipsum',
      'de' => 'lorem-ipsum',
      'es' => 'lorem-ipsum',
      'pt' => 'lorem-ipsum',
      'fr' => 'lorem-ipsum',
      'it' => 'lorem-ipsum'
    ],
    'category' => 'generators',
    'icon' => 'bi-file-text',
    'jsModule' => 'tools/loremIpsumTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => ['paragraphs', 'words', 'sentences', 'html-output'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'qrCodeGeneratorTool' => [
    'id' => 'qrCodeGeneratorTool',
    'slug' => 'qr-code-generator',
    'slugs' => [
      'en' => 'qr-code-generator',
      'de' => 'qr-code-generator',
      'es' => 'qr-code-generator',
      'pt' => 'qr-code-generator',
      'fr' => 'qr-code-generator',
      'it' => 'qr-code-generator'
    ],
    'category' => 'generators',
    'icon' => 'bi-qr-code',
    'jsModule' => 'tools/qrCodeGeneratorTool.js',
    'jsLibraries' => ['download-utils'],
    'externalLibraries' => [
      [
        'url' => 'https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js',
        'integrity' => 'sha384-lQXOAyZwHXE55JFyrOMB7nY2Wv+m5ZWNtJcHrd1rceRQXAYNLak8ukN5TjBTcIwz',
        'crossorigin' => 'anonymous'
      ]
    ],
    'features' => ['qr-generation', 'customizable', 'download-svg-png'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'stringEscaperTool' => [
    'id' => 'stringEscaperTool',
    'slug' => 'string-escaper',
    'slugs' => [
      'en' => 'string-escaper',
      'de' => 'string-maskierer',
      'es' => 'escapador-cadenas',
      'pt' => 'string-escaper',
      'fr' => 'string-escaper',
      'it' => 'string-escaper'
    ],
    'category' => 'stringtools',
    'icon' => 'bi-code-slash',
    'jsModule' => 'tools/stringEscaperTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => [],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'characterReferenceTool' => [
    'id' => 'characterReferenceTool',
    'slug' => 'character-reference',
    'slugs' => [
      'en' => 'character-reference',
      'de' => 'zeichen-referenz',
      'es' => 'referencia-caracteres',
      'pt' => 'referencia-caracteres',
      'fr' => 'reference-caracteres',
      'it' => 'riferimento-caratteri'
    ],
    'category' => 'references',
    'icon' => 'bi-table',
    'jsModule' => 'tools/characterReferenceTool.js',
    'jsLibraries' => ['clipboard-utils'],
    'features' => ['search', 'categories', 'toggle-view', 'copy-codes'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'emojiReferenceTool' => [
    'id' => 'emojiReferenceTool',
    'slug' => 'emoji-reference',
    'slugs' => [
      'en' => 'emoji-reference',
      'de' => 'emoji-referenz',
      'es' => 'referencia-emojis',
      'pt' => 'referencia-emojis',
      'fr' => 'reference-emoji',
      'it' => 'riferimento-emoji'
    ],
    'category' => 'references',
    'icon' => 'bi-emoji-smile',
    'jsModule' => 'tools/emojiReferenceTool.js',
    'jsLibraries' => [],
    'features' => ['search', 'categories', 'copy-emoji', 'copy-codes'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'regexTesterTool' => [
    'id' => 'regexTesterTool',
    'slug' => 'regex-tester',
    'slugs' => [
      'en' => 'regex-tester',
      'de' => 'regex-tester',
      'es' => 'regex-tester',
      'pt' => 'regex-tester',
      'fr' => 'regex-tester',
      'it' => 'regex-tester'
    ],
    'category' => 'utilities',
    'icon' => 'bi-regex',
    'jsModule' => 'tools/regexTesterTool.js',
    'jsLibraries' => ['clipboard-utils', 'download-utils'],
    'features' => ['live-testing', 'match-highlighting', 'group-extraction', 'multiple-flags'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ],

  'aspectRatioCalculator' => [
    'id' => 'aspectRatioCalculator',
    'slug' => 'aspect-ratio-calculator',
    'slugs' => [
      'en' => 'aspect-ratio-calculator',
      'de' => 'seitenverhaeltnis-rechner',
      'es' => 'calculadora-relacion-aspecto',
      'pt' => 'calculadora-proporcao-aspecto',
      'fr' => 'calculateur-ratio-aspect',
      'it' => 'calcolatore-rapporto-aspetto'
    ],
    'category' => 'converters',
    'icon' => 'bi-aspect-ratio',
    'jsModule' => 'tools/aspectRatioCalculatorTool.js',
    'jsLibraries' => ['clipboard-utils'],
    'features' => ['dimension-calculation', 'common-presets', 'css-padding-trick', 'responsive-design'],
    'seoTemplate' => 'default',
    'hasFeaturesSection' => true
  ]
];
