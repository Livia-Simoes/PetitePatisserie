
<?php

// Inicia a sessão para permitir o acesso aos dados do usuário conectado.
session_start();

// Verifica se existe um usuário conectado ao sistema.
// Se não existir, redireciona para a página de login do cliente.
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login/login_cliente.php");
    exit; // Encerra a execução após o redirecionamento.
}

// Inclui o arquivo responsável pela conexão com o banco de dados.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema.
include(__DIR__ . "/../includes/functions.php");

// Recupera o ID do usuário que está conectado.
$usuario_id = $_SESSION["usuario_id"];

// Busca os produtos que estão no carrinho desse usuário.
// A função listarCarrinho() retorna os itens encontrados no banco de dados.
$itens = listarCarrinho($conexao, $usuario_id);


// Verifica se o carrinho não possui nenhum produto.
if (count($itens) == 0) {

    // Exibe uma mensagem informando que o carrinho está vazio.
    echo "<h2>Seu carrinho está vazio.</h2>";

    // Disponibiliza um link para o usuário voltar à vitrine.
    echo "<a href='select.php'>Voltar para a vitrine</a>";

    // Encerra o código, pois não existe nenhum pedido para finalizar.
    exit;
}


// Inicializa a variável que armazenará o valor total do pedido.
$total = 0;

// Percorre todos os produtos encontrados no carrinho.
foreach ($itens as $item) {

    // Multiplica o preço do produto pela quantidade escolhida.
    // O resultado representa o subtotal daquele produto.
    $subtotal = $item["preco"] * $item["quantidade"];

    // Adiciona o subtotal ao valor total do pedido.
    $total += $subtotal;
}


