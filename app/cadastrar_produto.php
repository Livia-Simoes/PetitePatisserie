<?php

// Inicia a sessão para acessar as informações do usuário que está logado.
session_start();

// Verifica se existe um usuário logado e se ele possui o tipo "admin".
// Caso não seja administrador, redireciona para a página inicial.
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit; // Encerra o código para impedir o acesso à página.
}

// Importa a conexão com o banco de dados e as funções utilizadas no sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Variáveis utilizadas para exibir mensagens na página.
$mensagem = "";
$status_sucesso = false;

// Verifica se o formulário foi enviado pelo botão "Cadastrar".
if (isset($_POST["cadastrar"])) {

    // Recebe os dados enviados pelo formulário através do método POST.
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];

    // Verifica se o nome ou o preço não foram preenchidos.
    if ($nome == "" || $preco == "") {

        $mensagem = "Preencha todos os campos.";

    // Verifica se uma imagem foi enviada sem apresentar erro no upload.
    } elseif (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {

        // Guarda o nome original da imagem e define onde ela será salva.
        $imagem = $_FILES["imagem"]["name"];
        $caminho = __DIR__ . "/../assets/imagens/" . $imagem;

        // move_uploaded_file() transfere a imagem enviada para a pasta do projeto.
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)) {

            // Chama a função que cadastra o produto no banco de dados.
            // Se a função retornar sucesso, exibe a mensagem correspondente.
            if (cadastrarProduto($conexao, $nome, $preco, $imagem)) {
                $mensagem = "Produto cadastrado com sucesso!";
                $status_sucesso = true;
            } else {
                $mensagem = "Erro ao cadastrar o produto.";
            }

        } else {
            // Aparece quando não foi possível salvar a imagem na pasta.
            $mensagem = "Erro ao enviar a imagem.";
        }

    } else {
        // Aparece quando nenhuma imagem válida foi enviada pelo formulário.
        $mensagem = "Selecione uma imagem.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado entre as páginas do sistema. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="login-container">

    <div class="login-card">

        <h2>Cadastrar Produto</h2>

        <!-- Exibe a mensagem somente quando ela não estiver vazia. -->
        <?php if (!empty($mensagem)): ?>

            <p class="subtitle">
                <?php
                // htmlspecialchars() evita que o texto da mensagem seja interpretado como HTML.
                echo htmlspecialchars($mensagem);
                ?>
            </p>

        <?php endif; ?>

        <!-- Esconde o formulário quando o cadastro retorna sucesso. -->
        <?php if (!$status_sucesso): ?>

            <!--
                POST envia os dados sem colocá-los na URL.
                multipart/form-data é necessário para enviar arquivos, como imagens.
            -->
            <form method="POST" enctype="multipart/form-data">

                <label for="nome">Nome do produto:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="preco">Preço:</label>

                <!--
                    type="number" aceita valores numéricos.
                    step="0.01" permite valores com casas decimais, como 12.50.
                -->
                <input type="number" step="0.01" id="preco" name="preco" required>

                <label for="imagem">Imagem do produto:</label>

                <!--
                    type="file" permite selecionar um arquivo.
                    accept="image/*" orienta o navegador a mostrar arquivos de imagem.
                    required exige que o campo seja preenchido no navegador.
                -->
                <input type="file" id="imagem" name="imagem" accept="image/*" required>

                <input type="submit"
                       name="cadastrar"
                       value="Cadastrar"
                       class="btn-cute">

            </form>

        <?php endif; ?>

    </div>

</main>

<!-- Inclui o rodapé compartilhado entre as páginas do sistema. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>