<?php
if (isset($_SESSION['droit'])) {

  if($_SESSION['droit'] == "admin" || $_SESSION['droit'] == "redacteur") {

  
  ?>
<a href="<?= Conf::URL ?>article/insertion" class="btn btn-primary mb-4">Ajouter article</a>

<?php
}}
?>

<div class="container">
<div class="row">
<?php

foreach($listeArticle as $article) {

?>
<div class="col-6">
<div class="card border-primary m-5">
  <div class="card-header">Ecrit par: <?= htmlentities($article["pseudo"]) ?></div>
  <div class="card-body">
    <h4 class="card-title"><?= htmlentities($article["titre"]) ?></h4>

    <?php
    if($article['nom_image']) {
    ?>
    <img class="img-fluid" src="<?= Conf::URL ?>assets/img/<?= $article['nom_image'] ?>">
    <?php
    }
    ?>
    
    
    <p class="card-text"><?= htmlentities($article["contenu"]) ?></p>

    <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-primary mt-4"><i class='bx bx-home' ></i></a>

    <?php
    if ((isset($_SESSION['droit']) && $_SESSION['droit'] == "admin") 
    || (isset($_SESSION['id']) && $_SESSION['id'] == $article["id_utilisateur"])) {
      ?>

    <a href="<?= Conf::URL ?>article/edition/<?= $article["id"] ?>" class="btn btn-warning mt-4"><i class='bx bx-edit-alt' ></i></a>
    <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-danger mt-4"><i class='bx bxs-trash'></i></a>

    <?php
    } 
    ?>
  </div>
</div>
</div>

<?php
}
?>
</div>
</div>