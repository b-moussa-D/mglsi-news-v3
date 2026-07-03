<?php
class Article {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function findAll(int $limite, int $offset): array {
        $stmt = $this->db->prepare(
            "SELECT a.*, c.libelle AS categorieLibelle FROM Article a
             LEFT JOIN Categorie c ON a.categorie = c.id
             ORDER BY a.dateCreation DESC LIMIT :lim OFFSET :off");
        $stmt->bindValue(':lim', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM Article")->fetchColumn();
    }

    public function findByCategorie(int $idCategorie, int $limite, int $offset): array {
        $stmt = $this->db->prepare(
            "SELECT a.*, c.libelle AS categorieLibelle FROM Article a
             LEFT JOIN Categorie c ON a.categorie = c.id
             WHERE a.categorie = :cat
             ORDER BY a.dateCreation DESC LIMIT :lim OFFSET :off");
        $stmt->bindValue(':cat', $idCategorie, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT a.*, c.libelle AS categorieLibelle FROM Article a
             LEFT JOIN Categorie c ON a.categorie = c.id WHERE a.id = :id");
        $stmt->execute(['id' => $id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function create(array $d): int {
        $stmt = $this->db->prepare(
            "INSERT INTO Article (titre, extrait, contenu, categorie, auteur)
             VALUES (:titre, :extrait, :contenu, :categorie, :auteur)");
        $stmt->execute([
            'titre' => $d['titre'], 'extrait' => $d['extrait'], 'contenu' => $d['contenu'],
            'categorie' => $d['categorie'], 'auteur' => $d['auteur'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE Article SET titre=:titre, extrait=:extrait, contenu=:contenu, categorie=:categorie
             WHERE id=:id");
        return $stmt->execute([
            'titre' => $d['titre'], 'extrait' => $d['extrait'], 'contenu' => $d['contenu'],
            'categorie' => $d['categorie'], 'id' => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Article WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
