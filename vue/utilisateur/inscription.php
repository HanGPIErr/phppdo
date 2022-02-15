<form method="POST">

    <div class="form-group">
        <label class="col-form-label mt-4" for="pseudo">Pseudo</label>
        <input value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" name="pseudo" type="text" class="form-control" placeholder="Ex : JohnDoe" id="pseudo">
    </div>

        <?php if($erreurLongueurPseudo) { ?>
        <p class="text-danger">Le pseudo doit avoir au moins 5 caractères</p>
        <?php } ?>

    <div class="form-group">
        <label for="mot_de_passe" class="form-label mt-4">Mot De Passe</label>
        <input name="mot_de_passe" type="password" class="form-control" id="mot_de_passe">
    </div>

    <div class="form-group">
        <label for="confirmer_mot_de_passe" class="form-label mt-4">Confirmer Mot De Passe</label>
        <input name="confirmer_mot_de_passe" type="password" class="form-control" id="confirmer_mot_de_passe">
    </div>

    <?php if($erreurMotDePasseIdentique) { ?>
    <p class="text-danger">Les Mots de passe sont différents</p>
    <?php } ?>

    <input name="valider" class="btn btn-primary mt-4" type="submit" value="Inscription">
    <a class="btn btn-danger mt-4" href="<?= Conf::URL ?>">Annuler</a>
</form>