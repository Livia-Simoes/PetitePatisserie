
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Petite Patisserie</title>

    <!-- Importa a folha de estilos CSS global -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

    <!-- Inclui o cabeçalho global do site -->
    <?php include(__DIR__ . "/includes/header.php"); ?>

    <!-- Área principal da página de contato -->
    <main class="login-container">
        <div class="login-card" style="max-width: 520px;">

            <!-- Título principal da página -->
            <h2>Entre em contato</h2>

            <!-- Texto de apresentação da página de contato -->
            <p class="subtitle">
                fale com a Petite Patisserie para tirar dúvidas, fazer pedidos ou conhecer nossos produtos!
            </p>

            <!-- Bloco que organiza as informações de contato -->
            <div style="text-align: left; background-color: #fff8fa; padding: 20px; border-radius: 20px; border: 2px dashed #ffe4e8; margin-bottom: 25px;">

                <!-- Exibe o email para contato -->
                <p style="margin: 10px 0; font-size: 1rem;">
                    <strong style="color: #f77ca3;">♥ Email:</strong> petitepatisserie@gmail.com
                </p>

                <!-- Exibe o telefone para contato -->
                <p style="margin: 10px 0; font-size: 1rem;">
                    <strong style="color: #f77ca3;">♥ Telefone:</strong> (19) 99123-4567
                </p>

                <!-- Exibe o endereço da confeitaria -->
                <p style="margin: 10px 0; font-size: 1rem;">
                    <strong style="color: #f77ca3;">♥ Endereço:</strong> Rua do Algodão Doce, 67, Parque do Sorvete
                </p>

            </div>

            <!-- Link para retornar à página inicial -->
            <a href="index.php" class="btn-cute">Voltar para o início</a>

        </div>
    </main>

    <!-- Inclui o rodapé global da aplicação -->
    <?php include(__DIR__ . "/includes/footer.php"); ?>

</body>

</html>