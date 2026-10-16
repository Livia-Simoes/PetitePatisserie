<?php

// Configuração do endereço IP do servidor onde o banco de dados PostgreSQL está hospedado
$host = "192.168.10.56";

// Nome do banco de dados da aplicação
$dbname = "petite_patisserie";

// Usuário padrão do banco de dados PostgreSQL
$user = "petitepatisserie";

// Senha de acesso ao banco de dados
$pass = "23120920";

try {

    // Instancia a conexão com o banco de dados PostgreSQL via driver PDO ('pgsql')
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );

} catch (PDOException $e) {

    // Caso ocorra alguma falha na conexão, captura a exceção e exibe a mensagem de erro
    echo "Erro: " . $e->getMessage();

}

?>