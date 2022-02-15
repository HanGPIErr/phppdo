<?php

class Personne {

    protected $prenom;
    protected $nom;

    function __construct($nom, $prenom)
    {
        $this->nom=$nom;
        $this->prenom=$prenom;
}

    function nomComplet()
    {
        echo "Je m'apelle ".$this->prenom. " ". $this->nom;
    }


    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }
}

?>