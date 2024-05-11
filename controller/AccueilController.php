<?php
// Déclaration du namespace et des importations nécessaires
namespace Controller;
use Model\Connect;

class AccueilController{


    public function listNouveaute(){
        $pdo = Connect::seConnecter();

        $requete_nouveaute = $pdo->query("SELECT affiche,
            id_film,
            annee_sortie,
            titre,
            duree
            FROM film 
            ORDER BY annee_sortie DESC
            LIMIT 3");

        
    require "view/accueil.php";
    }
    

}