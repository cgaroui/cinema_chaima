<?php

namespace Controller ;
use Model\Connect;

class FilmController{
 

    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT id_film, titre,annee_sortie FROM film ");

        require "view/listFilms.php";
    }
    
    public function detailFilm($id) {
        
        $pdo = connect::seConnecter();
        $requete_detFilm = $pdo->prepare("SELECT titre , annee_sortie ,
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree ,
            note , CONCAT( personne.nom ,' ' ,personne.prenom) AS realisateur,
            realisateur.id_realisateur
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur= film.id_realisateur
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne
            WHERE id_film = :id");

        $requete_detFilm->execute(["id"=>$id]);


        $pdo = Connect::seConnecter();
        $requete_castingFilm = $pdo->prepare("SELECT casting.id_film,acteur.id_acteur, film.titre AS 'Titre du film', 
        concat(personne.nom,' ', personne.prenom) AS Acteur,
        role.nom_personnage AS 'role dans le film'
        FROM casting 
        INNER JOIN acteur on acteur.id_acteur = casting.id_acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        INNER JOIN role ON role.id_role = casting.id_role
        INNER JOIN film ON film.id_film = casting.id_film
        WHERE film.id_film = :id");
        
        $requete_castingFilm->execute(["id"=>$id]);
            
      require "view/detailFilm.php";

    }


}


