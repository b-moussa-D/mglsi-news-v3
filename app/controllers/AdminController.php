<?php
class AdminController {
    private PDO $db;
    private Article $articleModel;
    private Categorie $categorieModel;
    private Utilisateur $utilisateurModel;
    private Token $tokenModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->articleModel = new Article($db);
        $this->categorieModel = new Categorie($db);
        $this->utilisateurModel = new Utilisateur($db);
        $this->tokenModel = new Token($db);
    }

    // ---------- ARTICLES (éditeur ou administrateur) ----------

    public function articles(): void {
        AuthController::exigerRole('editeur');
        $articles = $this->articleModel->findAll(1000, 0);
        $categories = $this->categorieModel->findAll();
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/admin/articles.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function articleForm(): void {
        AuthController::exigerRole('editeur');
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $article = $id ? $this->articleModel->find($id) : null;
        $categories = $this->categorieModel->findAll();
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/admin/article_form.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function articleSave(): void {
        AuthController::exigerRole('editeur');
        $d = $_POST;
        $d['auteur'] = $_SESSION['utilisateur']['id'];
        if (!empty($_POST['id'])) {
            $this->articleModel->update((int) $_POST['id'], $d);
        } else {
            $this->articleModel->create($d);
        }
        header('Location: index.php?action=admin_articles'); exit;
    }

    public function articleDelete(): void {
        AuthController::exigerRole('editeur');
        $this->articleModel->delete((int) $_GET['id']);
        header('Location: index.php?action=admin_articles'); exit;
    }

    // ---------- CATÉGORIES (éditeur ou administrateur) ----------

    public function categories(): void {
        AuthController::exigerRole('editeur');
        $categories = $this->categorieModel->findAll();
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/admin/categories.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function categorieSave(): void {
        AuthController::exigerRole('editeur');
        if (!empty($_POST['id'])) {
            $this->categorieModel->update((int) $_POST['id'], $_POST);
        } else {
            $this->categorieModel->create($_POST);
        }
        header('Location: index.php?action=admin_categories'); exit;
    }

    public function categorieDelete(): void {
        AuthController::exigerRole('editeur');
        $this->categorieModel->delete((int) $_GET['id']);
        header('Location: index.php?action=admin_categories'); exit;
    }

    // ---------- UTILISATEURS (administrateur uniquement) ----------

    public function utilisateurs(): void {
        AuthController::exigerRole('administrateur');
        $utilisateurs = $this->utilisateurModel->findAll();
        $categories = $this->categorieModel->findAll(); // pour le menu du header
        $dernierJeton = $_SESSION['dernierJeton'] ?? null;
        unset($_SESSION['dernierJeton']);
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/admin/utilisateurs.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function utilisateurSave(): void {
        AuthController::exigerRole('administrateur');
        if (!empty($_POST['id'])) {
            $this->utilisateurModel->update((int) $_POST['id'], $_POST);
        } else {
            $this->utilisateurModel->create($_POST);
        }
        header('Location: index.php?action=admin_utilisateurs'); exit;
    }

    public function utilisateurDelete(): void {
        AuthController::exigerRole('administrateur');
        $this->utilisateurModel->delete((int) $_GET['id']);
        header('Location: index.php?action=admin_utilisateurs'); exit;
    }

    public function genererToken(): void {
        AuthController::exigerRole('administrateur');
        $jeton = $this->tokenModel->generer((int) $_POST['utilisateur']);
        $_SESSION['dernierJeton'] = $jeton;
        header('Location: index.php?action=admin_utilisateurs'); exit;
    }
}
