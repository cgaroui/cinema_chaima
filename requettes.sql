--Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
--la fonction concat: concatener plusieurs valeurs=> ici pour afficher EXEMPLE  "2h 30min"
--a. fonction Floor: calcul l'arrondi a l'entier inferieur=> ici le nb dheure ex 125min = 2H (elle fait division /60 )
    SELECT id_film, titre, annee_sortie, CONCAT(FLOOR(duree / 60), 'h ', duree % 60, 'min') AS duree_en_heure, id_realisateur 
    FROM film ; 


--b.Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)
    SELECT id_film, titre , CONCAT(FLOOR(duree / 60),'h',duree % 60,' min') AS duree_en_heure
    FROM film 
    WHERE duree>135
    ORDER BY duree DESC;

--c.Liste des films d’un réalisateur (en précisant l’année de sortie
    SELECT film.titre AS Titre_du_film, film.annee_sortie ,personne.nom AS nom_realisateur,personne.prenom AS prenom_realisateur
    FROM film
    INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
    INNER JOIN personne ON realisateur.id_personne = personne.id_personne
    WHERE personne.id_personne = 2;


--d.Nombre de films par genre (classés dans l’ordre décroissant)
    SELECT genre.nom_genre, COUNT(*) AS nombre_de_films
    FROM posseder
    INNER JOIN genre ON genre.id_genre = posseder.id_genre
    GROUP BY posseder.id_genre
    ORDER BY posseder.id_genre DESC;

--e.Nombre de films par réalisateur (classés dans l’ordre décroissant)
    SELECT personne.nom, personne.prenom, COUNT(*) AS nombre_de_films
    FROM film
    INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
    INNER JOIN personne ON personne.id_personne = realisateur.id_personne
    GROUP BY film.id_realisateur
    ORDER BY film.id_realisateur DESC;

--f.Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe
    SELECT  personne.nom AS nom_acteur, personne.prenom AS prenom_acteur , personne.sexe
    FROM casting 
    INNER JOIN acteur ON casting.id_acteur = acteur.id_acteur
    INNER JOIN personne ON acteur.id_personne = personne.id_personne
    WHERE casting.id_film = 1;

--g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de 
--sortie (du film le plus récent au plus ancien)

    SELECT film.id_film , film.titre , film.annee_sortie , casting.id_role ,role.nom_personnage
    FROM casting 
    INNER JOIN acteur on acteur.id_acteur = casting.id_acteur
    INNER JOIN personne ON acteur.id_personne = personne.id_personne
    INNER JOIN film ON  film.id_film = casting.id_film
    INNER JOIN role ON role.id_role = casting.id_role
    WHERE acteur.id_acteur =2
    ORDER BY annee_sortie DESC ;

--h.Liste des personnes qui sont à la fois acteurs et réalisateurs
    SELECT personne.id_personne, personne.nom,personne.prenom
    FROM personne 
    INNER JOIN acteur on acteur.id_personne = personne.id_personne
    INNER JOIN realisateur ON realisateur.id_personne = personne.id_personne
    WHERE realisateur.id_personne = acteur.id_personne;

--i.Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)

    SELECT film.id_film,film.titre, film.annee_sortie
    FROM film
    where film.annee_sortie >= YEAR("2024-04-22") - 5  -- Films sortis il ya 5 ans depuis la date dans YEAR("") 
    ORDER BY film.annee_sortie DESC ;


--j.Nombre d’hommes et de femmes parmi les acteurs
    SELECT 'Hommes' AS sexe,COUNT(*) AS total -- pour afficcher une colonne sexe avc une ligne hommes et une colonne total indiquant total hommes 
    FROM personne 
    WHERE personne.sexe LIKE 'm%'  
    UNION ALL --Elle permet de concaténer les enregistrements de plusieurs requêtes (ici mes 2 lignes hommes et femmes avc leur total)
    SELECT 'Femmes' AS sexe,COUNT(*) AS total -- pour afficcher une colonne sexe avc une ligne hommes et une colonne total indiquant total hommes 
    FROM personne 
    WHERE personne.sexe LIKE 'f%';  
    

--k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)
    SELECT personne.nom,  personne.prenom , 
    concat(floor(DATEDIFF('2024-04-22', personne.date_naissance)/ 365),' ans') AS age --DATEDIFF()=> calcul la difeence entre 2 dates ici je divise par 365 pour avoir la difference en année (l'age approximatif)
    FROM acteur
    INNER JOIN personne ON  personne.id_personne = acteur.id_personne
    WHERE DATEDIFF('2024-04-22', personne.date_naissance)/ 365>= 50;


 --l.Acteurs ayant joué dans 3 films ou plus
    SELECT personne.nom,  personne.prenom , COUNT(casting.id_film) AS nombre_films
    FROM casting 
    INNER JOIN acteur ON acteur.id_acteur = casting.id_acteur
    INNER JOIN personne ON personne.id_personne = acteur.id_personne
    GROUP BY  acteur.id_acteur,  personne.prenom ,personne.nom -- on regroupe par acteur ( ici les infos :id , nom et prenom d'un acteur)
    HAVING COUNT(casting.id_film) >=3; -- le having pour preciser la condition selon laquelle seront filtré les infos (ici c les acteurs ayant +de 3 films)