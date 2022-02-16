AFFICHAGE DES UTILISATEURS
<?php
foreach($listeUtilisateur as $utilisateur) {
    ?>
    <h1><?= $utilisateur['pseudo'] ?> </h1>
    <h1><?= $utilisateur['denomination'] ?> </h1>
<?php }
?>
