<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$isAdmin = isset($_SESSION['logado']) && $_SESSION['logado'] === true;

// Lógica de Caminho para Admin vs Site
$isInAdmin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
$basePath = $isInAdmin ? '../' : ''; 

// --- LÓGICA DE SEO (OPEN GRAPH) ---
// Define valores padrão caso a página (Controller) não tenha definido
$seoTitle = $seoTitle ?? $siteConfig['nome_site'];
$seoDesc  = $seoDesc  ?? 'Especialistas em turismo receptivo e transporte executivo em Alagoas. Conforto, segurança e pontualidade.';
// Nota: Em localhost, o WhatsApp NÃO mostra a imagem. Só funciona quando subir para um site real (.com.br)
$seoImage = $seoImage ?? 'http://' . $_SERVER['HTTP_HOST'] . '/edemaceio/models/img/logo.png'; 
$seoUrl   = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= htmlspecialchars($seoTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDesc) ?>">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $seoUrl ?>">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDesc) ?>">
    <meta property="og:image" content="<?= $seoImage ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoDesc) ?>">
    <meta name="twitter:image" content="<?= $seoImage ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="<?= $basePath ?>css/style.css">
</head>
<body>

    <?php if ($isAdmin): ?>
        <div class="bg-danger text-white py-2 px-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 1050; border-bottom: 2px solid #b02a37;">
            <small class="fw-bold"><i class="bi bi-shield-lock-fill"></i> MODO ADMIN</small>
            <div>
                <a href="<?= $basePath ?>admin/dashboard.php" class="btn btn-sm btn-light text-danger fw-bold me-2">Painel</a>
                <a href="<?= $basePath ?>admin/criar-passeio.php" class="btn btn-sm btn-outline-light fw-bold">Novo</a>
            </div>
        </div>
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-navbar-marine">
        <div class="container">
            <div class="logo-empresa">
                <img src="<?= $basePath ?>../models/img/logo.png" alt="Logo">
            </div>
            <a class="navbar-brand" href="<?= $basePath ?>index">É de Maceió</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= $basePath ?>index">Passeios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $basePath ?>sobre">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://wa.me/5582999999999">Contato</a></li>
                </ul>
            </div>
        </div>
    </nav>