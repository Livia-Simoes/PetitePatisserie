<?php

// Inicia a sessão e verifica se o usuário tem permissão de administrador.
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {
    // Redireciona usuários sem autorização e encerra a execução.
    header("Location: ../index.php");
    exit;
}

// Inclui a conexão com o banco de dados e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Prepara as variáveis que armazenam a mensagem e o resultado da operação.
$mensagem = "";
$status_sucesso = false;

// Verifica se o formulário foi enviado pelo botão de atualização.
if (isset($_POST["atualizar"])) {

    // Confere se o ID do cliente foi informado.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        $mensagem = "Erro: informe o ID do cliente.";

    // elseif verifica outra condição caso a anterior não seja atendida.
    } elseif (!isset($_POST["nome"]) || $_POST["nome"] == "") {

        $mensagem = "Erro: informe o nome do cliente.";

    } elseif (!isset($_POST["email"]) || $_POST["email"] == "") {

        $mensagem = "Erro: informe o email do cliente.";

    } else {

        // Guarda os novos dados recebidos pelo formulário.
        // $_POST permite acessar os valores enviados pelo método POST.
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];

        // Chama a função responsável por atualizar os dados do cliente.
        atualizarUsuario($conexao, $id, $nome, $email);

        // Prepara a mensagem e indica que a operação foi marcada como sucesso.
        $mensagem = "Cliente atualizado com sucesso!";
        $status_sucesso = true;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define a codificação, a adaptação para telas e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cliente - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<?php include(__DIR__ . "/../includes/header.php"); ?>
<!-- Inclui o cabeçalho compartilhado do site. -->

<main class="login-container">
    <div class="login-card">

        <h2>Atualizar Cliente</h2>

        <!-- Verifica se existe uma mensagem para exibir. -->
        <?php if (!empty($mensagem)): ?>

            <?php if ($status_sucesso): ?>

                <p class="subtitle">
                    <?php
                    // htmlspecialchars() evita que caracteres especiais do texto
                    // sejam interpretados como código HTML pelo navegador.
                    echo htmlspecialchars($mensagem);
                    ?>
                </p>

                <!-- Permite iniciar a atualização de outro cliente. -->
                <div class="login-footer">
                    <a href="atualizar_usuario.php" class="btn-cute">
                        Atualizar outro cliente
                    </a>
                </div>

            <?php else: ?>

                <p class="error-message">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>

            <?php endif; ?>

        <?php endif; ?>

        <!-- Exibe o formulário enquanto a operação não for marcada como sucesso. -->
        <?php if (!$status_sucesso): ?>

            <form method="POST">

                <label for="id">ID do cliente:</label>
                <input type="number" id="id" name="id" required>

                <label for="nome">Novo nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Novo email:</label>

                <!-- O tipo email verifica se o formato digitado parece um endereço de email. -->
                <input type="email" id="email" name="email" required>

                <!-- Envia os dados preenchidos para o PHP processar a atualização. -->
                <input type="submit"
                       name="atualizar"
                       value="Atualizar"
                       class="btn-cute">

            </form>

        <?php endif; ?>

    </div>
</main>

<?php include(__DIR__ . "/../includes/footer.php"); ?>
<!-- Inclui o rodapé compartilhado do site. -->

</body>
</html>