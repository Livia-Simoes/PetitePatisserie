<?php

// Inicia a sessão para permitir o acesso às informações
// do usuário que está conectado ao sistema.
session_start();


// Verifica se existe um usuário conectado e se ele possui o tipo "admin".
// O operador || significa "ou", então basta uma das condições ser verdadeira
// para que o acesso à página seja bloqueado.
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "admin") {

    // Redireciona o usuário para a página inicial caso não tenha autorização.
    header("Location: ../index.php");

    // Interrompe a execução do código para impedir o acesso à página.
    exit;
}


// Inclui o arquivo responsável pela conexão com o banco de dados.
// A variável $conexao será utilizada para realizar o cadastro do produto.
include(__DIR__ . "/../database/connect.php");

// Inclui o arquivo que contém as funções utilizadas no sistema,
// incluindo a função cadastrarProduto().
include(__DIR__ . "/../includes/functions.php");


// Cria uma variável vazia para armazenar mensagens de sucesso ou erro.
$mensagem = "";

// Cria uma variável para controlar se o produto foi cadastrado com sucesso.
// Inicialmente, recebe false, indicando que o cadastro ainda não foi realizado.
$status_sucesso = false;


// Verifica se o formulário foi enviado pelo botão chamado "cadastrar".
// O isset() verifica se o botão foi enviado através do método POST.
if (isset($_POST["cadastrar"])) {


    // Recebe os dados preenchidos pelo administrador no formulário.
    // O $_POST permite acessar as informações enviadas pelos campos
    // que possuem os respectivos atributos name.

    // Recebe o nome que será utilizado no cadastro do produto.
    $nome = $_POST["nome"];

    // Recebe o preço informado pelo administrador.
    $preco = $_POST["preco"];


    // Verifica se o nome ou o preço estão vazios.
    // O operador || significa "ou", ou seja, se pelo menos um dos campos
    // estiver vazio, o cadastro não continuará.
    if ($nome == "" || $preco == "") {

        // Armazena uma mensagem informando que todos os campos
        // obrigatórios precisam ser preenchidos.
        $mensagem = "Preencha todos os campos.";


    // Verifica se foi enviado um arquivo pelo campo imagem
    // e se o upload ocorreu sem apresentar erros.
    //
    // O $_FILES é utilizado para acessar os arquivos enviados
    // através de um formulário HTML.
    //
    // O índice "error" informa se ocorreu algum problema no envio.
    // O valor 0 significa que o arquivo foi enviado sem erros.
    } elseif (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {


        // Guarda o nome original do arquivo de imagem enviado.
        // Esse nome será utilizado para identificar a imagem do produto.
        $imagem = $_FILES["imagem"]["name"];


        // Define o caminho completo onde a imagem será armazenada.
        // O __DIR__ representa o diretório atual deste arquivo PHP.
        // A imagem será salva dentro da pasta assets/imagens do projeto.
        $caminho = __DIR__ . "/../assets/imagens/" . $imagem;


        // move_uploaded_file() transfere o arquivo recebido pelo formulário
        // da pasta temporária do servidor para a pasta de imagens do projeto.
        //
        // O primeiro parâmetro indica onde o arquivo está temporariamente.
        // O segundo parâmetro indica onde ele deverá ser salvo.
        //
        // Se a transferência funcionar, o código entra no primeiro bloco.
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)) {


            // Chama a função cadastrarProduto(), localizada no arquivo functions.php.
            // Ela recebe a conexão com o banco de dados, o nome, o preço
            // e o nome da imagem para cadastrar o produto.
            //
            // O if verifica se a função retornou um resultado de sucesso.
            if (cadastrarProduto($conexao, $nome, $preco, $imagem)) {

                // Armazena uma mensagem informando que o produto foi cadastrado.
                $mensagem = "Produto cadastrado com sucesso!";

                // Altera o status para true, indicando que o cadastro
                // foi marcado como concluído.
                // Essa variável também será utilizada para esconder o formulário.
                $status_sucesso = true;


            } else {

                // Caso a função não consiga cadastrar o produto no banco,
                // armazena uma mensagem informando que ocorreu um erro.
                $mensagem = "Erro ao cadastrar o produto.";
            }


        } else {

            // Executado quando o arquivo não consegue ser transferido
            // da pasta temporária para a pasta de imagens do projeto.
            $mensagem = "Erro ao enviar a imagem.";
        }


    } else {

        // Executado quando nenhuma imagem foi enviada
        // ou quando ocorreu algum erro durante o upload.
        $mensagem = "Selecione uma imagem.";
    }
}

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
    <title>Cadastrar Produto - Petite Patisserie</title>


    <!-- Conecta a página ao arquivo CSS externo,
         responsável pela aparência e formatação dos elementos. -->
    <link rel="stylesheet" href="/petite_patisserie/assets/style.css">

