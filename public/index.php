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
    default: http_response_code(404); echo "Page introuvable";
}
