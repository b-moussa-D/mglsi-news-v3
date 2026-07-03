<?php
class Token {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function estValide(string $jeton): ?array {
        $stmt = $this->db->prepare(
            "SELECT t.*, u.role FROM Token t
             JOIN Utilisateur u ON t.utilisateur = u.id
             WHERE t.jeton = :jeton AND t.actif = 1");
        $stmt->execute(['jeton' => $jeton]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function generer(int $idUtilisateur): string {
        $jeton = bin2hex(random_bytes(16));
        $stmt = $this->db->prepare("INSERT INTO Token (jeton, utilisateur) VALUES (:jeton, :u)");
        $stmt->execute(['jeton' => $jeton, 'u' => $idUtilisateur]);
        return $jeton;
    }

    public function revoquer(string $jeton): bool {
        $stmt = $this->db->prepare("UPDATE Token SET actif = 0 WHERE jeton = :jeton");
        return $stmt->execute(['jeton' => $jeton]);
    }
}
