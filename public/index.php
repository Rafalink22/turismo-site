<?php
// 1. Inicia sessão (necessário para verificar se é admin)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// --- CONFIGURAÇÃO DA PAGINAÇÃO ---
$itensPorPagina = 6; // Quantos cards aparecem por vez
// Valida se a página é um número inteiro, senão assume 1
$paginaAtual = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT) ?? 1;
// Calcula onde começa a busca no banco (Página 1 começa no 0, Página 2 no 6...)
$offset = ($paginaAtual - 1) * $itensPorPagina;

// --- FILTRO DE BUSCA ---
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_SPECIAL_CHARS);

try {
    // =================================================================
    // PASSO 1: Descobrir o TOTAL de registros (para a paginação funcionar)
    // =================================================================
    if ($busca) {
        // Correção do Erro HY093: Usamos :busca1 e :busca2 porque não podemos 
        // repetir o mesmo nome de parâmetro quando PDO::ATTR_EMULATE_PREPARES é false.
        $sqlCount = "SELECT COUNT(*) FROM passeios WHERE ativo = 1 AND (titulo LIKE :busca1 OR descricao LIKE :busca2)";
        $stmtCount = $pdo->prepare($sqlCount);
        $stmtCount->bindValue(':busca1', '%' . $busca . '%');
        $stmtCount->bindValue(':busca2', '%' . $busca . '%');
    } else {
        $sqlCount = "SELECT COUNT(*) FROM passeios WHERE ativo = 1";
        $stmtCount = $pdo->prepare($sqlCount);
    }
    
    $stmtCount->execute();
    $totalPasseios = $stmtCount->fetchColumn();
    
    // Calcula quantas páginas teremos (arredonda para cima)
    $totalPaginas = ceil($totalPasseios / $itensPorPagina); 

    // =================================================================
    // PASSO 2: Buscar os itens da página atual
    // =================================================================
    if ($busca) {
        // Query de Busca com Paginação
        $sql = "SELECT * FROM passeios 
                WHERE ativo = 1 AND (titulo LIKE :busca1 OR descricao LIKE :busca2) 
                ORDER BY id DESC 
                LIMIT :limite OFFSET :offset";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca1', '%' . $busca . '%');
        $stmt->bindValue(':busca2', '%' . $busca . '%');
    } else {
        // Query Padrão com Paginação
        $sql = "SELECT * FROM passeios 
                WHERE ativo = 1 
                ORDER BY id DESC 
                LIMIT :limite OFFSET :offset";
        
        // CORREÇÃO: Removemos o $pdo->query() que causava erro aqui
        $stmt = $pdo->prepare($sql);
    }

    // Bind dos parâmetros de paginação (Obrigatório passar como INTEIRO)
    $stmt->bindValue(':limite', $itensPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $passeios = $stmt->fetchAll();
    
    // Define o título da página para o Header
    $tituloPagina = $busca ? "Busca: " . $busca : "Home - Melhores Destinos";

} catch (PDOException $e) {
    // Em produção, não mostramos o erro técnico ($e->getMessage()) para o usuário
    die("Erro ao carregar os passeios. Por favor, tente novamente.");
}

// Carrega o cabeçalho HTML
require_once __DIR__ . '/../views/partials/header.php';
?>

<header class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Descubra lugares incríveis</h1>
        <p class="lead mb-4">Conforto, segurança e as melhores rotas para sua viagem.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="index" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white">
                    <input type="text" name="busca" class="form-control border-0 py-3 ps-4" 
                           placeholder="Para onde você quer ir? (Ex: Maragogi)" 
                           value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>"
                           style="box-shadow: none;"> 
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-0">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</header>

<main class="container my-5" id="passeios">
    <h2 class="text-center mb-4">Nossos Passeios</h2>
    
    <div class="row">
        <?php if (count($passeios) > 0): ?>
            <?php foreach ($passeios as $passeio): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm position-relative">
                        
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                            <a href="admin/editar-passeio.php?id=<?= $passeio['id'] ?>" class="admin-edit-btn text-warning" title="Editar este passeio">
                                <i class="bi bi-pencil-fill fs-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php 
                            $imgSrc = $passeio['imagem'] ? 'uploads/' . $passeio['imagem'] : 'https://placehold.co/600x400?text=Sem+Foto';
                        ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" class="card-img-top" alt="<?= htmlspecialchars($passeio['titulo']) ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="detalhes?id=<?= $passeio['id'] ?>" class="text-decoration-none text-dark stretched-link">
                                    <?= htmlspecialchars($passeio['titulo']) ?>
                                </a>
                            </h5>
                            
                            <p class="card-text flex-grow-1 text-muted">
                                <?= htmlspecialchars(substr($passeio['descricao'], 0, 100)) ?>...
                            </p>
                            
                            <h4 class="text-primary mb-3">
                                R$ <?= number_format($passeio['preco'], 2, ',', '.') ?>
                            </h4>
                            
                            <?php 
                                $msg = "Olá! Vi o passeio *" . $passeio['titulo'] . "* no site e gostaria de mais informações.";
                                $linkZap = "https://wa.me/5582999999999?text=" . urlencode($msg);
                            ?>
                            
                            <a href="<?= $linkZap ?>" target="_blank" class="btn whatsapp-btn w-100" style="position: relative; z-index: 2;">
                                <i class="bi bi-whatsapp"></i> Reservar Agora
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            
            <div class="col-12 text-center py-5">
                <i class="bi bi-geo-alt fs-1 text-muted mb-3 d-block"></i>
                
                <?php if ($busca): ?>
                    <h3>Ops! Não encontramos nada para "<?= htmlspecialchars($busca) ?>"</h3>
                    <p class="text-muted">Tente buscar por outro termo ou veja todos os nossos roteiros.</p>
                    <a href="index" class="btn btn-outline-primary mt-2">Limpar Busca</a>
                <?php else: ?>
                    <h3>Nenhum passeio cadastrado ainda.</h3>
                    <p class="text-muted">Em breve novidades incríveis por aqui!</p>
                <?php endif; ?>
            
            </div>

        <?php endif; ?>
    </div>

    <?php if ($totalPaginas > 1): ?>
    <nav aria-label="Navegação de páginas" class="mt-5">
        <ul class="pagination justify-content-center">
            
            <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?><?= $busca ? '&busca='.$busca : '' ?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= ($paginaAtual == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?><?= $busca ? '&busca='.$busca : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?><?= $busca ? '&busca='.$busca : '' ?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            
        </ul>
    </nav>
    <?php endif; ?>
</main>

<?php 
// 3. Incluo o rodapé
require_once __DIR__ . '/../views/partials/footer.php'; 
?>