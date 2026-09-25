<?php 
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($email && $senha) {
        cadastra_user($conexao, $email, $senha);
        header("Location: mini_sistema/index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main>
        <h1> Cadastre-se no sistema </h1>
        <form action="" method="post">
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required><br>

            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>