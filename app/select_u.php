
<?php

// Inicia a sessão para permitir o acesso aos dados do usuário conectado.
session_start();

// Verifica se existe um usuário conectado ao sistema.
// Caso não exista, redireciona para a página de login do cliente.
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login/login_cliente.php");
    exit;
}

// Verifica se o usuário conectado possui o tipo administrador.
// Caso não seja administrador, redireciona para a página inicial.
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

// Inclui o arquivo responsável pela conexão com o banco de dados.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema.
include(__DIR__ . "/../includes/functions.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres da página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Usuários - Petite Patisserie</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Container principal que organiza o conteúdo da página. -->
<main class="vitrine-container">

    <!-- Título principal da página de usuários. -->
    <h2 class="vitrine-title">Usuários cadastrados</h2>

    <?php

    // Chama a função listarUsuarios(), definida em functions.php.
    // Ela recebe a conexão com o banco de dados
    // e retorna os usuários cadastrados.
    $todosUsuarios = listarUsuarios($conexao);

    ?>

    <!-- Verifica se existem usuários cadastrados no banco. -->
    <?php if (empty($todosUsuarios)): ?>

        <!-- Mensagem exibida quando não existem usuários cadastrados. -->
        <p class="no-products">
            Nenhum usuário cadastrado no momento.
        </p>

    <?php else: ?>

        <!-- Tabela responsável por apresentar os usuários cadastrados. -->
        <table class="users-table">

            <!-- Cabeçalho da tabela com os nomes das colunas. -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Tipo</th>
                </tr>
            </thead>

            <!-- Corpo da tabela com os dados dos usuários. -->
            <tbody>

                <!-- Percorre todos os usuários retornados pelo banco de dados.
                     Cada usuário é armazenado na variável $usuario. -->
                <?php foreach ($todosUsuarios as $usuario): ?>

                    <tr>

                        <!-- Exibe o ID do usuário. -->
                        <td>
                            <?php echo $usuario["id"]; ?>
                        </td>

                        <!-- Exibe o nome do usuário.
                             htmlspecialchars() protege os dados exibidos no HTML. -->
                        <td>
                            <?php echo htmlspecialchars($usuario["nome"]); ?>
                        </td>

                        <!-- Exibe o e-mail do usuário. -->
                        <td>
                            <?php echo htmlspecialchars($usuario["email"]); ?>
                        </td>

                        <!-- Exibe o tipo de usuário:
                             cliente ou administrador. -->
                        <td>
                            <?php echo htmlspecialchars($usuario["tipo"] ?? "Não definido"); ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</main>


<!-- Inclui o rodapé padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
