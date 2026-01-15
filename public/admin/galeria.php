<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1. SEGURANÇA: Apenas admin logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: ../login.php");
    exit;
}

// 2. VALIDAÇÃO: Precisamos saber DE QUAL passeio estamos falando
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$passeio_id = (int)$_GET['id'];

// Busca info do passeio só para mostrar o título na tela
$stmt = $pdo->prepare("SELECT titulo FROM passeios WHERE id = :id");
$stmt->execute([':id' => $passeio_id]);
$passeio = $stmt->fetch();

if (!$passeio) {
    die("Passeio não encontrado.");
}

// =========================================================
// LÓGICA DE UPLOAD (POST)
// =========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fotos'])) {
    
    $fotos = $_FILES['fotos'];
    $pastaDestino = __DIR__ . '/../../public/uploads/';
    
    // O PHP entrega o array de arquivos "invertido" quando é múltiplo.
    // Precisamos iterar pelos índices numéricos.
    for ($i = 0; $i < count($fotos['name']); $i++) {
        
        // Verifica se houve erro neste arquivo específico e se tem nome
        if ($fotos['error'][$i] === 0 && !empty($fotos['name'][$i])) {
            
            $extensao = pathinfo($fotos['name'][$i], PATHINFO_EXTENSION);
            $novoNome = uniqid() . '-' . $i . "." . $extensao; // Adicionei o indice $i para evitar colisão no mesmo segundo
            
            if (move_uploaded_file($fotos['tmp_name'][$i], $pastaDestino . $novoNome)) {
                
                // Sucesso no upload? Salva no banco vinculando ao ID do passeio
                $stmt = $pdo->prepare("INSERT INTO fotos_passeio (passeio_id, imagem) VALUES (:pid, :img)");
                $stmt->execute([
                    ':pid' => $passeio_id,
                    ':img' => $novoNome
                ]);
            }
        }
    }
    
    // Refresh na página para mostrar as fotos novas
    header("Location: galeria.php?id=$passeio_id&msg=sucesso");
    exit;
}

// =========================================================
// LÓGICA DE DELETAR FOTO (GET com acao=deletar)
// =========================================================
if (isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['foto_id'])) {
    
    $foto_id = (int)$_GET['foto_id'];
    
    // 1. Buscar o nome do arquivo para deletar da pasta
    $stmt = $pdo->prepare("SELECT imagem FROM fotos_passeio WHERE id = :fid AND passeio_id = :pid");
    $stmt->execute([':fid' => $foto_id, ':pid' => $passeio_id]);
    $fotoAlvo = $stmt->fetch();
    
    if ($fotoAlvo) {
        // Deleta arquivo físico
        $caminho = __DIR__ . '/../../public/uploads/' . $fotoAlvo['imagem'];
        if (file_exists($caminho)) {
            unlink($caminho);
        }
        
        // Deleta do banco
        $stmt = $pdo->prepare("DELETE FROM fotos_passeio WHERE id = :fid");
        $stmt->execute([':fid' => $foto_id]);
    }
    
    header("Location: galeria.php?id=$passeio_id&msg=deletado");
    exit;
}

// =========================================================
// BUSCAR FOTOS EXISTENTES PARA EXIBIR
// =========================================================
$stmt = $pdo->prepare("SELECT * FROM fotos_passeio WHERE passeio_id = :id ORDER BY id DESC");
$stmt->execute([':id' => $passeio_id]);
$galeria = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Galeria - <?= htmlspecialchars($passeio['titulo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .foto-container {
            position: relative;
            height: 200px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }
        .foto-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-delete {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .foto-container:hover .btn-delete {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Galeria de Fotos</h2>
                <p class="text-muted">Passeio: <strong><?= htmlspecialchars($passeio['titulo']) ?></strong></p>
            </div>
            <div>
                <a href="../detalhes.php?id=<?= $passeio_id ?>" class="btn btn-outline-primary" target="_blank">
                    <i class="bi bi-eye"></i> Ver no Site
                </a>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h5 class="card-title mb-3">Adicionar Novas Fotos</h5>
                
                <form method="POST" enctype="multipart/form-data" class="row align-items-end">
                    <div class="col-md-9">
                        <label class="form-label">Selecione uma ou mais imagens</label>
                        <input type="file" name="fotos[]" class="form-control" multiple accept="image/*" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cloud-upload"></i> Enviar Fotos
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <h5 class="mb-3">Fotos Cadastradas (<?= count($galeria) ?>)</h5>
        
        <?php if (count($galeria) > 0): ?>
            <div class="row">
                <?php foreach ($galeria as $foto): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="foto-container shadow-sm">
                            <img src="../../public/uploads/<?= htmlspecialchars($foto['imagem']) ?>" alt="Foto">
                            
                            <a href="galeria.php?id=<?= $passeio_id ?>&acao=deletar&foto_id=<?= $foto['id'] ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Tem certeza que deseja apagar essa foto?');"
                               title="Excluir">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Nenhuma foto extra cadastrada neste álbum ainda. A foto de capa é gerenciada na edição principal.
            </div>
        <?php endif; ?>

    </div>

</body>
</html>