// Verifica se o usuário clicou no botão "Finalizar Pedido".
// O isset() verifica se o campo confirmar foi enviado pelo formulário.
if (isset($_POST["confirmar"])) {

    try {

        // Inicia uma transação no banco de dados.
        // A transação permite executar várias operações como um único processo.
        // Se todas funcionarem, as alterações serão confirmadas.
        // Se ocorrer algum erro, elas poderão ser desfeitas.
        $conexao->beginTransaction();


        // Cria o comando SQL para cadastrar um novo pedido.
        // São armazenados o ID do usuário e o valor total da compra.
        // RETURNING id retorna o ID gerado para o novo pedido.
        $sql = "INSERT INTO pedidos (usuario_id, total)
                VALUES (:usuario_id, :total)
                RETURNING id";

        // Prepara o comando SQL para receber os valores.
        $stmt = $conexao->prepare($sql);

        // Executa o comando enviando os valores correspondentes
        // aos parâmetros :usuario_id e :total.
        $stmt->execute([
            ":usuario_id" => $usuario_id,
            ":total" => $total
        ]);

        // Recupera o ID do pedido que acabou de ser cadastrado.
        // fetchColumn() retorna o valor da primeira coluna do resultado.
        $pedido_id = $stmt->fetchColumn();


        // Percorre novamente os produtos do carrinho.
        // Dessa vez, cada produto será cadastrado na tabela itens_pedido.
        foreach ($itens as $item) {

            // Comando SQL para registrar os produtos que fazem parte do pedido.
            // Cada registro recebe o ID do pedido, o produto,
            // a quantidade comprada e o preço do produto.
            $sql = "INSERT INTO itens_pedido
                    (pedido_id, produto_id, quantidade, preco)
                    VALUES
                    (:pedido_id, :produto_id, :quantidade, :preco)";

            // Prepara o comando SQL.
            $stmt = $conexao->prepare($sql);

            // Executa o cadastro dos itens associando cada produto ao pedido.
            $stmt->execute([
                ":pedido_id" => $pedido_id,
                ":produto_id" => $item["produto_id"],
                ":quantidade" => $item["quantidade"],
                ":preco" => $item["preco"]
            ]);
        }


        // Depois de registrar o pedido e seus produtos,
        // remove os itens do carrinho do usuário.
        $sql = "DELETE FROM carrinho WHERE usuario_id = :usuario_id";

        // Prepara o comando SQL de exclusão.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do usuário ao parâmetro da consulta.
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Executa a exclusão dos itens do carrinho.
        $stmt->execute();


        // Confirma todas as operações realizadas na transação.
        // A partir daqui, o pedido e seus itens ficam registrados no banco.
        $conexao->commit();

        // Cria uma variável para indicar que o pedido foi finalizado.
        // Ela será utilizada posteriormente para mostrar a mensagem de sucesso.
        $pedidoFeito = true;

    } catch (PDOException $e) {

        // Caso aconteça algum erro durante as operações,
        // verifica se ainda existe uma transação ativa.
        if ($conexao->inTransaction()) {

            // Desfaz todas as alterações realizadas na transação.
            // Assim, evita que o pedido fique registrado pela metade.
            $conexao->rollBack();
        }

        // Exibe uma mensagem de erro.
        // htmlspecialchars() impede que caracteres da mensagem
        // sejam interpretados como código HTML.
        echo "<p class='error-message'>Erro ao finalizar o pedido: "
            . htmlspecialchars($e->getMessage())
            . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres da página. -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Finalizar Pedido - Petite Patisserie</title>

    <!-- Conecta a página ao arquivo externo de estilos CSS. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho compartilhado do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Área principal do conteúdo da página. -->
<main class="vitrine-container">

    <!-- Verifica se a variável pedidoFeito foi criada.
         Isso significa que o pedido foi finalizado com sucesso. -->
    <?php if (isset($pedidoFeito)): ?>

        <!-- Exibe o título de confirmação do pedido. -->
        <h2 class="vitrine-title">
            Pedido feito com sucesso!
        </h2>

        <!-- Exibe uma mensagem de agradecimento ao cliente. -->
        <p>
            Obrigado pela sua compra!
        </p>

        <!-- Link para retornar à vitrine e continuar navegando. -->
        <a href="select.php" class="btn-cute">
            Voltar para a Vitrine
        </a>

    <?php else: ?>

        <!-- Caso o pedido ainda não tenha sido confirmado,
             apresenta o resumo dos produtos do carrinho. -->
        <h2 class="vitrine-title">
            Finalizar Pedido
        </h2>

        <!-- Container que organiza as informações do pedido. -->
        <div class="cart-container">

            <!-- Subtítulo da área de resumo. -->
            <h3>Resumo do pedido</h3>

            <!-- Percorre os produtos do carrinho para exibir suas informações. -->
            <?php foreach ($itens as $item): ?>

                <p>

                    <?php
                    // Exibe o nome do produto.
                    // htmlspecialchars() protege a saída contra a interpretação de HTML.
                    echo htmlspecialchars($item["nome"]);
                    ?>

                    -

                    <!-- Mostra a quantidade escolhida pelo cliente. -->
                    <?php echo $item["quantidade"]; ?> unidade(s)

                    -

                    <!-- Calcula e exibe o subtotal do produto.
                         number_format() formata o valor com duas casas decimais,
                         vírgula para os centavos e ponto para os milhares. -->
                    R$ <?php echo number_format(
                        $item["preco"] * $item["quantidade"],
                        2,
                        ',',
                        '.'
                    ); ?>

                </p>

            <?php endforeach; ?>


            <!-- Exibe o valor total da compra, considerando todos os produtos. -->
            <h3>
                Total:

                <!-- Formata o total no padrão de moeda brasileira. -->
                R$ <?php echo number_format($total, 2, ',', '.'); ?>

            </h3>


            <!-- Formulário responsável por enviar a confirmação do pedido. -->
            <form method="POST">

                <!-- Botão que envia o formulário.
                     O name="confirmar" permite que o PHP identifique
                     quando o usuário clicou para finalizar o pedido. -->
                <input type="submit"
                       name="confirmar"
                       value="Finalizar Pedido"
                       class="btn-cute">

            </form>

            <br>

            <!-- Link para voltar ao carrinho sem confirmar o pedido. -->
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
