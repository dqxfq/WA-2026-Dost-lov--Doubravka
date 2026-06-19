<?php require_once '../APP/Views/layout/header.php'; ?> // horní část stránky
// data jsem přišl z contrlleru míst, udělej z nich html, které se zobrazí v prohlížeči, tedy vytvoř pohled pro zobrazení všech míst

<section class="hero"> //section je samostatný blok, který se dá stylovat v css
    <h1>Místa v Jizerkách</h1>
</section> 

<?php

// načtení kategorie z URL, pokud je tam, jinak prázdný řetězec ($_GET['kategorie'] hodnoty z url adresy)
$aktivniKategorie = $_GET['kategorie'] ?? '';

// pole pro filtry, kde klíč je hodnota kategorie v databázi a hodnota je název kategorie, která se zobrazí na webu
$filtry = [
    '' => 'Všechna místa',
    'Občerstvení' => 'Občerstvení', // v databázi ej uložené obč a já chci na webu taky obč
    'Skály' => 'Skály', //kdyz filtruju skaly chci vsechyn skaly
    'Pěšina' => 'Pěšiny',
    'Vyhlídka' => 'Vyhlídky',
    'Vrchol' => 'Vrcholy',
    'Louka / mýtina' => 'Louky / mýtiny',
    'Vodopád / potok' => 'Vodopády'
];

if ($aktivniKategorie !== '') { // pokud je v url adrese nějaká kategorie, tak se filtruje podle ní, jinak se zobrazí všechna místa
    $mista = array_filter($mista, function($misto) use ($aktivniKategorie) { //projde všechna místa a zjistuje jestli odpovídá
        return $misto['kategorie'] === $aktivniKategorie; //jestli shoduje kategorie místa s kategorií z url adresy, pokud ano tak se místo zobrazí, jinak ne
    });
}

?> // konec php ted půjde zase o html, protože se to bude zobrazovat v prohlížeči, tedy vytvoř pohled pro zobrazení všech míst

<div class="filter-panel">

    //udělám klikací políčko pro každou z kategorií, které jsou v poli $filtry, a když kliknu na kategorii, tak se zobrazí jen místa z té kategorie, tedy vytvoř pohled pro zobrazení všech míst
    <?php foreach ($filtry as $hodnota => $nazev): ?> //projde všechny filtry a vytvoří pro ně html, tedy vytvoř pohled pro zobrazení všech míst
    // porjdi akždou aktegorii a vytvoř por ni odkaz, který když kliknu tak se zobrazí jen místa z té kategorie, tedy vytvoř pohled pro zobrazení všech míst

        <a
            class="filter-button <?= $aktivniKategorie === $hodnota ? 'active' : '' ?>"
            href="<?= BASE_URL ?>/index.php<?= $hodnota !== '' ? '?kategorie=' . urlencode($hodnota) : '' ?>">

            <?= htmlspecialchars($nazev) ?>

        </a>

    <?php endforeach; ?>

</div>

<section class="places-list">

<?php if (!empty($mista)): ?> //pokud je v poli $mista nějaké místo, tak se zobrazí, jinak se zobrazí hláška, že žádná místa nejsou, tedy vytvoř pohled pro zobrazení všech míst

    <?php foreach ($mista as $misto): ?> // beru ejdno místo po druhém a vytvořím pro ně kartu

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

            <div class="place-content"> // vypsání názvů místa, kategorie, lokality, autora a popisu místa, tedy vytvoř pohled pro zobrazení všech míst

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