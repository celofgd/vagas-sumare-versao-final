/**
 * Scripts comuns - alert de mensagem flash e confirmação de exclusão
 */
(function () {
    function initFlashMsg() {
        var el = document.getElementById('flash-msg');
        if (!el) return;
        var msg = el.getAttribute('data-msg');
        var redirect = el.getAttribute('data-redirect');
        if (msg) {
            alert(msg);
            if (redirect) {
                window.location.href = redirect;
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFlashMsg);
    } else {
        initFlashMsg();
    }
})();

function confirmarExclusao(titulo) {
    return confirm('Tem certeza que deseja excluir a vaga "' + titulo + '"?');
}
