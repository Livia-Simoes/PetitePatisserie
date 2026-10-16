<?php

// Inicia a sessão para acessar as informações do usuário que está conectado.
// A sessão permite identificar qual cliente está utilizando o carrinho.
session_start();


// Verifica se existe um usuário conectado ao sistema.
// O isset() verifica se a variável de sessão "usuario" está definida.
// Caso não exista, o cliente não poderá acessar o carrinho.
if (!isset($_SESSION["usuario"])) {

    // Redireciona o usuário para a página de login.
    header("Location: ../login/login_cliente.php");

    // Interrompe a execução para impedir o acesso ao restante da página.
    exit;
}


// Inclui o arquivo responsável pela conexão com o banco de dados.
// A variável $conexao será utilizada para consultar e remover itens do carrinho.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas pelo sistema,
// como listarCarrinho() e apagarCarrinho().
include(__DIR__ . "/../includes/functions.php");


// Verifica se o ID do usuário está armazenado na sessão.
// Esse identificador é necessário para buscar os produtos
// pertencentes ao carrinho do cliente conectado.
if (!isset($_SESSION["usuario_id"])) {

    // Exibe uma mensagem caso o ID do usuário não esteja disponível.
    echo "Erro: ID do usuário não encontrado na sessão.";

    // Interrompe a execução porque não é possível identificar o carrinho.
    exit;
}


// Armazena o ID do usuário conectado em uma variável.
// Essa variável será utilizada nas funções de consulta e remoção dos itens.
$usuario_id = $_SESSION["usuario_id"];


// Verifica se o formulário de remoção foi enviado pelo botão "excluir".
// O isset() identifica se o botão foi pressionado e enviado pelo método POST.
if (isset($_POST["excluir"])) {


    // Verifica se o ID do item foi enviado pelo formulário
    // e se o campo não está vazio.
    if (!isset($_POST["id"]) || $_POST["id"] == "") {

        // Exibe uma mensagem de erro caso nenhum item tenha sido identificado.
        echo "<h2 class='error-message'>Erro: item do carrinho não informado.</h2>";


    } else {

        // Recebe o ID do item do carrinho enviado pelo formulário.
        // Esse ID identifica especificamente qual registro será removido.
        $id = $_POST["id"];


        // Chama a função apagarCarrinho(), localizada no arquivo functions.php.
        // Ela recebe três informações:
        // $conexao: permite acessar o banco de dados;
        // $id: identifica o item que será removido;
        // $usuario_id: identifica o cliente dono do carrinho.
        //
        // O ID do usuário ajuda a garantir que a remoção seja limitada
        // aos itens pertencentes ao próprio cliente.
        apagarCarrinho($conexao, $id, $usuario_id);

    }
}


// Depois da possível remoção, busca novamente os itens do carrinho.
// A função listarCarrinho() consulta o banco de dados utilizando
// o ID do usuário para retornar somente os produtos daquele cliente.
$itens = listarCarrinho($conexao, $usuario_id);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres utilizada na página,
         permitindo a exibição correta de acentos e caracteres especiais. -->
    <meta charset="UTF-8">

    <!-- Configura a página para se adaptar a diferentes tamanhos de tela,
         como computadores, celulares e tablets. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título que aparece na aba do navegador. -->
    <title>Meu Carrinho - Petite Patisserie</title>


    <!-- Conecta a página ao arquivo CSS externo,
         responsável pela aparência e formatação dos elementos. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho padrão do site.
     O __DIR__ facilita a localização do arquivo header.php
     em relação ao diretório atual. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Define a área principal que apresenta os produtos do carrinho.
     A classe vitrine-container utiliza a formatação definida no CSS. -->
