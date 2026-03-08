<?php
/**
 * Template da listagem de vagas.
 */
?>
    <main>
        <?php if (count($vagas) === 0): ?>
            <div class="card empty">
                Nenhuma vaga cadastrada ainda.
            </div>
        <?php else: ?>
            <?php foreach ($vagas as $vaga): ?>
                <?php
                $loc = (!empty($vaga['rua']) || !empty($vaga['cidade'])) ? texto_endereco($vaga['rua'] ?? '', $vaga['bairro'] ?? '', $vaga['cidade'] ?? '', $vaga['cep'] ?? '', $vaga['numero'] ?? '') : ($vaga['localizacao'] ?? '');
                $esc = (!empty($vaga['dia_inicio']) || !empty($vaga['horario_inicio'])) ? texto_escala_horario($vaga['dia_inicio'] ?? '', $vaga['dia_fim'] ?? '', $vaga['horario_inicio'] ?? '', $vaga['horario_fim'] ?? '') : ($vaga['escala_horario'] ?? '');
                $beneficiosLista = beneficios_para_rotulos($vaga['beneficios'] ?? '');
                ?>
                <article class="card">
                    <h2><?= htmlspecialchars($vaga['titulo']) ?></h2>
                    <div class="meta">
                        <?= htmlspecialchars($loc ?: '—') ?> ·
                        Publicada em <?= date('d/m/Y', strtotime($vaga['criado_em'])) ?>
                    </div>
                    <?php if (!empty($vaga['salario']) || !empty($vaga['regime']) || $esc !== ''): ?>
                    <div class="meta meta-extra">
                        <?php if (!empty($vaga['salario'])): ?>
                            <span>Salário: <?= htmlspecialchars(formatar_salario($vaga['salario'])) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($vaga['regime'])): ?>
                            <span>Regime: <?= htmlspecialchars($vaga['regime']) ?></span>
                        <?php endif; ?>
                        <?php if ($esc !== ''): ?>
                            <span>Horário: <?= htmlspecialchars($esc) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($beneficiosLista)): ?>
                    <div class="benefits-tags">
                        <?php foreach ($beneficiosLista as $rotulo): ?>
                            <span class="tag"><?= htmlspecialchars($rotulo) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="actions">
                        <a class="btn btn-secondary" href="detalhes_vaga.php?id=<?= $vaga['id'] ?>">Detalhes</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
