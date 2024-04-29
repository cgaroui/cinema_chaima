<?php

namespace Controller ;
use Model\Connect;

class RealisateurController{

    public function listRealisateurs(){
        $pdo = Connect::seConnecter();
        $requete_listRealisateurs = $pdo->query("SELECT id_realisateur, nom, prenom, sexe , date_naissance FROM realisateur inner join personne on realisateur.id_personne = personne.id_personne ;");

        require "view/listRealisateurs.php";
    }


    public function detailRealisateur($id){
        $pdo = Connect::seConnecter();

        $requete_realisateur= $pdo->prepare("SELECT 
            CONCAT(personne.nom, ' ', personne.prenom) AS Realisateur, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance,
            TIMESTAMPDIFF(YEAR, personne.date_naissance, CURDATE()) AS Age    
            FROM 
                realisateur 
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne
            WHERE realisateur.id_realisateur = :id");
        
        $requete_realisateur->execute(["id"=>$id]);

        $requete_realisateurFilms = $pdo->prepare("SELECT film.id_film,
            film.titre , film.annee_sortie
            FROM realisateur 
            INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur
            
            WHERE realisateur.id_realisateur= :id");

        $requete_realisateurFilms->execute(["id"=>$id]);

        require "view/detailRealisateur.php";
    }


}