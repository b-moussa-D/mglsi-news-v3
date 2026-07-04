<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Utilisateur.php';
require_once __DIR__ . '/../../app/models/Token.php';
require_once __DIR__ . '/TokenGuard.php';

class UserService {
    private PDO $db;
    private Utilisateur $utilisateurModel;
    private Token $tokenModel;

    public function __construct() {
        $this->db = getPDO();
        $this->utilisateurModel = new Utilisateur($this->db);
        $this->tokenModel = new Token($this->db);
    }

    /** Authentifie un utilisateur ; renvoie un jeton si succès, sinon une chaîne vide. */
    public function authentifier(string $login, string $motDePasse): string {
        $u = $this->utilisateurModel->findByLogin($login);
        if ($u && password_verify($motDePasse, $u['motDePasse'])) {
            return $this->tokenModel->generer((int) $u['id']);
        }
        return '';
    }

    /** Liste les utilisateurs. Requiert un jeton administrateur. */
    public function listerUtilisateurs(string $jeton): array {
        TokenGuard::verifierAdmin($this->db, $jeton);
        return $this->utilisateurModel->findAll();
    }

    public function ajouterUtilisateur(string $jeton, string $nom, string $prenom,
            string $login, string $motDePasse, string $role): int {
        TokenGuard::verifierAdmin($this->db, $jeton);
        return $this->utilisateurModel->create(compact('nom', 'prenom', 'login', 'motDePasse', 'role'));
    }

    public function modifierUtilisateur(string $jeton, int $id, string $nom,
            string $prenom, string $role): bool {
        TokenGuard::verifierAdmin($this->db, $jeton);
        return $this->utilisateurModel->update($id, compact('nom', 'prenom', 'role'));
    }

    public function supprimerUtilisateur(string $jeton, int $id): bool {
        TokenGuard::verifierAdmin($this->db, $jeton);
        return $this->utilisateurModel->delete($id);
    }
}