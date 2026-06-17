<?php require_once '../APP/Views/layout/header.php'; ?>

<h1>Přihlášení</h1>

<div class="card">

<form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">

    <label for="email">E-mail</label><br>
    <input type="email" id="email" name="email" required>

    <br><br>

    <label for="password">Heslo</label><br>
    <input type="password" id="password" name="password" required>

    <br><br>

    <button type="submit">Přihlásit se</button>

</form>

<p>
    Nemáte účet?
    <a href="<?= BASE_URL ?>/index.php?url=auth/registrace">Registrovat se</a>
</p>

</div>

<?php require_once '../APP/Views/layout/footer.php'; ?>