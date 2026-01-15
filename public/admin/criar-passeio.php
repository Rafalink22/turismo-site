<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1. Segurança
if (!isset($_SESSION['logado'])) {
    header("Location: ../login.php");
    exit;
}

// 2. Processamento do Formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    
    // Lógica de Upload de Imagem
    $nomeImagem = null;
    
    // Verifica se veio arquivo e se não teve erro
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        // Geramos um nome único (time + random) para evitar arquivos com mesmo nome
        $novoNome = uniqid() . "." . $extensao;
        
        $pastaDestino = __DIR__ . '/../../public/uploads/';
        
        // Cria a pasta se não existir
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        // Move do temporário do PHP para nossa pasta
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $pastaDestino . $novoNome)) {
            $nomeImagem = $novoNome;
        }
    }

    try {
        // Inserção no Banco
        $sql = "INSERT INTO passeios (titulo, descricao, preco, imagem, ativo) VALUES (:titulo, :descricao, :preco, :imagem, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':imagem', $nomeImagem);
        $stmt->execute();

        // Redireciona para o dashboard
        header("Location: dashboard.php?sucesso=1");
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// 3. Se não for POST, carrega o formulário (View)
require_once __DIR__ . '/../../views/admin/criar-passeio.php';
?>