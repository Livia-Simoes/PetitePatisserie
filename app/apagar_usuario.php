<?php

// Inicia a sessão e verifica se o usuário tem permissão de administrador.
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {
    // Redireciona usuários sem autorização e interrompe a execução.
    header("Location: ../index.php");
    exit;
}

// Inclui a conexão com o banco de dados e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Prepara as variáveis que armazenam a mensagem e o resultado da operação.
$mensagem = "";
$status_sucesso = false;

// Verifica se o formulário foi enviado pelo botão de exclusão.
if (isset($_POST["apagar"])) {

    // $_POST acessa os dados enviados pelo formulário.
    // Verifica se o ID do cliente foi informado.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        $mensagem = "Erro: informe o ID do cliente.";

    } else {

        // Guarda o ID informado e chama a função que tenta excluir o cliente.
        $id = $_POST["id"];

        if (apagarUsuario($conexao, $id)) {

            // Informa que a exclusão foi concluída e atualiza o status.
            $mensagem = "Cliente removido com sucesso!";
            $status_sucesso = true;

        } else {

            // Informa que o cliente não foi encontrado ou não pôde ser removido.
            $mensagem = "Cliente não encontrado ou não pode ser removido.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define a codificação, a adaptação para telas e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<?php include(__DIR__ . "/../includes/header.php"); ?>
<!-- Inclui o cabeçalho compartilhado do site. -->

<main class="login-container">
    <div class="login-card">

        <h2>Deletar Cliente</h2>

        <!-- Exibe as mensagens somente quando houver conteúdo para mostrar. -->
        <?php if (!empty($mensagem)): ?>

            <?php if ($status_sucesso): ?>
                <p class="subtitle">
                    <?php
                    // htmlspecialchars() impede que caracteres especiais da mensagem
                    // sejam interpretados como código HTML pelo navegador.
                    echo htmlspecialchars($mensagem);
                    ?>
                </p>

                <!-- Permite iniciar uma nova exclusão após o sucesso. -->
                <div class="login-footer">
                    <a href="apagar_usuario.php" class="btn-cute">
                        Deletar outro cliente
                    </a>
                </div>

            <?php else: ?>
                <p class="error-message">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

        <?php endif; ?>

        <!-- Mostra o formulário enquanto a operação não tiver sido marcada como sucesso. -->
        <?php if (!$status_sucesso): ?>

            <form method="POST">

                <label for="id">ID do cliente:</label>

                <!-- Recebe o ID numérico do cliente que será excluído.
                     O required exige o preenchimento antes do envio. -->
                <input type="number"
                       id="id"
                       name="id"
                       placeholder="Ex: 5"
                       required>

                <!-- Envia o ID para o PHP processar a solicitação de exclusão. -->
                <input type="submit"
                       name="apagar"
                       value="Deletar"
                       class="btn-cute btn-remove">

            </form>

        <?php endif; ?>

    </div>
</main>

<?php include(__DIR__ . "/../includes/footer.php"); ?>
<!-- Inclui o rodapé compartilhado do site. -->

</body>
</html>