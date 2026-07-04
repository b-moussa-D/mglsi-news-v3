<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MGLSI News</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1><a href="index.php?action=accueil">MGLSI News</a></h1>
    <nav>
        <a href="index.php?action=accueil">Tous les articles</a>
        <?php foreach ($categories as $cat): ?>
            <a href="index.php?action=accueil&categorie=<?= $cat['id'] ?>">
                <?= htmlspecialchars($cat['libelle']) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</header>
<main>
