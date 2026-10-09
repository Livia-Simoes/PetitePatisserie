
<?php

// Inicia a sessão para armazenar os dados do cliente autenticado
session_start();

// Inclui o arquivo responsável pela conexão com o banco de dados
include(__DIR__ . "/../database/connect.php");

// Variável que armazenará uma possível mensagem de erro
$mensagem_erro = "";

// Verifica se o email foi enviado e se não está vazio
if (!isset($_POST["email"]) || trim($_POST["email"]) === "") {

    $mensagem_erro = "Erro: informe o email.";

// Verifica se a senha foi enviada e se não está vazia
} elseif (!isset($_POST["senha"]) || trim($_POST["senha"]) === "") {

    $mensagem_erro = "Erro: informe a senha.";

} else {

    // Armazena o email sem espaços no início e no final
    $email = trim($_POST["email"]);

    // Armazena a senha informada pelo cliente
    $senha = $_POST["senha"];

    // Define o tipo de usuário permitido neste login
    $tipo = "cliente";

    // Consulta o banco para localizar um usuário com o email e o tipo correspondentes
    $sql = "SELECT * FROM usuarios
            WHERE email = :email
            AND tipo = :tipo";

    try {

        // Prepara a consulta SQL
        $stmt = $conexao->prepare($sql);

        // Associa os valores aos parâmetros da consulta
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":tipo", $tipo);

        // Executa a consulta no banco de dados
        $stmt->execute();

        // Obtém os dados do cliente encontrado como um array associativo
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o cliente existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario["senha"])) {

            // Armazena os dados do cliente na sessão
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario"] = $usuario["nome"];
            $_SESSION["tipo"] = $usuario["tipo"];

            // Redireciona para a área da aplicação após o login
            header("Location: ../app/select.php");
            exit;

        } else {

            // Exibe uma mensagem se o email ou a senha estiverem incorretos
            $mensagem_erro = "E-mail ou senha incorretos.";
        }

    } catch (PDOException $e) {

        // Armazena uma mensagem caso ocorra um erro no banco de dados
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
    <title>Autenticação Cliente - Petite Patisserie</title>

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

        <!-- Exibe a mensagem somente quando existe algum erro -->
        <?php if (!empty($mensagem_erro)): ?>

            <p class="error-message">
                <!-- Evita que o texto da mensagem seja interpretado como código HTML -->
                <?php echo htmlspecialchars($mensagem_erro); ?>
            </p>

            <div class="login-footer" style="margin-top: 20px;">

                <!-- Link para retornar à página de login do cliente -->
                <a href="login_cliente.php" class="btn-cute">
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