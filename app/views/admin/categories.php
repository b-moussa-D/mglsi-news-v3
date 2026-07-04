<h1>Gestion des catégories</h1>

<table class="table-admin">
    <thead>
        <tr><th>Libellé</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
            <td>
                <form method="post" action="index.php?action=admin_categorie_save" class="formulaire-inline">
                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                    <input type="text" name="libelle" value="<?= htmlspecialchars($cat['libelle']) ?>" required>
                    <button type="submit">Enregistrer</button>
                </form>
            </td>
            <td>
                <a href="index.php?action=admin_categorie_delete&id=<?= $cat['id'] ?>"
                   onclick="return confirm('Supprimer cette catégorie ? Les articles liés perdront leur catégorie.');">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Ajouter une catégorie</h2>
<form method="post" action="index.php?action=admin_categorie_save" class="formulaire-inline">
    <input type="text" name="libelle" placeholder="Nom de la catégorie" required>
    <button type="submit">Ajouter</button>
</form>
