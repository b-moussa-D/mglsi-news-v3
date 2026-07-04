<?php
class AuthController {
    private PDO $db; private Utilisateur $utilisateurModel;
    public function __construct(PDO $db) { $this->db = $db; $this->utilisateurModel = new Utilisateur($db); }

    public function login(): void {
        $erreur = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = $this->utilisateurModel->findByLogin($_POST['login'] ?? '');
            if ($u && password_verify($_POST['motDePasse'] ?? '', $u['motDePasse'])) {
                $_SESSION['utilisateur'] = ['id' => $u['id'], 'role' => $u['role'], 'nom' => $u['nom']];
                header('Location: index.php?action=accueil'); exit;
            }
            $erreur = "Identifiants invalides.";
        }
        $categories = (new Categorie($this->db))->findAll();
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/auth/login.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function logout(): void {
        session_destroy();
        header('Location: index.php?action=accueil'); exit;
    }

    public static function exigerRole(string $role): void {
        $utilisateur = $_SESSION['utilisateur'] ?? null;
        if (!$utilisateur) { header('Location: index.php?action=login'); exit; }
        $roleActuel = $utilisateur['role'];
        $autorise = ($roleActuel === $role) || ($role === 'editeur' && $roleActuel === 'administrateur');
        if (!$autorise) { http_response_code(403); echo "Accès refusé."; exit; }
    }
}
