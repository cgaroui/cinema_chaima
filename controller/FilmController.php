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
            titre,  // Titre du film
            annee_sortie,  // Année de sortie du film
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree,  // Durée formatée (heures et minutes)
            note,  // Note du film
            CONCAT(personne.nom, ' ', personne.prenom) AS realisateur,  // Nom complet du réalisateur
            realisateur.id_realisateur  // ID du réalisateur
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur  // Jointure avec la table des réalisateurs
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne  // Jointure avec la table des personnes pour obtenir le nom du réalisateur
            WHERE id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film
        $requete_detFilm->execute(["id" => $id]);

        // Requête pour obtenir le casting du film
        $requete_castingFilm = $pdo->prepare("SELECT 
            casting.id_film,  // ID du film
            acteur.id_acteur,  // ID de l'acteur
            film.titre AS 'Titre du film',  // Titre du film
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur,  // Nom complet de l'acteur
            role.nom_personnage AS 'role dans le film'  // Nom du personnage joué par l'acteur
            FROM casting 
            INNER JOIN acteur ON acteur.id_acteur = casting.id_acteur  // Jointure avec la table des acteurs
            INNER JOIN personne ON acteur.id_personne = personne.id_personne  // Jointure avec la table des personnes
            INNER JOIN role ON role.id_role = casting.id_role  // Jointure avec la table des rôles
            INNER JOIN film ON film.id_film = casting.id_film  // Jointure avec la table des films
            WHERE film.id_film = :id");  // Filtrage par l'ID du film
        
        // Exécution de la requête avec l'ID du film
        $requete_castingFilm->execute(["id" => $id]);

        // Chargement de la vue pour afficher les détails du film
        require "view/detailFilm.php";
    }
}

