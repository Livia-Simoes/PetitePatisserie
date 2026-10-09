
<?php

// Inicia a sessão para armazenar os dados do usuário autenticado
session_start();

// Inclui o arquivo responsável pela conexão com o banco de dados
include(__DIR__ . "/../database/connect.php");

// Variável que armazenará uma possível mensagem de erro
$mensagem_erro = "";

// Verifica se o nome foi enviado e se não está vazio
if (!isset($_POST["nome"]) || trim($_POST["nome"]) === "") {

    $mensagem_erro = "Erro: informe o nome.";

// Verifica se o email foi enviado e se não está vazio
} elseif (!isset($_POST["email"]) || trim($_POST["email"]) === "") {

    $mensagem_erro = "Erro: informe o email.";

// Verifica se a senha foi enviada e se não está vazia
} elseif (!isset($_POST["senha"]) || trim($_POST["senha"]) === "") {

    $mensagem_erro = "Erro: informe a senha.";

} else {

    // Armazena os dados recebidos pelo formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Define o tipo de usuário permitido neste login
    $tipo = "admin";

    // Consulta o banco para localizar um usuário com nome, email e tipo correspondentes
    $sql = "SELECT * FROM usuarios
            WHERE nome = :nome
            AND email = :email
            AND tipo = :tipo";

    try {

        // Prepara a consulta SQL para executá-la com segurança
        $stmt = $conexao->prepare($sql);

        // Associa os valores às variáveis da consulta
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":tipo", $tipo);

        // Executa a consulta no banco de dados
        $stmt->execute();

        // Obtém os dados do usuário encontrado como um array associativo
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha corresponde à senha armazenada
        if ($usuario && password_verify($senha, $usuario["senha"])) {

            // Armazena os dados do administrador na sessão
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario"] = $usuario["nome"];
            $_SESSION["tipo"] = $usuario["tipo"];

            // Redireciona para a área de gerenciamento
            header("Location: ../app/select.php");
            exit;

        } else {

            // Exibe uma mensagem caso os dados de acesso não sejam válidos
            $mensagem_erro = "Nome, email ou senha incorretos.";
        }

    } catch (PDOException $e) {

        // Armazena uma mensagem genérica caso ocorra um erro no banco de dados
        $mensagem_erro = "Erro ao realizar o login.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação Admin - Petite Patisserie</title>

    <!-- Importa o arquivo de estilos CSS -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho do site -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<!-- Área principal da página de autenticação -->
<main class="login-container">

    <div class="login-card">

        <h2>Autenticação</h2>

        <!-- Exibe a mensagem somente se houver algum erro -->
        <?php if (!empty($mensagem_erro)): ?>

            <p class="error-message">
                <!-- Protege a exibição do texto, evitando que seja interpretado como HTML -->
                <?php echo htmlspecialchars($mensagem_erro); ?>
            </p>

            <div class="login-footer" style="margin-top: 20px;">

                <!-- Link para retornar à página de login do administrador -->
                <a href="login_admin.php" class="btn-cute">
                    Voltar para o login
                </a>

            </div>

        <?php endif; ?>

    </div>

</main>

<!-- Inclui o rodapé do site -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>