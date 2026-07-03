<?php
class Utilisateur {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function findByLogin(string $login): ?array {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function findAll(): array {
        return $this->db->query("SELECT id, nom, prenom, login, role FROM Utilisateur")->fetchAll();
    }

    public function create(array $d): int {
        $stmt = $this->db->prepare(
            "INSERT INTO Utilisateur (nom, prenom, login, motDePasse, role)
             VALUES (:nom, :prenom, :login, :mdp, :role)");
        $stmt->execute([
            'nom' => $d['nom'], 'prenom' => $d['prenom'], 'login' => $d['login'],
            'mdp' => password_hash($d['motDePasse'], PASSWORD_DEFAULT),
            'role' => $d['role'] ?? 'editeur',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE Utilisateur SET nom=:nom, prenom=:prenom, role=:role WHERE id=:id");
        return $stmt->execute([
            'nom' => $d['nom'], 'prenom' => $d['prenom'], 'role' => $d['role'], 'id' => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Utilisateur WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
