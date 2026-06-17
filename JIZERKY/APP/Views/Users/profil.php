<?php require_once '../APP/Views/layout/header.php'; ?>

<section class="hero">
    <h1>Můj profil</h1>
</section>

<div class="form-box">

    <form action="<?= BASE_URL ?>/index.php?url=auth/updateProfil" method="POST" autocomplete="off">

        <label for="nickname">Přezdívka</label>
        <input
            type="text"
            id="nickname"
            name="nickname"
            value="<?= htmlspecialchars($uzivatel['nickname'] ?? '') ?>">

        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($uzivatel['email'] ?? '') ?>"
            required>

        <label for="password">Nové heslo</label>
        <input
            type="password"
            id="password"
            name="password"
            value=""
            autocomplete="new-password"
            placeholder="Vyplňte jen pokud chcete změnit heslo">

        <label for="password_confirm">Potvrzení nového hesla</label>
        <input
            type="password"
            id="password_confirm"
            name="password_confirm"
            value=""
            autocomplete="new-password"
            placeholder="Zopakujte nové heslo">

        <button type="submit" class="nav-button">
            Uložit změny
        </button>

    </form>

</div>

<?php require_once '../APP/Views/layout/footer.php'; ?>