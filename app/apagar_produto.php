<?php

// Inicia a sessão e verifica se o usuário tem permissão de administrador.
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {
    // isset() verifica se uma variável existe e não é NULL.
    // Se o usuário não estiver conectado ou não for admin, redireciona.
    header("Location: ../index.php");
    exit; // Encerra a execução do código.
}

// Inclui a conexão com o banco e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Prepara as variáveis que armazenam a mensagem e o resultado.
$mensagem = "";
$status_sucesso = false;

// Verifica se o formulário foi enviado pelo botão de exclusão.
if (isset($_POST["apagar"])) {

    // $_POST recebe os dados enviados por formulários com method="POST".
    // Verifica se o ID do produto foi informado.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        $mensagem = "Erro: informe o ID do produto.";

    } else {

        // Guarda o ID e chama a função responsável pela exclusão.
        $id = $_POST["id"];

        if (apagarProduto($conexao, $id)) {

            $mensagem = "Produto removido com sucesso!";
            $status_sucesso = true;

        } else {

            $mensagem = "Produto não encontrado ou não pode ser removido.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define as configurações básicas e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<?php include(__DIR__ . "/../includes/header.php"); ?>
<!-- Inclui o cabeçalho compartilhado do site. -->

<main class="login-container">
    <div class="login-card">

        <h2>Deletar Produto</h2>

        <!-- Exibe as mensagens somente quando houver algo para mostrar. -->
        <?php if (!empty($mensagem)): ?>

            <?php if ($status_sucesso): ?>
                <p class="subtitle">
                    <?php
                    // htmlspecialchars() evita que caracteres especiais do texto
                    // sejam interpretados como código HTML pelo navegador.
                    echo htmlspecialchars($mensagem);
                    ?>
                </p>

                <!-- Oferece a opção de excluir outro produto. -->
                <div class="login-footer">
                    <a href="apagar_produto.php" class="btn-cute">
                        Deletar outro produto
                    </a>
                </div>

            <?php else: ?>
                <p class="error-message">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

        <?php endif; ?>

        <!-- Exibe o formulário enquanto a exclusão não for marcada como sucesso. -->
        <?php if (!$status_sucesso): ?>

            <form method="POST">

                <label for="id">ID do produto:</label>

                <!-- Campo numérico para informar qual produto será excluído.
                     required exige que o campo seja preenchido antes do envio. -->
                <input type="number"
                       id="id"
                       name="id"
                       placeholder="Ex: 5"
                       required>

                <!-- Envia o formulário para o próprio arquivo PHP. -->
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