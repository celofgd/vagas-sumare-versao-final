<?php
/**
 * Template da página de detalhes de uma vaga.
 */
$loc = (!empty($vaga['rua']) || !empty($vaga['cidade'])) ? texto_endereco($vaga['rua'] ?? '', $vaga['bairro'] ?? '', $vaga['cidade'] ?? '', $vaga['cep'] ?? '', $vaga['numero'] ?? '') : ($vaga['localizacao'] ?? '');
$esc = (!empty($vaga['dia_inicio']) || !empty($vaga['horario_inicio'])) ? texto_escala_horario($vaga['dia_inicio'] ?? '', $vaga['dia_fim'] ?? '', $vaga['horario_inicio'] ?? '', $vaga['horario_fim'] ?? '') : ($vaga['escala_horario'] ?? '');
$beneficiosLista = beneficios_para_rotulos($vaga['beneficios'] ?? '');
?>
    <main class="main-medium">
        <article class="card">
            <h2><?= htmlspecialchars($vaga['titulo']) ?></h2>
            <div class="meta">
                <?= htmlspecialchars($vaga['empresa']) ?> ·
                <?= htmlspecialchars($loc ?: '—') ?> ·
                Publicada em <?= date('d/m/Y', strtotime($vaga['criado_em'])) ?>
            </div>
            <?php if (!empty($vaga['salario'])): ?>
            <div class="detail-row"><strong>Salário:</strong> <?= htmlspecialchars(formatar_salario($vaga['salario'])) ?></div>
            <?php endif; ?>
            <?php if (!empty($vaga['regime'])): ?>
            <div class="detail-row"><strong>Regime:</strong> <?= htmlspecialchars($vaga['regime']) ?></div>
            <?php endif; ?>
            <?php if ($esc !== ''): ?>
            <div class="detail-row"><strong>Escala e horário:</strong> <?= htmlspecialchars($esc) ?></div>
            <?php endif; ?>
            <?php if (!empty($beneficiosLista)): ?>
            <div class="detail-row">
                <strong>Benefícios:</strong>
                <ul class="benefits-list">
                    <?php foreach ($beneficiosLista as $rotulo): ?>
                        <li><?= htmlspecialchars($rotulo) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php if (!empty($vaga['meio_contato'])): ?>
            <div class="detail-row"><strong>Contato:</strong> <?= nl2br(htmlspecialchars($vaga['meio_contato'])) ?></div>
            <?php endif; ?>
            <div class="description">
                <?= nl2br(htmlspecialchars($vaga['descricao'])) ?>
            </div>
        </article>
    </main>
