
<?php


// ==================================================
// PRODUTOS
// ==================================================


// Função responsável por listar todos os produtos cadastrados.
// Recebe a conexão com o banco de dados como parâmetro.
function listarProdutos($conexao){

    // Consulta todos os registros existentes na tabela produtos.
    $sql = "SELECT * FROM produtos";

    try{

        // Prepara o comando SQL para execução.
        $stmt = $conexao->prepare($sql);

        // Executa a consulta no banco de dados.
        $stmt->execute();

        // Recupera todos os produtos encontrados.
        // FETCH_ASSOC organiza os resultados em um array associativo,
        // permitindo acessar os campos pelo nome das colunas.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Exibe uma mensagem caso aconteça algum erro na consulta.
        echo "Erro ao buscar produtos.";

        // Retorna um array vazio caso não seja possível listar os produtos.
        return [];

    }
}


// Função responsável por pesquisar produtos pelo nome.
// Recebe a conexão com o banco e o texto digitado pelo usuário.
function buscarProdutos($conexao, $produto){

    // Consulta os produtos cujo nome contém o texto pesquisado.
    // ILIKE é utilizado no PostgreSQL para realizar pesquisas
    // sem diferenciar letras maiúsculas e minúsculas.
    $sql = "SELECT * FROM produtos WHERE nome ILIKE :produto";

    try{

        // Prepara o comando SQL para receber o termo pesquisado.
        $stmt = $conexao->prepare($sql);

        // Adiciona o símbolo % antes e depois do texto.
        // Isso permite encontrar nomes que contenham o termo pesquisado,
        // mesmo que ele esteja no início, no meio ou no final do nome.
        $pesquisa = "%" . $produto . "%";

        // Associa o texto pesquisado ao parâmetro :produto.
        $stmt->bindParam(":produto", $pesquisa);

        // Executa a consulta no banco de dados.
        $stmt->execute();

        // Retorna todos os produtos encontrados em um array associativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Exibe uma mensagem caso aconteça um erro na pesquisa.
        echo "Erro ao pesquisar os produtos.";

        // Retorna um array vazio caso a pesquisa falhe.
        return [];

    }
}


// Função responsável por cadastrar um novo produto.
// Recebe a conexão, o nome, o preço e o nome da imagem do produto.
function cadastrarProduto($conexao, $nome, $preco, $imagem){

    // Comando SQL responsável por inserir um novo produto na tabela.
    // Os parâmetros serão preenchidos com os valores recebidos pela função.
    $sql = "INSERT INTO produtos (nome, preco, imagem)
            VALUES (:nome, :preco, :imagem)";

    try{

        // Prepara o comando SQL para receber os dados do produto.
        $stmt = $conexao->prepare($sql);

        // Associa o nome do produto ao parâmetro :nome.
        $stmt->bindParam(":nome", $nome);

        // Associa o preço do produto ao parâmetro :preco.
        $stmt->bindParam(":preco", $preco);

        // Associa o nome do arquivo de imagem ao parâmetro :imagem.
        $stmt->bindParam(":imagem", $imagem);

        // Executa o comando e cadastra o produto no banco de dados.
        $stmt->execute();

        // Retorna true para indicar que o cadastro foi executado sem exceção.
        return true;

    }catch(PDOException $e){

        // Retorna false caso aconteça algum erro durante o cadastro.
        return false;

    }
}


// Função responsável por atualizar o nome e o preço de um produto.
// Recebe a conexão com o banco, o ID, o novo nome e o novo preço.
function atualizarProduto($conexao, $id, $nome, $preco){

    // Comando SQL que atualiza os campos nome e preco.
    // O WHERE identifica qual produto será atualizado pelo seu ID.
    $sql = "UPDATE produtos
            SET nome = :nome, preco = :preco
            WHERE id = :id";

    try{

        // Prepara o comando SQL de atualização.
        $stmt = $conexao->prepare($sql);

        // Executa a consulta enviando os valores correspondentes
        // aos parâmetros da instrução SQL.
        $stmt->execute([
            ':nome' => $nome,
            ':preco' => $preco,
            ':id' => $id
        ]);

        // Retorna true caso a execução não gere uma exceção.
        return true;

    }catch(PDOException $e){

        // Retorna false caso ocorra algum erro na atualização.
        return false;

    }
}


