<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Article.php';

$pdo = getPDO();
$articleModel = new Article($pdo);
$articles = $articleModel->findAll(1000, 0);

$format = $_GET['format'] ?? 'json';

if ($format === 'xml') {
    header('Content-Type: application/xml; charset=utf-8');
    $xml = new SimpleXMLElement('<articles/>');
    foreach ($articles as $a) {
        $noeud = $xml->addChild('article');
        foreach ($a as $cle => $valeur) $noeud->addChild($cle, htmlspecialchars((string) $valeur));
    }
    echo $xml->asXML();
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($articles, JSON_UNESCAPED_UNICODE);
}