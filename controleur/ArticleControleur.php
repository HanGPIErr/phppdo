<?php

namespace controleur;

use PDOperso;
use Conf;

class ArticleControleur extends BaseControleur
{

    public function liste()
    {

        $connexion = new \PDOperso();

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication, nom_image, pseudo, id_utilisateur
            FROM article
            JOIN utilisateur
            ON utilisateur.id = article.id_utilisateur"
        );
        $requete->execute();
        $listeArticle = $requete->fetchAll();

        //$parametres = [];
        //$parametres['listeArticle'] = $listeArticle;
        $parametres = compact('listeArticle');

        $this->afficherVue($parametres);
    }
    public function afficher($id)
    {
        include("bdd.php");

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication, nom_image, pseudo
            FROM article
            JOIN utilisateur
            ON utilisateur.id = article.id_utilisateur
            WHERE article.id = ?"
        );
        $requete->execute([$id]);

        $article = $requete->fetch();

        if ($article) {
            // on récupere toutes les catégories de cet article
            $requete = $connexion->prepare(
                "SELECT *
                 FROM categorie_article
                 JOIN categorie ON categorie.id = categorie_article.id_categorie
                 WHERE id_article = ?
                 "
            );

            $requete->execute([$id]);

            $listeCategorie = $requete->fetchAll();

            $parametres = compact('article', 'listeCategorie');

            $this->afficherVue($parametres, 'afficher');
        } else {
            header('Location: ' . Conf::URL . 'page/PageNonTrouve');
        }
    }
    public function insertion()
    {
        if (isset($_SESSION['droit'])) {

            if($_SESSION['droit'] == "admin" || $_SESSION['droit'] == "redacteur") { 
        if (isset($_POST['valider'])) {

            $nouveauNom = NULL;
            //si lutilisateur a selectionné une image
            if ($_FILES['image']['tmp_name'] != "") {
                $nomTemporaire = $_FILES['image']['tmp_name'];
                //oncré un nom unique à partir du titre de l'article
                $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                move_uploaded_file($nomTemporaire, "./assets/img/" . $nouveauNom);
            }
            include('bdd.php');
            $requete = $connexion->prepare("INSERT INTO article (titre, contenu, nom_image, id_utilisateur) VALUES (?,?,?,?)
            ");

            $requete->execute([
                $_POST['titre'],
                $_POST['contenu'],
                $nouveauNom,
                $_SESSION['id']
            ]);
            header('location: ' . Conf::URL . 'article/liste');
        }
        $this->afficherVue([], 'insertion');
    } }}
    public function supprimer($id)
    {
        $connexion = new PDOperso();
        $requete = $connexion->prepare("SELECT * FROM article WHERE id = ?");
        $requete->execute([$id]);
        $article = $requete->fetch();
        if ((isset($_SESSION['droit']) && $_SESSION['droit'] == "admin") 
    || (isset($_SESSION['id']) && $_SESSION['id'] == $article["id_utilisateur"])) {
            include('bdd.php');
            $requete = $connexion->prepare(
                'DELETE FROM article WHERE id = ?'
            );

            $requete->execute([
                $id
            ]);
            //redirection vers la page des tâches
            header('location: ' . Conf::URL . 'article/liste');
        } else {
            header('Location: ' . Conf::URL);
        }

    }
    public function edition($id)
    {
        $connexion = new PDOperso();
        $requete = $connexion->prepare("SELECT * FROM article WHERE id = ?");
        $requete->execute([$id]);
        $article = $requete->fetch();
        if ((isset($_SESSION['droit']) && $_SESSION['droit'] == "admin") 
    || (isset($_SESSION['id']) && $_SESSION['id'] == $article["id_utilisateur"])) {
            include('bdd.php');

            $requete = $connexion->prepare(
                'SELECT * FROM article WHERE id = ?'
            );

            $requete->execute([
                $id
            ]);

            $article = $requete->fetch();

            if (isset($_POST['valider'])) {

                $nouveauNom = NULL;
                //si lutilisateur a selectionné une image
                if ($_FILES['image']['tmp_name'] != "") {
                    $nomTemporaire = $_FILES['image']['tmp_name'];
                    //oncré un nom unique à partir du titre de l'article
                    $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                    move_uploaded_file($nomTemporaire, "./assets/img/" . $nouveauNom);
                }
                if ($nouveauNom == null) {

                    $requete = $connexion->prepare(
                        'UPDATE article SET titre = ?, contenu = ? WHERE id = ?'
                    );

                    $requete->execute([
                        $_POST['titre'],
                        $_POST['contenu'],
                        $id
                    ]);
                } else {
                    $requete = $connexion->prepare(
                        'UPDATE article SET titre = ?, contenu = ?, nom_image = ? WHERE id = ?'
                    );

                    $requete->execute([
                        $_POST['titre'],
                        $_POST['contenu'],
                        $nouveauNom,
                        $id
                    ]);
                }
                header('location: ' . Conf::URL . 'article/afficher/' . $id);
            } else if (isset($_POST['suppression_image'])) {
                $connexion = new PDOperso();

                $requete = $connexion->prepare(
                    'UPDATE article SET   titre = ?, contenu = ?, nom_image = null WHERE id = ?'
                );

                $requete->execute([
                    $_POST['titre'],
                    $_POST['contenu'],
                    $id
                ]);

                header('location: ' . Conf::URL . 'article/edition/' . $id);
            }

            $parametres = compact('article');

            $this->afficherVue($parametres, 'edition');
        } else {
            header('Location: ' . Conf::URL);
        }
    }
    public function recherche($mot)
    {
        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication, nom_image, pseudo, admin
            FROM article 
            JOIN utilisateur ON utilisateur.id = article.id_utilisateur
            WHERE titre LIKE :recherche OR contenu LIKE :recherche OR pseudo LIKE :recherche"

        );

        $requete->execute([':recherche' => '%' . $mot . '%']);

        $listeArticle = $requete->fetchAll();

        $parametres = compact('listeArticle');

        $this->afficherVue($parametres, 'liste');
    }
}
