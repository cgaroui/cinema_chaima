--Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
--la fonction concat: concatener plusieurs valeurs=> ici pour afficher EXEMPLE  "2h 30min"
-- fonction Floor: calcul l'arrondi a l'entier inferieur=> ici le nb dheure ex 125min = 2H (elle fait division /60 )
SELECT id_film, titre, annee_sortie, CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min')AS duree_en_heure, id_realisateur 
FROM film ; 


--Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)
SELECT id_film, titre , CONCAT(FLOOR(duree / 60),'h',duree % 60,' min') AS duree_en_heure
FROM film 
WHERE duree>135
ORDER BY duree DESC;

--Liste des films d’un réalisateur (en précisant l’année de sortie
SELECT film.titre AS Titre_du_film, film.annee_sortie ,personne.nom AS nom_realisateur,personne.prenom AS prenom_realisateur
FROM film
INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
INNER JOIN personne ON realisateur.id_personne = personne.id_personne
WHERE personne.id_personne = 2;


--Nombre de films par genre (classés dans l’ordre décroissant)
