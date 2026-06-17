<?php require_once '../APP/Views/layout/header.php'; ?>

<h1>Přidat nové místo</h1>

<div class="form-card">

<form action="<?= BASE_URL ?>/index.php?url=mista/ulozit"
      method="post"
      enctype="multipart/form-data">

    <label>Název místa *</label>
    <input type="text" name="nazev" required>

    <label>Lokalita</label>
    <select name="lokalita">
        <option value="">Vyber lokalitu</option>
        <option value="Bedřichov">Bedřichov</option>
        <option value="Janov nad Nisou">Janov nad Nisou</option>
        <option value="Josefův Důl">Josefův Důl</option>
        <option value="Smědava">Smědava</option>
        <option value="Jizerka">Jizerka</option>
        <option value="Hejnice">Hejnice</option>
        <option value="Liberec">Liberec</option>
        <option value="Tanvald">Tanvald</option>
        <option value="Kořenov">Kořenov</option>
        <option value="Desná">Desná</option>
    </select>

    <label>Kategorie</label>
    <select name="kategorie">
        <option value="">Vyber kategorii</option>
        <option value="Občerstvení">Občerstvení</option>
        <option value="Skály">Skály</option>
        <option value="Pěšina">Pěšina</option>
        <option value="Vyhlídka">Vyhlídka</option>
        <option value="Vrchol">Vrchol</option>
        <option value="Louka / mýtina">Louka / mýtina</option>
        <option value="Vodopád / potok">Vodopád / potok</option>
        <option value="Rozcestník">Rozcestník</option>
    </select>

    <label>Popis</label>
    <textarea name="popis" rows="5"></textarea>

    <label>Obrázek místa</label>
    <input type="file" name="obrazek">

    <button type="submit">
        Uložit místo
    </button>

</form>

</div>

<?php require_once '../APP/Views/layout/footer.php'; ?>