</head>

<body>


<!-- Inclui o cabeçalho padrão do site.
     O __DIR__ facilita a localização do arquivo header.php
     em relação ao diretório atual. -->
<?php include(__DIR__ . "/../includes/header.php"); ?>


<!-- Define a área principal do conteúdo da página.
     A classe login-container aplica a formatação definida no CSS. -->
<main class="login-container">


    <!-- Cria um cartão para organizar os elementos da página,
         como o título, as mensagens e o formulário. -->
    <div class="login-card">


        <!-- Título que identifica a funcionalidade da página. -->
        <h2>Cadastrar Produto</h2>


        <!-- Verifica se a variável mensagem possui algum conteúdo.
             Se estiver vazia, nenhuma mensagem será exibida.
             Caso tenha sido preenchida, o resultado da operação será apresentado. -->
        <?php if (!empty($mensagem)): ?>


            <!-- Parágrafo utilizado para exibir a mensagem ao administrador.
                 A classe subtitle aplica a formatação definida no CSS. -->
            <p class="subtitle">

                <?php
                // O echo exibe o conteúdo da variável mensagem na página.
                // O htmlspecialchars() evita que caracteres especiais
                // sejam interpretados como código HTML pelo navegador.
                echo htmlspecialchars($mensagem);
                ?>

            </p>


        <!-- Encerra a condição responsável pela exibição da mensagem. -->
        <?php endif; ?>


        <!-- Verifica se o cadastro ainda não foi marcado como sucesso.
             O símbolo ! representa negação.
             Portanto, !$status_sucesso significa que o valor ainda é false.
             Enquanto não houver sucesso, o formulário continuará aparecendo. -->
        <?php if (!$status_sucesso): ?>


            <!-- Cria o formulário utilizado pelo administrador
                 para cadastrar um novo produto.

                 O method="POST" envia os dados para o PHP sem colocá-los na URL.

                 O enctype="multipart/form-data" permite enviar arquivos,
                 sendo necessário para que a imagem seja recebida pelo $_FILES. -->
            <form method="POST" enctype="multipart/form-data">


                <!-- Identifica o campo onde será informado o nome do produto. -->
                <label for="nome">Nome do produto:</label>

                <!-- Campo de texto utilizado para digitar o nome do produto.
                     O name="nome" permite que o PHP receba o valor pelo POST.
                     O required torna o preenchimento obrigatório. -->
                <input type="text" id="nome" name="nome" required>


                <!-- Identifica o campo destinado ao preço do produto. -->
                <label for="preco">Preço:</label>

                <!-- Campo numérico utilizado para informar o preço.
                     O type="number" permite inserir valores numéricos.
                     O step="0.01" permite valores com duas casas decimais,
                     como 12.50.
                     O name="preco" permite receber o valor pelo PHP.
                     O required exige o preenchimento desse campo. -->
                <input type="number" step="0.01" id="preco" name="preco" required>


                <!-- Identifica o campo utilizado para selecionar
                     a imagem que será associada ao produto. -->
                <label for="imagem">Imagem do produto:</label>


                <!-- Campo responsável por permitir a seleção de um arquivo.
                     O type="file" abre a seleção de arquivos do dispositivo.
                     O name="imagem" permite que o PHP acesse o arquivo
                     através de $_FILES["imagem"].

                     O accept="image/*" orienta o navegador a mostrar
                     arquivos de imagem disponíveis para seleção.

                     O required exige que uma imagem seja selecionada. -->
                <input type="file" id="imagem" name="imagem" accept="image/*" required>


                <!-- Botão responsável por enviar os dados do formulário.
                     O type="submit" realiza o envio.
                     O name="cadastrar" permite que o PHP identifique
                     o envio através de isset($_POST["cadastrar"]).
                     O value define o texto exibido no botão.
                     A classe btn-cute aplica a aparência definida no CSS. -->
                <input type="submit"
                       name="cadastrar"
                       value="Cadastrar"
                       class="btn-cute">


            <!-- Encerra o formulário. -->
            </form>


        <!-- Encerra a condição que controla a exibição do formulário. -->
        <?php endif; ?>


    </div>

</main>


<!-- Inclui o rodapé padrão do site, mantendo a estrutura visual
     compartilhada entre as páginas da Petite Patisserie. -->
<?php include(__DIR__ . "/../includes/footer.php"); ?>


</body>
</html>