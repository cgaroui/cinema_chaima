<?php
// Déclaration du namespace et des importations nécessaires
namespace Controller;
use Model\Connect;

// Classe principale pour gérer les films
class FilmController {

    // Méthode pour lister tous les films
    public function listFilms() {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();
        
        // Requête SQL pour obtenir la liste des films avec leur titre et année de sortie
        $requete = $pdo->query("SELECT id_film, titre, annee_sortie FROM film");

        // Chargement de la vue pour afficher la liste des films
        require "view/listFilms.php";
    }
    
    // Méthode pour afficher les détails d'un film spécifique
    public function detailFilm($id) {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();
        
        // Requête pour obtenir les détails d'un film spécifique, y compris le titre, l'année de sortie, la durée, la note, le réalisateur et le casting
        $requete_detFilm = $pdo->prepare("SELECT 
            titre,  
            annee_sortie,  
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree, 
            note, 
            CONCAT(personne.nom, ' ', personne.prenom) AS realisateur, 
            realisateur.id_realisateur  
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur  
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne  
            WHERE id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film
        $requete_detFilm->execute(["id" => $id]);

        // Requête pour obtenir le casting du film
        $requete_castingFilm = $pdo->prepare("SELECT 
            casting.id_film,  
            acteur.id_acteur,  
            film.titre AS 'Titre du film', 
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur,  
            role.nom_personnage AS 'role dans le film'  
            FROM casting 
            INNER JOIN acteur ON acteur.id_acteur = casting.id_acteur  
            INNER JOIN personne ON acteur.id_personne = personne.id_personne  
            INNER JOIN role ON role.id_role = casting.id_role  
            INNER JOIN film ON film.id_film = casting.id_film  
            WHERE film.id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film
        $requete_castingFilm->execute(["id" => $id]);

        // Chargement de la vue pour afficher les détails du film
        require "view/detailFilm.php";
    }
}

