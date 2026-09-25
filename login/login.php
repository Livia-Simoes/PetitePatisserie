<?php 
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($email && $senha) {
       $usuarios = consulta_user($conexao, $_POST['email']);
        if($usuarios['email'] == $_POST['email'] && $usuarios['senha'] == $_POST ['senha']){
            session_start();
            $_SESSION['id'] = $usuarios['id'];
            header("Location: /mini_sistema/index.php");
        exit();
        } else {
            echo "usuário ou senha inválidos.";
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main>
        <h1>Faça login para continuar</h1>
        <form action="" method="post">
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required><br>

            <input type="submit" value="entrar">
            <input type="reset" value="Limpar">
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>