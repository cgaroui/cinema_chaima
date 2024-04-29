<?php

namespace Controller ;
use Model\Connect;

class PersonneController{
    
    
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


    public function ajoutPersonne(){

        if(isset($_post['submit'])){

            $nomPersonne = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenomPersonne = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $pdo = Connect::seConnecter();

            $requete_ajoutPersonne = $pdo->prepare("INSERT INTO personne (nom, prenom, sexe, date_naissance)
            VALUES (:nom, :prenom, :sexe, :date_naissance)");
            $requete_ajoutPersonne->execute([
                'nom' => $nomPersonne,
                'prenom' => $prenomPersonne,
                'sexe' => $sexe,
                'date_naissance' => $dateNaissance
            ]);
            echo "La personne a été ajoutée avec succès.";
        } else {

          
        }   
        
    require "view/ajouts/ajoutPersonne.php";

    }



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