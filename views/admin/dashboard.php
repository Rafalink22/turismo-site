<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - Turismo Vans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">
                <i class="bi bi-speedometer2"></i> Painel Administrativo
            </span>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Olá, <?= htmlspecialchars($_SESSION['user_nome'] ?? 'Admin') ?></span>
                <a href="../logout.php" class="btn btn-sm btn-light text-primary fw-bold">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Passeios</h5>
                        <p class="card-text display-4 fw-bold"><?= $totalPasseios ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ativos no Site</h5>
                        <p class="card-text display-4 fw-bold"><?= $totalAtivos ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ocultos / Inativos</h5>
                        <p class="card-text display-4 fw-bold"><?= $totalInativos ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Gerenciar Passeios</h3>
            <a href="criar-passeio.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Novo Passeio
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Título</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($passeios)): ?>
                            <?php foreach ($passeios as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>
                                    <?php if($p['imagem']): ?>
                                        <img src="../../public/uploads/<?= htmlspecialchars($p['imagem']) ?>" alt="img" width="50" height="40" style="object-fit:cover;">
                                    <?php else: ?>
                                        <i class="bi bi-image text-muted"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($p['titulo']) ?></td>
                                <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                <td>
                                    <?= $p['ativo'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?>
                                </td>
                                <td class="text-end">
                                    <a href="editar-passeio.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="deletar-passeio.php?id=<?= $p['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Tem certeza que deseja excluir este passeio?');" 
                                       title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">Nenhum passeio encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>