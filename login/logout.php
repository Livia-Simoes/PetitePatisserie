
<?php

// Inicia ou retoma a sessão do usuário
session_start();

// Limpa todas as variáveis armazenadas na sessão
$_SESSION = array();

// Verifica se a sessão utiliza cookies
if (ini_get("session.use_cookies")) {

    // Obtém as configurações atuais do cookie da sessão
    $params = session_get_cookie_params();

    // Expira o cookie para removê-lo do navegador
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói os dados da sessão no servidor
session_destroy();

// Redireciona o usuário para a página inicial do site
header("Location: ../index.php");

// Encerra a execução do código após o redirecionamento
exit;

?>