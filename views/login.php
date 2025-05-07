<form method="post" action="<?= site_url('auth/check_login') ?>">
    <input name="username" placeholder="Usuário" required>
    <input name="password" type="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>