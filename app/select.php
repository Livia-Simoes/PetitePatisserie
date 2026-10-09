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

// Verifica se o usuário conectado é um administrador.
// isset() verifica se o tipo existe e === compara o valor e o tipo de forma estrita.
$isAdmin = isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "admin";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrine - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="vitrine-container">

    <h2 class="vitrine-title">Vitrine de produtos</h2>

    <div class="products-grid">

        <?php

        // Busca todos os produtos cadastrados no banco de dados.
        $todosProdutos = listarProdutos($conexao);

        // Cria um array vazio para armazenar os produtos sem repetir seus IDs.
        $produtosUnicos = [];

        // Verifica se o resultado não está vazio e se é um array.
        if (!empty($todosProdutos) && is_array($todosProdutos)) {

            // Percorre os produtos encontrados.
            foreach ($todosProdutos as $produto) {

                // Usa o ID como chave do array para manter um registro por ID.
                $produtosUnicos[$produto["id"]] = $produto;
            }
        }

        ?>

        <!-- Verifica se existem produtos para exibir na vitrine. -->
        <?php if (empty($produtosUnicos)): ?>

            <p class="no-products">
                Nenhum produto cadastrado no momento.
            </p>

        <?php else: ?>

            <!-- Percorre os produtos para exibir cada cartão na vitrine. -->
            <?php foreach ($produtosUnicos as $produto): ?>

                <?php
                // Verifica se o produto possui uma imagem cadastrada.
                // Caso não possua, utiliza uma imagem substituta.
                $nomeImagem = !empty($produto["imagem"])
                    ? $produto["imagem"]
                    : "placeholder.jpg";
                ?>

                <div class="product-card">

                    <!-- Exibe o ID do produto somente para administradores. -->
                    <?php if ($isAdmin): ?>

                        <span class="admin-badge">
                            ID: <?php echo $produto["id"]; ?>
                        </span>

                    <?php endif; ?>

                    <!-- Exibe a imagem do produto e seu texto alternativo. -->
                    <img src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                         alt="<?php echo htmlspecialchars($produto["nome"]); ?>"
                         class="product-image">

                    <h3 class="product-title">
                        <?php
                        // Exibe o nome do produto protegendo a saída com htmlspecialchars().
                        echo htmlspecialchars($produto["nome"]);
                        ?>
                    </h3>

                    <p class="product-price">
                        <!-- Formata o preço com duas casas decimais e vírgula decimal. -->
                        R$ <?php echo number_format($produto["preco"], 2, ',', '.'); ?>
                    </p>

                    <!-- Envia o ID do produto pela URL para a página do carrinho. -->
                    <a href="adicionar_carrinho.php?id=<?php echo $produto["id"]; ?>"
                       class="btn-cute">
                        Adicionar ao carrinho
                    </a>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>