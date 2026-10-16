
<?php

// Inicia a sessão para acessar as informações do usuário conectado.
session_start();

// Verifica se o usuário está conectado e se possui permissão de administrador.
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {

    // Caso não esteja conectado ou não seja administrador,
    // redireciona para a página inicial.
    header("Location: ../index.php");

    // Interrompe a execução do código.
    exit;
}

// Inclui o arquivo responsável pela conexão com o banco de dados.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema.
include(__DIR__ . "/../includes/functions.php");

// Cria uma variável para armazenar as mensagens exibidas na página.
$mensagem = "";

// Define inicialmente que a exclusão ainda não foi realizada com sucesso.
$status_sucesso = false;


// Verifica se o formulário foi enviado pelo botão de exclusão.
if (isset($_POST["apagar"])) {

    // Verifica se o campo ID foi enviado e se não está vazio.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        // Armazena uma mensagem caso nenhum ID tenha sido informado.
        $mensagem = "Erro: informe o ID do produto.";

    } else {

        // Guarda na variável o ID do produto informado no formulário.
        $id = $_POST["id"];

        // Chama a função apagarProduto para tentar excluir o produto do banco.
        // Verifica se a função conseguiu realizar a exclusão.
        if (apagarProduto($conexao, $id)) {

            // Armazena a mensagem de confirmação da exclusão.
            $mensagem = "Produto removido com sucesso!";

            // Altera o status para indicar que a operação deu certo.
            $status_sucesso = true;

        } else {

            // Caso o produto não seja encontrado ou não possa ser excluído,
            // armazena uma mensagem de erro.
            $mensagem = "Produto não encontrado ou não pode ser removido.";
        }
    }
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
    <title>Deletar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo CSS do projeto. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal do conteúdo da página. -->
<main class="login-container">

    <!-- Card utilizado para organizar o formulário e as mensagens. -->
    <div class="login-card">

        <!-- Título apresentado na página. -->
        <h2>Deletar Produto</h2>


        <!-- Verifica se existe alguma mensagem para ser exibida.
             empty() verifica se a variável está vazia. -->
        <?php if (!empty($mensagem)): ?>


            <!-- Verifica se a exclusão foi realizada com sucesso. -->
            <?php if ($status_sucesso): ?>

                <!-- Exibe a mensagem de sucesso. -->
                <p class="subtitle">

                    <?php

                    // Exibe a mensagem armazenada na variável.
                    // htmlspecialchars() trata caracteres especiais como texto,
                    // evitando que sejam interpretados como código HTML.
                    echo htmlspecialchars($mensagem);

                    ?>

                </p>


                <!-- Disponibiliza um link para excluir outro produto. -->
                <div class="login-footer">

                    <!-- Redireciona para a própria página de exclusão. -->
                    <a href="apagar_produto.php" class="btn-cute">
                        Deletar outro produto
                    </a>

                </div>


            <?php else: ?>

                <!-- Caso ocorra algum erro, exibe a mensagem correspondente. -->
                <p class="error-message">

                    <?php
                    // Exibe a mensagem de erro.
                    echo htmlspecialchars($mensagem);
                    ?>

                </p>

            <?php endif; ?>

        <?php endif; ?>


        <!-- Verifica se a exclusão ainda não foi realizada com sucesso.
             Se não foi, mantém o formulário disponível na página. -->
        <?php if (!$status_sucesso): ?>


            <!-- Formulário utilizado para informar o ID do produto.
                 O método POST envia os dados sem colocá-los na URL. -->
            <form method="POST">


                <!-- Identifica o campo onde o administrador deve informar o ID. -->
                <label for="id">ID do produto:</label>


                <!-- Campo numérico para informar o ID do produto que será excluído. -->
                <input type="number"

                       id="id"          <!-- Identifica o campo no HTML. -->

                       name="id"        <!-- Nome utilizado pelo PHP para receber o valor. -->

                       placeholder="Ex: 5"  <!-- Exemplo exibido dentro do campo. -->

                       required>       <!-- Obriga o preenchimento do campo. -->


                <!-- Botão que envia o formulário para o próprio arquivo PHP. -->
                <input type="submit"

                       name="apagar"       <!-- Permite identificar o envio pelo PHP. -->

                       value="Deletar"     <!-- Texto exibido no botão. -->

                       class="btn-cute btn-remove"> <!-- Classes responsáveis pela aparência. -->


            </form>

        <?php endif; ?>

    </div>

</main>


<!-- Inclui o rodapé padrão do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
