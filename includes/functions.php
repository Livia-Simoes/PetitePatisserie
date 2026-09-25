
<?php 
require_once __DIR__ . '/../database/connect.php';

function cadastrar ($conexao, $nome, $turma, $nasc, $ativo, $email) {
$sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email) 
        VALUES (:nome, :turma, :nasc, :ativo, :email)";

try {
    $stmt = $conexao->prepare($sql);

    $stmt->bindValue(":nome", $_POST['nome']);
    $stmt->bindValue(":turma", $_POST['turma']);
    $stmt->bindValue(":nasc", $_POST['nasc']);
    $stmt->bindValue(":ativo", $_POST['ativo']);
    $stmt->bindValue(":email", $_POST['email']);

    $stmt->execute();
    echo "Inserido com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

function apagar($conexao, $id){
    $sql = "DELETE FROM alunos WHERE id = :id";

try{
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    echo "usuário $id removido com sucesso!";
}catch (PDOException $e){
    echo "erro: " . $e->getMessage();
}
}

function relatorio($conexao){

$sql = "SELECT * FROM alunos ORDER BY id";
try {
$stmt = $conexao->prepare($sql);
$stmt->execute();

$alunos = $stmt->fetchALL (PDO::FETCH_ASSOC);

foreach ($alunos as $aluno){
    echo "ID: {$aluno['id']} <br>";
    echo "nome: {$aluno['nome']} <br>";
    echo "turma: {$aluno['turma']} <br>";
    echo "nasc: {$aluno['nasc']} <br>";
    echo "email: {$aluno['email']} <br>";
    echo "ativo: {$aluno['ativo']} <br>";
    echo "<hr>";
}
} catch (PDOException $e){
    echo "erro: ".$e->getMessage();
}
}

function atualizar($conexao, $id, $nome, $turma, $nasc, $ativo, $email){

$sql = "UPDATE alunos SET nome = :nome , turma = :turma , nasc = :nasc , ativo = :ativo , email = :email WHERE id = :id";
try {
    $stmt = $conexao->prepare($sql);

    $stmt->bindValue(":nome", $_POST['nome']);
    $stmt->bindValue(":id", $_POST['id']);
    $stmt->bindValue(":turma", $_POST['turma']);
    $stmt->bindValue(":nasc", $_POST['nasc']);
    $stmt->bindValue(":ativo", $_POST['ativo']);
    $stmt->bindValue(":email", $_POST['email']);

    $stmt->execute();
    echo "Aluno atualizado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

function consultar($conexao, $id){
    $sql = "SELECT nome, turma, nasc, ativo, email FROM alunos WHERE id = :id";

try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "aluno: {$aluno['nome']} <br>";
    echo "turma: {$aluno['turma']}<br>";
    echo "nasc: {$aluno['nasc']}<br>";
    echo "ativo: {$aluno['ativo']}<br>";
    echo "email: {$aluno['email']}<br>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

// Funções para login:
function cadastra_user ($conexao, $email, $senha) {
    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";

    try {
        $stmt = $conexao->prepare($sql);

       
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);

        $stmt->execute();
        echo "Usuário inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consulta_user($conexao, $email){
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
    return $usuarios;
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}
?>
</main>
    

