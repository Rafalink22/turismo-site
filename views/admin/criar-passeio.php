<head>
    <meta charset="UTF-8">
    <title>Novo Passeio - Turismo Vans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
      tinymce.init({
        selector: 'textarea[name="descricao"]', // Seleciona o campo descrição
        height: 300,
        menubar: false,
        plugins: 'lists link',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist',
        branding: false // Remove a logo do TinyMCE
      });
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Cadastrar Novo Passeio</h4>
            </div>
            <div class="card-body">
                <form action="criar-passeio.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label">Título do Passeio</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ex: Praia do Gunga">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="4" required placeholder="Detalhes do roteiro..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto de Capa</label>
                            <input type="file" name="imagem" class="form-control" accept="image/*" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Salvar Passeio</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>