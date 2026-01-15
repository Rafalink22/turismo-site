<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="bg-light py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($passeio['titulo']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        
        <div class="col-lg-8">
            
            <h1 class="fw-bold mb-4"><?= htmlspecialchars($passeio['titulo']) ?></h1>

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <div class="alert alert-warning d-flex align-items-center justify-content-between mb-4 shadow-sm" role="alert">
                    <div>
                        <i class="bi bi-gear-fill me-2"></i> <strong>Gerenciar este Passeio:</strong>
                    </div>
                    <div>
                        <a href="admin/editar-passeio.php?id=<?= $passeio['id'] ?>" class="btn btn-sm btn-dark me-2">
                            <i class="bi bi-pencil"></i> Editar Texto/Preço
                        </a>
                        
                        <a href="admin/galeria.php?id=<?= $passeio['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-images"></i> Gerenciar Fotos (Album)
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div id="carouselPasseio" class="carousel slide mb-5 shadow rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="3000">
                
                <div class="carousel-inner carousel-custom-height">
                    
                    <div class="carousel-item active">
                        <?php $imgPrincipal = $passeio['imagem'] ? 'uploads/' . $passeio['imagem'] : 'https://placehold.co/800x500?text=Capa'; ?>
                        <img src="<?= $imgPrincipal ?>" class="d-block" alt="Capa">
                    </div>

                    <?php if (!empty($galeria)): ?>
                        <?php foreach ($galeria as $foto): ?>
                            <div class="carousel-item">
                                <img src="uploads/<?= htmlspecialchars($foto) ?>" class="d-block" alt="Foto Extra">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPasseio" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 20px;"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselPasseio" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 20px;"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            <div class="mb-5">
                <h3 class="fw-bold mb-3"><i class="bi bi-file-text me-2"></i>Sobre o Passeio</h3>
                <div class="text-muted" style="line-height: 1.8; font-size: 1.1rem;">
                    <div class="descricao-rica">
                        <?= html_entity_decode($passeio['descricao']) ?>
                    </div>
                </div>
            </div>

            <div class="card bg-light border-0 p-4 mb-4">
                <h4 class="fw-bold mb-3">O que este passeio oferece?</h4>
                <div class="row">
                    <div class="col-md-6 mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Transporte Ida e Volta</div>
                    <div class="col-md-6 mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Guia Credenciado</div>
                    <div class="col-md-6 mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Seguro Passageiro</div>
                    <div class="col-md-6 mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Ar-condicionado</div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card shadow border-0 position-sticky" style="top: 20px; z-index: 1;">
                <div class="card-body p-4">
                    <p class="text-muted mb-1">Preço por pessoa</p>
                    <h2 class="text-primary fw-bold mb-4">R$ <?= number_format($passeio['preco'], 2, ',', '.') ?></h2>

                    <div class="d-grid gap-2">
                        <?php 
                            $msg = "Olá! Gostaria de reservar o passeio *" . $passeio['titulo'] . "*. Poderia me passar a disponibilidade?";
                            $linkZap = "https://wa.me/5582999999999?text=" . urlencode($msg);
                        ?>
                        <a href="<?= $linkZap ?>" target="_blank" class="btn whatsapp-btn w-100 btn-lg fw-bold">
                            <i class="bi bi-whatsapp"></i> Reservar Agora
                        </a>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-share"></i> Compartilhar
                        </button>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-shield-check fs-4 text-primary me-3"></i>
                        <div>
                            <small class="fw-bold d-block">Reserva Segura</small>
                            <small class="text-muted">Pagamento direto com a agência</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check fs-4 text-primary me-3"></i>
                        <div>
                            <small class="fw-bold d-block">Cancelamento Grátis</small>
                            <small class="text-muted">Até 24h antes do passeio</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>