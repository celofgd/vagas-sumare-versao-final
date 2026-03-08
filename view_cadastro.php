<?php
/**
 * Template da página de cadastro de usuário.
 */
?>
    <main class="main-narrow main-cadastro">
        <section class="card">
            <h2>Cadastro</h2>

            <?php if (!empty($erros)): ?>
                <div class="errors">
                    <?php foreach ($erros as $erro): ?>
                        <div>- <?= htmlspecialchars($erro) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="field">
                    <label for="name">Nome completo*</label>
                    <input type="text" id="name" name="name" required
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                </div>

                <div class="field">
                    <label for="email">E-mail (pode ser fictício)*</label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="field">
                    <label for="password">Senha* (mínimo 6 caracteres)</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="field">
                    <label for="password_confirm">Confirmar senha*</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>

                <div class="field">
                    <label>Tipo de conta*</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="role" value="recruiter"
                                   <?= (($_POST['role'] ?? '') === 'recruiter') ? 'checked' : '' ?>>
                            Recrutador (cria e gerencia vagas)
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="role" value="candidate"
                                   <?= (($_POST['role'] ?? '') === 'candidate') ? 'checked' : '' ?>>
                            Candidato (visualiza e se candidata)
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>

            <p class="link">
                Já tem uma conta? <a href="entrar.php">Entrar</a>
            </p>
        </section>
    </main>
