<h1><?= $article ? 'Modifier' : 'Nouvel' ?> article</h1>

<form method="post" action="index.php?action=admin_article_save" class="formulaire">
    <?php if ($article): ?>
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
    <?php endif; ?>

    <label>Titre
        <input type="text" name="titre" required
               value="<?= htmlspecialchars($article['titre'] ?? '') ?>">
    </label>

    <label>Extrait (résumé court)
        <input type="text" name="extrait" maxlength="400"
               value="<?= htmlspecialchars($article['extrait'] ?? '') ?>">
    </label>

    <label>Contenu
        <textarea name="contenu" rows="8" required><?= htmlspecialchars($article['contenu'] ?? '') ?></textarea>
    </label>

    <label>Catégorie
        <select name="categorie" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= (isset($article['categorie']) && $article['categorie'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['libelle']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit"><?= $article ? 'Enregistrer les modifications' : 'Créer l’article' ?></button>
    <a href="index.php?action=admin_articles">Annuler</a>
</form>
