<h1>Connexion</h1>
<?php if (!empty($erreur)): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>
<form method="post" action="index.php?action=login" class="formulaire">
    <label>Login
        <input type="text" name="login" required>
    </label>
    <label>Mot de passe
        <input type="password" name="motDePasse" required>
    </label>
    <button type="submit">Se connecter</button>
</form>
