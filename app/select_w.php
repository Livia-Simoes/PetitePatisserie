
<?php require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>consultar</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php';?>
    <h1>consultar aluno</h1>
    <form action ="" method="post">
    <label for="id">ID: </label>
    <input type="number" name="id" id="id" placeholder="insira um ID para consultar" required> <br>
    <input type="submit" value="consultar">
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    consultar($conexao, $_POST['id']);
}
?>
<?php include __DIR__ . '/../includes/footer.php';?>
</body>
</html>
