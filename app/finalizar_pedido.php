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

// Recupera o ID do usuário conectado e busca os itens do carrinho.
$usuario_id = $_SESSION["usuario_id"];
$itens = listarCarrinho($conexao, $usuario_id);

// Verifica se o carrinho está vazio.
if (count($itens) == 0) {

    // Exibe uma mensagem e um link para voltar à vitrine.
    echo "<h2>Seu carrinho está vazio.</h2>";
    echo "<a href='select.php'>Voltar para a vitrine</a>";

    exit; // Encerra o código porque não há itens para finalizar.
}

// Inicializa o valor total do pedido.
$total = 0;

// Percorre os itens do carrinho para calcular o valor total.
foreach ($itens as $item) {

    // Calcula o subtotal de cada produto.
    $subtotal = $item["preco"] * $item["quantidade"];

    // Soma cada subtotal ao valor total do pedido.
    $total += $subtotal;
}

// Verifica se o botão "Finalizar Pedido" foi acionado.
if (isset($_POST["confirmar"])) {

    try {

        // Inicia uma transação no banco de dados.
        // Isso permite confirmar todas as alterações juntas ou desfazê-las em caso de erro.
        $conexao->beginTransaction();

        // Insere o pedido na tabela pedidos e retorna o ID gerado.
        $sql = "INSERT INTO pedidos (usuario_id, total)
                VALUES (:usuario_id, :total)
                RETURNING id";

        // Prepara o comando SQL para execução segura com parâmetros.
        $stmt = $conexao->prepare($sql);

        // Envia os valores do usuário e do total para o banco.
        $stmt->execute([
            ":usuario_id" => $usuario_id,
            ":total" => $total
        ]);

        // Recupera o ID do pedido que acabou de ser criado.
        // fetchColumn() retorna o valor da primeira coluna da linha consultada.
        $pedido_id = $stmt->fetchColumn();

        // Percorre os itens do carrinho para registrá-los no pedido.
        foreach ($itens as $item) {

            // Insere cada produto na tabela itens_pedido.
            $sql = "INSERT INTO itens_pedido
                    (pedido_id, produto_id, quantidade, preco)
                    VALUES
                    (:pedido_id, :produto_id, :quantidade, :preco)";

            $stmt = $conexao->prepare($sql);

            // Associa cada item ao pedido e registra quantidade e preço.
            $stmt->execute([
                ":pedido_id" => $pedido_id,
                ":produto_id" => $item["produto_id"],
                ":quantidade" => $item["quantidade"],
                ":preco" => $item["preco"]
            ]);
        }

        // Remove os itens do carrinho do usuário após registrar o pedido.
        $sql = "DELETE FROM carrinho WHERE usuario_id = :usuario_id";

        $stmt = $conexao->prepare($sql);

        // Associa o ID do usuário ao parâmetro da consulta SQL.
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        // Confirma todas as alterações realizadas na transação.
        $conexao->commit();

        // Indica que o pedido foi finalizado com sucesso.
        $pedidoFeito = true;

    } catch (PDOException $e) {

        // Se ocorrer um erro, desfaz as alterações da transação.
        if ($conexao->inTransaction()) {
            $conexao->rollBack();
        }

        // Exibe a mensagem de erro protegendo sua saída com htmlspecialchars().
        echo "<p class='error-message'>Erro ao finalizar o pedido: "
            . htmlspecialchars($e->getMessage())
            . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">
</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>

<main class="vitrine-container">

    <!-- Verifica se o pedido foi finalizado com sucesso. -->
    <?php if (isset($pedidoFeito)): ?>

        <!-- Área exibida após a conclusão do pedido. -->
        <h2 class="vitrine-title">
            Pedido feito com sucesso!
        </h2>

        <p>
            Obrigado pela sua compra!
        </p>

        <a href="select.php" class="btn-cute">
            Voltar para a Vitrine
        </a>

    <?php else: ?>

        <!-- Caso o pedido ainda não tenha sido finalizado, exibe o resumo. -->
        <h2 class="vitrine-title">
            Finalizar Pedido
        </h2>

        <div class="cart-container">

            <h3>Resumo do pedido</h3>

            <!-- Percorre os produtos para mostrar nome, quantidade e subtotal. -->
            <?php foreach ($itens as $item): ?>

                <p>
                    <?php
                    // Exibe o nome do produto sem interpretar caracteres como HTML.
                    echo htmlspecialchars($item["nome"]);
                    ?>
                    -
                    <?php echo $item["quantidade"]; ?> unidade(s)
                    -
                    R$ <?php echo number_format(
                        $item["preco"] * $item["quantidade"],
                        2,
                        ',',
                        '.'
                    ); ?>
                </p>

            <?php endforeach; ?>

            <!-- Exibe o valor total formatado como moeda brasileira. -->
            <h3>
                Total:
                R$ <?php echo number_format($total, 2, ',', '.'); ?>
            </h3>

            <!-- Envia a confirmação do pedido pelo método POST. -->
            <form method="POST">

                <input type="submit"
                       name="confirmar"
                       value="Finalizar Pedido"
                       class="btn-cute">

            </form>

            <br>

            <!-- Permite voltar ao carrinho antes de confirmar o pedido. -->
            <a href="carrinho.php" class="btn-cute">
                Voltar ao Carrinho
            </a>

        </div>

    <?php endif; ?>

</main>

<!-- Inclui o rodapé compartilhado do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>