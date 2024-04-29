<?php

namespace Controller ;
use Model\Connect;

class ActeurController{
    
    
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete_acteurs = $pdo->query("SELECT 
            acteur.id_acteur,
            personne.nom, 
            personne.prenom, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance
            FROM acteur
            INNER JOIN personne ON acteur.id_personne = personne.id_personne ");

        require "view/listActeurs.php";
    }


    public function detailActeur($id){
        $pdo = Connect::seConnecter();
        $requete_detailActeur =$pdo->prepare("SELECT acteur.id_acteur,
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance,
            TIMESTAMPDIFF(YEAR, personne.date_naissance, CURDATE())  AS age 
            FROM acteur
            INNER JOIN personne ON personne.id_personne = acteur.id_personne
            WHERE acteur.id_acteur = :id");

        $requete_detailActeur->execute(["id"=>$id]);

        $requete_acteurFilms = $pdo->prepare("SELECT DISTINCT
            film.id_film,
            film.titre ,
            film.annee_sortie,
            role.nom_personnage AS Role
            FROM film
            INNER JOIN casting ON film.id_film = film.id_film
            INNER JOIN role ON casting.id_role = role.id_role
            WHERE  casting.id_acteur = :id");

        $requete_acteurFilms->execute(["id"=>$id]);

        require "view/detailActeur.php";
    }

}