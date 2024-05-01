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
            id_acteur,  // ID de l'acteur
            film.titre AS 'Titre du film',  // Titre du film
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur,  // Nom complet de l'acteur
            role.nom_personnage AS 'role dans le film'  // Nom du personnage joué par l'acteur
            FROM casting 
            INNER JOIN acteur ON acteur.id_acteur = casting.id_acteur  // Jointure avec la table des acteurs
            INNER JOIN personne ON acteur.id_personne = personne.id_personne  // Jointure avec la table des personnes
            INNER JOIN role ON role.id_role = casting.id_role  // Jointure avec la table des rôles
            INNER JOIN film ON film.id_film = casting.id_film  // Jointure avec la table des films
            WHERE film.id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film comme paramètre
        $requete_castingFilm->execute(["id" => $id]);
        
        // Chargement de la vue pour afficher le casting du film
        require "view/castingFilm.php";
    }
}
