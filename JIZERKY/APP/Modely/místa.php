<?php

class Mista {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(
        string $nazev,
        string $lokalita,
        string $kategorie,
        string $popis,
        ?string $obrazek,
        ?int $createdBy
    ): bool {

        $sql = "INSERT INTO mista
                (nazev, lokalita, kategorie, popis, obrazek, created_by)
                VALUES
                (:nazev, :lokalita, :kategorie, :popis, :obrazek, :created_by)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nazev' => $nazev,
            ':lokalita' => $lokalita,
            ':kategorie' => $kategorie,
            ':popis' => $popis,
            ':obrazek' => $obrazek,
            ':created_by' => $createdBy
        ]);
    }

    public function getAll() {

        $sql = "SELECT mista.*,
                       COALESCE(NULLIF(uzivatele.nickname, ''), uzivatele.username) AS autor
                FROM mista
                LEFT JOIN uzivatele ON mista.created_by = uzivatele.id
                ORDER BY mista.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {

        $sql = "SELECT mista.*,
                       COALESCE(NULLIF(uzivatele.nickname, ''), uzivatele.username) AS autor
                FROM mista
                LEFT JOIN uzivatele ON mista.created_by = uzivatele.id
                WHERE mista.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nazev, $lokalita, $kategorie, $popis) {

        $sql = "UPDATE mista
                SET nazev = :nazev,
                    lokalita = :lokalita,
                    kategorie = :kategorie,
                    popis = :popis
                WHERE id = :id";

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