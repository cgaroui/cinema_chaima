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
}