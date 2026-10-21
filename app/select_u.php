
<?php

// Inicia a sessão para permitir o acesso às informações
// do usuário que está conectado ao sistema.
session_start();


// Verifica se existe um usuário conectado.
// Caso não exista, redireciona para a página de login do cliente.
if (!isset($_SESSION["usuario"])) {

    // Redireciona para o login do cliente.
    header("Location: ../login/login_cliente.php");

    // Interrompe a execução do código após o redirecionamento.
    exit;
}


// Verifica se o usuário conectado possui o tipo administrador.
// A comparação !== verifica se o valor é diferente de "admin".
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "admin") {

    // Caso não seja administrador, redireciona para a página inicial.
    header("Location: ../index.php");

    // Interrompe a execução do código.
    exit;
}


// Inclui o arquivo responsável pela conexão com o banco de dados.
// A conexão será utilizada para consultar os usuários cadastrados.
include(__DIR__ . "/../database/connect.php");


// Inclui o arquivo que contém as funções utilizadas no sistema.
// Nele está definida a função listarUsuarios().
include(__DIR__ . "/../includes/functions.php");


// Chama a função listarUsuarios(), enviando a conexão com o banco.
// O resultado da consulta é armazenado na variável $todosUsuarios.
$todosUsuarios = listarUsuarios($conexao);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres utilizada na página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Usuários - Petite Patisserie</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal que organiza o conteúdo da página de usuários. -->
<main class="usuarios-container">


    <!-- Título principal da página. -->
    <h2 class="vitrine-title">
        Usuários cadastrados
    </h2>


    <!-- Apresenta uma descrição abaixo do título. -->
    <p class="usuarios-subtitulo">
        Confira os usuários registrados na Petite Patisserie.
    </p>


    <!-- Cartão que organiza visualmente a tabela de usuários. -->
    <div class="usuarios-card">


        <!-- Verifica se a lista de usuários está vazia.
             empty() retorna verdadeiro quando não existem usuários. -->
        <?php if (empty($todosUsuarios)): ?>


            <!-- Mensagem apresentada caso nenhum usuário esteja cadastrado. -->
            <p class="usuarios-vazio">
                Nenhum usuário cadastrado no momento.
            </p>


        <?php else: ?>


            <!-- Tabela responsável por apresentar os usuários cadastrados. -->
            <table class="users-table">


                <!-- Cabeçalho da tabela com os nomes das colunas. -->
                <thead>

                    <tr>

                        <!-- Coluna que apresenta o identificador do usuário. -->
                        <th>ID</th>

                        <!-- Coluna que apresenta o nome do usuário. -->
                        <th>Nome</th>

                        <!-- Coluna que apresenta o endereço de e-mail. -->
                        <th>E-mail</th>

                        <!-- Coluna que identifica o tipo de usuário. -->
                        <th>Tipo</th>

                    </tr>

                </thead>


                <!-- Corpo da tabela onde serão apresentados os registros. -->
                <tbody>


                    <!-- Percorre todos os usuários encontrados no banco.
                         Cada registro é armazenado na variável $usuario. -->
                    <?php foreach ($todosUsuarios as $usuario): ?>


                        <!-- Cria uma linha para cada usuário encontrado. -->
                        <tr>


                            <!-- Exibe o ID do usuário.
                                 O valor é convertido para texto antes da exibição. -->
                            <td>
                                <?php echo htmlspecialchars((string) $usuario["id"]); ?>
                            </td>


                            <!-- Exibe o nome cadastrado.
                                 htmlspecialchars() protege a página,
                                 impedindo que caracteres especiais sejam interpretados como HTML. -->
                            <td>
                                <?php echo htmlspecialchars($usuario["nome"]); ?>
                            </td>


                            <!-- Exibe o endereço de e-mail do usuário.
                                 htmlspecialchars() protege o conteúdo exibido. -->
                            <td>
                                <?php echo htmlspecialchars($usuario["email"]); ?>
                            </td>


                            <!-- Verifica o tipo de usuário para apresentar
                                 uma identificação visual diferente para cada categoria. -->
                            <td>


                                <!-- Verifica se o usuário possui o tipo administrador. -->
                                <?php if ($usuario["tipo"] === "admin"): ?>


                                    <!-- Exibe uma etiqueta rosa para identificar o administrador. -->
                                    <span class="tipo-usuario tipo-admin">
                                        Administrador
                                    </span>


                                <?php else: ?>


                                    <!-- Caso não seja administrador, apresenta a etiqueta de cliente. -->
                                    <span class="tipo-usuario tipo-cliente">
                                        Cliente
                                    </span>


                                <?php endif; ?>


                            </td>


                        </tr>


                    <!-- Finaliza a repetição dos usuários. -->
                    <?php endforeach; ?>


                </tbody>

            </table>


        <?php endif; ?>


    </div>

</main>


<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>
