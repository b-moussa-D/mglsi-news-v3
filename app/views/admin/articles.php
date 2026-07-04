<h1>Gestion des articles</h1>
<p><a href="index.php?action=admin_article_form">+ Nouvel article</a></p>

<table class="table-admin">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['titre']) ?></td>
            <td><?= htmlspecialchars($a['categorieLibelle'] ?? '') ?></td>
            <td><?= $a['dateCreation'] ?></td>
            <td>
                <a href="index.php?action=admin_article_form&id=<?= $a['id'] ?>">Modifier</a>
                &nbsp;|&nbsp;
                <a href="index.php?action=admin_article_delete&id=<?= $a['id'] ?>"
                   onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($articles)): ?>
        <tr><td colspan="4">Aucun article.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
