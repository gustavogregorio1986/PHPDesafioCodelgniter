<h2>Bem-vindo, <?= $user->username ?> (Saldo: R$ <?= number_format($user->balance, 2, ',', '.') ?>)</h2>

<form method="post" action="<?= site_url('wallet/deposit') ?>">
    <input name="amount" type="number" placeholder="Valor do depósito" step="0.01" required>
    <button type="submit">Depositar</button>
</form>

<form method="post" action="<?= site_url('wallet/transfer') ?>">
    <input name="receiver_id" placeholder="ID do destinatário" required>
    <input name="amount" type="number" placeholder="Valor" step="0.01" required>
    <button type="submit">Transferir</button>
</form>

<h3>Transações:</h3>
<ul>
<?php foreach ($transactions as $txn): ?>
    <li><?= $txn->type ?> de R$<?= $txn->amount ?> | <?= $txn->status ?> |
        <a href="<?= site_url('wallet/reverse/'.$txn->id) ?>">Reverter</a></li>
<?php endforeach; ?>
</ul>

<a href="<?= site_url('auth/logout') ?>">Sair</a>