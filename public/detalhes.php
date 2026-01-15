<?php
require_once __DIR__ . '/../config/database.php';

// 1. Validação de Segurança
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index"); // Redireciona para index (sem .php)
    exit;
}

$id = (int)$_GET['id'];

try {
    // 2. Busca os dados
    $stmt = $pdo->prepare("SELECT * FROM passeios WHERE id = :id AND ativo = 1");
    $stmt->execute([':id' => $id]);
    $passeio = $stmt->fetch();

    if (!$passeio) {
        die("Passeio não encontrado ou inativo.");
    }

    // 3. Busca a Galeria
    $stmt = $pdo->prepare("SELECT imagem FROM fotos_passeio WHERE passeio_id = :id");
    $stmt->execute([':id' => $id]);
    $galeria = $stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    die("Erro no banco de dados.");
}

// --- PREPARAÇÃO DO SEO (NOVO) ---
$seoTitle = $passeio['titulo'] . " - É de Maceió Turismo";

// Pega os primeiros 140 caracteres da descrição e remove tags HTML
$seoDesc = substr(strip_tags($passeio['descricao']), 0, 140) . "...";

// Monta a URL da imagem. Se tiver foto, usa ela. Se não, usa a logo.
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$baseImg = "/edemaceio/public/uploads/"; // Ajuste conforme sua pasta real

if ($passeio['imagem']) {
    $seoImage = $protocol . "://" . $host . $baseImg . $passeio['imagem'];
}

// Carrega a View
require_once __DIR__ . '/../views/site/detalhes.php';
?>