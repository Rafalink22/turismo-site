<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verifica se os dados chegaram via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitização básica (embora Prepared Statements já resolvam SQL Injection)
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha']; // Senha não se sanitiza, pois pode ter caracteres especiais

    try {
        // 1. Buscar o usuário pelo email
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM admins WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        // 2. Verificar se o usuário existe E se a senha bate com o hash
        if ($user && password_verify($senha, $user['senha'])) {
            
            // SEGURANÇA: Regenerar o ID da sessão para evitar roubo de sessão
            session_regenerate_id(true);

            // Armazenar dados na sessão (apenas o necessário)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['logado'] = true;

            // Redirecionar para o Dashboard (que criaremos a seguir)
            header("Location: admin/dashboard.php");
            exit;

        } else {
            // Falha: Redireciona de volta com erro (sem dizer se foi senha ou email)
            header("Location: login.php?erro=1");
            exit;
        }

    } catch (PDOException $e) {
        // Em produção, logaríamos o erro em arquivo
        die("Erro no servidor.");
    }
} else {
    // Se tentar acessar o arquivo direto sem POST, joga para o login
    header("Location: login.php");
    exit;
}
?>