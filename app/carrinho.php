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

// Verifica se o ID do usuário está armazenado na sessão.
// Esse ID é necessário para identificar o carrinho correto.
if (!isset($_SESSION["usuario_id"])) {
    echo "Erro: ID do usuário não encontrado na sessão.";
    exit;
}

// Guarda o ID do usuário conectado em uma variável.
$usuario_id = $_SESSION["usuario_id"];

// Verifica se o botão de remover um item foi clicado.
if (isset($_POST["excluir"])) {

    // Confere se o ID do item do carrinho foi enviado.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        echo "<h2 class='error-message'>Erro: item do carrinho não informado.</h2>";

    } else {

        // Recebe o ID do item que será removido.
        $id = $_POST["id"];

        // Chama a função que remove o item do carrinho.
        // O ID do usuário também é enviado para limitar a remoção ao próprio carrinho.
        apagarCarrinho($conexao, $id, $usuario_id);
    }
}

// Busca os itens do carrinho do usuário após o possível processo de remoção.
$itens = listarCarrinho($conexao, $usuario_id);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="vitrine-container">

    <h2 class="vitrine-title">Meu carrinho</h2>

    <div class="cart-container">

        <!-- count() conta quantos itens foram retornados pela função listarCarrinho(). -->
        <?php if (count($itens) == 0): ?>

            <!-- Exibe uma mensagem quando não há produtos no carrinho. -->
            <p class="no-products">Seu carrinho está vazio.</p>

            <div class="cart-empty-action">
                <a href="select.php" class="btn-cute">
                    Ir para a Vitrine
                </a>
            </div>

        <?php else: ?>

            <?php
            // Inicializa o valor total antes de percorrer os itens.
            $subtotal_geral = 0;

            // Percorre cada item retornado pela função listarCarrinho().
            foreach ($itens as $item):

                // Verifica se o produto possui uma imagem cadastrada.
                // Se não possuir, utiliza uma imagem substituta.
                $nomeImagem = !empty($item["imagem"])
                    ? $item["imagem"]
                    : "placeholder.jpg";

                // Calcula o subtotal do item multiplicando preço pela quantidade.
                $subtotal_item = $item["preco"] * $item["quantidade"];

                // Soma o subtotal atual ao total geral do carrinho.
                $subtotal_geral += $subtotal_item;
            ?>

                <div class="cart-card">

                    <!-- Exibe a imagem do produto e utiliza o nome como texto alternativo. -->
                    <img
                        src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                        alt="<?php echo htmlspecialchars($item["nome"]); ?>"
                        class="cart-item-image"
                    >

                    <div class="cart-item-details">

                        <h3 class="product-title">
                            <?php
                            // Exibe o nome do produto protegendo a saída com htmlspecialchars().
                            echo htmlspecialchars($item["nome"]);
                            ?>
                        </h3>

                        <p class="product-price">
                            Preço unitário:

                            <!-- number_format() formata o preço com duas casas decimais. -->
                            R$ <?php echo number_format($item["preco"], 2, ',', '.'); ?>
                        </p>

                        <p class="cart-quantity">
                            Quantidade:
                            <strong>
                                <?php echo $item["quantidade"]; ?>
                            </strong>
                        </p>

                        <p class="cart-subtotal">
                            Subtotal:
                            <strong>
                                R$ <?php echo number_format($subtotal_item, 2, ',', '.'); ?>
                            </strong>
                        </p>

                    </div>

                    <!-- Formulário responsável por enviar o pedido de remoção do item. -->
                    <form method="POST" class="cart-actions">

                        <!-- Campo oculto que envia o ID do item sem exibi-lo na página. -->
                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $item["id"]; ?>"
                        >

                        <input
                            type="submit"
                            name="excluir"
                            value="Remover"
                            class="btn-cute btn-remove"
                        >

                    </form>

                </div>

            <?php endforeach; ?>

            <!-- Apresenta o total calculado e os links para continuar a compra. -->
            <div class="cart-summary">

                <h3>
                    Total do Pedido:
                    <span class="total-price">
                        R$ <?php echo number_format($subtotal_geral, 2, ',', '.'); ?>
                    </span>
                </h3>

                <a href="select.php" class="btn-cute btn-secondary">
                    Continuar Comprando
                </a>

                <a href="finalizar_pedido.php" class="btn-cute">
                    Finalizar Pedido
                </a>

            </div>

        <?php endif; ?>

    </div>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>