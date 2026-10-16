
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres utilizada na página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Petite Patisserie - Login Cliente</title>

    <!-- Importa o arquivo CSS externo, responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal que organiza o conteúdo da página de login. -->
<main class="login-container">

    <!-- Card que agrupa o formulário e as informações auxiliares. -->
    <div class="login-card">

        <!-- Título que identifica a página de login do cliente. -->
        <h2>Login do cliente</h2>

        <!-- Texto que orienta o cliente a informar seus dados de acesso. -->
        <p class="subtitle">
            Informe os seus dados para aceder à conta
        </p>


        <!-- Formulário responsável por enviar os dados para a verificação do login.
             action indica a página que receberá as informações.
             method="POST" envia os dados pelo método POST. -->
        <form action="verifica_user.php" method="POST">

            <!-- Agrupa o campo de nome do cliente. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de nome. -->
                <label for="nome">Nome:</label>

                <!-- Campo para informar o nome do cliente.
                     type="text" permite digitar texto.
                     id identifica o campo.
                     name permite recuperar o valor usando $_POST["nome"].
                     placeholder apresenta uma mensagem de orientação.
                     required exige que o campo seja preenchido. -->
                <input type="text"
                       id="nome"
                       name="nome"
                       class="form-control"
                       placeholder="O seu nome"
                       required>

            </div>


            <!-- Agrupa o campo de email do cliente. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de email. -->
                <label for="email">Email:</label>

                <!-- Campo para informar o email.
                     type="email" permite ao navegador verificar o formato básico
                     do endereço de email.
                     name permite recuperar o valor usando $_POST["email"].
                     required exige o preenchimento do campo. -->
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="seuemail@exemplo.com"
                       required>

            </div>


            <!-- Agrupa o campo de senha do cliente. -->
            <div class="form-group">

                <!-- Rótulo que identifica o campo de senha. -->
                <label for="senha">Senha:</label>

                <!-- Campo para informar a senha.
                     type="password" oculta visualmente os caracteres digitados.
                     name permite recuperar o valor usando $_POST["senha"].
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
                 name identifica o botão enviado.
                 value define o texto exibido no botão. -->
            <input type="submit"
                   name="login_cliente"
                   value="Entrar"
                   class="btn-cute">

        </form>


        <!-- Área que apresenta informações e links auxiliares ao cliente. -->
        <div class="login-footer">


            <!-- Container que apresenta dados de teste para acessar como cliente. -->
            <div class="dados-teste">

                <!-- Título da área de dados de acesso. -->
                <h3>Dados de acesso do cliente</h3>

                <!-- Apresenta o nome utilizado no acesso de teste. -->
                <p><strong>Nome:</strong> cliente</p>

                <!-- Apresenta o email utilizado no acesso de teste. -->
                <p><strong>Email:</strong> cliente@gmail.com</p>

                <!-- Apresenta a senha utilizada no acesso de teste. -->
                <p><strong>Senha:</strong> cliente123</p>

            </div>


            <!-- Informa que novos clientes podem criar uma conta. -->
            <p>

                Não possui uma conta?

                <!-- Link que direciona para a página de cadastro de clientes. -->
                <a href="../app/cadastro_cliente.php">Cadastre-se</a>

            </p>


            <!-- Apresenta uma opção de acesso para administradores. -->
            <p>

                É administrador?

                <!-- Link que direciona para a página de login do administrador. -->
                <a href="login_admin.php">Entrar como administrador</a>

            </p>

        </div>

    </div>

</main>


<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