// Função responsável por excluir um produto pelo seu ID.
// Também remove primeiro as referências desse produto no carrinho.
function apagarProduto($conexao, $id){

    try{

        // Primeiro, remove os registros do carrinho que possuem
        // o ID do produto que será excluído.
        $sql = "DELETE FROM carrinho WHERE produto_id = :id";

        // Prepara o comando SQL.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do produto ao parâmetro :id.
        $stmt->bindParam(":id", $id);

        // Executa a exclusão dos registros do carrinho.
        $stmt->execute();


        // Depois de remover as referências do carrinho,
        // prepara o comando para excluir o produto da tabela produtos.
        $sql = "DELETE FROM produtos WHERE id = :id";

        // Prepara o comando SQL de exclusão do produto.
        $stmt = $conexao->prepare($sql);

        // Associa o ID ao parâmetro da consulta.
        $stmt->bindParam(":id", $id);

        // Executa a exclusão do produto.
        $stmt->execute();


        // Verifica se alguma linha foi afetada pela exclusão.
        // rowCount() informa quantas linhas foram alteradas ou removidas.
        if($stmt->rowCount() > 0){

            // Retorna true se o produto foi excluído.
            return true;

        }else{

            // Retorna false se nenhum produto foi encontrado para exclusão.
            return false;
        }

    }catch(PDOException $e){

        // Retorna false caso aconteça algum erro durante a exclusão.
        return false;

    }
}


// ==================================================
// USUÁRIOS
// ==================================================


// Função responsável por cadastrar um novo usuário.
// Recebe a conexão, o nome, o email, a senha e o tipo de usuário.
function cadastrarUsuario($conexao, $nome, $email, $senha, $tipo){

    // Comando SQL para inserir um novo registro na tabela usuarios.
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo)
            VALUES (:nome, :email, :senha, :tipo)";

    try{

        // Transforma a senha original em um hash antes de armazená-la.
        // password_hash() protege a senha, evitando guardar o texto original
        // diretamente no banco de dados.
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara o comando SQL para receber os dados do usuário.
        $stmt = $conexao->prepare($sql);

        // Associa o nome ao parâmetro :nome.
        $stmt->bindParam(":nome", $nome);

        // Associa o email ao parâmetro :email.
        $stmt->bindParam(":email", $email);

        // Associa o hash da senha ao parâmetro :senha.
        $stmt->bindParam(":senha", $senhaHash);

        // Associa o tipo de usuário ao parâmetro :tipo.
        // Esse campo identifica se o usuário é cliente ou administrador.
        $stmt->bindParam(":tipo", $tipo);

        // Executa o comando e cadastra o usuário no banco.
        $stmt->execute();

        // Exibe uma mensagem informando que o cadastro foi realizado.
        echo "Usuário cadastrado com sucesso!";

    }catch(PDOException $e){

        // Exibe uma mensagem caso ocorra algum erro no cadastro.
        echo "Erro ao cadastrar o usuário.";

    }
}


// Função responsável por atualizar os dados de um cliente.
// Recebe a conexão com o banco, o ID, o novo nome e o novo email.
function atualizarUsuario($conexao, $id, $nome, $email){

    // Comando SQL para atualizar o nome e o email do usuário.
    // A condição tipo = 'cliente' impede que essa consulta
    // atualize usuários que sejam administradores.
    $sql = "UPDATE usuarios
            SET nome = :nome,
                email = :email
            WHERE id = :id
            AND tipo = 'cliente'";

    try{

        // Prepara o comando SQL de atualização.
        $stmt = $conexao->prepare($sql);

        // Associa o novo nome ao parâmetro :nome.
        $stmt->bindParam(":nome", $nome);

        // Associa o novo email ao parâmetro :email.
        $stmt->bindParam(":email", $email);

        // Associa o ID do usuário ao parâmetro :id.
        $stmt->bindParam(":id", $id);

        // Executa a atualização dos dados do cliente.
        $stmt->execute();


        // Verifica se alguma linha foi alterada no banco de dados.
        if($stmt->rowCount() > 0){

            // Exibe uma mensagem informando que o usuário foi atualizado.
            echo "Usuário $id atualizado com sucesso!";

        }else{

            // Informa que nenhum cliente foi encontrado ou atualizado.
            $stmt->rowCount();
            echo "Cliente não encontrado.";

        }

    }catch(PDOException $e){

        // Exibe uma mensagem caso aconteça algum erro na atualização.
        echo "Erro ao atualizar o cliente.";

    }
}


