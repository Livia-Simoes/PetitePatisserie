# Gestão de alunos
## mini sistema com crud HTML + CSS + PHP + postgres

### Descrição global
1. O sistema deve realizar as seguintes funções: <br>
   * cadastrar os alunos <br>
   * deletar os alunos <br>
   * consultar os alunos <br>
   * consultar alunos separados <br>
   * atualizar o cadastro dos alunos 

### Árvore de Pastas
```text
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
```

## Objetivos
### 1. Relatório de alunos cadastrados.
1.1. foi criado um arquivo chamado functions.php, nele, criei um include que chama o arquivo connect do database <br>
1.2. foi definida uma função chamada relatorio, nela, foi criado um sql que chama os dados da tabela e lista em ordem <br>
1.3. foi utilizado o prepare e o execute para fazer a conexão através do parâmetro $conexao <br>
1.4. foi criada uma variável chamada alunos, e utilizado o código `$stmt->fetchAll(PDO::FETCH_ASSOC)` para armazenar todos os dados da tabela nessa variável <br>
1.5. foi utilizado o laço foreach para percorrer aluno por aluno e exibir suas informações <br>
1.6. foi criado um tratamento de erro, caso ocorra uma falha na busca dos dados <br>
1.7. depois, foi criado um arquivo chamado select.php, onde foi usado o include para chamar o arquivo functions.php <br>
1.8. depois, foi dado um título para a página, e então, usado o include novamente para chamar o arquivo de header e depois o de footer

### 2. Consulta de aluno específico.
2.1. no arquivo functions.php, foi criada a função consultar, depois, feita a conexão com o $conexao e o$id do aluno <br>
2.2. depois, foi criado o sql que seleciona apenas os argumentos específicos e usa o id para consultar o id exato do aluno <br>
2.3. foi utilizado o execute, prepare e bindparam para preparar o comando no banco e depois vincular a variável id ao id da query, depois executar <br>
2.4. foi utilizado o `$stmt->fetch(PDO::FETCH_ASSOC)` para retornar um id específico <br>
2.5. foi criado um tratamento de erro, caso o dado inserido não seja o esperado <br>
2.6. depois, foi criado um arquivo chamado select_w.php, onde foi usado o include para chamar o arquivo functions.php <br>
2.7. depois, foi dado um título para a página, e então, usado o include novamente para chamar o arquivo header e o footer <br>
2.8. depois, foi criado um formulário com método POST com um campo para digitar o id do aluno <br>
2.9. depois, foi feita uma verificação com `$_SERVER['REQUEST_METHOD'] == "POST"` para saber se o formulário foi enviado <br>
2.10. por fim, a função consultar() foi chamada passando a conexão e o id recebido, mostrando os dados do aluno na tela

### 3. Cadastrar novo aluno.
3.1. primeiro, foi usado o `require_once` para chamar o arquivo de conexão com o banco de dados (`connect.php`) <br>
3.2. depois, foi criada a query SQL com o comando `INSERT INTO` para salvar os dados do aluno na tabela `alunos` <br>
3.3. foram usados os parâmetros nomeados `:nome`, `:turma`, `:nasc`, `:ativo` e `:email` na instrução SQL <br>
3.4. foi criado um bloco `try...catch` para tentar executar a inserção e capturar possíveis erros de banco de dados <br>
3.5. usou-se o `$conexao->prepare()` para preparar a query SQL com segurança <br>
3.6. depois, usou-se o `bindValue()` para associar cada valor direto na query preparada <br>
3.7. no primeiro exemplo, os dados foram passados fixos manualmente no código <br>
3.8. usou-se o `$stmt->execute()` para rodar o comando e inserir os dados no banco <br>
3.9. exibiu-se a mensagem "Inserido com sucesso!" após a execução sem erros <br>
3.10. no segundo exemplo, o código foi transformado em uma função chamada `cadastrar()` que recebe a conexão e os campos por parâmetro <br>
3.11. dentro da função, o `bindValue()` passou a pegar os valores vindos dinamicamente do formulário através do `$_POST`

### 4. Excluir alunos.
4.1. primeiro, foi criada a estrutura HTML básica com a tag `<title>apagar</title>` e o título `<h1>remover aluno</h1>` <br>
4.2. depois, foi criado um formulário com método POST contendo um input do tipo number para receber o id do aluno e um botão de submit <br>
4.3. foi feita a verificação com `$_SERVER['REQUEST_METHOD'] == "POST"` para executar o código PHP apenas quando o formulário for enviado <br>
4.4. dentro do bloco POST, usou-se o `require_once` para chamar o arquivo de conexão `connect.php` <br>
4.5. foi criada a instrução SQL com `DELETE FROM alunos WHERE id = :id` para apagar o registro com o id correspondente <br>
4.6. usou-se o bloco `try...catch` para tratar possíveis erros de banco de dados e o `$conexao->prepare()` para preparar o comando <br>
4.7. o `$stmt->bindParam(":id", $id)` foi utilizado para vincular a variável do id ao parâmetro `:id` da query <br>
4.8. usou-se o `$stmt->execute()` para apagar o aluno e exibiu-se a mensagem de sucesso na tela <br>
4.9. por fim, o código de exclusão foi isolado dentro de uma função chamada `apagar($conexao, $id)`, facilitando sua reutilização no projeto

### 5. Atualizar cadastro do aluno.
5.1. no arquivo update_w.php, foi usado o require_once para chamar o arquivo functions.php e o arquivo verifica_user.php <br>
5.2. depois, foi definida a estrutura basica do html e dado o titulo "Atualizar" para a pagina <br>
5.3. depois, foi usado o include para chamar o arquivo header dentro da tag main <br>
5.4. depois, foi criado o formulario usando o metodo POST para enviar os dados <br>
5.5. foi criado um input do tipo number para o id do aluno ser inserido obrigatoriamente <br>
5.6. foram criados inputs do tipo text para alterar o nome e a turma do aluno <br>
5.7. foi criado um input do tipo email para atualizar o e-mail do aluno <br>
5.8. foi criado um input do tipo date para alterar a data de nascimento <br>
5.9. foram criados inputs do tipo radio para selecionar se o aluno esta ativo como true ou false <br>
5.10. foram adicionados os botoes de submit para enviar a atualização e de reset para limpar os campos <br>
5.11. depois, foi feita a verificação com `$_SERVER['REQUEST_METHOD'] == "POST"` para saber se o formulario foi enviado <br>
5.12. por fim, a função atualizar() foi chamada passando a conexão e todos os dados recebidos via POST, e o include chamou o arquivo footer
