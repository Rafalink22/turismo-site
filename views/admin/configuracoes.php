<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1. Segurança
if (!isset($_SESSION['logado'])) {
    header("Location: ../login.php");
    exit;
}

// 2. Processar Atualização (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE site_config SET 
                nome_site = :nome,
                whatsapp = :zap,
                instagram = :insta,
                facebook = :face,
                email_contato = :email,
                endereco = :end
                WHERE id = 1"; // Sempre atualiza o ID 1
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $_POST['nome_site']);
        // Remove caracteres não numéricos do zap para salvar limpo
        $zapLimpo = preg_replace('/[^0-9]/', '', $_POST['whatsapp']);
        $stmt->bindValue(':zap', $zapLimpo);
        
        $stmt->bindValue(':insta', $_POST['instagram']);
        $stmt->bindValue(':face', $_POST['facebook']);
        $stmt->bindValue(':email', $_POST['email_contato']);
        $stmt->bindValue(':end', $_POST['endereco']);
        $stmt->execute();

        $msg = "Configurações atualizadas com sucesso!";
        
    } catch (PDOException $e) {
        $erro = "Erro ao atualizar: " . $e->getMessage();
    }
}

// 3. Buscar Configurações Atuais
$stmt = $pdo->query("SELECT * FROM site_config WHERE id = 1");
$config = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Configurações do Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand"><i class="bi bi-gear"></i> Configurações Gerais</span>
            <a href="dashboard.php" class="btn btn-sm btn-light text-primary fw-bold">Voltar ao Painel</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm" style="max-width: 800px; margin: 0 auto;">
            <div class="card-body">
                
                <?php if(isset($msg)): ?>
                    <div class="alert alert-success"><?= $msg ?></div>
                <?php endif; ?>

                <form method="POST">
                    <h5 class="mb-3 border-bottom pb-2">Informações Básicas</h5>
                    <div class="mb-3">
                        <label class="form-label">Nome do Site (SEO)</label>
                        <input type="text" name="nome_site" class="form-control" value="<?= htmlspecialchars($config['nome_site']) ?>">
                    </div>

                    <h5 class="mb-3 border-bottom pb-2 mt-4">Contatos & Redes Sociais</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-whatsapp text-success"></i> WhatsApp (com DDD)</label>
                            <input type="text" name="whatsapp" class="form-control" value="<?= htmlspecialchars($config['whatsapp']) ?>" placeholder="5582999...">
                            <div class="form-text">Apenas números (Ex: 558299998888)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> E-mail de Contato</label>
                            <input type="email" name="email_contato" class="form-control" value="<?= htmlspecialchars($config['email_contato']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-instagram text-danger"></i> Link do Instagram</label>
                            <input type="text" name="instagram" class="form-control" value="<?= htmlspecialchars($config['instagram']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-facebook text-primary"></i> Link do Facebook</label>
                            <input type="text" name="facebook" class="form-control" value="<?= htmlspecialchars($config['facebook']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endereço (Rodapé)</label>
                        <textarea name="endereco" class="form-control" rows="2"><?= htmlspecialchars($config['endereco']) ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Salvar Configurações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>