// Função responsável por excluir um cliente pelo seu ID.
// Primeiro remove os itens do carrinho e depois exclui o usuário.
function apagarUsuario($conexao, $id){

    try{

        // Remove os registros do carrinho que pertencem ao cliente.
        $sql = "DELETE FROM carrinho WHERE usuario_id = :id";

        // Prepara o comando SQL.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do cliente ao parâmetro :id.
        $stmt->bindParam(":id", $id);

        // Executa a exclusão dos itens do carrinho.
        $stmt->execute();


        // Prepara o comando SQL para excluir o usuário.
        // A condição tipo = 'cliente' impede a exclusão de administradores.
        $sql = "DELETE FROM usuarios
                WHERE id = :id
                AND tipo = 'cliente'";

        // Prepara o comando de exclusão do usuário.
        $stmt = $conexao->prepare($sql);

        // Associa o ID ao parâmetro da consulta.
        $stmt->bindParam(":id", $id);

        // Executa a exclusão do cliente.
        $stmt->execute();


        // Verifica se algum registro foi excluído.
        if($stmt->rowCount() > 0){

            // Retorna true se o cliente foi excluído.
            return true;

        }else{

            // Retorna false se nenhum cliente foi encontrado.
            return false;
        }

    }catch(PDOException $e){

        // Retorna false caso aconteça algum erro durante a exclusão.
        return false;

    }
}


// ==================================================
// CARRINHO
// ==================================================


// Função responsável por adicionar um produto ao carrinho.
// Recebe a conexão, o ID do usuário, o ID do produto e a quantidade.
function adicionarCarrinho($conexao, $usuario_id, $produto_id, $quantidade){

    // Comando SQL para inserir um novo item na tabela carrinho.
    // São armazenados o usuário, o produto escolhido e a quantidade.
    $sql = "INSERT INTO carrinho
            (usuario_id, produto_id, quantidade)
            VALUES (:usuario_id, :produto_id, :quantidade)";

    try{

        // Prepara o comando SQL para receber os dados.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do usuário ao parâmetro :usuario_id.
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Associa o ID do produto ao parâmetro :produto_id.
        $stmt->bindParam(":produto_id", $produto_id);

        // Associa a quantidade ao parâmetro :quantidade.
        $stmt->bindParam(":quantidade", $quantidade);

        // Executa a inserção do produto no carrinho.
        $stmt->execute();

        // Exibe uma mensagem informando que o produto foi adicionado.
        echo "Produto adicionado ao carrinho!";

    }catch(PDOException $e){

        // Exibe uma mensagem caso aconteça algum erro ao adicionar o produto.
        echo "Erro ao adicionar o produto ao carrinho.";

    }
}


// Função responsável por listar os produtos do carrinho de um usuário.
// Recebe a conexão com o banco e o ID do usuário.
function listarCarrinho($conexao, $usuario_id){

    // Consulta os registros do carrinho e recupera também
    // as informações dos produtos relacionados.
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

        // Prepara o comando SQL para execução.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do usuário ao parâmetro :usuario_id.
        // Assim, a consulta retorna somente os produtos
        // que pertencem ao carrinho desse usuário.
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Executa a consulta no banco de dados.
        $stmt->execute();

        // Recupera todos os itens encontrados.
        // Os resultados são retornados em um array associativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){

        // Exibe uma mensagem caso ocorra um erro ao carregar o carrinho.
        // htmlspecialchars() protege a mensagem contra a interpretação de HTML.
        echo "Erro ao carregar o carrinho: "
            . htmlspecialchars($e->getMessage());

        // Retorna um array vazio caso a consulta não seja realizada.
        return [];

    }
}


// Função responsável por remover um item específico do carrinho.
// Recebe a conexão, o ID do item e o ID do usuário.
function apagarCarrinho($conexao, $id, $usuario_id){

    // Comando SQL para excluir um item do carrinho.
    // A exclusão depende de duas condições:
    // o ID do item e o ID do usuário ao qual ele pertence.
    $sql = "DELETE FROM carrinho
            WHERE id = :id
            AND usuario_id = :usuario_id";

    try{

        // Prepara o comando SQL de exclusão.
        $stmt = $conexao->prepare($sql);

        // Associa o ID do item ao parâmetro :id.
        $stmt->bindParam(":id", $id);

        // Associa o ID do usuário ao parâmetro :usuario_id.
        $stmt->bindParam(":usuario_id", $usuario_id);

        // Executa a exclusão do item do carrinho.
        $stmt->execute();


        // Verifica se algum registro foi removido.
        if($stmt->rowCount() > 0){

            // Exibe uma mensagem informando que o item foi removido.
            echo "Item removido do carrinho!";

        }else{

            // Informa que o item não foi encontrado no carrinho desse usuário.
            echo "Item não encontrado no carrinho.";

        }

    }catch(PDOException $e){

        // Exibe uma mensagem caso aconteça algum erro na exclusão.
        echo "Erro ao remover o item do carrinho.";

    }
}

?>
