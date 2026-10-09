<?php

// Inicia a sessão para armazenar os dados do cliente que realizar o cadastro.
session_start();

// Importa a conexão com o banco de dados e as funções utilizadas pelo sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Variável que armazena as mensagens de erro exibidas na página.
$mensagem = "";

// Verifica se o formulário foi enviado pelo botão "Cadastrar".
if (isset($_POST["cadastrar"])) {

    // trim() remove espaços em branco do início e do final do texto.
    // Verifica se o nome foi informado e não contém apenas espaços.
    if (!isset($_POST["nome"]) || trim($_POST["nome"]) == "") {

        $mensagem = "Erro: informe o nome.";

    // Verifica se o email foi informado corretamente como campo preenchido.
    } elseif (!isset($_POST["email"]) || trim($_POST["email"]) == "") {

        $mensagem = "Erro: informe o email.";

    // Verifica se a senha foi informada.
    } elseif (!isset($_POST["senha"]) || trim($_POST["senha"]) == "") {

        $mensagem = "Erro: informe a senha.";

    } else {

        // Guarda os dados enviados pelo formulário.
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // Define que os usuários cadastrados por esta página são clientes.
        $tipo = "cliente";

        // Chama a função que cadastra o usuário no banco de dados.
        // !== false verifica se o retorno é diferente do valor booleano false.
        if (cadastrarUsuario($conexao, $nome, $email, $senha, $tipo) !== false) {

            // Armazena os dados do cliente na sessão após o cadastro.
            // Assim, o sistema pode reconhecer o usuário como logado.
            $_SESSION["usuario"] = $email;
            $_SESSION["tipo"] = $tipo;
            $_SESSION["nome"] = $nome;

            // Redireciona o cliente para a página select.php.
            header("Location: select.php");
            exit; // Encerra a execução após o redirecionamento.

        } else {

            // Exibe uma mensagem caso a função indique falha no cadastro.
            $mensagem = "Erro ao realizar o cadastro. Tente novamente.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petite Patisserie - Cadastro de Cliente</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="login-container">

    <div class="login-card">

        <h2>Cadastro de cliente</h2>

        <p class="subtitle">
            Preencha os campos para começar a comprar nossas delícias
        </p>

        <!-- Exibe a mensagem de erro somente quando ela não está vazia. -->
        <?php if (!empty($mensagem)): ?>

            <p class="error-message">
                <?php
                // htmlspecialchars() impede que caracteres especiais sejam interpretados como HTML.
                echo htmlspecialchars($mensagem);
                ?>
            </p>

        <?php endif; ?>

        <!-- O método POST envia os dados do formulário ao PHP sem colocá-los na URL. -->
        <form method="POST">

            <div class="form-group">

                <label for="nome">Nome completo</label>

                <!-- Campo para informar o nome do cliente. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Seu nome completo"
                       required>

            </div>

            <div class="form-group">

                <label for="email">E-mail</label>

                <!-- type="email" permite ao navegador verificar o formato básico do email. -->
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="seuemail@exemplo.com"
                       required>

            </div>

            <div class="form-group">

                <label for="senha">Senha</label>

                <!-- type="password" oculta visualmente os caracteres digitados. -->
                <input type="password"
                       id="senha"
                       name="senha"
                       class="form-control"
                       placeholder="••••••••"
                       required>

            </div>

            <!-- Envia os dados para o processamento do cadastro. -->
            <input type="submit"
                   name="cadastrar"
                   value="Cadastrar"
                   class="btn-cute">

        </form>

        <div class="login-footer">

            <p>
                Já tem uma conta?
                <!-- Link para a página de login dos clientes. -->
                <a href="../login/login_cliente.php">Entre</a>
            </p>

        </div>

    </div>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>