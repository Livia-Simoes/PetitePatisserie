<?php

// Inicia a sessão e verifica se o usuário tem permissão de administrador.
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] !== "admin") {
    // Redireciona usuários sem autorização e interrompe a execução.
    header("Location: ../index.php");
    exit;
}

// Inclui a conexão com o banco de dados e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Cria uma variável para armazenar a mensagem do resultado da operação.
$mensagem = "";

// Verifica se o formulário foi enviado pelo botão de atualização.
if (isset($_POST["atualizar"])) {

    // $_POST acessa os dados enviados pelo formulário.
    // Guarda o ID e os novos dados informados para o produto.
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];

    // Chama a função que tenta atualizar o produto no banco de dados.
    if (atualizarProduto($conexao, $id, $nome, $preco)) {

        $mensagem = "Produto atualizado no banco de dados com sucesso!";

    } else {

        $mensagem = "Erro ao atualizar produto.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define a codificação, a adaptação para telas e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<?php include(__DIR__ . "/../includes/header.php"); ?>
<!-- Inclui o cabeçalho compartilhado do site. -->

<main class="login-container">
    <div class="login-card">

        <h2>Atualizar Produto</h2>

        <!-- Exibe a mensagem caso a operação tenha gerado algum resultado. -->
        <?php if (!empty($mensagem)): ?>
            <p class="subtitle">
                <?php
                // htmlspecialchars() evita que caracteres especiais da mensagem
                // sejam interpretados como código HTML pelo navegador.
                echo htmlspecialchars($mensagem);
                ?>
            </p>
        <?php endif; ?>

        <!-- Formulário utilizado para informar os novos dados do produto. -->
        <form method="POST">

            <div class="form-group">
                <label for="id">ID do produto:</label>

                <!-- Recebe o identificador do produto que será atualizado. -->
                <input type="number"
                       id="id"
                       name="id"
                       class="form-control"
                       placeholder="Ex: 1"
                       required>
            </div>

            <div class="form-group">
                <label for="nome">Novo nome:</label>

                <!-- Recebe o nome que substituirá o nome atual do produto. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Ex: Macaron de Pistache"
                       required>
            </div>

            <div class="form-group">
                <label for="preco">Novo preço:</label>

                <!-- Recebe o preço atualizado.
                     O step="0.01" permite valores com duas casas decimais. -->
                <input type="number"
                       id="preco"
                       name="preco"
                       step="0.01"
                       class="form-control"
                       placeholder="Ex: 12.50"
                       required>
            </div>

            <!-- Envia os dados preenchidos para o PHP processar a atualização. -->
            <input type="submit"
                   name="atualizar"
                   value="Atualizar"
                   class="btn-cute">

        </form>

    </div>
</main>

<?php include(__DIR__ . "/../includes/footer.php"); ?>
<!-- Inclui o rodapé compartilhado do site. -->

</body>
</html>