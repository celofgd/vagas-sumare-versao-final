<?php
/**
 * Template da página de gerenciar vagas do recrutador.
 */
?>
    <main>
        <section class="card">
            <div class="top-actions">
                <h2 class="top-title">Vagas cadastradas</h2>
                <a href="criar_vaga.php" class="btn btn-primary">Cadastrar nova vaga</a>
            </div>

            <?php if (count($vagas) === 0): ?>
                <p>Nenhuma vaga cadastrada. Clique em "Cadastrar nova vaga" para criar a primeira.</p>
            <?php else: ?>
                <div class="jobs-table-wrap">
                <table class="jobs-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Empresa</th>
                            <th>Localização</th>
                            <th>Criada em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vagas as $vaga): ?>
                            <?php $loc = (!empty($vaga['rua']) || !empty($vaga['cidade'])) ? texto_endereco($vaga['rua'] ?? '', $vaga['bairro'] ?? '', $vaga['cidade'] ?? '', $vaga['cep'] ?? '', $vaga['numero'] ?? '') : ($vaga['localizacao'] ?? ''); ?>
                            <tr>
                                <td><?= htmlspecialchars($vaga['titulo']) ?></td>
                                <td><?= htmlspecialchars($vaga['empresa']) ?></td>
                                <td><?= htmlspecialchars($loc ?: '—') ?></td>
                                <td><?= date('d/m/Y', strtotime($vaga['criado_em'])) ?></td>
                                <td>
                                    <a class="btn btn-secondary" href="editar_vaga.php?edit_id=<?= $vaga['id'] ?>">Editar</a>
                                    <a class="btn btn-danger"
                                       href="gerenciar_vagas.php?delete_id=<?= $vaga['id'] ?>"
                                       onclick="return confirmarExclusao('<?= htmlspecialchars($vaga['titulo'], ENT_QUOTES) ?>');">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
