<?php require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>apagar aluno</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php';?>
    <h1>remover aluno</h1>
    <form action ="" method="post">
    <label for="id">ID: </label>
    <input type="number" name="id" id="id"> <br>
    <input type="submit" value="remover">
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    apagar($conexao, $_POST['id']);
}
?>
<?php include __DIR__ . '/../includes/footer.php';?>
</body>
</html>
