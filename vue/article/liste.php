<a href="<?= Conf::URL ?>article/insertion" class="btn btn-primary">Ajouter article</a>
<?php

foreach($listeArticle as $article) {

?>

<div class="card border-primary m-5" style="max-width: 20rem;">
  <div class="card-header">Ecrit par: <?= $article["pseudo"] ?></div>
  <div class="card-body">
    <h4 class="card-title"><?= $article["titre"] ?></h4>
    <p class="card-text"><?= $article["contenu"] ?></p>

    <?php
    if($article['nom_image']) {
    ?>
    <img class="img-fluid" src="<?= Conf::URL ?>assets/img/<?= $article['nom_image'] ?>">
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
      ?>
    <p class="card-text"><?=$article["contenu"] ?></p>
    <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-primary mt-4"><i class='bx bx-home' ></i></a>
    <a href="<?= Conf::URL ?>article/edition/<?= $article["id"] ?>" class="btn btn-warning mt-4"><i class='bx bx-edit-alt' ></i></a>
    <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-danger mt-4"><i class='bx bxs-trash'></i></a>
    <?php } ?>
  </div>
</div>

<?php
}
?>