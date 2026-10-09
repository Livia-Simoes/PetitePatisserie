<?php

// Inicia a sessão e verifica se o usuário está conectado.
session_start();

if (!isset($_SESSION["usuario"])) {
    // Redireciona para o login caso não exista um usuário conectado.
    header("Location: ../login/login_cliente.php");
    exit; // Interrompe a execução do código.
}

// Inclui a conexão com o banco e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Guarda o ID do usuário e prepara as variáveis das mensagens.
$usuario_id = $_SESSION["usuario_id"];
$mensagem = "";
$status_sucesso = false;

// Verifica se foi informado um ID de produto na URL.
if (isset($_GET["id"])) {

    // $_GET permite acessar informações enviadas pela URL.
    // Define o produto selecionado e a quantidade inicial.
    $produto_id = $_GET["id"];
    $quantidade = 1;

    // Chama a função que adiciona o produto ao carrinho no banco de dados.
    adicionarCarrinho(
        $conexao,     // Conexão com o banco de dados.
        $usuario_id,  // ID do usuário conectado.
        $produto_id,  // ID do produto selecionado.
        $quantidade   // Quantidade que será adicionada.
    );

    // Prepara a mensagem que será exibida na página.
    $mensagem = "Produto adicionado ao seu carrinho com sucesso! ♥";
    $status_sucesso = true;

} else {

    // Exibe uma mensagem caso nenhum ID tenha sido recebido pela URL.
    $mensagem = "Erro: nenhum produto foi selecionado.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define as configurações básicas e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar ao Carrinho - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<?php include(__DIR__ . "/../includes/header.php"); ?>
<!-- Inclui o cabeçalho compartilhado do site. -->

<main class="login-container">
    <div class="login-card">

        <h2>Carrinho de Compras</h2>

        <!-- Escolhe qual mensagem será exibida conforme o status da operação. -->
        <?php if ($status_sucesso): ?>
            <p class="subtitle">
                <?php
                // htmlspecialchars() evita que caracteres especiais do texto
                // sejam interpretados como código HTML pelo navegador
                echo htmlspecialchars($mensagem);
                ?>
            </p>
        <?php else: ?>
            <p class="error-message">
                <?php echo htmlspecialchars($mensagem); ?>
            </p>
        <?php endif; ?>

        <!-- Oferece opções para continuar comprando ou visualizar o carrinho. -->
        <div class="login-footer">
            <a href="select.php" class="btn-cute">
                Continuar Comprando
            </a>

            <br><br>

            <a href="carrinho.php" class="btn-cute btn-secondary">
                Ver Carrinho
            </a>
        </div>

    </div>
</main>

<?php include(__DIR__ . "/../includes/footer.php"); ?>
<!-- Inclui o rodapé compartilhado do site. -->

</body>
</html>