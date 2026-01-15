<?php
// Arquivo: /public/reset_senha.php
require_once __DIR__ . '/../config/database.php';

$email = 'admin@agencia.com';
$nova_senha = '123456';

// 1. Gera o hash usando o algoritmo padrão do seu PHP atual
$novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

try {
    // 2. Atualiza no banco
    $stmt = $pdo->prepare("UPDATE admins SET senha = :senha WHERE email = :email");
    $stmt->bindValue(':senha', $novo_hash);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    echo "<h1>Sucesso!</h1>";
    echo "Senha redefinida.<br>";
    echo "<b>Email:</b> $email<br>";
    echo "<b>Nova Senha:</b> $nova_senha<br>";
    echo "<b>Novo Hash Gerado:</b> $novo_hash<br><br>";
    echo "<a href='login.php'>Clique aqui para logar</a>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>