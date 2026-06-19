<?php
// zde je uvedeno, co se po příkazu z místacontroller.php stane opravdu v databázi

class Mista {

    private PDO $db; //připojení k databázi

    public function __construct(PDO $db) { // konstruktor třídy Mista, který přijímá připojení k databázi jako parametr a ukládá ho do vlastnosti $db
        $this->db = $db;
    }

    public function create( // vytvoření nového místa v databázi, tedy vložení nového záznamu do tabulky míst
       //přidání místa do databáze
        string $nazev,
        string $lokalita,
        string $kategorie,
        string $popis,
        ?string $obrazek,
        ?int $createdBy
    ): bool {


        // vložení hodnot do tabulky míst, tedy vytvoření nového záznamu v tabulce míst
        $sql = "INSERT INTO mista
                (nazev, lokalita, kategorie, popis, obrazek, created_by)
                VALUES 
                (:nazev, :lokalita, :kategorie, :popis, :obrazek, :created_by)";

        $stmt = $this->db->prepare($sql); // příprava SQL dotazu pro vložení nového místa do databáze

        return $stmt->execute([ // vykonání SQL dotazu pro vložení nového místa do databáze s předanými hodnotami
            ':nazev' => $nazev,
            ':lokalita' => $lokalita,
            ':kategorie' => $kategorie,
            ':popis' => $popis,
            ':obrazek' => $obrazek,
            ':created_by' => $createdBy
        ]);
    }

    public function getAll() { // načtení všech míst z databáze všech záznamů z tabulky míst

        // SQL dotaz pro načtení všech míst z databáze, včetně autora místa (nickname nebo username)
        $sql = "SELECT mista.*, 
                        //má li uzivatel přezdívku, zobraz tu, jinak zobraz jeho username
                       COALESCE(NULLIF(uzivatele.nickname, ''), uzivatele.username) AS autor
                FROM mista
                //propojuje tabulku míst s tabulkou uživatelů, aby se získal autor místa
                LEFT JOIN uzivatele ON mista.created_by = uzivatele.id
                ORDER BY mista.id DESC"; // seřazení míst podle id sestupně, tedy nejnovější místo bude první

        $stmt = $this->db->prepare($sql);
        $stmt->execute(); // vykonání SQL dotazu pro načtení všech míst z databáze

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // vrací všechna místa jako asociativní pole, tedy pole s názvy sloupců jako klíče
    }

    //načtení konkrétního místa podle jeho id z databáze, tedy načtení jednoho záznamu z tabulky míst
    public function getById($id) {

        $sql = "SELECT mista.*,
                       COALESCE(NULLIF(uzivatele.nickname, ''), uzivatele.username) AS autor
                FROM mista
                LEFT JOIN uzivatele ON mista.created_by = uzivatele.id
                WHERE mista.id = :id"; // načtení konkrétního místa podle jeho id z databáze, tedy načtení jednoho záznamu z tabulky míst

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id //tady se za id dosadí skutečné číslo id místa, které se má načíst z databáze
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // vrací konkrétní místo jako asociativní pole, tedy pole s názvy sloupců jako klíče
    }

    //v taulce místa se aktualizují hodnoty konkrétního místa podle jeho id, tedy aktualizace jednoho záznamu v tabulce míst
    public function update($id, $nazev, $lokalita, $kategorie, $popis) {

        $sql = "UPDATE mista
                SET nazev = :nazev,
                    lokalita = :lokalita,
                    kategorie = :kategorie,
                    popis = :popis
                WHERE id = :id"; //ÚPRAVA PROBĚHNE JEN U MÍSTA S TÍMTO ID

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nazev' => $nazev,
            ':lokalita' => $lokalita,
            ':kategorie' => $kategorie,
            ':popis' => $popis
        ]);
    }

    public function delete($id) {

        $sql = "DELETE FROM mista WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}