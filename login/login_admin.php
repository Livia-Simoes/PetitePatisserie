
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres da página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Petite Patisserie - Login Administrador</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal que organiza o conteúdo da página de login. -->
<main class="login-container">

    <!-- Card que agrupa os campos e as informações de acesso. -->
    <div class="login-card">

        <!-- Título que identifica a área de login do administrador. -->
        <h2>Login do administrador</h2>

        <!-- Texto que informa a finalidade dessa área do sistema. -->
        <p class="subtitle">
            Área restrita para gestão do sistema
        </p>


        <!-- Formulário responsável por enviar os dados do administrador.
             action indica que as informações serão enviadas para verifica_admin.php.
             method="POST" envia os dados sem colocá-los diretamente na URL. -->
        <form action="verifica_admin.php" method="POST">

            <!-- Agrupa o campo de nome do administrador. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de nome. -->
                <label for="nome">Nome:</label>

                <!-- Campo onde o administrador informa seu nome.
                     id relaciona o campo ao label.
                     name permite recuperar o valor no PHP através de $_POST["nome"].
                     required exige que o campo seja preenchido. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="Seu nome de usuário"
                       required>

            </div>


            <!-- Agrupa o campo de email do administrador. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de email. -->
                <label for="email">Email:</label>

                <!-- Campo utilizado para informar o email.
                     type="email" permite ao navegador verificar o formato básico
                     do endereço de email.
                     name="email" permite recuperar o valor com $_POST["email"].
                     required exige o preenchimento do campo. -->
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="admin@petitepatisserie.com"
                       required>

            </div>


            <!-- Agrupa o campo de senha do administrador. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de senha. -->
                <label for="senha">Senha:</label>

                <!-- Campo utilizado para informar a senha.
                     type="password" oculta visualmente os caracteres digitados.
                     name="senha" permite recuperar o valor com $_POST["senha"].
                     required exige que o campo seja preenchido. -->
                <input type="password"
                       id="senha"
                       name="senha"
                       class="form-control"
                       placeholder="••••••••"
                       required>

            </div>


            <!-- Botão responsável por enviar os dados do formulário.
                 type="submit" realiza o envio.
                 name="login_admin" identifica o botão enviado.
                 value define o texto apresentado no botão. -->
            <input type="submit"
                   name="login_admin"
                   value="Entrar"
                   class="btn-cute">

        </form>


        <!-- Área inferior que apresenta informações adicionais ao usuário. -->
        <div class="login-footer">


            <!-- Container que apresenta os dados de teste do administrador. -->
            <div class="dados-teste">

                <!-- Título da área de dados de acesso. -->
                <h3>Dados de acesso do administrador</h3>

                <!-- Apresenta o nome utilizado no acesso de teste. -->
                <p><strong>Nome:</strong> admin</p>

                <!-- Apresenta o email utilizado no acesso de teste. -->
                <p><strong>Email:</strong> admin@gmail.com</p>

                <!-- Apresenta a senha utilizada no acesso de teste. -->
                <p><strong>Senha:</strong> admin123</p>

            </div>


            <!-- Informa que clientes também podem acessar o sistema. -->
            <p>

                É um cliente?

                <!-- Link que direciona para a página de login dos clientes. -->
                <a href="login_cliente.php">Ir para o login de cliente</a>

            </p>

        </div>

    </div>

</main>


<!-- Inclui o rodapé padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
