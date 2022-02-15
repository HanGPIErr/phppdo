<?php

    namespace controleur;

use Conf;
use PDOperso;

class utilisateurControleur extends BaseControleur {

        public function liste() {
            $connexion = new \PDOperso();

            $requete = $connexion->prepare("SELECT * FROM utilisateur");
            $requete->execute();
            $listeUtilisateur = $requete->fetchAll();

            $parametres = compact('listeUtilisateur');
            $this->afficherVue($parametres);
        }
        public function connexion() {
            $erreurPseudo = false;
            //si lutilisateur valide la connexion
            if(isset($_POST['valider'])) {

                $connexion = new PDOperso();
                $requete = $connexion->prepare("SELECT * FROM utilisateur WHERE pseudo = ?");
                $requete->execute([
                    $_POST['pseudo']
                ]);
                // on récupere l'utilisateur ayant le pseudo saisi
                $utilisateur = $requete->fetch();

                //si lutilisateur exite bien
                if($utilisateur) {

                    //si lutilisateur a saisi un mdp compatible avec le mdp crypté
                    if(password_verify($_POST['mot_de_passe'], $utilisateur['mot_de_passe'])) {
                            $_SESSION['id'] = $utilisateur['id'];
                            $_SESSION['pseudo'] = $utilisateur['pseudo'];
                            $_SESSION['admin'] = $utilisateur['admin'];

                            header("Location: " . Conf::URL);
                            
                    }else{
                        $erreurPseudo = true;
                        //si lutilisateur à saisi un mauvais mot de passe = erreur
                    }
                    } else {
                        //si lutilisateur a saisi un mauvais pseudo = erreur
                        $erreurPseudo = true;
                    }
                }
            

            $parametres = compact('erreurPseudo');

            $this->afficherVue($parametres, 'connexion');
        }
        public function inscription() {


            $erreurLongueurPseudo = false;
            $erreurMotDePasseIdentique = false;

            if(isset($_POST['valider'])){

                if(strlen($_POST['pseudo']) < 5 ) {
                    $erreurLongueurPseudo = true;
                } else if ($_POST['mot_de_passe'] != $_POST['confirmer_mot_de_passe']) {
                    $erreurMotDePasseIdentique = true;
                } else {
                    $connexion = new PDOperso();
                    $requete = $connexion->prepare(
                        'INSERT INTO utilisateur (pseudo, mot_de_passe) VALUES (?,?)');

                        $requete->execute([
                            $_POST['pseudo'],
                            password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT)
                        ]);
                        header("Location: " . Conf::URL . "utilisateur/connexion");
                }

            }
            $parametres = compact('erreurLongueurPseudo', 'erreurMotDePasseIdentique');

            $this->afficherVue($parametres, 'inscription');
        }
        public function deconnexion(){
            session_destroy();
            header('Location: ' . Conf::URL);
        }
    }

?>