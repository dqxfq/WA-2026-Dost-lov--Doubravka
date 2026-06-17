<?php require_once '../APP/Views/layout/header.php'; ?>

<section class="hero">
    <h1>Místa v Jizerkách</h1>
</section>

<?php

$aktivniKategorie = $_GET['kategorie'] ?? '';

$filtry = [
    '' => 'Všechna místa',
    'Občerstvení' => 'Občerstvení',
    'Skály' => 'Skály',
    'Pěšina' => 'Pěšiny',
    'Vyhlídka' => 'Vyhlídky',
    'Vrchol' => 'Vrcholy',
    'Louka / mýtina' => 'Louky / mýtiny',
    'Vodopád / potok' => 'Vodopády'
];

if ($aktivniKategorie !== '') {
    $mista = array_filter($mista, function($misto) use ($aktivniKategorie) {
        return $misto['kategorie'] === $aktivniKategorie;
    });
}

?>

<div class="filter-panel">

    <?php foreach ($filtry as $hodnota => $nazev): ?>

        <a
            class="filter-button <?= $aktivniKategorie === $hodnota ? 'active' : '' ?>"
            href="<?= BASE_URL ?>/index.php<?= $hodnota !== '' ? '?kategorie=' . urlencode($hodnota) : '' ?>">

            <?= htmlspecialchars($nazev) ?>

        </a>

    <?php endforeach; ?>

</div>

<section class="places-list">

<?php if (!empty($mista)): ?>

    <?php foreach ($mista as $misto): ?>

        <article class="place-card">

            <div class="place-image">

                <?php if (!empty($misto['obrazek'])): ?>

                    <img
                        src="<?= BASE_URL ?>/images/<?= htmlspecialchars($misto['obrazek']) ?>"
                        alt="<?= htmlspecialchars($misto['nazev']) ?>">

                <?php else: ?>

                    <div class="no-image">
                        Bez obrázku
                    </div>

                <?php endif; ?>

            </div>

            <div class="place-content">

                <h2>
                    <?= htmlspecialchars($misto['nazev']) ?>
                </h2>

                <div class="meta">

                    <span>
                        Kategorie:
                        <?= htmlspecialchars($misto['kategorie'] ?: 'neuvedeno') ?>
                    </span>

                    <span>
                        Lokalita:
                        <?= htmlspecialchars($misto['lokalita'] ?: 'neuvedeno') ?>
                    </span>

                </div>

                <p class="short-text">
                    Přidal/a:
                    <?= htmlspecialchars($misto['autor'] ?? 'neznámý uživatel') ?>
                </p>

                <?php if (!empty($misto['popis'])): ?>

                    <p class="short-text">
                        <?= htmlspecialchars(
                            mb_strimwidth(
                                $misto['popis'],
                                0,
                                120,
                                '...'
                            )
                        ) ?>
                    </p>

                <?php endif; ?>

                <div class="akce">

                    <a href="<?= BASE_URL ?>/index.php?url=mista/detail/<?= $misto['id'] ?>">
                        Detail
                    </a>

                    <?php if (
                        isset($_SESSION['user_id']) &&
                        isset($misto['created_by']) &&
                        $misto['created_by'] == $_SESSION['user_id']
                    ): ?>

                        <a href="<?= BASE_URL ?>/index.php?url=mista/upravit/<?= $misto['id'] ?>">
                            Upravit
                        </a>

                        <a
                            href="<?= BASE_URL ?>/index.php?url=mista/smazat/<?= $misto['id'] ?>"
                            onclick="return confirm('Opravdu chcete místo smazat?')">

                            Smazat

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </article>

    <?php endforeach; ?>

<?php else: ?>

    <div class="empty-card">

        <p>
            Žádná místa v této kategorii zatím nejsou.
        </p>

    </div>

<?php endif; ?>

</section>

<?php require_once '../APP/Views/layout/footer.php'; ?>