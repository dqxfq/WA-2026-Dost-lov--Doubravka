<?php require_once '../APP/Views/layout/header.php'; ?>

<h1>Upravit místo</h1>

<?php if ($misto): ?>

<div class="form-card">

<?php if (!empty($misto['obrazek'])): ?>

    <img
        src="<?= BASE_URL ?>/images/<?= htmlspecialchars($misto['obrazek']) ?>"
        alt="<?= htmlspecialchars($misto['nazev']) ?>"
        class="preview-img">

<?php endif; ?>

<form action="<?= BASE_URL ?>/index.php?url=mista/update/<?= $misto['id'] ?>"
      method="post">

    <label>Název místa *</label>
    <input
        type="text"
        name="nazev"
        value="<?= htmlspecialchars($misto['nazev']) ?>"
        required>

    <label>Lokalita</label>
    <select name="lokalita">
        <?php
            $lokality = [
                'Bedřichov',
                'Janov nad Nisou',
                'Josefův Důl',
                'Smědava',
                'Jizerka',
                'Hejnice',
                'Liberec',
                'Tanvald',
                'Kořenov',
                'Desná'
            ];
        ?>

        <option value="">Vyber lokalitu</option>

        <?php foreach ($lokality as $lokalita): ?>
            <option value="<?= $lokalita ?>" <?= ($misto['lokalita'] === $lokalita) ? 'selected' : '' ?>>
                <?= $lokalita ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Kategorie</label>
    <select name="kategorie">
        <?php
            $kategorie = [
                'Občerstvení',
                'Skály',
                'Pěšina',
                'Vyhlídka',
                'Vrchol',
                'Louka / mýtina',
                'Vodopád / potok',
                'Rozcestník'
            ];
        ?>

        <option value="">Vyber kategorii</option>

        <?php foreach ($kategorie as $kat): ?>
            <option value="<?= $kat ?>" <?= ($misto['kategorie'] === $kat) ? 'selected' : '' ?>>
                <?= $kat ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Popis</label>
    <textarea name="popis" rows="5"><?= htmlspecialchars($misto['popis']) ?></textarea>

    <button type="submit">
        Uložit změny
    </button>

</form>

</div>

<?php endif; ?>

<?php require_once '../APP/Views/layout/footer.php'; ?>