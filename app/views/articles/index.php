<?php foreach ($articles as $a): ?>
  <article class="carte">
    <span class="badge"><?= htmlspecialchars($a['categorieLibelle'] ?? '') ?></span>
    <h2><a href="index.php?action=article&id=<?= $a['id'] ?>"><?= htmlspecialchars($a['titre']) ?></a></h2>
    <p><?= htmlspecialchars($a['extrait']) ?></p>
    <small><?= $a['dateCreation'] ?></small>
  </article>
<?php endforeach; ?>

<?php if (empty($articles)): ?>
  <p>Aucun article pour le moment.</p>
<?php endif; ?>

<div class="pagination">
  <?php if ($page > 1): ?>
    <a href="index.php?action=accueil&page=<?= $page - 1 ?>&categorie=<?= $catActive ?>">« Précédent</a>
  <?php endif; ?>
  <?php if ($offset + count($articles) < $total): ?>
    <a href="index.php?action=accueil&page=<?= $page + 1 ?>&categorie=<?= $catActive ?>">Suivant »</a>
  <?php endif; ?>
</div>
