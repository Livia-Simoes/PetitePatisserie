
<?php

// Inicia uma nova sessão ou retoma a sessão existente.
// A sessão permite armazenar os dados do cliente após o login.
session_start();


// Inclui o arquivo responsável pela conexão com o banco de dados.
// Assim, esta página consegue consultar a tabela usuarios.
include(__DIR__ . "/../database/connect.php");


// Cria uma variável vazia para armazenar possíveis mensagens de erro.
$mensagem_erro = "";


// Verifica se o campo email foi enviado pelo formulário
// e se não está vazio após a remoção dos espaços.
if (!isset($_POST["email"]) || trim($_POST["email"]) === "") {

    // Armazena uma mensagem caso o email não tenha sido informado.
    $mensagem_erro = "Erro: informe o email.";


// Verifica se o campo senha foi enviado e se não está vazio.
} elseif (!isset($_POST["senha"]) || trim($_POST["senha"]) === "") {

    // Armazena uma mensagem caso a senha não tenha sido informada.
    $mensagem_erro = "Erro: informe a senha.";

} else {

    // Armazena o email recebido pelo formulário.
    // trim() remove os espaços existentes no início e no final do texto.
    $email = trim($_POST["email"]);

    // Armazena a senha informada pelo cliente.
    $senha = $_POST["senha"];


    // Define o tipo de usuário permitido nesta página.
    // Dessa forma, somente usuários cadastrados como clientes
    // poderão realizar o login por esta área.
    $tipo = "cliente";


    // Cria a consulta SQL para localizar o cliente no banco de dados.
    // A busca considera o email e o tipo de usuário.
    $sql = "SELECT * FROM usuarios
            WHERE email = :email
            AND tipo = :tipo";


    // O try permite executar a consulta e tratar possíveis erros do banco.
    try {

        // Prepara a consulta SQL antes de executá-la.
        // Isso permite utilizar parâmetros na consulta.
        $stmt = $conexao->prepare($sql);


        // Associa os valores das variáveis aos parâmetros da consulta SQL.
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":tipo", $tipo);


        // Executa a consulta no banco de dados.
        $stmt->execute();


        // Recupera os dados do cliente encontrado.
        // PDO::FETCH_ASSOC retorna os resultados em um array associativo,
        // permitindo acessar as informações pelo nome das colunas.
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


        // Verifica duas condições:
        // 1. Se o cliente foi encontrado no banco de dados.
        // 2. Se a senha digitada corresponde à senha armazenada.
        // password_verify() compara a senha com seu hash.
        if ($usuario && password_verify($senha, $usuario["senha"])) {

            // Armazena o ID do cliente na sessão.
            $_SESSION["usuario_id"] = $usuario["id"];

            // Armazena o nome do cliente na sessão.
            $_SESSION["usuario"] = $usuario["nome"];

            // Armazena o tipo de usuário na sessão.
            $_SESSION["tipo"] = $usuario["tipo"];


            // Redireciona o cliente para a vitrine do sistema após o login.
            header("Location: ../app/select.php");

            // Encerra a execução para evitar que o restante da página seja executado.
            exit;


        } else {

            // Caso o cliente não seja encontrado ou a senha esteja incorreta,
            // armazena uma mensagem informando que os dados são inválidos.
            $mensagem_erro = "E-mail ou senha incorretos.";

        }


    } catch (PDOException $e) {

        // Caso ocorra algum erro durante a consulta ao banco de dados,
        // armazena uma mensagem genérica para apresentar ao cliente.
        $mensagem_erro = "Erro ao realizar o login.";

    }

}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres utilizada na página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Autenticação Cliente - Petite Patisserie</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal que organiza o conteúdo da página de autenticação. -->
<main class="login-container">

    <!-- Card que agrupa o título e as mensagens de autenticação. -->
    <div class="login-card">

        <!-- Título da página de autenticação do cliente. -->
        <h2>Autenticação</h2>


        <!-- Verifica se a variável mensagem_erro possui algum conteúdo.
             empty() verifica se a variável está vazia. -->
        <?php if (!empty($mensagem_erro)): ?>

            <!-- Exibe a mensagem de erro dentro de um parágrafo. -->
            <p class="error-message">

                <!-- htmlspecialchars() protege o texto exibido,
                     impedindo que caracteres especiais sejam interpretados como HTML. -->
                <?php echo htmlspecialchars($mensagem_erro); ?>

            </p>


            <!-- Área que organiza o link para retornar à página de login. -->
            <div class="login-footer" style="margin-top: 20px;">

                <!-- Link que direciona novamente para o login do cliente. -->
                <a href="login_cliente.php" class="btn-cute">
                    Voltar para o login
                </a>

            </div>

        <?php endif; ?>

    </div>

</main>


<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>
