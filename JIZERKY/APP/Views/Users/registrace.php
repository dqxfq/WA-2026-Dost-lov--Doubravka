<?php require_once '../APP/Views/layout/header.php'; ?>

<h1>Registrace</h1>

<div class="card">

<form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">

    <label for="username">Uživatelské jméno *</label><br>
    <input type="text" id="username" name="username" required>

    <br><br>

    <label for="email">E-mail *</label><br>
    <input type="email" id="email" name="email" required>

    <br><br>

    <label for="password">Heslo *</label><br>
    <input type="password" id="password" name="password" required>

    <br><br>

    <label for="password_confirm">Potvrzení hesla *</label><br>
    <input type="password" id="password_confirm" name="password_confirm" required>

    <br><br>

    <label for="first_name">Jméno</label><br>
    <input type="text" id="first_name" name="first_name">

    <br><br>

    <label for="last_name">Příjmení</label><br>
    <input type="text" id="last_name" name="last_name">

    <br><br>

    <label for="nickname">Přezdívka</label><br>
    <input type="text" id="nickname" name="nickname">

    <br><br>

    <button type="submit">Registrovat</button>

</form>

<p>
    Už máte účet?
    <a href="<?= BASE_URL ?>/index.php?url=auth/prihlaseni">Přihlásit se</a>
</p>

</div>

<?php require_once '../APP/Views/layout/footer.php'; ?>