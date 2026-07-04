<?php
session_start();
require_once __DIR__ . '/../config/database.php';
spl_autoload_register(function ($classe) {
    foreach (['app/models/', 'app/controllers/'] as $dossier) {
        $chemin = __DIR__ . '/../' . $dossier . $classe . '.php';
        if (file_exists($chemin)) { require $chemin; return; }
    }
});

$pdo = getPDO();
$action = $_GET['action'] ?? 'accueil';

switch ($action) {
    case 'accueil': (new ArticleController($pdo))->index(); break;
    case 'article': (new ArticleController($pdo))->show((int) $_GET['id']); break;

    case 'login':   (new AuthController($pdo))->login(); break;
    case 'logout':  (new AuthController($pdo))->logout(); break;

    case 'admin_articles':       (new AdminController($pdo))->articles(); break;
    case 'admin_article_form':   (new AdminController($pdo))->articleForm(); break;
    case 'admin_article_save':   (new AdminController($pdo))->articleSave(); break;
    case 'admin_article_delete': (new AdminController($pdo))->articleDelete(); break;

    case 'admin_categories':       (new AdminController($pdo))->categories(); break;
    case 'admin_categorie_save':   (new AdminController($pdo))->categorieSave(); break;
    case 'admin_categorie_delete': (new AdminController($pdo))->categorieDelete(); break;

    case 'admin_utilisateurs':       (new AdminController($pdo))->utilisateurs(); break;
    case 'admin_utilisateur_save':   (new AdminController($pdo))->utilisateurSave(); break;
    case 'admin_utilisateur_delete': (new AdminController($pdo))->utilisateurDelete(); break;
    case 'admin_generer_token':      (new AdminController($pdo))->genererToken(); break;

    default: http_response_code(404); echo "Page introuvable";
}
