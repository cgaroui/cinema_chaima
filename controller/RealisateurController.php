<?php

namespace Controller ;
use Model\Connect;

class RealisateurController{


    public function detailRealisateur($id){
        $pdo = Connect::seConnecter();
        
        $requete_realisateur= $pdo->prepare("SELECT 
            CONCAT(personne.nom, ' ', personne.prenom) AS Realisateur, 
            personne.sexe,
            personne.date_naissance,
            TIMESTAMPDIFF(YEAR, personne.date_naissance, CURDATE()) AS Age    
            FROM 
                realisateur 
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne
            WHERE realisateur.id_realisateur = :id");
        
        $requete_realisateur->execute(["id"=>$id]);

        $requete_realisateurFilms = $pdo->prepare("SELECT 
            film.titre , film.annee_sortie
            FROM realisateur 
            INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur
            
            WHERE realisateur.id_realisateur= :id");

        $requete_realisateurFilms->execute(["id"=>$id]);

        require "view/detailRealisateur.php";
    }


}