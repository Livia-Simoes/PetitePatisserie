
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas do documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petite Patisserie - Início</title>

    <!-- Importa a folha de estilos CSS da aplicação -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

    <!-- Inclui o cabeçalho global do site -->
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Conteúdo principal da página inicial -->
    <main>

        <!-- Seção de destaque com texto à esquerda e imagem à direita -->
        <section class="hero-section">

            <!-- Área com o slogan e o botão de cadastro -->
            <div class="hero-content">

                <!-- Título principal da página -->
                <h1>delícias que adoçam a vida</h1>

                <!-- Link para o cadastro de novos clientes -->
                <a href="app/cadastro_cliente.php" class="btn-cute">
                    cadastre-se para começar a comprar!
                </a>

            </div>

            <!-- Área que exibe a imagem principal de destaque -->
            <div class="hero-image">

                <!-- Imagem principal com texto alternativo para acessibilidade -->
                <img src="https://i.pinimg.com/736x/ae/ad/ed/aeaded7004e145b5e3a7910fca3776e3.jpg"
                     alt="Cheesecake de Frutas Vermelhas">

            </div>

        </section>

        <!-- Seção com três categorias de produtos -->
        <section class="categorias-section">

            <!-- Primeiro card: doces por encomenda -->
            <div class="categoria-card">
                <img src="https://i.pinimg.com/1200x/82/7d/6b/827d6b014a4d9d79e7bcd1a9af31d982.jpg"
                     alt="Doces por encomenda">
                <p>doces por encomenda</p>
            </div>

            <!-- Segundo card: tortas -->
            <div class="categoria-card">
                <img src="https://i.pinimg.com/736x/b1/3f/a4/b13fa482442f5f6584349377f5eb3679.jpg"
                     alt="Tortas">
                <p>tortas</p>
            </div>

            <!-- Terceiro card: morango cravejado -->
            <div class="categoria-card">
                <img src="https://i.pinimg.com/736x/c4/74/4d/c4744d21049f94ea17f50422dc62f2a8.jpg"
                     alt="Morango cravejado">
                <p>morango cravejado</p>
            </div>

        </section>

    </main>

    <!-- Inclui o rodapé global do site -->
    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>