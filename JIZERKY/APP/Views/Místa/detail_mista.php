<?php require_once '../APP/Views/layout/header.php'; ?>

<?php if ($misto): ?>

    <div class="card">

        <h1><?= htmlspecialchars($misto['nazev']) ?></h1>

        <?php if (!empty($misto['obrazek'])): ?>

            <img
                src="<?= BASE_URL ?>/images/<?= htmlspecialchars($misto['obrazek']) ?>"
                alt="<?= htmlspecialchars($misto['nazev']) ?>"
                style="max-width:300px;width:100%;height:auto;border-radius:15px;margin:0 auto 20px auto;display:block;"

        <?php endif; ?>

        <p><strong>Lokalita:</strong> <?= htmlspecialchars($misto['lokalita']) ?></p>

        <p><strong>Kategorie:</strong> <?= htmlspecialchars($misto['kategorie']) ?></p>

        <p>
            <strong>Popis:</strong><br>
            <?= nl2br(htmlspecialchars($misto['popis'])) ?>
        </p>

    </div>

    <div class="card">

        <h2>Komentáře</h2>

        <?php if (!empty($komentare)): ?>

            <?php foreach ($komentare as $komentar): ?>

                <div class="komentar">

                    <p>
                        <strong>
                            <?= htmlspecialchars($komentar['nickname'] ?: $komentar['username'] ?: 'Uživatel') ?>
                        </strong>
                    </p>

                    <p><?= nl2br(htmlspecialchars($komentar['obsah'])) ?></p>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=komenty/smazat/<?= $komentar['id'] ?>/<?= $misto['id'] ?>">
                            Smazat komentář
                        </a>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>Zatím zde nejsou žádné komentáře.</p>

        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>

            <h3>Přidat komentář</h3>

            <form action="<?= BASE_URL ?>/index.php?url=komenty/ulozit" method="post">

                <input type="hidden" name="misto_id" value="<?= $misto['id'] ?>">

                <textarea name="obsah" rows="5" required></textarea>

                <br><br>

                <button type="submit">Odeslat komentář</button>

            </form>

        <?php else: ?>

            <p>
                Pro přidání komentáře se musíte
                <a href="<?= BASE_URL ?>/index.php?url=auth/prihlaseni">přihlásit</a>.
            </p>

        <?php endif; ?>

    </div>

<?php else: ?>

    <div class="card">
        <h2>Místo nebylo nalezeno.</h2>
    </div>

<?php endif; ?>

<?php require_once '../APP/Views/layout/footer.php'; ?>