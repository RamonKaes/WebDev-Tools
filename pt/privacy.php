<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/security-headers.php';

$lang = 'pt';
$currentTool = 'privacy';
$assetPrefix = BASE_PATH . '/';
$toolBaseUrl = BASE_PATH . '/pt';
$homeUrl = BASE_PATH . '/pt';
$pageTitle = 'Política de Privacidade – Proteção de Dados no WebDev-Tools';
$pageDescription = 'Política de privacidade e informações sobre proteção de dados do WebDev-Tools.';

$i18nData = loadI18n($lang) ?: [];
$manifest = getManifest();
$buildHash = $manifest['generatedAt'] ?? '1.0.0';

$langUrls = getAllLanguageUrls('/privacy.php');
$currentUrl = getFullUrl('/privacy.php', $lang);
?>
<!DOCTYPE html>
<html lang="pt" data-bs-theme="auto">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <meta name="robots" content="noindex, follow">
  <meta name="googlebot" content="noindex, follow">
  <meta name="theme-color" content="#066fd1">
  <meta name="color-scheme" content="light dark">
  <meta name="author" content="Ramon Kaes">

  <link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />

  <!-- Hreflang -->
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($baseUrl . '/privacy.php', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php foreach ($langUrls as $hreflang => $url): ?>
    <link rel="alternate" hreflang="<?= $hreflang ?>" href="<?= htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php endforeach; ?>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= $assetPrefix ?>assets/img/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= $assetPrefix ?>assets/img/favicon.svg" />
  <link rel="shortcut icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="icon" type="image/x-icon" href="<?= $assetPrefix ?>favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetPrefix ?>assets/img/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="WebDev-Tools" />
  <link rel="manifest" href="<?= BASE_PATH . getLangPrefix($lang) ?>/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= assetSrc('css/style.css') ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>
<body class="d-flex flex-column bg-body">

<?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main id="main-content" class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Política de Privacidade</h1>
          <p class="lead text-secondary">Sua privacidade é importante</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Proteção de dados em resumo</h2>
            
            <h3 class="h6 mb-2">Informações gerais</h3>
            <p>As informações a seguir fornecem uma visão geral simples sobre o que acontece com os seus dados pessoais quando você visita este site. Dados pessoais são todos os dados com os quais você pode ser identificado pessoalmente.</p>

            <h3 class="h6 mb-2 mt-3">Coleta de dados neste site</h3>
            <p><strong>Quem é responsável pela coleta de dados neste site?</strong></p>
            <p>O processamento de dados neste site é feito pelo operador do site. Os dados de contato dele podem ser encontrados no aviso legal deste site.</p>
            
            <p><strong>Como coletamos seus dados?</strong></p>
            <p>Seus dados são coletados, por um lado, quando você os fornece a nós. Podem ser, por exemplo, dados que você nos envia por e-mail.</p>
            <p>Outros dados são coletados automaticamente, ou após o seu consentimento, pelos nossos sistemas de TI quando você visita o site. Trata-se principalmente de dados técnicos (por exemplo, navegador, sistema operacional ou hora da visita). A coleta desses dados é feita automaticamente assim que você entra neste site.</p>
            
            <p><strong>Para que usamos seus dados?</strong></p>
            <p>Parte dos dados é coletada para garantir o funcionamento sem erros do site (arquivos de log do servidor, ver seção 4). Além disso, duas ferramentas carregam, cada uma, uma biblioteca JavaScript a partir de uma rede de distribuição de conteúdo (ver seção 3.3). Não usamos serviços de análise, rastreamento ou publicidade.</p>
            
            <p><strong>Quais são os seus direitos em relação aos seus dados?</strong></p>
            <p>Você tem o direito de obter, a qualquer momento e gratuitamente, informações sobre a origem, o destinatário e a finalidade dos seus dados pessoais armazenados. Você também tem o direito de solicitar a correção ou a exclusão desses dados. Se você deu seu consentimento para o processamento de dados, pode revogá-lo a qualquer momento. Além disso, você tem o direito de solicitar, em determinadas circunstâncias, a restrição do processamento dos seus dados pessoais, bem como de apresentar uma reclamação à autoridade supervisora competente.</p>

            <h2 class="h5 mb-3 mt-4">2. Abordagem de privacidade em primeiro lugar para ferramentas</h2>
            <p><strong>Todas as ferramentas deste site processam seus dados de entrada exclusivamente no seu navegador.</strong> Ao usar nossas ferramentas (por exemplo, Codificador Base64, Formatador JSON etc.), aplica-se o seguinte:</p>
            <ul>
              <li>Todas as conversões, validações e gerações são feitas no lado do cliente, no seu navegador</li>
              <li>Os dados que você insere nas ferramentas nunca saem do seu dispositivo</li>
              <li>Não armazenamos, registramos nem temos acesso aos dados que você processa com nossas ferramentas</li>
              <li>Não podemos fornecer informações sobre dados inseridos nas ferramentas que não temos, pois não os coletamos</li>
            </ul>
            <p><strong>Observação importante:</strong> isso se refere exclusivamente ao processamento dos seus dados <em>dentro das ferramentas</em>. No entanto, ao visitar o site, dados técnicos são coletados automaticamente nos arquivos de log do servidor (ver seção 4) e, quando você usa o Gerador de QR Code ou minifica JavaScript no Formatador de Código, uma biblioteca é carregada a partir de uma CDN (ver seção 3.3).</p>

            <h2 class="h5 mb-3 mt-4">3. Segurança e Transparência</h2>

            <p>Implementamos várias camadas de segurança para proteger sua privacidade e garantir a integridade de nossas ferramentas:</p>

            <h3 class="h6 mb-2 mt-3">3.1 Código Aberto e Auditabilidade</h3>
            <p>O código-fonte completo está disponível publicamente no GitHub. Você pode revisar, auditar ou bifurcar o projeto a qualquer momento:</p>
            <p>
              <a href="https://github.com/RamonKaes/WebDev-Tools" target="_blank" rel="noopener noreferrer" title="Repositório GitHub do WebDev-Tools" class="d-inline-flex align-items-center">
                <i class="bi bi-github me-2"></i>github.com/RamonKaes/WebDev-Tools
              </a>
            </p>

            <h3 class="h6 mb-2 mt-3">3.2 Integridade de Sub-recursos (SRI)</h3>
            <p>Todas as bibliotecas externas são carregadas com hashes criptográficos SRI para evitar adulterações. Isso garante que o código de terceiros não possa ser modificado sem detecção:</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Biblioteca</th>
                    <th>Versão</th>
                    <th>Hash SRI (SHA-384)</th>
                  </tr>
                </thead>
                <tbody class="font-monospace small">
                  <tr>
                    <td>qrcode-generator</td>
                    <td>1.4.4</td>
                    <td class="text-break">sha384-lQXOAyZwHXE55JFyr...TcIwz</td>
                  </tr>
                  <tr>
                    <td>terser</td>
                    <td>5.31.0</td>
                    <td class="text-break">sha384-Be6gQ8oRB6kvVWiyo...1v7dX</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Os hashes SRI completos podem ser verificados no nosso código-fonte (<a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">config/tools.php</a> e <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/assets/js/tools/codeFormatterTool.js" target="_blank" rel="noopener noreferrer">codeFormatterTool.js</a>).</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Entrega de conteúdos de terceiros (CDN)</h3>
            <p>O Bootstrap, a fonte de ícones e todos os outros recursos estão hospedados em nosso próprio servidor. Apenas duas ferramentas carregam uma única biblioteca JavaScript a partir da rede de distribuição de conteúdo jsDelivr (cdn.jsdelivr.net), operada pela Prospect One (jsDelivr) e distribuída por vários provedores de CDN, incluindo Cloudflare e Fastly:</p>
            <ul>
              <li><strong>Gerador de QR Code:</strong> carrega <code>qrcode-generator</code> ao abrir a página da ferramenta.</li>
              <li><strong>Formatador de Código:</strong> carrega <code>terser</code> apenas quando você minifica código JavaScript.</li>
            </ul>
            <p>Ao carregar uma dessas bibliotecas, seu navegador se conecta diretamente à CDN e transmite os dados tecnicamente necessários para isso, em particular seu endereço IP, seu user agent e a página de origem (referrer). Não recebemos nenhum dado desse processo. As bibliotecas estão protegidas por hashes SRI (ver 3.2) e, por isso, não podem ser modificadas sem que isso seja detectado. Além disso, este site não faz nenhuma requisição a servidores de terceiros; apenas o Gerador de Hash SRI busca a URL do recurso que o próprio usuário informa.</p>
            <p>A base legal é o art. 6, parágrafo 1, alínea f) do RGPD; nosso interesse legítimo reside em disponibilizar essas ferramentas de forma confiável e eficiente. Você encontra mais informações na política de privacidade da jsDelivr: <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener">https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net</a></p>

            <h3 class="h6 mb-2 mt-3">3.4 Política de Segurança de Conteúdo (CSP)</h3>
            <p>Implementamos políticas de segurança de conteúdo rigorosas para prevenir ataques XSS e execução de código não autorizado:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Execução de scripts baseada em nonce (previne injeção de scripts inline)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Carregamento restrito de recursos externos (scripts apenas do nosso próprio servidor e de cdn.jsdelivr.net)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incorporação de frames completamente desabilitada (proteção contra clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Execução de objetos e plugins bloqueada</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Cabeçalhos de Segurança Adicionais</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previne ataques de incorporação de iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previne a detecção automática de tipo MIME (MIME sniffing)</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita vazamento de informações do referenciador</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Força conexões HTTPS com pré-carregamento</li>
              <li><strong>Permissions-Policy</strong> - Desabilita recursos desnecessários do navegador (geolocalização, câmera, microfone, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.6 Zero Dependências Externas para Processamento de Dados</h3>
            <p>Todas as funções principais de processamento de dados usam apenas APIs nativas do navegador. As bibliotecas externas são usadas apenas para duas funções auxiliares (renderização de códigos QR e minificação de JavaScript) e são carregadas com verificação SRI.</p>

            <h2 class="h5 mb-3 mt-4">4. Hospedagem e arquivos de log do servidor</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Descrição e âmbito do processamento de dados</h3>
            <p>Este site é hospedado por um prestador de serviços externo. Se você usar nosso site apenas para fins informativos (ou seja, sem cadastro nem qualquer outra transmissão de informações), coletamos apenas os dados pessoais que seu navegador transmite ao nosso servidor. Ao acessar nosso site, coletamos os seguintes dados:</p>
            <ul>
              <li>Endereço IP</li>
              <li>Provedor de internet do usuário</li>
              <li>Data e hora do acesso</li>
              <li>Tipo de navegador</li>
              <li>Idioma e versão do navegador</li>
              <li>Conteúdo da consulta</li>
              <li>Fuso horário</li>
              <li>Status de acesso/código de status HTTP</li>
              <li>Volume de dados</li>
              <li>Sites de onde vem a solicitação (URL de referência)</li>
              <li>Sistema operacional</li>
            </ul>
            <p>Esses dados não são armazenados juntamente com outros dados pessoais seus.</p>

            <h3 class="h6 mb-2 mt-3">4.2 Finalidade do processamento</h3>
            <p>Esses dados são usados com a finalidade de fornecer a você um site amigável, funcional e seguro, com funções e conteúdos, bem como para sua otimização e avaliação estatística. Os dados são usados exclusivamente para a operação técnica e a segurança do site.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Base legal</h3>
            <p>A base legal é o nosso interesse legítimo no processamento de dados de acordo com o art. 6, parágrafo 1, alínea f) do RGPD, que também se reflete nas finalidades acima mencionadas.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Período de armazenamento</h3>
            <p>Por razões de segurança, armazenamos esses dados em arquivos de log do servidor por um período de 60 dias. Após o término desse período, eles são excluídos automaticamente, a menos que precisemos retê-los para fins probatórios em caso de ataques à infraestrutura do servidor ou outras violações legais. Os dados não são combinados com outras fontes de dados.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookies utilizados</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Informações gerais sobre cookies</h3>
            <p>Cookies são pequenos arquivos de texto que seu navegador armazena no seu dispositivo. Este site usa <strong>exatamente um cookie</strong>, que é tecnicamente necessário. Não usamos cookies de sessão, de análise, de rastreamento ou de terceiros, e não são criados perfis de usuário. Como não são usados cookies que exijam consentimento, nenhum banner de cookies é exibido.</p>

            <h3 class="h6 mb-2 mt-3">5.2 Cookie de preferência de idioma (tecnicamente necessário)</h3>
            <p>Usamos um único cookie para armazenar sua preferência de idioma:</p>
            <ul>
              <li><strong>Nome do cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Finalidade:</strong> armazena o idioma da interface selecionado (por exemplo, "en", "de", "pt")</li>
              <li><strong>Validade:</strong> 30 dias</li>
              <li><strong>Dados armazenados:</strong> apenas um código de idioma de duas letras</li>
              <li><strong>Tipo:</strong> tecnicamente necessário (habilita a funcionalidade básica de preferência de idioma)</li>
            </ul>
            <p>Este cookie não contém nenhuma informação pessoal e é usado exclusivamente para fornecer a você conteúdo no seu idioma preferido. Você pode excluir este cookie a qualquer momento nas configurações do seu navegador.</p>

            <h3 class="h6 mb-2 mt-3">5.3 Base legal</h3>
            <p>A base legal é o art. 6, parágrafo 1, alínea f) do RGPD. Nosso interesse legítimo reside em disponibilizar a você o site no idioma que selecionou, sem precisar perguntar a cada visualização de página. O cookie é estritamente necessário para essa função, por isso não é exigido consentimento.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Período de armazenamento / Eliminação</h3>
            <p>O cookie é excluído automaticamente após 30 dias ou assim que você o remover manualmente. Você pode impedir a qualquer momento o armazenamento de cookies nas configurações do seu navegador; nesse caso, sua seleção de idioma não será salva e o site recorrerá à detecção automática do idioma (URL, idioma do navegador). Aqui você encontra informações sobre a exclusão de cookies em diferentes navegadores:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h2 class="h5 mb-3 mt-4">6. Contato por e-mail/correio</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Descrição e âmbito do processamento de dados</h3>
            <p>Quando você entra em contato conosco por correio ou e-mail, seus dados são processados com a finalidade de tratar sua solicitação de contato.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Base legal</h3>
            <p>A base legal para o processamento dos dados é o art. 6, parágrafo 1, alínea a) do RGPD, se você deu seu consentimento. A base legal para o processamento dos dados transmitidos no curso de uma solicitação de contato, e-mail ou carta é o art. 6, parágrafo 1, alínea f) do RGPD. O responsável tem um interesse legítimo em processar e armazenar os dados a fim de poder responder às solicitações dos usuários, preservar provas por razões de responsabilidade e cumprir suas obrigações legais de retenção de cartas comerciais, se aplicável. Se a finalidade do contato for a conclusão de um contrato, a base legal adicional para o processamento é o art. 6, parágrafo 1, alínea b) do RGPD.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Armazenamento no sistema CRM</h3>
            <p>Podemos armazenar seus dados e sua solicitação de contato em nosso sistema de gestão de relacionamento com o cliente ("sistema CRM") ou em um sistema comparável.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Duração do armazenamento</h3>
            <p>Os dados serão excluídos assim que não forem mais necessários para a finalidade para a qual foram coletados. Para os dados pessoais enviados por e-mail, isso ocorre quando a respectiva conversa com você terminou. A conversa termina quando se pode inferir das circunstâncias que o assunto em questão foi esclarecido de forma conclusiva. Armazenamos solicitações de usuários que têm uma conta ou contrato conosco por até dois anos após o término do contrato. No caso de obrigações legais de arquivamento, a exclusão ocorre após o seu término, de acordo com as diretivas da UE e as regulamentações nacionais de retenção.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Direito de oposição e direito de eliminação</h3>
            <p>Você tem o direito de retirar seu consentimento para o processamento de dados pessoais a qualquer momento, de acordo com o art. 6, parágrafo 1, alínea a) do RGPD. Se você entrar em contato conosco por e-mail, pode se opor ao armazenamento dos seus dados pessoais a qualquer momento.</p>

            <h2 class="h5 mb-3 mt-4">7. Uso das ferramentas por sua própria conta e risco</h2>
            <p><strong>Você usa todas as ferramentas deste site por sua própria conta e risco.</strong> Embora nos esforcemos para fornecer ferramentas precisas e confiáveis, não podemos garantir que estejam livres de erros ou sejam adequadas para todas as finalidades.</p>
            <p>Não aceitamos nenhuma responsabilidade por:</p>
            <ul>
              <li>Erros, imprecisões ou mau funcionamento das ferramentas</li>
              <li>Perda de dados ou danos resultantes do uso das ferramentas</li>
              <li>Decisões tomadas com base nos resultados gerados pelas nossas ferramentas</li>
            </ul>
            <p>Verifique independentemente os resultados críticos antes de usá-los em ambientes de produção.</p>

            <h2 class="h5 mb-3 mt-4">8. Os seus direitos</h2>
            <p>Você tem os seguintes direitos de acordo com o RGPD:</p>
            <ul>
              <li><strong>Direito de acesso (art. 15 RGPD):</strong> você tem o direito de solicitar informações sobre os seus dados pessoais processados por nós.</li>
              <li><strong>Direito de retificação (art. 16 RGPD):</strong> você tem o direito de solicitar a retificação imediata de dados pessoais imprecisos ou a conclusão de dados pessoais incompletos.</li>
              <li><strong>Direito à exclusão (art. 17 RGPD):</strong> você tem o direito de solicitar a exclusão dos seus dados pessoais.</li>
              <li><strong>Limitação do processamento (art. 18 RGPD):</strong> você tem o direito de solicitar a limitação do processamento dos seus dados pessoais.</li>
              <li><strong>Portabilidade de dados (art. 20 RGPD):</strong> você tem o direito de receber seus dados pessoais em um formato estruturado, de uso comum e legível por máquina.</li>
              <li><strong>Direito de oposição (art. 21 RGPD):</strong> você tem o direito de se opor ao processamento de dados pessoais que lhe dizem respeito a qualquer momento por razões decorrentes da sua situação particular.</li>
              <li><strong>Retirada do consentimento (art. 7, parágrafo 3 RGPD):</strong> você tem o direito de retirar seu consentimento a qualquer momento.</li>
              <li><strong>Direito de apresentar uma reclamação (art. 77 RGPD):</strong> você tem o direito de apresentar uma reclamação junto de uma autoridade de controlo.</li>
            </ul>
            <p>Se você tiver alguma dúvida sobre proteção de dados, entre em contato conosco usando os dados de contato fornecidos no aviso legal.</p>

          </div>
        </div>

    </div>
  </main>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
