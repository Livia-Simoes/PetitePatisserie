# Gestão de alunos
## mini sistema com crud HTML + CSS + PHP + postgres

### Descrição global
1. O sistema deve realizar as seguintes funções
• cadastrar os alunos
• deletar os alunos
• consultar os alunos 
• consultar alunos separados 
• atualizar o cadastro dos alunos 

### Tree das pastas
 documentacao.md
│   index.php
│   
├───app
│       delete.php
│       insert.php
│       select.php
│       select_w.php
│       update.php
│       
├───database
│       connect.php
│       
├───includes
│       footer.php
│       functions.php
│       header.php
│       
└───login
        cadastrar.php
        login.php
        logout.php
        verifica_user.php
        


### Objetivos
1. Relatório de alunos cadastrados.
1.2. foi criado um arquivo chamado functions.php, nele, criei um include que chama o arquivo connect do database
1.3. foi definido uma função chamada relatorio, nele, foi criado um sql que chama os dados da tabela e lista em ordem
1.3. foi utilizado o prepare e o execute para fazer a conexao através do parametro $conexao
1.4. foi criado uma variavel chamado alunos, e utilizado o codigo $stmt->fetchALL (PDO::FETCH_ASSOC) para armazenar todos os dados da tabela nessa variavel
1.5. foi utilizado o laço foreach para percorrer aluno por aluno e exibir suas informações 
1.6. foi criado um tratamento de erro, caso o dado inserido não seja o esperado
1.7. depois, foi criado um arquivo chamado select.php, onde foi usado o include para chamar o arquivo functions.php
1.8. depois, foi dado um titulo para a página, e então, usado o include novamente para chamar o arquivo de header e depois o de footer 

2. Consulta de aluno específico.
2.2. no arquivo functions.php, foi criado a função consultar, depois, feito a conexão com o $conexao e o $id do aluno
2.3. depois, foi criado o sql que seleciona apenas os argumentos especificos e usa o id para consultar o id exato do aluno 
2.4. foi utilizado o execute, prepare e bindparam para preparar o comando no banco e depois vincular a variavel id ao id da query, depois executar
2.5. foi utilizado o $stmt->fetch(PDO::FETCH_ASSOC) para retornar um id especifico
2.6. foi criado um tratamento de erro, caso o dado inserido não seja o esperado
2.7 depois, foi criado um arquivo chamado select_w.php, onde foi usando o include para chamar o arquivo functions.php 
2.8 depois, dado um titulo para a página, e então, usado o include novamente para chamar o arquivo header e o footer
2.9. depois, foi criado um formulário com método POST com um campo para digitar o id do aluno
2.10. depois, foi feita uma verificação com $_SERVER['REQUEST_METHOD'] == "POST" para saber se o formulário foi enviado
2.11. por fim, a função consultar() foi chamada passando a conexão e o id recebido, mostrando os dados do aluno na tela

3. Cadastrar novo aluno..
3.1. primeiro, foi usado o `require_once` para chamar o arquivo de conexão com o banco de dados (`connect.php`)
3.2. depois, foi criada a query SQL com o comando `INSERT INTO` para salvar os dados do aluno na tabela `alunos`
3.3. foram usados os parâmetros nomeados `:nome`, `:turma`, `:nasc`, `:ativo` e `:email` na instrução SQL
3.4. foi criado um bloco `try...catch` para tentar executar a inserção e capturar possíveis erros de banco de dados
3.5. usou-se o `$conexao->prepare()` para preparar a query SQL com segurança
3.6. depois, usou-se o `bindValue()` para associar cada valor direto na query preparada
3.7. no primeiro exemplo, os dados foram passados fixos manualmente no código
3.8. usou-se o `$stmt->execute()` para rodar o comando e inserir os dados no banco
3.9. exibiu-se a mensagem "Inserido com sucesso!" após a execução sem erros
3.10. no segundo exemplo, o código foi transformado em uma função chamada `cadastrar()` que recebe a conexão e os campos por parâmetro
3.11. dentro da função, o `bindValue()` passou a pegar os valores vindos dinamicamente do formulário através do `$_POST`


4. Excluir alunos.
4.1. primeiro, foi criada a estrutura HTML básica com a tag `<title>apagar</title>` e o título `<h1>remover aluno</h1>`
4.2. depois, foi criado um formulário com método POST contendo um input do tipo number para receber o id do aluno e um botão de submit
4.3. foi feita a verificação com `$_SERVER['REQUEST_METHOD'] == "POST"` para executar o código PHP apenas quando o formulário for enviado
4.4. dentro do bloco POST, usou-se o `require_once` para chamar o arquivo de conexão `connect.php`
4.5. foi criada a instrução SQL com `DELETE FROM alunos WHERE id = :id` para apagar o registro com o id correspondente
4.6. usou-se o bloco `try...catch` para tratar possíveis erros de banco de dados e o `$conexao->prepare()` para preparar o comando
4.7. o `$stmt->bindParam(":id", $id)` foi utilizado para vincular a variável do id ao parâmetro `:id` da query
4.8. usou-se o `$stmt->execute()` para apagar o aluno e exibiu-se a mensagem de sucesso na tela
4.9. por fim, o código de exclusão foi isolado dentro de uma função chamada `apagar($conexao, $id)`, facilitando sua reutilização no projeto

5. Atualizar cadastro do aluno.
5.1. no arquivo update_w.php, foi usado o require_once para chamar o arquivo functions.php e o arquivo verifica_user.php
5.2. depois, foi definida a estrutura basica do html e dado o titulo "Atualizar" para a pagina
5.3. depois, foi usado o include para chamar o arquivo header dentro da tag main
5.4. depois, foi criado o formulario usando o metodo POST para enviar os dados
5.5. foi criado um input do tipo number para o id do aluno ser inserido obrigatoriamente
5.6. foram criados inputs do tipo text para alterar o nome e a turma do aluno
5.7. foi criado um input do tipo email para atualizar o e-mail do aluno
5.8. foi criado um input do tipo date para alterar a data de nascimento
5.9. foram criados inputs do tipo radio para selecionar se o aluno esta ativo como true ou false
5.10. foram adicionados os botoes de submit para enviar a atualização e de reset para limpar os campos
5.11. depois, foi feita a verificação com $_SERVER['REQUEST_METHOD'] == "POST" para saber se o formulario foi enviado
5.12. por fim, a função atualizar() foi chamada passando a conexão e todos os dados recebidos via POST, e o include chamou o arquivo footer



 