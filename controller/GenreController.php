<?php

namespace Controller ;
use Model\Connect;

class GenreController{

    public function listGenres(){
        $pdo = Connect::seConnecter();
        $requete_genres = $pdo->query(
        "SELECT id_genre, nom_genre, COUNT(id_genre) AS 'nombre de films'
        FROM genre
        GROUP BY id_genre");

        require "view/listGenres.php";
            
    }

    public function detailGenre($id) {
        $pdo = connect::seConnecter();
        $requete_nom = $pdo -> prepare("SELECT nom_genre 
        FROM genre
        WHERE genre.id_genre = :id");
        $requete_nom -> execute(["id"=>$id]);

        $requete_detGenre = $pdo->prepare("SELECT genre.id_genre, film.id_film, genre.nom_genre,
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