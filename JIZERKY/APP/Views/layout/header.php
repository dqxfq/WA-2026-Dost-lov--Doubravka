<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Jizerský průvodce</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styly.css">
</head>
<body>

<nav class="topbar">

    <div class="brand">

        <a href="<?= BASE_URL ?>/index.php" class="brand-link">

            <img
                src="<?= BASE_URL ?>/images/logo.png"
                alt="Logo Jizerského průvodce"
                class="brand-logo">

            <span>Jizerský průvodce</span>

        </a>

    </div>

    <div class="nav-links">

        <a href="<?= BASE_URL ?>/index.php">Seznam míst</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>/index.php?url=mista/pridani" class="nav-button">
                + Přidat nové místo
            </a>

            <span class="user-pill">
                Přihlášen/a: <?= htmlspecialchars($_SESSION['user_name']) ?>
            </span>

            <a href="<?= BASE_URL ?>/index.php?url=auth/profil">
                Můj profil
            </a>

            <a href="<?= BASE_URL ?>/index.php?url=auth/logout">
                Odhlásit se
            </a>

        <?php else: ?>

            <a href="<?= BASE_URL ?>/index.php?url=auth/prihlaseni">
                Přihlásit se
            </a>

            <a href="<?= BASE_URL ?>/index.php?url=auth/registrace" class="nav-button">
                Registrovat se
            </a>

        <?php endif; ?>

    </div>

</nav>

<main class="container">