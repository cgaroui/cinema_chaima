<?php

namespace controller ;
use model\Connect;

class FilmController{
 

    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT titre,annee_sortie FROM film ");

        require "view/listFilms.php";
    }
    
    public function detailFilm($id) {
        
        $pdo = connect::seConnecter();
        $requete_detFilm = $pdo->prepare("SELECT titre , annee_sortie ,
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree ,
            note , CONCAT( personne.nom ,' ' ,personne.prenom) AS realisateur
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur= film.id_realisateur
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne
            WHERE id_film = :id");

        $requete_detFilm->execute(["id"=>$id]);
      require "view/detailFilm.php";

    }


}

