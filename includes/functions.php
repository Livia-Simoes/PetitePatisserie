
<?php

// --- PRODUTOS ---

// Função responsável por listar todos os produtos cadastrados no banco de dados
function listarProdutos($conexao){

    // Consulta todos os registros da tabela produtos
    $sql = "SELECT * FROM produtos";

    try{

        // Prepara e executa a consulta SQL
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        // Retorna todos os produtos encontrados em um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Exibe uma mensagem caso ocorra um erro e retorna uma lista vazia
        echo "Erro ao buscar produtos.";
        return [];

    }
}


// Função para pesquisar produtos pelo nome
function buscarProdutos($conexao, $produto){

    // Busca produtos cujos nomes contenham o termo informado
    // ILIKE permite pesquisar sem diferenciar letras maiúsculas e minúsculas no PostgreSQL
    $sql = "SELECT * FROM produtos WHERE nome ILIKE :produto";

    try{

        // Prepara a consulta SQL
        $stmt = $conexao->prepare($sql);

        // Adiciona % antes e depois para permitir correspondências parciais
        $pesquisa = "%" . $produto . "%";

        // Associa o termo pesquisado ao parâmetro da consulta
        $stmt->bindParam(":produto", $pesquisa);
        $stmt->execute();

        // Retorna todos os produtos encontrados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Informa que houve um erro na pesquisa
        echo "Erro ao pesquisar os produtos.";
        return [];

    }
}


// Função para cadastrar um novo produto
function cadastrarProduto($conexao, $nome, $preco, $imagem){

    // Comando SQL para inserir um produto na tabela
    $sql = "INSERT INTO produtos (nome, preco, imagem)
            VALUES (:nome, :preco, :imagem)";

    try{

        // Prepara a consulta de inserção
        $stmt = $conexao->prepare($sql);

        // Associa os dados do produto aos parâmetros da consulta
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);

        // Executa o cadastro no banco de dados
        $stmt->execute();

        // Retorna true para indicar que a operação foi executada
        return true;

    }catch(PDOException $e){

        // Retorna false se ocorrer um erro
        return false;

    }
}


// Função para atualizar o nome e o preço de um produto pelo ID
function atualizarProduto($conexao, $id, $nome, $preco){

    // Atualiza os campos nome e preco do produto correspondente ao ID
    $sql = "UPDATE produtos
            SET nome = :nome, preco = :preco
            WHERE id = :id";

    try{

        // Prepara a consulta de atualização
        $stmt = $conexao->prepare($sql);

        // Executa a consulta passando os valores dos campos
        $stmt->execute([
            ':nome' => $nome,
            ':preco' => $preco,
            ':id' => $id
        ]);

        // Retorna true se a execução não gerar uma exceção
        return true;

    }catch(PDOException $e){

        // Retorna false caso ocorra um erro
        return false;

    }
}


// Função para excluir um produto pelo ID
function apagarProduto($conexao, $id){

    try{

        // Remove primeiro as referências ao produto no carrinho
        $sql = "DELETE FROM carrinho WHERE produto_id = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Depois remove o produto da tabela produtos
        $sql = "DELETE FROM produtos WHERE id = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Verifica se algum produto foi excluído
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }catch(PDOException $e){

        // Retorna false se ocorrer um erro durante a exclusão
        return false;

    }
}


// --- USUÁRIOS ---

// Função para cadastrar um novo usuário
function cadastrarUsuario($conexao, $nome, $email, $senha, $tipo){

    // Comando SQL para inserir os dados na tabela usuarios
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo)
            VALUES (:nome, :email, :senha, :tipo)";

    try{

        // Gera um hash da senha antes de armazená-la no banco
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara a consulta de inserção
        $stmt = $conexao->prepare($sql);

        // Associa os dados do usuário à consulta
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senhaHash);
        $stmt->bindParam(":tipo", $tipo);

        // Executa o cadastro do usuário
        $stmt->execute();

        // Exibe uma mensagem de sucesso
        echo "Usuário cadastrado com sucesso!";

    }catch(PDOException $e){

        // Exibe uma mensagem caso o cadastro falhe
        echo "Erro ao cadastrar o usuário.";

    }
}


