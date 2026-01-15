<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['logado']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

try {
    // Passo 1: Opcional - Buscar a imagem para deletar o arquivo físico
    $stmt = $pdo->prepare("SELECT imagem FROM passeios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $p = $stmt->fetch();

    if ($p && $p['imagem']) {
        $caminhoArquivo = __DIR__ . '/../../public/uploads/' . $p['imagem'];
        if (file_exists($caminhoArquivo)) {
            unlink($caminhoArquivo); // Deleta o arquivo da pasta
        }
    }

    // Passo 2: Deletar do Banco
    $stmt = $pdo->prepare("DELETE FROM passeios WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    header("Location: dashboard.php?msg=deletado");

} catch (PDOException $e) {
    die("Erro ao deletar.");
}
?>