
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


// Verifica se o usuário conectado possui o tipo administrador.
// isset() verifica se a informação tipo existe na sessão.
// === compara o valor e o tipo de forma estrita.
// Se o usuário for administrador, $isAdmin recebe true.
// Caso contrário, recebe false.
$isAdmin = isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "admin";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Define a codificação de caracteres da página. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Vitrine - Petite Patisserie</title>

    <!-- Importa o arquivo CSS responsável pela aparência da página. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Container principal que organiza o conteúdo da vitrine. -->
<main class="vitrine-container">

    <!-- Título principal da página de produtos. -->
    <h2 class="vitrine-title">Vitrine de produtos</h2>


    <!-- Área responsável por organizar os cartões dos produtos. -->
    <div class="products-grid">

        <?php

        // Chama a função listarProdutos(), definida em functions.php.
        // Ela recebe a conexão com o banco de dados e retorna os produtos cadastrados.
        $todosProdutos = listarProdutos($conexao);


        // Cria um array vazio para armazenar os produtos sem repetir seus IDs.
        // Cada produto será identificado pelo seu próprio ID.
        $produtosUnicos = [];


        // Verifica se a lista de produtos não está vazia
        // e se o resultado recebido é realmente um array.
        if (!empty($todosProdutos) && is_array($todosProdutos)) {

            // Percorre todos os produtos retornados pelo banco de dados.
            foreach ($todosProdutos as $produto) {

                // Utiliza o ID do produto como chave do array.
                // Assim, se houver outro produto com o mesmo ID,
                // o registro anterior será substituído, evitando repetição.
                $produtosUnicos[$produto["id"]] = $produto;
            }
        }

        ?>


        <!-- Verifica se existe algum produto para apresentar na vitrine.
             empty() retorna verdadeiro quando o array está vazio. -->
        <?php if (empty($produtosUnicos)): ?>

            <!-- Mensagem exibida quando ainda não existem produtos cadastrados. -->
            <p class="no-products">
                Nenhum produto cadastrado no momento.
            </p>

        <?php else: ?>


            <!-- Percorre os produtos armazenados no array $produtosUnicos.
                 Cada produto é armazenado temporariamente na variável $produto. -->
            <?php foreach ($produtosUnicos as $produto): ?>

                <?php

                // Verifica se o produto possui uma imagem cadastrada.
                // Se possuir, utiliza o nome da imagem armazenado no banco.
                // Caso contrário, utiliza a imagem padrão placeholder.jpg.
                $nomeImagem = !empty($produto["imagem"])
                    ? $produto["imagem"]
                    : "placeholder.jpg";

                ?>


                <!-- Cria um cartão individual para apresentar cada produto. -->
                <div class="product-card">


                    <!-- Verifica se o usuário conectado é um administrador.
                         Somente administradores conseguem visualizar o ID do produto. -->
                    <?php if ($isAdmin): ?>

                        <!-- Apresenta o ID do produto para facilitar sua identificação
                             durante o gerenciamento dos produtos. -->
                        <span class="admin-badge">
                            ID: <?php echo $produto["id"]; ?>
                        </span>

                    <?php endif; ?>


                    <!-- Exibe a imagem do produto.
                         O caminho é formado pela pasta de imagens e pelo nome do arquivo.
                         O atributo alt apresenta uma descrição da imagem.
                         htmlspecialchars() protege os valores exibidos no HTML. -->
                    <img src="../assets/imagens/<?php echo htmlspecialchars($nomeImagem); ?>"
                         alt="<?php echo htmlspecialchars($produto["nome"]); ?>"
                         class="product-image">


                    <!-- Exibe o nome do produto no cartão. -->
                    <h3 class="product-title">

                        <?php
                        // Mostra o nome do produto sem interpretar caracteres como HTML.
                        echo htmlspecialchars($produto["nome"]);
                        ?>

                    </h3>


                    <!-- Exibe o preço do produto no formato de moeda brasileira. -->
                    <p class="product-price">

                        <!-- number_format() apresenta duas casas decimais,
                             vírgula para os centavos e ponto para milhares. -->
                        R$ <?php echo number_format($produto["preco"], 2, ',', '.'); ?>

                    </p>


                    <!-- Link utilizado para adicionar o produto ao carrinho.
                         O ID do produto é enviado pela URL através do parâmetro id.
                         A página adicionar_carrinho.php recebe esse ID para
                         identificar qual produto deverá ser adicionado. -->
                    <a href="adicionar_carrinho.php?id=<?php echo $produto["id"]; ?>"
                       class="btn-cute">

                        Adicionar ao carrinho

                    </a>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</main>


<!-- Inclui o rodapé padrão utilizado nas páginas do site. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>

</body>
</html>
