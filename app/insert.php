<?php require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php' ;?>
    <main> 
        <h1>Cadastro de Aluno. </h1>
    <form action="" method="post">
        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome"><br>
        <label for="turma">Turma: </label>
        <input type="text" name="turma" id="turma"><br>
        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email"><br>
        <label for="nasc">Nascimento: </label>
        <input type="date" name="nasc" id="nasc"><br>
        <label for="ativo">Ativo: </label><br>
        <input type="radio" name="ativo" id="ativo" value="true">
        <label for="ativo">Sim </label>
        <input type="radio" name="ativo" id="ativo" value="false">
        <label for="ativo">Não </label>
        <input type="submit" value="Cadastrar">
        <input type="reset" value="Limpar">
    </form>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
    cadastrar($conexao, $_POST['nome'], $_POST['turma'], $_POST['turma'], $_POST['nasc'], $_POST['ativo'], $_POST['email']);}
    ?>
    <?php include __DIR__ . '/../includes/footer.php' ;?>
</body>
</html>


