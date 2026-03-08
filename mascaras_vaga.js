/**
 * Máscaras para CEP e Salário nos formulários de vaga.
 * CEP: apenas dígitos, insere hífen após o 5º (00000-000).
 * Salário: formata com ponto para milhares e vírgula para decimais (máx. 12 caracteres).
 */
(function () {
    function aplicarMascaraCep(input) {
        input.addEventListener('input', function () {
            var v = this.value.replace(/\D/g, '');
            if (v.length > 8) v = v.slice(0, 8);
            if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
            this.value = v;
        });
    }

    function aplicarMascaraSalario(input) {
        var maxChars = 12;

        input.addEventListener('input', function () {
            var v = this.value.replace(/\s/g, '');
            var commaIdx = v.indexOf(',');
            var intPart = (commaIdx >= 0 ? v.slice(0, commaIdx) : v).replace(/\D/g, '').slice(0, 7);
            var decPart = (commaIdx >= 0 ? v.slice(commaIdx + 1) : '').replace(/\D/g, '').slice(0, 2);
            var formattedInt = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            var result = formattedInt + (decPart.length > 0 ? ',' + decPart : '');
            if (result.length > maxChars) result = result.slice(0, maxChars);
            this.value = result;
        });
    }

    function toggleCamposEndereco(semEndereco) {
        var ids = ['rua', 'bairro', 'numero', 'cidade', 'cep'];
        var bloco = document.getElementById('bloco-endereco');
        ids.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                el.disabled = semEndereco;
                el.required = !semEndereco;
                if (semEndereco) el.value = '';
            }
        });
        if (bloco) bloco.style.opacity = semEndereco ? '0.5' : '1';
    }

    function initSemEndereco() {
        var cb = document.getElementById('nao_possui_endereco');
        if (!cb) return;
        toggleCamposEndereco(cb.checked);
        cb.addEventListener('change', function () {
            toggleCamposEndereco(cb.checked);
        });
    }

    function init() {
        var cep = document.getElementById('cep');
        var salario = document.getElementById('salario');
        if (cep) {
            aplicarMascaraCep(cep);
            if (cep.value) cep.dispatchEvent(new Event('input'));
        }
        if (salario) {
            aplicarMascaraSalario(salario);
            if (salario.value) salario.dispatchEvent(new Event('input'));
        }
        initSemEndereco();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
