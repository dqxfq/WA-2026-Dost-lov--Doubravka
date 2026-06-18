<?php

class Book
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(
        string $title,
        string $author,
        int $year,
        string $category,
        string $subcategory,
        float $price,
        $isbn,
        string $description
    ): bool {
        $sql = "INSERT INTO books (title, author, category, subcategory, year, price, isbn, description)
                VALUES (:title, :author, :category, :subcategory, :year, :price, :isbn, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':year' => $year,
            ':category' => $category,
            ':subcategory' => $subcategory ?: '',
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
        ]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM books ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(
        $id,
        $title,
        $author,
        $category,
        $subcategory,
        $year,
        $price,
        $isbn,
        $description
    ) {
        $sql = "UPDATE books
                SET title = :title,
                    author = :author,
                    category = :category,
                    subcategory = :subcategory,
                    year = :year,
                    price = :price,
                    isbn = :isbn,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: '',
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}