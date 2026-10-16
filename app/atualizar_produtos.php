<?php

// Inicia a sessão para permitir o acesso às informações do usuário que está conectado.
session_start();

// Verifica se existe um usuário conectado e se ele possui permissão de administrador.
// O operador || significa "ou", ou seja, se uma das condições for verdadeira,
// o usuário não poderá continuar acessando esta página.
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] !== "admin") {

    // Envia o usuário para a página inicial caso não tenha autorização.
    header("Location: ../index.php");

    // Interrompe a execução do código para impedir o acesso à página.
    exit;
}


// Inclui o arquivo responsável por estabelecer a conexão com o banco de dados.
// A variável $conexao será utilizada para realizar operações no banco.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas pelo sistema,
// entre elas a função atualizarProduto().
include(__DIR__ . "/../includes/functions.php");


// Cria uma variável vazia para armazenar a mensagem que será exibida
// ao administrador depois que ele tentar atualizar um produto.
$mensagem = "";


// Verifica se o formulário foi enviado por meio do botão chamado "atualizar".
// O isset() verifica se essa informação foi enviada pelo método POST.
if (isset($_POST["atualizar"])) {

    // Recebe os dados preenchidos pelo administrador no formulário.
    // O $_POST permite acessar as informações enviadas pelos campos
    // que possuem os respectivos atributos name.

    // Recebe o ID do produto que será modificado.
    $id = $_POST["id"];

    // Recebe o novo nome que será colocado no lugar do nome atual.
    $nome = $_POST["nome"];

    // Recebe o novo preço que substituirá o preço atual do produto.
    $preco = $_POST["preco"];


    // Chama a função atualizarProduto(), que está no arquivo functions.php.
    // Ela recebe a conexão com o banco de dados e os novos dados do produto.
    // O ID indica qual produto deverá ser atualizado.
    //
    // O if verifica o resultado retornado pela função:
    // se a atualização funcionar, executa o primeiro bloco;
    // caso contrário, executa o else.
    if (atualizarProduto($conexao, $id, $nome, $preco)) {

        // Armazena uma mensagem informando que a atualização foi realizada.
        $mensagem = "Produto atualizado no banco de dados com sucesso!";

    } else {

        // Armazena uma mensagem caso ocorra algum erro na atualização.
        $mensagem = "Erro ao atualizar produto.";
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define o conjunto de caracteres utilizado na página,
         permitindo a exibição correta de acentos e caracteres especiais. -->
    <meta charset="UTF-8">

    <!-- Faz com que a página se adapte ao tamanho da tela,
         melhorando a visualização em computadores, celulares e tablets. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Atualizar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo CSS externo,
         responsável pela aparência e formatação dos elementos. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho padrão do site.
     O __DIR__ representa o diretório atual deste arquivo,
     facilitando a localização do arquivo header.php. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal do conteúdo da página.
     As classes são utilizadas para aplicar a formatação definida no CSS. -->
<main class="login-container">

    <!-- Caixa que organiza visualmente o conteúdo da página. -->
    <div class="login-card">

        <!-- Título que identifica a função desta página. -->
        <h2>Atualizar Produto</h2>


        <!-- Verifica se a variável mensagem possui algum conteúdo.
             Isso evita exibir um espaço de mensagem antes de uma tentativa
             de atualização do produto. -->
        <?php if (!empty($mensagem)): ?>

            <!-- Exibe a mensagem armazenada no PHP.
                 A classe subtitle aplica a formatação definida no CSS. -->
            <p class="subtitle">

                <?php
                // O echo exibe a mensagem na página.
                // O htmlspecialchars() protege a saída, impedindo que
                // caracteres especiais sejam interpretados como código HTML.
                echo htmlspecialchars($mensagem);
                ?>

            </p>

        <!-- Encerra a condição responsável por exibir a mensagem. -->
        <?php endif; ?>


        <!-- Cria o formulário utilizado pelo administrador para atualizar
             as informações de um produto cadastrado no banco de dados.

             O método POST envia os dados sem colocá-los na URL. -->
        <form method="POST">


            <!-- Agrupa o campo de identificação do produto. -->
            <div class="form-group">

                <!-- Texto que informa ao administrador qual dado deve preencher. -->
                <label for="id">ID do produto:</label>

                <!-- Campo utilizado para informar o ID do produto que será atualizado.
                     O type="number" permite inserir apenas valores numéricos.
                     O name="id" permite que o PHP receba esse valor por $_POST.
                     O required torna o preenchimento obrigatório. -->
                <input type="number"
                       id="id"
                       name="id"
                       class="form-control"
                       placeholder="Ex: 1"
                       required>

            </div>


            <!-- Agrupa o campo destinado ao novo nome do produto. -->
            <div class="form-group">

                <!-- Identifica o campo onde deve ser informado o novo nome. -->
                <label for="nome">Novo nome:</label>

                <!-- Campo de texto utilizado para digitar o novo nome do produto.
                     O name="nome" permite acessar o valor pelo $_POST["nome"].
                     O required impede o envio do formulário sem preenchimento. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Ex: Macaron de Pistache"
                       required>

            </div>


            <!-- Agrupa o campo destinado ao novo preço do produto. -->
            <div class="form-group">

                <!-- Identifica o campo onde deve ser informado o novo preço. -->
                <label for="preco">Novo preço:</label>

                <!-- Campo numérico utilizado para informar o preço atualizado.
                     O name="preco" permite que o PHP receba o valor pelo POST.
                     O step="0.01" permite informar valores com até duas casas decimais,
                     como 12.50.
                     O required torna o preenchimento obrigatório. -->
                <input type="number"
                       id="preco"
                       name="preco"
                       step="0.01"
                       class="form-control"
                       placeholder="Ex: 12.50"
                       required>

            </div>


            <!-- Botão responsável por enviar os dados preenchidos no formulário.
                 O type="submit" realiza o envio.
                 O name="atualizar" permite que o PHP identifique o envio
                 por meio da condição isset($_POST["atualizar"]).
                 O value define o texto exibido no botão. -->
            <input type="submit"
                   name="atualizar"
                   value="Atualizar"
                   class="btn-cute">


        <!-- Encerra o formulário. -->
        </form>

    </div>
</main>


<!-- Inclui o rodapé padrão do site, mantendo a estrutura
     visual das outras páginas da Petite Patisserie. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>