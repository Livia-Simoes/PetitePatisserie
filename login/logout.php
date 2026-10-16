
<?php

// Inicia uma nova sessão ou retoma a sessão já existente do usuário.
// É necessário iniciar a sessão para conseguir acessar suas informações.
session_start();


// Limpa todas as variáveis armazenadas na sessão.
// Isso remove informações como nome, email, tipo de usuário e ID.
$_SESSION = array();


// Verifica se a sessão está configurada para utilizar cookies.
// Os cookies armazenam informações da sessão no navegador.
if (ini_get("session.use_cookies")) {

    // Obtém as configurações atuais do cookie da sessão,
    // como caminho, domínio e opções de segurança.
    $params = session_get_cookie_params();


    // Expira o cookie da sessão para removê-lo do navegador.
    // O tempo negativo indica que o cookie deve ser considerado expirado.
    setcookie(
        session_name(),       // Obtém o nome do cookie da sessão.
        '',                   // Define o valor do cookie como vazio.
        time() - 42000,       // Define uma data de expiração no passado.
        $params["path"],      // Mantém o caminho configurado para o cookie.
        $params["domain"],    // Mantém o domínio configurado.
        $params["secure"],    // Mantém a configuração de conexão segura.
        $params["httponly"]   // Mantém a proteção contra acesso via JavaScript.
    );

}


// Destrói os dados da sessão armazenados no servidor.
// Depois desse comando, a sessão atual deixa de existir.
session_destroy();


// Redireciona o usuário para a página inicial do site.
header("Location: ../index.php");


// Encerra a execução do código após o redirecionamento.
// Impede que outros comandos sejam executados.
exit;

?>
