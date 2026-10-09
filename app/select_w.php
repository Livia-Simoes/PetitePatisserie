<?php

// Inicia a sessão para acessar os dados do usuário conectado.
session_start();

// Verifica se existe um usuário logado.
// Caso não exista, redireciona para a página de login.
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login/login_cliente.php");
    exit;
}

// Importa a conexão com o banco de dados e as funções do sistema.
include(__DIR__ . "/../database/connect.php");
include(__DIR__ . "/../includes/functions.php");

// Inicializa a variável que armazenará o nome do produto pesquisado.
$produto = "";

// Verifica se o nome do produto foi enviado pela URL.
// trim() remove espaços em branco do início e do final do texto.
if (isset($_GET["produto"])) {
    $produto = trim($_GET["produto"]);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Produto - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="vitrine-container">

    <div class="search-section">

        <h2 class="vitrine-title">Pesquisar produtos</h2>

        <p class="subtitle">
            Encontre as suas doçuras favoritas
        </p>

        <!-- O método GET envia o termo pesquisado pela URL. -->
        <form method="GET" class="search-form">

            <div class="search-group">

                <input type="text"
                       name="produto"
                       class="form-control search-input"
                       placeholder="Digite o nome do produto..."
                       value="<?php echo htmlspecialchars($produto); ?>"
                       required>

                <button type="submit" class="btn-cute search-btn">
                    Buscar
                </button>

            </div>

        </form>

    </div>

    <div class="products-grid">

        <!-- Verifica se o usuário ainda não digitou um termo de pesquisa. -->
        <?php if ($produto == ""): ?>

            <p class="no-products">
                Digite o nome de um produto no campo acima para pesquisar.
            </p>

        <?php else: ?>

            <?php
            // Chama a função que pesquisa os produtos no banco de dados.
            $produtos = buscarProdutos($conexao, $produto);
            ?>

            <!-- Verifica se a pesquisa retornou algum produto. -->
            <?php if (count($produtos) == 0): ?>

                <p class="no-products">
                    Nenhum produto encontrado para
                    "<strong><?php echo htmlspecialchars($produto); ?></strong>".
                </p>

            <?php else: ?>

                <!-- Percorre os produtos encontrados para exibi-los na página. -->
                <?php foreach ($produtos as $item): ?>

                    <?php
                    // Verifica se o produto possui uma imagem cadastrada.
                    // Se não possuir, utiliza uma imagem substituta.
                    $nomeImagem = !empty($item["imagem"])
                        ? $item["imagem"]
                        : "placeholder.jpg";
                    ?>

                    <div class="product-card">

                        <!-- Exibe a imagem do produto com um texto alternativo. -->
                        <img src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                             alt="<?php echo htmlspecialchars($item["nome"]); ?>"
                             class="product-image">

                        <h3 class="product-title">
                            <?php
                            // Exibe o nome do produto protegendo a saída com htmlspecialchars().
                            echo htmlspecialchars($item["nome"]);
                            ?>
                        </h3>

                        <p class="product-price">
                            <!-- Formata o preço com duas casas decimais. -->
                            R$ <?php echo number_format($item["preco"], 2, ',', '.'); ?>
                        </p>

                        <!-- Envia o ID do produto pela URL para a página do carrinho. -->
                        <a href="adicionar_carrinho.php?id=<?php echo $item["id"]; ?>"
                           class="btn-cute">
                            Adicionar ao carrinho
                        </a>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>