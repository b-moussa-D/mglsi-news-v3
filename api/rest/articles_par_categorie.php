<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Article.php';
require_once __DIR__ . '/../../app/models/Categorie.php';

$pdo = getPDO();
$articleModel = new Article($pdo);
$categorieModel = new Categorie($pdo);

$format = $_GET['format'] ?? 'json';
$idCategorie = isset($_GET['categorie']) ? (int) $_GET['categorie'] : null;

if ($idCategorie) {
    // Cas filtré : une seule catégorie -> liste plate d'articles
    $resultat = $articleModel->findByCategorie($idCategorie, 1000, 0);
} else {
    // Cas par défaut : regroupement par catégorie
    $resultat = [];
    foreach ($categorieModel->findAll() as $cat) {
        $resultat[$cat['libelle']] = $articleModel->findByCategorie((int) $cat['id'], 1000, 0);
    }
}

if ($format === 'xml') {
    header('Content-Type: application/xml; charset=utf-8');
    $xml = new SimpleXMLElement('<resultat/>');

    if ($idCategorie) {
        // Liste plate d'articles
        foreach ($resultat as $a) {
            $noeud = $xml->addChild('article');
            foreach ($a as $cle => $valeur) {
                $noeud->addChild($cle, htmlspecialchars((string) $valeur));
            }
        }
    } else {
        // Regroupement par catégorie
        foreach ($resultat as $libelleCategorie => $articles) {
            $noeudCategorie = $xml->addChild('categorie');
            $noeudCategorie->addAttribute('libelle', htmlspecialchars((string) $libelleCategorie));
            foreach ($articles as $a) {
                $noeudArticle = $noeudCategorie->addChild('article');
                foreach ($a as $cle => $valeur) {
                    $noeudArticle->addChild($cle, htmlspecialchars((string) $valeur));
                }
            }
        }
    }

    echo $xml->asXML();
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resultat, JSON_UNESCAPED_UNICODE);
}