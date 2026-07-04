<?php if ($article): ?>
  <article class="detail">
    <span class="badge"><?= htmlspecialchars($article['categorieLibelle'] ?? '') ?></span>
    <h1><?= htmlspecialchars($article['titre']) ?></h1>
    <small><?= $article['dateCreation'] ?></small>
    <div class="contenu"><?= nl2br(htmlspecialchars($article['contenu'])) ?></div>
    <a href="index.php?action=accueil">← Retour à la liste</a>
  </article>
<?php else: ?>
  <p>Article introuvable.</p>
<?php endif; ?>
