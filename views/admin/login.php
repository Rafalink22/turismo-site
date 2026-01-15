<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Turismo Vans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border: none;
            border-radius: 15px;
        }
        .brand-logo {
            font-size: 3rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="card login-card shadow-lg p-4">
        <div class="card-body text-center">
            <div class="brand-logo mb-3">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h3 class="mb-4 fw-bold">Painel Admin</h3>
            
            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger text-start text-sm">
                    ⚠️ Usuário ou senha incorretos.
                </div>
            <?php endif; ?>

            <form action="auth.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required>
                    <label for="email">E-mail</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                    <label for="senha">Senha</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Entrar</button>
            </form>
            
            <div class="mt-3 text-muted">
                <small>Acesso restrito à equipe.</small>
            </div>
        </div>
    </div>

</body>
</html>