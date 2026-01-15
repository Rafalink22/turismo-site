<footer class="bg-navbar-marine text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row">
                
                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">
                        <i class="bi bi-bus-front-fill me-2"></i> É de Maceió
                    </h5>
                    <p class="text-white-50 small">
                        Especialistas em turismo receptivo e transporte executivo em Alagoas. 
                        Conforto, segurança e pontualidade para você curtir o paraíso.
                    </p>
                    <div class="mt-3">
                        <a href="<?= htmlspecialchars($siteConfig['instagram']) ?>" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="<?= htmlspecialchars($siteConfig['facebook']) ?>" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="https://wa.me/<?= $siteConfig['whatsapp'] ?>" target="_blank" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Navegação</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= isset($basePath) ? $basePath : '' ?>index" class="footer-link">Início</a></li>
                        <li class="mb-2"><a href="<?= isset($basePath) ? $basePath : '' ?>index#passeios" class="footer-link">Nossos Passeios</a></li>
                        <li class="mb-2"><a href="<?= isset($basePath) ? $basePath : '' ?>sobre" class="footer-link">Sobre a Agência</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Fale Conosco</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2 text-warning"></i>
                            <?= htmlspecialchars($siteConfig['endereco']) ?>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill me-2 text-warning"></i>
                            <a href="mailto:<?= htmlspecialchars($siteConfig['email_contato']) ?>" class="text-white-50 text-decoration-none">
                                <?= htmlspecialchars($siteConfig['email_contato']) ?>
                            </a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-whatsapp me-2 text-warning"></i>
                            <?php 
                                // Formatação simples de máscara para visualização (opcional)
                                $zap = $siteConfig['whatsapp'];
                                // Se tiver 13 digitos (5582...), mostra +55 (82) ...
                                echo strlen($zap) > 10 ? '+' . substr($zap, 0, 2) . ' (' . substr($zap, 2, 2) . ') ' . substr($zap, 4, 5) . '-' . substr($zap, 9) : $zap;
                            ?>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-white-50">
                        &copy; <?= date('Y') ?> <?= htmlspecialchars($siteConfig['nome_site']) ?>. Todos os direitos reservados.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-white-50">
                        Desenvolvido por <strong>Bruno Rafael</strong>
                    </small>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="<?= isset($basePath) ? $basePath : '' ?>js/main.js"></script>
</html>