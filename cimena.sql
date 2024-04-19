-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema_chaima
CREATE DATABASE IF NOT EXISTS `cinema_chaima` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema_chaima`;

-- Listage de la structure de table cinema_chaima. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  KEY `FK_acteur_personne` (`id_personne`),
  CONSTRAINT `FK_acteur_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.acteur : ~8 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(1, 1),
	(2, 3),
	(3, 4),
	(4, 6),
	(5, 7),
	(6, 8),
	(7, 9),
	(8, 10);

-- Listage de la structure de table cinema_chaima. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  KEY `FK_jouer_film` (`id_film`),
  KEY `FK_jouer_acteur` (`id_acteur`),
  KEY `FK_jouer_role` (`id_role`),
  CONSTRAINT `FK_jouer_acteur` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `FK_jouer_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_jouer_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.casting : ~10 rows (environ)
INSERT INTO `casting` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 4, 1),
	(1, 6, 2),
	(2, 2, 4),
	(2, 7, 3),
	(3, 2, 5),
	(4, 2, 5),
	(5, 4, 6),
	(5, 5, 7),
	(6, 3, 8),
	(7, 3, 9);

-- Listage de la structure de table cinema_chaima. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `annee_sortie` smallint NOT NULL,
  `duree` smallint NOT NULL,
  `synopsis` longtext,
  `note` float DEFAULT NULL,
  `affiche` varchar(50) DEFAULT NULL,
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `FK_film_realisateur` (`id_realisateur`),
  CONSTRAINT `FK_film_realisateur` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.film : ~7 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `annee_sortie`, `duree`, `synopsis`, `note`, `affiche`, `id_realisateur`) VALUES
	(1, 'Once Upon a Time... in Hollywood', 2019, 201, NULL, 5, NULL, 2),
	(2, 'Pulp Fiction', 1994, 154, NULL, 4, NULL, 2),
	(3, 'Kill Bill - Volume 1', 2003, 111, NULL, 3, NULL, 2),
	(4, 'Kill Bill - Volume 2', 2004, 137, NULL, 3, NULL, 2),
	(5, 'Arrête-moi si tu peux', 2002, 141, NULL, 3, NULL, 1),
	(6, 'Indiana Jones et la Dernière Croisade', 1989, 127, NULL, 3, NULL, 1),
	(7, 'La Guerre des étoiles', 1977, 121, NULL, 3, NULL, 3);

-- Listage de la structure de table cinema_chaima. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom_genre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.genre : ~8 rows (environ)
INSERT INTO `genre` (`id_genre`, `nom_genre`) VALUES
	(1, 'Drame'),
	(2, 'Comédie'),
	(3, 'Gangster'),
	(4, 'Arts martiaux'),
	(5, 'Action'),
	(6, 'Thriller'),
	(7, 'Aventure'),
	(8, 'Science-fiction');

-- Listage de la structure de table cinema_chaima. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `date_naissance` date NOT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.personne : ~11 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`) VALUES
	(1, 'Spielberg', 'Steven', 'masculin', '1946-12-18'),
	(2, 'Tarantino', 'Quentin', 'masculin', '1963-03-27'),
	(3, 'Thurman', 'Uma', 'feminin', '1970-04-29'),
	(4, 'Ford', 'Harrison', 'masculin', '1942-07-13'),
	(5, 'Lucas', 'George', 'masculin', '1944-05-14'),
	(6, 'DiCaprio', 'Leonardo', 'masculin', '1974-11-11'),
	(7, 'Hanks', 'Tom', 'masculin', '1956-07-09'),
	(8, 'Pitt', 'Brad', 'masculin', '1963-12-18'),
	(9, 'Travolta', 'John', 'masculin', '1954-02-18'),
	(10, 'Willis', 'Bruce', 'masculin', '1955-03-19'),
	(11, 'CAMERON', 'James', 'Masculin', '1971-01-01');

-- Listage de la structure de table cinema_chaima. posseder
CREATE TABLE IF NOT EXISTS `posseder` (
  `id_genre` int NOT NULL,
  `id_film` int NOT NULL,
  KEY `FK_associer_genre_film` (`id_film`),
  KEY `FK_associer_genre_genre` (`id_genre`),
  CONSTRAINT `FK_associer_genre_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_associer_genre_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.posseder : ~15 rows (environ)
INSERT INTO `posseder` (`id_genre`, `id_film`) VALUES
	(1, 1),
	(1, 5),
	(2, 1),
	(2, 2),
	(3, 2),
	(4, 3),
	(4, 4),
	(5, 3),
	(5, 4),
	(5, 6),
	(5, 7),
	(6, 5),
	(7, 6),
	(7, 7),
	(8, 7);

-- Listage de la structure de table cinema_chaima. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  KEY `FK__personne` (`id_personne`),
  CONSTRAINT `FK__personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.realisateur : ~5 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 2),
	(3, 5),
	(4, 7),
	(5, 11);

-- Listage de la structure de table cinema_chaima. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_personnage` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema_chaima.role : ~10 rows (environ)
INSERT INTO `role` (`id_role`, `nom_personnage`) VALUES
	(1, 'Rick Dalton'),
	(2, 'Cliff Booth'),
	(3, 'Vincent Vega'),
	(4, 'Mia Wallace'),
	(5, 'Beatrix Kiddo'),
	(6, 'Frank Abagnale Jr.'),
	(7, 'Carl Hanratty'),
	(8, 'Indiana Jones'),
	(9, 'Han Solo'),
	(11, 'Batman');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
