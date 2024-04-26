<?php

namespace Controller ;
use Model\Connect;

class RoleController{
    
    public function castingFilm($id) {
        $pdo = Connect::seConnecter();
        $requete_castingFilm = $pdo->prepare("SELECT id_acteur,film.titre AS 'Titre du film', 
            concat(personne.nom,' ', personne.prenom) AS Acteur,
            role.nom_personnage AS 'role dans le film'
            FROM casting 
            INNER JOIN acteur on acteur.id_acteur = casting.id_acteur
            INNER JOIN personne ON acteur.id_personne = personne.id_personne
            INNER JOIN role ON role.id_role = casting.id_role
            INNER JOIN film ON film.id_film = casting.id_film
            WHERE film.id_film = :id");
        
        $requete_castingFilm->execute(["id"=>$id]);
        
        require "view/castingFilm.php";
    }
}