<?php

class Uzivatel {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function register(
        string $username,
        string $email,
        string $password,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $nickname = null
    ): bool {

        if ($this->findByEmail($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO uzivatele 
                (username, email, password, first_name, last_name, nickname)
                VALUES 
                (:username, :email, :password, :first_name, :last_name, :nickname)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':nickname' => $nickname
        ]);
    }

    public function findByEmail(string $email) {
        $sql = "SELECT * FROM uzivatele WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id) {
        $sql = "SELECT * FROM uzivatele WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExistsForOtherUser(string $email, int $id): bool {
        $sql = "SELECT id FROM uzivatele WHERE email = :email AND id != :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function updateProfile(int $id, string $nickname, string $email, string $password = ''): bool {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE uzivatele 
                    SET nickname = :nickname, email = :email, password = :password
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':nickname' => $nickname,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':id' => $id
            ]);
        }

        $sql = "UPDATE uzivatele 
                SET nickname = :nickname, email = :email
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nickname' => $nickname,
            ':email' => $email,
            ':id' => $id
        ]);
    }
}