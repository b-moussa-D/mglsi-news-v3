<?php
class ArticleController {
    private PDO $db; private Article $articleModel; private Categorie $categorieModel;
    private const PAR_PAGE = 5;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->articleModel = new Article($db);
        $this->categorieModel = new Categorie($db);
    }

    public function index(): void {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PAR_PAGE;
        $catActive = (int) ($_GET['categorie'] ?? 0);

        if ($catActive > 0) {
            $articles = $this->articleModel->findByCategorie($catActive, self::PAR_PAGE, $offset);
        } else {
            $articles = $this->articleModel->findAll(self::PAR_PAGE, $offset);
        }
        $total = $this->articleModel->count();
        $categories = $this->categorieModel->findAll();

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/articles/index.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function show(int $id): void {
        $article = $this->articleModel->find($id);
        $categories = $this->categorieModel->findAll();
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/articles/show.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
