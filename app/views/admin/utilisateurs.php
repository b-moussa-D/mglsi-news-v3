<h1>Gestion des utilisateurs</h1>

<?php if ($dernierJeton): ?>
    <p class="succes">
        Jeton généré : <code><?= htmlspecialchars($dernierJeton) ?></code>
        (copie-le maintenant, il ne sera plus réaffiché ici).
    </p>
<?php endif; ?>

<table class="table-admin">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Login</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['nom']) ?></td>
            <td><?= htmlspecialchars($u['prenom']) ?></td>
            <td><?= htmlspecialchars($u['login']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
            <td>
                <form method="post" action="index.php?action=admin_generer_token" style="display:inline">
                    <input type="hidden" name="utilisateur" value="<?= $u['id'] ?>">
                    <button type="submit">Générer un jeton</button>
                </form>
                &nbsp;|&nbsp;
                <a href="index.php?action=admin_utilisateur_delete&id=<?= $u['id'] ?>"
                   onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Ajouter un utilisateur</h2>
<form method="post" action="index.php?action=admin_utilisateur_save" class="formulaire">
    <label>Nom
        <input type="text" name="nom" required>
    </label>
    <label>Prénom
        <input type="text" name="prenom" required>
    </label>
    <label>Login
        <input type="text" name="login" required>
    </label>
    <label>Mot de passe
        <input type="password" name="motDePasse" required>
    </label>
    <label>Rôle
        <select name="role">
            <option value="editeur">Éditeur</option>
            <option value="administrateur">Administrateur</option>
        </select>
    </label>
    <button type="submit">Ajouter</button>
</form>
