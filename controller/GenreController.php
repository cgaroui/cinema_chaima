<?php
// Déclaration du namespace et des importations nécessaires
namespace Controller;
use Model\Connect;

// Classe principale pour gérer les genres de films
class GenreController {

    // Méthode pour lister tous les genres de films
    public function listGenres() {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Requête SQL pour récupérer la liste des genres avec le nombre de films associés
        $requete_genres = $pdo->query("SELECT 
            id_genre,  
            nom_genre,  
            COUNT(id_genre) AS 'nombre de films'  
            FROM genre
            GROUP BY id_genre");  // Groupement par ID du genre

        // Chargement de la vue pour afficher la liste des genres
        require "view/listGenres.php";
    }

    // Méthode pour afficher le détail d'un genre spécifique
    public function detailGenre($id) {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Requête pour obtenir le nom du genre par son ID
        $requete_nom = $pdo->prepare("SELECT nom_genre 
            FROM genre
            WHERE genre.id_genre = :id");
        // Exécution de la requête avec l'ID du genre
        $requete_nom->execute(["id" => $id]);

        // Requête pour récupérer les détails des films associés à ce genre
        $requete_detGenre = $pdo->prepare("SELECT 
            genre.id_genre,  
            film.id_film, 
            genre.nom_genre,  
            titre, 
            annee_sortie, 
            CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree,
            note  
            FROM film 
            INNER JOIN posseder ON posseder.id_film = film.id_film  
            INNER JOIN genre ON genre.id_genre = posseder.id_genre  
            WHERE genre.id_genre = :id");
        
        // Exécution de la requête avec l'ID du genre
        $requete_detGenre->execute(["id" => $id]);

        // Chargement de la vue pour afficher les détails du genre
        require "view/detailGenre.php";
    }

    // Méthode pour ajouter un nouveau genre de film
    public function ajoutGenre() {
        // Vérification si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // Récupération et nettoyage du nom du genre à partir du formulaire
            $nomGenre = filter_input(INPUT_POST, "nom_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si un nom de genre a été soumis
            if ($nomGenre) {
                // Connexion à la base de données
                $pdo = Connect::seConnecter();
                
                // Préparation de la requête pour insérer le nouveau genre
                $requete_ajoutGenre = $pdo->prepare("INSERT INTO genre (nom_genre) VALUES (:nom_genre)");
                
                // Exécution de la requête avec le nom du genre
                $requete_ajoutGenre->execute(['nom_genre' => $nomGenre]);

                // Vous pourriez inclure un message de confirmation ici
            }

            // Chargement de la vue pour ajouter un genre
            require "view/ajouts/ajoutGenre.php";
        } else {
            // Si le formulaire n'a pas été soumis, simplement charger la vue
            require "view/ajouts/ajoutGenre.php";
        }
    }


    public function supprimerGenre() {
        // Vérifiez si le formulaire a été soumis et l'ID du genre est fourni
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idGenre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);

            if ($idGenre) {
                // Connexion à la base de données
                $pdo = Connect::seConnecter();

                // Supprimer les références dans les tables associées (si nécessaire)
                $requete_supprimerRelations = $pdo->prepare("DELETE FROM posseder WHERE id_genre = :id_genre");
                $requete_supprimerRelations->execute(['id_genre' => $idGenre]);

                // Supprimer le genre
                $requete_supprimerGenre = $pdo->prepare("DELETE FROM genre WHERE id_genre = :id_genre");
                $requete_supprimerGenre->execute(['id_genre' => $idGenre]);

                // Redirection avec message de confirmation
                header("Location: index.php?action=listGenres&message=Genre supprimé avec succès");
                exit();
            } else {
                // Redirection avec message d'erreur
                header("Location: index.php?action=listGenres&message=Erreur lors de la suppression");
                exit();
            }
        }
    }
}

    

