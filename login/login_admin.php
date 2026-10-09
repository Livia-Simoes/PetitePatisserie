<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petite Patisserie - Login Administrador</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="login-container">

    <div class="login-card">

        <h2>Login do administrador</h2>

        <p class="subtitle">
            Área restrita para gestão do sistema
        </p>

        <!-- Envia os dados preenchidos para a página que verifica o login. -->
        <form action="verifica_admin.php" method="POST">

            <div class="form-group">

                <label for="nome">Nome:</label>

                <!-- Campo para informar o nome do administrador. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Seu nome de usuário"
                       required>

            </div>

            <div class="form-group">

                <label for="email">Email:</label>

                <!-- type="email" permite ao navegador verificar o formato básico do email. -->
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="admin@petitepatisserie.com"
                       required>

            </div>

            <div class="form-group">

                <label for="senha">Senha:</label>

                <!-- type="password" oculta visualmente os caracteres digitados. -->
                <input type="password"
                       id="senha"
                       name="senha"
                       class="form-control"
                       placeholder="••••••••"
                       required>

            </div>

            <!-- Envia os dados do formulário ao clicar no botão Entrar. -->
            <input type="submit"
                   name="login_admin"
                   value="Entrar"
                   class="btn-cute">

        </form>

        <div class="login-footer">

            <!-- Exibe dados de teste para acessar a área administrativa. -->
            <div class="dados-teste">

                <h3>Dados de acesso do administrador</h3>
                <p><strong>Nome:</strong> admin</p>
                <p><strong>Email:</strong> admin@gmail.com</p>
                <p><strong>Senha:</strong> admin123</p>

            </div>

            <p>
                É um cliente?
                <!-- Link para a página de login dos clientes. -->
                <a href="login_cliente.php">Ir para o login de cliente</a>
            </p>

        </div>

    </div>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>