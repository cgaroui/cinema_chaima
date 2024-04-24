<?php

namespace controller ;
use model\Connect;

class GenreController{

    public function listGenres(){
        $pdo = Connect::seConnecter();
        $requete_genres = $pdo->query(
        "SELECT nom_genre, COUNT(id_genre) AS 'nombre de films'
        FROM genre
        GROUP BY nom_genre");

        require "view/listGenres.php";
            
    }

    public function detailGenre($id) {
        $pdo = connect::seConnecter();
        $requete_detGenre = $pdo->prepare("SELECT genre.nom_genre,
            titre, annee_sortie, 
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree ,
            note 
            FROM film 
            INNER JOIN posseder ON posseder.id_film = film.id_film
            INNER JOIN genre ON genre.id_genre = posseder.id_genre
            WHERE genre.id_genre = :id");
        $requete_detGenre->execute(["id"=>$id]);
        require "view/detailGenre.php";
    }

}