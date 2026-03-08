<?php
/**
 * Template do formulário de edição de vaga.
 */
$beneficiosSelecionados = isset($vaga['beneficios']) && $vaga['beneficios'] !== '' ? explode(',', $vaga['beneficios']) : [];
?>
    <main>
        <section class="card">
            <h2>Editar vaga</h2>

            <?php if (!empty($erros)): ?>
                <div class="errors">
                    <?php foreach ($erros as $erro): ?>
                        <div>- <?= htmlspecialchars($erro) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="id" value="<?= (int) $vaga['id'] ?>">

                <div class="field">
                    <label for="titulo">Título da vaga*</label>
                    <input type="text" id="titulo" name="titulo" required maxlength="<?= VAGA_MAX_TITLE ?>" value="<?= htmlspecialchars($vaga['titulo'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="empresa">Empresa*</label>
                    <input type="text" id="empresa" name="empresa" required maxlength="<?= VAGA_MAX_COMPANY ?>" value="<?= htmlspecialchars($vaga['empresa'] ?? '') ?>">
                </div>
                <div class="field">
                    <label class="checkbox-label">
                        <input type="checkbox" id="nao_possui_endereco" name="nao_possui_endereco" value="1" <?= !empty($vaga['nao_possui_endereco']) ? 'checked' : '' ?>>
                        Não possuo endereço
                    </label>
                </div>
                <div id="bloco-endereco" class="bloco-endereco">
                    <div class="field">
                        <label for="rua">Rua*</label>
                        <input type="text" id="rua" name="rua" required maxlength="<?= VAGA_MAX_RUA ?>" value="<?= htmlspecialchars($vaga['rua'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="field">
                            <label for="bairro">Bairro*</label>
                            <input type="text" id="bairro" name="bairro" required maxlength="<?= VAGA_MAX_BAIRRO ?>" value="<?= htmlspecialchars($vaga['bairro'] ?? '') ?>">
                        </div>
                        <div class="field">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" maxlength="<?= VAGA_MAX_NUMERO ?>" placeholder="Ex: 123 ou 123-A" value="<?= htmlspecialchars($vaga['numero'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label for="cidade">Cidade*</label>
                        <input type="text" id="cidade" name="cidade" required maxlength="<?= VAGA_MAX_CIDADE ?>" value="<?= htmlspecialchars($vaga['cidade'] ?? '') ?>">
                    </div>
                    <div class="field">
                        <label for="cep">CEP*</label>
                        <input type="text" id="cep" name="cep" required maxlength="<?= VAGA_MAX_CEP ?>" placeholder="00000-000" value="<?= htmlspecialchars($vaga['cep'] ?? '') ?>">
                    </div>
                </div>
                <div class="field">
                    <label for="salario">Salário*</label>
                    <input type="text" id="salario" name="salario" required maxlength="<?= VAGA_MAX_SALARY ?>" placeholder="Ex: 5.000,00 ou 5.000" value="<?= htmlspecialchars($vaga['salario'] ?? '') ?>">
                </div>
                <div class="field">
                    <label>Regime</label>
                    <div class="radio-group">
                        <?php $regimeAtual = $vaga['regime'] ?? ''; ?>
                        <label class="radio-label"><input type="radio" name="regime" value="CLT" <?= $regimeAtual === 'CLT' ? 'checked' : '' ?>> CLT</label>
                        <label class="radio-label"><input type="radio" name="regime" value="CNPJ" <?= $regimeAtual === 'CNPJ' ? 'checked' : '' ?>> CNPJ</label>
                        <label class="radio-label"><input type="radio" name="regime" value="Freelance" <?= $regimeAtual === 'Freelance' ? 'checked' : '' ?>> Freelance</label>
                    </div>
                </div>
                <div class="field">
                    <label>Escala e horário*</label>
                    <div class="field-row">
                        <div class="field">
                            <label for="dia_inicio" class="sublabel">Dia início*</label>
                            <select id="dia_inicio" name="dia_inicio" required>
                                <option value="">— Selecione —</option>
                                <?php foreach ($DIAS_SEMANA as $valor => $rotulo): ?>
                                <option value="<?= htmlspecialchars($valor) ?>" <?= ($vaga['dia_inicio'] ?? '') === $valor ? 'selected' : '' ?>><?= htmlspecialchars($rotulo) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="dia_fim" class="sublabel">Dia fim*</label>
                            <select id="dia_fim" name="dia_fim" required>
                                <option value="">— Selecione —</option>
                                <?php foreach ($DIAS_SEMANA as $valor => $rotulo): ?>
                                <option value="<?= htmlspecialchars($valor) ?>" <?= ($vaga['dia_fim'] ?? '') === $valor ? 'selected' : '' ?>><?= htmlspecialchars($rotulo) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field">
                            <label for="horario_inicio" class="sublabel">Horário início*</label>
                            <select id="horario_inicio" name="horario_inicio" required>
                                <option value="">— Selecione —</option>
                                <?php foreach ($HORARIOS as $h): ?>
                                <option value="<?= htmlspecialchars($h) ?>" <?= ($vaga['horario_inicio'] ?? '') === $h ? 'selected' : '' ?>><?= htmlspecialchars($h) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="horario_fim" class="sublabel">Horário fim*</label>
                            <select id="horario_fim" name="horario_fim" required>
                                <option value="">— Selecione —</option>
                                <?php foreach ($HORARIOS as $h): ?>
                                <option value="<?= htmlspecialchars($h) ?>" <?= ($vaga['horario_fim'] ?? '') === $h ? 'selected' : '' ?>><?= htmlspecialchars($h) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Benefícios</label>
                    <div class="checkbox-group">
                        <?php foreach ($BENEFICIOS_OPCOES as $valor => $rotulo): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="beneficios[]" value="<?= htmlspecialchars($valor) ?>" <?= in_array($valor, $beneficiosSelecionados, true) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($rotulo) ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="field">
                    <label for="meio_contato">Contato*</label>
                    <input type="text" id="meio_contato" name="meio_contato" required maxlength="<?= VAGA_MAX_MEIO_CONTATO ?>" placeholder="Ex: e-mail, telefone, WhatsApp" value="<?= htmlspecialchars($vaga['meio_contato'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="descricao">Descrição da vaga*</label>
                    <textarea id="descricao" name="descricao" required maxlength="<?= VAGA_MAX_DESCRIPTION ?>"><?= htmlspecialchars($vaga['descricao'] ?? '') ?></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    <a href="gerenciar_vagas.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </section>
    </main>
    <script src="js/mascaras_vaga.js"></script>
