<?php

namespace controller ;
use model\Connect;

class ActeurController{
    //liste des films 
    
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete_acteurs = $pdo->query("SELECT nom, prenom, sexe , date_naissance FROM acteur inner join personne on acteur.id_personne = personne.id_personne ;");

        require "view/listActeurs.php";
    }

}