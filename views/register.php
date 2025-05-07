<form method="post" action="<?= site_url('auth/save_register') ?>">
    <input name="username" placeholder="Usuário" required>
    <input name="password" type="password" placeholder="Senha" required>
    <button type="submit">Registrar</button>
</form>