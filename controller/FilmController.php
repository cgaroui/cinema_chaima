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
        $requete_detFilm = $pdo->prepare("SELECT affiche,
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


    public function ajoutFilm() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Récupérer et nettoyer les données du formulaire
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $annee_sortie = filter_input(INPUT_POST, 'annee_sortie', FILTER_VALIDATE_INT);
            $duree = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT);
            $note = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_FLOAT);
            $id_realisateur = filter_input(INPUT_POST, 'id_realisateur', FILTER_VALIDATE_INT);
    
            // pour s'assurer que les champs requis ne sont pas vides
            if ($titre && $annee_sortie && $duree && $note !== false && $id_realisateur) {
                $pdo = Connect::seConnecter();
    
                // Préparer la requête SQL pour insérer un nouveau film
                $requete_ajoutFilm = $pdo->prepare("INSERT INTO film (titre, annee_sortie, duree, note, id_realisateur) 
                                                   VALUES (:titre, :annee_sortie, :duree, :note, :id_realisateur)");
    
                // Exécuter la requête avec les valeurs extraites du formulaire
                $requete_ajoutFilm->execute([
                    'titre' => $titre,
                    'annee_sortie' => $annee_sortie,
                    'duree' => $duree,
                    'note' => $note,
                    'id_realisateur' => $id_realisateur,
                ]);
    
                echo "Le film '$titre' a été ajouté avec succès.";
            } else {
                echo "Veuillez remplir tous les champs requis.";
            }
        }
    
        // Afficher le formulaire d'ajout
        require "view/ajouts/ajoutFilm.php";
    }

    public function supprimerFilm() {
        // Vérifiez si le formulaire a été soumis et l'ID du film est fourni
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer l'ID du film à supprimer
            $idFilm = filter_input(INPUT_POST, 'id_film', FILTER_VALIDATE_INT);
            
        
            if ($idFilm) {
                $pdo = Connect::seConnecter();
        
                // Supprimer les enregistrements du casting liés au film
                $requete_supprimerCasting = $pdo->prepare("DELETE FROM casting WHERE id_film = :id_film");
                $requete_supprimerCasting->execute(['id_film' => $idFilm]);
        
                // Supprimer les relations du film  avec le genre via posséder
                $requete_supprimerGenre = $pdo->prepare("DELETE FROM posseder WHERE id_film = :id_film");
                $requete_supprimerGenre->execute(['id_film' => $idFilm]);
        
                // Supprimer le film de la table des films
                $requete_supprimerFilm = $pdo->prepare("DELETE FROM film WHERE id_film = :id_film");
                $requete_supprimerFilm->execute(['id_film' => $idFilm]);
        
                // Redirection avec message de confirmation
                header("Location: index.php?action=listFilms&message=Film supprimé avec succès");
                exit(); // Arrêter le script après la redirection
            } else {
                // Redirection avec message d'erreur
                header("Location: index.php?action=listFilms&message=Erreur lors de la suppression");
                exit(); // Arrêter le script après la redirection
            }
        }
        
       
        require "view/listFilms.php";
    }
}


