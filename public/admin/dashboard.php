<?php
session_start();

// Importa a conexão com o banco
require_once __DIR__ . '/../../config/database.php';

// 1. SEGURANÇA
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: ../login.php?erro=2");
    exit;
}

// 2. BUSCAR DADOS
try {
    $stmt = $pdo->query("SELECT * FROM passeios ORDER BY id DESC");
    $passeios = $stmt->fetchAll();

    // --- LÓGICA DE ESTATÍSTICAS (Movida para o Controller) ---
    $totalPasseios = count($passeios);
    $totalAtivos   = 0;
    $totalInativos = 0;

    foreach ($passeios as $p) {
        if ($p['ativo'] == 1) {
            $totalAtivos++;
        } else {
            $totalInativos++;
        }
    }

} catch (PDOException $e) {
    $passeios = []; 
    $totalPasseios = 0;
    $totalAtivos = 0;
    $totalInativos = 0;
}

// 3. CARREGAR A TELA
require_once __DIR__ . '/../../views/admin/dashboard.php';
?>