<?php

// Inicia a sessão para acessar as informações do usuário que está conectado.
session_start();


// Verifica se existe um usuário conectado e se ele possui permissão de administrador.
// O operador || significa "ou". Portanto, se uma das condições for verdadeira,
// o acesso à página será bloqueado.
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {

    // Redireciona o usuário para a página inicial caso não seja administrador.
    header("Location: ../index.php");

    // Interrompe a execução para impedir que o restante da página seja carregado.
    exit;
}


// Inclui o arquivo responsável pela conexão com o banco de dados.
// A conexão será utilizada para realizar a atualização das informações.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas pelo sistema,
// incluindo a função atualizarUsuario().
include(__DIR__ . "/../includes/functions.php");


// Cria uma variável vazia para armazenar mensagens de sucesso ou erro.
$mensagem = "";

// Cria uma variável para identificar se a atualização foi realizada com sucesso.
// Inicialmente, recebe false, indicando que nenhuma atualização foi concluída.
$status_sucesso = false;


// Verifica se o formulário foi enviado pelo botão chamado "atualizar".
// O isset() verifica se o botão foi enviado pelo método POST.
if (isset($_POST["atualizar"])) {


    // Verifica se o campo ID foi enviado e se não está vazio.
    // O ID identifica qual cliente terá seus dados modificados.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        // Caso o ID não tenha sido informado, armazena uma mensagem de erro.
        $mensagem = "Erro: informe o ID do cliente.";


    // Verifica se o campo nome foi enviado e se não está vazio.
    // O elseif permite testar uma nova condição caso a anterior não seja verdadeira.
    } elseif (!isset($_POST["nome"]) || $_POST["nome"] == "") {

        // Caso o nome não tenha sido informado, armazena uma mensagem de erro.
        $mensagem = "Erro: informe o nome do cliente.";


    // Verifica se o campo email foi enviado e se não está vazio.
    } elseif (!isset($_POST["email"]) || $_POST["email"] == "") {

        // Caso o email não tenha sido informado, armazena uma mensagem de erro.
        $mensagem = "Erro: informe o email do cliente.";


    } else {

        // Se todos os campos estiverem preenchidos, o código entra neste bloco.

        // Recebe o ID do cliente que será atualizado.
        // O $_POST["id"] acessa o valor enviado pelo campo com name="id".
        $id = $_POST["id"];

        // Recebe o novo nome informado pelo administrador.
        $nome = $_POST["nome"];

        // Recebe o novo email informado pelo administrador.
        $email = $_POST["email"];


        // Chama a função atualizarUsuario(), localizada no arquivo functions.php.
        // Ela recebe a conexão com o banco de dados, o ID do cliente,
        // o novo nome e o novo email para realizar a atualização.
        atualizarUsuario($conexao, $id, $nome, $email);


        // Armazena a mensagem que será exibida após a atualização.
        $mensagem = "Cliente atualizado com sucesso!";

        // Altera o status para true, indicando que a operação foi marcada como sucesso.
        // Essa variável também será utilizada para controlar a exibição do formulário.
        $status_sucesso = true;
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres para permitir a exibição correta
         de acentos e caracteres especiais. -->
    <meta charset="UTF-8">

    <!-- Configura a página para se adaptar a diferentes tamanhos de tela,
         como computadores, celulares e tablets. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Atualizar Cliente - Petite Patisserie</title>


    <!-- Conecta a página ao arquivo CSS externo,
         responsável pela aparência e organização dos elementos. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho padrão do site.
     O __DIR__ representa o diretório atual do arquivo,
     permitindo localizar o header.php em relação a ele. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Define a área principal da página.
     A classe login-container aplica a formatação definida no CSS. -->
<main class="login-container">

    <!-- Cria um cartão para organizar o conteúdo da página. -->
    <div class="login-card">

        <!-- Título que identifica a funcionalidade da página. -->
        <h2>Atualizar Cliente</h2>


        <!-- Verifica se a variável mensagem possui algum conteúdo.
             Se estiver vazia, nenhuma mensagem será exibida. -->
        <?php if (!empty($mensagem)): ?>


            <!-- Verifica se a operação foi marcada como sucesso.
                 Se status_sucesso for true, exibe a mensagem de sucesso. -->
            <?php if ($status_sucesso): ?>

                <!-- Parágrafo utilizado para apresentar a mensagem de sucesso. -->
                <p class="subtitle">

                    <?php
                    // O echo exibe o conteúdo da variável mensagem.
                    // O htmlspecialchars() evita que caracteres especiais
                    // sejam interpretados como código HTML pelo navegador.
                    echo htmlspecialchars($mensagem);
                    ?>

                </p>


                <!-- Área que organiza o link abaixo da mensagem. -->
                <div class="login-footer">

                    <!-- Permite que o administrador volte à página de atualização
                         para cadastrar os dados de outro cliente.
                         O href indica o arquivo para o qual o link direciona. -->
                    <a href="atualizar_usuario.php" class="btn-cute">
                        Atualizar outro cliente
                    </a>

                </div>


            <!-- Caso o status não seja de sucesso, exibe a mensagem de erro. -->
            <?php else: ?>

                <!-- Parágrafo destinado à apresentação de mensagens de erro. -->
                <p class="error-message">

                    <?php
                    // Exibe a mensagem de erro de forma segura utilizando
                    // htmlspecialchars() para evitar interpretação de HTML.
                    echo htmlspecialchars($mensagem);
                    ?>

                </p>

            <!-- Encerra a condição que verifica o resultado da operação. -->
            <?php endif; ?>


        <!-- Encerra a condição que verifica se existe uma mensagem. -->
        <?php endif; ?>


        <!-- Verifica se a atualização ainda não foi marcada como sucesso.
             O símbolo ! significa negação, ou seja, !$status_sucesso
             significa que o status de sucesso ainda é false.

             Enquanto não houver sucesso, o formulário continuará aparecendo. -->
        <?php if (!$status_sucesso): ?>


            <!-- Cria o formulário utilizado pelo administrador para informar
                 os dados do cliente que deseja atualizar.

                 O método POST envia os dados para serem processados pelo PHP. -->
            <form method="POST">


                <!-- Campo utilizado para informar o ID do cliente.
                     O type="number" permite inserir valores numéricos.
                     O name="id" permite receber o valor pelo $_POST["id"].
                     O required torna o preenchimento obrigatório. -->
                <label for="id">ID do cliente:</label>
                <input type="number" id="id" name="id" required>


                <!-- Campo utilizado para informar o novo nome do cliente.
                     O name="nome" permite que o PHP receba o valor digitado.
                     O required impede o envio sem preencher esse campo. -->
                <label for="nome">Novo nome:</label>
                <input type="text" id="nome" name="nome" required>


                <!-- Campo utilizado para informar o novo email do cliente.
                     O name="email" permite acessar o valor pelo PHP.
                     O required torna o preenchimento obrigatório. -->
                <label for="email">Novo email:</label>

                <!-- O type="email" faz uma verificação básica do formato digitado,
                     esperando um endereço de email válido.
                     Essa verificação é feita pelo próprio navegador. -->
                <input type="email" id="email" name="email" required>


                <!-- Botão responsável por enviar os dados do formulário.
                     O type="submit" realiza o envio.
                     O name="atualizar" permite que o PHP identifique
                     o envio por meio de isset($_POST["atualizar"]).
                     O value define o texto que aparece no botão. -->
                <input type="submit"
                       name="atualizar"
                       value="Atualizar"
                       class="btn-cute">


            <!-- Encerra o formulário. -->
            </form>


        <!-- Encerra a condição que controla a exibição do formulário. -->
        <?php endif; ?>


    </div>
</main>


<!-- Inclui o rodapé padrão do site para manter a estrutura
     visual das páginas da Petite Patisserie. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>