
<?php

// Inicia a sessão para acessar os dados do usuário conectado.
session_start();

// Verifica se existe um usuário conectado no sistema.
if (!isset($_SESSION["usuario"])) {

    // Caso não esteja conectado, redireciona para a página de login.
    header("Location: ../login/login_cliente.php");

    // Interrompe a execução do código após o redirecionamento.
    exit;
}

// Inclui o arquivo responsável pela conexão com o banco de dados.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema.
include(__DIR__ . "/../includes/functions.php");

// Armazena o ID do usuário que está conectado.
$usuario_id = $_SESSION["usuario_id"];

// Cria uma variável para armazenar as mensagens que serão exibidas.
$mensagem = "";

// Define inicialmente que a operação ainda não foi realizada com sucesso.
$status_sucesso = false;


// Verifica se foi recebido um ID de produto pela URL.
if (isset($_GET["id"])) {

    // Obtém o ID do produto enviado pela URL.
    $produto_id = $_GET["id"];

    // Define a quantidade inicial do produto como 1.
    $quantidade = 1;

    // Chama a função adicionarCarrinho para salvar o produto no carrinho.
    adicionarCarrinho(
        $conexao,     // Envia a conexão com o banco de dados.
        $usuario_id,  // Envia o ID do usuário conectado.
        $produto_id,  // Envia o ID do produto selecionado.
        $quantidade   // Envia a quantidade do produto.
    );

    // Armazena a mensagem que será exibida caso a operação seja realizada.
    $mensagem = "Produto adicionado ao seu carrinho com sucesso! ♥";

    // Altera o status para indicar que o produto foi adicionado.
    $status_sucesso = true;

} else {

    // Caso não exista um ID na URL, prepara uma mensagem de erro.
    $mensagem = "Erro: nenhum produto foi selecionado.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres para permitir acentos. -->
    <meta charset="UTF-8">

    <!-- Permite adaptar a página a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Adicionar ao Carrinho - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo CSS do projeto. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<!-- Área principal do conteúdo da página. -->
<main class="login-container">

    <!-- Card utilizado para organizar as mensagens e os links. -->
    <div class="login-card">

        <!-- Título apresentado ao usuário. -->
        <h2>Carrinho de Compras</h2>

        <!-- Verifica se a operação de adicionar o produto foi realizada com sucesso. -->
        <?php if ($status_sucesso): ?>

            <!-- Caso tenha dado certo, exibe a mensagem de sucesso. -->
            <p class="subtitle">
                <?php

                // Exibe a mensagem armazenada na variável.
                // htmlspecialchars protege a página ao tratar caracteres especiais como texto.
                echo htmlspecialchars($mensagem);

                ?>
            </p>

        <?php else: ?>

            <!-- Caso a operação não tenha dado certo, exibe a mensagem de erro. -->
            <p class="error-message">

                <?php
                // Exibe a mensagem de erro armazenada na variável.
                echo htmlspecialchars($mensagem);
                ?>

            </p>

        <?php endif; ?>
        <!-- Encerra a condição que escolhe entre a mensagem de sucesso e a de erro. -->


        <!-- Área que contém os links de navegação da página. -->
        <div class="login-footer">

            <!-- Link para voltar à vitrine e continuar comprando. -->
            <a href="select.php" class="btn-cute">
                Continuar Comprando
            </a>

            <!-- Adiciona um espaço entre os links. -->
            <br><br>

            <!-- Link para acessar a página do carrinho. -->
            <a href="carrinho.php" class="btn-cute btn-secondary">
                Ver Carrinho
            </a>

        </div>

    </div>

</main>

<!-- Inclui o rodapé padrão do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
