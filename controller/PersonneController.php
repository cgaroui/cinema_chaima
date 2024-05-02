<?php
// Déclaration du namespace et des importations nécessaires
namespace Controller;
use Model\Connect;

// Classe principale qui gère les opérations liées aux personnes (acteurs, réalisateurs, etc.)
class PersonneController {
    
    // Méthode pour lister tous les acteurs
    public function listActeurs() {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();
        
        // Requête SQL pour récupérer les détails des acteurs en joignant avec la table des personnes
        $requete_acteurs = $pdo->query("SELECT 
            acteur.id_acteur,
            personne.nom, 
            personne.prenom, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance
            FROM acteur
            INNER JOIN personne ON acteur.id_personne = personne.id_personne");

        // Chargement de la vue pour afficher la liste des acteurs
        require "view/listActeurs.php";
    }

    // Méthode pour afficher le détail d'un acteur spécifique
    public function detailActeur($id) {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Requête SQL pour récupérer les détails d'un acteur par son ID
        $requete_detailActeur = $pdo->prepare("SELECT 
            acteur.id_acteur,
            CONCAT(personne.nom, ' ', personne.prenom) AS Acteur, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance,
            TIMESTAMPDIFF(YEAR, personne.date_naissance, CURDATE()) AS age 
            FROM acteur
            INNER JOIN personne ON personne.id_personne = acteur.id_personne
            WHERE acteur.id_acteur = :id");

        // Exécution de la requête avec l'ID de l'acteur
        $requete_detailActeur->execute(["id" => $id]);

        // Requête pour récupérer les films associés à cet acteur
        $requete_acteurFilms = $pdo->prepare("SELECT DISTINCT
            film.id_film,
            film.titre,
            film.annee_sortie,
            role.nom_personnage AS Role
            FROM film
            INNER JOIN casting ON film.id_film = film.id_film
            INNER JOIN role ON casting.id_role = role.id_role
            WHERE casting.id_acteur = :id");

        // Exécution de la requête pour récupérer les films de l'acteur
        $requete_acteurFilms->execute(["id" => $id]);

        // Chargement de la vue pour afficher le détail de l'acteur
        require "view/detailActeur.php";
    }


    // Méthode pour lister tous les réalisateurs
    public function listRealisateurs() {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Requête SQL pour récupérer les détails des réalisateurs avec jointure sur la table des personnes
        $requete_listRealisateurs = $pdo->query("SELECT id_realisateur, nom, prenom, sexe, date_naissance 
            FROM realisateur 
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne;");

        // Chargement de la vue pour afficher la liste des réalisateurs
        require "view/listRealisateurs.php";
    }

    // Méthode pour afficher le détail d'un réalisateur spécifique
    public function detailRealisateur($id) {
        // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Requête pour obtenir des détails sur le réalisateur
        $requete_realisateur = $pdo->prepare("SELECT 
            CONCAT(personne.nom, ' ', personne.prenom) AS Realisateur, 
            personne.sexe,
            DATE_FORMAT(personne.date_naissance, '%d-%m-%Y') AS date_naissance,
            TIMESTAMPDIFF(YEAR, personne.date_naissance, CURDATE()) AS Age    
            FROM realisateur 
            INNER JOIN personne ON personne.id_personne = realisateur.id_personne
            WHERE realisateur.id_realisateur = :id");
        
        // Exécution de la requête pour obtenir le détail du réalisateur
        $requete_realisateur->execute(["id" => $id]);

        // Requête pour obtenir les films réalisés par le réalisateur
        $requete_realisateurFilms = $pdo->prepare("SELECT 
            film.id_film,
            film.titre, 
            film.annee_sortie 
            FROM realisateur 
            INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur 
            WHERE realisateur.id_realisateur = :id");

        // Exécution de la requête pour obtenir les films du réalisateur
        $requete_realisateurFilms->execute(["id" => $id]);

        // Chargement de la vue pour afficher le détail du réalisateur
        require "view/detailRealisateur.php";
    }



    // Méthode pour ajouter une nouvelle personne
    public function ajoutPersonne() {
        // Vérification si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // Récupération et nettoyage des données du formulaire
            $nomPersonne = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenomPersonne = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $professions = $_POST['profession'] ?? []; // Récupérer les professions sélectionnées

            // Connexion à la base de données
        $pdo = Connect::seConnecter();

        // Insérer les données de la personne
        $requete_ajoutPersonne = $pdo->prepare("
            INSERT INTO personne (nom, prenom, sexe, date_naissance)
            VALUES (:nom, :prenom, :sexe, :date_naissance)
        ");
        $requete_ajoutPersonne->execute([
            'nom' => $nomPersonne,
            'prenom' => $prenomPersonne,
            'sexe' => $sexe,
            'date_naissance' => $dateNaissance
        ]);

        // Obtenir le dernier ID inséré
        $idPersonne = $pdo->lastInsertId();

        // Vérifiez les professions sélectionnées et ajoutez-les
        foreach ($professions as $profession) {
            if ($profession === 'acteur') {
                $requete_ajoutActeur = $pdo->prepare("INSERT INTO acteur (id_personne) VALUES (:id_personne)");
                $requete_ajoutActeur->execute(['id_personne' => $idPersonne]);
            } elseif ($profession === 'realisateur') {
                $requete_ajoutRealisateur = $pdo->prepare("INSERT INTO realisateur (id_personne) VALUES (:id_personne)");
                $requete_ajoutRealisateur->execute(['id_personne' => $idPersonne]);
            }
        }
            // Message de succès pour l'ajout
            echo "La personne a été ajoutée avec succès.";
        }

        // Chargement de la vue pour ajouter une nouvelle personne
        require "view/ajouts/ajoutPersonne.php";
    }
}
