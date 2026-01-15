<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1. Segurança: Logado?
if (!isset($_SESSION['logado'])) {
    header("Location: ../login.php");
    exit;
}

// Verifica se tem ID na URL (GET)
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// ---------------------------------------------------------
// CENÁRIO A: Processar o Formulário (POST - Atualizar)
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    // Checkbox html: se não estiver marcado, não envia nada. Precisamos forçar 0.
    $ativo = isset($_POST['ativo']) ? 1 : 0; 

    // Primeiro, buscamos a imagem atual no banco caso a gente precise mantê-la
    $stmt = $pdo->prepare("SELECT imagem FROM passeios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $atual = $stmt->fetch();
    
    $nomeImagem = $atual['imagem']; // Por padrão, mantém a velha

    // Se o usuário fez upload de uma NOVA imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $novoNome = uniqid() . "." . $ext;
        $destino = __DIR__ . '/../../public/uploads/' . $novoNome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $nomeImagem = $novoNome; // Atualiza a variável com o novo nome
            
            // Opcional: Deletar a imagem antiga do servidor para economizar espaço
            if ($atual['imagem'] && file_exists(__DIR__ . '/../../public/uploads/' . $atual['imagem'])) {
                unlink(__DIR__ . '/../../public/uploads/' . $atual['imagem']);
            }
        }
    }

    // Update SQL
    try {
        $sql = "UPDATE passeios SET titulo=:titulo, descricao=:descricao, preco=:preco, imagem=:imagem, ativo=:ativo WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':imagem', $nomeImagem);
        $stmt->bindValue(':ativo', $ativo);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        header("Location: dashboard.php?msg=atualizado");
        exit;

    } catch (PDOException $e) {
        die("Erro ao atualizar: " . $e->getMessage());
    }
}

// ---------------------------------------------------------
// CENÁRIO B: Carregar a Tela (GET - Preencher formulário)
// ---------------------------------------------------------
try {
    $stmt = $pdo->prepare("SELECT * FROM passeios WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $passeio = $stmt->fetch();

    if (!$passeio) {
        die("Passeio não encontrado.");
    }

    // Carrega a view passando os dados
    require_once __DIR__ . '/../../views/admin/editar-passeio.php';

} catch (PDOException $e) {
    die("Erro ao buscar dados.");
}
?>