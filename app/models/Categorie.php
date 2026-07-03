<?php
class Categorie {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function findAll(): array {
        return $this->db->query("SELECT * FROM Categorie ORDER BY libelle")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM Categorie WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function create(array $d): int {
        $stmt = $this->db->prepare("INSERT INTO Categorie (libelle) VALUES (:libelle)");
        $stmt->execute(['libelle' => $d['libelle']]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare("UPDATE Categorie SET libelle = :libelle WHERE id = :id");
        return $stmt->execute(['libelle' => $d['libelle'], 'id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Categorie WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
