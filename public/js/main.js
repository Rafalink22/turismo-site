document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Inicializa Tooltips do Bootstrap (opcional, mas bom para UX)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // 2. Confirmação global para botões de deletar
    // Procura qualquer link que tenha a classe 'confirm-delete'
    const deleteLinks = document.querySelectorAll('.confirm-delete');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Tem certeza que deseja realizar esta exclusão? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    });

});