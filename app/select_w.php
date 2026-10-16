
<?php

// Inicia a sessão para permitir o acesso aos dados do usuário conectado.
session_start();

// Verifica se existe um usuário conectado ao sistema.
// Caso não exista, redireciona para a página de login do cliente.
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login/login_cliente.php");
    exit; // Encerra a execução após o redirecionamento.
}

// Inclui o arquivo responsável pela conexão com o banco de dados.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema.
include(__DIR__ . "/../includes/functions.php");


// Cria uma variável para armazenar o nome do produto pesquisado.
// Inicialmente, ela recebe um texto vazio.
$produto = "";


// Verifica se o formulário enviou o campo produto pela URL.
if (isset($_GET["produto"])) {

    // Recupera o texto digitado pelo usuário.
    // trim() remove os espaços em branco do início e do final do texto.
    $produto = trim($_GET["produto"]);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres da página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Pesquisar Produto - Petite Patisserie</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Container principal que organiza o conteúdo da página. -->
<main class="vitrine-container">

    <!-- Seção que contém o título e o formulário de pesquisa. -->
    <div class="search-section">

        <!-- Título da página de pesquisa. -->
        <h2 class="vitrine-title">Pesquisar produtos</h2>

        <!-- Texto apresentado abaixo do título. -->
        <p class="subtitle">
            Encontre as suas doçuras favoritas
        </p>


        <!-- Formulário utilizado para pesquisar os produtos.
             O método GET envia o valor digitado pela URL. -->
        <form method="GET" class="search-form">

            <!-- Agrupa o campo de pesquisa e o botão. -->
            <div class="search-group">

                <!-- Campo de texto onde o usuário informa o produto desejado.
                     name identifica o campo para recuperá-lo com $_GET.
                     value mantém o texto pesquisado após o envio.
                     placeholder apresenta uma orientação dentro do campo.
                     required exige que o campo seja preenchido. -->
                <input type="text"
                       name="produto"
                       class="form-control search-input"
                       placeholder="Digite o nome do produto..."
                       value="<?php echo htmlspecialchars($produto); ?>"
                       required>

                <!-- Botão responsável por enviar o formulário. -->
                <button type="submit" class="btn-cute search-btn">
                    Buscar
                </button>

            </div>

        </form>

    </div>


    <!-- Área onde os produtos encontrados serão apresentados. -->
    <div class="products-grid">

        <!-- Verifica se o usuário ainda não informou nenhum produto.
             A condição é verdadeira quando a variável $produto está vazia. -->
        <?php if ($produto == ""): ?>

            <!-- Orienta o usuário a digitar o nome de um produto. -->
            <p class="no-products">
                Digite o nome de um produto no campo acima para pesquisar.
            </p>

        <?php else: ?>

            <?php

            // Executa a função buscarProdutos(), definida no arquivo functions.php.
            // Recebe a conexão com o banco de dados e o texto pesquisado.
            // Os produtos encontrados são armazenados na variável $produtos.
            $produtos = buscarProdutos($conexao, $produto);

            ?>


            <!-- Verifica se a pesquisa retornou algum resultado.
                 count() conta quantos produtos foram encontrados. -->
            <?php if (count($produtos) == 0): ?>

                <!-- Mensagem apresentada quando nenhum produto é encontrado. -->
                <p class="no-products">

                    Nenhum produto encontrado para

                    <!-- Exibe o nome pesquisado de forma segura. -->
                    "<strong><?php echo htmlspecialchars($produto); ?></strong>".

                </p>

            <?php else: ?>


                <!-- Percorre a lista de produtos encontrados no banco de dados.
                     Cada produto é armazenado temporariamente na variável $item. -->
                <?php foreach ($produtos as $item): ?>

                    <?php

                    // Verifica se existe uma imagem cadastrada para o produto.
                    // Se existir, utiliza o nome da imagem armazenado no banco.
                    // Caso contrário, utiliza uma imagem padrão chamada placeholder.jpg.
                    $nomeImagem = !empty($item["imagem"])
                        ? $item["imagem"]
                        : "placeholder.jpg";

                    ?>


                    <!-- Cria um card individual para cada produto encontrado. -->
                    <div class="product-card">

                        <!-- Apresenta a imagem correspondente ao produto.
                             O caminho é formado pela pasta de imagens e pelo nome do arquivo.
                             O atributo alt descreve a imagem caso ela não seja carregada. -->
                        <img src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                             alt="<?php echo htmlspecialchars($item["nome"]); ?>"
                             class="product-image">


                        <!-- Apresenta o nome do produto. -->
                        <h3 class="product-title">

                            <?php
                            // Exibe o nome do produto.
                            // htmlspecialchars() evita que o texto seja interpretado como HTML.
                            echo htmlspecialchars($item["nome"]);
                            ?>

                        </h3>


                        <!-- Apresenta o preço do produto. -->
                        <p class="product-price">

                            <!-- Formata o preço com duas casas decimais,
                                 vírgula para separar os centavos e ponto para milhares. -->
                            R$ <?php echo number_format($item["preco"], 2, ',', '.'); ?>

                        </p>


                        <!-- Link utilizado para adicionar o produto ao carrinho.
                             O ID do produto é enviado pela URL através do parâmetro id.
                             A página adicionar_carrinho.php utiliza esse ID
                             para identificar qual produto deverá ser adicionado. -->
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


<!-- Inclui o rodapé padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
