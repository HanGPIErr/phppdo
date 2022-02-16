<?php
session_start();

include('Autoloader.php');
Autoloader::start();

//new ArticleControleur();

// ex : http://localhost/phppdo/index.php?chemin=article/afficher/42
$chemin = str_replace("/parametre=","/",$_GET['chemin']);
$partiesChemin = explode("/", $chemin);

//si lutilisateur a fournit la premiere partie de l'url (le controleur)
//sinon le controleur sera articlecontroleur par défaut
if(isset($partiesChemin[0]) && $partiesChemin[0] != "") {
$nomControleur = "controleur\\".ucfirst($partiesChemin[0]). "Controleur"; //ex : controleur\ArticleControlleur

} else {
    $nomControleur = "controleur\\ArticleControleur";
}

// si lutilisateur a fournit la seconde partie de l'url (l'action)
if (isset($partiesChemin[1]) && $partiesChemin[1] != "") {
$nomAction = $partiesChemin[1]; //ex : liste
} else {
    $nomAction = "liste";
}

// si l'url comporte un parametre et que celle-ci ne finit pas par un slash
//ex localhost/phppdo/article/afficher/42
if(isset($partiesChemin[2]) && $partiesChemin[2] != "") {
$parametre = $partiesChemin[2]; //ex : 42
} else {
    $parametre = null;
}


//Si la classe et sa méthode existe
if(!method_exists($nomControleur, $nomAction)) {

    $nomControleur = "controleur\\PageControleur";
    $nomAction = "PageNonTrouve";
}

//article -> ArticleControleur
$controleur = new $nomControleur();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/phppdo/assets/css/bootstrap.min.css">
    <script src="/phppdo/assets/js/bootstrap.min.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>PHPPDO</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= Conf::URL ?>">Super Jose</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?= Conf::URL ?>">Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <?php
          if(isset($_SESSION['pseudo'])) {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= Conf::URL ?>utilisateur/deconnexion">Déconnexion</a>
        </li>
        <?php
          } else {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= Conf::URL ?>utilisateur/connexion">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= Conf::URL ?>utilisateur/inscription">Inscription</a>
        </li>

        <?php
          }
        ?>
      </ul>
          <?php
          if(isset($_SESSION['pseudo'])){
          ?>
      <div class="m-4">
          Bienvenue <?= $_SESSION['pseudo'] ?>
      </div>
      <?php } ?>

      <!--FAIRE UNE RECHERCHE PHP ne pas oublier le name recherche dans input--->
      <form method="GET" class="d-flex" action="<?= Conf::URL?>article/recherche">
        <input name="parametre" class="form-control me-sm-2" type="text" placeholder="Titre, contenu...">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class='bx bx-search-alt' ></i></button>
      </form>
    </div>
  </div>
</nav>

    <?php
    $controleur -> $nomAction($parametre);
    ?>
    
</body>
</html>