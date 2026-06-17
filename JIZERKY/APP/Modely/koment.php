<?php

class Koment {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(int $mistoId, int $uzivatelId, string $obsah): bool {

        $sql = "INSERT INTO komentare (misto_id, uzivatel_id, obsah)
                VALUES (:misto_id, :uzivatel_id, :obsah)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':misto_id' => $mistoId,
            ':uzivatel_id' => $uzivatelId,
            ':obsah' => $obsah
        ]);
    }

    public function getByMistoId($mistoId) {

        $sql = "SELECT komentare.*, uzivatele.username, uzivatele.nickname
                FROM komentare
                LEFT JOIN uzivatele ON komentare.uzivatel_id = uzivatele.id
                WHERE komentare.misto_id = :misto_id
                ORDER BY komentare.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':misto_id' => $mistoId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {

        $sql = "DELETE FROM komentare WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}