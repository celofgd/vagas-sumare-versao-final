<?php
/**
 * Template da página de login.
 */
?>
    <main class="main-narrow main-login">
        <div class="login-brasao">
            <img src="img/brasao.png" alt="Brasão de Sumaré" class="login-brasao-img">
        </div>
        <section class="card">
            <h2>Entrar</h2>

            <?php if (isset($papelAlvo) && $papelAlvo === 'recruiter'): ?>
                <p class="hint">Faça login como <strong>recrutador</strong> para criar e gerenciar vagas.</p>
            <?php elseif (isset($papelAlvo) && $papelAlvo === 'candidate'): ?>
                <p class="hint">Faça login como <strong>candidato</strong> para visualizar e se candidatar às vagas.</p>
            <?php endif; ?>

            <?php if (!empty($erros)): ?>
                <div class="errors">
                    <?php foreach ($erros as $erro): ?>
                        <div>- <?= htmlspecialchars($erro) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($urlRedirecionamento ?? '') ?>">

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>

            <p class="link">
                Ainda não tem conta? <a href="cadastro.php">Registrar</a>
            </p>
        </section>
    </main>
