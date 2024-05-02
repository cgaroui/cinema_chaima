<?php
// Déclaration du namespace et des importations nécessaires
namespace Controller;
use Model\Connect;

// Définition de la classe pour gérer les rôles dans les films
class RoleController {
    
    // Méthode pour obtenir le casting d'un film donné
    public function castingFilm($id) {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();
        
        // Requête SQL pour obtenir les détails du casting d'un film spécifique
        $requete_castingFilm = $pdo->prepare("SELECT 
            id_acteur, 
            film.titre AS 'Titre du film',  
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur,  
            role.nom_personnage AS 'role dans le film'  
            FROM casting 
            INNER JOIN acteur ON acteur.id_acteur = casting.id_acteur  
            INNER JOIN personne ON acteur.id_personne = personne.id_personne 
            INNER JOIN role ON role.id_role = casting.id_role  
            INNER JOIN film ON film.id_film = casting.id_film  
            WHERE film.id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film comme paramètre
        $requete_castingFilm->execute(["id" => $id]);
        
        // Chargement de la vue pour afficher le casting du film
        require "view/detailFilm.php";


    }

    public function ajoutRole(){

        if (isset($_POST['submit'])) {
            // Récupération et nettoyage du nom du role à partir du formulaire
            $nomRole = filter_input(INPUT_POST, "nom_personnage", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si un nom de genre a été soumis
            if ($nomRole) {
            // Connexion à la base de données
            $pdo = Connect::seConnecter();


            $requete_ajoutRole = $pdo->prepare("INSERT INTO role(nom_personnage) VALUES (:nom_personnage)");

            $requete_ajoutRole->execute(['nom_Role' => $nomRole]);

            }
        }
        require "view/detailFilm.php";
    }

}