<main class="vitrine-container">


    <!-- Título que identifica a página do carrinho de compras. -->
    <h2 class="vitrine-title">Meu carrinho</h2>


    <!-- Container responsável por organizar os itens e as informações do carrinho. -->
    <div class="cart-container">


        <!-- A função count() conta quantos itens existem no array $itens.
             Se a quantidade for igual a zero, significa que o carrinho está vazio. -->
        <?php if (count($itens) == 0): ?>


            <!-- Exibe uma mensagem informando que não existem produtos no carrinho. -->
            <p class="no-products">Seu carrinho está vazio.</p>


            <!-- Área que organiza o link para voltar à vitrine. -->
            <div class="cart-empty-action">

                <!-- Link que direciona o cliente para select.php,
                     página responsável por apresentar os produtos disponíveis. -->
                <a href="select.php" class="btn-cute">
                    Ir para a Vitrine
                </a>

            </div>


        <!-- Caso existam produtos no carrinho, executa o bloco abaixo. -->
        <?php else: ?>


            <?php

            // Inicializa a variável que armazenará o valor total do carrinho.
            // Começa em zero porque ainda não foram calculados os subtotais.
            $subtotal_geral = 0;


            // O foreach percorre todos os itens existentes no array $itens.
            // A cada repetição, os dados de um produto são armazenados na variável $item.
            // Isso permite acessar informações como nome, preço, quantidade e imagem.
            foreach ($itens as $item):


                // Verifica se o produto possui uma imagem cadastrada no banco de dados.
                // O empty() verifica se o campo está vazio.
                // Se existir uma imagem, utiliza o nome armazenado no banco.
                // Caso contrário, utiliza a imagem substituta placeholder.jpg.
                $nomeImagem = !empty($item["imagem"])
                    ? $item["imagem"]
                    : "placeholder.jpg";


                // Calcula o subtotal do produto.
                // Multiplica o preço unitário pela quantidade de unidades
                // existentes no carrinho.
                $subtotal_item = $item["preco"] * $item["quantidade"];


                // Soma o subtotal do produto atual ao valor total do carrinho.
                // O operador += adiciona o valor à variável que já existe.
                // Assim, todos os produtos são somados durante o foreach.
                $subtotal_geral += $subtotal_item;

            ?>


                <!-- Cria um cartão individual para apresentar cada produto do carrinho. -->
                <div class="cart-card">


                    <!-- Exibe a imagem do produto.
                         O src indica o caminho da imagem dentro da pasta do projeto.
                         O htmlspecialchars() protege o nome do arquivo exibido.
                         O alt apresenta uma descrição alternativa da imagem.
                         A classe cart-item-image aplica a formatação do CSS. -->
                    <img
                        src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                        alt="<?php echo htmlspecialchars($item["nome"]); ?>"
                        class="cart-item-image"
                    >


                    <!-- Container que organiza as informações do produto. -->
                    <div class="cart-item-details">


                        <!-- Exibe o nome do produto armazenado no banco de dados. -->
                        <h3 class="product-title">

                            <?php
                            // O echo apresenta o nome do produto na página.
                            // O htmlspecialchars() evita que caracteres especiais
                            // sejam interpretados como código HTML.
                            echo htmlspecialchars($item["nome"]);
                            ?>

                        </h3>


                        <!-- Apresenta o preço de uma unidade do produto. -->
                        <p class="product-price">

                            Preço unitário:

                            <!-- A função number_format() formata o valor numérico.
                                 O primeiro parâmetro recebe o preço.
                                 O segundo define duas casas decimais.
                                 O terceiro define a vírgula como separador decimal.
                                 O quarto define o ponto como separador de milhares. -->
                            R$ <?php echo number_format($item["preco"], 2, ',', '.'); ?>

                        </p>


                        <!-- Apresenta a quantidade de unidades do produto no carrinho. -->
                        <p class="cart-quantity">

                            Quantidade:

                            <strong>

                                <!-- Exibe a quantidade armazenada no banco de dados. -->
                                <?php echo $item["quantidade"]; ?>

                            </strong>

                        </p>


                        <!-- Apresenta o subtotal calculado para aquele produto. -->
                        <p class="cart-subtotal">

                            Subtotal:

                            <strong>

                                <!-- Exibe o subtotal do produto com duas casas decimais
                                     e a formatação monetária brasileira. -->
                                R$ <?php echo number_format($subtotal_item, 2, ',', '.'); ?>

                            </strong>

                        </p>


                    </div>


                    <!-- Cria um formulário responsável por solicitar a remoção
                         do produto selecionado do carrinho.

                         O método POST envia os dados para o próprio arquivo,
                         que verifica o botão "excluir" no início do código. -->
                    <form method="POST" class="cart-actions">


                        <!-- Campo oculto utilizado para enviar o ID do item.
                             O type="hidden" faz com que o campo não apareça visualmente.
                             O name="id" permite que o PHP receba o identificador.
                             O value recebe o ID do item atual do array $item. -->
                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $item["id"]; ?>"
                        >


                        <!-- Botão responsável por enviar o formulário de remoção.
                             O type="submit" realiza o envio.
                             O name="excluir" permite que o PHP identifique
                             que o cliente solicitou a remoção do item.
                             O value define o texto exibido no botão.
                             As classes aplicam a formatação definida no CSS. -->
                        <input
                            type="submit"
                            name="excluir"
                            value="Remover"
                            class="btn-cute btn-remove"
                        >


                    <!-- Encerra o formulário de remoção. -->
                    </form>


                <!-- Encerra o cartão do produto atual. -->
                </div>


            <!-- Encerra o foreach depois de percorrer todos os produtos. -->
            <?php endforeach; ?>


            <!-- Container responsável por apresentar o resumo financeiro
                 e os links para continuar a compra ou finalizar o pedido. -->
            <div class="cart-summary">


                <!-- Apresenta o valor total de todos os produtos do carrinho. -->
                <h3>

                    Total do Pedido:

                    <span class="total-price">

                        <!-- Exibe o valor armazenado em subtotal_geral.
                             A função number_format() organiza o valor
                             com duas casas decimais e formato brasileiro. -->
                        R$ <?php echo number_format($subtotal_geral, 2, ',', '.'); ?>

                    </span>

                </h3>


                <!-- Link que permite voltar à vitrine para escolher outros produtos.
                     O href indica o caminho da página select.php. -->
                <a href="select.php" class="btn-cute btn-secondary">
                    Continuar Comprando
                </a>


                <!-- Link que direciona o cliente para a página de finalização.
                     Nessa página, o sistema deverá processar o pedido do cliente. -->
                <a href="finalizar_pedido.php" class="btn-cute">
                    Finalizar Pedido
                </a>


            <!-- Encerra o resumo do carrinho. -->
            </div>


        <!-- Encerra a condição que verifica se o carrinho está vazio. -->
        <?php endif; ?>


    </div>

</main>


<!-- Inclui o rodapé padrão do site,
     mantendo a estrutura visual compartilhada entre as páginas. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>