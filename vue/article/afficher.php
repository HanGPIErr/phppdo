<article>

    <h1><?= $article['titre'] ?> </h1>
    <legend>Ecrit par : <?= $article['pseudo'] ?></legend>

    <p>
        <?= $article['contenu'] ?>
    </p>
    <?php if($article['nom_image'] != "" && $article['nom_image'] != null) { ?>
    <img src="<?= Conf::URL ?>assets/img/<?= $article['nom_image'] ?>">
    <?php } ?>

</article>

<a class="btn btn-primary" href="<?= Conf::URL ?>article/liste">Retour</a>