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

        <?php $role = $_SESSION['utilisateur']['role'] ?? null; ?>
        <?php if ($role === 'editeur' || $role === 'administrateur'): ?>
            <a href="index.php?action=admin_articles">Gérer les articles</a>
            <a href="index.php?action=admin_categories">Gérer les catégories</a>
        <?php endif; ?>
        <?php if ($role === 'administrateur'): ?>
            <a href="index.php?action=admin_utilisateurs">Gérer les utilisateurs</a>
        <?php endif; ?>
    </nav>
    <div class="compte">
        <?php if (!empty($_SESSION['utilisateur'])): ?>
            Bonjour <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?>
            (<?= htmlspecialchars($_SESSION['utilisateur']['role']) ?>)
            — <a href="index.php?action=logout">Se déconnecter</a>
        <?php else: ?>
            <a href="index.php?action=login">Se connecter</a>
        <?php endif; ?>
    </div>
</header>
<main>
