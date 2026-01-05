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
$pageTitle = 'Política de Privacidade – WebDev-Tools';
$pageDescription = 'Política de privacidade e informações sobre proteção de dados para WebDev-Tools.';

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
  <meta name="theme-color" content="#0d6efd">
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
  <meta name="apple-mobile-web-app-title" content="WebDev Tools" />
  <link rel="manifest" href="<?= $assetPrefix ?>assets/img/site.webmanifest" />

  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= $assetPrefix ?>assets/css/style.css?v=<?= $buildHash ?>">

  <script src="<?= $assetPrefix ?>assets/js/theme-init.js"></script>

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
</head>
<body class="d-flex flex-column bg-body">

<?php include __DIR__ . '/../partials/header-with-sidebar.php'; ?>

  <div class="d-flex flex-grow-1 position-relative">
    <div class="left-sidebar-spacer"></div>

  <main class="flex-grow-1 p-4 p-md-5 bg-body shadow-sm overflow-auto">
    <div class="tool-container-inner mx-auto">

        <div class="text-center mb-5">
          <h1 class="display-5 mb-3">Política de Privacidade</h1>
          <p class="lead text-secondary">Sua privacidade é importante</p>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-body p-4">
            
            <h2 class="h5 card-title mb-3">1. Proteção de dados em resumo</h2>
            
            <h3 class="h6 mb-2">Informações gerais</h3>
            <p>As informações a seguir fornecem uma visão geral simples sobre o que acontece com os seus dados pessoais quando visita este site. Dados pessoais são todos os dados com os quais pode ser identificado pessoalmente.</p>

            <h3 class="h6 mb-2 mt-3">Recolha de dados neste site</h3>
            <p><strong>Quem é responsável pela recolha de dados neste site?</strong></p>
            <p>O processamento de dados neste site é feito pelo operador do site. Os seus dados de contacto podem ser encontrados nas informações legais deste site.</p>
            
            <p><strong>Como recolhemos os seus dados?</strong></p>
            <p>Os seus dados são recolhidos, por um lado, quando você nos fornece. Estes podem ser, por exemplo, dados que você nos envia por e-mail.</p>
            <p>Outros dados são recolhidos automaticamente ou após o seu consentimento ao visitar o site pelos nossos sistemas de TI. Trata-se principalmente de dados técnicos (por exemplo, navegador da Internet, sistema operativo ou hora da visita ao site). A recolha desses dados é feita automaticamente assim que entra neste site.</p>
            
            <p><strong>Para que utilizamos os seus dados?</strong></p>
            <p>Parte dos dados é recolhida para garantir o funcionamento sem erros do website. Outros dados podem ser utilizados para analisar o seu comportamento de utilizador. Além disso, utilizamos o Google AdSense para financiar este website gratuito através de anúncios publicitários.</p>
            
            <p><strong>Quais são os seus direitos em relação aos seus dados?</strong></p>
            <p>Tem o direito de obter, a qualquer momento e gratuitamente, informações sobre a origem, o destinatário e a finalidade dos seus dados pessoais armazenados. Tem também o direito de solicitar a correção ou eliminação desses dados. Se tiver dado o seu consentimento para o tratamento de dados, pode revogar esse consentimento a qualquer momento no futuro. Além disso, tem o direito de solicitar, em determinadas circunstâncias, a restrição do tratamento dos seus dados pessoais. Além disso, tem o direito de apresentar uma reclamação à autoridade supervisora competente.</p>

            <h2 class="h5 mb-3 mt-4">2. Abordagem de privacidade em primeiro lugar para ferramentas</h2>
            <p><strong>Todas as ferramentas deste site processam os seus dados de entrada exclusivamente no seu navegador.</strong> Ao utilizar as nossas ferramentas (por exemplo, codificador Base64, formatador JSON, etc.), aplica-se o seguinte:</p>
            <ul>
              <li>Todas as conversões, validações e gerações são feitas no lado do cliente, no seu navegador</li>
              <li>Os seus dados inseridos nas ferramentas nunca saem do seu dispositivo</li>
              <li>Não armazenamos, registamos nem temos acesso aos dados que processa com as nossas ferramentas</li>
              <li>Não podemos fornecer informações sobre dados inseridos nas ferramentas que não temos, pois não os recolhemos</li>
            </ul>
            <p><strong>Observação importante:</strong> isso se refere exclusivamente ao processamento dos seus dados <em>dentro das ferramentas</em>. No entanto, ao visitar o site, dados técnicos são coletados automaticamente (ver seção 4) e o Google AdSense utiliza cookies para fins publicitários (ver seções 6 e 7).</p>

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
                </tbody>
              </table>
            </div>
            <p><small class="text-muted">Os hashes SRI completos podem ser verificados em nosso <a href="https://github.com/RamonKaes/WebDev-Tools/blob/main/config/tools.php" target="_blank" rel="noopener noreferrer">código-fonte</a>.</small></p>

            <h3 class="h6 mb-2 mt-3">3.3 Política de Segurança de Conteúdo (CSP)</h3>
            <p>Implementamos políticas de segurança de conteúdo rigorosas para prevenir ataques XSS e execução de código não autorizado:</p>
            <ul>
              <li><i class="bi bi-check-circle text-success me-2"></i>Execução de scripts baseada em nonce (previne injeção de scripts inline)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Carregamento restrito de recursos externos (apenas de CDNs confiáveis)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Incorporação de frames completamente desabilitada (proteção contra clickjacking)</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Execução de objetos e plugins bloqueada</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.4 Cabeçalhos de Segurança Adicionais</h3>
            <ul class="small">
              <li><strong>X-Frame-Options: DENY</strong> - Previne ataques de incorporação de iframe</li>
              <li><strong>X-Content-Type-Options: nosniff</strong> - Previne rastreamento de tipo MIME</li>
              <li><strong>Referrer-Policy: strict-origin-when-cross-origin</strong> - Limita vazamento de informações do referenciador</li>
              <li><strong>Strict-Transport-Security (HSTS)</strong> - Força conexões HTTPS com pré-carregamento</li>
              <li><strong>Permissions-Policy</strong> - Desabilita recursos desnecessários do navegador (geolocalização, câmera, microfone, etc.)</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">3.5 Zero Dependências Externas para Processamento de Dados</h3>
            <p>Todas as funções principais de processamento de dados usam apenas APIs nativas do navegador. Bibliotecas externas são usadas apenas para componentes de UI (renderização de código QR) e são carregadas com verificação SRI.</p>

            <h2 class="h5 mb-3 mt-4">4. Alojamento e ficheiros de registo do servidor</h2>
            
            <h3 class="h6 mb-2 mt-3">4.1 Descrição e âmbito do processamento de dados</h3>
            <p>Este website é alojado por um prestador de serviços externo. Se utilizar o nosso website apenas para fins informativos (ou seja, sem registo nem qualquer outra transmissão de informações), recolhemos apenas os dados pessoais que o seu navegador transmite ao nosso servidor. Se pretender visualizar o nosso website, recolhemos os seguintes dados:</p>
            <ul>
              <li>Endereço IP</li>
              <li>Provedor de serviços de Internet do utilizador</li>
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
            <p>Esses dados são usados com a finalidade de fornecer-lhe um website amigável, funcional e seguro com funções e conteúdos, bem como para sua otimização e avaliação estatística. Os dados são usados exclusivamente para a operação técnica e segurança do website.</p>

            <h3 class="h6 mb-2 mt-3">4.3 Base legal</h3>
            <p>A base legal é o nosso interesse legítimo no processamento de dados de acordo com o art. 6, parágrafo 1, alínea f) do RGPD, que também se reflete nas finalidades acima mencionadas.</p>

            <h3 class="h6 mb-2 mt-3">4.4 Período de armazenamento</h3>
            <p>Por razões de segurança, armazenamos esses dados em ficheiros de registo do servidor por um período de armazenamento de 60 dias. Após o término deste período, são automaticamente eliminados, a menos que precisemos retê-los para fins probatórios em caso de ataques à infraestrutura do servidor ou outras violações legais. Os dados não são fundidos com outras fontes de dados.</p>

            <h2 class="h5 mb-3 mt-4">5. Cookies utilizados</h2>
            
            <h3 class="h6 mb-2 mt-3">5.1 Informações gerais sobre cookies</h3>
            <p>Utilizamos cookies quando visita o nosso website. Os cookies são pequenos ficheiros de texto que o seu navegador de Internet armazena no seu computador. Quando visita novamente o nosso website, esses cookies fornecem informações para reconhecê-lo automaticamente. Os cookies também incluem os chamados "IDs de utilizador", onde as informações dos utilizadores são armazenadas usando perfis pseudonimizados. Quando visita o nosso website, informamos sobre o uso de cookies para as finalidades acima mencionadas e como pode opor-se a isso ou impedir o seu armazenamento ("opt-out") fazendo referência à nossa política de privacidade.</p>
            
            <p>Distinguem-se os seguintes tipos de cookies:</p>
            <ul>
              <li><strong>Cookies necessários e essenciais:</strong> os cookies essenciais são cookies absolutamente necessários para o funcionamento do website, a fim de armazenar certas funções do website, como logins, carrinho de compras ou entradas do utilizador, por exemplo, em relação ao idioma do website.</li>
              <li><strong>Cookies de sessão:</strong> os cookies de sessão são necessários para reconhecer o uso múltiplo de uma oferta pelo mesmo utilizador (por exemplo, quando fez login para determinar o seu status de login). Quando visita novamente o nosso site, esses cookies fornecem informações para reconhecê-lo automaticamente. As informações obtidas desta forma são usadas para otimizar as nossas ofertas e facilitar o seu acesso ao nosso site. Quando fecha o navegador ou faz logout, os cookies de sessão são eliminados.</li>
              <li><strong>Cookies persistentes:</strong> esses cookies permanecem armazenados mesmo após o fecho do navegador. São usados para armazenar o seu login, medir o alcance e para fins de marketing. São automaticamente eliminados após um período especificado, que pode variar dependendo do cookie. Pode eliminar cookies a qualquer momento nas configurações de segurança do seu navegador.</li>
              <li><strong>Cookies de terceiros (especialmente de anunciantes):</strong> pode configurar as definições do seu navegador de acordo com as suas preferências e, por exemplo, recusar cookies de terceiros ou todos os cookies. No entanto, gostaríamos de salientar que pode não conseguir usar todas as funções deste website se o fizer. Para mais informações sobre esses cookies, consulte as respectivas políticas de privacidade dos fornecedores terceiros.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.2 Categorias de dados</h3>
            <p>Dados do utilizador, cookies, ID do utilizador (incluindo as páginas visitadas, informações do dispositivo, horários de acesso e endereços IP).</p>

            <h3 class="h6 mb-2 mt-3">5.3 Finalidades do processamento</h3>
            <p>As informações obtidas desta forma servem à finalidade de otimizar as nossas ofertas web técnica e economicamente e permitir-lhe um acesso mais fácil e seguro ao nosso website.</p>

            <h3 class="h6 mb-2 mt-3">5.4 Base legal</h3>
            <p>Se processarmos os seus dados pessoais com a ajuda de cookies com base no seu consentimento ("opt-in"), então o art. 6, parágrafo 1, alínea a) do RGPD é a base legal. Caso contrário, temos um interesse legítimo na funcionalidade efetiva, melhoria e operação económica do website, caso em que o art. 6, parágrafo 1, alínea f) do RGPD é a base legal. A base legal também é o art. 6, parágrafo 1, alínea b) do RGPD se os cookies forem definidos com a finalidade de iniciar um contrato, por exemplo, para encomendas.</p>

            <h3 class="h6 mb-2 mt-3">5.5 Período de armazenamento / Eliminação</h3>
            <p>Os dados serão eliminados assim que não forem mais necessários para a finalidade para a qual foram recolhidos. No caso da recolha de dados para o fornecimento do website, este é o caso quando a respectiva sessão termina.</p>
            <p>Caso contrário, os cookies são armazenados no seu computador e transmitidos ao nosso site. Como utilizador, portanto, tem controlo total sobre o uso de cookies. Pode desativar ou restringir a transmissão de cookies alterando as configurações no seu navegador de Internet. Os cookies já armazenados podem ser eliminados a qualquer momento. Isso também pode ser feito automaticamente. Se os cookies forem desativados para o nosso website, pode não ser mais possível usar todas as funções do website na sua totalidade.</p>
            <p>Aqui encontrará informações sobre a eliminação de cookies para diferentes navegadores:</p>
            <ul>
              <li>Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">https://support.google.com/chrome/answer/95647</a></li>
              <li>Safari: <a href="https://support.apple.com/de-at/guide/safari/sfri11471/mac" target="_blank" rel="noopener">https://support.apple.com/de-at/guide/safari/sfri11471/mac</a></li>
              <li>Firefox: <a href="https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen" target="_blank" rel="noopener">https://support.mozilla.org/de/kb/cookies-und-website-daten-in-firefox-loschen</a></li>
              <li>Internet Explorer: <a href="https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/17442/windows-internet-explorer-delete-manage-cookies</a></li>
              <li>Microsoft Edge: <a href="https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies" target="_blank" rel="noopener">https://support.microsoft.com/de-at/help/4027947/windows-delete-cookies</a></li>
            </ul>

            <h3 class="h6 mb-2 mt-3">5.6 Oposição e "opt-out"</h3>
            <p>Pode geralmente impedir que os cookies sejam armazenados no seu disco rígido, independentemente do consentimento ou permissão legal, selecionando "não aceitar cookies" nas configurações do seu navegador. No entanto, isso pode resultar em restrições funcionais às nossas ofertas. Pode opor-se ao uso de cookies de terceiros para fins publicitários através de um chamado "opt-out" neste website americano (<a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a>) ou neste website europeu (<a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>).</p>

            <h3 class="h6 mb-2 mt-3">Cookie de preferência de idioma (tecnicamente necessário)</h3>
            <p>Utilizamos um único cookie para armazenar a sua preferência de idioma:</p>
            <ul>
              <li><strong>Nome do cookie:</strong> <code>webdev-tools-lang</code></li>
              <li><strong>Finalidade:</strong> armazena o idioma da interface selecionado (por exemplo, "en", "de", "pt")</li>
              <li><strong>Validade:</strong> 30 dias</li>
              <li><strong>Dados armazenados:</strong> apenas um código de idioma de duas letras</li>
              <li><strong>Tipo:</strong> tecnicamente necessário (habilita a funcionalidade básica de preferência de idioma)</li>
            </ul>
            <p>Este cookie não contém nenhuma informação pessoal e é usado exclusivamente para fornecer-lhe conteúdo no seu idioma preferido. Pode eliminar este cookie a qualquer momento através das configurações do seu navegador.</p>

            <h2 class="h5 mb-3 mt-4">6. Google Adsense</h2>
            
            <h3 class="h6 mb-2 mt-3">6.1 Introdução</h3>
            <p>Integrámos anúncios do serviço Google "Adsense" (fornecedor de serviços: Google Ireland Limited, número de registo: 368047, Gordon House, Barrow Street, Dublin 4, Irlanda) no nosso website. Os anúncios são marcados com a nota (i) "Anúncios Google" em cada anúncio.</p>

            <h3 class="h6 mb-2 mt-3">6.2 Categorias de dados e descrição do processamento de dados</h3>
            <p>Dados de uso/dados de comunicação; quando visita o nosso website, o Google recebe a informação de que acedeu ao nosso website. Para isso, o Google coloca um web beacon ou cookie no seu computador. Os dados também são transferidos para os EUA e lá analisados. Se estiver conectado com uma conta Google, o Adsense pode atribuir os dados à sua conta. Se não desejar que isso aconteça, deve fazer logout antes de visitar o nosso website. No entanto, o Google também pode usar outras informações para esta finalidade:</p>
            <ul>
              <li>o tipo de websites que visita e as aplicações móveis instaladas no seu dispositivo;</li>
              <li>cookies no seu navegador e configurações na sua conta Google;</li>
              <li>websites e aplicações que visitou;</li>
              <li>as suas atividades noutros dispositivos;</li>
              <li>interações anteriores com anúncios ou serviços publicitários do Google;</li>
              <li>as atividades e informações da sua conta Google.</li>
            </ul>
            <p>Quando clica num anúncio do Adsense, o Google processa o endereço IP do utilizador (dados de uso), pelo que o processamento é pseudonimizado (chamado "ID de publicidade") truncando os últimos dois dígitos do endereço IP. No caso de publicidade personalizada, o Google não vincula identificadores de cookies ou tecnologias semelhantes a categorias especiais de dados pessoais nos termos do art. 9 do RGPD, como origem étnica, religião, orientação sexual ou saúde.</p>

            <h3 class="h6 mb-2 mt-3">6.3 Finalidade do processamento</h3>
            <p>Ativámos os anúncios personalizados a fim de mostrar-lhe publicidade mais interessante que apoia o uso comercial do nosso website, aumenta o seu valor para nós e melhora a sua experiência de utilizador. Com a ajuda da publicidade personalizada, podemos alcançar utilizadores através do Adsense com base nos seus interesses e características demográficas (por exemplo, "entusiastas do desporto"). Além disso, o processamento é usado para rastreamento, remarketing e medição de conversão, bem como para financiar o nosso website.</p>

            <h3 class="h6 mb-2 mt-3">6.4 Base legal</h3>
            <p>Se deu o seu consentimento ("opt-in") para o processamento dos seus dados pessoais através do "Google Adsense com anúncios personalizados", então o art. 6, parágrafo 1, alínea a) do RGPD é a base legal. Caso contrário, a base legal para o processamento dos seus dados é o art. 6, parágrafo 1, alínea f) do RGPD com base nos nossos interesses legítimos na análise, otimização e operação económica eficiente da nossa publicidade e website.</p>

            <h3 class="h6 mb-2 mt-3">6.5 Transferência de dados/categoria de destinatários</h3>
            <p>Google Irlanda, EUA; este website também ativou anúncios Google AdSense de terceiros. Os dados acima mencionados também podem ser transferidos para esses fornecedores terceiros, conhecidos como "Fornecedores Externos Certificados", listados em <a href="https://support.google.com/dfp_sb/answer/94149" target="_blank" rel="noopener">https://support.google.com/dfp_sb/answer/94149</a>.</p>

            <h3 class="h6 mb-2 mt-3">6.6 Período de armazenamento</h3>
            <p>Os dados são armazenados por até 24 meses após a última visita.</p>

            <h3 class="h6 mb-2 mt-3">6.7 Opções de oposição e eliminação ("opt-out")</h3>
            <p>Pode opor-se ou impedir a instalação de cookies pelo Google Adsense de várias maneiras:</p>
            <ul>
              <li>Pode impedir cookies no seu navegador selecionando a configuração "não aceitar cookies", que também inclui cookies de terceiros;</li>
              <li>Pode desativar os anúncios personalizados no Google diretamente através do link <a href="https://adssettings.google.com" target="_blank" rel="noopener">https://adssettings.google.com</a>, embora esta configuração permaneça em vigor apenas até eliminar os seus cookies. As instruções para desativar a publicidade personalizada em dispositivos móveis podem ser encontradas aqui: <a href="https://support.google.com/adsense/troubleshooter/1631343" target="_blank" rel="noopener">https://support.google.com/adsense/troubleshooter/1631343</a>;</li>
              <li>Pode desativar os anúncios personalizados de fornecedores terceiros que participam na iniciativa de autorregulação publicitária "About Ads" através do link <a href="https://optout.aboutads.info" target="_blank" rel="noopener">https://optout.aboutads.info</a> para sites dos EUA ou <a href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank" rel="noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a> para sites da UE. Esta configuração permanecerá em vigor apenas até eliminar todos os seus cookies.</li>
              <li>Pode desativar permanentemente os cookies usando um plug-in de navegador para Chrome, Firefox ou Internet Explorer em <a href="https://support.google.com/ads/answer/7395996" target="_blank" rel="noopener">https://support.google.com/ads/answer/7395996</a>. A desativação de cookies pode significar que não poderá mais usar todas as funções do nosso website na sua totalidade.</li>
            </ul>

            <h3 class="h6 mb-2 mt-3">6.8 Mais informações</h3>
            <p>Na política de privacidade do Google para publicidade em <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener">https://policies.google.com/technologies/ads</a>, encontrará mais informações sobre o uso de cookies do Google em anúncios e suas tecnologias publicitárias, duração do armazenamento, anonimização, dados de localização, funcionalidade e os seus direitos.</p>

            <h2 class="h5 mb-3 mt-4">7. Contacto por e-mail/correio postal</h2>
            
            <h3 class="h6 mb-2 mt-3">7.1 Descrição e âmbito do processamento de dados</h3>
            <p>Quando nos contacta por correio postal ou e-mail, os seus dados são processados com a finalidade de tratar a sua solicitação de contacto.</p>

            <h3 class="h6 mb-2 mt-3">7.2 Base legal</h3>
            <p>A base legal para o processamento dos dados é o art. 6, parágrafo 1, alínea a) do RGPD se deu o seu consentimento. A base legal para o processamento dos dados transmitidos no curso de uma solicitação de contacto ou e-mail ou carta é o art. 6, parágrafo 1, alínea f) do RGPD. O responsável tem um interesse legítimo em processar e armazenar os dados a fim de poder responder às solicitações dos utilizadores, preservar provas por razões de responsabilidade e poder cumprir as suas obrigações legais de retenção de cartas comerciais, se aplicável. Se a finalidade do contacto for a conclusão de um contrato, a base legal adicional para o processamento é o art. 6, parágrafo 1, alínea b) do RGPD.</p>

            <h3 class="h6 mb-2 mt-3">7.3 Armazenamento no sistema CRM</h3>
            <p>Podemos armazenar os seus dados e solicitação de contacto no nosso sistema de gestão de relacionamento com o cliente ("sistema CRM") ou num sistema comparável.</p>

            <h3 class="h6 mb-2 mt-3">7.4 Duração do armazenamento</h3>
            <p>Os dados serão eliminados assim que não forem mais necessários para a finalidade para a qual foram recolhidos. Para os dados pessoais enviados por e-mail, este é o caso quando a respetiva conversa consigo terminou. A conversa termina quando se pode inferir das circunstâncias que o assunto em questão foi esclarecido de forma conclusiva. Armazenamos solicitações de utilizadores que têm uma conta ou contrato connosco por até dois anos após o término do contrato. No caso de obrigações legais de arquivo, a eliminação ocorre após o seu término de acordo com as diretivas da UE e regulamentações nacionais de retenção.</p>

            <h3 class="h6 mb-2 mt-3">7.5 Direito de oposição e direito de eliminação</h3>
            <p>Tem o direito de retirar o seu consentimento para o processamento de dados pessoais a qualquer momento de acordo com o art. 6, parágrafo 1, alínea a) do RGPD. Se nos contactar por e-mail, pode opor-se ao armazenamento dos seus dados pessoais a qualquer momento.</p>

            <h2 class="h5 mb-3 mt-4">8. Uso das ferramentas por sua própria conta e risco</h2>
            <p><strong>Utiliza todas as ferramentas deste website por sua própria conta e risco.</strong> Embora nos esforcemos para fornecer ferramentas precisas e confiáveis, não podemos garantir que estejam livres de erros ou sejam adequadas para todas as finalidades.</p>
            <p>Não aceitamos nenhuma responsabilidade por:</p>
            <ul>
              <li>Erros, imprecisões ou mau funcionamento das ferramentas</li>
              <li>Perda de dados ou danos resultantes do uso das ferramentas</li>
              <li>Decisões tomadas com base nos resultados gerados pelas nossas ferramentas</li>
            </ul>
            <p>Verifique independentemente os resultados críticos antes de usá-los em ambientes de produção.</p>

            <h2 class="h5 mb-3 mt-4">9. Os seus direitos</h2>
            <p>Tem os seguintes direitos de acordo com o RGPD:</p>
            <ul>
              <li><strong>Direito de acesso (art. 15 RGPD):</strong> tem o direito de solicitar informações sobre os seus dados pessoais processados por nós.</li>
              <li><strong>Direito de retificação (art. 16 RGPD):</strong> tem o direito de solicitar a retificação imediata de dados pessoais imprecisos ou a conclusão de dados pessoais incompletos.</li>
              <li><strong>Direito ao apagamento (art. 17 RGPD):</strong> tem o direito de solicitar a eliminação dos seus dados pessoais.</li>
              <li><strong>Limitação do processamento (art. 18 RGPD):</strong> tem o direito de solicitar a limitação do processamento dos seus dados pessoais.</li>
              <li><strong>Portabilidade de dados (art. 20 RGPD):</strong> tem o direito de receber os seus dados pessoais num formato estruturado, de uso comum e legível por máquina.</li>
              <li><strong>Direito de oposição (art. 21 RGPD):</strong> tem o direito de se opor ao processamento de dados pessoais que lhe dizem respeito a qualquer momento por razões decorrentes da sua situação particular.</li>
              <li><strong>Retirada do consentimento (art. 7, parágrafo 3 RGPD):</strong> tem o direito de retirar o seu consentimento a qualquer momento.</li>
              <li><strong>Direito de apresentar uma reclamação (art. 77 RGPD):</strong> tem o direito de apresentar uma reclamação junto de uma autoridade de controlo.</li>
            </ul>
            <p>Se tiver alguma dúvida sobre proteção de dados, contacte-nos usando os dados de contacto fornecidos nas informações legais.</p>

          </div>
        </div>

    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