// Função para atualizar os dados de um usuário do tipo cliente
function atualizarUsuario($conexao, $id, $nome, $email){

    // Atualiza nome e email apenas se o usuário for um cliente
    $sql = "UPDATE usuarios
            SET nome = :nome,
                email = :email
            WHERE id = :id
            AND tipo = 'cliente'";

    try{

        // Prepara a consulta de atualização
        $stmt = $conexao->prepare($sql);

        // Associa os dados aos parâmetros da consulta
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);

        // Executa a atualização
        $stmt->execute();

        // Verifica se alguma linha foi alterada
        if($stmt->rowCount() > 0){

            echo "Usuário $id atualizado com sucesso!";

        }else{

            // Informa que nenhum cliente foi atualizado
            $stmt->rowCount();
            echo "Cliente não encontrado.";

        }

    }catch(PDOException $e){

        // Exibe uma mensagem caso ocorra um erro
        echo "Erro ao atualizar o cliente.";

    }
}


// Função para excluir um usuário do tipo cliente
function apagarUsuario($conexao, $id){

    try{

        // Remove os itens do carrinho pertencentes ao cliente
        $sql = "DELETE FROM carrinho WHERE usuario_id = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Exclui o usuário somente se ele for um cliente
        $sql = "DELETE FROM usuarios
                WHERE id = :id
                AND tipo = 'cliente'";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Verifica se o cliente foi excluído
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }catch(PDOException $e){

        // Retorna false se ocorrer um erro
        return false;

    }
}


// --- CARRINHO ---

// Função para adicionar um produto ao carrinho do usuário
function adicionarCarrinho($conexao, $usuario_id, $produto_id, $quantidade){

    // Insere o usuário, o produto e a quantidade na tabela carrinho
    $sql = "INSERT INTO carrinho
            (usuario_id, produto_id, quantidade)
            VALUES (:usuario_id, :produto_id, :quantidade)";

    try{

        // Prepara a consulta de inserção
        $stmt = $conexao->prepare($sql);

        // Associa os dados do carrinho aos parâmetros
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":produto_id", $produto_id);
        $stmt->bindParam(":quantidade", $quantidade);

        // Executa a inserção
        $stmt->execute();

        // Informa que o produto foi adicionado
        echo "Produto adicionado ao carrinho!";

    }catch(PDOException $e){

        // Informa que ocorreu um erro ao adicionar o produto
        echo "Erro ao adicionar o produto ao carrinho.";

    }
}


// Função para listar os produtos adicionados ao carrinho
function listarCarrinho($conexao, $usuario_id){

    // Consulta os itens do carrinho junto com os dados dos produtos
    $sql = "SELECT carrinho.id,
                   carrinho.usuario_id,
                   carrinho.produto_id,
                   carrinho.quantidade,
                   produtos.nome,
                   produtos.preco,
                   produtos.imagem
            FROM carrinho
            INNER JOIN produtos
            ON carrinho.produto_id = produtos.id
            WHERE carrinho.usuario_id = :usuario_id";

    try{

        // Prepara a consulta SQL
        $stmt = $conexao->prepare($sql);

        // Define qual usuário terá o carrinho consultado
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Executa a consulta
        $stmt->execute();

        // Retorna todos os itens do carrinho encontrados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Exibe uma mensagem de erro protegendo os caracteres especiais
        echo "Erro ao carregar o carrinho: "
            . htmlspecialchars($e->getMessage());

        // Retorna uma lista vazia caso ocorra um erro
        return [];

    }
}


// Função para remover um item específico do carrinho de um usuário
function apagarCarrinho($conexao, $id, $usuario_id){

    // Exclui o item somente se o ID e o usuário corresponderem
    $sql = "DELETE FROM carrinho
            WHERE id = :id
            AND usuario_id = :usuario_id";

    try{

        // Prepara a consulta de exclusão
        $stmt = $conexao->prepare($sql);

        // Associa o ID do item e o ID do usuário
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Executa a exclusão
        $stmt->execute();

        // Verifica se algum item foi removido
        if($stmt->rowCount() > 0){

            echo "Item removido do carrinho!";

        }else{

            // Informa que o item não foi encontrado para esse usuário
            echo "Item não encontrado no carrinho.";

        }

    }catch(PDOException $e){

        // Exibe uma mensagem caso a exclusão falhe
        echo "Erro ao remover o item do carrinho.";

    }
}

?>