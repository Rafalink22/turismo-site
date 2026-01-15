<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Passeio - Turismo Vans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: 'textarea[name="descricao"]',
        height: 300,
        menubar: false,
        plugins: 'lists link',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist',
        branding: false
      });
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Passeio #<?= $passeio['id'] ?></h4>
            </div>
            <div class="card-body">
                
                <form action="editar-passeio.php?id=<?= $passeio['id'] ?>" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="id" value="<?= $passeio['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($passeio['titulo']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($passeio['descricao']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" value="<?= $passeio['preco'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagem Atual</label><br>
                        <?php if($passeio['imagem']): ?>
                            <img src="../../public/uploads/<?= htmlspecialchars($passeio['imagem']) ?>" width="150" class="img-thumbnail mb-2">
                        <?php endif; ?>
                        
                        <label class="form-label d-block text-muted small">Trocar Imagem (Deixe vazio para manter a atual)</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" <?= $passeio['ativo'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="ativo">Passeio Ativo (Visível no site)</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">Atualizar Dados</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>