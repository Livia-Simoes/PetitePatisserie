<?php

// Inicia a sessão para permitir armazenar informações do cliente
// e manter os dados disponíveis durante a navegação pelo site.
session_start();


// Inclui o arquivo responsável por estabelecer a conexão com o banco de dados.
// A variável $conexao será utilizada para realizar o cadastro do cliente.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas pelo sistema,
// incluindo a função cadastrarUsuario().
include(__DIR__ . "/../includes/functions.php");


// Cria uma variável vazia para armazenar mensagens de erro
// que poderão ser exibidas ao usuário na página.
$mensagem = "";


// Verifica se o formulário foi enviado pelo botão chamado "cadastrar".
// O isset() identifica se essa informação foi enviada pelo método POST.
if (isset($_POST["cadastrar"])) {


    // Verifica se o campo nome foi enviado e se não está vazio.
    // O trim() remove os espaços em branco do início e do final do texto.
    // Isso impede que o usuário informe apenas espaços como nome.
    if (!isset($_POST["nome"]) || trim($_POST["nome"]) == "") {

        // Armazena uma mensagem informando que o nome precisa ser preenchido.
        $mensagem = "Erro: informe o nome.";


    // Verifica se o campo email foi enviado e se não está vazio.
    // O trim() também remove espaços em branco do início e do final do email.
    } elseif (!isset($_POST["email"]) || trim($_POST["email"]) == "") {

        // Armazena uma mensagem informando que o email precisa ser preenchido.
        $mensagem = "Erro: informe o email.";


    // Verifica se o campo senha foi enviado e se não está vazio.
    // Essa verificação impede que o cadastro continue sem uma senha.
    } elseif (!isset($_POST["senha"]) || trim($_POST["senha"]) == "") {

        // Armazena uma mensagem informando que a senha precisa ser preenchida.
        $mensagem = "Erro: informe a senha.";


    } else {

        // Se todos os campos estiverem preenchidos, o código entra neste bloco.


        // Recebe o nome informado pelo cliente no formulário.
        // O $_POST["nome"] acessa o valor do campo que possui name="nome".
        $nome = $_POST["nome"];

        // Recebe o email informado pelo cliente.
        $email = $_POST["email"];

        // Recebe a senha informada pelo cliente.
        $senha = $_POST["senha"];


        // Define o tipo de usuário como "cliente".
        // Assim, todos os usuários cadastrados por esta página
        // serão registrados como clientes, e não como administradores.
        $tipo = "cliente";


        // Chama a função cadastrarUsuario(), localizada no arquivo functions.php.
        // Ela recebe a conexão com o banco de dados, o nome, o email,
        // a senha e o tipo de usuário para realizar o cadastro.
        //
        // O operador !== significa "diferente de".
        // Portanto, a condição verifica se o retorno da função é diferente
        // do valor booleano false, indicando que o cadastro foi realizado.
        if (cadastrarUsuario($conexao, $nome, $email, $senha, $tipo) !== false) {


            // Armazena o email do cliente na sessão.
            // Essa informação permite identificar qual usuário está conectado.
            $_SESSION["usuario"] = $email;

            // Armazena o tipo de usuário na sessão.
            // Essa informação permite diferenciar clientes de administradores.
            $_SESSION["tipo"] = $tipo;

            // Armazena o nome do cliente na sessão.
            // Assim, o sistema pode utilizar o nome durante a navegação.
            $_SESSION["nome"] = $nome;


            // Redireciona o cliente para a página select.php após o cadastro.
            // Essa página corresponde à vitrine de produtos da Petite Patisserie.
            header("Location: select.php");

            // Interrompe a execução do código após o redirecionamento,
            // impedindo que o restante da página continue sendo processado.
            exit;


        } else {

            // Caso a função cadastrarUsuario() retorne false,
            // armazena uma mensagem informando que ocorreu um erro no cadastro.
            $mensagem = "Erro ao realizar o cadastro. Tente novamente.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres utilizada na página,
         permitindo a exibição correta de acentos e caracteres especiais. -->
    <meta charset="UTF-8">

    <!-- Configura a página para se adaptar a diferentes tamanhos de tela,
         como computadores, celulares e tablets. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Petite Patisserie - Cadastro de Cliente</title>


    <!-- Conecta a página ao arquivo CSS externo,
         responsável pela aparência e formatação dos elementos. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho padrão do site.
     O __DIR__ representa o diretório atual deste arquivo,
     facilitando a localização do header.php. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Define a área principal da página.
     A classe login-container aplica a formatação definida no CSS. -->
<main class="login-container">


    <!-- Cria um cartão para organizar os elementos da página,
         como o título, as mensagens e o formulário. -->
    <div class="login-card">


        <!-- Título que identifica a página de cadastro de clientes. -->
        <h2>Cadastro de cliente</h2>


        <!-- Apresenta uma breve orientação para o cliente
             sobre o preenchimento do formulário. -->
        <p class="subtitle">
            Preencha os campos para começar a comprar nossas delícias
        </p>


        <!-- Verifica se a variável mensagem possui algum conteúdo.
             Se estiver vazia, nenhuma mensagem de erro será exibida.
             Caso tenha sido preenchida, o erro será apresentado na página. -->
        <?php if (!empty($mensagem)): ?>


            <!-- Parágrafo utilizado para exibir mensagens de erro.
                 A classe error-message aplica a formatação definida no CSS. -->
            <p class="error-message">

                <?php
                // O echo exibe o conteúdo da variável mensagem.
                // O htmlspecialchars() impede que caracteres especiais
                // sejam interpretados como código HTML pelo navegador.
                echo htmlspecialchars($mensagem);
                ?>

            </p>


        <!-- Encerra a condição responsável pela exibição da mensagem. -->
        <?php endif; ?>


        <!-- Cria o formulário utilizado para realizar o cadastro do cliente.
             O método POST envia os dados para o PHP sem colocá-los na URL. -->
        <form method="POST">


            <!-- Agrupa os elementos relacionados ao nome do cliente. -->
            <div class="form-group">


                <!-- Identifica o campo onde o cliente deve informar seu nome completo. -->
                <label for="nome">Nome completo</label>


                <!-- Campo de texto utilizado para receber o nome do cliente.
                     O type="text" permite digitar textos.
                     O id="nome" identifica o campo no HTML.
                     O name="nome" permite que o PHP receba o valor por $_POST.
                     O placeholder apresenta uma orientação dentro do campo.
                     O required torna o preenchimento obrigatório.
                     A classe form-control aplica a formatação do CSS. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Seu nome completo"
                       required>


            </div>


            <!-- Agrupa os elementos relacionados ao email do cliente. -->
            <div class="form-group">


                <!-- Identifica o campo onde o cliente deve informar seu email. -->
                <label for="email">E-mail</label>


                <!-- Campo utilizado para receber o email do cliente.
                     O type="email" faz uma verificação básica do formato do endereço,
                     como a presença de um nome e de um domínio.
                     O name="email" permite acessar o valor pelo $_POST["email"].
                     O placeholder apresenta um exemplo de preenchimento.
                     O required torna o campo obrigatório. -->
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="seuemail@exemplo.com"
                       required>


            </div>


            <!-- Agrupa os elementos relacionados à senha do cliente. -->
            <div class="form-group">


                <!-- Identifica o campo onde o cliente deve criar sua senha. -->
                <label for="senha">Senha</label>


                <!-- Campo utilizado para receber a senha do cliente.
                     O type="password" oculta visualmente os caracteres digitados.
                     O name="senha" permite que o PHP receba o valor pelo POST.
                     O placeholder apresenta uma indicação visual de preenchimento.
                     O required torna o campo obrigatório. -->
                <input type="password"
                       id="senha"
                       name="senha"
                       class="form-control"
                       placeholder="••••••••"
                       required>


            </div>


            <!-- Botão responsável por enviar os dados do formulário.
                 O type="submit" realiza o envio.
                 O name="cadastrar" permite que o PHP identifique
                 o envio através de isset($_POST["cadastrar"]).
                 O value define o texto exibido no botão.
                 A classe btn-cute aplica a aparência definida no CSS. -->
            <input type="submit"
                   name="cadastrar"
                   value="Cadastrar"
                   class="btn-cute">


        <!-- Encerra o formulário. -->
        </form>


        <!-- Área destinada a apresentar o link para quem já possui uma conta. -->
        <div class="login-footer">


            <p>

                <!-- Informa ao usuário que ele pode acessar sua conta
                     caso já tenha realizado um cadastro anteriormente. -->
                Já tem uma conta?

                <!-- Link que direciona o cliente para a página de login.
                     O href indica o caminho do arquivo login_cliente.php. -->
                <a href="../login/login_cliente.php">Entre</a>

            </p>


        </div>


    </div>

</main>


<!-- Inclui o rodapé padrão do site,
     mantendo a estrutura visual compartilhada entre as páginas. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>