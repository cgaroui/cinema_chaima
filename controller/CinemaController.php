<?php

namespace controller ;
use model\Connect;

class CinemaController{
    //liste des films 

    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT titre,annee_sortie FROM film ");

        require "view/listFilms.php";
    }
}