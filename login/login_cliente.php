
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petite Patisserie - Login Cliente</title>

    <!-- Importa o arquivo CSS externo -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho do site -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<!-- Área principal da página de login -->
<main class="login-container">

    <div class="login-card">

        <h2>Login do cliente</h2>

        <p class="subtitle">
            Informe os seus dados para aceder à conta
        </p>

        <!-- Formulário que envia os dados para a verificação do login -->
        <form action="verifica_user.php" method="POST">

            <div class="form-group">

                <!-- Campo para informar o nome do cliente -->
                <label for="nome">Nome:</label>

                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="O seu nome"
                       required>

            </div>

            <div class="form-group">

                <!-- Campo para informar o email -->
                <label for="email">Email:</label>

                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="seuemail@exemplo.com"
                       required>

            </div>

            <div class="form-group">

                <!-- Campo para informar a senha -->
                <label for="senha">Senha:</label>

                <input type="password"
                       id="senha"
                       name="senha"
                       class="form-control"
                       placeholder="••••••••"
                       required>

            </div>

            <!-- Botão que envia os dados do formulário -->
            <input type="submit"
                   name="login_cliente"
                   value="Entrar"
                   class="btn-cute">

        </form>

        <!-- Área com informações e links auxiliares -->
        <div class="login-footer">

            <!-- Dados de teste para acessar como cliente -->
            <div class="dados-teste">
                <h3>Dados de acesso do cliente</h3>
                <p><strong>Nome:</strong> cliente</p>
                <p><strong>Email:</strong> cliente@gmail.com</p>
                <p><strong>Senha:</strong> cliente123</p>
            </div>

            <!-- Link para a página de cadastro -->
            <p>
                Não possui uma conta?
                <a href="../app/cadastro_cliente.php">Cadastre-se</a>
            </p>

            <!-- Link para o login do administrador -->
            <p>
                É administrador?
                <a href="login_admin.php">Entrar como administrador</a>
            </p>

        </div>

    </div>

</main>

<!-- Inclui o rodapé do site -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>